<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommand\Transfer;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tecan\TecanProtocol;
use Mll\LiquidHandlingRobotics\Tecan\TipMask\TipMaskEightTips;
use Mll\LiquidHandlingRobotics\Tecan\TipMask\TipMaskFourTips;
use Mll\LiquidHandlingRobotics\Tests\TestImplentations\TestLiquidClass;
use Mll\LiquidHandlingRobotics\Tests\TestImplentations\TestRack;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class TecanProtocolTest extends TestCase
{
    public function testAspirateWithBarcodeLocationForTips(): void
    {
        $tecanProtocol = new TecanProtocol(new TipMaskFourTips());

        $liquidClass = new TestLiquidClass();
        $rack = new TestRack();
        $barcodeLocation = new BarcodeLocation('barcode', $rack);
        $location = new BarcodeLocation('barcode1', $rack);

        foreach (range(1, 5) as $_) {
            $tecanProtocol->addCommandForNextTip(
                new Transfer(
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

    public function testAspirateWithBarcodeLocation(): void
    {
        $tecanProtocol = new TecanProtocol(new TipMaskEightTips());

        $liquidClass = new TestLiquidClass();
        $rack = new TestRack();
        $barcodeLocation = new BarcodeLocation('barcode', $rack);
        $location = new BarcodeLocation('barcode1', $rack);

        for ($i = 1; $i <= 10; ++$i) {
            $tecanProtocol->addCommandForNextTip(
                new Transfer(
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
