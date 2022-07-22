<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\Rack;

interface Rack
{
    public function name(): string;

    public function type(): string;
}
