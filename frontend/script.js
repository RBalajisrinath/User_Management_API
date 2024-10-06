const userForm = document.getElementById('userForm');
const userIdInput = document.getElementById('userId');
const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const userList = document.getElementById('userList');

// Fetch all users
async function fetchUsers() {
    const response = await fetch('http://localhost/user_management_api/src/backend/api.php');
    const users = await response.json();
    displayUsers(users);
}

// Display users in the UI
function displayUsers(users) {
    userList.innerHTML = '';
    users.forEach(user => {
        const userItem = document.createElement('div');
        userItem.className = 'user-item';
        userItem.innerHTML = `
            <span>${user.username} (${user.email})</span>
            <div>
                <button onclick="editUser(${user.id}, '${user.username}', '${user.email}')">Edit</button>
                <button class="delete" onclick="deleteUser(${user.id})">Delete</button>
            </div>
        `;
        userList.appendChild(userItem);
    });
}

// Create or update user
userForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const userId = userIdInput.value;
    const method = userId ? 'PUT' : 'POST';
    const url = userId ? `http://localhost/user_management_api/src/backend/api.php?id=${userId}` : 'http://localhost/user_management_api/src/backend/api.php';

    const userData = {
        username: usernameInput.value,
        email: emailInput.value,
        password: passwordInput.value || undefined, // Only include password if provided
    };

    await fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(userData),
    });

    resetForm();
    fetchUsers();
});

// Edit user
function editUser(id, username, email) {
    userIdInput.value = id;
    usernameInput.value = username;
    emailInput.value = email;
    passwordInput.value = ''; // Clear password field
}

// Delete user
async function deleteUser(id) {
    await fetch(`http://localhost/user_management_api/src/backend/api.php?id=${id}`, {
        method: 'DELETE',
    });
    fetchUsers();
}

// Reset form
function resetForm() {
    userIdInput.value = '';
    usernameInput.value = '';
    emailInput.value = '';
    passwordInput.value = '';
}

// Initial fetch of users
fetchUsers();