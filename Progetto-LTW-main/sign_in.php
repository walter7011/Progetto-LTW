<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" media="screen and (min-width: 1231px)" href="css\PC_sign_in_php.css">
    <link rel="stylesheet" media="screen and (min-width: 601px) and (max-width: 1230px)" href="css\Tablet_sign_in_php.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="css\Smartphone_sign_in_php.css">
   
    <link rel="icon" type="image/png" href="immagini/bws_logo.png">
	<link rel="shortcut icon" type="image/png" href="immagini/bws_logo.png">
    <title>Sign In - php</title>
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
            $q1 = "SELECT * FROM utenti WHERE email=$1";
            $result = pg_query_params($dbconn, $q1, array($email));
            if ($tuple = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo '<div class="message">
                        <br>
                        <img src="immagini/bws_logo.png">
                        <br>
                        <br>
                        Spiacente, l' . "'" . 'indirizzo email è già in uso, vai al <a href=login.html> login</a>
                    </div>';
                
            }
            else {
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $telephone = $_POST['telephone'];
                $birthdate = $_POST['birthdate'];
                $gender = $_POST['gender'];
                $q2 = "INSERT INTO utenti (first_name,surname,username,email,pswd,phone,birthdate,gender) VALUES ($1,$2,$3,$4,$5,$6,$7,$8)";
                $data = pg_query_params($dbconn, $q2, array($name, $surname, $username, $email, $password, $telephone, $birthdate, $gender));
                if ($data) {
                    echo '<div class="message">
                            <br>
                            <img src="immagini/bws_logo.png">
                            <br>
                            <br>
                            Registrazione completata! Effettua il <a href=login.html> login </a>
                        </div>';
                }
                else {
                    die("La registrazione non è andata a buon fine. Prova di nuovo");
                }
            }
        }

        pg_close($dbconn);

    ?>
</body>
</html>