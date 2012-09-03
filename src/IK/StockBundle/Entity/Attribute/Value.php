<?php

namespace IK\StockBundle\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_value")
 * @ORM\HasLifecycleCallbacks()
 */
class Value {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $int_value = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $str_value = '';

    /**
     * @ORM\ManyToOne(targetEntity="IK\StockBundle\Entity\Attribute\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\ManyToOne(targetEntity="IK\StockBundle\Entity\Product")
     */
    private $product;

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function prePersist(){
        $this->product->updateAttributes();
    }

    // Generated methods

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
     * Set int_value
     *
     * @param integer $intValue
     * @return Value
     */
    public function setIntValue($intValue)
    {
        $this->int_value = $intValue;
    
        return $this;
    }

    /**
     * Get int_value
     *
     * @return integer 
     */
    public function getIntValue()
    {
        return $this->int_value;
    }

    /**
     * Set str_value
     *
     * @param string $strValue
     * @return Value
     */
    public function setStrValue($strValue)
    {
        $this->str_value = $strValue;
    
        return $this;
    }

    /**
     * Get str_value
     *
     * @return string 
     */
    public function getStrValue()
    {
        return $this->str_value;
    }

    /**
     * Set category
     *
     * @param IK\StockBundle\Entity\Attribute\Category $category
     * @return Value
     */
    public function setCategory(\IK\StockBundle\Entity\Attribute\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return IK\StockBundle\Entity\Attribute\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set product
     *
     * @param IK\StockBundle\Entity\Product $product
     * @return Value
     */
    public function setProduct(\IK\StockBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return IK\StockBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Value
     */
    public function setCategoryId($categoryId)
    {
        //$this->category_id = $categoryId;
    
        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }
}