<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoardingHouse</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    </head>
    <body>
<div class="wrapper">
    <aside id="sidebar">
        <div class="h-100">
            <div class="sidebar-logo">
                <a href="index.php">RHMS</a>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="profile.php">
                        <i class="bi bi-people"></i>
                        Profile
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="payment.php">
                        <i class="bi bi-credit-card-2-front"></i>
                        Payment
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="maintenancerequest.php">
                        <i class="bi bi-house"></i>
                        Request Maintenance
                    </a>
                </li>
                <li class="sidebar-item">
                <a class="sidebar-link" href="agreement.php">
                        <i class="bi bi-laptop"></i>
                        Terms and Conditions
                    </a>
                </li>
                <li class="sidebar-item">
                <a class="sidebar-link" href="adminaccount.php">
                        <i class="bi bi-laptop"></i>
                        Admin Profile
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <div class="main">
        <nav class="navbar navbar-expand px-3 border-bottom">
            <button class="btn" id="sidebar-toggle" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse navbar">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0 ">
                            <i class="bi bi-person-circle" style="font-size: 25px"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="account.php" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="content px-4 py-4">
    <div class="container-fluid bg-white">
            <div class="room-content p-2">
                <div class="row">
                    <div class="d-md-flex" id="deliquent-container"></div>
                        <div class="d-flex align-items-center py-2" style="height: 50px;">
                           
                </div>

                <div class="container">
    <h1>Admin Profile</h1>

    <ul class="profile-details">
        <li>
            <span class="label">Name:</span>
            <span class="value">Charliss Bongcayao</span>
        </li>
        <li>
            <span class="label">Email:</span>
            <span class="value">charlissrhms@gmail.com</span>
        </li>
        <li>
            <span class="label">Phone Number:</span>
            <span class="value">09605270287</span>
        </li>
        <li>
            <span class="label">Boarding House Name:</span>
            <span class="value">Charliss Rooming House</span>
        </li>
    </ul>

    <div class="role-description">
        <h2>Role and Responsibilities</h2>
        <p>The admin is the owner and primary manager of the boarding house. Responsibilities include:</p>
        <ul>
            <li>Managing tenant agreements and overseeing lease terms.</li>
            <li>Maintaining property standards and coordinating repairs.</li>
            <li>Handling rent collection and financial records.</li>
            <li>Ensuring adherence to house rules and handling tenant inquiries.</li>
            <li>Overseeing all boarding house operations and improvements.</li>
        </ul>
    </div>
    <button class="manage-account-btn" onclick="openModal()">Manage Admin Account</button>
</div>
<div class="modal" id="adminModal">
    <div class="modal-content">
        <h2>Manage Admin Account</h2>

        <label for="new-username">New Username:</label>
        <input type="text" id="new-username" placeholder="Enter new username">

        <label for="new-password">New Password:</label>
        <input type="password" id="new-password" placeholder="Enter new password">

        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" placeholder="Confirm new password">

        <button class="close-btn" onclick="closeModal()">Cancel</button>
        <button type="submit">Save Changes</button>
    </div>
</div>

<script>
     function openModal() {
        document.getElementById('adminModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('adminModal').style.display = 'none';
    }
    // Automatically set the request date when the form is loaded
</script>
                </div>
            </div>
        </div>
    </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
    $("#sidebar-toggle").click(function() {
        $("#sidebar").toggleClass("collapsed");
    });

    const adminaccountPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
         
        },
        BindEvents: function() {
            const $this = this.config;
           
        },
     
       

    }

    adminaccountPage.Init({
    
    });
});

    </script>
</body>
</html>