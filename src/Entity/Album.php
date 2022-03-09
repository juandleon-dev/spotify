<?php

namespace App\Entity;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\ApiPlatform\AlbumArtistFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get" = {
 *              "method"="GET",
 *              "controller"=NotFoundAction::class,
 *              "read"=false,
 *              "outpou"=false
 *          }
 *     },
 *     normalizationContext={"groups"="album:read"},
 *     collectionOperations={"get"},
 *     routePrefix="/v1"
 * )
 * @ApiFilter(AlbumArtistFilter::class)
 */
final class Album
{
    private $id;

    /** @Groups({"album:read"}) */
    private $name;

    /** @Groups({"album:read"}) */
    private $released;

    /** @Groups({"album:read"}) */
    private $tracks;

    /** @Groups({"album:read"}) */
    private $cover;

    protected function __construct(string $id, string $name, string $released, int $tracks, Cover $cover)
    {
        $this->id = $id;
        $this->name = $name;
        $this->released = $released;
        $this->tracks = $tracks;
        $this->cover = $cover;
    }

    public static function create(string $id, string $name, string $released, int $tracks, Cover $cover): self
    {
        return new self($id, $name, $released, $tracks, $cover);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getReleased(): string
    {
        return $this->released;
    }

    /**
     * @return int
     */
    public function getTracks(): int
    {
        return $this->tracks;
    }

    /**
     * @return array
     */
    public function getCover(): array
    {
        return [
            'height' => $this->cover->getHeight(),
            'width' => $this->cover->getWidth(),
            'url' => $this->cover->getUrl()
        ];
    }
}