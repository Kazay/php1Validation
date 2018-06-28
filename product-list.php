<?php

session_start();
require_once('template/header.html');
require_once('template/nav.php');
?>
<main class="container">
    <div class="row">
    <h3>Don't be shy, buy.</h3>
    <h2>Products list</h2>
    <section class="col m8">
        
        <div class="row">
        <?php 
            $productList = [];

            $productJSON = file_get_contents("products.txt");
            if($productJSON != "")
                {
                    $productList = unserialize($productJSON);
                }

            if(count($productList) >0) {
            foreach($productList as $product)
            {
                 echo '<div class="col m12 l6">
                         <form action="./cart.php" method="POST">
                            <div class="card light-blue darken-4">
                                <div class="card-content white-text">
                                    <span class="card-title">' . $product['name'] . '</span>
                                    <p>Prix: ' . $product['price'] . '€</p>
                                    <br>
                                    <p>Description: ' . $product['description'] . '</p>
                                    <input type="hidden" name="productName" value=' . $product['name'] . '>
                                    <input type="hidden" name="productPrice" value=' . $product['price'] . '>
                                    <input type="hidden" name="productDescription" value=' . $product['description'] . '>
                                    </div>
                                    <div class="card-action">';
                                    if(isset($_SESSION['login']))
                                    {
                                        echo '<button class="btn waves-effect waves-light" type="submit" name="action">Add to cart
                                                <i class="material-icons right">send</i>
                                            </button>';
                                    }
                                    else
                                    {
                                        echo '<button class="btn waves-effect waves-light disabled" type="submit" name="action">Log in to add to cart
                                                <i class="material-icons right">send</i>
                                            </button>';
                                    }
                                    
                                    echo '</div></div></form></div>';
                    }
                }
                ?>
         </div>
    </section>
    <section class="col m4">
    <h5>Gotta buy them all.</h5>
        <h4>Your cart :</h4>
        <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(isset($_SESSION['login']))
            {
                $cookieName = 'cart-' . str_replace('.', '_', $_SESSION['login']);

                if(isset($_COOKIE[$cookieName]))
                {
                    $clientCart = unserialize($_COOKIE[$cookieName]);
                    foreach($clientCart['products'] as $products)
                    {
                        echo "<tr>";
                        echo "<td>" . $products['name'] . "</td>";
                        echo "<td>" . $products['quantity'] . "</td>";
                        echo "<td>" . $products['price'] . " €</td>";
                        echo "</tr>";
                    }
                    echo "<tr><td>Total :</td><td></td><td>" . $clientCart['prixTotal'] . " €</td></tr>";
                }
                else
                {
                    echo "<td>Your cart is empty</td>";
                }
            }
            else
            {
                echo "<td>Log in to add products to your cart</td>";
            }
            ?>
        </tbody>
        </table>
        <?php
       if(isset($_SESSION['login']) && isset($_COOKIE[$cookieName]))
       {
            echo '<br><button class="btn waves-effect waves-light" type="submit" name="action">Checkout
                    <i class="material-icons right">send</i>
                    </button>';
       }
       ?>
        <br><br><br>
        <h5>The more, the better.</h5>
        <h4>Add a Product</h4>
        <form action="./products.php" method="POST">
            <div class="input-field">
                <label for="productName">Product name</label>
                <input type="text" name="productName" required>
            </div>
            <div class="input-field">
                <label for="price">Price</label>
                <input type="number" name="price" required>
            </div>
            <div class="input-field">
                <label for="description">Description</label>
                <textarea id="description" class="materialize-textarea" name="description"></textarea>
            </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Add a product
                <i class="material-icons right">send</i>
            </button>
        </form>
    </section>
    </div>
</main>

<?php
require_once('template/footer.html');
?>