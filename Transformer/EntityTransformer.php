<?php

namespace KaneMenicou\FastControllerBundle\Transformer;

use KaneMenicou\FastControllerBundle\Helper\StringHelper;
use KaneMenicou\FastControllerBundle\Model\ApiResponseTransformerInterface;

class EntityTransformer
{
    /**
     * @var \ReflectionClass
     */
    private $reflectedEntity;

    /**
     * @var array
     */
    private $entityProperties = [];

    /**
     * @var object
     */
    private $originalEntity;

    /**
     * @var string[]
     */
    private $excludedFields;

    /**
     * @param object $entity
     * @param ApiResponseTransformerInterface|null $responseTransformer
     * @param array $excludedFields
     *
     * @return array|string
     */
    public function transform(
        $entity,
        ApiResponseTransformerInterface $responseTransformer = null,
        array $excludedFields = []
    )
    {
        $this->excludedFields = $excludedFields;

        $this->originalEntity = $entity;
        $this->reflectedEntity = new \ReflectionClass($entity);

        $this->getValOfAllProps($this->reflectedEntity->getProperties());

        if ($responseTransformer !== null) {
            return $responseTransformer->transform($this->entityProperties);
        }

        return $this->entityProperties;
    }

    /**
     * @param array $properties
     */
    private function getValOfAllProps(array $properties)
    {
        $propertyName = $properties[0]->getName();

        $property = $this->reflectedEntity->getProperty($propertyName);

        $cannotAccessProperty = $property->isPrivate() || $property->isProtected();

        if ($cannotAccessProperty) {
            $property->setAccessible(true);
        }

        $value = $property->getValue($this->originalEntity);

        if (
            !in_array($propertyName, $this->excludedFields) &&
            !in_array(StringHelper::getAsSnakeCase($propertyName), $this->excludedFields)
        ) {
            $this->entityProperties = array_merge(
                $this->entityProperties,
                [StringHelper::getAsSnakeCase($propertyName) => $value]
            );
        }

        if ($cannotAccessProperty) {
            $property->setAccessible(false);
        }

        array_shift($properties);

        if ($properties === [] || $properties === null) {
            return;
        }

        $this->getValOfAllProps($properties);
    }
}