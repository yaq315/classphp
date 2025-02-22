<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    // task1
class Book {
    protected string $title;
    protected Author $author;
    protected string $isbn;
    protected string $status;

    public function __construct(string $title, Author $author, string $isbn) {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->status = "available"; // Default status
        $author->addBook($this);
    }

    public function borrowBook() {
        if ($this->status === "available") {
            $this->status = "borrowed";
            echo " The book '{$this->title}' has been borrowed.\n";
        } else {
            echo "The book '{$this->title}' is currently unavailable.\n";
        }
    }

    public function returnBook() {
        if ($this->status === "borrowed") {
            $this->status = "available";
            echo "The book '{$this->title}' has been returned.\n";
        } else {
            echo " The book '{$this->title}' is already available.\n";
        }
    }

    public function getBookInfo(): string {
        return " Title: {$this->title}, Author: {$this->author->getName()}, ISBN: {$this->isbn}, Status: {$this->status}\n";
    }

    public function getStatus(): string {
        return $this->status;
    }
    public function getISBN(): string {
        return $this->isbn;
    }
}



// task2

class Author {
    private string $name;
    private string $email;
    private array $books = [];

    public function __construct(string $name, string $email) {
        $this->name = $name;
        $this->email = $email;
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function getAuthorBooks(): array {
        return $this->books;
    }

    public function getName(): string {
        return $this->name;
    }
}


// task3
class Library {
    private array $books = [];

    public function addBook(Book $book) {
        $this->books[$book->getISBN()] = $book;
    }

    public function getAllBooks(): array {
        return $this->books;
    }

    public function findBookByISBN(string $isbn): ?Book {
        return $this->books[$isbn] ?? null;
    }

    public function listAvailableBooks(): array {
        return array_filter($this->books, fn($book) => $book->getStatus() === "available");
    }
}

// task4
class DigitalBook extends Book {
    private float $fileSize;

    public function __construct(string $title, Author $author, string $isbn, float $fileSize) {
        parent::__construct($title, $author, $isbn);
        $this->fileSize = $fileSize;
    }

    // Overriding `getBookInfo` for DigitalBook
    public function getBookInfo(): string {
        return parent::getBookInfo() . " File Size: {$this->fileSize}MB\n";
    }
}


// task5

$author1 = new Author("Naguib Mahfouz", "naguib@email.com");
$author2 = new Author("Ahmed Khaled Tawfik", "ahmed@email.com");

$book1 = new Book("The Thief and the Dogs", $author1, "978-1");
$book2 = new Book("Utopia", $author2, "978-2");
$digitalBook = new DigitalBook("Digital Novel", $author1, "978-3", 2.5);

$library = new Library();
$library->addBook($book1);
$library->addBook($book2);
$library->addBook($digitalBook);

// Display all books
echo " All books in the library:";
foreach ($library->getAllBooks() as $book) {
    echo $book->getBookInfo();
    echo"<br>";
}

// Borrow a book
$book1->borrowBook();
echo"<br>";
//  Find book by ISBN
echo " Searching for book by ISBN:";
$searchedBook = $library->findBookByISBN("978-2");
if ($searchedBook) {
    echo $searchedBook->getBookInfo();
    echo"<br>";
} else {
    echo "Book not found";
    echo"<br>";
}

//  Display available books
echo " Available books:\n";
foreach ($library->listAvailableBooks() as $availableBook) {
    echo $availableBook->getBookInfo();
    echo"<br>";
}

// Return a book
$book1->returnBook();
echo"<br>";

//  Display available books after return
echo "Available books after returning:\n";
foreach ($library->listAvailableBooks() as $availableBook) {
    echo $availableBook->getBookInfo();
    echo"<br>";
}

    ?>
</body>
</html>