<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\TecanScanner;

final class NoRackIdException extends TecanScanException
{
    public function __construct()
    {
        parent::__construct('No valid rack ID scanned');
    }
}
