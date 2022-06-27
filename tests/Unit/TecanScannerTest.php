<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit;

use Mll\LiquidHandlingRobotics\TecanScanner\NoRackIdException;
use Mll\LiquidHandlingRobotics\TecanScanner\TecanScanEmptyException;
use Mll\LiquidHandlingRobotics\TecanScanner\TecanScanner;
use Mll\LiquidHandlingRobotics\TecanScanner\WrongNumberOfWells;
use Mll\Microplate\Exceptions\WellNotEmptyException;
use PHPUnit\Framework\TestCase;

final class TecanScannerTest extends TestCase
{
    public function testCreateFromStringEmpty(): void
    {
        $this->expectExceptionObject(new TecanScanEmptyException());
        TecanScanner::parseRawContent('');
    }

    public function testCreateFromUnexpectedLineCount(): void
    {
        $this->expectExceptionObject(new WrongNumberOfWells(96, 2));
        TecanScanner::parseRawContent("rackid,SA00411242\nA1,FD13945423\nB1,FD32807353");
    }

    public function testMicroplateHandlesDuplicateCoordinate(): void
    {
        $this->expectExceptionObject(new WellNotEmptyException('Well with coordinate "A1" is not empty. Use setWell() to overwrite the coordinate. Well content "s:10:"FD32807353";" was not added.'));
        TecanScanner::parseRawContent("rackid,SA00411242\nA1,FD13945423\nA1,FD32807353\nC1,NO READ\nD1,NO READ\nE1,NO READ\nF1,NO READ\nG1,NO READ\nH1,NO READ\nA2,NO READ\nB2,NO READ\nC2,NO READ\nD2,NO READ\nE2,NO READ\nF2,NO READ\nG2,NO READ\nH2,NO READ\nA3,NO READ\nB3,NO READ\nC3,NO READ\nD3,NO READ\nE3,NO READ\nF3,NO READ\nG3,NO READ\nH3,NO READ\nA4,NO READ\nB4,NO READ\nC4,NO READ\nD4,NO READ\nE4,NO READ\nF4,NO READ\nG4,NO READ\nH4,NO READ\nA5,NO READ\nB5,NO READ\nC5,NO READ\nD5,NO READ\nE5,NO READ\nF5,NO READ\nG5,NO READ\nH5,NO READ\nA6,NO READ\nB6,NO READ\nC6,NO READ\nD6,NO READ\nE6,NO READ\nF6,NO READ\nG6,NO READ\nH6,NO READ\nA7,NO READ\nB7,NO READ\nC7,NO READ\nD7,NO READ\nE7,NO READ\nF7,NO READ\nG7,NO READ\nH7,NO READ\nA8,NO READ\nB8,NO READ\nC8,NO READ\nD8,NO READ\nE8,NO READ\nF8,NO READ\nG8,NO READ\nH8,NO READ\nA9,NO READ\nB9,NO READ\nC9,NO READ\nD9,NO READ\nE9,NO READ\nF9,NO READ\nG9,NO READ\nH9,NO READ\nA10,NO READ\nB10,NO READ\nC10,NO READ\nD10,NO READ\nE10,NO READ\nF10,NO READ\nG10,NO READ\nH10,NO READ\nA11,NO READ\nB11,NO READ\nC11,NO READ\nD11,NO READ\nE11,NO READ\nF11,NO READ\nG11,NO READ\nH11,NO READ\nA12,NO READ\nB12,NO READ\nC12,NO READ\nD12,NO READ\nE12,NO READ\nF12,NO READ\nG12,NO READ\nH12,NO READ");
    }

