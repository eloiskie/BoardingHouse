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
                    <a class="sidebar-link" href="house.php" id="btnMenu-house">
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
                            <a href="amenities.php" class="sidebar-link">Amenities</a>
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
    <!-- start modal -->
    <div class="modal" id="modal" tabindex="-1" action="new" data-amenitiesid="">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white">Add Amenities</h5>
                    <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <form id="amenitiesForm" method="post">
            <div class="form-content p-4">
                <div class="mb-3">
                    <label for="houseLocation" class="form-label" style="font-size: 14px">House Location</label>
                    <select id="sel-houseLocation" class="form-select" style="font-size: 15px; height: 40px">
                                    <option>Select House</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="houseLocation" class="form-label" style="font-size: 14px">Room Number</label>
                    <select id="sel-roomNumber" class="form-select" style="font-size: 15px; height: 40px">
                                    <option>Select Room Number</option>
                    </select>
                </div>
                <div class="mb-3" id="input-tenantName">
                    <label for="input-tenantName" class="form-label">Name</label>
                    <select id="sel-tenantName" class="form-select" style="font-size: 15px; height: 40px">
                                    <option>Select Name</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="input-waterBill" class="form-label">Water Bill</label>
                    <input type="number" name="input-waterBill" class="form-control" id="input-waterBill">
                </div>
                <div class="mb-3">
                    <label for="input-electricBill" class="form-label">Electric Bill</label>
                    <input type="number" name="input-electricBill" class="form-control" id="input-electricBill">
                </div>
                <div class="mb-3" id="monthReading">
                    <label for="sel-monthReading" class="form-label">Month Reading</label>
                    <select id="sel-monthReading" class="form-select" style="font-size: 15px; height: 40px">
                                    <option>January</option>
                                    <option>Febuary</option>
                                    <option>March</option>
                                    <option>April</option>
                                    <option>May</option>
                                    <option>June</option>
                                    <option>July</option>
                                    <option>August</option>
                                    <option>September</option>
                                    <option>October</option>
                                    <option>November</option>
                                    <option>December</option>
                    </select>
                </div>
            </div>
            </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-submit">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
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
                            <a href="#"  class="dropdown-item" data-houseID="he">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
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
                                <button class="btn btn-primary btn-sm p-2" type="button" id="btn-add" style="font-size: 12px;">Add Amenities</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="table-wrapper">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr style="font-size: 15px">
                                            <th scope="col">Name</th>
                                            <th scope="col">Water Bill</th>
                                            <th scope="col">Electric Bill</th>
                                            <th scope="col">Month Reading</th>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   $(document).ready(function() {
    $("#sidebar-toggle").click(function() {
        $("#sidebar").toggleClass("collapsed");
    });

    const housePage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.getHouseLocation();
            this.viewData();
        },
        BindEvents: function() {
            const $this = this.config;
            $this.$btn_add.on('click', this.modalShow.bind(this));
            $this.$sel_houseLocation.on('change', this.getRoom.bind(this));
            $this.$sel_roomNumber.on('change', this.getTenantName.bind(this));
            $this.$btn_submit.on('click', this.addAmenities.bind(this));
            $this.$tbody.on('click', '#btn-edit', this.editButton.bind(this));
        },
        getHouseLocation: function() {
            const $self = this.config;
            $.ajax({
                url: '../controller/tenantController.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                   $self.$sel_houseLocation.empty();
                    $self.$sel_houseLocation.append('<option value="" style="font-size: 15px;">Select House</option>');

                    $.each(response.data, function(index, item) {
                        $self.$sel_houseLocation.append('<option value="' + item.houseID + '">' + item.houselocation + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        },
        getTenantName: function() {
            const $self = this.config;
            const roomID = $self.$sel_roomNumber.val();
        
            if (!roomID) {
                $self.$sel_tenantName.empty().append('<option value="" style="font-size: 15px;">Select Tenant</option>');
                return;
            }
            $.ajax({
                url: '../controller/amenitiesController.php',
                type: 'POST',
                data: { roomID: roomID },
                dataType: 'json',
                success: function(response) {
                    const selectTenant = $self.$sel_tenantName;
                    selectTenant.empty();
                    selectTenant.append('<option value="" style="font-size: 15px;">Select Tenant</option>');

                    if (response.status === 'success') {
                        $.each(response.data, function(index, item) {
                            selectTenant.append('<option value="' + item.tenantID + '">' + item.tenantName + '</option>');
                        });
                    } else {
                        console.error('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        },
        getRoom: function() {
            const $self = this.config;
            const houseID = $self.$sel_houseLocation.val();
            if (!houseID) {
                $self.$sel_roomNumber.empty().append('<option value="" style="font-size: 15px;">Select Room</option>');
                return;
            }
            $.ajax({
                url: '../controller/tenantController.php',
                type: 'POST',
                data: { houseID: houseID },
                dataType: 'json',
                success: function(response) {
                    const selectRoom = $self.$sel_roomNumber;
                    selectRoom.empty();
                    selectRoom.append('<option value="" style="font-size: 15px;">Select Room</option>');

                    $.each(response.data, function(index, item) {
                        selectRoom.append('<option value="' + item.roomID + '">' + item.roomNumber + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        },
        viewData: function(){
            const $self = this.config;
            $.ajax({
                url: '../controller/amenitiesController.php',
                type: 'GET',
                data: { amenities: true },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $self.$tbody.empty(); 
                        if (response.data.length > 0) { 
                            $.each(response.data, function(index, item) {
                                const row = `
                                    <tr class="text-capitalize" data-amenitiesid="${item.amenitiesID}">
                                        <td>${item.tenantName}</td>
                                        <td>${item.electricBill}</td>
                                        <td>${item.waterBill}</td>
                                        <td>${item.monthReading}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary style="width: 80px" flex-fill edit-room" id="btn-edit" data-amenitiesID="${item.amenitiesID}">Edit</button>
                                            <button type="button" class="btn btn-secondary style="width: 80px" flex-fill delete-room" id="btn-delete" data-amenitiesID="${item.amenitiesID}">Delete</button>
                                        </td>
                                    </tr>`;
                                $self.$tbody.append(row);
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
        modalShow: function(){
            const $self = this.config;
            $self.$modal.modal('show');
        },
        addAmenities: function() {
            const $self = this.config;

            const houseLocation   = $self.$sel_houseLocation.val().trim();
            const roomNumber      = $self.$sel_roomNumber.val().trim();
            const tenantID        = $self.$sel_tenantName.val().trim();
            const electricBill    = parseFloat($self.$inpt_electricBill.val()) || 0;
            const waterBill       = parseFloat($self.$inpt_waterBill.val()) || 0;
            const monthReading    = $self.$sel_monthReading.val();
            const action = $self.$modal.attr('action');

            if(action === 'new') {
                $.ajax({
                    url: '../controller/amenitiesController.php',
                    type: 'POST',
                    data: {
                        tenantID: tenantID,
                        electricBill: electricBill,
                        waterBill: waterBill,
                        monthReading: monthReading
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === "error") {
                            alert(response.message);
                        } else if (response.status === "success") {
                            alert(response.message);
                            $.each(response.data, function(index, item) {
                                const row = `
                                    <tr class="text-capitalize" data-amenitiesid="${item.amenitiesID}>
                                        <td>${item.tenantName}</td>
                                        <td>${item.electricBill}</td>
                                        <td>${item.waterBill}</td>
                                        <td>${item.monthReading}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary style="width: 80px" flex-fill edit-room" id="btn-edit" data-roomID="${item.roomID}">Edit</button>
                                            <button type="button" class="btn btn-secondary style="width: 80px" flex-fill delete-room" id="btn-delete" data-roomID="${item.roomID}">Delete</button>
                                        </td>
                                    </tr>`;
                                $self.$tbody.append(row);
                            });
                            $self.$modal.modal('hide');
                            $('#amenitiesForm')[0].reset();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('An error occurred while submitting amenities details: ' + errorThrown);
                    }
                });
            }
        },
        editButton: function(event){
            const $self = this.config;
            const $row = $(event.currentTarget).closest('tr');
            const amenitiesID = $row.data('amenitiesid');
            const tenantName = $row.find('td').eq(0).text();
            const waterBill = $row.find('td').eq(1).text();
            const electricBill = $row.find('td').eq(2).text();
            const monthReading = $row.find('td').eq(3).text();

            $self.$modal.attr('action', 'edit');
            $self.$btn_submit.text("Save Update");
            $self.$modal_3.attr('data-amenitiesid', amenities);

            $.ajax({
                url: '../controller/amenitiesController.php',
                type: 'GET',
                data: { tenantID: tenantID },
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $.each(response.data, function(index, item) {
                            // Ensure that room options are loaded before setting the value
                            $self.$sel_houseLocation.val(item.houseID).trigger('change'); // Trigger change to update room options

                            // Use a short delay to give time for room options to be populated
                            setTimeout(function() {
                                $self.$sel_roomNumber.val(item.roomID); // Set the roomID value

                            }, 10); // Adjust the delay if needed

                            $self.$inpt_name.val(item.tenantName);
                            $self.$inpt_birthday.val(item.birthdate);
                            $self.$inpt_gender.val(item.gender);
                            $self.$inpt_number.val(item.phoneNumber);
                            $self.$inpt_email.val(item.emailAddress);
                            $self.$inpt_address.val(item.currentAddress);
                            $self.$inpt_fatherName.val(item.fatherName);
                            $self.$inpt_fatherNumber.val(item.fatherNumber);
                            $self.$inpt_motherName.val(item.motherName);
                            $self.$inpt_motherNumber.val(item.motherNumber);
                            $self.$inpt_emergencyName.val(item.emergencyName);
                            $self.$inpt_emergencyNumber.val(item.emergencyNumber);
                            $self.$inpt_dateStarted.val(item.dateStarted);
                            $self.$inpt_username.val(item.username);
                            $self.$inpt_password.val(item.password);

                            const roomID = item.roomID;
                            $self.$modal_3.attr('data-roomID', roomID);

                            // Show the edit modal
                            $self.$modal_1.modal('show');
                        });
                    }   
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
            

        }
    }
    housePage.Init({
        $sel_houseLocation          : $('#sel-houseLocation'),
        $sel_roomNumber             : $('#sel-roomNumber'),
        $sel_tenantName             : $('#sel-tenantName'),
        $sel_monthReading           : $('#sel-monthReading'),
        $inpt_waterBill             : $('#input-waterBill'),
        $inpt_electricBill          : $('#input-electricBill'),
        $btn_add                    : $('#btn-add'),
        $modal                      : $('#modal'),
        $btn_submit                 : $('#btn-submit'),
        $tbody                      : $('#tbody')
    });
});
</script>
</body>
</html>
