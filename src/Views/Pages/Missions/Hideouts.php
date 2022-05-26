<?php use System\Tools\FormTool; ?>

<?php ob_start(); ?>

<h1 data-section="hideouts">Les planques</h1>

<form method="POST" autocomplete="off">
    <?= FormTool::input('text', 'code', 'Code'); ?>
    <?= FormTool::input('text', 'address', 'Adresse'); ?>
    <?= FormTool::input('text', 'type', 'Type'); ?>
    <?= FormTool::select('country', 'Pays', $countries); ?>
    <?= FormTool::button('Nouvelle planque', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste <input id="search" type="input" autocomplete="off" placeholder="Recherche par code" /></h2>
<?php if ($all): ?>
    
    <?php foreach ($all as $data): ?>    
    <div class="box" data-id="<?= $data->id; ?>">
        <h3><?= $data->code; ?></h3>
        <p data-address="<?= $data->address; ?>">Adresse: <?= $data->address; ?></p>
        <p data-type="<?= $data->type; ?>">Type: <?= $data->type; ?></p>
        <p data-country="<?= $data->country; ?>">Pays: <?= $data->country; ?></p>

        <div class="buttons">
            <button class="btn-warning" data-edit="<?= $data->id; ?>">Modifier</button>
        </div>
    </div>
    <?php endforeach; ?>

<?php else: ?>
    <p class="empty">Vide.</p>
<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>