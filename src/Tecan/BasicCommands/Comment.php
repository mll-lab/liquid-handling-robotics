<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

final class Comment extends Command
{
    private string $comment;

    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    public function toString(): string
    {
        return "C;{$this->comment}";
    }
}
