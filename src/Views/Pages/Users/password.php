<?php
    use System\Tools\FormTool;
?>


<?php ob_start(); ?>

<h1>Sécurier un mot de passe</h1>
<form method="POST" autocomplete="off">
    <?= FormTool::input('password', 'password', 'Mot de passe à sécuriser'); ?>

    <?= FormTool::button('Génerer', 'generate', 'success'); ?>
</form>

<?php if (isset($secure)): ?>
    <p>Votre mot de passe sécuriser est: <?= $secure; ?></p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>