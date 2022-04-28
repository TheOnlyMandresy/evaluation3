<?php use System\Tools\FormTool; ?>

<?php ob_start(); ?>

<h1>Types de mission</h1>

<form method="POST">
    <?= FormTool::input('text', 'code', 'Code'); ?>
    <?= FormTool::input('text', 'address', 'Adresse'); ?>
    <?= FormTool::input('text', 'type', 'Type'); ?>
    <?= FormTool::select('country', 'Pays', $countries); ?>
    <?= FormTool::button('Nouvelle planque', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste</h2>
<?php if ($all): ?>
    
    <?php foreach ($all as $data): ?>    
    <div class="box">
        <h3><?= $data->code; ?></h3>
        <p>Adresse: <?= $data->address; ?></p>
        <p>Type: <?= $data->type; ?></p>
        <p>Pays: <?= $data->country; ?></p>
    </div>
    <?php endforeach; ?>

<?php else: ?>
    <p class="empty">Vide.</p>
<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>