<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensure full height for the body and html */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        /* Style for the video background */
        .bg-video {
            position: absolute; /* Position the video absolutely */
            top: 50%; /* Center the video vertically */
            left: 50%; /* Center the video horizontally */
            min-width: 100%; /* Minimum width to cover the viewport */
            min-height: 100%; /* Minimum height to cover the viewport */
            width: auto; /* Allow auto width */
            height: auto; /* Allow auto height */
            z-index: -1; /* Send the video behind other content */
            transform: translate(-50%, -50%); /* Adjust position */
            object-fit: cover; /* Cover the area without distortion */
        }

    </style>
</head>
<body>
<video class="bg-video" autoplay loop muted>
    <source src="../asset/loginBG.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
<div class="container login-container">
    <div class="login-form">
        <h3 class="text-center mb-4">Login</h3>
        <form id="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="inpt-username" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="inpt-password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="button" class="btn btn-primary btn-block" id="btn-loginPage">Login</button>
            <p class="text-center mt-3">
                <a class="nav-link text-primary forgot-password-link">Forgot password?</a>
            </p>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        const loginPage = {
            Init: function(config) {
                this.config = config;
                this.BindEvents();
            },
            BindEvents: function() {
                const $self = this.config;
                $self.$btn_login.on('click', this.login.bind(this));
            },
            login: function(e) {
                const $self = this.config;

                const username = $self.$inpt_username.val().trim();
                const password = $self.$inpt_password.val().trim();

                $.ajax({
                    url: '../controller/loginController.php',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: 'json',
                    success: function(response) {
                            if (response.success) {
                                e.preventDefault();
                                const tenantID = response.tenantID;
                                const adminID = response.adminID;
                                
                                // Ensure you are setting the adminID and tenantID correctly
                                if (adminID) {
                                    localStorage.setItem("adminID", adminID);
                                }

                                if (tenantID) {
                                    localStorage.setItem("tenantID", tenantID);
                                }
                                
                                // Redirect based on role
                                window.location.href = response.redirect;
                            } else {
                                // Display the error message from the server
                                alert(response.message || 'Invalid username or password.');
                            }
                        },
                    error: function() {
                        alert('An error occurred while processing your request. Please try again.');
                    }
                });
            }
        }
        loginPage.Init({
            $inpt_username: $('#inpt-username'),
            $inpt_password: $('#inpt-password'), // Correct ID here
            $btn_login: $('#btn-loginPage')
        });
    });
</script>

</body>
</html>
