<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\BreakCommand;
use PHPUnit\Framework\TestCase;

final class BreakTest extends TestCase
{
    public function testBreakCommand(): void
    {
        self::assertSame('B;', (new BreakCommand())->formatToString());
    }
}
