<?php

namespace app\controllers;
use app\Router;
use app\models\Product;

class MainController {
    public static function index(Router $router){
        $router->renderView("index");
    }
    public static function shop(Router $router){
        $_SESSION['page'] = $_GET['page'];
        $search = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);
        // Make sure you cannot go out of bounds like page=-5 or page=3 if there are less than 20
        if($_SESSION['page'] < 1){
            $_SESSION['page'] = 1;
            header("Location: /shop?search=$search&page=1");
            exit;
        }
        if(count($products) > 0 && ceil(count($products)/10) < $_SESSION['page']){
            $_SESSION['page'] = ceil(count($products)/10);
            header("Location: /shop?search=$search&page=" . $_SESSION['page']);
            exit;
        }
        $router->renderView("shop", [
            'products' => $products,
            'search' => $search
        ]);
    }
    public static function login(Router $router){
        $errors = [];
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $user = $_POST['user'];
            $pass = md5($_POST['pass']);
            if ($user === "admin" && $pass === md5("123")){
                $_SESSION['admin'] = true;
                header("Location: /admin");
                exit;
            }else{
                $errors[] = "Invalid User/Password combination!";
            }
        }
        $router->renderView("login", [
            'errors' => $errors
        ]);
    }
    public static function logout(){
        session_destroy();
        header("Location: /");
        exit;
    }
    public static function adminIndex(Router $router){
        if($_SESSION['admin']){
            $_SESSION['page'] = $_GET['page'];
            $search = $_GET['search'] ?? '';
            $products = $router->db->getProducts($search);
            if($_SESSION['page'] < 1){
                $_SESSION['page'] = 1;
                header("Location: /admin?search=$search&page=1");
                exit;
            }
            if(count($products) > 0 && ceil(count($products)/10) < $_SESSION['page']){
                $_SESSION['page'] = ceil(count($products)/10);
                header("Location: /admin?search=$search&page=" . $_SESSION['page']);
                exit;
            }
            $router->renderView('admin/index', [
                'products' => $products,
                'search' => $search
            ]);
        }else{
            header("Location: /login");
        }
    }

    public static function create(Router $router){
        if($_SESSION['admin']){
            $errors = [];
            $productData = [
                'name' => '',
                'desc' => '',
                'image' => '',
                'price' => ''
            ];
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $productData['name'] = $_POST['name'];
                $productData['desc'] = $_POST['desc'];
                $productData['price'] = (float)$_POST['price'];
                $productData['imageFile'] = $_FILES['image'] ?? null;

                $product = new Product();
                $product->load($productData);
                $errors = $product->save();
                if(empty($errors)){ 
                    header("Location: /admin");
                    exit;
                }
            }

            $router->renderView('admin/create', [
                'product' => $productData,
                'errors' => $errors
            ]);
        }else{
            header("Location: /login");
        }
    }

    public static function update(Router $router){
        if($_SESSION['admin']){
            $id = $_GET['id'] ?? null;
            if(!$id){
                header("Location: /admin");
                exit;
            }
            $productData = $router->db->getProductById($id); // JSDOM PTSD

            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $productData['id'] = $id;
                $productData['name'] = $_POST['name'];
                $productData['desc'] = $_POST['desc'];
                $productData['price'] = (float)$_POST['price'];
                $productData['imageFile'] = $_FILES['image'] ?? null;
                $productData['imagePath'] = $productData['image'];

                $product = new Product();
                $product->load($productData);
                $errors = $product->save();
                if(empty($errors)){
                    header("Location: /admin");
                    exit;
                }
            }

            $router->renderView('admin/update', [
                'product' => $productData,
                'errors' => $errors
            ]);
        }else{
            header("Location: /login");
        }
    }

    public static function delete(Router $router){
        if($_SESSION['admin']){
            $id = $_POST['id'] ?? null;
            if (!$id){
                header("Location: /admin");
                exit;
            }
            $router->db->deleteProduct($id);
            header("Location: /admin");
        }else{
            header("Location: /login");
        }

    }
}

?>