    public function testNoBarcode(): void
    {
        $this->expectExceptionObject(new NoRackIdException());
        TecanScanner::parseRawContent("A1,FD13945423\nB1,FD32807353\nC1,NO READ\nD1,NO READ\nE1,NO READ\nF1,NO READ\nG1,NO READ\nH1,NO READ\nA2,NO READ\nB2,NO READ\nC2,NO READ\nD2,NO READ\nE2,NO READ\nF2,NO READ\nG2,NO READ\nH2,NO READ\nA3,NO READ\nB3,NO READ\nC3,NO READ\nD3,NO READ\nE3,NO READ\nF3,NO READ\nG3,NO READ\nH3,NO READ\nA4,NO READ\nB4,NO READ\nC4,NO READ\nD4,NO READ\nE4,NO READ\nF4,NO READ\nG4,NO READ\nH4,NO READ\nA5,NO READ\nB5,NO READ\nC5,NO READ\nD5,NO READ\nE5,NO READ\nF5,NO READ\nG5,NO READ\nH5,NO READ\nA6,NO READ\nB6,NO READ\nC6,NO READ\nD6,NO READ\nE6,NO READ\nF6,NO READ\nG6,NO READ\nH6,NO READ\nA7,NO READ\nB7,NO READ\nC7,NO READ\nD7,NO READ\nE7,NO READ\nF7,NO READ\nG7,NO READ\nH7,NO READ\nA8,NO READ\nB8,NO READ\nC8,NO READ\nD8,NO READ\nE8,NO READ\nF8,NO READ\nG8,NO READ\nH8,NO READ\nA9,NO READ\nB9,NO READ\nC9,NO READ\nD9,NO READ\nE9,NO READ\nF9,NO READ\nG9,NO READ\nH9,NO READ\nA10,NO READ\nB10,NO READ\nC10,NO READ\nD10,NO READ\nE10,NO READ\nF10,NO READ\nG10,NO READ\nH10,NO READ\nA11,NO READ\nB11,NO READ\nC11,NO READ\nD11,NO READ\nE11,NO READ\nF11,NO READ\nG11,NO READ\nH11,NO READ\nA12,NO READ\nB12,NO READ\nC12,NO READ\nD12,NO READ\nE12,NO READ\nF12,NO READ\nG12,NO READ\nH12,NO READ");
    }

    public function testSuccess(): void
    {
        $fluidXPlate = TecanScanner::parseRawContent("rackid,SA00411242\nA1,FD13945423\nB1,FD32807353\nC1,NO READ\nD1,NO READ\nE1,NO READ\nF1,NO READ\nG1,NO READ\nH1,NO READ\nA2,NO READ\nB2,NO READ\nC2,NO READ\nD2,NO READ\nE2,NO READ\nF2,NO READ\nG2,NO READ\nH2,NO READ\nA3,NO READ\nB3,NO READ\nC3,NO READ\nD3,NO READ\nE3,NO READ\nF3,NO READ\nG3,NO READ\nH3,NO READ\nA4,NO READ\nB4,NO READ\nC4,NO READ\nD4,NO READ\nE4,NO READ\nF4,NO READ\nG4,NO READ\nH4,NO READ\nA5,NO READ\nB5,NO READ\nC5,NO READ\nD5,NO READ\nE5,NO READ\nF5,NO READ\nG5,NO READ\nH5,NO READ\nA6,NO READ\nB6,NO READ\nC6,NO READ\nD6,NO READ\nE6,NO READ\nF6,NO READ\nG6,NO READ\nH6,NO READ\nA7,NO READ\nB7,NO READ\nC7,NO READ\nD7,NO READ\nE7,NO READ\nF7,NO READ\nG7,NO READ\nH7,NO READ\nA8,NO READ\nB8,NO READ\nC8,NO READ\nD8,NO READ\nE8,NO READ\nF8,NO READ\nG8,NO READ\nH8,NO READ\nA9,NO READ\nB9,NO READ\nC9,NO READ\nD9,NO READ\nE9,NO READ\nF9,NO READ\nG9,NO READ\nH9,NO READ\nA10,NO READ\nB10,NO READ\nC10,NO READ\nD10,NO READ\nE10,NO READ\nF10,NO READ\nG10,NO READ\nH10,NO READ\nA11,NO READ\nB11,NO READ\nC11,NO READ\nD11,NO READ\nE11,NO READ\nF11,NO READ\nG11,NO READ\nH11,NO READ\nA12,NO READ\nB12,NO READ\nC12,NO READ\nD12,NO READ\nE12,NO READ\nF12,NO READ\nG12,NO READ\nH12,NO READ");

        self::assertCount(96, $fluidXPlate->wells());
        self::assertCount(94, $fluidXPlate->freeWells());
        self::assertSame('SA00411242', $fluidXPlate->rackId);

        self::assertSame([
            'A1' => 'FD13945423',
            'B1' => 'FD32807353',
        ], $fluidXPlate->filledWells()->toArray());
    }
}
