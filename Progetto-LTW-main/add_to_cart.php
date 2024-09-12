<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" media="screen and (min-width: 1231px)" href="css/PC_add_to_cart.css">
    <link rel="stylesheet" media="screen and (min-width: 601px) and (max-width: 1230px)" href="css/Tablet_add_to_cart.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="css/Smartphone_add_to_cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart - Bestway Streetwear</title>
    <link rel="icon" type="image/png" href="immagini/bws_logo.png">
	<link rel="shortcut icon" type="image/png" href="immagini/bws_logo.png">
</head>
<body>

    <?php
         session_start();
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: /");
        }
        else {
            $dbconn = pg_connect("host=localhost password=bestwaystreetwear_85 
                    user=postgres port=5432 dbname=bestway_streetwear_DB") 
                    or die("Errore di connessione: " . pg_last_error());
        }

        if ($dbconn) {
            $utente = $_POST['utente'];
            $code = $_POST['code'];
            $colore = $_POST['colore'];
            $taglia = $_POST['taglia'];

            $check_available = "select pezzi_disponibili from taglia where code = $1 and colore = $2 and taglia = $3";
            $result = pg_query_params($dbconn, $check_available, array($code, $colore, $taglia));
            $array = pg_fetch_array($result, null, PGSQL_ASSOC);
            $pezzi_disponibili = $array['pezzi_disponibili'];

            if($pezzi_disponibili > 0) {
                $q1 = "select * from carrello where utente = $1 and prodotto_code = $2 and prodotto_colore = $3 and prodotto_taglia = $4";
                $result1 = pg_query_params($dbconn, $q1, array($utente, $code, $colore, $taglia));
                $array1 = pg_fetch_array($result1, null, PGSQL_ASSOC);

                if($array1) {
                    $quantità = $array1['quantità'] + 1;
                    $update_cart = "update carrello set quantità = $1 where utente = $2 and prodotto_code = $3 and prodotto_colore = $4 and prodotto_taglia = $5";
                    $data = pg_query_params($dbconn, $update_cart, array($quantità, $utente, $code, $colore, $taglia));
                }

                else {
                    $quantità = 1;
                    $add_to_cart = "insert into carrello (utente, prodotto_code, prodotto_colore, prodotto_taglia, quantità) values ($1,$2,$3,$4,$5)";
                    $data = pg_query_params($dbconn, $add_to_cart, array($utente, $code, $colore, $taglia, $quantità));
                }


                if ($data) {
                    echo '
                    <div class="addtocart">
                    <img src="immagini/bws_logo.png" style="margin-top: 3%">
                    <br>
                    Prodotto aggiunto al carrello! 
                    <br>
                    <a href="home.html">Continua a comprare</a>
                    <br>
                    <form action="carrello.php" method="post">
                        <input type="text" name="utente" value="' . $utente . '" style="display:none;">
                        <input type="text" name="op" value="" style="display: none;">
                        <input type="text" name="prodotto_code" value="" style="display: none;">
                        <input type="text" name="prodotto_colore" value="" style="display: none;">
                        <input type="text" name="prodotto_taglia" value="" style="display: none;">
                        <button class="btn btn-dark btn-rounded" style="margin-top:2%">
                                <input type="submit" style="display:none;">Vai al carrello
                        </button>
                    </form>
                    </div>
                    ';
                }
            }

            else {
                echo '
                <div class="addtocart">
                Prodotto non disponibile.
                Torna alla<a href="home.html"> Home</a>
                </div>';
            }

        }

    ?>

</body>
</html>