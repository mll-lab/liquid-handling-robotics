<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\TestImplentations;

use Mll\LiquidHandlingRobotics\Tecan\LiquidClass;

class TestLiquidClass implements LiquidClass
{
    public function name(): string
    {
        return 'TestLiquidClassName';
    }
}
