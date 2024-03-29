<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan\CustomCommands;

use Mll\LiquidHandlingRobotics\Tecan\CustomCommands\AspirateParameters;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommands\DispenseParameters;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommands\MllReagentDistribution;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\MllLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Rack\MllLabWareRack;
use PHPUnit\Framework\TestCase;

final class MllReagentDistributionTest extends TestCase
{
    public function testFormatToString(): void
    {
        $sourceStartPosition = 13;
        $sourceRack = MllLabWareRack::MM();
        $source = new AspirateParameters($sourceRack, $sourceStartPosition);

        $targetRack = MllLabWareRack::DEST_PCR();
        $target = new DispenseParameters($targetRack, [48, 49, 72, 73]);

        $dispenseVolume = 24;
        $liquidClass = MllLiquidClass::TRANSFER_MASTERMIX_MP();

        $command = new MllReagentDistribution(
            $source,
            $target,
            $dispenseVolume,
            $liquidClass,
        );

        $numberOfDitiReuses = MllReagentDistribution::NUMBER_OF_DITI_REUSES;
        $numberOfMultiDisp = MllReagentDistribution::NUMBER_OF_MULTI_DISP;

        self::assertSame(
            "R;{$sourceRack->name()};;{$sourceRack->type()};{$sourceStartPosition};{$sourceStartPosition};{$targetRack->name()};;{$targetRack->type()};48;73;{$dispenseVolume};{$liquidClass->name()};{$numberOfDitiReuses};{$numberOfMultiDisp};0;50;51;52;53;54;55;56;57;58;59;60;61;62;63;64;65;66;67;68;69;70;71",
            $command->toString()
        );
    }
}
