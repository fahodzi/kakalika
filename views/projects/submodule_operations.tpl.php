<td class="operations">
<?php if($variables['disable_edit'] !== true): ?>
<a class="edit-operation" href="<?= u("admin/projects/{$variables['module']}/{$variables['id']}/edit/$column") ?>">Edit</a>
<?php endif; ?>
<a class="delete-operation" href="<?= u("admin/projects/{$variables['module']}/{$variables['id']}/delete/$column") ?>">Delete</a>
</td>