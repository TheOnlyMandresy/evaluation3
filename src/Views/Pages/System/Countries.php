<?php use System\Tools\FormTool; ?>

<?php ob_start(); ?>

<h1 data-section="countries">Pays et Nationalité</h1>

<form method="POST" autocomplete="off">
    <?= FormTool::input('text', 'country', 'Pays'); ?>
    <?= FormTool::input('text', 'nationality', 'Nationalité du pays'); ?>
    <?= FormTool::button('Nouveau pays', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste <input id="search" type="input" autocomplete="off" placeholder="Recherche par pays" /></h2>
<?php if ($all): ?>

    <?php foreach ($all as $data): ?>    
    <div class="box" data-id="<?= $data->id; ?>">
        <h3><?= $data->country; ?></h3>
        <p data-nationality="<?= $data->nationality; ?>">Nationalité: <?= $data->nationality; ?></p>
        
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