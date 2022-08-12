<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\LiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\Location;

abstract class BasicPipettingActionCommand extends Command implements UsesTipMask
{
    public float $volume;

    public Location $location;

    public LiquidClass $liquidClass;

    protected string $tipMask = '';

    abstract public static function commandLetter(): string;

    public function toString(): string
    {
        return implode(
            ';',
            [
                static::commandLetter(),
                $this->location->toString(),
                $this->volume,
                $this->liquidClass->name(),
                null, // tipType
                $this->getTipMask(),
            ]
        );
    }

    protected function getTipMask(): string
    {
        return $this->tipMask;
    }

    public function setTipMask(int $tipMask): void
    {
        $this->tipMask = (string) $tipMask;
    }
}
