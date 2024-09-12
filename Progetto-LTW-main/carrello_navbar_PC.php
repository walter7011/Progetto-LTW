<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello Navbar PC</title>
</head>
<body>
    
    <?php
        session_start();
        echo '
        <form action="carrello.php" method="post">
            <input type="text" name="utente" value="' . $_SESSION["utente"] . '" style="display: none;">
            <input type="text" name="op" value="" style="display: none;">
            <input type="text" name="prodotto_code" value="" style="display: none;">
            <input type="text" name="prodotto_colore" value="" style="display: none;">
            <input type="text" name="prodotto_taglia" value="" style="display: none;">
                <button class="sub_novita" style="text-align: center;">
                    Carrello
                    <input type="submit" style="display:none;">
                </button>
        </form>';

    ?>

    <!--    <li>
                <form action="carrello.php" method="post">
                    <input type="text" name="utente" value="" style="display: none;">
                    <button class="sub_novita" style="text-align: center;">
                            Carrello
                        <input type="submit" style="display:none;">
                    </button>
                </form>        
            </li>



            <li class="nav-item">
                <form action="carrello.php" method="post">
                     <input type="text" name="utente" value="" style="display: none;">
                         <button class="sub_novita" style="text-align: left;">
                               Carrello
                               <input type="submit" style="display:none;">
                         </button>
                </form>
            </li>
    -->




</body>
</html>