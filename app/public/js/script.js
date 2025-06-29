// Client-side validation for login form
document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    
    if (!username || !password) {
        e.preventDefault();
        alert('Both username and password are required');
        return false;
    }
    
    if (username.length < 4) {
        e.preventDefault();
        alert('Username must be at least 4 characters');
        return false;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters');
        return false;
    }
});

// Client-side validation for registration form
document.getElementById('registerForm')?.addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    
    if (!username || !email || !password) {
        e.preventDefault();
        alert('All fields are required');
        return false;
    }
    
    if (username.length < 4) {
        e.preventDefault();
        alert('Username must be at least 4 characters');
        return false;
    }
    
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address');
        return false;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters');
        return false;
    }
});

// Client-side validation for task form
document.getElementById('taskForm')?.addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const priority = document.getElementById('priority').value;
    const dueDate = document.getElementById('due_date').value;
    
    if (!title) {
        e.preventDefault();
        alert('Title is required');
        return false;
    }
    
    if (!priority) {
        e.preventDefault();
        alert('Priority is required');
        return false;
    }
    
    if (dueDate) {
        const today = new Date().toISOString().split('T')[0];
        if (dueDate < today) {
            e.preventDefault();
            alert('Due date cannot be in the past');
            return false;
        }
    }
});

// Confirm before deleting task
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to delete this task?')) {
            e.preventDefault();
        }
    });
});