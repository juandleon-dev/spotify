<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

final class Cover
{
    private $height;

    private $width;

    private $url;

    protected function __construct(int $height, int $width, string $url)
    {
        $this->height = $height;
        $this->width = $width;
        $this->url = $url;
    }

    public static function create(int $height, int $width, string $url): self
    {
        return new self($height, $width, $url);
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}