<?php require_once 'views/layouts/header.php'; ?>

<div class="tasks-container">
    <h2>Edit Task</h2>
    
    <form action="/tasks/update/<?php echo $task['id']; ?>" method="POST" id="taskForm">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>"> 
    <div class="form-group">
            <label for="title">Title*</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="priority">Priority*</label>
            <select id="priority" name="priority" required>
                <option value="high" <?php echo $task['priority'] === 'high' ? 'selected' : ''; ?>>High</option>
                <option value="medium" <?php echo $task['priority'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                <option value="low" <?php echo $task['priority'] === 'low' ? 'selected' : ''; ?>>Low</option>
            </select>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="pending" <?php echo $task['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="completed" <?php echo $task['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
            </select>
        </div>
        <button type="submit" class="btn">Update Task</button>
    </form>
</div>

<script src="/assets/js/script.js"></script>
<?php require_once 'views/layouts/footer.php'; ?>