<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\Rack;

final class CustomRack implements Rack
{
    private string $name;

    private string $type;

    public function __construct(string $name, string $type)
    {
        $this->type = $type;
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }
}
