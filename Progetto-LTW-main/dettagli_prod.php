<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    
    <link rel="stylesheet" media="screen and (min-width: 1231px)" href="css/PC_dettagli_prod.css">
    <link rel="stylesheet" media="screen and (min-width: 601px) and (max-width: 1230px)" href="css/Tablet_dettagli_prod.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="css/Smartphone_dettagli_prod.css">
    
    <link rel="stylesheet" media="screen and (min-width: 1231px)" href="css/PC_home.css">
    <link rel="stylesheet" media="screen and (min-width: 601px) and (max-width: 1230px)" href="css/Tablet_home.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="css/Smartphone_home.css">
    
    <link rel="stylesheet" href="css/footer.css">
    <link rel="icon" type="image/png" href="immagini/bws_logo.png">
	<link rel="shortcut icon" type="image/png" href="immagini/bws_logo.png">
    <title>Dettaglio Prodotto - Bestway Streetwear</title>

    <script>
        function checkTaglia() {
            if(document.addToCart.taglia.value == "") {
                alert("Per aggiungere un prodotto al carrello seleziona prima la tua taglia");
                return false;
            }
        }
    </script>

</head>
<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
   
    <div id="navbar"></div>

    <div class="sconto">
        <form action="sconto.php" method="post">
            <input type="text" name="codice" value="" style="display: none;">
            <button style="border:none; background-color: #02b49c; color:white;">
                <input type="submit" style="display: none;">
                Ottieni il 20% di sconto!
            </button>
        </form>
    </div>

    <br>
        
    <div class="product">
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
                $code = $_POST['code'];
                $colore = $_POST['colore'];
                
                $q1 = "select * from prodotto where code = $1 and colore = $2";
                $result = pg_query_params($dbconn, $q1, array($code, $colore));
                $prodotto = pg_fetch_array($result, null, PGSQL_ASSOC);
                if($prodotto) {

                    $q2 = "select * from prodotto where code = $1";
                    $result2 = pg_query_params($dbconn, $q2, array($code));
                    $prodotti_colore = pg_fetch_all($result2, PGSQL_ASSOC);

                    $q3 = "select * from taglia where code = $1 and colore = $2";
                    $result3 = pg_query_params($dbconn, $q3, array($code, $colore));
                    $taglie = pg_fetch_all($result3, PGSQL_ASSOC);

                    echo '
                    
                    <div id="carouselExampleIndicators" class="carousel slide imgprod">

                        <div class="carousel-indicators" style="">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="immagini/Prodotti/' . $prodotto["immagine1"] . '" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="immagini/Prodotti/' . $prodotto["immagine2"] . '" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="immagini/Prodotti/' . $prodotto["immagine3"] . '" class="d-block w-100" alt="...">
                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                    </div>

                    <div class="textprod">

                        <h3 style="font-weight: bold;">' . $prodotto["nome"] . '</h3>
                        <div>' . $prodotto["categoria"] . ' - '. UomoDonna($prodotto["sesso"]) .  '</div>
                            <br>
                            '. $prodotto["prezzo"] . ' $
                            <br>
                            <br> 
                            <div style="display: grid; grid-template-columns: 90px 90px 90px;">
                                '
                                .
                                colorazioni($prodotti_colore)
                                . 
                                '
                            </div>

                            <br>
                            <br>

                            
                            <form name="addToCart" action="add_to_cart.php" method="post" onsubmit="return checkTaglia()">
                                <p>Seleziona la taglia: <p>
                                <div style="display: grid; grid-template-columns: 75px 75px 75px;">
                                    '
                                    .
                                    taglie2($taglie)     // controllo js taglia non selezionata
                                    . 
                                    '
                                </div>

                                <br>
                                <br>
                            
                                <input type="text" name="utente" value="' . $_SESSION["utente"] . '" style="display:none;">
                                <input type="text" name="code" value="' . $prodotto["code"] . '" style="display:none;">
                                <input type="text" name="colore" value="' . $prodotto["colore"] . '" style="display:none;">
                                <button class="btn btn-dark btn-rounded">
                                    <input type="submit" style="display:none;">
                                    Aggiungi al carrello
                                </button>
                            </form>

                        </div>
                    
                </div>

                    <br>
                    <br>

                    <div class="description">
                        <p style="font-weight: bold;">Descrizione:<p>
                        <p>' . $prodotto["descrizione"] . '<p>
                    </div>
                    ';
                }
            }

        ?>
    </div>

    <br>

    <!-- Footer -->
    <footer class="text-center text-white" style="background-color: #000000;">

        <div class="container pt-4">
            <section class="mb-4">

                <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#02b49c" class="bi bi-instagram" viewBox="0 0 16 16">
                       <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                    </svg>
                </a>

                <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#02b49c" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                    </svg>
                </a>

                <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#02b49c" class="bi bi-google" viewBox="0 0 16 16">
                        <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                    </svg>
                </a>
      
                <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#02b49c" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                    </svg>
                </a>  
                  
          </section>
        </div>
      
        <div class="text-center p-3 copyright" style="background-color: rgb(15, 15, 15);">
          © 2022 Copyright:
          <a class="link-secondary copyright" href="https://mdbootstrap.com/">BestwayStreetwear.com</a>
        </div>

    </footer>

    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#navbar").load("navbar.html");
        });
    </script>

    <?php

        function colorazioni($prodotti_colore) {
            $s = '';
            foreach ($prodotti_colore as $index => $var) {
                $s = $s . '
                <form action="dettagli_prod.php" method="post">
                    <input type="text" name="code" value="' . $var["code"] . '" style="display: none;">
                    <input type="text" name="colore" value="' . $var["colore"] . '" style="display:none;">
                    <button style="border-radius: 4px;">
                        <input type="submit" style="display:none;">
                        <img style="width: 70px;" src="immagini/Prodotti/' . $var["immagine1"] . '">   
                    </button>

                </form>
                ';
            }
            return $s;
        }

        function taglie($taglie) {
            $s = '';
            foreach ($taglie as $index => $var) {
                $s = $s . '
                    <input type="radio" name="taglia" value="' . $var["taglia"] . '">
                        '
                        . $var["taglia"] .
                        '
                    </input>
                ';
            }
            return $s;
        }

        function taglie2($taglie) {
            $s = '';
            foreach ($taglie as $index => $var) {
                $s = $s . '
                <input type="radio" class="btn-check" name="taglia" id="'. $var["taglia"] .'" value="'. $var["taglia"] .'" style="padding-right: 2px;">
                    <label class="btn btn-outline-dark" for="'. $var["taglia"] .'" style="margin-right: 10%;">' . $var["taglia"] . '</label>
                </input>
                ';
            }
            return $s;
        }




        function UomoDonna($var) {
            if ($var == 'M') {
                return 'Uomo';
            }
            else {
                return 'Donna';
            }
        }

    ?>

</body>
</html>

