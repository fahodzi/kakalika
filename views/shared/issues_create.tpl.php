<h4><?= $title ?></h4>
<?= 
t(
    'issues_form.tpl.php',
    array(
        'data' => $data,
        'errors' => $errors,
        'assignees' => $assignees,
        'components' => $components,
        'milestones' => $milestones,
        'comment' => false
    )
) 
?>

<?= $helpers->form->close('Create Issue') ?>
