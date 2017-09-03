<?php

namespace KaneMenicou\FastControllerBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use KaneMenicou\FastControllerBundle\Model\Config\InstantiatedCrudRouteConfig;
use KaneMenicou\FastControllerBundle\Transformer\EntityTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceController extends Controller
{
    /**
     * @var InstantiatedCrudRouteConfig
     */
    protected $config;

    /**
     * {@inheritdoc}
     */
    public function deleteAction($id, $config)
    {
        $this->parseConfig($config);
        $objectManager = $this->getDoctrine()->getManager();

        $entity = $this->getEntityOrError($id);

        $objectManager->remove($entity);
        $objectManager->flush();

        return $this->response(['Message' => 'Deleted'], Response::HTTP_OK, InstantiatedCrudRouteConfig::DELETE_ROUTE);
    }

    /**
     * @param array $config
     */
    private function parseConfig($config)
    {
        $this->config = new InstantiatedCrudRouteConfig($config);
    }

    /**
     * @param string $id
     *
     * @return null|object
     */
    protected function getEntityOrError($id)
    {
        $entity = $this->resolveEntity($id);

        if ($entity === null) {
            throw new NotFoundHttpException;
        }

        return $entity;
    }

    /**
     * @param string $id
     *
     * @return null|object
     */
    private function resolveEntity($id)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = $this->getDoctrine()->getManager();

        $entity = $objectManager->find($this->config->getEntity(), $id);

        return $entity;
    }

    /**
     * @param array $array
     *
     * @param int $responseCode
     * @param string $method
     * @return Response
     */
    private function response(array $array, $responseCode = Response::HTTP_OK, $method)
    {
        if ($this->config->isApi()) {
            $responseTransformerChain = $this->get('kane_menicou_fast_controller.chain.api_response_transformer_chain');
            $transformer = $responseTransformerChain->getResponseTransformer($this->config->getReturnType());
            $response = $transformer->transform($array);
        } else {
            $responseTransformerChain = $this->get('kane_menicou_fast_controller.chain.view_response_transformer_chain');
            $transformer = $responseTransformerChain->getResponseTransformer($this->config->getReturnType());
            $response = $transformer->transform($array, $method);
        }

        return new Response($response, $responseCode);
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id, $config)
    {
        $this->parseConfig($config);
        $objectManager = $this->getDoctrine()->getManager();

        $entity = $this->getEntityOrError($id);

//        $objectManager->remove($entity);EDIT
        $objectManager->flush();

        return $this->response(['Message' => 'Deleted'], Response::HTTP_OK, InstantiatedCrudRouteConfig::EDIT_ROUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function viewAction($id, $config)
    {
        $this->parseConfig($config);

        $entity = $this->getEntityOrError($id);

        if ($this->config->isApi()) {
            $transformer = new EntityTransformer();

            return $this->response(
                $transformer->transform($entity),
                Response::HTTP_OK,
                InstantiatedCrudRouteConfig::VIEW_ROUTE
            );
        }

        return $this->response(['entity' => $entity], Response::HTTP_OK, InstantiatedCrudRouteConfig::VIEW_ROUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return new Response('hi there');
    }

    /**
     * {@inheritdoc}
     */
    public function newAction(Request $request, $config)
    {
        // TODO: Implement newAction() method.
    }
}
