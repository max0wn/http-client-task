<?php

namespace unit;

use Generator;
use HttpClientTask\HttpClient\Comment;
use HttpClientTask\HttpClient\CommentBuilder;
use PHPUnit\Framework\TestCase;

class CommentBuilderTest extends TestCase
{
    /**
     * @dataProvider buildData
     */
    public function testBuild(
        int $id,
        string $name,
        string $text,
    ): void {
        $comment = (new CommentBuilder())
            ->setId($id)
            ->setName($name)
            ->setText($text)
            ->build();

        $expected = new Comment();
        $expected->setId($id);
        $expected->setName($name);
        $expected->setText($text);

        self::assertEquals($expected, $comment);
    }

    public function buildData(): Generator
    {
        yield [
            'id' => 1,
            'name' => 'name',
            'text' => 'text'
        ];
    }
}