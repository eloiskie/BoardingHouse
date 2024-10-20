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
                    <a type="button" class="sidebar-link" href="house.php">
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
        <div class="modal" id="modal" action="new" tabindex="-1" data-availableStatus="">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white">Add Room</h5>
                    <button type="button" id="btn-closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <form id="roomForm" method="post">
            <div class="form-content p-4">
                <div class="mb-3">
                    <label for="input-roomNumber" class="form-label" style="font-size: 14px">Room Number</label>
                    <input type="text" name="input-roomNumber" class="form-control" id="input-roomNumber" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-3">
                    <label for="input-roomType" class="form-label" style="font-size: 14px">Room Type</label>
                    <input type="text" name="input-roomType" class="form-control text-capitalize" id="input-roomType" style="font-size: 15px; height: 30px"> 
                </div>
                <div class="mb-3">
                    <label for="input-capacity" class="form-label" style="font-size: 14px">Capacity</label>
                    <input type="number" name="input-capacity" class="form-control" id="input-capacity" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-3">
                    <label for="input-roomFee" class="form-label" style="font-size: 14px">Room Fee</label>
                    <input type="number" name="input-roomFee" class="form-control" id="input-roomFee" style="font-size: 15px; height: 30px">
                </div>
                <div class="mb-3" id="input-houseName">
                    <label for="input-houseLocation" class="form-label text-capitalize" style="font-size: 14px">House Location</label>
                </div>
            </div>
            </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- close modal -->
    <main class="content px-4 py-4">
    <div class="container-fluid bg-white">
            <div class="room-content p-2">
                <div class="row">
                    <div class="d-md-flex" id="house-location-container"></div>
                        <div class="d-flex align-items-center py-2" style="height: 50px;">
                            <div class="d-flex">
                                <label for="sel-roomType" >Room Type</label>
                                <select id="sel-roomType" class="form-select" style="height: 40px">
                                    <option>Select Room Type</option>
                                </select>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-primary btn-sm p-2" type="button" id="btnAdd-Room" style="font-size: 12px;">Add Room</button>
                            </div>
                </div>
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <table class="table table-hover">
                                <thead class="table-dark    ">
                                    <tr>
                                        <th scope="col">Room Number</th>
                                        <th scope="col">Room Type</th>
                                        <th scope="col">Capacity</th>
                                        <th scope="col">Room Fee</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody" >
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
<script>
    $(document).ready(function() {
    $("#sidebar-toggle").click(function() {
        $("#sidebar").toggleClass("collapsed");
    });

    const housePage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.getHouseLocation(); // Call the function to populate the select element
            this.getHouseID();
            this.viewTable();
        },
        BindEvents: function() {
            const $this = this.config;
            $this.$btnAdd_Room.on('click', this.btnAddRoom.bind(this));
            $this.$btnSave.on('click', this.addRoom.bind(this));
            $this.$modal.on('click', '#btn-Update', this.update.bind(this));
            $this.$btn_closeModal.on('click', this.closeModal.bind(this));
            $this.$tbody.on('click', '#btn-delete', this.deleteData.bind(this));
            $this.$tbody.on('click', '#btn-edit', this.edit.bind(this));


        },
        closeModal: function() {
            const $self = this.config;
            $self.$modal.modal('hide');
            $self.$modal.attr('action', 'new');
            $self.$btnSave.text("Save ");
            $self.$btnSave.attr('id', 'btnSave');
            $("#roomForm")[0].reset();
        },
        getHouseID: function() {
            const $self = this.config;
            const houseName = localStorage.getItem("housename");
            const houseID = localStorage.getItem("houseID");

            if (houseName) {
                const input = `<input type="text" id="house-name" data-houseID="${houseID}" value="${houseName}" class="form-control text-capitalize" style="font-size: 15px; height: 30px" disabled>`;
                const label = `<h1 id="house-locationName" data-houselocationID="${houseID}" class="text-uppercase">${houseName}</h1>`;
                $self.$house_location.append(label); // Assuming $house_location is the container for the label
                $self.$input_houseName.append(input);
            } else {
                console.warn("No house name found in localStorage.");
            }
        },
        getHouseLocation: function() {
            const $self = this.config;
            $.ajax({
                url: '../controller/houseController.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                        const selectHouse = $self.$select_house;
                        selectHouse.empty();
                        selectHouse.append('<option value="">Select House</option>');
                        $.each(data, function(index, item) {
                        selectHouse.append('<option name="input-houseLocation" class="text-capitalize" value="' + item.houseID + '">' + item.houselocation + '</option>');
                        
                        });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error); // Uncomment for debugging
                }
            });
        },
        viewTable: function(){
            const $self = this.config;
            const houseID = $("#house-locationName").data('houselocationid');
    
                $.ajax({
                    url: "../controller/roomController.php",
                    type: "GET",
                    data: { houseID: houseID },
                    dataType: 'json',
                    success: function(data) {
                    if (data.length === 0) {
                        $self.$tbody.append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                    } else {
                        $.each(data, function(index, item) {
                            const row = `
                                <tr  class="text-capitalize" data-roomID="${item.roomID}" data-roomNumber="${item.roomNumber}">
                                    <td>${item.roomNumber}</td>
                                    <td>${item.roomType}</td>
                                    <td>${item.capacity}</td>
                                    <td>${item.roomFee}</td>
                                    <td>${item.houselocation}</td>
                                    <td>${item.availableStatus}</td>
                                    <td>
                                        <button type="button" style="width: 80px" class="btn btn-secondary edit-room" id="btn-edit" data-roomID="${item.roomID}">Edit</button>
                                        <button type="button" style="width: 80px" class="btn btn-secondary delete-room" id="btn-delete" data-roomID="${item.roomID}">Delete</button>
                                    </td>
                                </tr>
                                `;
                            $self.$tbody.append(row);
                        });
                    }
                },

                        error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' ' + error);
                    }
                });
            },
        btnAddRoom: function() {
            const $self = this.config;
            $self.$modal.modal('show');
        },
        addRoom: function() {
            const $self = this.config;
            const roomNumber = $self.$input_roomNumber.val();
            const roomType = $self.$input_roomType.val();
            const capacity = $self.$input_capacity.val();
            const roomFee = $self.$input_roomFee.val();
            const houseID = $('#house-name').data('houseid');
            const action = $self.$modal.attr('action');
            const availableStatus = "available";
            const roomID = $self.$modal.data('roomid'); // Retrieve the stored roomID if editing
            
   

            if ($self.$input_roomNumber.val().trim()==="" || $self.$input_roomType.val().trim() === "" || $self.$input_capacity.val().trim() === "" || $self.$input_roomFee.val().trim() === "") {
                alert("Please enter complete fields");
                return;
            } else if ($self.$input_roomFee.val() < 0 || $self.$input_capacity.val() < 0) {
                alert("Negative Numbers are not allowed");
                return;
            } else if(action === 'new'){
                $.ajax({
                    url : '../controller/roomController.php',
                    type : 'POST',
                    data : {
                        roomNumber  : roomNumber,
                        roomType   : roomType,
                        capacity    : capacity,
                        roomFee     : roomFee,
                        availableStatus : availableStatus,
                        houseID     : houseID
                    },
                    success: function(response){
                        const data = JSON.parse(response);
                        $self.$tbody.empty();
                        if (data.status === "error"){
                            alert(data.messsage);
                        }else if(data.status ==="success"){
                            alert(data.message);
                            $.each(data.data, function(index, item) {
                                const row = `
                                    <tr class="text-capitalize" data-roomID="${item.roomID}">
                                        <td>${item.roomNumber}</td>
                                        <td>${item.roomType}</td>
                                        <td>${item.capacity}</td>
                                        <td>${item.roomFee}</td>
                                        <td>${item.houselocation}</td>
                                        <td>${item.availableStatus}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary style="width: 80px" flex-fill edit-room" id="btn-edit" data-roomID="${item.roomID}">Edit</button>
                                            <button type="button" class="btn btn-secondary style="width: 80px" flex-fill delete-room" id="btn-delete" data-roomID="${item.roomID}">Delete</button>
                                        </td>
                                    </tr>`;
                                $self.$tbody.append(row);
                            });
                            $self.$modal.modal('hide');
                            $('#roomForm')[0].reset();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('An error occurred while submitting room details.');
                    }
                });

            }
            
        },
        update: function() {
            const $self = this.config;
            const roomNumber = $self.$input_roomNumber.val().trim();
            const roomType = $self.$input_roomType.val().trim();
            const capacity = parseInt($self.$input_capacity.val().trim(), 10);
            const roomFee = parseFloat($self.$input_roomFee.val().trim());
            const houseID = $('#house-name').data('houseid');
            const action = $self.$modal.attr('action');
            const availableStatus =  $self.$modal.data('availableStatus');
            const roomID = $self.$modal.data('roomid');
            if (roomNumber === "" || roomType === "" || isNaN(capacity) || isNaN(roomFee)) {
                alert("Please enter complete fields");
                return;
            } else if (roomFee < 0 || capacity < 0) {
                alert("Negative numbers are not allowed");
                return;
            } else if (action === 'edit') {
                        $.ajax({
                            url: '../controller/roomController.php',
                            type: 'PUT',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                roomID: roomID,
                                roomNumber: roomNumber,
                                roomType: roomType,
                                capacity: capacity,
                                roomFee: roomFee,
                                availableStatus: availableStatus,
                                houseID: houseID
                            }),
                            success: function(response) {
                                try {
                                    const data = JSON.parse(response);
                                    $self.$tbody.empty();
                                    if (data.status === "error") {
                                        alert(data.message);
                                    } else if (data.status === "success") {
                                        alert(data.message);
                                        $.ajax({
                                                url: "../controller/roomController.php",
                                                type: "GET",
                                                data: { houseID: houseID },
                                                dataType: 'json',
                                                success: function(data) {
                                                if (data.length === 0) {
                                                    $self.$tbody.append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                                                } else {
                                                    $.each(data, function(index, item) {
                                                        const row = `
                                                            <tr  class="text-capitalize" data-roomID="${item.roomID}" data-roomNumber="${item.roomNumber}">
                                                                <td>${item.roomNumber}</td>
                                                                <td>${item.roomType}</td>
                                                                <td>${item.capacity}</td>
                                                                <td>${item.roomFee}</td>
                                                                <td>${item.houselocation}</td>
                                                                <td>${item.availableStatus}</td>
                                                                <td>
                                                                    <button type="button" style="width: 80px" class="btn btn-secondary edit-room" id="btn-edit" data-roomID="${item.roomID}">Edit</button>
                                                                    <button type="button" style="width: 80px" class="btn btn-secondary delete-room" id="btn-delete" data-roomID="${item.roomID}">Delete</button>
                                                                </td>
                                                            </tr>
                                                            `;
                                                        $self.$tbody.append(row);
                                                    });
                                                    $self.$modal.modal('hide');
                                                    $('#roomForm')[0].reset();
                                                    $self.$btnSave.attr('id', 'btnSave');
                                                    $self.$btnSave.text("Save ");
                                                }
                                            },

                                            error: function(xhr, status, error) {
                                            console.error('AJAX Error: ' + status + ' ' + error);
                                            }
                                            });
                            }
                            } catch (e) {
                                alert('Failed to parse response: ' + e.message);
                            }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('An error occurred while submitting room details.');
                    }
                });
            }
        },
        deleteData: function(event){
            const $self = this.config;
            const roomID = $(event.currentTarget).data('roomid'); 
            var row = $(event.currentTarget).closest('tr');
            $.ajax({
                url     : '../controller/roomController.php',
                type    : 'DELETE',
                data    : {roomID : roomID},
                success : function(response){
                    var result = JSON.parse(response);
                    if(result.status === 'success') {
                            alert(result.message);
                            row.remove();
                        } else {
                            alert(result.message);
                        }
                },
                error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });
        },
        edit: function(event) {
            const $self = this.config;
            const $row = $(event.currentTarget).closest('tr');
            const roomID = $row.data('roomid');
            const roomNumber = $row.find('td').eq(0).text();
            const roomType = $row.find('td').eq(1).text();
            const capacity = $row.find('td').eq(2).text();
            const roomFee = $row.find('td').eq(3).text();
            const availableStatus = $row.find('td').eq(5).text();

            // Set the modal form inputs
                $self.$input_roomNumber.val(roomNumber);
                $self.$input_roomType.val(roomType);
                $self.$input_capacity.val(capacity);
                $self.$input_roomFee.val(roomFee);

            // Set a hidden input or variable for action
            $self.$modal.attr('action', 'edit');
            $self.$btnSave.text("Save Update");
            $self.$btnSave.attr('id', 'btn-Update');
            $self.$modal.data('roomid', roomID); // Store roomID for later use
            $self.$modal.data('availableStatus', availableStatus);

            // Show the modal
            $self.$modal.modal('show');
        }
    }

    housePage.Init({
        $btnAdd_Room                : $("#btnAdd-Room"),
        $btnSave                    : $("#btnSave"),
        $btn_viewRoom               : $("#btn-viewRoom"),
        $btn_closeModal             : $("#btn-closeModal"),
        $btn_edit                   : $("#btn-edit"),
        $btn_delete                 : $("#btn-delete"),
        $modal                      : $("#modal"),
        $input_houseLocation        : $("#input-houseLocation"),
        $input_roomNumber           : $("#input-roomNumber"),
        $input_roomType             : $("#input-roomType"),
        $input_capacity             : $("#input-capacity"),
        $input_roomFee              : $("#input-roomFee"),
        $input_houseName            : $("#input-houseName"),
        $select_house               : $("#select-house"),
        $house_name                 : $("#house-name"),
        $house_location             : $("#house-location-container"),
        $tbody                      : $("#tbody"),
        $btn_Update                 : $("#btn-Update")        
    });
});


</script>
</body>
</html>

