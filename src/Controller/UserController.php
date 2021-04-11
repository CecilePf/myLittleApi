<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * Get users list
     * 
     * @Route("/api/users", name="api_users", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     * 
     * @return JsonResponse
     */
    public function findAll(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $jsonResponse = $this->apiService->generateJsonResponse($users);

        return $jsonResponse;
    }
}
