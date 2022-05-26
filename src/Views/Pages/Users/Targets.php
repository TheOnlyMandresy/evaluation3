<?php
    use System\Tools\FormTool;
    use System\Tools\DateTool;
?>

<?php ob_start(); ?>
<h1 data-section="targets">les cibles</h1>

<form method="POST" autocomplete="off">
    <?= FormTool::input('text', 'lastname', 'Nom'); ?>
    <?= FormTool::input('text', 'firstname', 'Prénom'); ?>
    <?= FormTool::input('text', 'codeName', 'Nom de code'); ?>
    <?= FormTool::date('birth', 'Date de naissance'); ?>
    <?= FormTool::select('nationality', 'Nationalité', $nationalities); ?>

    <?= FormTool::button('Ajouter la cible', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste <input id="search" type="input" autocomplete="off" placeholder="Recherche par nom" /></h2>

<?php if ($all): ?>
    <?php foreach ($all as $data): ?>
    <div class="box" data-id="<?= $data->id; ?>">
        <h3><?= strtoupper($data->lastname); ?> <?= ucfirst($data->firstname); ?></h3>
        <p data-codename="<?= $data->codeName; ?>">Nom de code: <?= $data->codeName; ?></p>
        <p data-nationality="<?= $data->nationality; ?>">Nationalité: <?= $data->nationality; ?></p>
        <p data-birth="<?= DateTool::dateFormat($data->birthDate); ?>">Née le : <?= DateTool::dateFormat($data->birthDate, 'd/m/y'); ?></p>
        
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