<?php

namespace app;
use PDO;

class Database {
    public PDO $pdo;
    public static Database $db;

    public function __construct(){
        $dbfile = __DIR__.'/cvjecara.db';
        $this->pdo = new PDO("sqlite:$dbfile");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    public function getProducts($search = ''){
        if ($search) {
            $stmn = $this->pdo->prepare('SELECT * FROM cvjece WHERE name LIKE :name');
            $stmn->bindValue(':name', "$search");
        }else{
            $stmn = $this->pdo->prepare('SELECT * FROM cvjece');
        }

        $stmn->execute();
        return $stmn->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createProduct(models\Product $product){
        $stmn = $this->pdo->prepare("INSERT INTO cvjece (name, image, desc, price)
                VALUES (:name, :image, :desc, :price)");
        $stmn->bindValue(':name', $product->name);
        $stmn->bindValue(':image', $product->imagePath ?? 'default.png');
        $stmn->bindValue(':desc', $product->desc);
        $stmn->bindValue(':price', $product->price);

        $stmn->execute();
    }

    public function updateProduct(models\Product $product){
        $stmn = $this->pdo->prepare("UPDATE cvjece SET name = :name, image = :image, 
        desc = :desc, price = :price WHERE ID = :id");
        $stmn->bindValue(':name', $product->name);
        $stmn->bindValue(':image', $product->imagePath ?? 'default.png');
        $stmn->bindValue(':desc', $product->desc);
        $stmn->bindValue(':price', $product->price);
        $stmn->bindValue(':id', $product->id);

        $stmn->execute();
    }

    public function deleteProduct($id){
        $stmn = $this->pdo->prepare('DELETE FROM cvjece WHERE ID = :id');
        $stmn->bindValue(':id', $id);
        $stmn->execute();
    }

    public function getProductById($id) {
        $stmn = $this->pdo->prepare('SELECT * FROM cvjece WHERE ID = :id LIMIT 1');
        $stmn->bindValue(':id', $id);
        $stmn->execute();
        
        return $stmn->fetch(PDO::FETCH_ASSOC);
    }
}

?>