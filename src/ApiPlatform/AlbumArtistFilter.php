<?php

namespace App\ApiPlatform;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

class AlbumArtistFilter implements FilterInterface
{
    public const Q_FILTER_CONTEXT = 'album_artist_q';
    public const LIMIT_FILTER_CONTEXT = 'album_limit';
    public const PAGE_FILTER_CONTEXT = 'album_page';

    public const DEFAULT_LIMIT_PER_PAGE = 20;
    public const DEFAULT_PAGE = 1;

    public function apply(Request $request, bool $normalization, array $attributes, array &$context)
    {
        $q = $request->query->get('q');
        $limit = $request->query->get('limit', self::DEFAULT_LIMIT_PER_PAGE);
        $page = $request->query->get('page', self::DEFAULT_PAGE);

        if (!$q) {
            return;
        }

        $context[self::Q_FILTER_CONTEXT] = $q;
        $context[self::LIMIT_FILTER_CONTEXT] = $limit;
        $context[self::PAGE_FILTER_CONTEXT] = $page;
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'q' => [
                'property' => null,
                'type' => 'string',
                'required' => true,
                'openapi' => [
                    'description' => 'Search Album by Artist Name'
                ]
            ],
            'limit' => [
                'property' => null,
                'type' => 'int',
                'required' => false,
                'openapi' => [
                    'description' => 'Max results per page'
                ]
            ],
            'page' => [
                'property' => null,
                'type' => 'int',
                'required' => false,
                'openapi' => [
                    'description' => 'Page'
                ]
            ],
        ];
    }
}