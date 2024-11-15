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
        <!-- start modal -->
         <!-- modal-step-1 -->
         <div class="modal" id="modal-1" tabindex="-1" action="new">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white" id="modalTitle">Add Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="progress m-2" style="height: 2px;">
                <div class="progress-bar" role="progressbar"  style="width: 33.33%; color: black" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form id="form2" >
                <div class="modal-content p-4">
                <div class="mb-2">
                    <h4 class="mb-2">Tenant Info</h4>
                    <label for="tenantName" class="form-label" style="font-size: 14px">Full Name</label>
                    <input type="text" class="form-control" id="inpt-name" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                <div class="row align-items-start">
                <div class="col">
                    <label for="contactNumber" class="form-label" style="font-size: 14px">Contact Number</label>
                    <input type="number" class="form-control" id="inpt-number" style="font-size: 15px; height: 30px" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11)">
                </div>
                    <div class="col">
                        <label for="gender" class="form-label" style="font-size: 14px">Gender</label>
                        <select id="inpt-gender" class="form-select" style="font-size: 13px; height: 31px" placeholder="Select Gender">
                            <option value ="" disabled selected>Select Gender</option>
                            <option value ="Male">Male</option>
                            <option value ="Female">Female</option>
                        </select>

                    </div>
                </div>
                </div>
                <div class="mb-2">
                <label for="emailAddress" class="form-label" style="font-size: 14px">Email Address</label>
                <input type="email" aria-describedby="emailHelp" class="form-control" id="inpt-email" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-2">
                    <label for="homeAddress" class="form-label" style="font-size: 14px">Home Address</label>
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
        <div class="modal" id="modal-2" tabindex="-1" action="new" data-tenantID="" data-roomID="">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white" id="modalTitle2">Add Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="progress m-2" style="height: 2px;">
                <div class="progress-bar" role="progressbar" style="width: 66.66%; color: black" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form id="form3">
                <div class="modal-content p-4">
                <div class="mb-2">
                    <h4 class="mb-2">Other Information</h4>
                    <div class="row align-items-start">
                    <div class="col">
                        <label for="fatherName" class="form-label" style="font-size: 14px">Father's Full Name</label>
                        <input type="text" class="form-control" id="inpt-fatherName" style="font-size: 15px; height: 30px">
                    </div>
                    <div class="col">
                        <label for="fatherNumber" class="form-label" style="font-size: 14px">Contact Number</label>
                        <input type="number" class="form-control" id="inpt-fatherNumber" style="font-size: 15px; height: 30px" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11)">
                    </div>
                </div>
                </div>
                <div class="mb-2">
                    <div class="row align-items-start">
                    <div class="col">
                        <label for="motherName" class="form-label" style="font-size: 14px">Mother's Full Name</label>
                        <input type="text" class="form-control" id="inpt-motherName" style="font-size: 15px; height: 30px">
                    </div>
                    <div class="col">
                        <label for="fatherNumber" class="form-label" style="font-size: 14px">Contact Number</label>
                        <input type="number" class="form-control" id="inpt-motherNumber" style="font-size: 15px; height: 30px" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11)">
                    </div>
                </div>
                </div>
                <div class="mb-2">
                    <div class="row align-items-start">
                    <div class="col">
                        <label for="emergencyName" class="form-label" style="font-size: 14px">Emegency Contact Name</label>
                        <input type="text" class="form-control" id="inpt-emergencyName" style="font-size: 15px; height: 30px">
                    </div>
                    <div class="col">
                        <label for="emergencyNumber" class="form-label" style="font-size: 14px">Contact Number</label>
                        <input type="number"class="form-control" id="inpt-emergencyNumber" style="font-size: 15px; height: 30px" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11)">
                    </div>
                </div>
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
        <div class="modal" id="modal-3" tabindex="-1" action="new">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white" id="modalTitle3">Add Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="progress m-2" style="height: 2px;">
                <div class="progress-bar" role="progressbar" style="width: 100%; color: black" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form id="form1">
                <div class="modal-content p-4">
                <div class="mb-2">
                    <h4 class="mb-2">Create Tenant Account</h4>
                <div class="row align-items-start">
                    <div class="col">
                        <label for="houseLocation" class="form-label" style="font-size: 14px">House Location</label>
                            <select id="sel-houseLocation" class="form-select" style="font-size: 15px; height: 40px">
                                            <option>Select House</option>
                            </select>
                    </div>
                    <div class="col">
                        <label for="roomNumber" class="form-label" style="font-size: 14px">Room Number</label>
                        <select id="sel-roomNumber" class="form-select" style="font-size: 15px; height: 40px">
                                        <option style="font-size: 15px;">Select Room Number</option>
                        </select>
                    </div>
                </div>
                </div>
                <div class="mb-2">
                    <label for="username" class="form-label" style="font-size: 14px">Date Started</label>
                    <input type="date" class="form-control" id="inpt-dateStarted" style="font-size: 15px; height: 40px">
                </div>
                <div class="mb-2">
                    <label for="username" class="form-label" style="font-size: 14px">Username</label>
                    <input type="text" class="form-control" id="inpt-username" style="font-size: 15px; height: 40px">
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label" id="lbl-password" style="font-size: 14px; display: none">Password</label>
                    <input type="text" class="form-control" id="inpt-password" style="font-size: 15px; height: 40px; display: none" disabled >
                    <button type="button" class="btn btn-primary mt-2" id="generatePass">Generate Password</button>
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
        <!-- modal-for-ViewData -->
        <div class="modal" id="modalView" tabindex="-1">
        <div class="modal-dialog" style="max-width: 80%">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl-tenantName"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-6">
                <h6>Details</h6>
                </div>
                <div class="container" style="font-size: 12px;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="phone-number" id="lbl-tenantNumber" class="form-label" >Phone Number:</label>
                        </div>
                        <div class="mb-3">
                            <label for="current-address" id="lbl-address" class="form-label">Current Address:</label>
                        </div>
                        <div class="mb-3">
                            <label for="fathers-name" id="lbl-fatherName" class="form-label">Father's Name:</label>
                        </div>
                        <div class="mb-3">
                            <label for="mothers-name" id="lbl-motherName" class="form-label">Mother's Name:</label>
                        </div>
                        <div class="mb-3">
                            <label for="emergency-name" id="lbl-emergencyName" class="form-label">Emergency Name:</label>
                        </div>
                        <div class="mb-3">
                            <label for="date-started" id="lbl-dateStarted" class="form-label">Date Started:</label>
                        </div>
                        
                    </div>
                    <div class="col-md-3">
                            <div class="mb-3">
                                <label for="gender" id="lbl-gender" class="form-label">Gender:</label>
                            </div>
                            <div class="mb-3">
                                <label for="email" id="lbl-email"  class="form-label">Email:</label>
                            </div>  
                            <div class="mb-3">
                                <label for="fathers-phone-number" id="lbl-nvm" class="form-label">Phone Number:</label>
                            </div>
                            <div class="mb-3">
                                <label for="fathers-phone-number"  id="lbl-fathersNumber" class="form-label">Phone Number:</label>
                            </div>
                            <div class="mb-3">
                                <label for="mothers-phone-number" id="lbl-mothersNumber" class="form-label">Phone Number:</label>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                <label for="inpt-searchName" class="form-label me-2">Search</label>
                                <input type="text" id="inpt-searchName" class="form-control" placeholder="Enter Name" data-status="active"style="font-size: 15px; height: 40px">
                            </div>
                            <div class="ms-auto mb-2" id="content-btn">
                            <button class="btn btn-primary btn-sm p-2" type="button" id="btn-inactiveTenant" style="font-size: 12px;">Inactive Tenant</button>
                                <button class="btn btn-primary btn-sm p-2" type="button" id="btn-add" style="font-size: 12px;">Add Tenant</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="table-wrapper">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr style="font-size: 15px">
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">House Rented</th>
                                            <th scope="col">Room</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody" data-action="new" style="font-size: 15px;" >
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

    const tenantPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.getHouseLocation();
            this.displayData();
        },
        BindEvents: function() {
            const $this = this.config;
            $this.$btn_add.on('click', this.btnAdd.bind(this));
            $this.$btn_nextStep.on('click', this.step_1_Modal.bind(this));
            $this.$btn_step2_next.on('click', this.nextStep_2_Modal.bind(this));
            $this.$btn_step2_previous.on('click', this.previousStep_2_Modal.bind(this));
            $this.$btn_step3_previous.on('click', this.previousStep_3_Modal.bind(this));
            $this.$btn_submit.on('click', this.addTenant.bind(this));
            $this.$tbody.on('click', '#btn-view', this.viewData.bind(this));
            $this.$tbody.on('click', '#btn-delete', this.deleteData.bind(this));
            $this.$tbody.on('click', '#btn-edit', this.editButton.bind(this));
            $this.$modal_3.on('click', '#btn-Update', this.update.bind(this));
            $this.$btn_generatePass.on('click', this.generate.bind(this));
            $this.$inpt_searchName.on('keyup', this.filterName.bind(this));
            $this.$btn_inactiveTenant.on('click', this.inactiveTenant.bind(this));
            $this.$content_btn.on('click', '#btn-activeTenant', this.activeTenant.bind(this));
            $this.$tbody.on('click', '#btn-active', this.btnActiveTenant.bind(this));
            $this.$btn_close.on('click', this.btnClose.bind(this));
           
            // Bind change event to house location dropdown
            $this.$sel_houseLocation.on('change', this.getRoom.bind(this));
        },
        btnClose: function(){
            const $self = this.condig

            $('#form1')[0].reset();
            $('#form2')[0].reset();
            $('#form2')[0].reset();
        },
        btnAdd: function(){
            const $self = this.config;
            $self.$modal_1.attr('action', 'new');
            $self.$modal_2.attr('action', 'new');
            $self.$modal_3.attr('action', 'new');
            $self.$btn_submit.text("Save");
            $self.$btn_submit.attr('id', 'btn-submit');

            $('#modalTitle').text('Add Tenant');
            $('#modalTitle').text('Add Tenant');
            $('#modalTitle').text('Add Tenant');
          
         

            $self.$lbl_password.hide();
            $self.$inpt_password.hide();
            $self.$modal_1.modal('show');
        },
        step_1_Modal: function(){
            const $self = this.config;
            $self.$modal_1.modal("hide");
            $self.$modal_2.modal("show");
        },
        nextStep_2_Modal: function(){
            const $self = this.config;
            $self.$modal_2.modal("hide");
            $self.$modal_3.modal("show");
        },
        previousStep_2_Modal: function(){
            const $self = this.config;
            $self.$modal_2.modal("hide");
            $self.$modal_1.modal("show");
        },
        previousStep_3_Modal: function(){
            const $self = this.config;
            $self.$modal_3.modal("hide");
            $self.$modal_2.modal("show");
        },       
        getHouseLocation: function(){
            const $self = this.config;
            $.ajax({
                url: '../controller/tenantController.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const selectHouse = $self.$sel_houseLocation;
                    selectHouse.empty();
                    selectHouse.append('<option value="" style="font-size: 15px;">Select House</option>');

                    $.each(response.data, function(index, item) {
                        selectHouse.append('<option value="' + item.houseID + '">' + item.houselocation + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        },
        getRoom: function() {
            const $self = this.config;
            const houseID = $self.$sel_houseLocation.val();
            const action = $self.$tbody.data('action');
            if (!houseID) {
                $self.$sel_roomNumber.empty().append('<option value="" style="font-size: 15px;">Select Room</option>');
                return;
            }
            $.ajax({
                url: '../controller/tenantController.php',
                type: 'POST',
                data: { houseID: houseID, action: action },
                dataType: 'json',
                success: function(response) {
                
                    const selectRoom = $self.$sel_roomNumber;
                    selectRoom.empty();
                    selectRoom.append('<option value="" style="font-size: 15px;">Select Room</option>');

                    $.each(response.data, function(index, item) {
                        selectRoom.append('<option value="' + item.roomID + '" data-roomtype="' + item.roomType + '">' + item.roomNumber + ', ' + item.roomType + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        },
        generate: function(){
            const $self = this.config;
            $.ajax({
                    url: '../controller/tenantController.php',
                    type: 'POST',
                    data:{generatePass: true},
                    dataType: 'json',
                    success: function(response) {
                        $self.$lbl_password.show();
                        $self.$inpt_password.show();
                        $self.$inpt_password.val(response.password);
                    },
                    error: function() {
                        console.error("Error generating password");
                    }
                });
        },
        addTenant: function() {
            const $self = this.config;
            const action = $self.$modal_3.attr('action'); // Get the action ('new' or 'edit')
            const selectedOption = $self.$sel_roomNumber.find("option:selected");
            

            if (action === "new") {
                // Gather form input values
                const tenantName = $self.$inpt_name.val().trim();
                const gender = $self.$inpt_gender.val();
                const number = $self.$inpt_number.val().trim();
                const email = $self.$inpt_email.val().trim();
                const address = $self.$inpt_address.val().trim();
                const fatherName = $self.$inpt_fatherName.val().trim();
                const fatherNumber = $self.$inpt_fatherNumber.val().trim();
                const motherName = $self.$inpt_motherName.val().trim();
                const motherNumber = $self.$inpt_motherNumber.val().trim();
                const emergencyName = $self.$inpt_emergencyName.val().trim();
                const emergencyNumber = $self.$inpt_emergencyNumber.val().trim();
                const dateStarted = $self.$inpt_dateStarted.val().trim();
                const username = $self.$inpt_username.val().trim();
                const roomID = $self.$sel_roomNumber.val();
                const roomType = selectedOption.data("roomtype");
                const password = $self.$inpt_password.val().trim();
                const tenantStatus = "active"; // Set initial tenant status

                // Validation
                if (
                    !tenantName ||!gender || gender === "" || !number || !email || !address ||
                    !fatherName || !fatherNumber || !motherName || !motherNumber ||
                    !emergencyName || !emergencyNumber || !dateStarted || 
                    !username || !roomID || !password
                    ) {
                    alert('Please fill in all required fields.');
                    return;
                }

                // Validate email format
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(email)) {
                    alert('Please enter a valid email address.');
                    return;
                }

                // Validate phone number format (example: must be numeric and 11 digits)
                const phonePattern = /^[0-9]{11}$/;
                if (number && !phonePattern.test(number)) {
                    alert('Please enter a valid phone number (10 digits).');
                    return;
                }

                if (fatherNumber && !phonePattern.test(fatherNumber)) {
                    alert('Please enter a valid father\'s phone number (11 digits).');
                    return;
                }

                if (motherNumber && !phonePattern.test(motherNumber)) {
                    alert('Please enter a valid mother\'s phone number (11 digits).');
                    return;
                }

                if (emergencyNumber && !phonePattern.test(emergencyNumber)) {
                    alert('Please enter a valid emergency phone number (11 digits).');
                    return;
                }

                // Password validation (minimum 6 characters)
                if (password.length < 6) {
                    alert('Password must be at least 6 characters long.');
                    return;
                }

                // Send the data to the server via AJAX
                $.ajax({
                    url: '../controller/tenantController.php',
                    type: 'POST',
                    data: {
                        tenantName,
                        gender,
                        number,
                        email,
                        address,
                        fatherName,
                        fatherNumber,
                        motherName,
                        motherNumber,
                        emergencyName,
                        emergencyNumber,
                        dateStarted,
                        username,
                        password,
                        tenantStatus,
                        roomID,
                        roomType
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === "success") {
                            alert(response.message);
                            $self.$tbody.empty(); // Clear the table before adding the new tenant
                            // Add new tenant to the table
                            response.data.forEach(function(item) {
                                const row = `
                                    <tr class="text-capitalize" data-tenantid="${item.tenantID}" data-roomid="${item.roomID}">
                                        <td>${item.tenantName}</td>
                                        <td>${item.phoneNumber}</td>
                                        <td>${item.houselocation}</td>
                                        <td>Room Number: ${item.roomNumber} <br/> Room Type: ${item.roomType}</td>
                                        <td>${item.tenantStatus}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-view" data-tenantID="${item.tenantID}">View</button>
                                            <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-edit" data-tenantID="${item.tenantID}">Edit</button>
                                            <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-delete" data-tenantID="${item.tenantID}">Inactive</button>
                                        </td>
                                    </tr>`;
                                $self.$tbody.append(row); // Append new row
                            });

                            // Reset the modal and form
                            $self.$modal_3.modal('hide');
                            $('#form1')[0].reset();
                            $('#form2')[0].reset();
                            $('#form2')[0].reset()
                        } else {
                            console.error(response.message);
                            alert(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown);
                        alert('An error occurred while submitting tenant details.');
                    }
                });
            }
        },
        activeTenant: function() {
            const $self = this.config;
            $self.$inpt_searchName.attr('data-status', 'active');
            
            $.ajax({
                url: '../controller/tenantController.php',
                type: 'GET',
                data: { tenant: true },
                dataType: 'json',
                success: function(response) {
                    $self.$tbody.empty(); // Clear the table body

                    if (response.status === 'success') {
                        if (response.data && response.data.length > 0) {
                            // Populate active tenants
                            $.each(response.data, function(index, item) {
                                const row = `
                                <tr class="text-capitalize" data-tenantid="${item.tenantID}" data-roomid="${item.roomID}">
                                    <td>${item.tenantName}</td>
                                    <td>${item.phoneNumber}</td>
                                    <td>${item.houselocation}</td>
                                    <td>Room Number: ${item.roomNumber} <br/> Room Type: ${item.roomType}</td>
                                    <td>${item.tenantStatus}</td>
                                    <td>
                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-view" data-roomID="${item.tenantID}">View</button>
                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-edit" data-roomID="${item.tenantID}">Edit</button>
                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-active" data-roomID="${item.tenantID}">Inactive</button>
                                    </td>
                                </tr>`;
                                $self.$tbody.append(row);
                            });
                            $self.$btn_add.show(); // Show add button when tenants are found
                            $self.$btn_inactiveTenant.text("Inactive Tenant").attr('id', 'btn-inactiveTenant');
                        } else {
                            // No active tenants found
                            $self.$tbody.append('<tr><td colspan="6" class="text-center">No active tenants found</td></tr>');
                            $self.$btn_add.hide(); // Hide add button if no tenants
                            $self.$btn_inactiveTenant.text("Inactive Tenant").attr('id', 'btn-inactiveTenant');
                        }
                    } else {
                        console.error('Error fetching data: ' + response.message);
                        $self.$tbody.append('<tr><td colspan="6" class="text-center">Error fetching data</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                    $self.$tbody.append('<tr><td colspan="6" class="text-center">Error fetching data</td></tr>');
                }
            });
        },
        inactiveTenant: function() {
            const $self = this.config;
            $self.$inpt_searchName.attr('data-status', 'inactive');

            $.ajax({
                url: '../controller/tenantController.php',
                type: 'GET',
                data: { inactiveTenant: true },
                dataType: 'json',
                success: function(response) {
                    $self.$tbody.empty(); // Clear the table body

                    if (response.status === 'success') {
                        if (response.data && response.data.length > 0) {
                            // Populate inactive tenants
                            $.each(response.data, function(index, item) {
                                const row = `
                                <tr class="text-capitalize" data-tenantid="${item.tenantID}" data-roomid="${item.roomID}">
                                    <td>${item.tenantName}</td>
                                    <td>${item.phoneNumber}</td>
                                    <td>${item.houselocation}</td>
                                    <td>Room Number: ${item.roomNumber} <br/> Room Type: ${item.roomType}</td>
                                    <td>${item.tenantStatus}</td>
                                    <td>
                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-view" data-roomID="${item.tenantID}">View</button>
                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-edit" data-roomID="${item.tenantID}">Edit</button>
                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-active" data-roomID="${item.tenantID}">Activate</button>
                                    </td>
                                </tr>`;
                                $self.$tbody.append(row);
                            });
                            $self.$btn_add.hide(); // Hide add button when inactive tenants are found
                            $self.$btn_inactiveTenant.text("Active Tenant").attr('id', 'btn-activeTenant');
                        } else {
                            // No inactive tenants found
                            $self.$tbody.append('<tr><td colspan="6" class="text-center">No inactive tenants found</td></tr>');
                            $self.$btn_add.hide(); // Show add button if no inactive tenants are found
                            $self.$btn_inactiveTenant.text("Active Tenant").attr('id', 'btn-activeTenant');
                        }
                    } else {
                        console.error('Error fetching data: ' + response.message);
                        $self.$tbody.append('<tr><td colspan="6" class="text-center">Error fetching data</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                    $self.$tbody.append('<tr><td colspan="6" class="text-center">Error fetching data</td></tr>');
                }
            });
        },
        displayData: function(){
            const $self = this.config;
                $.ajax({
                    url: '../controller/tenantController.php',
                    type: 'GET',
                    data: { tenant: true },
                    dataType: 'json',
                    success: function(response) {
                                        if (response.status === 'success') {
                                            $self.$tbody.empty(); 
                                            if (response.data.length > 0) { 
                                                $.each(response.data, function(index, item) {
                                                    const row = `
                                                            <tr class="text-capitalize" data-tenantid="${item.tenantID}" data-roomid="${item.roomID}">
                                                                <td>${item.tenantName}</td>
                                                                <td>${item.phoneNumber}</td>
                                                                <td>${item.houselocation}</td>
                                                                <td>Room Number: ${item.roomNumber} <br/> Room Type: ${item.roomType}</td>
                                                                 <td>${item.tenantStatus}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" flex-fill id="btn-view" data-roomID="${item.tenantID}">View</button>
                                                                    <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-edit" data-roomID="${item.tenantID}">Edit</button>
                                                                    <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" flex-fill id="btn-delete" data-roomID="${item.tenantID}">Inactive</button>
                                                                </td>
                                                            </tr>`;
                                                            $self.$tbody.append(row);
                                                    $self.$modal_3.modal('hide');   
                                                });
                                            } else { 
                                                $self.$tbody.append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                                            }
                                        } else { 
                                            console.error('Error fetching data: ' + response.message);
                                        }
                                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' ' + error);
                    }
                });
        },
        viewData: function(event) {
            const $self = this.config;
            const $row = $(event.currentTarget).closest('tr');
            const tenantID = $row.data('tenantid'); 
            
                $.ajax({
                    url: '../controller/tenantController.php',
                    type: 'GET',
                    data: { tenantID: tenantID },
                    dataType: 'json',
                    success: function(response){
                        if(response.status ==="success"){
                            $.each(response.data, function(index, item) {
                                $('#lbl-tenantName').text(`Name: ${item.tenantName}`);
                                $('#lbl-address').text(`Current Address: ${item.currentAddress}`);
                                $('#lbl-gender').text(`Gender: ${item.gender}`);
                                $('#lbl-tenantNumber').text(`Phone Number: ${item.phoneNumber}`);
                                $('#lbl-email').text(`Email: ${item.emailAddress}`);
                                $('#lbl-fatherName').text(`Father's Name: ${item.fatherName}`);
                                $('#lbl-fathersNumber').text(`Phone Number: ${item.fatherNumber}`);
                                $('#lbl-motherName').text(`Mother's Name: ${item.motherName}`);
                                $('#lbl-mothersNumber').text(`Phone Number: ${item.motherNumber}`);
                                $('#lbl-emergencyName').text(`Emergency Name: ${item.emergencyName}`);
                                $('#lbl-emergencyNumber').text(`Phone Number: ${item.emergencyNumber}`);
                                $('#lbl-dateStarted').text(`Date Started: ${item.dateStarted}`);
                                $('#lbl-balanceskie').text(`Balance: ${item.balance}`);
                                $('#lbl-tenantUsername').text(`Username: ${item.username}`);
                                    $("#modalView").modal('show');
                            });
                        }   
                    },
                    error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
                });
        },
        deleteData: function(event){
            const $self = this.config;
            const $row = $(event.currentTarget).closest('tr');
            const tenantID = $row.data('tenantid'); 
            const roomID = $row.data('roomid'); 
            if(confirm("Are you sure you want to set this tenant as inactive?")){
                $.ajax({
                    url: '../controller/tenantController.php',
                    type    : 'DELETE',
                    data    : {tenantID : tenantID, roomID : roomID},
                    success : function(response){
                        var result = JSON.parse(response);
                        if(result.status === 'success') {
                                alert(result.message);
                                $row.remove();
                            } else {
                                alert(result.message);
                            }
                    },
                    error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                        }
                    });
            }
        },
        editButton: function(event) {   
            const $self = this.config;
            const $row = $(event.currentTarget).closest('tr');
            const tenantID = $row.data('tenantid');
            const action = 'edit';
            $self.$tbody.data('action', 'edit');

            $('.modalTitle').text('Edit Tenant');
            $self.$modal_3.attr('action', action);
            $self.$btn_submit.text("Save Update");
            $self.$btn_submit.attr('id', 'btn-Update');
            $self.$modal_3.attr('data-tenantid', tenantID);

            // Hide password fields when editing
            $self.$lbl_password.hide();
            $self.$inpt_password.hide();

            // Fetch tenant data
            $.ajax({
                url: '../controller/tenantController.php',
                type: 'GET',
                data: { tenantID: tenantID },
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        const tenantData = response.data[0];
                        // Display existing room and details for editing
                        $self.$sel_houseLocation.val(tenantData.houseID).trigger('change');
                        
                        // Delay to ensure room options are loaded, then select the current room number
                        setTimeout(function() {
                            $self.$sel_roomNumber.val(tenantData.roomID);
                            $self.$sel_roomNumber.attr('data-oldroomid', tenantData.roomID);
                        }, 10);

                        $self.$inpt_name.val(tenantData.tenantName);
                        $self.$inpt_gender.val(tenantData.gender);
                        $self.$inpt_number.val(tenantData.phoneNumber);
                        $self.$inpt_email.val(tenantData.emailAddress);
                        $self.$inpt_address.val(tenantData.currentAddress);
                        $self.$inpt_fatherName.val(tenantData.fatherName);
                        $self.$inpt_fatherNumber.val(tenantData.fatherNumber);
                        $self.$inpt_motherName.val(tenantData.motherName);
                        $self.$inpt_motherNumber.val(tenantData.motherNumber);
                        $self.$inpt_emergencyName.val(tenantData.emergencyName);
                        $self.$inpt_emergencyNumber.val(tenantData.emergencyNumber);
                        $self.$inpt_dateStarted.val(tenantData.dateStarted);
                        $self.$inpt_username.val(tenantData.username);

                        $self.$modal_1.modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        },
        update: function() {
            const $self = this.config;
            const tenantID = $self.$modal_3.data('tenantid');
            const action = $self.$modal_3.attr('action'); // Check if action is 'edit'
            const oldRoomID = $self.$sel_roomNumber.data('oldroomid');
            // Collect form values
            const tenantData = {
                tenant: true,
                action: action,
                tenantID,
                oldRoomID : oldRoomID,
                tenantName: $self.$inpt_name.val().trim(),
                gender: $self.$inpt_gender.val().trim(),
                phoneNumber: $self.$inpt_number.val().trim(),
                emailAddress: $self.$inpt_email.val().trim(),
                currentAddress: $self.$inpt_address.val().trim(),
                fatherName: $self.$inpt_fatherName.val().trim(),
                fatherNumber: $self.$inpt_fatherNumber.val().trim(),
                motherName: $self.$inpt_motherName.val().trim(),
                motherNumber: $self.$inpt_motherNumber.val().trim(),
                emergencyName: $self.$inpt_emergencyName.val().trim(),
                emergencyNumber: $self.$inpt_emergencyNumber.val().trim(),
                dateStarted: $self.$inpt_dateStarted.val().trim(),
                roomID: $self.$sel_roomNumber.val()
            };
            console.log(tenantData);
            // Form validation here

            // Check if action is 'edit'
            if (action === 'edit') {
                // Modify the tenant data before sending the request for 'edit'
                tenantData.tenantID = tenantID; // Ensure tenantID is included for 'edit'

                // Send data to the server with PUT method for edit
                $.ajax({
                    url: '../controller/tenantController.php',
                    type: 'PUT',  // 'PUT' for edit action
                    contentType: 'application/json',
                    data: JSON.stringify(tenantData),
                    dataType: 'json',
                    success: function(response) {
                        alert(response.message);
                        if (response.status === "success") {
                            location.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('An error occurred while updating tenant.');
                    }
                });
            } 
        },
        filterName: function() {
                const $self = this.config;
                let query = $self.$inpt_searchName.val().trim(); // Get trimmed search query

                // Clear the table before appending new data
                $self.$tbody.empty();

                // If query is not empty, perform search
                if (query !== '') {
                    const action = $self.$inpt_searchName.attr('data-status');
                    if(action === "active"){
                        $.ajax({
                            url: '../controller/tenantController.php', // PHP script to process the request
                            method: 'POST',
                            dataType: 'json', // Expect JSON response
                            data: { query: query }, // Send the query as POST data for active tenants
                            success: function(response) {
                                    // Check if response.data is an array and has elements
                                    if (Array.isArray(response.data) && response.data.length > 0) {
                                        // Populate the table with filtered data
                                        $.each(response.data, function(index, item) {
                                            const row = `
                                                <tr class="text-capitalize" data-tenantid="${item.tenantID}" data-roomid="${item.roomID}">
                                                    <td>${item.tenantName}</td>
                                                    <td>${item.phoneNumber}</td>
                                                    <td>${item.houselocation}</td>
                                                    <td>Room Number: ${item.roomNumber} <br/> Room Type: ${item.roomType}</td>
                                                    <td>${item.tenantStatus}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" flex-fill id="btn-view" data-roomID="${item.tenantID}">View</button>
                                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-edit" data-roomID="${item.tenantID}">Edit</button>
                                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" flex-fill id="btn-delete" data-roomID="${item.tenantID}">Inactive</button>
                                                    </td>
                                                </tr>`;
                                            $self.$tbody.append(row);
                                        });
                                    } else {
                                        // Append message if no tenants are found
                                        $self.$tbody.append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                                    }
                                },

                            error: function(xhr, status, error) {
                                console.error('AJAX Error: ' + status + ' ' + error);
                                $self.$tbody.append('<tr><td colspan="6">An error occurred while fetching tenants.</td></tr>');
                            }
                        });
                    } else if (action === "inactive") {
                        $.ajax({
                            url: '../controller/tenantController.php', // PHP script to process the request
                            method: 'POST',
                            dataType: 'json', // Expect JSON response
                            data: { queryInactive: query }, // Send the query as POST data for inactive tenants
                            success: function(response) {
                                    // Check if response.data is an array and has elements
                                    if (Array.isArray(response.data) && response.data.length > 0) {
                                        // Populate the table with filtered data
                                        $.each(response.data, function(index, item) {
                                            const row = `
                                                <tr class="text-capitalize" data-tenantid="${item.tenantID}" data-roomid="${item.roomID}">
                                                    <td>${item.tenantName}</td>
                                                    <td>${item.phoneNumber}</td>
                                                    <td>${item.houselocation}</td>
                                                    <td>Room Number: ${item.roomNumber} <br/> Room Type: ${item.roomType}</td>
                                                    <td>${item.tenantStatus}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" flex-fill id="btn-view" data-roomID="${item.tenantID}">View</button>
                                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-edit" data-roomID="${item.tenantID}">Edit</button>
                                                        <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" flex-fill id="btn-delete" data-roomID="${item.tenantID}">Inactive</button>
                                                    </td>
                                                </tr>`;
                                            $self.$tbody.append(row);
                                        });
                                    } else {
                                        // Append message if no tenants are found
                                        $self.$tbody.append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                                    }
                                },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error: ' + status + ' ' + error);
                                $self.$tbody.append('<tr><td colspan="6">An error occurred while fetching tenants.</td></tr>');
                            }
                        });
                    }
                } else {
                    // When search input is empty, check the data-status attribute
                    const action = $self.$inpt_searchName.attr('data-status');
                    if (action === "inactive") {
                        this.inactiveTenant(); // Fetch inactive tenants
                    } else if (action === "active") {
                        this.displayData(); // Fetch active tenants
                    }
                }
        },
        btnActiveTenant: function(event) {
            const $self = this.config;
            const $row = $(event.currentTarget).closest('tr');
            const tenantID = $row.data('tenantid'); 
            const roomID = $row.data('roomid');
            const tenantStatus = 'active';  

         

            if (tenantID && roomID) {
                if (confirm("Are you sure you want to activate this tenant")) {
                    $.ajax({
                        url: '../controller/tenantController.php',
                        type: 'PUT',
                        contentType: 'application/json',  // Set content type to JSON
                        data: JSON.stringify({
                            active: true,                  // Send active status as true
                            tenantID: tenantID,            // Send tenant ID
                            roomID: roomID,                // Send room ID
                            tenantStatus: tenantStatus     // Send tenant status as "active"
                        }),
                        success: function(response) {
                            console.log("Response:", response); // Log the response for debugging
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                alert(result.message);
                                $row.remove();  // Remove the row if the tenant is successfully set to active
                            } else {
                                alert(result.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error:", error);
                            alert("An error occurred: " + error);
                        }
                    });
                }
            } else {
                alert("Invalid tenant ID or room ID.");
            }
        }




    }
    tenantPage.Init({
        $btn_add                    : $('#btn-add'),
        $btn_nextStep               : $('#btn-nextStep'),
        $btn_step2_next             : $('#btn-step2-next'),
        $btn_step2_previous         : $('#btn-step2-previous'),
        $btn_submit                 : $('#btn-submit'),
        $btn_step3_previous         : $('#btn-step3-previous'),
        $modal_1                    : $('#modal-1'),
        $modal_2                    : $('#modal-2'),
        $modal_3                    : $('#modal-3'),
        $modalView                  : $('#modalView'),
        $inpt_name                  : $('#inpt-name'),
        $inpt_gender                : $('#inpt-gender'),
        $inpt_number                : $('#inpt-number'),
        $inpt_email                 : $('#inpt-email'),
        $inpt_address               : $('#inpt-address'),
        $inpt_fatherName            : $('#inpt-fatherName'),
        $inpt_fatherNumber          : $('#inpt-fatherNumber'),
        $inpt_motherName            : $('#inpt-motherName'),
        $inpt_motherNumber          : $('#inpt-motherNumber'),
        $inpt_emergencyName         : $('#inpt-emergencyName'),
        $inpt_emergencyNumber       : $('#inpt-emergencyNumber'),
        $sel_houseLocation          : $('#sel-houseLocation'),
        $sel_roomNumber             : $('#sel-roomNumber'),
        $inpt_dateStarted           : $('#inpt-dateStarted'),
        $inpt_username              : $('#inpt-username'),
        $inpt_password              : $('#inpt-password'),
        $inpt_searchName            : $('#inpt-searchName'),
        $tbody                      : $('#tbody'),
        $btn_view                   : $('#btn-view'),
        $btn_delete                 : $('#btn-delete'),
        $btn_generatePass           : $('#generatePass'),
        $btn_inactiveTenant         : $('#btn-inactiveTenant'),
        $btn_close                  : $('.btn-close'),
        $lbl_password               : $('#lbl-password'),
        $content_btn                : $('#content-btn')
    });
});

</script>
</body>
</html>
