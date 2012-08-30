<?php

namespace IK\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IK\StockBundle\Model\Attribute\ExtensionInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Product {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $article;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="IK\StockBundle\Entity\Attribute\Value", mappedBy="product", cascade={"persist","refresh"})
     */
    protected $attributes;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     */
    protected $category;

    protected $extensions = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set category
     *
     * @param IK\StockBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\IK\StockBundle\Entity\Category $category = null)
    {
        $this->category = $category;
        $this->updateExtensions();
        return $this;
    }

    public function setExtensions($extensions){
        foreach($extensions as $extension)
            $this->addExtension($extension);
    }

    public function addExtension(ExtensionInterface $extension){
        $extension->setProduct( $this );
        $this->extensions[$extension->getName()] = $extension;
    }

    public function getExtensions(){
        return $this->extensions;
    }
    public function getExtension($name){
        return isset($this->extensions[$name])?$this->extensions[$name]:null;
    }

    public function getExtensionById($id){
        $name = 'attribute_'.$id;
        return isset($this->extensions[$name])?$this->extensions[$name]:null;

    }

    public function __get($attribute){
        return $this->getExtension($attribute)->getData();
    }

    public function __set($attribute, $value){
        $this->getExtension($attribute)->setData($value);
    }

    /**
     * @ORM\PostLoad
     */
    public function updateExtensions(){
        foreach($this->category->getAttributes() as $category_attribute){
            $extension = $category_attribute->getExtensionInstance();
            $this->addExtension( $extension );
            foreach($this->getAttributes() as $attribute){
                $exists = false;
                if($category_attribute->getId() == $attribute->getCategoryId()){
                    $extension->setValue($attribute);
                    $exists = true;
                }
            }
            if(!$exists){
                $this->addAttribute( $extension->getValue() );
            }
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function updateAttributes(){
        $this->setUpdatedAt(\time());
        foreach($this->extensions as $extension){
            $this->addAttribute( $extension->getValue() );
        }
    }


    // GeneratedMethods
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
     * Set article
     *
     * @param string $article
     * @return Product
     */
    public function setArticle($article)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Add attributes
     *
     * @param Attribute\Value $attributes
     * @return Product
     */
    public function addAttribute(Attribute\Value $attributes)
    {
        $this->attributes[] = $attributes;
        return $this;
    }

    /**
     * Remove attributes
     *
     * @param Attribute\Value $attributes
     */
    public function removeAttribute(Attribute\Value $attributes)
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
     * Get category
     *
     * @return IK\StockBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set updatedAt
     *
     * @param integer $updatedAt
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return integer 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}