<?php

namespace HttpClientTask\HttpClient\Responses;

class PostCommentResponse
{
    private bool $isSuccess;

    public function __construct(bool $isSuccess)
    {
        $this->isSuccess = $isSuccess;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }
}
