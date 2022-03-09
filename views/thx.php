<?php
echo(do_shortcode( "[demovox_form]" ))
?>
<div id="cpv-order-sheet-container">
    <h3>Vous n'avez pas d'imprimante&nbsp;?</h3>
    <p>Nous vous enverrons volontiers une feuille de signatures à votre domicile&nbsp;!</p>
    <a href="#" class="button" id="cpv-order-sheet-button" data-sheet-guid=<?= $_GET["sign"] ?>>Commander ma feuille</a>
</div>