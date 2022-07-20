<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\Location;

use Mll\LiquidHandlingRobotics\Tecan\Rack;

final class PositionLocation implements Location
{
    private int $position;

    private Rack $rack;

    public function __construct(int $position, Rack $rack)
    {
        $this->position = $position;
        $this->rack = $rack;
    }

    public function tubeId(): ?string
    {
        return null;
    }

    public function position(): string
    {
        return (string) $this->position;
    }

    public function rackName(): ?string
    {
        return null;
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
