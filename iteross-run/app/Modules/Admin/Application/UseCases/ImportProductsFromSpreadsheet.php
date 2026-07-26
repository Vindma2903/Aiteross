<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use SimpleXMLElement;
use ZipArchive;

class ImportProductsFromSpreadsheet
{
    /**
     * @return array{created:int,updated:int,skipped:int}
     */
    public function handle(UploadedFile $file): array
    {
        $rows = $this->readRows($file);

        if ($rows === []) {
            throw new RuntimeException('Р¤Р°Р№Р» РїСѓСЃС‚РѕР№. Р”РѕР±Р°РІСЊС‚Рµ С…РѕС‚СЏ Р±С‹ РѕРґРЅСѓ СЃС‚СЂРѕРєСѓ СЃ С‚РѕРІР°СЂРѕРј.');
        }

        $headers = $this->normalizeHeaders(array_shift($rows));

        if (! in_array('name', $headers, true) || ! in_array('sku', $headers, true)) {
            throw new RuntimeException('Р’ С„Р°Р№Р»Рµ РґРѕР»Р¶РЅС‹ Р±С‹С‚СЊ РєРѕР»РѕРЅРєРё "РќР°Р·РІР°РЅРёРµ" Рё "РђСЂС‚РёРєСѓР»".');
        }

        $counts = [
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
        ];

        DB::transaction(function () use ($rows, $headers, &$counts): void {
            foreach ($rows as $row) {
                $mapped = $this->mapRow($headers, $row);

                if ($this->rowIsEmpty($mapped)) {
                    $counts['skipped']++;
                    continue;
                }

                $name = $this->stringValue($mapped['name'] ?? null);
                $sku = $this->stringValue($mapped['sku'] ?? null);

                if ($name === '' || $sku === '') {
                    $counts['skipped']++;
                    continue;
                }

                $categoryId = $this->resolveCategoryId($mapped['category'] ?? null);
                $isVisible = $this->parseBoolean($mapped['is_visible'] ?? null, true);
                $price = $this->parseInteger($mapped['price'] ?? null);
                $stockQuantity = $this->parseInteger($mapped['stock_quantity'] ?? null);
                $unitMode = $this->parseUnitMode($mapped['unit_mode'] ?? $mapped['unit'] ?? null);
                $unitMultiplier = $this->parseInteger($mapped['unit_multiplier'] ?? $mapped['multiplier'] ?? null);
                $description = $this->nullableString($mapped['description'] ?? null);
                $image = $this->normalizeImageValue($mapped['image'] ?? null);

                $payload = [
                    'name' => $name,
                    'slug' => Str::slug($name.'-'.$sku),
                    'sku' => $sku,
                    'description' => $description,
                    'price' => $price,
                    'stock_quantity' => $stockQuantity,
                    'unit_mode' => $unitMode,
                    'unit_multiplier' => $unitMode === Product::UNIT_MODE_PACKS ? max(1, $unitMultiplier) : 1,
                    'is_visible' => $isVisible,
                    'image' => $image,
                    'category_id' => $categoryId,
                ];

                $product = Product::query()->where('sku', $sku)->first();

                if ($product) {
                    $product->update($payload);
                    $counts['updated']++;
                    continue;
                }

                Product::query()->create($payload);
                $counts['created']++;
            }
        });

        if (($counts['created'] + $counts['updated']) === 0) {
            throw new RuntimeException('Р’ С„Р°Р№Р»Рµ РЅРµ РЅР°Р№РґРµРЅРѕ РЅРё РѕРґРЅРѕР№ РєРѕСЂСЂРµРєС‚РЅРѕР№ СЃС‚СЂРѕРєРё РґР»СЏ РёРјРїРѕСЂС‚Р°.');
        }

        return $counts;
    }

    /**
     * @return list<list<string>>
     */
    private function readRows(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());

