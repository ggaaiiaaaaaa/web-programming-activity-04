<?php

require_once "database.php";

class Library {
    public $id = "";
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year = "";

    protected $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function addBook(){
        $sql = "INSERT INTO book (title, author, genre, publication_year) 
                VALUE (:title, :author, :genre, :publication_year)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);

        return $query->execute();
    }

    public function bookTitleExist($title){
        $sql = "SELECT COUNT(*) as total_books FROM books WHERE title = :title and id <> :id";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(":title", $bookTitle);
        $query->bindParam(":id", $bookId);
        $record = NULL;

        if ($query->execute()) {
            $record = $query->fetch();
        }
        
        if($record["total_books"] > 0){
            return true;
        }else{
            return false;
        }
    }

    public function viewBook($search = "", $genre = "") {
        $sql = "SELECT * FROM books WHERE 1=1";

        if (!empty($search)) {
            $sql .= " AND title LIKE CONCAT('%', :search, '%')";
        }
    
        if (!empty($genre)) {
            $sql .= " AND genre = :genre";
        }

        $sql .= " ORDER BY title ASC";

        $query = $this->db->connect()->prepare($sql);

        if (!empty($search)) {
            $query->bindParam(":search", $search);
        }
    
        if (!empty($genre)) {
            $query->bindParam(":genre", $genre);
        }

        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

}
