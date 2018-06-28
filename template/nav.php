<nav>
    <div class="nav-wrapper light-blue darken-3">
        <span class="left brand-logo"> Hello, <?php echo (isset($_SESSION['login']))? $_SESSION['login'] : "stranger" ?>.</span>
        <ul class="right">
            <li><a href='./index.php'>Home page</a></li>
            <li><a href='./product-list.php'>Shop</a></li>
            <?php echo (isset($_SESSION['login']))? "<li><a href='./authentification.php'>Logout</a></li>" : "<li><a href='./login.php'>Login</a></li>"; ?>
        </ul>
    </div>
</nav>