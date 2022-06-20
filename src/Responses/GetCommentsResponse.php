<?php

namespace HttpClientTask\HttpClient\Responses;

class GetCommentsResponse
{
    private array $comments;

    public function __construct(array $comments)
    {
        $this->comments = $comments;
    }

    public function getComments(): array
    {
        return $this->comments;
    }
}
