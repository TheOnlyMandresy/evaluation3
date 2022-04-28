<?php use System\Tools\FormTool; ?>

<?php ob_start(); ?>

<h1>Pays et Nationalité</h1>

<form method="POST">
    <?= FormTool::input('text', 'country', 'Pays'); ?>
    <?= FormTool::input('text', 'nationality', 'Nationalité du pays'); ?>
    <?= FormTool::button('Nouveau pays', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste</h2>
<?php if ($all): ?>

    <?php foreach ($all as $data): ?>    
    <div class="box">
        <h3><?= $data->country; ?></h3>
        <p><?= $data->nationality; ?></p>
    </div>
    <?php endforeach; ?>

<?php else: ?>
    <p class="empty">Vide.</p>
<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>