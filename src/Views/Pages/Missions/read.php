<?php use System\Tools\DateTool; ?>

<?php ob_start(); ?>

<h1><?= $datas->title; ?></h1>

<div class="box">
    <p >Code: <?= $datas->codeName; ?></p>
    <p class="description"><?= $datas->description; ?></p>
    <p>Pays: <?= $countries[$datas->countryId]; ?></p>
    <p>Type: <?= $types[$datas->typeId]; ?></p>

    <p>Agents :</p>
    <ul>
    <?php foreach ($datas->agentIds as $agent): ?>
        <li><?= $agents[$agent]; ?></li>
    <?php endforeach; ?>
    </ul>
    
    <p>Contacts :</p>
    <ul>
    <?php foreach ($datas->contactIds as $contact): ?>
        <li><?= $contacts[$contact]; ?></li>
    <?php endforeach; ?>
    </ul>

    
    <p>Cibles :</p>
    <ul>
    <?php foreach ($datas->targetIds as $target): ?>
        <li><?= $targets[$target]; ?></li>
    <?php endforeach; ?>
    </ul>

    
    <p>Planques :</p>
    <ul>
    <?php foreach ($datas->hideoutIds as $hideout): ?>
        <li><?= $hideouts[$hideout]; ?></li>
    <?php endforeach; ?>
    </ul>

    <p>État de la mission: <?= System::getSystemInfos('mission_state')[$datas->state]; ?></p>
    <p class="start">Début de la mission: <?= DateTool::dateFormat($datas->startDate, 'd/m/y'); ?></p>
    <p class="end">Fin de la mission: <?= DateTool::dateFormat($datas->endDate, 'd/m/y'); ?></p>
</div>

<?php $content = ob_get_clean(); ?>