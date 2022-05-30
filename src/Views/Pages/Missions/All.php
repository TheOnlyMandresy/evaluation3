<?php
use System\Tools\DateTool;
use System\Tools\FormTool;
?>

<?php ob_start(); ?>

<h1 data-section="missions">Les missions</h1>

<form method="POST" autocomplete="off">
    <?= FormTool::input('text', 'title', 'Titre'); ?>
    <?= FormTool:: textarea('description', 'Décrire la mission'); ?>
    <?= FormTool::input('text', 'codeName', 'Nom de code'); ?>
    <?= FormTool::select('country', 'Pays', $countries); ?>
    <?= FormTool::select('type', 'Type', $types); ?>
    <?= FormTool::select('faculty', 'Faculté requise', $faculties); ?>
    <?= FormTool::select('agents[]', 'Agents (CTRL pour sélection multiple)', $agents, null, true); ?>
    <?= FormTool::select('contacts[]', 'Contacts (CTRL pour sélection multiple)', $contacts, null, true); ?>
    <?= FormTool::select('targets[]', 'Cibles (CTRL pour sélection multiple)', $targets, null, true); ?>
    <?= FormTool::select('hideouts[]', 'Planques (CTRL pour sélection multiple)', $hideouts, null, true); ?>
    <?= FormTool::select('state', 'État de la mission', System::getSystemInfos('mission_state')); ?>
    <?= FormTool::date('startDate', 'Début de mission', true); ?>
    <?= FormTool::date('endDate', 'Fin de mission', true); ?>

    <?= FormTool::button('Nouvelle mission', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste <input id="search" type="input" autocomplete="off" placeholder="Recherche par titre" /></h2>
<?php if ($all): ?>
    
    <?php foreach ($all as $data): ?>    
    <div class="box" data-id="<?= $data->id; ?>">
        <h3><?= $data->title; ?></h3>
        <p data-codename="<?= $data->codeName; ?>">Code: <?= $data->codeName; ?></p>
        <p class="description"><?= $data->description; ?></p>
        <p data-country="<?= $countries[$data->countryId]; ?>">Pays: <?= $countries[$data->countryId]; ?></p>
        <p data-type="<?= $types[$data->typeId]; ?>">Type: <?= $types[$data->typeId]; ?></p>
        <p data-state="<?= System::getSystemInfos('mission_state')[$data->state]; ?>">État de la mission: <?= System::getSystemInfos('mission_state')[$data->state]; ?></p>

        <p>Agents :</p>
        <ul>
        <?php foreach ($data->agentIds as $agent): ?>
            <li data-agents="<?= $agents[$agent]; ?>"><?= $agents[$agent]; ?></li>
        <?php endforeach; ?>
        </ul>
        
        <p>Contacts :</p>
        <ul>
        <?php foreach ($data->contactIds as $contact): ?>
            <li data-contacts="<?= $contacts[$contact]; ?>"><?= $contacts[$contact]; ?></li>
        <?php endforeach; ?>
        </ul>

        
        <p>Cibles :</p>
        <ul>
        <?php foreach ($data->targetIds as $target): ?>
            <li data-targets="<?= $targets[$target]; ?>"><?= $targets[$target]; ?></li>
        <?php endforeach; ?>
        </ul>

        
        <p>Planques :</p>
        <ul>
        <?php foreach ($data->hideoutIds as $hideout): ?>
            <li data-hideouts="<?= $hideouts[$hideout]; ?>"><?= $hideouts[$hideout]; ?></li>
        <?php endforeach; ?>
        </ul>

        <p class="start" data-date="<?= DateTool::dateFormat($data->startDate); ?>">Début de la mission: <?= DateTool::dateFormat($data->startDate, 'd/m/y'); ?></p>
        <p class="end" data-date="<?= DateTool::dateFormat($data->endDate); ?>">Fin de la mission: <?= DateTool::dateFormat($data->endDate, 'd/m/y'); ?></p>

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