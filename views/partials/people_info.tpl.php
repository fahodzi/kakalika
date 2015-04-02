<div class='people-info'>
    <img src='<?= $helpers->social->gravatar($email)->size(56) ?>' /> 
    <span class='top-part'>
        <?= $action ?> <span class='name'><?= $firstname ?> <?= $lastname ?></span>
    </span>
    <span class='bottom-part small-date'>
        <?= $helpers->date($time)->sentence(array('elaborate_with' => 'ago')) ?> ⚫ <?= $helpers->date($time)->format('jS F, Y @ g:i a') ?>
    </span>
</div>