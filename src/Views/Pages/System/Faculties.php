<?php use System\Tools\FormTool; ?>

<?php ob_start(); ?>

<h1 data-section="faculties">Facultés d'agent</h1>

<form method="POST" autocomplete="off">
    <?= FormTool::input('text', 'name', 'Faculté'); ?>
    <?= FormTool::button('Nouvelle faculté', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste <input id="search" type="input" autocomplete="off" placeholder="Recherche par faculté" /></h2>
<?php if ($all): ?>

    <?php foreach ($all as $data): ?>    
    <div class="box" data-id="<?= $data->id; ?>">
        <p><?= $data->name; ?></p>
        
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