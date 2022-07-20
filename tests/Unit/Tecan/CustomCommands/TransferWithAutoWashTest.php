<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan\CustomCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommand\TransferWithAutoWash;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tests\TestImplentations\TestLiquidClass;
use Mll\LiquidHandlingRobotics\Tests\TestImplentations\TestRack;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

class TransferWithAutoWashTest extends TestCase
{
    public function testTransferWithAutoWashCommand(): void
    {
        $liquidClass = new TestLiquidClass();
        $rack = new TestRack();
        $barcodeLocation = new BarcodeLocation('barcode', $rack);
        $location = new BarcodeLocation('barcode1', $rack);

        $transfer = new TransferWithAutoWash(
            new Aspirate(100, $barcodeLocation, $liquidClass),
            new Dispense(100, $location, $liquidClass)
        );

        self::assertSame(
            StringUtil::normalizeLineEndings(
                'A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;;
W;'
            ),
            $transfer->toString()
        );
    }
}
