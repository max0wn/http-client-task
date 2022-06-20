<?php

namespace unit;

use Generator;
use HttpClientTask\HttpClient\CommentBuilder;
use HttpClientTask\HttpClient\CommentsHelper;
use PHPUnit\Framework\TestCase;

class CommentsHelperTest extends TestCase
{
    /**
     * @dataProvider toArrayData
     */
    public function testToArray(array $data, array $expected): void
    {
        self::assertEquals(CommentsHelper::toArray($data), $expected);
    }

    public function toArrayData(): Generator
    {
        yield [
            'data' => json_decode("{\"comments\": [{\"id\": 1, \"name\": \"name\", \"text\": \"text\"}]}", true)['comments'],
            'expected' => [
                (new CommentBuilder())
                    ->setId(1)
                    ->setName('name')
                    ->setText('text')
                    ->build(),
            ]
        ];
    }
}
