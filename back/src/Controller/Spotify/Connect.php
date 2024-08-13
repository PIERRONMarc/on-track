<?php

namespace App\Controller\Spotify;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spotify/connect', name: 'spotify_connect')]
class Connect
{
    public function __construct(private readonly ClientRegistry $clientRegistry) {}

    public function __invoke(): Response
    {
        return $this->clientRegistry
            ->getClient('spotify')
            ->redirect([
                'playlist-read-private',
                'playlist-read-collaborative',
                'playlist-modify-public',
            ])
        ;
    }
}
