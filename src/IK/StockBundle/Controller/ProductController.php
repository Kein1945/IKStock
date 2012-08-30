<?php

namespace IK\StockBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use IK\StockBundle\Entity\Product;
use IK\StockBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/stock/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="stock_product")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IKStockBundle:Product')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Lists all Product entities in selected category.
     *
     * @Route("/by/category/{id}", name="stock_product_by_category")
     * @Template()
     */
    public function byCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('IKStockBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $entities = $em->getRepository('IKStockBundle:Product')->findByCategory($category);

        return array(
            'entities' => $entities,
            'category' => $category
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}/show", name="stock_product_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'category' => $entity->getCategory()
        );
    }

    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/{id}/new", name="stock_product_new")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('IKStockBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $entity = new Product();
        $entity->setCategory($category);
        $form   = $this->createForm(new ProductType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'category' => $category,
        );
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/{id}/create", name="stock_product_create")
     * @Method("POST")
     * @Template("IKStockBundle:Product:new.html.twig")
     */
    public function createAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('IKStockBundle:Category')->find($id);
        if (!$category) { throw $this->createNotFoundException('Unable to find Category entity.'); }

        $entity  = new Product();
        $entity->setCategory($category);

        $form = $this->createForm(new ProductType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stock_product_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'category' => $category
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="stock_product_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createForm(new ProductType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'category' => $entity->getCategory()
        );
    }

    /**
     * Edits an existing Product entity.
     *
     * @Route("/{id}/update", name="stock_product_update")
     * @Method("POST")
     * @Template("IKStockBundle:Product:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ProductType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('stock_product_by_category', array('id' => $category_id)));
            return $this->render('IKStockBundle:Product:show.html.twig',array(
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView(),
                'category' => $entity->getCategory()
            ));
            die();
            return $this->redirect($this->generateUrl('stock_product_by_category', array('id' => $entity->getCategory()->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'category' => $entity->getCategory()
        );
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}/delete", name="stock_product_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IKStockBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }
            $category_id = $entity->getCategory()->getId();
            $em->remove($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('stock_product_by_category', array('id' => $category_id)));
        }

        return $this->redirect($this->generateUrl('stock_product'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
