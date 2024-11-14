document.addEventListener('DOMContentLoaded', () => {
    // Fetch users from backend using Axios
    axios({
        method: "post",
        url: "http://localhost/cinematch/backend/admin-pannel.php",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    })
        .then((response) => {
            const users = response.data.users;
            const usersTable = document.getElementById('users-table');

            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.userId}</td>
                    <td>${user.username}</td>
                    <td>${user.user_type}</td>
                    <td>${user.ban == 1 ? 'Banned' : 'Not Banned'}</td>
                    <td>
                        <input type="radio" name="ban_user_${user.userId}" class="radio-btn" data-user-id="${user.userId}" ${user.ban == 1 ? 'checked' : ''}> Ban
                    </td>
                `;
                usersTable.appendChild(row);
            });

            document.querySelectorAll('.radio-btn').forEach(radio => {
                radio.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    let isBanned;

                    if (this.hasAttribute('checked')) {
                        this.checked = false;
                        this.removeAttribute('checked');
                        isBanned = false; 
                    } else {
                        this.setAttribute('checked', 'true');
                        isBanned = true; 
                    }

                    // Send request to update ban status
                    axios({
                        method: "post",
                        url: "http://localhost/cinematch/backend/update-ban.php",
                        data: new URLSearchParams({
                            userId: userId,
                            isBanned: isBanned
                        }),
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                    })
                    .then((response) => {
                        console.log("Ban status updated:", response.data);
                    })
                    .catch((error) => {
                        console.error("Error updating ban status:", error);
                        alert("An error occurred while updating ban status. Please try again.");
                    });
                });
            });
        })
        .catch((error) => {
            console.error("Error fetching users:", error);
            alert("An error occurred while fetching users. Please try again.");
        });
});
