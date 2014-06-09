<?php

namespace Tritoq\Bundle\TpanelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tritoq\Bundle\TpanelBundle\Entity\Vhost;
use Tritoq\Bundle\TpanelBundle\Form\VhostType;

/**
 * Vhost controller.
 *
 * @Route("/vhost")
 */
class VhostController extends Controller
{

    /**
     * Lists all Vhost entities.
     *
     * @Route("/", name="vhost")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TritoqTpanelBundle:Vhost')->getByIdDesc();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Vhost entity.
     *
     * @Route("/", name="vhost_create")
     * @Method("POST")
     * @Template("TritoqTpanelBundle:Vhost:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Vhost();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vhost_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Vhost entity.
     *
     * @param Vhost $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vhost $entity)
    {
        $form = $this->createForm(
            new VhostType(),
            $entity,
            array(
                'action' => $this->generateUrl('vhost_create'),
                'method' => 'POST',
            )
        );


        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    private function getVhostTemplate()
    {
        $kernel = $this->get('kernel');
        $file = $kernel->getRootDir() . '/template/vhost.template.txt';
        $template = file_get_contents($file);
        return $template;
    }

    private function getNginxTemplate()
    {
        $kernel = $this->get('kernel');
        $file = $kernel->getRootDir() . '/template/nginx.template.txt';
        $template = file_get_contents($file);
        return $template;
    }

    /**
     * Displays a form to create a new Vhost entity.
     *
     * @Route("/new", name="vhost_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vhost();
        $entity->setVhost($this->getVhostTemplate());
        $entity->setNginx($this->getNginxTemplate());

        if (isset($_SERVER['SERVER_ADDR'])) {
            $entity->setIp($_SERVER['SERVER_ADDR']);
        }

        $form = $this->createCreateForm($entity);


        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     *
     * @Route("/download/{domain}", defaults={"_format"="txt"})
     * @Method("GET")
     */
    public function vhostAction($domain)
    {
        $em = $this->getDoctrine()->getManager();
        $vhost = $em->getRepository("TritoqTpanelBundle:Vhost")->findOneByDomain($domain);
        if (!$vhost) {
            throw new NotFoundHttpException('Domínio não encontrado');
        }

        return new Response($vhost->getVhost());
    }

    /**
     *
     * @Route("/download/{domain}/nginx", defaults={"_format"="txt"})
     * @Method("GET")
     */
    public function nginxAction($domain)
    {
        $em = $this->getDoctrine()->getManager();
        $vhost = $em->getRepository("TritoqTpanelBundle:Vhost")->findOneByDomain($domain);
        if (!$vhost) {
            throw new NotFoundHttpException('Domínio não encontrado');
        }

        return new Response($vhost->getNginx());
    }

    /**
     * Finds and displays a Vhost entity.
     *
     * @Route("/{id}", name="vhost_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TritoqTpanelBundle:Vhost')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vhost entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Vhost entity.
     *
     * @Route("/{id}/edit", name="vhost_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TritoqTpanelBundle:Vhost')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vhost entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Vhost entity.
     *
     * @param Vhost $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Vhost $entity)
    {
        $form = $this->createForm(
            new VhostType(),
            $entity,
            array(
                'action' => $this->generateUrl('vhost_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Vhost entity.
     *
     * @Route("/{id}", name="vhost_update")
     * @Method("PUT")
     * @Template("TritoqTpanelBundle:Vhost:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TritoqTpanelBundle:Vhost')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vhost entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('vhost_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Vhost entity.
     *
     * @Route("/{id}", name="vhost_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TritoqTpanelBundle:Vhost')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vhost entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vhost'));
    }

    /**
     * Creates a form to delete a Vhost entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhost_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
