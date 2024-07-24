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
                            <a href="rentalFee.php" class="sidebar-link">Rental Fee</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="rentalPayment.php" class="sidebar-link">Rental Payment</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="houseAmenities.php" class="sidebar-link">House Amenities</a>
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
        <!-- start modal -->
         <!-- modal-step-1 -->
        <div class="modal" id="modal-1" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white">Add Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="progress m-2" style="height: 2px;">
                <div class="progress-bar" role="progressbar" style="width: 33.33%; color: black" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form>
                <div class="modal-content p-4">
                <div class="mb-2">
                    <h4 class="mb-2">Tenant Info</h4>
                    <label for="tenantName" class="form-label" style="font-size: 14px">Full Name</label>
                    <input type="text" class="form-control" id="inpt-name" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="birthday" class="form-label" style="font-size: 14px">Birthday</label>
                    <input type="date" class="form-control" id="inpt-birthday" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="contactNumber" class="form-label" style="font-size: 14px">Contact Number</label>
                    <input type="number" class="form-control" id="inpt-number" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="emailAddress" class="form-label" style="font-size: 14px">Email Address</label>
                    <input type="email" aria-describedby="emailHelp" class="form-control" id="inpt-email" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="homeAddress" class="form-label" style="font-size: 14px">Current Address</label>
                    <input type="text" class="form-control" id="inpt-address" style="font-size: 15px; height: 30px">
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-nextStep">Next</button>
                </div>
                </div>
                </div>
            </div>
        </div>
        <!-- modal-step-2 -->
        <div class="modal" id="modal-2" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white">Add Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="progress m-2" style="height: 2px;">
                <div class="progress-bar" role="progressbar" style="width: 66.66%; color: black" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form>
                <div class="modal-content p-4">
                <div class="mb-2">
                    <h4 class="mb-2">Other Information</h4>
                    <label for="fatherName" class="form-label" style="font-size: 14px">Father's Full Name</label>
                    <input type="text" class="form-control" id="inpt-fatherName" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="fatherNumber" class="form-label" style="font-size: 14px">Contact Number</label>
                    <input type="number" class="form-control" id="inpt-fatherNumber" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="motherName" class="form-label" style="font-size: 14px">Mother's Full Name</label>
                    <input type="text" class="form-control" id="inpt-motherName" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="fatherNumber" class="form-label" style="font-size: 14px">Contact Number</label>
                    <input type="number" class="form-control" id="inpt-motherNumber" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="emergencyName" class="form-label" style="font-size: 14px">Emegency Contact Name</label>
                    <input type="text" class="form-control" id="inpt-emergencyName" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="emergencyNumber" class="form-label" style="font-size: 14px">Emergency Contact Phone Number</label>
                    <input type="number" class="form-control" id="inpt-emergencyNumber" style="font-size: 15px; height: 30px">
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-step2-previous">Previous</button>
                    <button type="button" class="btn btn-primary" id="btn-step2-next">Next</button>
                </div>
                </div>
                </div>
            </div>
        </div>
        <!-- modal-step-3 -->
        <div class="modal" id="modal-3" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white">Add Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="progress m-2" style="height: 2px;">
                <div class="progress-bar" role="progressbar" style="width: 100%; color: black" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form>
                <div class="modal-content p-4">
                <div class="mb-2">
                    <h4 class="mb-2">Create Tenant Account</h4>
                    <label for="username" class="form-label" style="font-size: 14px">Username</label>
                    <input type="text" class="form-control" id="inpt-username" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label" style="font-size: 14px">Password</label>
                    <input type="Password" class="form-control" id="inpt-password" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="confirmPassword" class="form-label" style="font-size: 14px">Confirm Password</label>
                    <input type="Password" class="form-control" id="inpt-confirmPassword" style="font-size: 15px; height: 30px">
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-step3-previous">Previous</button>
                    <button type="button" class="btn btn-primary" id="btn-submit">Submit</button>
                </div>
                </div>
                </div>
            </div>
        </div>
        <!-- end Modal -->
        <main class="content px-4 py-4">
        <div class="container-fluid bg-white">
                <div class="room-content p-2">
                    <div class="row">
                        <div class="d-md-flex" id="house-location-container"></div>
                        <div class="d-flex align-items-center py-2" style="height: 50px;">
                            <div class="d-flex align-items-center mb-2">
                                <label for="sel-roomType" class="form-label me-2">Search</label>
                                <input type="text" id="inpt-searchName" class="form-control" placeholder="Enter Name" style="font-size: 15px; height: 40px">
                            </div>
                            <div class="ms-auto mb-2">
                                <button class="btn btn-primary btn-sm p-2" type="button" id="btn-add" style="font-size: 12px;">Add Tenant</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="table-wrapper">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr style="font-size: 15px">
                                            <th scope="col">Name</th>
                                            <th scope="col">House Rented</th>
                                            <th scope="col">Room Number</th>
                                            <th scope="col">Monthly Rate</th>
                                            <th scope="col">Outstanding Balance</th>
                                            <th scope="col">Last Payment</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody" style="font-size: 15px;" >
                                        <!-- Table rows go here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
   $(document).ready(function() {
    $("#sidebar-toggle").click(function() {
        $("#sidebar").toggleClass("collapsed");
    });
    const housePage = {
    Init: function(config) {
        this.config = config;
        this.BindEvents();
    },
    BindEvents: function() {
        const $this = this.config;
            $this.$btn_add.on('click', this.modalShow.bind(this));
            $this.$btn_nextStep.on('click', this.step_1_Modal.bind(this));
            $this.$btn_step2_next.on('click', this.nextStepstep_2_Modal.bind(this));
            $this.$btn_step2_previous.on('click', this.previousStepstep_2_Modal.bind(this));
            $this.$btn_step3_previous.on('click', this.previousStepstep_3_Modal.bind(this));
    },
    modalShow: function(){
        const $self = this.config;
            $self.$modal_1.modal('show');
    },
    step_1_Modal: function(){
        const $self = this.config;

        // if($self.$inpt_name.val().trim()==="" || $self.$inpt_number.val().trim()==="" || $self.$inpt_address.val().trim()==="" ||
        // $self.$inpt_province.val().trim()==="" || $self.$inpt_city.val().trim()==="" || $self.$inpt_zipCode.val().trim()===""){
        //     alert("ok");
        // }else{
            $self.$modal_1.modal("hide");
            $self.$modal_2.modal("show");
        // }

    },
    nextStepstep_2_Modal: function(){
        const $self = this.config;
            $self.$modal_2.modal("hide");
            $self.$modal_3.modal("show");
    },
    previousStepstep_2_Modal: function(){
        const $self = this.config;
            $self.$modal_2.modal("hide");
            $self.$modal_1.modal("show");
    },
    previousStepstep_3_Modal: function(){
        const $self = this.config;
            $self.$modal_3.modal("hide");
            $self.$modal_2.modal("show");
    },
    addTenant: function(){
        const $self = this.config;
        const formData = {
                        name            : $self.$inpt_name.val().trim(),
                        birthday        : $self.$inpt_birthday.val().trim(),
                        number          : $self.$inpt_number.val().trim(),
                        email           : $self.$inpt_email.val().trim(),
                        address         : $self.$inpt_address.val().trim(),
                        fatherName      : $self.$inpt_fatherName.val().trim(),
                        fatherNumber    : $self.$inpt_fatherNumber.val().trim(),
                        motherName      : $self.$inpt_motherName.val().trim(),
                        motherNumber    : $self.$inpt_motherNumber.val().trim(),
                        emergencyName   : $self.$inpt_emergencyName.val().trim(),
                        emergencyNumber : $self.$inpt_emergencyNumber.val().trim(),
                    };
        const accountData ={
                        username        : $self.$inpt_username.val().trim(),
                        password        : $self.$inpt_password.val().trim(),
                        confirmPassword : $self.$inpt_confirmPassword.val().trim()
                    };

    }
    }
    housePage.Init({
        $btn_add                            : $('#btn-add'),
        $btn_nextStep                       : $('#btn-nextStep'),
        $btn_step2_next                     : $('#btn-step2-next'),
        $btn_step2_previous                 : $('#btn-step2-previous'),
        $btn_submit                         : $('#btn-submit'),
        $btn_step3_previous                 : $('#btn-step3-previous'),
        $modal_1                            : $('#modal-1'),
        $modal_2                            : $('#modal-2'),
        $modal_3                            : $('#modal-3'),
        $inpt_name                          : $('#inpt-name'),
        $inpt_birthday                      : $('#inpt-birthday'),
        $inpt_number                        : $('#inpt-number'),
        $inpt_email                         : $('#inpt-email'),
        $inpt_address                       : $('#inpt-address'),
        $inpt_fatherName                    : $('#inpt-fatherName'),
        $inpt_fatherNumber                  : $('#inpt-fatherNumber'),
        $inpt_motherName                    : $('#inpt-motherName'),
        $inpt_motherNumber                  : $('#inpt-motherNumber'),
        $inpt_emergencyName                 : $('#inpt-emergencyName'),
        $inpt_emegencyNumber                : $('#inpt-emergencyNumber'),
        $inpt_username                      : $('#inpt-username'),
        $inpt_password                      : $('#inpt-password'),
        $inpt_confirmPassword               : $('#inpt-confirmPassword')
    });

    });

</script>
</body>
</html>
