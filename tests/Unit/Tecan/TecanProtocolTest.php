<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Wash;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommand\TransferWithAutoWash;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tecan\TecanProtocol;
use Mll\LiquidHandlingRobotics\Tecan\TipMask\TipMask;
use Mll\LiquidHandlingRobotics\Tests\TestImplentations\TestLiquidClass;
use Mll\LiquidHandlingRobotics\Tests\TestImplentations\TestRack;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class TecanProtocolTest extends TestCase
{
    public function testProtocolWithForFourTips(): void
    {
        $tecanProtocol = new TecanProtocol(TipMask::FOUR_TIPS());

        $liquidClass = new TestLiquidClass();
        $rack = new TestRack();
        $barcodeLocation = new BarcodeLocation('barcode', $rack);
        $location = new BarcodeLocation('barcode1', $rack);

        foreach (range(1, 5) as $_) {
            $tecanProtocol->addCommandForNextTip(
                new TransferWithAutoWash(
                    new Aspirate(100, $barcodeLocation, $liquidClass),
                    new Dispense(100, $location, $liquidClass)
                )
            );
        }

        self::assertSame(
            StringUtil::normalizeLineEndings(
                'A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;1;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;1;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;2;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;2;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;4;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;4;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;8;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;8;
W;
B;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;1;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;1;
W;
'
            ),
            $tecanProtocol->buildProtocol()
        );
    }

    public function testProtocolWithForForTipsAndManualWash(): void
    {
        $tecanProtocol = new TecanProtocol(TipMask::FOUR_TIPS());

        $liquidClass = new TestLiquidClass();
        $rack = new TestRack();
        $barcodeLocation = new BarcodeLocation('barcode', $rack);
        $location = new BarcodeLocation('barcode1', $rack);

        foreach (range(1, 5) as $_) {
            $tecanProtocol->addCommandForNextTip(
                new Aspirate(100, $barcodeLocation, $liquidClass),
            );
            $tecanProtocol->addCommandCurrentTip(
                new Dispense(100, $location, $liquidClass)
            );
            $tecanProtocol->addCommandCurrentTip(
                new Wash()
            );
        }

        self::assertSame(
            StringUtil::normalizeLineEndings(
                'A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;1;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;1;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;2;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;2;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;4;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;4;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;8;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;8;
W;
B;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;1;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;1;
W;
'
            ),
            $tecanProtocol->buildProtocol()
        );
    }

    public function testProtocolWithForEightTips(): void
    {
        $tecanProtocol = new TecanProtocol(TipMask::EIGHT_TIPS());

        $liquidClass = new TestLiquidClass();
        $rack = new TestRack();
        $barcodeLocation = new BarcodeLocation('barcode', $rack);
        $location = new BarcodeLocation('barcode1', $rack);

        foreach (range(1, 10) as $_) {
            $tecanProtocol->addCommandForNextTip(
                new TransferWithAutoWash(
                    new Aspirate(100, $barcodeLocation, $liquidClass),
                    new Dispense(100, $location, $liquidClass)
                )
            );
        }

        self::assertSame(
            StringUtil::normalizeLineEndings(
                'A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;1;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;1;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;2;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;2;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;4;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;4;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;8;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;8;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;16;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;16;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;32;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;32;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;64;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;64;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;128;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;128;
W;
B;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;1;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;1;
W;
A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;2;
D;TestRackName;;TestRackType;;barcode1;100;TestLiquidClassName;;2;
W;
'
            ),
            $tecanProtocol->buildProtocol()
        );
    }
}
