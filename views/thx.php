<?php
echo(do_shortcode( "[demovox_form]" ))
?>

<div id="cpv-share-container">
    <h3>Partagez votre soutien !</h3>
    <div id="cpv-share-inner">
        <textarea name="sharemsg" id="sharemsg">Bonjour!
Je viens de signer l'initiative pour un congé parental dans le Canton de Vaud. Pour plus d'égalité entre les femmes et les hommes, et pour faciliter la conciliation entre famille et travail. Comment signer aussi? C'est simple, c'est ici, et on peut même le faire en ligne!</textarea>
        <div class="boettens">
            <a href="#" class="boetten" id="whatsapp">WhatsApp</a>
            <a href="#" class="boetten" id="telegram">Telegram</a>
            <a href="#" class="boetten" id="facebook">Facebook</a>
            <a href="#" class="boetten" id="twitter">Twitter</a>
            <a href="#" class="boetten" id="threema">Threema</a>
            <a href="#" class="boetten" id="email">E-Mail</a>
        </div>
    </div>
</div>

<div id="cpv-order-sheet-container">
    <h3>Vous n'avez pas d'imprimante&nbsp;?</h3>
    <p>Nous vous enverrons volontiers une feuille de signatures à votre domicile&nbsp;!</p>
    <a href="#" class="button" id="cpv-order-sheet-button" data-sheet-guid=<?= $_GET["sign"] ?>>Commander ma feuille</a>
</div>
