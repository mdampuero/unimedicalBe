<?php

namespace Inamika\BackEndBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Inamika\BackEndBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"barcode"}, repositoryMethod="getUniqueNotDeleted")
 * @ExclusionPolicy("all")
 */
class Product
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @Expose
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="brand", type="string", length=255, nullable=true)
     * @Expose
     */
    private $brand;
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     * @Expose
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="barcode", type="string", length=32)
     * @Expose
     */
    private $barcode;

    /**
     * @var float|null
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     * @Expose
     */
    private $price;

    /**
     * @var float|null
     *
     * @ORM\Column(name="price_min", type="float", nullable=true)
     * @Expose
     */
    private $priceMin;

    /**
     * @var float|null
     *
     * @ORM\Column(name="price_max", type="float", nullable=true)
     * @Expose
     */
    private $priceMax;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="display", type="string", length=255, nullable=true)
     * @Expose
     */
    private $display;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number_branches_available", type="integer")
     * @Expose
     */
    private $numberBranchesAvailable=0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_delete", type="boolean")
     */
    private $isDelete=false;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set brand.
     *
     * @param string|null $brand
     *
     * @return Product
     */
    public function setBrand($brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand.
     *
     * @return string|null
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set category.
     *
     * @param string|null $category
     *
     * @return Product
     */
    public function setCategory($category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set barcode.
     *
     * @param string $barcode
     *
     * @return Product
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode.
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set price.
     *
     * @param float|null $price
     *
     * @return Product
     */
    public function setPrice($price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set priceMin.
     *
     * @param float|null $priceMin
     *
     * @return Product
     */
    public function setPriceMin($priceMin = null)
    {
        $this->priceMin = $priceMin;

        return $this;
    }

    /**
     * Get priceMin.
     *
     * @return float|null
     */
    public function getPriceMin()
    {
        return $this->priceMin;
    }

    /**
     * Set priceMax.
     *
     * @param float|null $priceMax
     *
     * @return Product
     */
    public function setPriceMax($priceMax = null)
    {
        $this->priceMax = $priceMax;

        return $this;
    }

    /**
     * Get priceMax.
     *
     * @return float|null
     */
    public function getPriceMax()
    {
        return $this->priceMax;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set display.
     *
     * @param string|null $display
     *
     * @return Product
     */
    public function setDisplay($display = null)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display.
     *
     * @return string|null
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set numberBranchesAvailable.
     *
     * @param int|null $numberBranchesAvailable
     *
     * @return Product
     */
    public function setNumberBranchesAvailable($numberBranchesAvailable = null)
    {
        $this->numberBranchesAvailable = $numberBranchesAvailable;

        return $this;
    }

    /**
     * Get numberBranchesAvailable.
     *
     * @return int|null
     */
    public function getNumberBranchesAvailable()
    {
        return $this->numberBranchesAvailable;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set isDelete.
     *
     * @param bool $isDelete
     *
     * @return Product
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete.
     *
     * @return bool
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt=new \DateTime();
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt=new \DateTime();
    }
}
