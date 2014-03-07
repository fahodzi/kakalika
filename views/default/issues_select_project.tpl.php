<h4>Select Project</h4>
<ul class="spreadout-list" id="projects-list">
<?php foreach($projects as $project): ?>
    <li class="project-info-wrapper">
        <a href="<?= u("{$project['project']['code']}/issues/create") ?>" class="project-name"><?= $project['project']['name'] ?></a>
        <span class="project-desc"><?= $project['project']['description'] ?></span>
    </li>
<?php endforeach; ?>
</ul>
