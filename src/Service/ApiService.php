<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ApiService {

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param mixed $response
     */
    public function generateJsonResponse($data)
    {
        return new JsonResponse(
            $this->serializer->serialize($data, 'json'),
            JsonResponse::HTTP_OK, [],
            true
        );
    }

    /**
     * @param ConstraintViolationListInterface $errors
     */
    public function generateJsonBadRequest(ConstraintViolationListInterface $errors)
    {
        return new JsonResponse(
            $this->serializer->serialize($errors, 'json'),
            JsonResponse::HTTP_BAD_REQUEST, [],
            true
        );
    }
}