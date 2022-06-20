<?php

namespace HttpClientTask\HttpClient;

class CommentsHelper
{
    public static function toArray(array $data): array
    {
        $comments = [];

        foreach ($data as $row) {
            $comment = new Comment();

            foreach (Comment::KEYS as $key) {
                $comment->$key = $row[$key];
            }

            $comments[] = $comment;
        }

        return $comments;
    }
}
