<?php
echo(do_shortcode( "[demovox_form]" ))
?>
<div id="cpv-order-sheet-container">
    <h3>Vous n'avez pas d'imprimante&nbsp;?</h3>
    <p>Nous vous enverrons volontiers une feuille de signatures à votre domicile&nbsp;!</p>
    <a href="#" class="button" id="cpv-order-sheet-button" data-sheet-guid=<?= $_GET["sign"] ?>>Commander ma feuille</a>
</div>

<div id="cpv-share-container">
    <h3>Partagez votre soutien !</h3>
    <textarea name="sharemsg" id="sharemsg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur voluptatibus provident soluta aperiam, blanditiis maxime mollitia suscipit voluptas porro libero veritatis quisquam? Temporibus maxime repellat in nobis fugiat et animi!</textarea>
    <div class="boettens">
        <a href="#" class="button" id="whatsapp">WhatsApp</a>
        <a href="#" class="button" id="telegram">Telegram</a>
        <a href="#" class="button" id="facebook">Facebook</a>
        <a href="#" class="button" id="twitter">Twitter</a>
        <a href="#" class="button" id="email">E-Mail</a>
    </div>
</div>