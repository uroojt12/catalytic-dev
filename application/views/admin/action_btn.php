<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
    <ul class="dropdown-menu dropdown-primary" role="menu">
        <li><a href="<?= site_url(ADMIN . '/code/manage/' . $id); ?>">Edit</a></li>
        <li><a href="<?= site_url(ADMIN . '/code/delete/' . $id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
    </ul>
</div>