<?php

namespace App\Controller;

use App\Domain\musicProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api")
 */
class SpotifyController extends AbstractController
{
    /**
    * @Route("/releases", name="last_releases", methods={"GET"}, options={"expose" = true})
    */
    public function releases(musicProvider $musicProvider): JsonResponse
    {
        return new JsonResponse($musicProvider->lastReleases());
    }

    /**
     * @Route("/artist/{id}", name="artist_detail", methods={"GET"}, options={"expose" = true})
     */
    public function artist(musicProvider $musicProvider, $id): JsonResponse
    {
        return new JsonResponse($musicProvider->artist($id));
    }

    /**
     * @Route("/artist/{id}/top-tracks", name="artist_top_tracks", methods={"GET"}, options={"expose" = true})
     */
    public function artistTopTracks(musicProvider $musicProvider, $id): JsonResponse
    {
        return new JsonResponse($musicProvider->artistTopTracks($id));
    }
}