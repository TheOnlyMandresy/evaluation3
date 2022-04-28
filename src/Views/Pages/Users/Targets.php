<?php
    use System\Tools\FormTool;
    use System\Tools\DateTool;
?>

<?php ob_start(); ?>
<h1>TARGETS</h1>

<form method="POST">
    <?= FormTool::input('text', 'lastname', 'Nom'); ?>
    <?= FormTool::input('text', 'firstname', 'Prénom'); ?>
    <?= FormTool::input('text', 'codeName', 'Nom de code'); ?>
    <?= FormTool::date('birthday', 'Date d\'anniversaire'); ?>
    <?= FormTool::select('nationality', 'Nationalité', $nationalities); ?>

    <?= FormTool::button('Ajouter la cible', 'newTarget', 'success'); ?>
</form>

<div class="list">
    <h2>Liste</h2>

<?php if ($all): ?>
    <?php foreach ($all as $data): ?>
    <div class="box">
        <h3><?= strtoupper($data->lastname); ?> <?= ucfirst($data->firstname); ?></h3>
        <p>Nom de code: <?= $data->codeName; ?></p>
        <p>Nationality: <?= $data->nationality; ?></p>
        <p>Née le : <?= DateTool::dateFormat($data->birthDate, 'd/m/y'); ?></p>
    </div>
    <?php endforeach; ?>
    
<?php else: ?>
    <p class="empty">Vide.</p>
<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>