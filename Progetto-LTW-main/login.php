<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="immagini/bws_logo.png">
	<link rel="shortcut icon" type="image/png" href="immagini/bws_logo.png">
    <link rel="stylesheet" media="screen and (min-width: 1231px)" href="css\PC_login_php.css">
    <link rel="stylesheet" media="screen and (min-width: 601px) and (max-width: 1230px)" href="css\Tablet_login_php.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="css\Smartphone_login_php.css">
    <title>Login - php</title>
</head>
<body>
    <?php

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: /");
        }
        else {
            $dbconn = pg_connect("host=localhost password=bestwaystreetwear_85 
                    user=postgres port=5432 dbname=bestway_streetwear_DB") 
                    or die("Errore di connessione: " . pg_last_error());
        }

        if ($dbconn) {
            $email = $_POST['email'];
            $q1 = "select * from utenti where email= $1";
            $result = pg_query_params($dbconn, $q1, array($email));
            if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                echo '<div class="message">
                        <br>
                        <img src="immagini/bws_logo.png">
                        <br>
                        <br>
                        Non sembra che tu sia registrato. <a href=sign_in.html> Clicca qui per farlo </a>
                      </div>';
            }
            else {
                $password = $_POST['password'];
                $q2 = "select * from utenti where email = $1 and pswd = $2";
                $result = pg_query_params($dbconn, $q2, array($email,$password));
                if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                    echo '<div class="message">
                            <br>
                            <img src="immagini/bws_logo.png">
                            <br>
                            <br>
                            Password errata! <a href=login.html> Riprova</a>
                          </div>';
                }
                else {
                    session_start();
                    $_SESSION["utente"] = $email;
                    echo '<div class="message">
                            <br>
                            <img src="immagini/bws_logo.png">
                            <br>
                            <br>
                            <a href=home.html> Premi qui</a> per inziare a usare il sito
                          </div>';
                }
            }
        }
    ?> 
</body>
</html>