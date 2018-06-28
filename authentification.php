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

    //Creation de compte
    if($_POST['signin'] == 1)
    {
        $regexPW = "/^.*(?=.{4,10})(?=.*\d)(?=.*[a-zA-Z]).*$/";
        $loginList = [];

        //On verifie si le mdp est valide, sinon on redirige vers la page de login
        if($_POST['password'] != $_POST['password2'])
            $_SESSION['error'] .= 'Passwords do not match.';
        if(!preg_match($regexPW, $_POST['password']))
            $_SESSION['error'] .= 'Passwords must be between 4 and 10 characters with at least one digit.';
        if($_SESSION['error'] != "")
        {
            header('Location: ./login.php');
            exit;
        }


        
        $newClient =    ['email' => $_POST['email'],
                        'password' => sha1($_POST['password'])];

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
                if($_POST['email'] == $login['email'] && sha1($_POST['password']) == $login['password'])
                {
                    $_SESSION['login'] = $_POST['email'];
                    $_SESSION['success'] = "You are now connected. Welcome back " . $_POST['email'] . " !";
                    header('Location: ./index.php');
                    exit;
                }
            }
        }
        $_SESSION['error'] = "Wrong email/password. Please retry.";
        header('Location: ./login.php');


    }
}