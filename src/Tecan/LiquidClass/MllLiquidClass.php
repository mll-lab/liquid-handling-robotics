<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\LiquidClass;

use BenSampo\Enum\Enum;

/**
 * @method static static DNA_DILUTION()
 * @method static static DNA_DILUTION_WATER()
 * @method static static TRANSFER_PCR_PRODUKT()
 * @method static static TRANSFER_MASTERMIX_MP()
 * @method static static TRANSFER_TEMPLATE()
 */
final class MllLiquidClass extends Enum implements LiquidClass
{
    public const DNA_DILUTION = 'DNA_Dilution';
    public const DNA_DILUTION_WATER = 'DNA_Dilution_Water';
    public const TRANSFER_PCR_PRODUKT = 'Transfer_PCR_Produkt';
    public const TRANSFER_MASTERMIX_MP = 'Transfer_Mastermix_MP';
    public const TRANSFER_TEMPLATE = 'Transfer_Template'; // DNA-templates and BUFFER!

    public function name(): string
    {
        assert(is_string($this->value));

        return $this->value;
    }
}
