<?php
require_once "../classes/library.php";
$libraryObj = new Library();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter = isset($_GET['genre']) ? trim($_GET['genre']) : '';

$books = $libraryObj->viewBook($search, $filter);
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
    <button><a href="addBook.php">Add Another Book</a></button>

    <form method="get" action="">
        <input type="text" name="search" placeholder="Search by title or author" value="<?= htmlspecialchars($search) ?>">
        <select name="genre">
            <option value="">-- Genres --</option>
            <option value="History" <?= ($filter == "History") ? "selected" : "" ?>>History</option>
            <option value="Science" <?= ($filter == "Science") ? "selected" : "" ?>>Science</option>
            <option value="Fiction" <?= ($filter == "Fiction") ? "selected" : "" ?>>Fiction</option>
        </select>
        <button type="submit">Search</button>
        <button type="button" onclick="window.location='viewBook.php'">Reset</button>
    </form>

    <br>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Title Name</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
        </tr>

        <?php
        $id = 1;
        if (!empty($books)) {
            foreach ($books as $book) {
                echo "<tr>
                        <td>{$id}</td>
                        <td>{$book['title']}</td>
                        <td>{$book['author']}</td>
                        <td>{$book['genre']}</td>
                        <td>{$book['publication_year']}</td>
                    </tr>";
                $id++;
            }
        } else {
            echo "<tr><td colspan='5'>Book not found</td></tr>";
        }
        ?>
    </table>
</body>
</html>