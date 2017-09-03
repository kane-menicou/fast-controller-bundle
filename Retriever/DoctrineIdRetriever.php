<?php

namespace KaneMenicou\FastControllerBundle\Retriever;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineIdRetriever
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param $entity
     *
     * @return string
     */
    public function getIdForEntity($entity)
    {
        $meta = $this->em->getClassMetadata(get_class($entity));

        $identifier = $meta->getSingleIdentifierFieldName();

        return $this->getPropertyFromEntity($entity, $identifier);
    }

    /**
     * @param $entity
     * @param string $propertyName
     *
     * @return mixed
     */
    private function getPropertyFromEntity($entity, string $propertyName)
    {
        $reflectionClass = new \ReflectionClass($entity);

        $property = $reflectionClass->getProperty($propertyName);

        if ($property->isPrivate() || $property->isProtected()) {
            $property->setAccessible(true);
        }

        return $property->getValue($entity);
    }
}
