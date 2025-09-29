<?php
require_once "../classes/book.php";
$libraryObj = new Library();

$search = "";
$genre = "";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $search = isset($_GET["search"])? trim(htmlspecialchars($_GET["search"])) : "";
    $genre = isset($_GET["genre"])? trim(htmlspecialchars($_GET["genre"])) : "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
</head>
<body>
    <h1>List of Books</h1>
    <form action="" method="get">
        <input type="search" name="search" id="search" value="<?= $search ?>">
        <select name="genre" id="genre">
                    <option value="" <?= empty($genre) ? "selected" : ""; ?>>All</option>
                    <option value="History" <?= $genre == "History" ? "selected" : ""; ?>>History</option>
                    <option value="Science" <?= $genre == "Science" ? "selected" : ""; ?>>Science</option>
                    <option value="Fiction" <?= $genre == "Fiction" ? "selected" : ""; ?>>Fiction</option>
        </select>
        <input type="submit" value="Search">
    </form>
    <button><a href="addBook.php">Add another book</a></button>
    
    <br>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Title Name</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
            <th>Action</th>
        </tr>

        <?php
        $id = 1;
        foreach($libraryObj->viewBook($search, $genre) as $book){
        ?>
        <tr>
            <td><?= $id++ ?></td>
            <td><?= $book["title"] ?></td>
            <td><?= $book["author"]  ?></td>
            <td><?= $book["genre"]  ?></td>
            <td><?= $book["publication_year"] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
