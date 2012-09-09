<?php

namespace IK\StockBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use IK\StockBundle\Entity\Category;
use IK\StockBundle\Form\CategoryType;
use IK\StockBundle\Entity\Attribute\Category as AttributeCategory;
use IK\StockBundle\Form\Attribute\CategoryType as AttributeCategoryType;

/**
 * Category controller.
 *
 * @Route("/stock/category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="stock_category")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IKStockBundle:Category')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}/show", name="stock_category_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new/{id}", name="stock_category_new", defaults={"id" = null})
     * @Template()
     */
    public function newAction($id = null)
    {
        $entity = new Category();
        if(!is_null($id)){
            $em = $this->getDoctrine()->getManager();

            $parent = $em->getRepository('IKStockBundle:Category')->find($id);
            if (!$parent) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }
            $entity->setParent($parent);
        }
        $form   = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create/{id}", name="stock_category_create", defaults={"id" = null})
     * @Method("POST")
     * @Template("IKStockBundle:Category:new.html.twig")
     */
    public function createAction(Request $request, $id=null)
    {
        $entity  = new Category();
        if(!is_null($id)){
            $em = $this->getDoctrine()->getManager();

            $parent = $em->getRepository('IKStockBundle:Category')->find($id);
            if (!$parent) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }
            $entity->setParent($parent);
        }
        $form = $this->createForm(new CategoryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if(null!=$entity->getParent()){
                foreach($entity->getParent()->getAttributes() as $attribute){
                    $new_attribute = clone $attribute;
                    $new_attribute->setCategory($entity);
                    $entity->addAttribute($new_attribute);
                }
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stock_category_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="stock_category_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}/update", name="stock_category_update")
     * @Method("POST")
     * @Template("IKStockBundle:Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IKStockBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stock_category_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="stock_category_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IKStockBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('stock_category'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
