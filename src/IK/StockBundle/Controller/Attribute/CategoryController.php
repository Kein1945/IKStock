<?php

namespace IK\StockBundle\Controller\Attribute;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use IK\StockBundle\Entity\Category as CategoryBase;
use IK\StockBundle\Entity\Attribute\Category;
use IK\StockBundle\Form\Attribute\CategoryType;

/**
 * Attribute\Category controller.
 *
 * @Route("/stock/category/attribute")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Attribute\Category entities.
     *
     * @Route("/", name="stock_category_attribute")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IKStockBundle:Attribute\Category')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Attribute\Category entity.
     *
     * @Route("/{id}/show", name="stock_category_attribute_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Attribute\Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Attribute\Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Attribute\Category entity.
     *
     * @Route("/{id}/new", name="stock_category_attribute_new")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new Category();
        $form   = $this->createForm(new CategoryType(), $entity);
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('IKStockBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'category' => $category
        );
    }

    /**
     * Creates a new Attribute\Category entity.
     *
     * @Route("/{id}/create", name="stock_category_attribute_create")
     * @Method("POST")
     * @Template("IKStockBundle:Attribute\Category:new.html.twig")
     */
    public function createAction($id, Request $request)
    {
        $entity  = new Category();
        $form = $this->createForm(new CategoryType(), $entity);
        $form->bind($request);

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('IKStockBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        if ($form->isValid()) {
            $entity->setCategory($category);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stock_category_show', array('id' => $category->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'category' => $category
        );
    }

    /**
     * Displays a form to edit an existing Attribute\Category entity.
     *
     * @Route("/{id}/edit", name="stock_category_attribute_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Attribute\Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Attribute\Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'category' => $entity->getCategory()
        );
    }

    /**
     * Edits an existing Attribute\Category entity.
     *
     * @Route("/{id}/update", name="stock_category_attribute_update")
     * @Method("POST")
     * @Template("IKStockBundle:Attribute\Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Attribute\Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Attribute\Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stock_category_show', array('id' => $entity->getCategory()->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'category' => $entity->getCategory()
        );
    }

    /**
     * Deletes a Attribute\Category entity.
     *
     * @Route("/{id}/delete", name="stock_category_attribute_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IKStockBundle:Attribute\Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Attribute\Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('stock_category_attribute'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
