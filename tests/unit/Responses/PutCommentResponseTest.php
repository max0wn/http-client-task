<?php

namespace unit\Responses;

use Generator;
use HttpClientTask\HttpClient\Responses\PutCommentResponse;
use PHPUnit\Framework\TestCase;

class PutCommentResponseTest extends TestCase
{
    /**
     * @dataProvider isSuccessData
     */
    public function testIsSuccess(bool $isSuccess, bool $expected): void
    {
        $response = new PutCommentResponse($isSuccess);

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
