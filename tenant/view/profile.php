<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoardingHouse</title>
    <link rel="stylesheet" href="../../admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .scrollable-container {
            max-height: 80vh; /* Adjust as needed */
            overflow-y: auto;
            padding: 20px;
        }
        .profile-image-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-image {
            width: 100px; /* Adjust size as needed */
            height: auto; /* Maintain aspect ratio */
            border-radius: 50%;
            margin-right: 15px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <aside id="sidebar" >
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
                    <a class="sidebar-link" href="index.php">
                        <i class="bi bi-credit-card-2-front"></i>
                        Payment History
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
                        <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
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
            <div class="scrollable-container">
                <div class="container">
                    <div class="header">
                        <div class="profile-image-container">
                            
                            <div>
                                <h2>Tenant Profile</h2>
                            </div>
                        </div>
                        <div>
                            <h2></h2>
                            <h5></h5>
                            <h5></h5> 
                        </div>
                    </div>

                    <div class="form-container">
                        <h2>Profile Information</h2>

                        <div class="form-group">
                            <label for="tenantName">Tenant Name:</label>
                            <input type="text" id="inpt-tenantName" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="sel-gender" class="form-select">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="text" id="inpt-phoneNumber" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="emailAddress">Email Address:</label>
                            <input type="email" id="inpt-emailAddress" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="currentAddress">Current Address:</label>
                            <input type="text" id="inpt-currentAddress" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="fatherName">Father's Name:</label>
                            <input type="text" id="inpt-fatherName" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="fatherNumber">Father's Contact Number:</label>
                            <input type="text" id="inpt-fatherNumber" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="motherName">Mother's Name:</label>
                            <input type="text" id="inpt-motherName" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="motherNumber">Mother's Contact Number:</label>
                            <input type="text" id="inpt-motherNumber" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="emergencyName">Emergency Contact Name:</label>
                            <input type="text" id="inpt-emergencyName" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="emergencyNumber">Emergency Contact Number:</label>
                            <input type="text" id="inpt-emergencyNumber" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="dateStarted">Date Started:</label>
                            <input type="text" id="inpt-dateStarted" class="form-control">
                        </div>

                        <div class="form-footer">
                            <button type="button" class="btn btn-primary" id="btn-save">Save Changes</button>
                        </div>
                    </div>

                    <div class="form-container account-section">
                        <h2>Account Management</h2>

                        <div class="form-group">
                            <label for="newUsername">New Username:</label>
                            <input type="text" id="newUsername" class="form-control" placeholder="Enter new username">
                        </div>

                        <div class="form-group">
                            <label for="newPassword">New Password:</label>
                            <input type="password" id="newPassword" class="form-control" placeholder="Enter new password">
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password:</label>
                            <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm new password">
                        </div>

                        <div class="form-footer">
                            <button type="button" class="btn btn-success">Change Password</button>
                        </div>
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

    const profileTenantPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.getTenantID();
            this.displayInformation();
        },
        BindEvents: function() {
            const $this = this.config;
            $this.$btn_save.on('click', this.updateData.bind(this));
        },
        getTenantID: function() {
            const $self = this.config;
            
            const tenantID = localStorage.getItem("tenantID");
            console.log('Retrieved tenantID:', tenantID); // Log the tenantID

            if (tenantID) {
                $self.$inpt_tenantName.attr('data-tenantid', tenantID);
                console.log('Data attribute set:', tenantID); // Confirm data attribute is set
            } else {
                console.warn("No tenantID found in localStorage.");
            }
        },
        displayInformation: function(){
            const $self = this.config;
            const tenantID = $self.$inpt_tenantName.data('tenantid');
            $.ajax({
                url: '../controller/indexController.php',
                type: "GET",
                data: {
                    tenantID: tenantID // Make sure this matches the PHP parameter name
                },
                dataType: 'json',
                success: function(data){
                    if (data.length > 0) {
                        const item = data[0]; // Assuming you're interested in the first result
                        $self.$inpt_tenantName.val(item.tenantName);
                        $self.$inpt_phoneNumber.val(item.phoneNumber); // Add additional fields as needed
                        $self.$sel_gender.val(item.gender); // Example for gender
                        $self.$inpt_emailAddress.val(item.emailAddress);
                        $self.$inpt_currentAddress.val(item.currentAddress);
                        $self.$inpt_fatherName.val(item.fatherName);
                        $self.$inpt_fatherNumber.val(item.fatherNumber);
                        $self.$inpt_motherName.val(item.motherName);
                        $self.$inpt_motherNumber.val(item.motherNumber);
                        $self.$inpt_emergencyName.val(item.emergencyName);
                        $self.$inpt_emergencyNumber.val(item.emergencyNumber);
                        $self.$inpt_dateStarted.val(item.dateStarted);
                    } else {
                        console.warn("No data found for tenantID:", tenantID);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        },
        updateData: function(){
            const $self = this.config;
        }

    }
    profileTenantPage.Init({
        $inpt_tenantName            : $('#inpt-tenantName'),
        $inpt_phoneNumber           : $('#inpt-phoneNumber'),
        $sel_gender                 : $('#sel-gender'),
        $inpt_emailAddress          : $('#inpt-emailAddress'),
        $inpt_currentAddress        : $('#inpt-currentAddress'),
        $inpt_fatherName            : $('#inpt-fatherName'),
        $inpt_fatherNumber          : $('#inpt-fatherNumber'),
        $inpt_motherName            : $('#inpt-motherName'),
        $inpt_motherNumber          : $('#inpt-motherNumber'),
        $inpt_emergencyName         : $('#inpt-emergencyName'),
        $inpt_emergencyNumber       : $('#inpt-emergencyNumber'),
        $inpt_dateStarted           : $('#inpt-dateStarted'),
        $btn_save                   : $('#btn-save')
    });
});

</script>
</body>
</html>
