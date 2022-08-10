<?php declare(strict_types=1);

namespace Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Comment;
use PHPUnit\Framework\TestCase;

final class CommentTest extends TestCase
{
    public function testFormatToString(): void
    {
        $text = 'foo. bar';
        $comment = new Comment($text);

        self::assertSame("C;$text", $comment->formatToString());
    }
}
