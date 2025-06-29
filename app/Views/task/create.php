<?php require_once 'views/layouts/header.php'; ?>

<div class="tasks-container">
    <h2>Create New Task</h2>
    
    <form action="/tasks/store" method="POST" id="taskForm">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <div class="form-group">
            <label for="title">Title*</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="priority">Priority*</label>
            <select id="priority" name="priority" required>
                <option value="high">High</option>
                <option value="medium" selected>Medium</option>
                <option value="low">Low</option>
            </select>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date">
        </div>
        <button type="submit" class="btn">Create Task</button>
    </form>
</div>

<script src="/assets/js/script.js"></script>
<?php require_once 'views/layouts/footer.php'; ?>