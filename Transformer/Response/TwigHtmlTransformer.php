<?php

namespace KaneMenicou\FastControllerBundle\Transformer\Response;

use KaneMenicou\FastControllerBundle\Model\ViewResponseTransformerInterface;

class TwigHtmlTransformer implements ViewResponseTransformerInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twigEnvironment;

    /**
     * @param \Twig_Environment $twigEnvironment
     */
    public function __construct(\Twig_Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(array $dataArray, string $method): string
    {
        return $this->twigEnvironment->render("FastControllerBundle::$method.html.twig", $dataArray);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'TwigHtml';
    }
}