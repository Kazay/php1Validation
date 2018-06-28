<?php

session_start();
require_once('template/header.html');
require_once('template/nav.php');

if(isset($_SESSION['success']) && $_SESSION['success'] != "")
{
    echo '<div class="row">
            <div class="col s12">
                <div class="card-panel center-align green darken-3">
                    <span class="white-text">'. $_SESSION['success'] . '</span>
                </div>
            </div>
        </div>'; 
    unset($_SESSION['success']);
}
?>

<main class="container">
    <div class="row">
        <section class="col m8">
        <h1>Welcome to hell, <?php echo (isset($_SESSION['login']))? $_SESSION['login']: "stranger";?>.</h1>
        <p>My money's in that office, right? If she start giving me some bullshit about it ain't there, and we got to go someplace else and get it, I'm gonna shoot you in the head then and there. Then I'm gonna shoot that bitch in the kneecaps, find out where my goddamn money is. She gonna tell me too. Hey, look at me when I'm talking to you, motherfucker. You listen: we go in there, and that nigga Winston or anybody else is in there, you the first motherfucker to get shot. You understand? </p>
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
       </section>
    </div>
</main>

<?php
require_once('template/footer.html');
?>