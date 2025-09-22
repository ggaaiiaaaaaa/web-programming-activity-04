<?php
require_once "../classes/library.php";
$libraryObj = new Library();

$book = ["title" => "", "author" => "", "genre" => "", "publication_year" => ""];
$errors = ["title" => "", "author" => "", "genre" => "", "publication_year" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));

    if (empty($book["title"])) {
        $errors["title"] = "Book title is required";
    } elseif ($libraryObj->bookTitleExist($book["title"])) {
        $errors["title"] = "This book title already exists.";
    }

    if (empty($book["author"])) {
        $errors["author"] = "Please add author";
    }

    if (empty($book["genre"])) {
        $errors["genre"] = "Please select genre";
    }

    if (empty($book["publication_year"])) {
        $errors["publication_year"] = "Published when?";
    } elseif ($book["publication_year"] > date('Y')) {
        $errors["publication_year"] = "Invalid Book Year";
    }

    if (empty(array_filter($errors))) {
        $libraryObj->title = $book["title"];
        $libraryObj->author = $book["author"];
        $libraryObj->genre = $book["genre"];
        $libraryObj->publication_year = $book["publication_year"];

        if ($libraryObj->addBook()) {
            header("Location: viewBook.php");
            exit;
        } else {
            echo "FAILED";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        label { 
            display: block; 
        }
        span, .error { 
            color: red; 
            margin: 0; 
        }
    </style>
</head>
<body>
    <h1>Add Book</h1>
    <form action="" method="post">
        <label>Field with <span>*</span> is required</label>

        <label for="title">Book Title <span>*</span></label>
        <input type="text" name="title" id="title" value="<?= $book["title"] ?>">
        <p class="error"><?= $errors["title"] ?></p>

        <label for="author">Book Author <span>*</span></label>
        <input type="text" name="author" id="author" value="<?= $book["author"] ?>">
        <p class="error"><?= $errors["author"] ?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">--- Select Genre</option>
            <option value="History" <?= ($book["genre"] == "History") ? "selected" : "" ?>>History</option>
            <option value="Science" <?= ($book["genre"] == "Science") ? "selected" : "" ?>>Science</option>
            <option value="Fiction" <?= ($book["genre"] == "Fiction") ? "selected" : "" ?>>Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"] ?></p>

        <label for="publication_year">Publication Year <span>*</span></label>
        <input type="text" name="publication_year" id="publication_year" value="<?= $book["publication_year"] ?>">
        <p class="error"><?= $errors["publication_year"] ?></p>
        <br>

        <input type="submit" value="Save Book">
    </form>

    <br>
    <button><a href="viewBook.php">View Books</a></button>
</body>
</html>