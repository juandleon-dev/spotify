<?php

namespace App\Repository;

use App\Domain\musicRepository;
use App\Security\Exception\InvalidToken;
use App\Security\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpotifyRepository implements musicRepository
{
    const URI_SEARCH = '/search?q=artist:{artist}&type=album';

    /** @var HttpClientInterface */
    private $client;

    private $spotifyUrlRequest;

    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session, HttpClientInterface $client, $spotifyUrlRequest)
    {
        $this->session = $session;
        $this->client = $client;
        $this->spotifyUrlRequest = $spotifyUrlRequest;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws InvalidToken
     */
    public function searchAlbumsByArtist(string $artist): array
    {
        $uri = str_replace('{artist}', $artist, self::URI_SEARCH);
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('%s%s', $this->spotifyUrlRequest, $uri),
            [
                'headers' => [
                    $this->session->getAuthorizationHeader(),
                    'Content-Type: application/json'
                ]
            ]
        );

        return json_decode($response->getContent(), true);
    }
}