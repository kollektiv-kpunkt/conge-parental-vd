<?php
$signatures = do_shortcode( "[demovox_count]");
$needed = 5000;
$percentage = round($signatures / $needed * 100, 2);
if ($percentage >= 100) {
    $percentage = 100;
}

?>

<div id="cpv-lander">
    <div id="cpv-lander-image" class="cpv-lander-half">
        <?php
        $attachment_id = 28901;
        $img_src = wp_get_attachment_image_url( $attachment_id, 'full' );
        ?>
        <img src="<?php echo esc_url( $img_src ); ?>" alt="baby holding hand of father">
    </div>
    <div id="cpv-lander-content" class="cpv-lander-half">
        <div id="cpv-lander-inner">
            <div id="cpv-lander-wrapper">
                <h1 id="cpv-lander-title">POUR UN CONGÉ PARENTAL VAUDOIS&nbsp;!</h1>
                <p>
                    -  Renforcer l'égalité entre les femmes et les hommes<br>
                    -  Améliorer la conciliation entre famille et travail<br>
                    -  Offrir à tous les parents les mêmes possibilités à la naissance d'un enfant<br>
                </p>
                <div id="cpv-lander-counter-container" style="--percentage: <?= $percentage ?>%;">
                    <div id="cpv-counter-numbers">
                        <span id="cpv-counter-signatures"><?= number_format($signatures, 0, ',', "'") ?></span>
                        <span id="cpv-counter-needed"><?= number_format($needed, 0, ',', "'") ?></span>
                    </div>
                    <div id="cpv-counter-bar">
                        <div id="cpv-counter-bar-inner"></div>
                    </div>
                </div>
                <?php
                echo(do_shortcode( "[demovox_form]"))
                ?>
            </div>
        </div>
    </div>
</div>