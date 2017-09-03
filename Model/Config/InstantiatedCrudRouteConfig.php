<?php

namespace KaneMenicou\FastControllerBundle\Model\Config;

use KaneMenicou\FastControllerBundle\Model\Exception\MissingCrudConfiguration;

class InstantiatedCrudRouteConfig extends AbstractCrudRouteConfig
{
    /**
     * @var bool
     */
    private $api;

    /**
     * @var string
     */
    private $returnType;

    /**
     * @var string
     */
    private $entity;

    /**
     * @param array $config
     */
    public function __construct($config)
    {
        foreach ($config as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }

        $this->checkConfig();
    }

    /**
     * @throws MissingCrudConfiguration
     */
    private function checkConfig()
    {
        if ($this->entity === null) {
            throw new MissingCrudConfiguration('Route is missing configuration for the entity');
        }

        if ($this->api === null) {
            throw new MissingCrudConfiguration(
                "Config 'API' for crud route is missing for the crud routes for entity $this->entity"
            );
        }

        if ($this->returnType === null) {
            throw new MissingCrudConfiguration(
                "Config 'return type' for crud route is missing for the crud routes for entity $this->entity"
            );
        }
    }

    /**
     * @return bool
     */
    public function isApi(): bool
    {
        return $this->api;
    }

    /**
     * @return string
     */
    public function getReturnType(): ?string
    {
        return $this->returnType;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }
}
