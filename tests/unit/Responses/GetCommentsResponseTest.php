<?php

namespace unit\Responses;

use Generator;
use HttpClientTask\HttpClient\Comment;
use HttpClientTask\HttpClient\CommentBuilder;
use HttpClientTask\HttpClient\Responses\GetCommentsResponse;
use PHPUnit\Framework\TestCase;

class GetCommentsResponseTest extends TestCase
{
    /**
     * @dataProvider getCommentsData
     */
    public function testGetComments(int $id, string $name, string $text, array $expected): void
    {
        $comment = new Comment();
        $comment->setId($id);
        $comment->setName($name);
        $comment->setText($text);

        $response = new GetCommentsResponse([$comment]);

        self::assertEquals($response->getComments(), $expected);
    }

    /**
     * @return Generator
     */
    public function getCommentsData(): Generator
    {
        yield [
            'id' => 1,
            'name' => 'name',
            'text' => 'text',
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
