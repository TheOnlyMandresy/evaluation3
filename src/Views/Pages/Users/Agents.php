<?php
    use System\Tools\DateTool;
    use System\Tools\FormTool;
?>

<?php ob_start(); ?>

<h1>Les agents</h1>

<form method="POST">
    <?= FormTool::input('text', 'lastname', 'Nom'); ?>
    <?= FormTool::input('text', 'firstname', 'Prénom'); ?>
    <?= FormTool::date('birthday', 'Date d\'anniversaire'); ?>
    <?= FormTool::select('nationality', 'Nationalité', $nationalities); ?>
    <?= FormTool::input('password', 'password', 'Mot de passe'); ?>
    <?= FormTool::select('faculties[]', 'Facultés (CTRL pour sélection multiple)', $faculties, null, true); ?>

    <?= FormTool::button('Nouvel agent', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste</h2>

<?php if ($all): ?>
    <?php foreach ($all as $data): ?>
    <div class="box">
        <h3><?= strtoupper($data->lastname); ?> <?= ucfirst($data->firstname); ?></h3>
        <p>Nationality: <?= $data->nationality; ?></p
        <p>Née le: <?= DateTool::dateFormat($data->birthDate, 'd/m/y'); ?></p>
        <p>Facultés</p>
        <ul>
        <?php foreach ($data->faculties as $faculty): ?>
            <li><?= $faculties[$faculty]; ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="empty">Vide.</p>
<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>