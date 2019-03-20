<?php

session_start();

$productList = [];

$productJSON = file_get_contents("products.txt");
if($productJSON != "")
    {
        $productList = unserialize($productJSON);
    }

if(count($_POST) > 0)
{
    $productName = filter_var($_POST['productName'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);

    $newProduct =   ['name' => $productName,
                    'description' => $description,
                    'price' => $price];

    //On sauvegarde le nouveau produit dans le fichier produits
    $productFile = fopen("products.txt", "c");
    array_push($productList, $newProduct);
    fwrite($productFile, serialize($productList));
}

header('Location: product-list.php');



