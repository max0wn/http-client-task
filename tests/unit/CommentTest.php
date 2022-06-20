<?php

namespace unit;

use Generator;
use HttpClientTask\HttpClient\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    /**
     * @dataProvider getSetData
     */
    public function testGetSet(int $id, string $name, string $text): void
    {
        $comment = new Comment();

        $comment->setId($id);
        $comment->setName($name);
        $comment->setText($text);

        self::assertEquals($id, $comment->getId());
        self::assertEquals($name, $comment->getName());
        self::assertEquals($text, $comment->getText());
    }

    public function getSetData(): Generator
    {
        yield [
            'id' => 1,
            'name' => 'name',
            'text' => 'text'
        ];
    }
}