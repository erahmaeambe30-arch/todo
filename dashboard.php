<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

include 'db_connect.php';
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - To-Do List</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    :root {
      --primary: #4a6fa5;
      --secondary: #6b8cbc;
      --accent: #ff7e5f;
      --light: #f5f7fa;
      --dark: #2c3e50;
      --danger: #e74c3c;
      --success: #2ecc71;
      --warning: #f39c12;
      --gray: #95a5a6;
    }

    body {
      background-image: url(IMG/image.png);
      min-height: 100vh;
    }

    .navbar {
      background: rgb(101, 177, 207);
      color: white;
      padding: 1rem 2rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      gap: 0px;
      font-weight: 100vh;
      font-size: 40px;
      font-weight: bold;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .logout-btn {
      font-weight: bold;
      background: purple;
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s;
    }

    .logout-btn:hover {
      background: pink;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .welcome-section {
      font-size: 20px;
      font-weight: bold;
      background: rgb(101, 177, 207);
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
      text-align: center;
    }

    .dashboard-grid {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 2rem;
    }

    @media (max-width: 768px) {
      .dashboard-grid {
        grid-template-columns: 1fr;
      }
    }

    .todo-form {
      background: rgb(101, 177, 207);
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .todo-list {
      background-image: url("IMG/image.png");
      color: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      max-height: 500px;
      overflow-y: auto;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      color:white;
      font-weight: 500;
    }

    .form-control {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.2);
      outline: none;
    }

    .btn {
      display: inline-block;
      padding: 12px 25px;
      background-color: purple;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn:hover {
      background: pink;
      transform: translateY(-2px);
    }

    .btn-block {
      display: block;
      width: 100%;
    }

    .todo-item {
      display: flex;
      align-items: center;
      padding: 1rem;
      border-bottom: 1px solid #eee;
      transition: all 0.3s;
    }

    .todo-text {
      flex: 1;
      color: white;
    }

    .todo-actions {
      display: flex;
      gap: 10px;
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1rem;
      margin-top: 2rem;
    }

  .stat-card {
  background: rgb(101, 177, 207);
  padding: 2rem;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.stat-number {
  font-size: 30px;     
  font-weight: bold;
  color: white;
}

.stat-label {
  font-size: 25px;     
  font-weight: bold;
  margin-top: 5px;
  color: white;
}


    .priority-badge {
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 0.7rem;
      font-weight: bold;
      margin-left: 8px;
      background-color: purple;
      color: white;
    }
  </style>
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="navbar-brand">
      <img src="IMG/logo image.png" alt="App logo" width="80" height="80">
      <span>To-Do List Dashboard</span>
    </div>
    <div class="user-info">
      <span>Welcome, <span id="userName"><?php echo htmlspecialchars($username); ?></span>!</span>
      <form action="logout.php" method="POST">
        <button type="submit" class="logout-btn">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
    </div>
  </nav>

  <div class="container">

    <div class="welcome-section">
      <h1>Your Personal To-Do List</h1>
      <p>Stay Organized and Boost Your Productivity</p>
    </div>

    <div class="dashboard-grid">

      <!-- Todo Form -->
      <div class="todo-form">
        <h2>Add New Task</h2>
        <form id="todoForm">
          <div class="form-group">
            <label for="taskTitle">Task Title</label>
            <input type="text" id="taskTitle" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="taskDescription">Description (Optional)</label>
            <textarea id="taskDescription" class="form-control" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="taskPriority">Priority</label>
            <select id="taskPriority" class="form-control">
              <option value="low">Low</option>
              <option value="medium" selected>Medium</option>
              <option value="high">High</option>
            </select>
          </div>

          <button type="submit" class="btn btn-block" id="addTaskBtn">Add Task</button>
        </form>
      </div>

      <!-- Todo List -->
      <div class="todo-list">
        <h2>Your Tasks</h2>

        <!-- ⭐ SEARCH BAR ADDED HERE ⭐ -->
        <input type="text" id="taskSearch" placeholder="Search tasks..."
               onkeyup="searchTasks()" class="form-control" style="margin-bottom:15px;">

        <div id="todoList">
          <div class="empty-state">
            <i class="fas fa-clipboard-list"></i>
            <h3>No tasks yet</h3>
            <p>Add your first task to get started!</p>
          </div>
        </div>
      </div>

    </div>

    <!-- Stats -->
    <div class="stats">
      <div class="stat-card">
        <div class="stat-number" id="totalTasks">0</div>
        <div class="stat-label">Total Tasks</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" id="completedTasks">0</div>
        <div class="stat-label">Completed</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" id="pendingTasks">0</div>
        <div class="stat-label">Pending</div>
      </div>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    loadTodos();
    // Stats will update when todos are loaded, but calling it here ensures initial visibility
    updateStats(); 
});

// Helper function to clear the form and reset button text after an edit/add
function clearEditState() {
    const todoForm = document.getElementById('todoForm');
    todoForm.reset();
    // Remove the ID from the dataset
    delete todoForm.dataset.editId;
    // Reset the button text
    document.getElementById('addTaskBtn').textContent = 'Add Task';
}

async function loadTodos() {
    const response = await fetch('get_tasks.php');
    // Check for network errors
    if (!response.ok) {
        document.getElementById('todoList').innerHTML = '<p style="color:red;">Error loading tasks. Check the server endpoint.</p>';
        return;
    }
    const todos = await response.json();
    const todoList = document.getElementById('todoList');

    if (todos.length === 0) {
        todoList.innerHTML = `
          <div class="empty-state">
            <i class="fas fa-clipboard-list"></i>
            <h3>No tasks yet</h3>
            <p>Add your first task to get started!</p>
          </div>`;
        return;
    }

    // Map tasks to HTML structure
    todoList.innerHTML = todos.map(todo => `
      <div class="todo-item ${todo.completed == 1 ? 'completed' : ''}" 
           data-title="${todo.title}" data-description="${todo.description || ''}">
        <input type="checkbox" class="todo-checkbox" 
          ${todo.completed == 1 ? 'checked' : ''}
          onchange="toggleTodo(${todo.id})">

        <div class="todo-text">
          <strong>${todo.title}</strong>
          <span class="priority-badge">${todo.priority.charAt(0).toUpperCase() + todo.priority.slice(1)}</span>
          ${todo.description ? `<p>${todo.description}</p>` : ''}
        </div>

        <div class="todo-actions">
          <button class="todo-action-btn edit" onclick="editTodo(${todo.id})">
            <i class="fas fa-edit"></i>
          </button>
          <button class="todo-action-btn delete" onclick="deleteTodo(${todo.id})">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
    `).join('');
    
    // Important: Run the search filter again in case the user was searching when the list refreshed
    searchTasks();
    
    // Update the stats immediately after loading the list
    updateStats();
}

// ---------------------------------------------------------------------------------
// ⭐ MAIN FORM SUBMISSION HANDLER (FIXED) ⭐
document.getElementById('todoForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const todoForm = this;
    const id = todoForm.dataset.editId || ''; // Check if we are editing
    const title = document.getElementById('taskTitle').value.trim();
    const description = document.getElementById('taskDescription').value.trim();
    const priority = document.getElementById('taskPriority').value;

    if (!title) return;

    const formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);
    formData.append('priority', priority);
    if (id) formData.append('id', id); // Include ID for update

    const endpoint = id ? 'update_task.php' : 'add_task.php';
    const actionButton = document.getElementById('addTaskBtn');

    actionButton.disabled = true; // Disable button while processing

    try {
        const res = await fetch(endpoint, { method: 'POST', body: formData });
        
        // This check ensures the PHP script executed successfully
        if (!res.ok) {
            console.error(`Server error during ${id ? 'update' : 'add'}:`, await res.text());
            alert(`Error: Failed to ${id ? 'update' : 'add'} task.`);
            return;
        }

        // ⭐ The FIX: Clear the form state after a successful operation
        clearEditState(); 
        
        loadTodos(); // Reload the list
        
    } catch (error) {
        console.error('Network or parsing error:', error);
        alert('An unexpected error occurred. Check console for details.');
    } finally {
        actionButton.disabled = false; // Re-enable button
    }
});
// ---------------------------------------------------------------------------------

