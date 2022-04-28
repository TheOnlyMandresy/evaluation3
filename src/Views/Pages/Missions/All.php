<?php use System\Tools\FormTool; ?>

<?php ob_start(); ?>

<h1>Les missions</h1>

<form method="POST">
    <?= FormTool::input('text', 'title', 'Titre'); ?>
    <?= FormTool:: textarea('description', 'Décrire la mission'); ?>
    <?= FormTool::input('text', 'codeName', 'Nom de code'); ?>
    <?= FormTool::select('country', 'Pays', $countries); ?>
    <?= FormTool::select('type', 'Type', $types); ?>
    <?= FormTool::select('faculty', 'Faculté requise', $faculties); ?>
    <?= FormTool::select('agents', 'Agents (CTRL pour sélection multiple)', $agents, null, true); ?>
    <?= FormTool::select('contacts', 'Contacts (CTRL pour sélection multiple)', $contacts, null, true); ?>
    <?= FormTool::select('targets', 'Cibles (CTRL pour sélection multiple)', $targets, null, true); ?>
    <?= FormTool::select('hideouts', 'Planques (CTRL pour sélection multiple)', $hideouts, null, true); ?>
    <?= FormTool::select('country', 'Pays', System::getSystemInfos('mission_state')); ?>
    <?= FormTool::date('startDate', 'Début de la mission', true); ?>
    <?= FormTool::date('endDate', 'Fin de la mission', true); ?>

    <?= FormTool::button('Nouvelle mission', 'new', 'success'); ?>
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