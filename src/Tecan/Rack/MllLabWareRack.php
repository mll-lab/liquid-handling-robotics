<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\Rack;

use BenSampo\Enum\Enum;
use Exception;

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
final class MllLabWareRack extends Enum implements Rack
{
    public const A = 'A';
    public const MP_CDNA = 'MPCDNA';
    public const MP_SAMPLE = 'MPSample';
    public const MP_WATER = 'MPWasser';
    public const FLUID_X = 'FluidX';
    public const MM = 'MM';
    public const DEST_LC = 'DestLC';
    public const DEST_PCR = 'DestPCR';
    public const DEST_TAQMAN = 'DestTaqMan';

    public function type(): string
    {
        switch ($this->value) {
            case self::A:
                return 'Eppis 24x0.5 ml Cooled';
            case self::MP_CDNA:
                return 'MP cDNA';
            case self::MP_SAMPLE:
                return 'MP Microplate';
            case self::MP_WATER:
                return 'Trough 300ml MCA Portrait';
            case self::FLUID_X:
                return '96FluidX';
            case self::MM:
                return 'Eppis 32x1.5 ml Cooled';
            case self::DEST_LC:
                return '96 Well MP LightCycler480';
            case self::DEST_PCR:
                return '96 Well PCR ABI semi-skirted';
            case self::DEST_TAQMAN:
                return '96 Well PCR TaqMan';
            default:
                throw new Exception('Type not defined for ' . $this->value);
        }
    }

    public function name(): string
    {
        assert(is_string($this->value));

        return $this->value;
    }

    public function id(): ?string
    {
        return null;
    }
}