// Function to enter Edit Mode
async function editTodo(id) {
    const todos = await (await fetch('get_tasks.php')).json();
    const todo = todos.find(t => t.id == id);
    if (!todo) return;

    // Populate the form fields
    document.getElementById('taskTitle').value = todo.title;
    document.getElementById('taskDescription').value = todo.description || '';
    document.getElementById('taskPriority').value = todo.priority;

    // Set the task ID on the form element
    document.getElementById('todoForm').dataset.editId = id;
    
    // Change button text to reflect editing state
    document.getElementById('addTaskBtn').textContent = 'Update Task';
    
    // Scroll to the top of the form for better UX
    document.getElementById('todoForm').scrollIntoView({ behavior: 'smooth' });
}


async function deleteTodo(id) {
    // Improved confirmation message
    if (!confirm) return; 
    
    // Note: Deletion should ideally use POST, but we keep GET here to match your original structure
    await fetch('delete_task.php?id=' + id); 
    loadTodos();
}

async function toggleTodo(id) {
    await fetch('toggle_complete.php?id=' + id);
    loadTodos();
}

async function updateStats() {
    const todos = await (await fetch('get_tasks.php')).json();
    // Ensure all elements exist before updating
    if (document.getElementById('totalTasks')) {
      document.getElementById('totalTasks').textContent = todos.length;
      document.getElementById('completedTasks').textContent = todos.filter(t => t.completed == 1).length;
      document.getElementById('pendingTasks').textContent = todos.filter(t => t.completed == 0).length;
    }
}

/* ⭐ SEARCH FUNCTION (Optimized) ⭐ */
function searchTasks() {
    const searchValue = document.getElementById('taskSearch').value.toLowerCase();
    const items = document.querySelectorAll('.todo-item');

    items.forEach(item => {
      // Search in the main text content, title, and description
      const text = item.querySelector('.todo-text').innerText.toLowerCase(); 
      item.style.display = text.includes(searchValue) ? "flex" : "none"; // Use 'flex' to maintain CSS layout
    });
}
</script>

</body>
</html>
