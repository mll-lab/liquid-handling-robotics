<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\TipMask;

use BenSampo\Enum\Enum;
use Mll\LiquidHandlingRobotics\Tecan\TecanException;

/**
 * @method static static FOUR_TIPS()
 * @method static static EIGHT_TIPS()
 *
 * @extends Enum<string>
 */
final class TipMask extends Enum
{
    public const FOUR_TIPS = 'FOUR_TIPS';
    public const EIGHT_TIPS = 'EIGHT_TIPS';

    public static function firstTip(): int
    {
        return 1;
    }

    public ?int $currentTip = null;

    public function isLastTip(): bool
    {
        switch ($this->value) {
            case self::FOUR_TIPS:
                return 8 === $this->currentTip;
            case self::EIGHT_TIPS:
                return 128 === $this->currentTip;
            default:
                throw new TecanException('isLastTip not defined for ' . $this->value);
        }
    }

    public function nextTip(): int
    {
        $this->currentTip = ! isset($this->currentTip) || $this->isLastTip()
            ? self::firstTip()
            // due to the bitwise nature we can simply multiply the current tip by 2 if we want to specify the next tip.
            : $this->currentTip * 2;

        return $this->currentTip;
    }
}
