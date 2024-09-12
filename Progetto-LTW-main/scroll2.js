var thumb_count2;
var thumb_current2 = 5; // BLOCCO DI PARTENZA
var thumb_number2 = 8; // NUMERO DI BLOCCHI DI THUMB
function thumb_move2(where)
{
    // DECREMENTO E CAMBIO IMMAGINE PER LO SCORRIMENTO A SINISTRA
    if (where == "left")
    {
        if (thumb_current2 > 5) {
            thumb_current2--;
            document.getElementById("thumb_arrow_left2").className = "visibile2";
        }
        if (thumb_current2 == 5) document.getElementById("thumb_arrow_left2").className = "nascosta2";
        if (thumb_current2 < thumb_number2) {
            document.getElementById("thumb_img_right2").src = "thumb_img_right2.png";
            document.getElementById("thumb_arrow_right2").className = "visibile2";
            document.getElementById("vedi_tutte2").className = "nascosta2";
        }
    }
    // INCREMENTO E CAMBIO IMMAGINE PER LO SCORRIMENTO A DESTRA
    else
    {
        if (thumb_current2 < thumb_number2) {
            thumb_current2++;
            document.getElementById("thumb_arrow_right2").className = "visibile2";
            document.getElementById("thumb_arrow_left2").className = "visibile2";
            document.getElementById("vedi_tutte2").className = "nascosta2";
        }
        document.getElementById("thumb_img_left2").src = "thumb_img_left2.png";
        if (thumb_current2 == thumb_number2) {
            document.getElementById("thumb_arrow_right2").className = "nascosta2";
            document.getElementById("vedi_tutte2").className = "visibile2";
        }
    }
    // CAMBIO DEL BLOCCO DI THUMB DA VISUALIZZARE
    if (thumb_current2 <= thumb_number2)
    {
        for (thumb_count2=5; thumb_count2<thumb_number2+1; thumb_count2++)
        {
            document.getElementById("thumb_item_" + thumb_count2).className = "thumb_hide2";
            if (thumb_count2 == thumb_current2) document.getElementById("thumb_item_" + thumb_count2).className = "thumb_show2";
        }
    }
}