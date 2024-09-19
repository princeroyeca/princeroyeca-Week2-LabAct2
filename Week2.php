<?php
class Book {
    public $title;
    protected $author;
    private $price;
    private $stock;

    public function __construct($title, $author, $price, $stock = 0) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getDetails() {
        return "Title: " . $this->title . ", Author: " . $this->author . ", Price: $" . $this->price . ", Stock: " . $this->stock;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function updateStock($quantity) {
        if (is_numeric($quantity) && $quantity >= 0) {
            $this->stock = $quantity;
            return "Stock updated to $quantity.";
        }
        return "Invalid quantity.";
    }

    public function __call($method, $args) {
        if ($method === 'updateStock') {
            return $this->updateStock(...$args);
        }
        return "Method '$method' does not exist.";
    }
}

class Library {
    private $books = [];
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function removeBook($title) {
        foreach ($this->books as $key => $book) {
            if ($book->title === $title) {
                unset($this->books[$key]);
                $this->books = array_values($this->books); 
                return "Book '$title' removed.";
            }
        }
        return "Book '$title' not found.";
    }

    public function listBooks() {
        if (empty($this->books)) {
            return "No books in the library.";
        }

        $bookList = "";
        foreach ($this->books as $book) {
            $bookList .= $book->getDetails() . "<br>";
        }
        return $bookList;
    }

    public function __destruct() {
        echo "Library '$this->name' is now closed.<br>";
    }
}

$book1 = new Book('1984', 'George Orwell', 9.99, 10);
$book2 = new Book('To Kill a Mockingbird', 'Harper Lee', 7.99, 5);
$book3 = new Book('The Great Gatsby', 'F. Scott Fitzgerald', 10.99, 8);

$library = new Library('Central Library');

$library->addBook($book1);
$library->addBook($book2);
$library->addBook($book3);

$book1->setPrice(12.99);

echo $book1->updateStock(15) . "<br>";

echo $book1->updateStock(20) . "<br>";

echo $library->removeBook('1984') . "<br>";

echo $library->listBooks();

unset($library);
?>
