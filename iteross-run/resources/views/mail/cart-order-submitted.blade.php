<h1>Новая заявка из корзины</h1>
<p><strong>Имя/компания:</strong> {{ $data->name }}</p>
<p><strong>Телефон:</strong> {{ $data->phone }}</p>
@if ($data->email)
    <p><strong>Email:</strong> {{ $data->email }}</p>
@endif
@if ($data->comment)
    <p><strong>Комментарий:</strong></p>
    <p>{!! nl2br(e($data->comment)) !!}</p>
@endif

<h2>Состав заявки</h2>
<table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th align="left">Артикул</th>
            <th align="left">Наименование</th>
            <th align="right">Кол-во</th>
            <th align="right">Цена за шт.</th>
            <th align="right">Сумма</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data->items as $item)
            @php($itemPrice = $item['price'] ?? null)
            <tr>
                <td>{{ $item['sku'] }}</td>
                <td>{{ $item['name'] ?? '' }}</td>
                <td align="right">{{ $item['qty'] }}</td>
                <td align="right">{{ $itemPrice ? number_format($itemPrice, 0, ',', ' ').' ₽' : 'По запросу' }}</td>
                <td align="right">{{ $itemPrice ? number_format($itemPrice * $item['qty'], 0, ',', ' ').' ₽' : 'По запросу' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p>
    <strong>Позиций:</strong> {{ count($data->items) }}<br>
    <strong>Штук всего:</strong> {{ $data->totalQuantity() }}<br>
    <strong>Сумма:</strong> {{ $data->totalPrice() > 0 ? number_format($data->totalPrice(), 0, ',', ' ').' ₽'.($data->hasUnknownPrice() ? '+' : '') : 'По запросу' }}
</p>
