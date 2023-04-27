<?php

declare(strict_types=1);

namespace App\Service\Api\Superheroes;

use App\Entity\Superheroes;
use App\Factory\JsonResponseFactory;
use App\Service\Api;
use App\Utility\ApiUtilities;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiClient
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly JsonResponseFactory $jsonResponseFactory,
        public ApiUtilities $apiUtilities
    ){}

    /**
     * @return Response
     */
    public function getAllHeroes(): Response
    {
        $repository = $this->entityManager->getRepository(Superheroes::class);

        $data = $repository->findAll();

        return $this->jsonResponseFactory->create((object)$data);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addHero(Request $request): Response
    {
        try {
            if (!$request->get('name') || !$request->get('slug')) {
                throw new Exception();
            }

            $superheroes = new Superheroes();
            $superheroes->setName($request->get('name'));
            $superheroes->setSlug($request->get('slug'));
            $superheroes->setCreated($this->apiUtilities->getDateTime());
            $this->entityManager->persist($superheroes);
            $this->entityManager->flush();

            $data = [
                'success' => 'Superhero added successfully!',
            ];

            return $this->jsonResponseFactory->create((object)$data);
        } catch(Exception) {
            $data = [
                'errors' => 'Data not valid',
            ];

            return $this->jsonResponseFactory->create((object)$data, 402);
        }
    }

    /**
     * @param int $id
     * @return Response
     */
    public function getHero(int $id): Response
    {
        $repository = $this->entityManager->getRepository(Superheroes::class);
        $hero = $repository->find($id);

        if (!$hero) {
            $data = [
                'errors' => 'Hero not found!',
            ];

            return $this->jsonResponseFactory->create((object)$data, 404);
        }

        return $this->jsonResponseFactory->create((object)$hero);
    }


    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateHero(Request $request, int $id): Response
    {
        try {
            $repository = $this->entityManager->getRepository(Superheroes::class);
            $hero = $repository->find($id);

            if (!$hero) {
                $data = [
                    'errors' => 'Hero not found!',
                ];

                return $this->jsonResponseFactory->create((object)$data, 404);
            }

            if (!$request->get('name') || !$request->get('slug')) {
                throw new Exception();
            }

            $hero->setName($request->get('name'));
            $hero->setSlug($request->get('slug'));
            $hero->setUpdated($this->apiUtilities->getDateTime());

            $this->entityManager->persist($hero);
            $this->entityManager->flush();

            $data = [
                'success' => 'Hero updated successfully!',
            ];

            return $this->jsonResponseFactory->create((object)$data);

        } catch (Exception) {
            $data = [
                'errors' => 'Data not valid!',
            ];

            return $this->jsonResponseFactory->create((object)$data, 422);
        }
    }

    /**
     * @param int $id
     * @return Response
     */
    public function deleteHero(int $id): Response
    {
        $repository = $this->entityManager->getRepository(Superheroes::class);
        $hero = $repository->find($id);

        if (!$hero) {
            $data = [
                'errors' => 'Hero not found!',
            ];

            return $this->jsonResponseFactory->create((object)$data, 404);
        }

        $this->entityManager->remove($hero);
        $this->entityManager->flush();

        $data = [
            'success' => 'Hero deleted!',
        ];

        return $this->jsonResponseFactory->create((object)$data);
    }
}