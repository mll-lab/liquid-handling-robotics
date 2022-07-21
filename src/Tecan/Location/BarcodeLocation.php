<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\Location;

use Mll\LiquidHandlingRobotics\Tecan\Rack;

final class BarcodeLocation implements Location
{
    private string $barcode;

    private Rack $rack;

    public function __construct(string $barcode, Rack $rack)
    {
        $this->barcode = $barcode;
        $this->rack = $rack;
    }

    public function tubeId(): string
    {
        return $this->barcode;
    }

    public function position(): ?string
    {
        return null;
    }

    public function rackName(): string
    {
        return $this->rack->name();
    }

    public function rackType(): string
    {
        return $this->rack->type();
    }

    public function rackId(): ?string
    {
        return null;
    }
}
