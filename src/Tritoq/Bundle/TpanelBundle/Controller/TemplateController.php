<?php
/**
 * @author Artur Magalhães <nezkal@gmail.com>
 */

namespace Tritoq\Bundle\TpanelBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TemplateController extends Controller
{

    /**
     * @return array
     * @Route("/templates", name="templates")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $kernel = $this->get('kernel');
        $file = $kernel->getRootDir() . '/template/vhost.template.txt';
        //
        $vhost = file_get_contents($file);

        return array('vhost' => $vhost);
    }

    /**
     * @Route("/templates", name="template.save")
     * @Method("POST")
     */
    public function saveAction()
    {


        $vhost = $this->get('request_stack')->getCurrentRequest()->get('vhost');

        if (!empty($vhost)) {
            $dir = $this->get('kernel')->getRootDir() . '/template';
            copy($dir . '/vhost.template.txt' , $dir . '/' . time() . '.vhost.template.txt');
            file_put_contents($dir . '/vhost.template.txt', $vhost);
        }

        return $this->redirect($this->generateUrl('templates'));
    }
} 