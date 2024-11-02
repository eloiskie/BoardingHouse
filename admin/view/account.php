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
     <style>
        
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #2c3e50;
        }
        .profile-details {
            list-style-type: none;
            padding: 0;
        }
        .profile-details li {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .role-description {
            background: #f0f8ff;
            padding: 15px;
            border-left: 4px solid #2c3e50;
            border-radius: 4px;
            margin-top: 20px;
        }
        .manage-account-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: white;
            background-color: #2c3e50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
        }
        .modal-content h2 {
            margin-top: 0;
        }
        .modal-content label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        .modal-content input[type="text"],
        .modal-content input[type="email"],
        .modal-content input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .modal-content button {
            padding: 10px 20px;
            border: none;
            color: white;
            background-color: #2c3e50;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal-content .close-btn {
            background-color: #e74c3c;
            margin-right: 10px;
        }
    </style>
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
                    <a class="sidebar-link" href="index.php">
                        <i class="bi bi-laptop"></i>
                        Dashboard
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="house.php">
                        <i class="bi bi-house"></i>
                        House
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="tenant.php">
                        <i class="bi bi-people"></i>
                        Tenant
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#payments" aria-expanded="false" aria-controls="payments">
                        <i class="bi bi-credit-card-2-front"></i>
                        Payments
                    </a>
                    <ul id="payments" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="rentalPayment.php" class="sidebar-link">Rental Payment</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="deliquent.php" class="sidebar-link">Deliquent Tenant</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="maintenance.php">
                        <i class="bi bi-envelope-paper"></i>
                        Maintenance
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="reports.php">
                        <i class="bi bi-file-earmark-text"></i>
                        Report
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
            <span class="value" id ="lbl-adminName"></span>
        </li>
        <li>
            <span class="label">Email:</span>
            <span class="value" id="lbl-adminEmail"></span>
        </li>
        <li>
            <span class="label">Phone Number:</span>
            <span class="value" id="lbl-phoneNumber"></span>
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
    <button class="manage-account-btn" id="btn-manageAccount">Manage Admin Account</button><br/>
    <button class="manage-account-btn" id="btn-requestCode">Reset Password</button>
