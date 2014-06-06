<?php

namespace Tritoq\Bundle\TpanelBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('vhost'));
    }

    /**
     * @Route("/user", name="user")
     * @Template()
     */
    public function userAction () {

        return array();

    }
}
