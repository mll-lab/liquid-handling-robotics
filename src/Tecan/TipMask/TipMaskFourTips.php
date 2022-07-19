<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\TipMask;

final class TipMaskFourTips extends TipMask
{
    public function isLastTip(): bool
    {
        return 8 === $this->currentTip;
    }
}
