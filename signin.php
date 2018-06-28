<?php

require_once('template/header.html');
require_once('template/nav.php');
?>

<h2>Sign in</h2>
<form action="./authentification.php" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password">
    </div>
    <div>
        <label for="password2">Confirm Password</label>
        <input type="password" name="password2">
    </div>
    <div>
        <input type="submit" value="Sign in">
    </div>
</form>

<?php

require_once('template/footer.html');

?>