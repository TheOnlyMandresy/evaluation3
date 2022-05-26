<?php
    use System\Tools\DateTool;
    use System\Tools\FormTool;
?>

<?php ob_start(); ?>

<h1 data-section="agents">les agents</h1>

<form method="POST" autocomplete="off">
    <?= FormTool::input('text', 'lastname', 'Nom'); ?>
    <?= FormTool::input('text', 'firstname', 'Prénom'); ?>
    <?= FormTool::date('birth', 'Date de naissance'); ?>
    <?= FormTool::input('text', 'codeName', 'Nom de code'); ?>
    <?= FormTool::select('nationality', 'Nationalité', $nationalities); ?>
    <?= FormTool::select('faculties[]', 'Facultés (CTRL pour sélection multiple)', $faculties, null, true); ?>

    <?= FormTool::button('Nouvel agent', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste <input id="search" type="input" autocomplete="off" placeholder="Recherche par nom" /></h2>

<?php if ($all): ?>
    <?php foreach ($all as $data): ?>
    <div class="box" data-id="<?= $data->id; ?>">
        <h3><?= strtoupper($data->lastname); ?> <?= ucfirst($data->firstname); ?></h3>
        <p data-codename="<?= $data->codeName; ?>">Nom de code: <?= $data->codeName; ?></p>
        <p data-nationality="<?= $data->nationality; ?>">Nationalité: <?= $data->nationality; ?></p>
        <p data-birth="<?= DateTool::dateFormat($data->birthDate); ?>">Née le: <?= DateTool::dateFormat($data->birthDate, 'd/m/y'); ?></p>
        <p>Facultés</p>
        <ul>
        <?php foreach ($data->faculties as $faculty): ?>
            <li data-faculties="<?= $faculties[$faculty]; ?>"><?= $faculties[$faculty]; ?></li>
        <?php endforeach; ?>
        </ul>
        
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