<?php

namespace FoodRetail\Entity;

class Product
{
    private ?int $id;
    private ?string $qrcode;
    private ?string $name;
    private ?int $price;
    private ?int $isExpired = 0;
    private ?float $discount = 0;
    private ?string $expiredAt;
    private ?string $deletedAt;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setQrcode($qrcode)
    {
        $this->qrcode = $qrcode;

        return $this;
    }

    public function getQrcode()
    {
        return $this->qrcode;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getIsExpired()
    {
        return $this->isExpired;
    }

    public function setIsExpired($isExpired)
    {
        $this->isExpired = $isExpired;

        return $this;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }
}