</div>
    <!-- start modal rest pass -->
        <div class="modal" id="resetModal" tabindex="-1" data-houseid="">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <h2>Verification Code</h2>
                    <label for="vertifitcation-Details" id="lbl-verificationDetails"></label><br/>
                    <label for="timeLeft" id="lbl-remainingTime" display="none"></label>
                    <input type="text" id="inpt-verificationCode" placeholder="Code">
                    <button type="submit" class="btn btn-primary" id="btn-verify">Verify</button>
                </div>
            </div>
        </div>
    <!-- end modal -->
    <!-- start modal edit data -->
        <div class="modal" id="updateModal" tabindex="-1" >
            <div class="modal-dialog ">
                <div class="modal-content">
                    <h2>Personal Information</h2>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name: </label>
                            <input type="text"  class="form-control" id="inpt-adminName">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email: </label>
                            <input type="text"  class="form-control" id="inpt-adminEmail">
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number: </label>
                            <input type="text"  class="form-control" id="inpt-adminNumber">
                        </div>
                    <button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
                </div>
            </div>
        </div>
    <!-- end modal -->
    <!-- start modal change password -->
     <div class="modal" id="changePassModal" tabindex="-1" data-houseid="">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <h2>Reset Password</h2>
                    <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password: </label>
                            <input type="text"  class="form-control" id="inpt-newPassword">
                    </div>
                    <div class="mb-3">
                            <label for="newPassword" class="form-label">Confirm New Password </label>
                            <input type="text"  class="form-control" id="inpt-confirmNewPassword">
                    </div>
                    <button type="submit" class="btn btn-primary" id="btn-reset">Reset</button>
                </div>
            </div>
        </div>
    <!-- end modal -->
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
            this.adminData();
            this.getEmail();
         
        },
        BindEvents: function() {
            const $this = this.config;
            $this.$btn_manageAccount.on('click', this.showUpdateModal.bind(this));
            $this.$btn_verify.on('click', this.verificationCode.bind(this));
            $this.$btn_submit.on('click', this.updateData.bind(this));
            $this.$btn_requestCode.on('click', this.codeModalShow.bind(this));
            $this.$btn_reset.on('click', this.updatePassword.bind(this));
        },
        getEmail: function() {
            const $self = this.config;
            const email = $self.$lbl_adminEmail.text();
            $.ajax({
                url: '../controller/accountController.php',
                type: 'GET',
                dataType: 'json',
                data: { email: email },
                success: function(data) {
                    if (data && data.length > 0) {
                        $.each(data, function(index, item) {
                            $self.$lbl_verificationDetails.text("We have sent a code to your email " + item.maskEmail);
                        });
                    } else {
                        $self.$lbl_verificationDetails.text("No email found.");
                    }
                },
                error: function(xhr, status, error) {
                    $('#responseMessage').html('An error occurred while fetching the email: ' + error);
                }
            });
        },

        adminData: function(){
            const $self = this.config;
                $.ajax({
                    url: '../controller/accountController.php',
                    type: 'GET',
                    dataType: 'json',
                    data: { adminName: true },
                    success: function(data){
                        $.each(data, function(index, item){
                            $self.$lbl_adminName.attr('data-adminid', item.AdminID);
                            $self.$lbl_adminName.text(item.adminName);
                            $self.$lbl_adminEmail.text(item.Email);
                            $self.$lbl_adminNumber.text(item.PhoneNumber);
                        })
                        adminaccountPage.getEmail();
                    },
                });
        },
        showUpdateModal: function(){
            const $self = this.config;
            const adminID = $self.$lbl_adminName.attr('data-adminid');
            const adminName = $self.$lbl_adminName.text();
            const adminEmail = $self.$lbl_adminEmail.text();
            const adminNumber = $self.$lbl_adminNumber.text();

            $self.$inpt_adminName.val(adminName);
            $self.$inpt_adminEmail.val(adminEmail);
            $self.$inpt_adminNumber.val(adminNumber);
            $self.$updateModal.attr('data-adminid', adminID);
            $self.$updateModal.modal('show');
            
        },  
        codeModalShow: function() {
            const $self = this.config;
            $self.$resetModal.modal('show');
            const email = $self.$lbl_adminEmail.text();

            // Send a password reset request to the server
            $.ajax({
                url: '../controller/requestPassController.php',
                type: 'POST',
                data: { email: email },
                dataType: 'json', // Ensure jQuery interprets the response as JSON
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message); // Success message
                    } else if (response.status === "exist") {
                        $self.$lbl_remainingTime.text(response.message + response.minutes_left); // Message for existing code
                    } else if (response.error) {
                        alert(response.error); // Handle other errors returned from PHP
                    } else {
                        alert("An unexpected error occurred."); // Fallback message
                    }
                },
                error: function(xhr, status, error) {
                    $('#responseMessage').html('An error occurred: ' + error);
                }
            });
        },  


        verificationCode: function() {
            const $self = this.config;
            const userEmail = $self.$lbl_adminEmail.text(); // Ideally, this should be fetched dynamically
            const emailCode = $self.$inpt_verificationCode.val().trim();
            const adminID   = $self.$lbl_adminName.attr('data-adminid');

            if (!emailCode) {
                alert('Please enter the verification code.');
                return; // Exit if the code is not provided
            }

            $.ajax({
                url: '../controller/verificationCodeController.php', // Ensure this is the correct path
                type: 'POST',
                dataType: 'json',
                data: {
                    emailCode: emailCode,
                    userEmail: userEmail
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Verification code is valid. You may proceed to reset your password.');
                        
                        $self.$resetModal.modal('hide');
                        $self.$changePassModal.modal('show');
                        $self.$changePassModal.attr('data-adminid', adminID);
                       
                    } else {
                        alert(response.message); // Show error message
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred during verification: ' + error);
                }
            });
        },
        updateData: function() {
            const $self = this.config;
            const adminID = $self.$updateModal.attr('data-adminid');
            const adminName = $self.$inpt_adminName.val().trim();
            const adminEmail = $self.$inpt_adminEmail.val().trim();
            const adminNumber = $self.$inpt_adminNumber.val().trim();

            // Check if all fields are filled before sending the request
            if (!adminName || !adminEmail || !adminNumber) {
                alert('Please fill in all fields.');
                return;
            }

            $.ajax({
                url: '../controller/accountController.php',
                type: 'PUT',
                contentType: 'application/json', // Set the content type to JSON
                data: JSON.stringify({
                    adminID: adminID,
                    adminName: adminName,
                    adminEmail: adminEmail,
                    adminNumber: adminNumber
                }),
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status == "success") {
                        alert(data.message);
                        $.ajax({
                            url: '../controller/accountController.php',
                            type: 'GET',
                            dataType: 'json',
                            data: { adminName: true },
                            success: function(data){
                                $.each(data, function(index, item){
                                    $self.$lbl_adminName.attr('data-adminid', item.AdminID);
                                    $self.$lbl_adminName.text(item.adminName);
                                    $self.$lbl_adminEmail.text(item.Email);
                                    $self.$lbl_adminNumber.text(item.PhoneNumber);
                                })
                            },
                        });
                        $self.$updateModal.modal('hide');
                        $('#updateModal')[0].reset();
                        
                    } else {
                        alert(data.message); // Show error message if not successful
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating the data: ' + error);
                }
            });
        },
        updatePassword: function() {
            const $self = this.config;
            const adminID = $self.$changePassModal.attr('data-adminid');  // Ensure you're using the correct modal for admin ID
            const newPassword = $self.$inpt_newPassword.val().trim();
            const confirmNewPassword = $self.$inpt_confirmNewPassword.val().trim();

            if (newPassword !== confirmNewPassword) {
                alert('Passwords do not match!');
                return;
            }

            $.ajax({
                url: '../controller/accountController.php',
                type: 'PUT',  // Ensure the method is correct (PUT)
                contentType: 'application/json', // Set the content type to JSON
                data: JSON.stringify({
                    resetPass: true,
                    adminID: adminID,
                    newPassword: newPassword
                }),
                success: function(response) {
                    // Parse the response
                    const data = typeof response === "string" ? JSON.parse(response) : response; // Ensure we have a JSON object
                    console.log(data); // Log the response for debugging
                    if (data.status === 'success') {
                        alert(data.message); // Success message
                        $self.$changePassModal.modal('hide'); // Hide the modal
                        // Optionally, you can reset the input fields here
                        $self.$inpt_newPassword.val('');
                        $self.$inpt_confirmNewPassword.val('');
                    } else {
                        alert(data.message); // Show error message
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating the password: ' + error);
                }
            });
        }




        
    }

    adminaccountPage.Init({
        $resetModal                 : $('#resetModal'),
        $updateModal                : $('#updateModal'),
        $changePassModal            : $('#changePassModal'),
        $btn_manageAccount          : $('#btn-manageAccount'),
        $btn_verify                 : $('#btn-verify'),
        $btn_requestCode            : $('#btn-requestCode'),
        $btn_submit                 : $('#btn-submit'),
        $btn_reset                  : $('#btn-reset'),
        $lbl_verificationDetails    : $('#lbl-verificationDetails'),
        $lbl_adminName              : $('#lbl-adminName'),
        $lbl_adminEmail             : $('#lbl-adminEmail'),
        $lbl_adminNumber            : $('#lbl-phoneNumber'),
        $lbl_remainingTime          : $('#lbl-remainingTime'),
        $inpt_verificationCode      : $('#inpt-verificationCode'),
        $inpt_adminName             : $('#inpt-adminName'),
        $inpt_adminEmail            : $('#inpt-adminEmail'),
        $inpt_adminNumber           : $('#inpt-adminNumber'),
        $inpt_newPassword           : $('#inpt-newPassword'),
        $inpt_confirmNewPassword    : $('#inpt-confirmNewPassword')
    });
});
</script>


</body>
</html>
