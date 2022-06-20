<?php

namespace unit;

use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use HttpClientTask\HttpClient\Comment;
use HttpClientTask\HttpClient\CommentBuilder;
use HttpClientTask\HttpClient\Exceptions\BadRequestException;
use HttpClientTask\HttpClient\HttpClient;
use HttpClientTask\HttpClient\Responses\GetCommentsResponse;
use HttpClientTask\HttpClient\Responses\PostCommentResponse;
use HttpClientTask\HttpClient\Responses\PutCommentResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpClientTest extends TestCase
{
    private Client $client;
    private HttpClient $httpClient;

    protected function setUp(): void
    {
        $this->client = $this->getMockBuilder(Client::class)
            ->onlyMethods(['get', 'post', 'put'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->httpClient = new HttpClient($this->client);
    }

    /**
     * @dataProvider getCommentsData
     * @throws BadRequestException
     */
    public function testGetComments(string $json, GetCommentsResponse $expected): void
    {
        $httpResponse = $this->getResponseInterfaceMock();

        $httpResponse
            ->method('getStatusCode')
            ->willReturn(200);

        $httpResponse
            ->method('getBody')
            ->willReturn($json);

        $this->client
            ->method('get')
            ->willReturn($httpResponse);

        $response = $this->httpClient->getComments();

        self::assertEquals($expected, $response);
    }

    public function getCommentsData(): Generator
    {
        yield 'not_empty_comments' => [
            'json' => "{\"comments\": [{\"id\": 1, \"name\": \"name\", \"text\": \"text\"}]}",
            'expected' => new GetCommentsResponse([
                (new CommentBuilder())
                    ->setId(1)
                    ->setName('name')
                    ->setText('text')
                    ->build(),
            ])
        ];
    }

    /**
     * @dataProvider getCommentsEmptyData
     * @throws BadRequestException
     */
    public function testGetCommentsEmpty(GetCommentsResponse $expected): void
    {
        $httpResponse = $this->getResponseInterfaceMock();

        $httpResponse
            ->method('getStatusCode')
            ->willReturn(404);

        $this->client
            ->method('get')
            ->willReturn($httpResponse);

        $response = $this->httpClient->getComments();

        self::assertEquals($expected, $response);
    }

    public function getCommentsEmptyData(): Generator
    {
        yield 'empty_comments' => [
            'expected' => new GetCommentsResponse([]),
        ];
    }

    public function testGetCommentsThrows(): void
    {
        $this->expectException(BadRequestException::class);

        $exception = $this->getExceptionMock();

        $this->client
            ->method('get')
            ->willThrowException($exception);

        $this->httpClient->getComments();
    }

    /**
     * @dataProvider postCommentData
     * @throws BadRequestException
     */
    public function testPostComment(
        int $statusCode,
        Comment $comment,
        PostCommentResponse $expected
    ): void {
        $httpResponse = $this->getResponseInterfaceMock();

        $httpResponse
            ->method('getStatusCode')
            ->willReturn($statusCode);

        $this->client
            ->method('post')
            ->willReturn($httpResponse);

        $response = $this->httpClient->postComment($comment);

        self::assertEquals($expected, $response);
    }

    public function postCommentData(): Generator
    {
        yield 'is_not_success' => [
            'status_code' => 404,
            'comment' => (new CommentBuilder())
                ->setId(1)
                ->setName('name')
                ->setText('text')
                ->build(),
            'expected' => new PostCommentResponse(false)
        ];

        yield 'is_success' => [
            'status_code' => 200,
            'comment' => (new CommentBuilder())
                ->setId(1)
                ->setName('name')
                ->setText('text')
                ->build(),
            'expected' => new PostCommentResponse(true)
        ];
    }

    /**
     * @dataProvider postCommentThrowsData
     */
    public function testPostCommentThrows(Comment $comment): void
    {
        $this->expectException(BadRequestException::class);

        $exception = $this->getExceptionMock();

        $this->client
            ->method('post')
            ->willThrowException($exception);

        $this->httpClient->postComment($comment);
    }

    public function postCommentThrowsData(): Generator
    {
        yield [
            'comment' => (new CommentBuilder())
                ->setId(1)
                ->setText('text')
                ->setName('name')
                ->build()
        ];
    }

    /**
     * @dataProvider putCommentData
     * @throws BadRequestException
     */
    public function testPutComment(
        int $statusCode,
        Comment $comment,
        PutCommentResponse $expected
    ): void {
        $httpResponse = $this->getResponseInterfaceMock();

        $httpResponse
            ->method('getStatusCode')
            ->willReturn($statusCode);

        $this->client
            ->method('put')
            ->willReturn($httpResponse);

        $response = $this->httpClient->putComment($comment);

        self::assertEquals($expected, $response);
    }

    public function putCommentData(): Generator
    {
        yield 'is_not_success' => [
            'status_code' => 404,
            'comment' => (new CommentBuilder())
                ->setId(1)
                ->setName('name')
                ->setText('text')
                ->build(),
            'expected' => new PutCommentResponse(false)
        ];

        yield 'is_success' => [
            'status_code' => 200,
            'comment' => (new CommentBuilder())
                ->setId(1)
                ->setName('name')
                ->setText('text')
                ->build(),
            'expected' => new PutCommentResponse(true)
        ];
    }

    /**
     * @dataProvider putCommentThrowsData
     */
    public function testPutCommentThrows(Comment $comment): void
    {
        $this->expectException(BadRequestException::class);

        $exception = $this->getExceptionMock();

        $this->client
            ->method('put')
            ->willThrowException($exception);

        $this->httpClient->putComment($comment);
    }

    public function putCommentThrowsData(): Generator
    {
        yield [
            'comment' => (new CommentBuilder())
                ->setId(1)
                ->setText('text')
                ->setName('name')
                ->build()
        ];
    }

    public function getExceptionMock(): MockObject|Throwable
    {
        return $this->getMockBuilder(GuzzleException::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function getResponseInterfaceMock(): MockObject|ResponseInterface
    {
        return $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getBody',
                'getStatusCode',
                'withStatus',
                'getReasonPhrase',
                'getProtocolVersion',
                'withProtocolVersion',
                'getHeaders',
                'hasHeader',
                'getHeader',
                'getHeaderLine',
                'withHeader',
                'withAddedHeader',
                'withoutHeader',
                'withBody'
            ])
            ->getMock();
    }
}
