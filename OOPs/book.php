<?php
class Book
{
    public string $title;
    public string $author;
    public int $price;
    public static int $bookCounterv = 0;

    public function  __construct(string $title, string $author, int $price)
    {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;

        self::$bookCounterv += 1;
    }

    public function displayBook(): void
    {
        echo "<br>";
        echo $this->title;
        echo "<br>";
        echo $this->author;
        echo "<br>";
        echo $this->price;
        echo "<br>";
    }


    public static function getBookCounter(): int
    {
        return self::$bookCounterv;
    }
}

$book1 = new Book(" War and peace", "Leo Talstory", 500);
$book1->displayBook();

echo "<br>";

echo "<br>";
$book1 = new Book(" War ", "Leo", 400);
$book1->displayBook();
echo "<br>";

echo "<br>";
$book1 = new Book("  peace", " Talstory", 300);
$book1->displayBook();
echo "<br>";

echo "<br>";
$book1 = new Book("  and ", " Tal", 200);
$book1->displayBook();

echo Book::getBookCounter();
