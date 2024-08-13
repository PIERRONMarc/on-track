<?php

namespace App\Controller\Spotify;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spotify/callback', name: 'spotify_callback')]
class Callback
{
    public function __construct(
        private readonly ClientRegistry $clientRegistry,
        private readonly ParameterBagInterface $parameterBag
    ) {}

    public function __invoke(): Response
    {
        $client = $this->clientRegistry->getClient('spotify');
        $frontUrl = $this->buildFrontUrl($client->getAccessToken());

        return new RedirectResponse($frontUrl);
    }

    private function buildFrontUrl(AccessTokenInterface $accessToken): string
    {
        $query = http_build_query([
            'service' => 'spotify',
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
        ]);

        return sprintf('%s?%s', $this->parameterBag->get('front_url'), $query);
    }
}
