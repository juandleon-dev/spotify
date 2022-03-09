<?php

namespace App\Domain;

interface musicRepository
{
    public function searchAlbumsByArtist(string $artist, int $limit = 20, $page = 1): array;
}