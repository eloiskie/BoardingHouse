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
                    <a class="sidebar-link" href="index.php">
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
                <h2>Maintenance Request</h2>
            
            <p id='lbl-tenantName' class="text-capitalize"></p>
            <p id='lbl-houselocation' class="text-capitalize"><strong>House Location:</strong></p>
            <p id='lbl-houseRented' class="text-capitalize"><strong>House Address and Room Rented:</strong></p>
            

            <form action="submit_form.php" method="post">
            <fieldset class="border p-4">
            <legend class="w-auto px-2"><strong>Maintenance Issue Details</strong></legend>

            <div class="form-group">
                <label for="issue_type">Type of Issue:</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="issue_type" id="rb-plumbing" value="Plumbing" onclick="toggleSpecifyInput()">
                        <label class="form-check-label" for="plumbing">Plumbing</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="issue_type" id="rb-electric" value="Electric" onclick="toggleSpecifyInput()">
                        <label class="form-check-label" for="electric">Electric</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="issue_type" id="rb-structural" value="Structural" onclick="toggleSpecifyInput()">
                        <label class="form-check-label" for="structural">Structural</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="issue_type" id="rb-others" value="Others" onclick="toggleSpecifyInput()">
                        <label class="form-check-label" for="others">Others (specify):</label>
                        <input type="text" class="form-control mt-2" id="inpt-specifyRequest" name="other_specify" placeholder="Please specify..." disabled>
                    </div>
            </div>
            <div class="form-group">
                <label for="description">Description of the Issue:</label>
                <textarea class="form-control" placeholder="Leave a description here" id="txt-description"  rows="3" style="height: 100px" maxlength="255" ></textarea>
                <div class="text-end">
                    <small id="lbl-charCount" class="form-text text-muted">0/200 characters</small>
                </div>
            </div>

            <div class="form-group">
                <label for="priority_level">Priority Level:</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="priority_level" id="low" value="Low">
                    <label class="form-check-label" for="low">Low</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="priority_level" id="medium" value="Medium">
                    <label class="form-check-label" for="medium">Medium</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="priority_level" id="high" value="High">
                    <label class="form-check-label" for="high">High</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="btn-submitRequest">Submit</button>
        </fieldset>
    </form>
                </div>
            </div>
        </div>
    </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function toggleSpecifyInput() {
            const othersRadio = document.getElementById('rb-others');
            const otherSpecify = document.getElementById('inpt-specifyRequest');

            if (othersRadio.checked) {
                otherSpecify.disabled = false;
                otherSpecify.focus();
            } else {
                otherSpecify.disabled = true;
                otherSpecify.value = ''; // Clear the input when disabled
            }
        }

    $(document).ready(function() {
    $("#sidebar-toggle").click(function() {
        $("#sidebar").toggleClass("collapsed");
    });

    const maintenancerequestPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.getTenantID();
            this.displayInformation();
            this.characterCount();
        },
        BindEvents: function() {
            const $this = this.config;
                $this.$btn_submitRequest.on('click', this.sendRequest.bind(this));
        },
        characterCount: function() {
            const $self = this.config;
            const textarea = $self.$txt_description;
            const charCount = $self.$lbl_charCount;

            // Bind the input event to update the character count
            textarea.on('input', function() {
                const currentLength = textarea.val().length;
                charCount.text(`${currentLength}/255 characters`);
            });

            // Initialize the count on page load in case there’s pre-filled text
            const initialLength = textarea.val().length;
            charCount.text(`${initialLength}/255 characters`);
        },

        getTenantID: function() {
            const $self = this.config;
            
            const tenantID = localStorage.getItem("tenantID");

            if (tenantID) {
                $self.$lbl_tenantName.attr('data-tenantid', tenantID);
            } else {
                console.warn("No tenantID found in localStorage.");
            }
        },
        displayInformation: function(){
            const $self = this.config;
            const tenantID = $self.$lbl_tenantName.data('tenantid');
            $.ajax({
                url: '../controller/reqMaintenanceController.php',
                type: "GET",
                data: {
                    tenantID: tenantID // Make sure this matches the PHP parameter name
                },
                dataType: 'json',
                success: function(data){
                    if (data.length > 0) {
                        const item = data[0]; 
                        const tenantName = `<strong>Tenant:</strong> ${item.tenantName}`;
                        const houselocation = `<strong>House Location:</strong> ${item.houselocation}`;
                        const houseRented = `<strong>House Address and Room Rented:</strong> ${item.houseAddress} - ${item.roomNumber}`;
                        $self.$lbl_tenantName.append(tenantName);
                        $self.$lbl_houseRented.append(houseRented);
                        $self.$lbl_houselocation.append(houselocation);
                    } else {
                        console.warn("No data found for tenantID:", tenantID);
                    }
                },
                error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                       
                    }
            });
        },
        sendRequest: function(event){
            const $self = this.config;
            event.preventDefault();
            const tenantID = $self.$lbl_tenantName.data('tenantid');
            let maintenanceType = $('input[name="issue_type"]:checked').val();

            // If "Others" is selected, get the value from the additional text input
            if (maintenanceType === 'Others') {
                const specifyRequest = $('#inpt-specifyRequest').val();
                maintenanceType = specifyRequest; // Use the specified value or default to 'Others'
            }
            const description = $self.$txt_description.val();
            const priorityLevel = $('input[name="priority_level"]:checked').val();

            // Perform an AJAX POST request
            $.ajax({
                url: '../controller/reqMaintenanceController.php',
                type: "POST",
                data: {
                    tenantID: tenantID,
                    maintenanceType: maintenanceType,
                    description: description,
                    status: 'Pending', // Default status
                    priorityLevel: priorityLevel
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message)

                         // Clear the form fields
                            $('input[name="issue_type"]').prop('checked', false); // Uncheck radio buttons
                            $('#inpt-specifyRequest').val('').prop('disabled', true); // Clear and disable "Others" input
                            $self.$txt_description.val(''); // Clear the textarea
                            $('input[name="priority_level"]').prop('checked', false); // Uncheck priority level
                            $('#lbl-charCount').text('0/255 characters'); // Reset character count display
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                    alert("An error occurred while submitting your request. Please try again.");
                }
            });
        },
    }

    maintenancerequestPage.Init({
        $lbl_tenantName             : $('#lbl-tenantName'),
        $lbl_houselocation          : $('#lbl-houselocation'),
        $lbl_houseRented            : $('#lbl-houseRented'),
        $lbl_charCount              : $('#lbl-charCount'),
        $btn_submitRequest          : $('#btn-submitRequest'),
        $txt_description            : $('#txt-description'),
    });
});

    </script>
</body>
</html> 