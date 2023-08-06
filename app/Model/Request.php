<?php

namespace FoodRetail\Model;

class Request
{
    public ?int $id;
    public ?string $qrcode;
    public ?string $name;
    public ?int $price;
    public ?int $isExpired = 0;
    public ?float $discount = 0;
    public ?string $expiredAt;
    public ?string $deletedAt;
}
