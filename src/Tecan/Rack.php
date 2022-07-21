<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan;

interface Rack
{
    public function name(): string;

    public function type(): string;
}
