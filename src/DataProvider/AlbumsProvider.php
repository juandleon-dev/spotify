<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\ApiPlatform\AlbumArtistFilter;
use App\Domain\musicRepository;
use App\Entity\Album;
use App\Entity\Cover;

class AlbumsProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var musicRepository
     */
    private $musicRepository;

    public function __construct(musicRepository $musicRepository)
    {
        $this->musicRepository = $musicRepository;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Album::class;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): array
    {
        $result = $this->musicRepository->searchAlbumsByArtist(
            $context[AlbumArtistFilter::Q_FILTER_CONTEXT],
            $context[AlbumArtistFilter::LIMIT_FILTER_CONTEXT] ?? AlbumArtistFilter::DEFAULT_LIMIT_PER_PAGE,
            $context[AlbumArtistFilter::PAGE_FILTER_CONTEXT] ?? AlbumArtistFilter::DEFAULT_PAGE
        );

        $albums = [];
        $items = $result['albums']['items'];
        foreach ($items as $item) {
            $image = $item['images'][0];
            $cover = Cover::create($image['height'], $image['width'], $image['url']);
            $albums[] = Album::create($item['id'], $item['name'], $item['release_date'], $item['total_tracks'], $cover);
        }

        return $albums;
    }
}