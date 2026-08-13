<?php
class Calculator
{
    public float $result = 0;

    public function add(float $number): static
    {
        $this->result += $number;
        return $this;
    }
    public function mul(float $number): static
    {
        $this->result *= $number;
        return $this;
    }
    public function sub(float $number): static
    {
        $this->result -= $number;
        return $this;
    }
    public function div(float $number): static
    {
        if ($number != 0) {
            $this->result /= $number;
        } else {
            echo "<br>";
            echo "Division by zero is not possible";
        }
        return $this;
    }

    public function getFunction(): float
    {
        return  $this->result;
    }

    public function reset(): static
    {
        $this->result = 0;
        return $this;
    }
}
$calc = new Calculator();
$calc->add(1);
$calc->mul(2);
$calc->div(5);
$calc->sub(10);


echo $calc->getFunction();
echo "<br>";

$calc->reset();


echo "<br>";
$calc->add(2)->sub(12)->div(2)->mul(12);

echo "<br>";
echo $calc->getFunction();
