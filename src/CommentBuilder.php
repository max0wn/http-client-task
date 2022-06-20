<?php

namespace HttpClientTask\HttpClient;

class CommentBuilder
{
    private Comment $comment;

    public function __construct()
    {
        $this->comment = new Comment();
    }

    public function setId(int $id): self
    {
        $this->comment->setId($id);
        return $this;
    }

    public function setName(string $name): self
    {
        $this->comment->setName($name);
        return $this;
    }

    public function setText(string $text): self
    {
        $this->comment->setText($text);
        return $this;
    }

    public function build(): Comment
    {
        return $this->comment;
    }
}
