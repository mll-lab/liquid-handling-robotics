<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\FluidXPlate\Scalars;

use MLL\GraphQLScalars\Regex;

final class FrameStarBarcode extends Regex
{
    public const FRAME_STAR_BARCODE_REGEX = /* @lang RegExp */ '/[A-Z]{2}(\d){6}/';

    public ?string $description = 'A valid barcode for a FrameStar plate represented as a string, e.g. `WD123456`.';

    public static function regex(): string
    {
        return self::FRAME_STAR_BARCODE_REGEX;
    }
}