        return match ($extension) {
            'xlsx' => $this->readXlsxRows($file),
            'csv', 'txt' => $this->readCsvRows($file),
            default => throw new RuntimeException('РќРµРїРѕРґРґРµСЂР¶РёРІР°РµРјС‹Р№ С„РѕСЂРјР°С‚ С„Р°Р№Р»Р°.'),
        };
    }

    /**
     * @return list<list<string>>
     */
    private function readCsvRows(UploadedFile $file): array
    {
        $path = $file->getRealPath();
        if (! $path || ! is_file($path)) {
            throw new RuntimeException('РќРµ СѓРґР°Р»РѕСЃСЊ РїСЂРѕС‡РёС‚Р°С‚СЊ CSV-С„Р°Р№Р».');
        }

        $handle = fopen($path, 'rb');
        if ($handle === false) {
            throw new RuntimeException('РќРµ СѓРґР°Р»РѕСЃСЊ РѕС‚РєСЂС‹С‚СЊ CSV-С„Р°Р№Р».');
        }

        $firstLine = fgets($handle) ?: '';
        rewind($handle);

        $delimiter = $this->detectDelimiter($firstLine);
        $rows = [];

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rows[] = array_map(fn ($value): string => trim((string) $value), $row);
        }

        fclose($handle);

        return $rows;
    }

    /**
     * @return list<list<string>>
     */
    private function readXlsxRows(UploadedFile $file): array
    {
        $path = $file->getRealPath();
        if (! $path || ! is_file($path)) {
            throw new RuntimeException('РќРµ СѓРґР°Р»РѕСЃСЊ РїСЂРѕС‡РёС‚Р°С‚СЊ Excel-С„Р°Р№Р».');
        }

        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            throw new RuntimeException('РќРµ СѓРґР°Р»РѕСЃСЊ РѕС‚РєСЂС‹С‚СЊ Excel-С„Р°Р№Р».');
        }

        $sharedStrings = $this->readSharedStrings($zip);
        $worksheetPath = $this->resolveFirstWorksheetPath($zip);
        $worksheetXml = $zip->getFromName($worksheetPath);

        if ($worksheetXml === false) {
            $zip->close();
            throw new RuntimeException('РќРµ СѓРґР°Р»РѕСЃСЊ РїСЂРѕС‡РёС‚Р°С‚СЊ РїРµСЂРІС‹Р№ Р»РёСЃС‚ Excel-С„Р°Р№Р»Р°.');
        }

        $worksheet = simplexml_load_string($worksheetXml);
        if (! $worksheet instanceof SimpleXMLElement) {
            $zip->close();
            throw new RuntimeException('РџРѕРІСЂРµР¶РґС‘РЅ Р»РёСЃС‚ Excel-С„Р°Р№Р»Р°.');
        }

        $namespaces = $worksheet->getNamespaces(true);
        $mainNs = $namespaces[''] ?? null;
        if ($mainNs) {
            $worksheet->registerXPathNamespace('x', $mainNs);
        }

        $rowNodes = $worksheet->xpath($mainNs ? '//x:sheetData/x:row' : '//sheetData/row') ?: [];
        $rows = [];

        foreach ($rowNodes as $rowNode) {
            $cells = [];
            $cellNodes = $rowNode->xpath($mainNs ? 'x:c' : 'c') ?: [];

            foreach ($cellNodes as $cell) {
                $reference = (string) ($cell['r'] ?? '');
                $columnIndex = $this->columnLettersToIndex(preg_replace('/\d+/', '', $reference));
                $cells[$columnIndex] = $this->extractCellValue($cell, $sharedStrings, $mainNs);
            }

            if ($cells === []) {
                $rows[] = [];
                continue;
            }

            ksort($cells);
            $maxIndex = (int) max(array_keys($cells));
            $row = [];

            for ($i = 0; $i <= $maxIndex; $i++) {
                $row[] = trim((string) ($cells[$i] ?? ''));
            }

            $rows[] = $row;
        }

        $zip->close();

        return $rows;
    }

    /**
     * @return list<string>
     */
    private function readSharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');
        if ($xml === false) {
            return [];
        }

        $sharedStrings = simplexml_load_string($xml);
        if (! $sharedStrings instanceof SimpleXMLElement) {
            return [];
        }

        $namespaces = $sharedStrings->getNamespaces(true);
        $mainNs = $namespaces[''] ?? null;
        if ($mainNs) {
            $sharedStrings->registerXPathNamespace('x', $mainNs);
        }

        $items = $sharedStrings->xpath($mainNs ? '//x:si' : '//si') ?: [];
        $strings = [];

        foreach ($items as $item) {
            $parts = $item->xpath($mainNs ? './/x:t' : './/t') ?: [];
            $strings[] = trim(implode('', array_map(fn ($part): string => (string) $part, $parts)));
        }

        return $strings;
    }

    private function resolveFirstWorksheetPath(ZipArchive $zip): string
    {
        $workbookXml = $zip->getFromName('xl/workbook.xml');
        $relsXml = $zip->getFromName('xl/_rels/workbook.xml.rels');

        if ($workbookXml === false || $relsXml === false) {
            return 'xl/worksheets/sheet1.xml';
        }

        $workbook = simplexml_load_string($workbookXml);
        $relationships = simplexml_load_string($relsXml);

        if (! $workbook instanceof SimpleXMLElement || ! $relationships instanceof SimpleXMLElement) {
            return 'xl/worksheets/sheet1.xml';
        }

        $workbookNamespaces = $workbook->getNamespaces(true);
        $mainNs = $workbookNamespaces[''] ?? null;
        $relNs = $workbookNamespaces['r'] ?? null;

        if ($mainNs) {
            $workbook->registerXPathNamespace('x', $mainNs);
        }
        if ($relNs) {
            $workbook->registerXPathNamespace('r', $relNs);
        }

        $sheet = ($workbook->xpath($mainNs ? '//x:sheets/x:sheet[1]' : '//sheets/sheet[1]') ?: [])[0] ?? null;
        $relationshipId = $sheet ? (string) $sheet->attributes($relNs, true)?->id : '';

        if ($relationshipId === '') {
            return 'xl/worksheets/sheet1.xml';
        }

        $relationshipNamespaces = $relationships->getNamespaces(true);
        $relationshipNs = $relationshipNamespaces[''] ?? null;
        if ($relationshipNs) {
            $relationships->registerXPathNamespace('r', $relationshipNs);
        }

        $relation = ($relationships->xpath($relationshipNs ? "//r:Relationship[@Id='{$relationshipId}']" : "//Relationship[@Id='{$relationshipId}']") ?: [])[0] ?? null;
        $target = $relation ? (string) ($relation['Target'] ?? '') : '';

        if ($target === '') {
            return 'xl/worksheets/sheet1.xml';
        }

        return str_starts_with($target, 'xl/') ? $target : 'xl/'.$target;
    }

    private function extractCellValue(SimpleXMLElement $cell, array $sharedStrings, ?string $mainNs): string
    {
        $type = (string) ($cell['t'] ?? '');
        $valueNode = ($cell->xpath($mainNs ? 'x:v' : 'v') ?: [])[0] ?? null;
        $inlineNode = ($cell->xpath($mainNs ? 'x:is/x:t' : 'is/t') ?: [])[0] ?? null;

        return match ($type) {
            's' => $sharedStrings[(int) ($valueNode ? (string) $valueNode : 0)] ?? '',
            'inlineStr' => (string) $inlineNode,
            'b' => ((string) $valueNode) === '1' ? '1' : '0',
            default => (string) ($valueNode ?? ''),
        };
    }

    private function detectDelimiter(string $line): string
    {
        $delimiters = [';' => substr_count($line, ';'), ',' => substr_count($line, ','), "\t" => substr_count($line, "\t")];
        arsort($delimiters);

        $delimiter = array_key_first($delimiters);

        return $delimiter ?: ';';
    }

    /**
     * @param list<string> $headers
     * @param list<string> $row
     * @return array<string, string>
     */
    private function mapRow(array $headers, array $row): array
    {
        $mapped = [];

        foreach ($headers as $index => $header) {
            if ($header === '') {
                continue;
            }

            $mapped[$header] = trim((string) ($row[$index] ?? ''));
        }

        return $mapped;
    }

    private function rowIsEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    /**
     * @param list<string> $headers
     * @return list<string>
     */
    private function normalizeHeaders(array $headers): array
    {
        return array_map(function ($header): string {
            $normalized = Str::of((string) $header)
                ->trim()
                ->lower()
                ->replace(['С‘'], 'Рµ')
                ->replace(['"', "'", '`'], '')
                ->replace(['-', ' '], '_')
                ->replace(['/', '\\'], '_')
                ->replace(['__'], '_')
                ->toString();

            return match ($normalized) {
                'РЅР°Р·РІР°РЅРёРµ', 'name', 'product_name', 'С‚РѕРІР°СЂ' => 'name',
                'Р°СЂС‚РёРєСѓР»', 'sku', 'РєРѕРґ', 'article' => 'sku',
                'РѕРїРёСЃР°РЅРёРµ', 'description', 'desc' => 'description',
                'С†РµРЅР°', 'price', 'СЃС‚РѕРёРјРѕСЃС‚СЊ' => 'price',
                'РѕСЃС‚Р°С‚РѕРє', 'stock', 'stock_quantity', 'РєРѕР»РёС‡РµСЃС‚РІРѕ' => 'stock_quantity',
                'РІРёРґРёРјРѕСЃС‚СЊ', 'is_visible', 'visible', 'РїРѕРєР°Р·С‹РІР°С‚СЊ' => 'is_visible',
                'РµРґРёРЅРёС†Р°', 'unit', 'unit_mode', 'С‚РёРї_РµРґРёРЅРёС†С‹' => 'unit_mode',
                'РјРЅРѕР¶РёС‚РµР»СЊ', 'unit_multiplier', 'multiplier', 'РІ_СѓРїР°РєРѕРІРєРµ' => 'unit_multiplier',
                'РєР°С‚РµРіРѕСЂРёСЏ', 'category', 'category_name' => 'category',
                'РёР·РѕР±СЂР°Р¶РµРЅРёРµ', 'image', 'image_url', 'С„РѕС‚Рѕ', 'photo' => 'image',
                default => $normalized,
            };
        }, $headers);
    }

    private function resolveCategoryId(mixed $rawValue): ?int
    {
        $categoryName = $this->nullableString($rawValue);

        if ($categoryName === null) {
            return null;
        }

        $slug = Str::slug($categoryName);

        $category = Category::query()
            ->where('slug', $slug)
            ->orWhereRaw('lower(name) = ?', [mb_strtolower($categoryName)])
            ->first();

        if ($category) {
            return $category->id;
        }

        $maxSort = (int) Category::query()->max('sort_order');

        return Category::query()->create([
            'name' => $categoryName,
            'slug' => $slug !== '' ? $slug : Str::slug('category-'.Str::random(6)),
            'sort_order' => $maxSort + 1,
        ])->id;
    }

    private function parseInteger(mixed $value): int
    {
        $string = $this->stringValue($value);

        if ($string === '') {
            return 0;
        }

        $normalized = str_replace(["\u{00A0}", ' '], '', $string);
        $normalized = str_replace(',', '.', $normalized);

        if (! is_numeric($normalized)) {
            return 0;
        }

        return max(0, (int) round((float) $normalized));
    }

    private function parseBoolean(mixed $value, bool $default = false): bool
    {
        $string = mb_strtolower($this->stringValue($value));

        if ($string === '') {
            return $default;
        }

        return in_array($string, ['1', 'true', 'yes', 'y', 'РґР°', 'РїРѕРєР°Р·С‹РІР°С‚СЊ', 'РІРёРґРµРЅ'], true);
    }

    private function parseUnitMode(mixed $value): string
    {
        $string = mb_strtolower($this->stringValue($value));

        return match ($string) {
            'packs', 'pack', 'package', 'СѓРїР°РєРѕРІРєРё', 'СѓРїР°РєРѕРІРєР°', 'СѓРїР°Рє', 'РєРѕСЂРѕР±РєР°' => Product::UNIT_MODE_PACKS,
            default => Product::UNIT_MODE_PIECES,
        };
    }

    private function stringValue(mixed $value): string
    {
        return trim((string) $value);
    }

    private function nullableString(mixed $value): ?string
    {
        $string = $this->stringValue($value);

        return $string !== '' ? $string : null;
    }

    private function normalizeImageValue(mixed $value): ?string
    {
        $image = $this->nullableString($value);

        if ($image === null) {
            return null;
        }

        $image = str_replace('\\', '/', $image);

        if (preg_match('#^https?://#i', $image)) {
            return $image;
        }

        if (str_starts_with($image, '/storage/')) {
            return $image;
        }

        if (str_starts_with($image, 'storage/')) {
            return '/'.ltrim($image, '/');
        }

        if (str_starts_with($image, 'product-images/')) {
            return '/storage/'.ltrim($image, '/');
        }

        if (! str_contains($image, '/')) {
            return '/storage/product-images/'.$image;
        }

        return '/'.ltrim($image, '/');
    }

    private function columnLettersToIndex(string $letters): int
    {
        $letters = strtoupper($letters);
        $length = strlen($letters);
        $index = 0;

        for ($i = 0; $i < $length; $i++) {
            $index = ($index * 26) + (ord($letters[$i]) - 64);
        }

        return max(0, $index - 1);
    }
}
