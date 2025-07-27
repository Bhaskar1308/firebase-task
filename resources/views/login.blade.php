
<!DOCTYPE html>
<html>
<head>
    <title>Firebase Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .login-box h2 {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Firebase Login</h2>
        <input type="email" id="email" value="testuser@gmail.com" placeholder="Email" />
        <input type="password" id="password" value="test1234" placeholder="Password" />
        <button onclick="login()">Login</button>
    </div>

    <!-- Firebase CDN (Compat Version) -->
    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-auth-compat.js"></script>

    <script>
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

        async function login() {
            try {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                const userCredential = await firebase.auth().signInWithEmailAndPassword(email, password);
                const user = userCredential.user;

                const response = await fetch('/firebase-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        uid: user.uid,
                        email: user.email
                    })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    sessionStorage.setItem("firebase_uid", user.uid);
                    window.location.href = '/dashboard';
                } else {
                    alert(data.message || 'Login failed.');
                }
            } catch (error) {
                alert(error.message);
            }
        }
    </script>
</body>
</html>
