<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Wash;
use PHPUnit\Framework\TestCase;

final class WashTest extends TestCase
{
    public function testWashCommand(): void
    {
        self::assertSame('W;', (new Wash())->toString());
    }
}
