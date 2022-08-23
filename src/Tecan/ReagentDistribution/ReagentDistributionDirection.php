<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\ReagentDistribution;

use BenSampo\Enum\Enum;

/**
 * @method static static LEFT_TO_RIGHT()
 * @method static static RIGHT_TO_LEFT()
 *
 * @extends Enum<int>
 */
final class ReagentDistributionDirection extends Enum
{
    public const LEFT_TO_RIGHT = 0;
    public const RIGHT_TO_LEFT = 1;
}
