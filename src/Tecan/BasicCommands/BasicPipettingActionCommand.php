<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\LiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\Location;

abstract class BasicPipettingActionCommand implements PipettingActionCommand
{
    public float $volume;

    public Location $location;

    public LiquidClass $liquidClass;

    protected string $tipMask = '';

    abstract public static function commandLetter(): string;

    public function formatToString(): string
    {
        return
            static::commandLetter() . ';'
            . $this->location->rackName() . ';'
            . $this->location->rackId() . ';'
            . $this->location->rackType() . ';'
            . $this->location->position() . ';'
            . $this->location->tubeId() . ';'
            . $this->volume . ';'
            . $this->liquidClass->name() . ';'
            . ';' // tipType
            . $this->getTipMask()
        ;
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
