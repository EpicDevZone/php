<?php

class Person
{
    public string  $name;
    public string $email;
    public string $password;
    public static int $personCounter = 0;




    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        self::$personCounter++;
    }

    public static  function getCounter(): int
    {
        return self::$personCounter;
    }


    public function displayUser(): void
    {
        echo $this->name;
        echo "<br>";
        echo $this->email;
        echo "<br>";
        echo $this->password;
        echo "<br>";
    }
}

$p1 = new Person("sunil", "sunilkathayat41@gmail.com", "1234");
$p1 = new Person("sunil", "sunilkathayat41@gmail.com", "1234");
$p1 = new Person("sunil", "sunilkathayat41@gmail.com", "1234");
$p1 = new Person("sunil", "sunilkathayat41@gmail.com", "1234");
$p1 = new Person("sunil", "sunilkathayat41@gmail.com", "1234");
$p1 = new Person("sunil", "sunilkathayat41@gmail.com", "1234");
$p1 = new Person("sunil", "sunilkathayat41@gmail.com", "1234");


$p1->displayUser();

echo "The number of users are " . Person::getCounter();
