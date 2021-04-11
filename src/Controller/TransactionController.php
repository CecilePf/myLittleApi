<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Service\ApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TransactionController extends AbstractController
{
    private TransactionRepository $transactionRepository;
    private ApiService $apiService;
    private EntityManagerInterface $em;
    private ValidatorInterface $validator;

    public function __construct(
        TransactionRepository $transactionRepository,
        ApiService $apiService,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->apiService = $apiService;
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * Get transactions list
     * 
     * @Route("/api/transactions", name="api_transactions", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * 
     * @return JsonResponse
     */
    public function findAll(): JsonResponse
    {
        $transactions = $this->transactionRepository->findAll();

        return $this->apiService->generateJsonResponse($transactions);
    }

    /**
     * Create one transaction
     * 
     * @Route("/api/transaction", name="api_post_transaction", methods={"POST"})
     * @IsGranted("ROLE_USER")
     * 
     * @param Transaction $transaction
     * 
     * @return JsonResponse
     */
    public function create(Transaction $transaction): JsonResponse
    {
        $errors = $this->validator->validate($transaction);
        if ($errors->count() > 0) {
            return $this->apiService->generateJsonBadRequest($errors);
        }

        $this->em->persist($transaction);
        $this->em->flush();

        return $this->apiService->generateJsonResponse($transaction);
    }
}
