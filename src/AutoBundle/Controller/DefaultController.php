<?php

namespace AutoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AutoBundle:Default:index.html.twig');
    }

    /**
     *
     * @Route("/getmodels/{id}", name="getmodels")
     */
    public function getModelsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $models = $em->getRepository("AutoBundle:Model")->findBy(["make" => $id]);

        $modelDtoArray = [];
        foreach ($models as $model){
            $modelDto = [
                'id' => $model->getId(),
                'name' => $model->getName()
            ];
            array_push($modelDtoArray, $modelDto);
        }

        return new JsonResponse($modelDtoArray);
    }
}
