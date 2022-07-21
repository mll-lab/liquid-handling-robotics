<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\Location;

interface Location
{
    public function tubeId(): ?string;

    public function position(): ?string;

    public function rackName(): ?string;

    public function rackType(): string;

    public function rackId(): ?string;
}
