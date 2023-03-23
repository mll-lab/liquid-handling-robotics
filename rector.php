<?php declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;

use function MLL\RectorConfig\config;

return static function (RectorConfig $config): void {
    config($config);
    $config->rules([
        AddClosureReturnTypeRector::class,
    ]);
    $config->sets([
        SetList::CODE_QUALITY,
        SetList::PHP_74,
    ]);
    $config->paths([__DIR__ . '/src', __DIR__ . '/tests']);
    $config->phpVersion(PhpVersion::PHP_74);

    $config->skip([
        FinalizeClassesWithoutChildrenRector::class => [
            __DIR__ . '/src/FluidXPlate/FluidXScanner.php', // enabled for mocking
        ],
    ]);
};
