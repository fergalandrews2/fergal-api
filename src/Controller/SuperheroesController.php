<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Api\Superheroes\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuperheroesController extends AbstractController
{
    /**
     * @param ApiClient $apiClient
     * @return Response
     */
    #[Route('/api', name: 'all-heroes', methods: ['GET'])]
    public function getHeroes(ApiClient $apiClient): Response
    {
        return $apiClient->getAllHeroes();
    }

    /**
     * @param ApiClient $apiClient
     * @param Request $request
     * @return Response
     */
    #[Route('/api/add', 'add-hero', methods: ['POST'])]
    public function addHero(ApiClient $apiClient, Request $request): Response
    {
        return $apiClient->addHero($request);
    }

    /**
     * @param ApiClient $apiClient
     * @param int $id
     * @return Response
     */
    #[Route('api/hero/{id}', 'single-hero', methods: ['GET'])]
    public function getHero(ApiClient $apiClient, int $id): Response
    {
        return $apiClient->getHero($id);
    }

    /**
     * @param ApiClient $apiClient
     * @param Request $request
     * @param int $id
     * @return Response
     */
    #[Route('api/update/{id}', 'update-hero', methods: ['PUT'])]
    public function updateHero(ApiClient $apiClient, Request $request, int $id): Response
    {
        return $apiClient->updateHero($request, $id);
    }

    /**
     * @param ApiClient $apiClient
     * @param int $id
     * @return Response
     */
    #[Route('api/delete/{id}', 'delete-hero', methods: ['DELETE'])]
    public function deleteHero(ApiClient $apiClient, int $id): Response
    {
        return $apiClient->deleteHero($id);
    }
}