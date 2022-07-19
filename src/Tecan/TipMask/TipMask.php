<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\TipMask;

abstract class TipMask
{
    public const FIRST_TIP = 1;

    public ?int $currentTip = null;

    abstract public function isLastTip(): bool;

    public function nextTip(): int
    {
        if (! isset($this->currentTip) || $this->isLastTip()) {
            $this->currentTip = self::FIRST_TIP;
        } else {
            // because of the bitwise nature we can just multiply current tip with 2 switch to the next tip
            $this->currentTip *= 2;
        }

        return $this->currentTip;
    }
}
