<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig',
            [
                'fromAction' => "Hello User"
            ]
        );
    }

    /**
     * @Route("/admin/")
     */
    public function adminAction()
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        echo $user->getPassword(); die;
        return $this->render('AdminBundle:Default:index.html.twig',
            [
                'fromAction' => "Hello Admin"
            ]
        );
    }

    /**
     * @Route("/simpleuser/")
     */
    public function simpleUserAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig',
            [
                'fromAction' => "Hello Registered User"
            ]
        );
    }
}
