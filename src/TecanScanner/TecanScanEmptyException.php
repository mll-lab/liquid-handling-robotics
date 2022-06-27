<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\TecanScanner;

class TecanScanEmptyException extends TecanScanException
{
    public function __construct()
    {
        parent::__construct('Empty scan content');
    }
}
