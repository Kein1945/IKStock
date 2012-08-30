<?php

namespace IK\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use IK\StockBundle\Entity\Attribute\Category as AttributeCategory;


/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\OneToMany(targetEntity="IK\StockBundle\Entity\Attribute\Category", mappedBy="category")
     */
    protected $attributes;

    /**
     * @ORM\OneToMany(targetEntity="IK\StockBundle\Entity\Product", mappedBy="category")
     */
    protected $products;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    public function __construct(){
        $this->children = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    public function __toString(){
        return $this->name;
    }

    // Generated function

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parent
     *
     * @param IK\StockBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(\IK\StockBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return IK\StockBundle\Entity\Category 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param IK\StockBundle\Entity\Category $children
     * @return Category
     */
    public function addChildren(\IK\StockBundle\Entity\Category $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param IK\StockBundle\Entity\Category $children
     */
    public function removeChildren(\IK\StockBundle\Entity\Category $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add attributes
     *
     * @param Attribute\Category $attributes
     * @return Category
     */
    public function addAttribute(AttributeCategory $attributes)
    {
        $this->attributes[] = $attributes;
    
        return $this;
    }

    /**
     * Remove attributes
     *
     * @param Attribute\Category $attributes
     */
    public function removeAttribute(AttributeCategory $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * Get attributes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Add products
     *
     * @param IK\StockBundle\Entity\Product $products
     * @return Category
     */
    public function addProduct(\IK\StockBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param IK\StockBundle\Entity\Product $products
     */
    public function removeProduct(\IK\StockBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}