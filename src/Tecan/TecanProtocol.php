<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan;

use Illuminate\Support\Collection;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\BreakCommand;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Command;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\PipettingActionCommand;
use Mll\LiquidHandlingRobotics\Tecan\TipMask\TipMask;

final class TecanProtocol
{
    /**
     * Tecan software runs on Windows.
     */
    public const WINDOWS_NEW_LINE = "\r\n";

    /**
     * @var Collection<int, Command>
     */
    private Collection $commands;

    private TipMask $tipMask;

    public function __construct(TipMask $tipMask)
    {
        $this->commands = new Collection([]);
        $this->tipMask = $tipMask;
    }

    public function addCommandCurrentTip(PipettingActionCommand $command): void
    {
        $command->setTipMask($this->tipMask->currentTip ?? TipMask::firstTip());
        $this->commands->add($command);
    }

    public function addCommandForNextTip(PipettingActionCommand $command): void
    {
        if ($this->tipMask->isLastTip()) {
            $this->commands->add(new BreakCommand());
        }

        $command->setTipMask($this->tipMask->nextTip());
        $this->commands->add($command);
    }

    public function buildProtocol(): string
    {
        return $this->commands
            ->map(fn (Command $command): string => $command->toString())
            ->join(self::WINDOWS_NEW_LINE)
            . self::WINDOWS_NEW_LINE;
    }
}
