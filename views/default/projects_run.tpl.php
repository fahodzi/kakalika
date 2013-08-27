<?php foreach($projects as $project): ?>
<div class="project-info-wrapper">
<div class="row">
    <div class="column grid_10_4">
        <a href="<?= u($project['project']['code']) ?>" class="project-name"><?= $project['project']['name'] ?></a>
        <span class="project-desc"><?= $project['project']['description'] ?></span>
    </div>
    <div class="column grid_10_2">
        <a class="tinylink" href="<?= u("{$project['project']['code']}/edit") ?>">
            <img src="<?= load_asset('images/edit_small.png')?>" alt="edit" />Edit
        </a>
    </div>
    <div class="column grid_10_4">
        Resolved Open
    </div>
</div>
</div>
<?php endforeach; ?>

