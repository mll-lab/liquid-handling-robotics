<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan;

use BenSampo\Enum\Enum;

/**
 * @method static static A()
 * @method static static MP_CDNA()
 * @method static static MP_SAMPLE()
 * @method static static MP_WATER()
 * @method static static FLUID_X()
 * @method static static MM()
 * @method static static DEST_LC()
 * @method static static DEST_PCR()
 * @method static static DEST_TAQMAN()
 */
final class TecanLabWareName extends Enum
{
    /**
     * @var string
     */
    public $value;

    public const A = 'A';
    public const MP_CDNA = 'MPCDNA';
    public const MP_SAMPLE = 'MPSample';
    public const MP_WATER = 'MPWasser'; // Is named MPWasser in EVOWare
    public const FLUID_X = 'FluidX';
    public const MM = 'MM';
    public const DEST_LC = 'DestLC';
    public const DEST_PCR = 'DestPCR';
    public const DEST_TAQMAN = 'DestTaqMan';

    public function type(): TecanLabWareType
    {
        switch ($this->value) {
            case self::MP_CDNA:
                return TecanLabWareType::MP_CDNA();
            case self::MP_SAMPLE:
                return TecanLabWareType::MP_MICROPLATE();
            case self::MP_WATER:
                return TecanLabWareType::TROUGH_300ML_MCA_PORTRAIT();
            case self::FLUID_X:
                return TecanLabWareType::_96_FLUID_X();
            case self::MM:
                return TecanLabWareType::EPPIS_32X1_5_ML_COOLED();
            case self::A:
                return TecanLabWareType::EPPIS_24X0_5_ML_COOLED();
            case self::DEST_PCR:
                return TecanLabWareType::_96_WELL_PCR_ABI_SEMI_SKIRTED();
            case self::DEST_LC:
                return TecanLabWareType::_96_WELL_MP_LIGHT_CYCLER_480();
            case self::DEST_TAQMAN:
                return TecanLabWareType::_96_WELL_PCR_TAQMAN();
            default:
                throw new TecanException('Type not defined for ' . $this->value);
        }
    }
}
