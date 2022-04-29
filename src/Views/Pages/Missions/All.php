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
    <?= FormTool::select('agents[]', 'Agents (CTRL pour sélection multiple)', $agents, null, true); ?>
    <?= FormTool::select('contacts[]', 'Contacts (CTRL pour sélection multiple)', $contacts, null, true); ?>
    <?= FormTool::select('targets[]', 'Cibles (CTRL pour sélection multiple)', $targets, null, true); ?>
    <?= FormTool::select('hideouts[]', 'Planques (CTRL pour sélection multiple)', $hideouts, null, true); ?>
    <?= FormTool::select('state', 'État de la mission', System::getSystemInfos('mission_state')); ?>
    <?= FormTool::date('startDate', 'Début de la mission', true); ?>
    <?= FormTool::date('endDate', 'Fin de la mission', true); ?>

    <?= FormTool::button('Nouvelle mission', 'new', 'success'); ?>
</form>

<div class="list">
    <h2>Liste</h2>
<?php if ($all): ?>
    
    <?php foreach ($all as $data): ?>    
    <div class="box">
        <h3><?= $data->title; ?></h3>
        <p>Code: <?= $data->codeName; ?></p>
        <p>Pays: <?= $countries[$data->countryId]; ?></p>
        <p>Type: <?= $types[$data->typeId]; ?></p>
        <p>État de la mission: <?= System::getSystemInfos('mission_state')[$data->state]; ?></p>

        <p>Agents :</p>
        <ul>
        <?php foreach ($data->agentIds as $agent): ?>
            <li><?= $agents[$agent]; ?></li>
        <?php endforeach; ?>
        </ul>
        
        <p>Contacts :</p>
        <ul>
        <?php foreach ($data->contactIds as $contact): ?>
            <li><?= $contacts[$contact]; ?></li>
        <?php endforeach; ?>
        </ul>

        
        <p>Cibles :</p>
        <ul>
        <?php foreach ($data->targetIds as $target): ?>
            <li><?= $targets[$target]; ?></li>
        <?php endforeach; ?>
        </ul>

        
        <p>Planques :</p>
        <ul>
        <?php foreach ($data->hideoutIds as $hideout): ?>
            <li><?= $hideouts[$hideout]; ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endforeach; ?>

<?php else: ?>
    <p class="empty">Vide.</p>
<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>