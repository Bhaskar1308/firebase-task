<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-auth-compat.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f5f7fa;
        }
        .task-card {
            margin-bottom: 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        .task-title {
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome to Dashboard</h2>
        <button id="logoutBtn" class="btn btn-danger">Logout</button>
    </div>

    <div id="tasks" class="row">
        <!-- Task cards will be appended here -->
    </div>
</div>

<script>
    // Firebase config (make sure to replace this with your actual config)
    const firebaseConfig = {
            apiKey: "AIzaSyCeQsgsr9kPliY_xQ_sv-1fBo1Pnd2sNVg",
            authDomain: "first-project-4a9b4.firebaseapp.com",
            projectId: "first-project-4a9b4",
            storageBucket: "first-project-4a9b4.appspot.com",
            messagingSenderId: "528885287735",
            appId: "1:528885287735:web:c9a1e0ab277734f84068b2",
            measurementId: "G-QEENJNLBMK"
        };

    firebase.initializeApp(firebaseConfig);

    $(document).ready(function () {
        // Logout
        $('#logoutBtn').click(function () {
            firebase.auth().signOut().then(() => {
                window.location.href = "/logout";
            }).catch((error) => {
                alert("Logout failed: " + error.message);
            });
        });

        // Fetch tasks
        fetchTasks();

        function fetchTasks() {
            $.ajax({
                url: "/get-tasks",
                method: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        $('#tasks').empty();
                        response.tasks.forEach(task => {
                            const card = `
                                <div class="col-md-6">
                                    <div class="card task-card">
                                        <div class="card-body">
                                            <h5 class="task-title">${task.title}</h5>
                                            <p>${task.description}</p>
                                            <span class="badge bg-primary">Due: ${task.due_date}</span>
                                        </div>
                                    </div>
                                </div>`;
                            $('#tasks').append(card);
                        });
                    } else {
                        $('#tasks').html('<p class="text-danger">No tasks found or error loading tasks.</p>');
                    }
                },
                error: function () {
                    $('#tasks').html('<p class="text-danger">Failed to load tasks.</p>');
                }
            });
        }
    });
</script>
</body>
</html>
