<?php

namespace IK\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Export {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     */
    private $lastUpdate;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $clientKey;

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
     * Set url
     *
     * @param string $url
     * @return Export
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set lastUpdate
     *
     * @param integer $lastUpdate
     * @return Export
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return integer
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set clientKey
     *
     * @param string $clientKey
     * @return Export
     */
    public function setClientKey($clientKey)
    {
        $this->clientKey = $clientKey;

        return $this;
    }

    /**
     * Get clientKey
     *
     * @return string
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }
}