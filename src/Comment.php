<?php

namespace HttpClientTask\HttpClient;

use JsonSerializable;

class Comment implements JsonSerializable
{
    /** @var string */
    public const KEY_DATA = 'comments';

    /** @var array */
    public const KEYS = [
        'id',
        'name',
        'text'
    ];

    private int $id;
    private string $name;
    private string $text;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function __set(string $name, $value): void
    {
        $this->$name = $value;
    }

    public function __get(string $name)
    {
        return $this->$name;
    }

    public function jsonSerialize(): array
    {
        $result = [
            'name' => $this->name,
            'text' => $this->text,
        ];

        if (isset($this->id)) {
            $result['id'] = $this->id;
        }

        return $result;
    }
}
