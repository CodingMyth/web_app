<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="tasks-container">
    <h2>Your Tasks</h2>
    
    <div class="task-actions">
        <a href="/tasks/create" class="btn">Create New Task</a>
        <div class="filter-buttons">
            <a href="/tasks/filter/high" class="btn priority-high">High</a>
            <a href="/tasks/filter/medium" class="btn priority-medium">Medium</a>
            <a href="/tasks/filter/low" class="btn priority-low">Low</a>
            <a href="/tasks" class="btn">All</a>
        </div>
    </div>

    <?php if (empty($tasks)): ?>
        <p>No tasks found.</p>
    <?php else: ?>
        <div class="task-list">
            <?php foreach ($tasks as $task): ?>
                <div class="task-card priority-<?php echo htmlspecialchars($task['priority']); ?>">
                    <div class="task-header">
                        <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                        <span class="status <?php echo htmlspecialchars($task['status']); ?>">
                            <?php echo htmlspecialchars(ucfirst($task['status'])); ?>
                        </span>
                    </div>
                    <p><?php echo htmlspecialchars($task['description']); ?></p>
                    <div class="task-meta">
                        <span>Priority: <?php echo htmlspecialchars(ucfirst($task['priority'])); ?></span>
                        <span>Due: <?php echo $task['due_date'] ? htmlspecialchars($task['due_date']) : 'No due date'; ?></span>
                        <span>Created: <?php echo htmlspecialchars($task['created_at']); ?></span>
                    </div>
                    <div class="task-actions">
                        <a href="/tasks/edit/<?php echo $task['id']; ?>" class="btn">Edit</a>
                        <form action="/tasks/delete/<?php echo $task['id']; ?>" method="POST" class="delete-form">
                            <button type="submit" class="btn danger">Delete</button>
                        </form>
                        <?php if ($task['status'] === 'pending'): ?>
                            <form action="/tasks/update/<?php echo $task['id']; ?>" method="POST">
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn success">Mark Complete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="/assets/js/script.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>