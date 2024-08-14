<?php

namespace App\Controller\Strava;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/strava/connect', name: 'strava_connect')]
class Connect
{
    public function __construct(private readonly ClientRegistry $clientRegistry) {}

    public function __invoke(): Response
    {
        return $this->clientRegistry
            ->getClient('strava')
            ->redirect([
                'activity:read_all',
            ])
        ;
    }
}
