<?php use System\Tools\FormTool; ?>

<?php ob_start(); ?>

<h1>Facultés d'agent</h1>

<form method="POST">
    <?= FormTool::input('text', 'name', 'Faculté'); ?>
    <?= FormTool::button('Nouvelle faculté', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste</h2>
<?php if ($all): ?>

    <?php foreach ($all as $data): ?>    
    <div class="box">
        <h3><?= $data->name; ?></h3>
    </div>
    <?php endforeach; ?>

<?php else: ?>
    <p class="empty">Vide.</p>
<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>