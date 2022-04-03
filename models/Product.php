<?php

namespace app\models;
use app\Database;
use app\helpers\UtilHelper;

class Product {
    public ?int $id = null;
    public ?string $name = null;
    public ?string $desc = null;
    public ?string $imagePath = null;
    public ?float $price = null;

    public ?array $imageFile = null;

    public function load($data){
        /* Gets data from POST */
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->desc = $data['desc'] ?? '';
        $this->price = $data['price'];
        $this->imageFile = $data['imageFile'] ?? null;
        $this->imagePath = $data['imagePath'] ?? null;
    }
    public function save(){
        $errors = [];
        if (!$this->name){
            $errors[] = 'Product name missing';
        }
        if (!$this->price){
            $errors[] = 'Product price missing';
        }
        if(!is_dir(__DIR__.'/../public/images')){
            mkdir(__DIR__.'/../public/images');
        }

        if (empty($errors)) {
            if ($this->imageFile && $this->imageFile['tmp_name']) {
                if ($this->imagePath && !($this->imagePath === "default.png")) {
                    unlink(__DIR__ . '/../public/' . $this->imagePath);
                }
                $this->imagePath = 'images/' . UtilHelper::randomString(8) . '/' . $this->imageFile['name'];
                mkdir(dirname(__DIR__ . '/../public/' . $this->imagePath));
                move_uploaded_file($this->imageFile['tmp_name'], __DIR__ . '/../public/' . $this->imagePath);
            }

            $db = Database::$db;
            if ($this->id) {
                $db->updateProduct($this);
            } else {
                $db->createProduct($this);
            }

        }
        return $errors;
    }
}

?>