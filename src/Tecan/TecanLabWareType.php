<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan;

use BenSampo\Enum\Enum;

/**
 * @method static static TROUGH_300ML_MCA_PORTRAIT()
 * @method static static MP_CDNA()
 * @method static static MP_MICROPLATE()
 * @method static static _96_FLUID_X()
 * @method static static FALCON_TUBE_15ML_12_POS()
 * @method static static EPPIS_32X1_5_ML_COOLED()
 * @method static static EPPIS_24X0_5_ML_COOLED()
 * @method static static _96_WELL_PCR_ABI_SEMI_SKIRTED()
 * @method static static _96_WELL_MP_LIGHT_CYCLER_480()
 * @method static static _96_WELL_PCR_TAQMAN()
 */
final class TecanLabWareType extends Enum
{
    /**
     * @var string
     */
    public $value;

    public const TROUGH_300ML_MCA_PORTRAIT = 'Trough 300ml MCA Portrait';
    public const MP_CDNA = 'MP cDNA';
    public const MP_MICROPLATE = 'MP Microplate';
    public const _96_FLUID_X = '96FluidX';
    public const FALCON_TUBE_15ML_12_POS = 'Falcon Tube 15ml 12 Pos';
    public const EPPIS_32X1_5_ML_COOLED = 'Eppis 32x1.5 ml Cooled';
    public const EPPIS_24X0_5_ML_COOLED = 'Eppis 24x0.5 ml Cooled';
    public const _96_WELL_PCR_ABI_SEMI_SKIRTED = '96 Well PCR ABI semi-skirted';
    public const _96_WELL_MP_LIGHT_CYCLER_480 = '96 Well MP LightCycler480';
    public const _96_WELL_PCR_TAQMAN = '96 Well PCR TaqMan';
}
