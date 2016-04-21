<h4><?= $title ?></h4>
<?= 
t(
    'issues_form.tpl.php',
    array(
        'data' => $form_data,
        'errors' => $form_errors,
        'assignees' => $assignees,
        'components' => $components,
        'milestones' => $milestones,
        'comment' => true
    )
) 
?>

<?= $helpers->form->close('Update Issue') ?>
