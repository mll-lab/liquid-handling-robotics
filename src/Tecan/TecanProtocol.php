<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan;

use Carbon\Carbon;
use Composer\InstalledVersions;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\BreakCommand;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Command;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Comment;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\UsesTipMask;
use Mll\LiquidHandlingRobotics\Tecan\TipMask\TipMask;

final class TecanProtocol
{
    /**
     * Tecan software runs on Windows.
     */
    public const WINDOWS_NEW_LINE = "\r\n";

    public const GEMINI_WORKLIST_FILENAME_SUFFIX = '.gwl';
    public const PACKAGE_NAME = 'mll-lab/liquid-handling-robotics';

    /**
     * @var Collection<int, Command>
     */
    private Collection $commands;

    private TipMask $tipMask;

    private string $protocolName;

    public function __construct(TipMask $tipMask, string $protocolName = null, string $userName = null)
    {
        $this->protocolName = $protocolName ?? Str::uuid()->toString();
        $this->tipMask = $tipMask;

        $this->commands = $this->initHeader($userName, $protocolName);
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

    /**
     * @return Collection<int, Command>
     */
    private function initHeader(?string $userName, ?string $protocolName): Collection
    {
        $package = self::PACKAGE_NAME;
        $version = InstalledVersions::getPrettyVersion($package);

        $now = Carbon::now();

        /** @var Collection<int, Command> $commentCommands necessary due to contravariance issues with the generic collection */
        $commentCommands = new Collection([
            new Comment("Created by {$package} {$version}"),
            new Comment("Date: {$now}"),
        ]);

        if (null !== $userName) {
            $commentCommands->add(new Comment("User: {$userName}"));
        }
        if (null !== $protocolName) {
            $commentCommands->add(new Comment("Protocol name: {$protocolName}"));
        }

        return $commentCommands;
    }
}
