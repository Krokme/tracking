<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Ticket</h4>
</div>

<form method="post" action="<?php echo PROJECT_PATH; ?>ticket/edit" id="ticket_form">
    <input type="hidden" name="id" value="<?php echo $this->App->request->get('id'); ?>">
    <div class="modal-body">
        <div class="error" id="error"></div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $this->App->request->get('name'); ?>" placeholder="" required>
        </div>
        <div class="form-group">
            <label for="project">Project</label>
            <select name="project" id="project" class="form-control">
                <?php
                foreach ($data['projects'] as $project) {
                    echo '<option value="' . $project['id'] . '"' . ($this->App->request->get('project_id') == $project['id'] ? ' selected' : '') . '>' . $project['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="priority">Priority</label>
            <select name="priority" id="priority" class="form-control">
                <option value="0"<?php echo $this->App->request->get('priority') == '0' ? ' selected' : ''; ?>>Normal</option>
                <option value="1"<?php echo $this->App->request->get('priority') == '1' ? ' selected' : ''; ?>>Low</option>
                <option value="2"<?php echo $this->App->request->get('priority') == '2' ? ' selected' : ''; ?>>Hight</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="0"<?php echo $this->App->request->get('status') == '0' ? ' selected' : ''; ?>>In progress</option>
                <option value="1"<?php echo $this->App->request->get('status') == '1' ? ' selected' : ''; ?>>Finished</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<script language="javascript">
    $('#ticket_form').validator();
    $("#ticket_form").submit(function(event) {
            $.post('/tickets/edit', $(this).serialize(), function(json) {
                if (json.success === true) {
                    location.reload(true);
                } else {
                    $("#error").html(json.error);
                }
            }, "json");
            event.preventDefault();
        });
</script>