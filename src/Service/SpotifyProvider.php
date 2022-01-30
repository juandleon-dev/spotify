<?php

namespace App\Service;

use App\Domain\musicProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpotifyProvider implements musicProvider
{
    const URI_RELEASES = '/browse/new-releases';
    const URI_ARTIST = '/artists/';
    const URI_ARTIST_ALBUMS = '/artists/{id}/top-tracks?market=CO';

    /**
     * @var HttpClientInterface
     */
    private $client;
    private $spotifyUrlRequest;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Router
     */
    private $router;

    public function __construct(Session $session, HttpClientInterface $client, $spotifyUrlRequest, UrlGeneratorInterface $router)
    {
        $this->session = $session;
        $this->client = $client;
        $this->spotifyUrlRequest = $spotifyUrlRequest;
        $this->router = $router;
    }

    /**
     * @return array
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception\InvalidToken
     */
    public function lastReleases(): array
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('%s%s', $this->spotifyUrlRequest, self::URI_RELEASES),
            [
                'headers' => [
                    Session::authorizationHeader($this->session->token()),
                    'Content-Type: application/json'
                ]
            ]
        );

        $albums = json_decode($response->getContent(), true);

        $albumList = [];
        $key = 0;
        foreach ($albums['albums']['items'] as $album) {
            $albumList[$key]['image'] = $album['images'][0]['url'];
            $albumList[$key]['name'] = $album['name'];

            $keyArtist = 0;
            foreach ($album['artists'] as $artist) {
                $albumList[$key]['artists'][$keyArtist]['name'] = $artist['name'];
                $albumList[$key]['artists'][$keyArtist]['url'] = $this->router->generate('artist', ['id' => $artist['id']], UrlGeneratorInterface::ABSOLUTE_URL);
                $keyArtist++;
            }
            $key++;
        }

        return $albumList;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception\InvalidToken
     */
    public function artist(string $id): array
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('%s%s%s', $this->spotifyUrlRequest, self::URI_ARTIST, $id),
            [
                'headers' => [
                    Session::authorizationHeader($this->session->token()),
                    'Content-Type: application/json'
                ]
            ]
        );
        $artist = json_decode($response->getContent(), true);

        return [
            'name' => $artist['name'],
            'image' => $artist['images'][0]['url']
        ];
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception\InvalidToken
     */
    public function artistTopTracks(string $id): array
    {
        $uri = str_replace('{id}', $id, self::URI_ARTIST_ALBUMS);
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('%s%s', $this->spotifyUrlRequest, $uri),
            [
                'headers' => [
                    Session::authorizationHeader($this->session->token()),
                    'Content-Type: application/json'
                ]
            ]
        );

        $topTracks = json_decode($response->getContent(), true);

        $topTrackList = [];
        $key = 0;
        foreach ($topTracks['tracks'] as $topTrack) {
            $topTrackList[$key]['image'] = $topTrack['album']['images'][0]['url'];
            $topTrackList[$key]['album'] = $topTrack['album']['name'];
            $topTrackList[$key]['song'] = $topTrack['name'];
            $key++;
        }

        return $topTrackList;
    }
}