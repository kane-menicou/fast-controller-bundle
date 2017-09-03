<?php

namespace KaneMenicou\FastControllerBundle\Twig\Extension;

use KaneMenicou\FastControllerBundle\Retriever\DoctrineIdRetriever;
use KaneMenicou\FastControllerBundle\Transformer\EntityTransformer;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class EntityTransversingExtension extends \Twig_Extension
{
    /**
     * @var EntityTransformer
     */
    private $entityTransformer;
    /**
     * @var DoctrineIdRetriever
     */
    private $doctrineIdRetriever;

    /**
     * @param EntityTransformer $entityTransformer
     */
    public function __construct(EntityTransformer $entityTransformer, DoctrineIdRetriever $doctrineIdRetriever)
    {
        $this->entityTransformer = $entityTransformer;
        $this->doctrineIdRetriever = $doctrineIdRetriever;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('getEntitiesProperties', [$this, 'getEntitiesProperties']),
        ];
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('shortName', [$this, 'getEntityName']),
            new Twig_SimpleFilter('id', [$this, 'getId']),
        ];
    }

    /**
     * @param object $entity
     *
     * @return array
     */
    public function getEntitiesProperties($entity): array
    {
        return $this->entityTransformer->transform($entity);
    }

    /**
     * @param $entity
     *
     * @return string
     */
    public function getEntityName($entity)
    {
        $reflection = new \ReflectionClass($entity);

        return $reflection->getShortName();
    }

    /**
     * @param $entity
     *
     * @return int|string
     */
    public function getId($entity)
    {
        return $this->doctrineIdRetriever->getIdForEntity($entity);
    }
}
