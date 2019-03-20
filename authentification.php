<?php

session_start();

//Si on est déjà log, logout et nous redirige vers l'index
if(isset($_SESSION['login']))
    {
        unset($_SESSION['login']);
        header('Location: ./login.php');
        exit;
    }

if(count($_POST) > 0)
{
    $_SESSION['error'] = "";

    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    //Creation de compte
    if($_POST['signin'] == 1)
    {
        $regexPW = "/^.*(?=.{4,10})(?=.*\d)(?=.*[a-zA-Z]).*$/";
        $loginList = [];

        $passwordCheck = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);

        //On verifie si le mdp est valide, sinon on redirige vers la page de login
        if($password != $passwordCheck)
            $_SESSION['error'] .= 'Passwords do not match.';
        if(!preg_match($regexPW, $password))
            $_SESSION['error'] .= 'Passwords must be between 4 and 10 characters with at least one digit.';
        if($_SESSION['error'] != "")
        {
            header('Location: ./login.php');
            exit;
        }
        
        $newClient =    ['email' => $email,
                        'password' => sha1($password)];

        //On sauvegarde le nouveau client dans le fichier clients
        $loginFile = fopen("login.txt", "c");
        $loginJSON = file_get_contents("login.txt");
        if($loginJSON != "")
        {
            $loginList = unserialize($loginJSON);
        }
        array_push($loginList, $newClient);
        fwrite($loginFile, serialize($loginList));

        $_SESSION['success'] = "You are now registered. Congratulations, you can now login !";
        header('Location: ./login.php');

    }
    //Sinon, il s'agit d'une tentative de login
    else
    {
        $loginJSON = file_get_contents("login.txt");
        $loginList = unserialize($loginJSON);

        if(count($loginList) > 0)
        {
            //On verifie si le client match avec un client deja enregistre
            foreach($loginList as $login)
            {
                if($email == $login['email'] && sha1($password) == $login['password'])
                {
                    $_SESSION['login'] = $email;
                    $_SESSION['success'] = "You are now connected. Welcome back " . $email . " !";
                    header('Location: ./index.php');
                    exit;
                }
            }
        }
        $_SESSION['error'] = "Wrong email/password. Please retry.";
        header('Location: ./login.php');


    }
}