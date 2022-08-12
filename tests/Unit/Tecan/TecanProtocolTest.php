<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan;

use Carbon\Carbon;
use Composer\InstalledVersions;
use Illuminate\Support\Str;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Wash;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommands\AspirateParameters;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommands\DispenseParameters;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommands\MllReagentDistribution;
use Mll\LiquidHandlingRobotics\Tecan\CustomCommands\TransferWithAutoWash;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\CustomLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\MllLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tecan\Rack\CustomRack;
use Mll\LiquidHandlingRobotics\Tecan\Rack\MllLabWareRack;
use Mll\LiquidHandlingRobotics\Tecan\TecanProtocol;
use Mll\LiquidHandlingRobotics\Tecan\TipMask\TipMask;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class TecanProtocolTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::createStrict(2022, 10, 5, 13, 34, 32));
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
            $tecanProtocol->addCommand(
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

    public function testReagentDistributionProtocol(): void
    {
        $sourceRack = MllLabWareRack::MM();
        $targetRack = MllLabWareRack::DEST_PCR();
        $dispenseVolume = 24;
        $liquidClass = MllLiquidClass::TRANSFER_MASTERMIX_MP();

        $tecanProtocol = new TecanProtocol(TipMask::FOUR_TIPS());

        $dispensePositions = [1, 2, 3, 4, 5, 57];
        $tecanProtocol->addCommand(
            new MllReagentDistribution(
                new AspirateParameters($sourceRack, 1),
                new DispenseParameters($targetRack, $dispensePositions),
                $dispenseVolume,
                $liquidClass,
            )
        );

        $dispensePositions1 = [6, 7, 50, 58, 74, 75];
        $tecanProtocol->addCommand(
            new MllReagentDistribution(
                new AspirateParameters($sourceRack, 2),
                new DispenseParameters($targetRack, $dispensePositions1),
                $dispenseVolume,
                $liquidClass,
            )
        );

        $dispensePositions2 = [8, 10, 51, 59];
        $tecanProtocol->addCommand(
            new MllReagentDistribution(
                new AspirateParameters($sourceRack, 3),
                new DispenseParameters($targetRack, $dispensePositions2),
                $dispenseVolume,
                $liquidClass,
            )
        );

        $dispensePositions3 = [11, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 52, 60];
        $tecanProtocol->addCommand(
            new MllReagentDistribution(
                new AspirateParameters($sourceRack, 4),
                new DispenseParameters($targetRack, $dispensePositions3),
                $dispenseVolume,
                $liquidClass,
            )
        );

        $dispensePositions4 = [24, 25, 26, 27, 28, 29, 30, 53, 61];
        $tecanProtocol->addCommand(
            new MllReagentDistribution(
                new AspirateParameters($sourceRack, 5),
                new DispenseParameters($targetRack, $dispensePositions4),
                $dispenseVolume,
                $liquidClass,
            )
        );
        $dispensePositions5 = [1, 2, 3, 4, 5];
        $tecanProtocol->addCommand(
            new MllReagentDistribution(
                new AspirateParameters($sourceRack, 5),
                new DispenseParameters($targetRack, $dispensePositions5),
                $dispenseVolume,
                $liquidClass,
            )
        );

        self::assertEquals(
            StringUtil::normalizeLineEndings(
                $this->initComment() . 'R;MM;;Eppis 32x1.5 ml Cooled;1;1;DestPCR;;96 Well PCR ABI semi-skirted;1;57;24;Transfer_Mastermix_MP;6;1;0;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23;24;25;26;27;28;29;30;31;32;33;34;35;36;37;38;39;40;41;42;43;44;45;46;47;48;49;50;51;52;53;54;55;56
R;MM;;Eppis 32x1.5 ml Cooled;2;2;DestPCR;;96 Well PCR ABI semi-skirted;6;75;24;Transfer_Mastermix_MP;6;1;0;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23;24;25;26;27;28;29;30;31;32;33;34;35;36;37;38;39;40;41;42;43;44;45;46;47;48;49;51;52;53;54;55;56;57;59;60;61;62;63;64;65;66;67;68;69;70;71;72;73
R;MM;;Eppis 32x1.5 ml Cooled;3;3;DestPCR;;96 Well PCR ABI semi-skirted;8;59;24;Transfer_Mastermix_MP;6;1;0;9;11;12;13;14;15;16;17;18;19;20;21;22;23;24;25;26;27;28;29;30;31;32;33;34;35;36;37;38;39;40;41;42;43;44;45;46;47;48;49;50;52;53;54;55;56;57;58
R;MM;;Eppis 32x1.5 ml Cooled;4;4;DestPCR;;96 Well PCR ABI semi-skirted;11;60;24;Transfer_Mastermix_MP;6;1;0;12;23;24;25;26;27;28;29;30;31;32;33;34;35;36;37;38;39;40;41;42;43;44;45;46;47;48;49;50;51;53;54;55;56;57;58;59
R;MM;;Eppis 32x1.5 ml Cooled;5;5;DestPCR;;96 Well PCR ABI semi-skirted;24;61;24;Transfer_Mastermix_MP;6;1;0;31;32;33;34;35;36;37;38;39;40;41;42;43;44;45;46;47;48;49;50;51;52;54;55;56;57;58;59;60
R;MM;;Eppis 32x1.5 ml Cooled;5;5;DestPCR;;96 Well PCR ABI semi-skirted;1;5;24;Transfer_Mastermix_MP;6;1;0;
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
