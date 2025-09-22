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
                VALUES (:title, :author, :genre, :publication_year)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);

        return $query->execute();
    }

    public function bookTitleExist($title){
        $sql = "SELECT COUNT(*) FROM book WHERE title = :title";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $title);
        $query->execute();
        return $query->fetchColumn() > 0;
    }

    public function viewBook($search = '', $filter = ''){
        $sql = "SELECT * FROM book WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (title LIKE :search OR author LIKE :search)";
            $params[':search'] = "%$search%";
        }

        if (!empty($filter)) {
            $sql .= " AND genre = :genre";
            $params[':genre'] = $filter;
        }

        $sql .= " ORDER BY title ASC";

        $query = $this->db->connect()->prepare($sql);

        foreach ($params as $key => &$val) {
            $query->bindParam($key, $val);
        }

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}