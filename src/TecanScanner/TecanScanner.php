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
    public const RACKID_IDENTIFIER = 'rackid,';

    public static function parseRawContent(string $rawContent): FluidXPlate
    {
        if ('' === $rawContent) {
            throw new TecanScanEmptyException();
        }

        $lines = new Collection(StringUtil::splitLines($rawContent));

        $firstLineWithRackId = $lines->shift();

        if (! is_string($firstLineWithRackId) || ! Str::startsWith($firstLineWithRackId, self::RACKID_IDENTIFIER)) {
            throw new NoRackIdException();
        }
        $rackId = Str::substr($firstLineWithRackId, strlen(self::RACKID_IDENTIFIER));

        $expectedCount = FluidXPlate::coordinateSystem()->positionsCount();
        $actualCount = $lines->count();
        if ($expectedCount !== $actualCount) {
            throw new WrongNumberOfWells($expectedCount, $actualCount);
        }

        $plate = new FluidXPlate($rackId);

        foreach ($lines as $line) {
            $barcode = Str::after($line, ',');

            if (self::NO_READ !== $barcode) {
                $coordinateString = Str::before($line, ',');

                $plate->addWell(
                    Coordinate::fromString(
                        $coordinateString,
                        $plate::coordinateSystem()
                    ),
                    $barcode
                );
            }
        }

        return $plate;
    }

    /**
     * Checks if a string can be parsed into a FluidXPlate.
     */
    public static function isValidRawContent(string $rawContent): bool
    {
        $lines = StringUtil::splitLines($rawContent);

        if (97 !== count($lines)) {
            return false;
        }
        if (0 === \Safe\preg_match(/* @lang RegExp */ '/^' . self::RACKID_IDENTIFIER . FluidXPlate::FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER . '$/', array_shift($lines))) {
            return false;
        }
        foreach ($lines as $line) {
            if (1 !== \Safe\preg_match(/* @lang RegExp */ '/^[A-H][1-12],' . FluidXPlate::FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER . '|' . self::NO_READ . '$/', $line)) {
                return false;
            }
        }

        return true;
    }
}
