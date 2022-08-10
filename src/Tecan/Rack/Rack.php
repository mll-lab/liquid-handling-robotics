<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\Rack;

interface Rack
{
    /**
     * Source labware barcode.
     */
    public function id(): ?string;

    /**
     * User-defined label (name) which is assigned to the source labware.
     */
    public function name(): string;

    /**
     * Source labware type (configuration name), e.g. “384 Well, landscape”.
     */
    public function type(): string;
}
