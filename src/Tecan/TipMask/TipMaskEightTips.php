<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\TipMask;

final class TipMaskEightTips extends TipMask
{
    public function isLastTip(): bool
    {
        return 128 === $this->currentTip;
    }
}
