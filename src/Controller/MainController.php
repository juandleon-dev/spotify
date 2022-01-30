<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("lanzamientos", name="homepage", options={"expose" = true})
     */
    public function albumReleases(): Response
    {
        return $this->render(
            'releases.html.twig'
        );
    }

    /**
     * @Route("artista/{id}", name="artist" )
     */
    public function artist($id): Response
    {
        return $this->render(
            'artist.html.twig',
            [
                'id' => $id
            ]
        );
    }
}