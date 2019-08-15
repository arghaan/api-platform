<?php

namespace App\Entity\Catalog;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ozon_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $offer_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $old_price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $premium_price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recommended_price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $barcode;

    /**
     * @ORM\Column(type="json")
     */
    private $images = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\Column(type="json")
     */
    private $visibility_details = [];

    /**
     * @ORM\Column(type="json")
     */
    private $validation_errors = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getSku(): ?int
    {
        return $this->sku;
    }

    /**
     * @param int $sku
     * @return Product
     */
    public function setSku(int $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOfferId(): ?string
    {
        return $this->offer_id;
    }

    /**
     * @param string $offer_id
     * @return Product
     */
    public function setOfferId(string $offer_id): self
    {
        $this->offer_id = $offer_id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     * @return Product
     */
    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return Product
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOldPrice(): ?string
    {
        return $this->old_price;
    }

    /**
     * @param string $old_price
     * @return Product
     */
    public function setOldPrice(string $old_price): self
    {
        $this->old_price = $old_price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPremiumPrice(): ?string
    {
        return $this->premium_price;
    }

    /**
     * @param string $premium_price
     * @return Product
     */
    public function setPremiumPrice(string $premium_price): self
    {
        $this->premium_price = $premium_price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecommendedPrice(): ?string
    {
        return $this->recommended_price;
    }

    /**
     * @param string $recommended_price
     * @return Product
     */
    public function setRecommendedPrice(string $recommended_price): self
    {
        $this->recommended_price = $recommended_price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVat(): ?string
    {
        return $this->vat;
    }

    /**
     * @param string $vat
     * @return Product
     */
    public function setVat(string $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     * @return Product
     */
    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param array $images
     * @return Product
     */
    public function setImages(array $images): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Product
     */
    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStock(): ?int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     * @return Product
     */
    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     * @return Product
     */
    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getVisibilityDetails(): ?array
    {
        return $this->visibility_details;
    }

    /**
     * @param array $visibility_details
     * @return Product
     */
    public function setVisibilityDetails(array $visibility_details): self
    {
        $this->visibility_details = $visibility_details;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getValidationErrors(): ?array
    {
        return $this->validation_errors;
    }

    /**
     * @param array $validation_errors
     * @return Product
     */
    public function setValidationErrors(array $validation_errors): self
    {
        $this->validation_errors = $validation_errors;

        return $this;
    }

    public function getOzonId(): ?int
    {
        return $this->ozon_id;
    }

    public function setOzonId(int $ozon_id): self
    {
        $this->ozon_id = $ozon_id;

        return $this;
    }
}
