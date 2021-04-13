<?php

namespace App\Request\ParamConverter;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PatchConverter
 * @package App\Request\ParamConverter
 */
class PatchConverter implements ParamConverterInterface
{
    private SerializerInterface $serializer;
    private EntityManagerInterface $em;

    /**
     * PatchConverter constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool|void
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if (!$request->isMethod(Request::METHOD_PATCH)) {
            return;
        }

        $object = $this->em->getRepository($configuration->getClass())->find($request->attributes->get('id'));

        $this->serializer->deserialize(
            $request->getContent(),
            $configuration->getClass(),
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $object]
        );

        $request->attributes->set($configuration->getName(), $object);
    }

    /**
     * @param ParamConverter $configuration
     * @return bool|void
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === Transaction::class;
    }
}