<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\TestImplentations;

use Mll\LiquidHandlingRobotics\Tecan\Rack;

class TestRack implements Rack
{
    public function name(): string
    {
        return 'TestRackName';
    }

    public function type(): string
    {
        return 'TestRackType';
    }
}
