<?php

namespace App\Controller;

use App\Domain\musicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api")
 */
class SpotifyController extends AbstractController
{
    /**
     * @Route("/artist/{name}", name="artist_detail", methods={"GET"}, options={"expose" = true})
     */
    public function albums(musicRepository $musicProvider, $name): JsonResponse
    {
        return new JsonResponse($musicProvider->searchAlbumsByArtist($name));
    }
}