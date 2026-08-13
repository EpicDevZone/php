<?php

class Product
{
    private string $name;
    private int $price;
    private float $quantity;

    public function __construct(string $name, int $price, float $quantity)
    {
        $this->setPrice($price);
        $this->setProductName($name);
        $this->setQuantity($quantity);
    }

    public function setQuantity($quantity): bool
    {
        if ($quantity < 0) {
            echo "The quantity may not be the negative number ";
            return false;
        }
        $this->quantity = $quantity;
        return true;
    }

    public function setPrice($price): bool
    {
        if ($price < 0) {
            echo "The price may not be the negative number ";
            return false;
        }
        $this->price = $price;
        return true;
    }

    public function setProductName($name): bool

    {
        if (strlen($name) < 3) {
            return false;
        }
        if (!preg_match(
            '/^[a-zA-Z0-9_]+$/',
            $name
        )) {
            echo "The product name should contain only aphapbets , numbers and ";
            return false;
        }
        $this->name = $name;
        return true;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function getPrice(): int
    {
        return $this->price;
    }

    public function getProductName(): string
    {

        return $this->name;
    }



    public function displayProduct(): void
    {
        echo "<br>";
        echo "Name ";

        echo __CLASS__;
        echo __METHOD__;
        echo $this->name;
        echo "<br>";
        echo "Price ";
        echo $this->price;
        echo "<br>";
        echo "Quantity ";
        echo $this->quantity;
    }
}


$p1 = new Product("laptop", 100000, 10);

$p1->displayProduct();

$p1->getProductName();
$p1->getPrice();
$p1->getQuantity();
