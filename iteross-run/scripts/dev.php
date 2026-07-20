<?php

declare(strict_types=1);

$isWindows = PHP_OS_FAMILY === 'Windows';

$commands = [
    '"php artisan serve"',
    '"php artisan queue:listen --tries=1 --timeout=0"',
    '"npm run dev"',
];

$colors = '#93c5fd,#c4b5fd,#fdba74';
$names = 'server,queue,vite';

if (! $isWindows) {
    $commands = [
        '"php artisan serve"',
        '"php artisan queue:listen --tries=1 --timeout=0"',
        '"php artisan pail --timeout=0"',
        '"npm run dev"',
    ];

    $colors = '#93c5fd,#c4b5fd,#fb7185,#fdba74';
    $names = 'server,queue,logs,vite';
}

$command = sprintf(
    'npx concurrently -c "%s" %s --names=%s --kill-others',
    $colors,
    implode(' ', $commands),
    $names,
);

passthru($command, $exitCode);

exit($exitCode);
