<?php

namespace HttpClientTask\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use HttpClientTask\HttpClient\Exceptions\BadRequestException;
use HttpClientTask\HttpClient\Responses\GetCommentsResponse;
use HttpClientTask\HttpClient\Responses\PostCommentResponse;
use HttpClientTask\HttpClient\Responses\PutCommentResponse;

class HttpClient
{
    /** @var string */
    private const URL = 'http://example.com';

    /** @var int */
    private const HTTP_OK = 200;

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws BadRequestException
     */
    public function getComments(): GetCommentsResponse
    {
        $url = sprintf('%s/comments', self::URL);

        try {
            $response = $this->client->get($url);
        } catch (GuzzleException $e) {
            throw new BadRequestException(
                'failed to get comments'
            );
        }

        if ($response->getStatusCode() === self::HTTP_OK) {
            $body = json_decode($response->getBody(), true)[Comment::KEY_DATA];
            return new GetCommentsResponse(CommentsHelper::toArray($body));
        }

        return new GetCommentsResponse([]);
    }

    /**
     * @throws BadRequestException
     */
    public function postComment(Comment $comment): PostCommentResponse
    {
        $url = sprintf('%s/comment', self::URL);

        try {
            $response = $this->client->post($url, [
                'query' => [
                    'name' => $comment->getName(),
                    'text' => $comment->getText(),
                ]
            ]);
        } catch (GuzzleException $e) {
            throw new BadRequestException(
                'failed to post comment'
            );
        }

        if ($response->getStatusCode() !== self::HTTP_OK) {
            return new PostCommentResponse(false);
        }

        return new PostCommentResponse(true);
    }

    /**
     * @throws BadRequestException
     */
    public function putComment(Comment $comment): PutCommentResponse
    {
        $url = sprintf(
            '%s/comment/%d',
            self::URL,
            $comment->getId()
        );

        try {
            $response = $this->client->put($url, [
                'name' => $comment->getName(),
                'text' => $comment->getText()
            ]);
        } catch (GuzzleException $e) {
            throw new BadRequestException(
                'failed to put comment'
            );
        }

        if ($response->getStatusCode() !== self::HTTP_OK) {
            return new PutCommentResponse(false);
        }

        return new PutCommentResponse(true);
    }
}
