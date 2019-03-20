<?php

session_start();

$cookieName = 'cart-' . str_replace('.', '_', $_SESSION['login']);
if(isset($_COOKIE[$cookieName]))
{
    $clientCart = unserialize($_COOKIE[$cookieName]);
}

if(count($_POST) > 0)
{
    $productToAdd = [];
    $new = true;
    $productToAdd = ['name' => $_POST['productName'],
                    'price' => $_POST['productPrice'],
                    'quantity' => 1];

    if(isset($clientCart) && $clientCart != "")
    {
        $i = 0;

        foreach($clientCart['products'] as $products)
        {
            if($productToAdd['name'] == $products['name'])
            {
                $clientCart['products'][$i]['quantity']++;
                $clientCart['prixTotal'] = $clientCart['prixTotal'] + $products['price'];
                $new = false;
            }
            $i++;
        }
    }
    if($new)
    {
        if(!isset($clientCart))
        {
            $clientCart =[ 'client' => $_SESSION['login'],
                    'prixTotal' => $productToAdd['price'],
                    'products' => []];
        }
        else
        {
            $clientCart['prixTotal'] = $clientCart['prixTotal'] + $productToAdd['price'];
        }
        array_push($clientCart['products'], $productToAdd);
    }

    setcookie($cookieName, serialize($clientCart), time() + 3600);


}

header('Location: ./product-list.php');