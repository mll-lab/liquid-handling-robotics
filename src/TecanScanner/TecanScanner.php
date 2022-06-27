<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\TecanScanner;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Mll\LiquidHandlingRobotics\FluidXPlate\FluidXPlate;
use Mll\Microplate\Coordinate;
use MLL\Utils\StringUtil;

/**
 * The plate scanner on a tecan worktable.
 */
final class TecanScanner
{
    public const NO_READ = 'NO READ';

    public static function parseRawContent(string $rawContent): FluidXPlate
    {
        if ('' === $rawContent) {
            throw new TecanScanEmptyException();
        }

        $lines = new Collection(StringUtil::splitLines($rawContent));

        $firstLineWithRackId = $lines->shift();

        if (! is_string($firstLineWithRackId) || ! Str::startsWith($firstLineWithRackId, 'rackid,')) {
            throw new NoRackIdException();
        }

        $expectedCount = FluidXPlate::coordinateSystem()->positionsCount();
        $actualCount = $lines->count();
        if ($expectedCount !== $actualCount) {
            throw new WrongNumberOfWells($expectedCount, $actualCount);
        }

        $plate = new FluidXPlate(Str::substr($firstLineWithRackId, 7));

        foreach ($lines as $line) {
            $barcode = Str::after($line, ',');

            if (self::NO_READ !== $barcode) {
                $coordinateString = Str::before($line, ',');

                $plate->addWell(
                    Coordinate::fromString(
                        $coordinateString,
                        $plate->coordinateSystem
                    ),
                    $barcode
                );
            }
        }

        return $plate;
    }
}
