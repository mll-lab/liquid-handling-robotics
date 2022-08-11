<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\BreakCommand;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Command;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\UsesTipMask;
use Mll\LiquidHandlingRobotics\Tecan\TipMask\TipMask;

final class TecanProtocol
{
    /**
     * Tecan software runs on Windows.
     */
    public const WINDOWS_NEW_LINE = "\r\n";

    public const GEMINI_WORKLIST_FILENAME_SUFFIX = '.gwl';

    /**
     * @var Collection<int, Command>
     */
    private Collection $commands;

    private TipMask $tipMask;

    private string $protocolName;

    public function __construct(TipMask $tipMask, string $protocolName = null)
    {
        $this->commands = new Collection([]);
        $this->tipMask = $tipMask;
        $this->protocolName = $protocolName ?? Str::uuid()->toString();
    }

    public function addCommand(Command $command): void
    {
        $this->commands->add($command);
    }

    /**
     * @param Command&UsesTipMask $command
     */
    public function addCommandCurrentTip(Command $command): void
    {
        $command->setTipMask($this->tipMask->currentTip ?? TipMask::firstTip());

        $this->commands->add($command);
    }

    /**
     * @param Command&UsesTipMask $command
     */
    public function addCommandForNextTip(Command $command): void
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

    public function fileName(): string
    {
        return $this->protocolName . self::GEMINI_WORKLIST_FILENAME_SUFFIX;
    }
}
