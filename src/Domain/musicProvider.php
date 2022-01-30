<?php

namespace App\Domain;

interface musicProvider
{
    public function lastReleases(): array;

    public function artist(string $id): array;

    public function artistTopTracks(string $id): array;
}