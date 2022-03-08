<?php

namespace App\Domain;

interface musicRepository
{
    public function searchAlbumsByArtist(string $artist): array;
}