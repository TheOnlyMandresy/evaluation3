<?php use System\Tools\DateTool; ?>

<?php ob_start(); ?>

<div class="list">
    <h2>Liste <input id="search" type="input" autocomplete="off" placeholder="Recherche par titre" /></h2>
<?php if ($all): ?>
    
    <?php foreach ($all as $data): ?>    
    <div class="box" data-id="<?= $data->id; ?>">
        <h3><?= $data->title; ?></h3>
        <p>Code: <?= $data->codeName; ?></p>
        <p>Pays: <?= $countries[$data->countryId]; ?></p>
        <p>État de la mission: <?= System::getSystemInfos('mission_state')[$data->state]; ?></p>
        <div class="buttons">
            <a href="/missions/r/<?= $data->id; ?>"><button class="btn-infos">En savoir plus</button></a>
        </div>
    </div>
    <?php endforeach; ?>

<?php else: ?>
    <p class="empty">Vide.</p>
<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>