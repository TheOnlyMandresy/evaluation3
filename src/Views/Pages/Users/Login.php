<?php
    use System\Tools\FormTool;
?>


<?php ob_start(); ?>

<h1>Identifiez-vous</h1>
<form method="POST" autocomplete="off">
    <?= FormTool::input('text', 'email', 'Email'); ?>
    <?= FormTool::input('password', 'password', 'Mot de passe'); ?>

    <?= FormTool::button('Connexion', 'login', 'success'); ?>
</form>

<?php $content = ob_get_clean(); ?>