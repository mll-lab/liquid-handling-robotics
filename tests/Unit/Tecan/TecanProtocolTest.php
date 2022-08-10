<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan;

use Carbon\Carbon;
use Composer\InstalledVersions;
use Illuminate\Support\Str;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Wash;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommand\TransferWithAutoWash;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\CustomLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tecan\Rack\CustomRack;
use Mll\LiquidHandlingRobotics\Tecan\TecanProtocol;
use Mll\LiquidHandlingRobotics\Tecan\TipMask\TipMask;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class TecanProtocolTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::createStrict(2022,10,5,13,34,32));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow(Carbon::now());
    }

    public function testProtocolUserAndName(): void
    {
        $userName = 'username';
        $protocolName = 'testProtocol';
        $tecanProtocol = new TecanProtocol(TipMask::FOUR_TIPS(), $protocolName, $userName);

        self::assertSame('testProtocol.gwl', $tecanProtocol->fileName());
        self::assertSame(
            StringUtil::normalizeLineEndings(
                $this->initComment() . 'C;User: username
C;Protocol name: testProtocol
'
            ),
            $tecanProtocol->buildProtocol()
        );
    }

    public function testProtocolUuidName(): void
    {
        $tecanProtocol = new TecanProtocol(TipMask::FOUR_TIPS());

        $fileName = Str::before($tecanProtocol->fileName(), TecanProtocol::GEMINI_WORKLIST_FILENAME_SUFFIX);
        self::assertTrue(Str::isUuid($fileName));

        $fileSuffix = Str::after($tecanProtocol->fileName(), $fileName);
        self::assertSame($fileSuffix, TecanProtocol::GEMINI_WORKLIST_FILENAME_SUFFIX);
    }

    public function testProtocolWithForFourTips(): void
    {
        $tecanProtocol = new TecanProtocol(TipMask::FOUR_TIPS());

        $liquidClass = new CustomLiquidClass('TestLiquidClassName');
        $rack = new CustomRack('TestRackName', 'TestRackType');
        $aspirateLocation = new BarcodeLocation('barcode', $rack);
        $dispenseLocation = new BarcodeLocation('barcode1', $rack);

        foreach (range(1, 5) as $_) {
            $tecanProtocol->addCommandForNextTip(
                new TransferWithAutoWash(100, $liquidClass, $aspirateLocation, $dispenseLocation)
            );
        }
        self::assertSame(
            StringUtil::normalizeLineEndings(
                $this->initComment() . 'A;;;TestRackType;;barcode;100;TestLiquidClassName;;1
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;1
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;2
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;2
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;4
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;4
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;8
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;8
W;
B;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;1
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;1
W;
'
            ),
            $tecanProtocol->buildProtocol()
        );
    }

    public function testProtocolWithForForTipsAndManualWash(): void
    {
        $tecanProtocol = new TecanProtocol(TipMask::FOUR_TIPS());

        $liquidClass = new CustomLiquidClass('TestLiquidClassName');
        $rack = new CustomRack('TestRackName', 'TestRackType');
        $aspirateLocation = new BarcodeLocation('barcode', $rack);
        $dispenseLocation = new BarcodeLocation('barcode1', $rack);

        foreach (range(1, 5) as $_) {
            $tecanProtocol->addCommandForNextTip(
                new Aspirate(100, $aspirateLocation, $liquidClass),
            );
            $tecanProtocol->addCommandCurrentTip(
                new Dispense(100, $dispenseLocation, $liquidClass)
            );
            $tecanProtocol->addCommandCurrentTip(
                new Wash()
            );
        }

        self::assertSame(
            StringUtil::normalizeLineEndings(
                $this->initComment() . 'A;;;TestRackType;;barcode;100;TestLiquidClassName;;1
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;1
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;2
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;2
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;4
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;4
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;8
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;8
W;
B;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;1
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;1
W;
'
            ),
            $tecanProtocol->buildProtocol()
        );
    }

    public function testProtocolWithForEightTips(): void
    {
        $tecanProtocol = new TecanProtocol(TipMask::EIGHT_TIPS());

        $liquidClass = new CustomLiquidClass('TestLiquidClassName');
        $rack = new CustomRack('TestRackName', 'TestRackType');
        $aspirateLocation = new BarcodeLocation('barcode', $rack);
        $dispenseLocation = new BarcodeLocation('barcode1', $rack);

        foreach (range(1, 10) as $_) {
            $tecanProtocol->addCommandForNextTip(
                new TransferWithAutoWash(100, $liquidClass, $aspirateLocation, $dispenseLocation)
            );
        }

        self::assertSame(
            StringUtil::normalizeLineEndings(
                $this->initComment() . 'A;;;TestRackType;;barcode;100;TestLiquidClassName;;1
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;1
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;2
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;2
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;4
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;4
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;8
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;8
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;16
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;16
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;32
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;32
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;64
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;64
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;128
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;128
W;
B;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;1
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;1
W;
A;;;TestRackType;;barcode;100;TestLiquidClassName;;2
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;2
W;
'
            ),
            $tecanProtocol->buildProtocol()
        );
    }

    private function initComment(): string
    {
        $version = InstalledVersions::getPrettyVersion(TecanProtocol::PACKAGE_NAME);

        return "C;Created by mll-lab/liquid-handling-robotics v.{$version}
C;Date: 2022-10-05 13:34:32
";
    }
}
