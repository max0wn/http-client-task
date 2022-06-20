<?php

namespace unit\Responses;

use Generator;
use HttpClientTask\HttpClient\Responses\PostCommentResponse;
use PHPUnit\Framework\TestCase;

class PostCommentResponseTest extends TestCase
{
    /**
     * @dataProvider isSuccessData
     */
    public function testIsSuccess(bool $isSuccess, bool $expected): void
    {
        $response = new PostCommentResponse($isSuccess);

        self::assertEquals($response->isSuccess(), $expected);
    }

    public function isSuccessData(): Generator
    {
        yield [
            'isSuccess' => true,
            'expected' => true,
        ];
    }
}
