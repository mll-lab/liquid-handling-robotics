<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\FluidXPlate;

use Illuminate\Support\Str;
use Mll\Microplate\Coordinate;
use Mll\Microplate\CoordinateSystem96Well;
use MLL\Utils\StringUtil;

/**
 * Communicates with a FluidX scanner device and fetches results from it.
 */
class FluidXScanner
{
    private const READING = 'Reading...';
    private const XTR_96_CONNECTED = 'xtr-96 Connected';
    private const NO_READ = 'NO READ';
    private const NO_TUBE = 'NO TUBE';
    public const TEST_IP = '127.0.0.1';

    public function scanPlate(string $ip): FluidXPlate
    {
        if (self::TEST_IP === $ip) {
            return self::returnTestPlate();
        }

        if ('' === $ip) {
            throw new ScanFluidXPlateException('Cannot start scan request without a IP address');
        }

        try {
            $socket = \Safe\fsockopen($ip, 8001, $errno, $errstr, 30);
        } catch (\Throwable $e) {
            throw new ScanFluidXPlateException("Cannot reach FluidX Scanner {$ip}: {$e->getMessage()}. Verify that the FluidX Scanner is turned on and the FluidX software is started.", 0, $e);
        }

        \Safe\fwrite($socket, "get\r\n");

        $answer = '';
        do {
            $content = fgets($socket);
            $answer .= $content;
        } while (is_string($content) && ! Str::contains($content, 'H12'));

        \Safe\fclose($socket);

        return self::parseRawContent($answer);
    }

    public static function parseRawContent(string $rawContent): FluidXPlate
    {
        if ('' === $rawContent) {
            throw new ScanFluidXPlateException('Der Scanner lieferte ein leeres Ergebnis zurück.');
        }

        $lines = StringUtil::splitLines($rawContent);
        $barcodes = [];
        $id = null;
        foreach ($lines as $line) {
            if ('' !== $line
                && self::READING !== $line
                && self::XTR_96_CONNECTED !== $line
            ) {
                $content = explode(', ', $line);

                if (count($content) > 3) {
                    // All valid lines contain the same plate barcode
                    $id = $content[3];
                    if (FluidXScanner::NO_READ === $id && isset($content[4])) {
                        $id = $content[4];
                    }

                    $barcodeScanResult = $content[1];
                    $coordinateString = $content[0];
                    if (self::NO_READ !== $barcodeScanResult
                        && self::NO_TUBE !== $barcodeScanResult
                    ) {
                        $barcodes[$coordinateString] = $barcodeScanResult;
                    }
                }
            }
        }

        if (is_null($id)) {
            throw new ScanFluidXPlateException('Der Scanner lieferte keinen Plattenbarcode zurück.');
        }

        $plate = new FluidXPlate($id);
        foreach ($barcodes as $coordinate => $barcode) {
            $plate->addWell(Coordinate::fromString($coordinate, new CoordinateSystem96Well()), $barcode);
        }

        if (FluidXScanner::NO_READ === $id) {
            if ([] === $barcodes) {
                throw new ScanFluidXPlateException(
                    'Weder Platten-Barcode noch Tube-Barcodes konnten gescannt werden. Bitte überprüfen Sie, dass die Platte korrekt in den FluidX-Scanner eingelegt wurde.'
                );
            }
            throw new ScanFluidXPlateException('Platten-Barcode konnte nicht gescannt werden. Bitte überprüfen Sie, dass die Platte mit der korrekten Orientierung in den FluidX-Scanner eingelegt wurde.');
        }

        return $plate;
    }

    private static function returnTestPlate(): FluidXPlate
    {
        return self::parseRawContent(\Safe\file_get_contents(__DIR__ . '/TestPlate.txt'));
    }
}
