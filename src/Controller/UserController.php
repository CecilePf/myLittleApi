<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private ApiService $apiService;
    private UserRepository $userRepository;

    public function __construct(ApiService $apiService, UserRepository $userRepository)
    {
        $this->apiService = $apiService;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/api/users", name="api_users", methods={"GET"})
     */
    public function findAll(): Response
    {
        $users = $this->userRepository->findAll();
        $jsonResponse = $this->apiService->generateJsonResponse($users);

        return $jsonResponse;
    }
}
