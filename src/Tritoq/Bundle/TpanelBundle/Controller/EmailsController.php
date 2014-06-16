<?php

namespace Tritoq\Bundle\TpanelBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tritoq\Bundle\TpanelBundle\Entity\Emails;
use Tritoq\Bundle\TpanelBundle\Form\EmailsType;

/**
 * Emails controller.
 *
 * @Route("/email")
 */
class EmailsController extends Controller
{

    /**
     * Lists all Emails entities.
     *
     * @Route("/", name="email")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/get.json", name="emails_get", defaults={"_format"="json"})
     * @Method("GET")
     * @Template()
     */
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TritoqTpanelBundle:Emails')->findAll();

        $data = array();

        foreach ($entities as $email) {
            $data[] = array(
                'id' => $email->getId(),
                'email' => $email->getEmail(),
                'password' => $email->getPassword(),
                'dominio' => $email->getDominio()
            );
        }

        return new JsonResponse($data);
    }

    /**
     * Creates a new Emails entity.
     *
     * @Route("/", name="email_create")
     * @Method("POST")
     * @Template("TritoqTpanelBundle:Emails:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Emails();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('email_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Emails entity.
     *
     * @param Emails $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Emails $entity)
    {
        $form = $this->createForm(
            new EmailsType(),
            $entity,
            array(
                'action' => $this->generateUrl('email_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Emails entity.
     *
     * @Route("/new", name="email_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Emails();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Emails entity.
     *
     * @Route("/{id}", name="email_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TritoqTpanelBundle:Emails')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emails entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Emails entity.
     *
     * @Route("/{id}/edit", name="email_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TritoqTpanelBundle:Emails')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emails entity.');
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
     * Creates a form to edit a Emails entity.
     *
     * @param Emails $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Emails $entity)
    {
        $form = $this->createForm(
            new EmailsType(),
            $entity,
            array(
                'action' => $this->generateUrl('email_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Emails entity.
     *
     * @Route("/{id}", name="email_update")
     * @Method("PUT")
     * @Template("TritoqTpanelBundle:Emails:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TritoqTpanelBundle:Emails')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emails entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('email_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Emails entity.
     *
     * @Route("/{id}", name="email_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TritoqTpanelBundle:Emails')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Emails entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('email'));
    }

    /**
     * Creates a form to delete a Emails entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('email_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
