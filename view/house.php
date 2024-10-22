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
<body >
<div class="wrapper" style="background-color: white;">
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
    <!-- start modal -->
    <div class="modal" id="modal" tabindex="-1" data-houseid="">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white" id="lbl-modalName">Add House</h5>
                    <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <form id="houseForm" method="post">
            <div class="form-content p-4">
                <div class="mb-3">
                    <label for="inputHouse-location" class="form-label">Location</label>
                    <input type="text" name="inputHouse-location" class="form-control text-capitalize" id="inputHouse-location" >
                </div>
                <div class="mb-3">
                    <label for="inputHouse-address" class="form-label">Address</label>
                    <input type="text" name="inputHouse-address" class="form-control text-capitalize" id="inputHouse-address">
                </div>
                <div class="mb-3">
                    <label for="inputNumberOf-rooms" class="form-label">Number of Room</label>
                    <input type="number" name="inputNumberOf-rooms" class="form-control" id="inputNumberOf-rooms">
                </div>
            </div>
            </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSave">Save</button>
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
        <main class="content px-2 py-2 h-100">
        <div class="container-fluid">
                    <div class="row" id="houseCardsContainer">
                        
                    </div>
                </div>
        </main>
        <div class="p-4 align-self-end">
            <div class="p-0 m-7">
                <button type="button" id="add-house"  class="btn btn-dark">
                    <i class="bi bi-plus-circle" style="font-size: 25px"></i>
                </button>
            </div>
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
            this.displayHouse();
        },
        BindEvents: function() {
             const $this = this.config;

            $this.$btn_addHouse.on('click', this.addHouseBtn.bind(this));
            $this.$btnSave.on('click', function(e) {
                e.preventDefault();  

                const action = $this.$modal.attr('action'); 
                if (action === "new") {
                    housePage.addHouse.call(housePage, e);  
                } else if (action === "edit") {
                    housePage.updateHouse.call(housePage, e);  
                }
            });
            $this.$btn_close.on('click', this.closeModal.bind(this));
            $this.$btnMenu_house.on('click', this.displayHouse.bind(this));
            $this.$houseCards.on('click', '#btn-viewData', this.passHouseID.bind(this));
            $this.$houseCards.on('click', '#btn-deleteCards', this.deleteHouse.bind(this));
            $this.$houseCards.on('click', '#btn-editCards', this.btnEdit.bind(this));
        },
        passHouseID: function(e) {
            e.preventDefault();
            var houseName = $(e.currentTarget).data('housename'); // Correct
            var houseID = $(e.currentTarget).data('houseid');     // Corrected to camelCase
        
            localStorage.setItem("housename", houseName);
            localStorage.setItem("houseID", houseID);
            window.location.href = "room.php";

        },
        displayHouse: function() {
            const $self = this.config;
                $.ajax({
                    url     : "../controller/houseController.php",
                    type    : "GET",
                    dataType  :'json',
                    success: function(data){
                        const container = $self.$houseCards;
                            container.empty();
                            $.each(data, function(index, item){
                                const newCard = `<div class="col-12 col-md-4 d-flex p-3" action="room.php" id="houseCards" data-cardID="${item.houseID}">
                                                    <div class="card flex-fill border-0 illustration" style="background: linear-gradient(to right, #FDFEFE, #3F8FA7);">
                                                        <div class="card-body p-0 d-flex flex-fill">
                                                            <div class="card-content w-100">
                                                                <div class="d-flex justify-content-end p-2">
                                                                    <a style="font-size: 18px;" id="btn-editCards" data-houseID="${item.houseID}"><i class="bi bi-pencil-fill"></i></a>
                                                                    <button type="button" id="btn-deleteCards" class="btn-close" data-houseID="${item.houseID}" aria-label="Close"></button>
                                                                </div>
                                                                <div class="p-2 m-1">
                                                                    <i class="bi bi-houses" style="font-size:50px"></i>
                                                                    <label for="text" style="font-size: 30px" class="lbl-location text-capitalize" data-housLocation="${item.houselocation}" id="lbl-houselocationCards">${item.houselocation}</label>
                                                                    <div class="m-1">
                                                                        <label for="text" class="house-address text-capitalize" style="font-size:15px" data-houseAddress="${item.houseAddress}" id="lbl-houseAddressCards">House Address: ${item.houseAddress}</label><br/>
                                                                        <label for="text" class="room-number text-capitalize" style="font-size:12px"data-roomNumber="${item.numberOfRoom}" id="lbl-numberOfRoomCards">Number of rooms: ${item.numberOfRoom}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer d-flex justify-content-end">
                                                            <a href="#" id="btn-viewData" class="nav-link view-house text-capitalize" data-houseName="${item.houselocation}" data-houseID="${item.houseID}">View</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            `;
                                    container.append(newCard);
                                    });
                    }
                });
         return false; 
        },
        closeModal: function() {
            const $self = this.config;
            $self.$modal.modal('hide');
            $("#houseForm")[0].reset(); // Reset the form fields
            $self.$modal.attr('data-houseid', ''); // Reset houseID
            $self.$modal.attr('action', ''); // Reset action
        },
        addHouseBtn: function() {
            const $self = this.config;
            $self.$modal.attr('action', 'new');
            $self.$lbl_modalName.text('Add House');
            $self.$btnSave.text("Save");
            $self.$btnSave.attr('id', 'btnSave');
            $('#houseForm')[0].reset(); 
            $self.$modal.modal('show');
        },
        addHouse: function(e) {
            e.preventDefault();
            const $self = this.config;
            const action = $self.$modal.attr('action');
            let hasError = false;

            // Clear previous Bootstrap validation classes
            $self.$inpt_location.removeClass('is-invalid');
            $self.$inpt_address.removeClass('is-invalid');
            $self.$inpt_rooms.removeClass('is-invalid');
            if(action == "new");
           {     // Check for empty fields and apply the Bootstrap 'is-invalid' class
                if ($self.$inpt_location.val().trim() === "") {
                    $self.$inpt_location.addClass('is-invalid');
                    hasError = true;
                }
                if ($self.$inpt_address.val().trim() === "") {
                    $self.$inpt_address.addClass('is-invalid');
                    hasError = true;
                }
                if ($self.$inpt_rooms.val().trim() === "" || $self.$inpt_rooms.val() < 0) {
                    $self.$inpt_rooms.addClass('is-invalid');
                    hasError = true;
                }

                // If there's an error, stop submission and show alert
                if (hasError) {
                    alert("Please fill in all required fields correctly.");
                    return;
                }

                // Continue with the AJAX request if no errors
                else {
                    $.ajax({
                        url: "../controller/houseController.php",
                        type: "post",
                        data: $("#houseForm").serialize(),
                        success: function(response) {
                            const data = JSON.parse(response);
                            if (data.status === "error") {
                                alert(data.message);
                            } else if (data.status === "success") {
                                alert(data.message);
                                const container = $self.$houseCards;

                                // Iterate over each item in the data array
                                $.each(data.data, function(index, item) {
                                    const newCard = `<div class="col-12 col-md-4 d-flex p-3" action="room.php" id="houseCards" data-cardID="${item.houseID}">
                                                        <div class="card flex-fill border-0 illustration" style="background: linear-gradient(to right, #FDFEFE, #3F8FA7);">
                                                            <div class="card-body p-0 d-flex flex-fill">
                                                                <div class="card-content w-100">
                                                                    <div class="d-flex justify-content-end p-2">
                                                                        <a style="font-size: 18px;" id="btn-editCards" data-houseID="${item.houseID}"><i class="bi bi-pencil-fill"></i></a>
                                                                        <button type="button" id="btn-deleteCards" class="btn-close" data-houseID="${item.houseID}" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="p-2 m-1">
                                                                        <i class="bi bi-houses" style="font-size:50px"></i>
                                                                        <label for="text" style="font-size: 30px" class="lbl-location text-capitalize" data-housLocation="${item.houselocation}" id="lbl-houselocationCards">${item.houselocation}</label>
                                                                        <div class="m-1">
                                                                            <label for="text" class="house-address text-capitalize" style="font-size:15px" data-houseAddress="${item.houseAddress}" id="lbl-houseAddressCards">House Address: ${item.houseAddress}</label><br/>
                                                                            <label for="text" class="room-number text-capitalize" style="font-size:12px" data-roomNumber="${item.numberOfRoom}" id="lbl-numberOfRoomCards">Number of rooms: ${item.numberOfRoom}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer d-flex justify-content-end">
                                                                <a href="#" id="btn-viewData" class="nav-link view-house text-capitalize" data-houseName="${item.houselocation}" data-houseID="${item.houseID}">View</a>
                                                            </div>
                                                        </div>
                                                    </div>`;
                                    container.append(newCard);
                                });

                                $('#houseForm')[0].reset(); // Reset the form fields
                                $self.$modal.modal('hide');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred while processing your request.");
                        }
                    });
                }
            }
        },
        deleteHouse: function(e){
            e.preventDefault();
            const $self = this.config;
            const houseID = $(e.currentTarget).data('houseid');

            if(confirm('Are you sure you want to delete this house?'))
            { 
                    $.ajax({
                        url: '../controller/houseController.php',
                        type: 'DELETE',
                        data: {houseID : houseID},
                        dataType: 'json', 
                        success: function(response){ // Corrected 'succes' to 'success'
                    if(response.status === 'success'){
                        alert(response.message);
                        $(e.currentTarget).closest('.col-12').remove();
                    }else{
                        alert(response.message);
                    }
                },
                        error: function(xhr, status, error) {
                                alert("An error occurred: " + error);
                            }

                    })
                }
        },
        btnEdit: function(e) {
            e.preventDefault();
            const $self = this.config;
            const houseCard = $(e.currentTarget).closest('.card');  
            const houseID = $(e.currentTarget).data('houseid');
        
            // Extracting data attributes from the houseCard
            const houseLocation = houseCard.find('.lbl-location').data('houslocation');
            const houseAddress = houseCard.find('.house-address').data('houseaddress');
            const roomNumber = houseCard.find('.room-number').data('roomnumber');
        
            // Clear previous data
            $self.$modal.removeAttr('data-houseid'); // Remove any previous houseID
            $self.$modal.removeAttr('action');       // Remove previous action

            // Setting values in the modal
            $self.$inpt_location.val(houseLocation);
            $self.$inpt_address.val(houseAddress);
            $self.$inpt_rooms.val(roomNumber);

            // Setting modal attributes
            $self.$modal.attr('action', 'edit');
            $self.$modal.attr('data-houseid', houseID);  // Set the new houseID

            $self.$lbl_modalName.text('Edit House');
            $self.$btnSave.text("Save Update");
            $self.$btnSave.attr('id', 'btn-update');

            // Show the modal
            $self.$modal.modal('show');
        },
        updateHouse: function() {
            const $self = this.config;

            const action = $self.$modal.attr('action');
            const houseID = $self.$modal.attr('data-houseid');
            const houselocation = $self.$inpt_location.val().trim();
            const houseAddress = $self.$inpt_address.val().trim();
            const numberOfRoom = parseInt($self.$inpt_rooms.val().trim(), 10);
            
            let hasError = false;

            // Clear previous Bootstrap validation classes
            $self.$inpt_location.removeClass('is-invalid');
            $self.$inpt_address.removeClass('is-invalid');
            $self.$inpt_rooms.removeClass('is-invalid');
            if(action == "edit")
            { // Validation and applying Bootstrap 'is-invalid' class for highlighting
            if (houselocation === "") {
                $self.$inpt_location.addClass('is-invalid');
                hasError = true;
            }
            if (houseAddress === "") {
                $self.$inpt_address.addClass('is-invalid');
                hasError = true;
            }
            if (isNaN(numberOfRoom) || numberOfRoom < 0) {
                $self.$inpt_rooms.addClass('is-invalid');
                hasError = true;
            }

            // If validation fails, show an alert and stop the form submission
            if (hasError) {
                alert("Please fill in all the fields correctly.");
                return;
            }
            else{
                $.ajax({
                    url: "../controller/houseController.php",
                    type: "PUT",
                    data: JSON.stringify({
                        houseID: houseID,
                        houselocation: houselocation,
                        houseAddress: houseAddress,
                        numberOfRoom: numberOfRoom
                    }),
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.status === "success") {
                            alert(data.message);
                            $.ajax({
                                url: "../controller/houseController.php",
                                type: "GET",
                                dataType: 'json',
                                success: function(data) {
                                    const container = $self.$houseCards;
                                    container.empty();

                                    // Iterate over each house and update the UI
                                    $.each(data, function(index, item) {
                                        const newCard = `
                                            <div class="col-12 col-md-4 d-flex p-3" action="room.php" id="houseCards" data-cardID="${item.houseID}">
                                                <div class="card flex-fill border-0 illustration" style="background: linear-gradient(to right, #FDFEFE, #3F8FA7);">
                                                    <div class="card-body p-0 d-flex flex-fill">
                                                        <div class="card-content w-100">
                                                            <div class="d-flex justify-content-end p-2">
                                                                <a style="font-size: 18px;" id="btn-editCards" data-houseID="${item.houseID}"><i class="bi bi-pencil-fill"></i></a>
                                                                <button type="button" id="btn-deleteCards" class="btn-close" data-houseID="${item.houseID}" aria-label="Close"></button>
                                                            </div>
                                                            <div class="p-2 m-1">
                                                                <i class="bi bi-houses" style="font-size:50px"></i>
                                                                <label for="text" style="font-size: 30px" class="lbl-location text-capitalize" data-housLocation="${item.houselocation}" id="lbl-houselocationCards">${item.houselocation}</label>
                                                                <div class="m-1">
                                                                    <label for="text" class="house-address text-capitalize" style="font-size:15px" data-houseAddress="${item.houseAddress}" id="lbl-houseAddressCards">House Address: ${item.houseAddress}</label><br/>
                                                                    <label for="text" class="room-number text-capitalize" style="font-size:12px" data-roomNumber="${item.numberOfRoom}" id="lbl-numberOfRoomCards">Number of rooms: ${item.numberOfRoom}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-end">
                                                        <a href="#" id="btn-viewData" class="nav-link view-house text-capitalize" data-houseName="${item.houselocation}" data-houseID="${item.houseID}">View</a>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                        container.append(newCard);
                                    });

                                    $self.$modal.modal('hide');
                                    $('#houseForm')[0].reset();
                                    $self.$btnSave.attr('id', 'btnSave');
                                    $self.$btnSave.text("Save ");
                                },
                                error: function(xhr, status, error) {
                                    alert("An error occurred while loading house data.");
                                }
                            });
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred while processing your request.");
                    }
                });
            }
            }
        }


    }

    housePage.Init({
        $btn_addHouse               : $("#add-house"),
        $btn_close                  : $("#btn-close"),
        $btn                        : $("#btn"),
        $btnMenu_house              : $("#btnMenu-house"),
        $btn_viewData               : $("#btn-viewData"),
        $btn_deleteCards            : $('#btn-deleteCards'),
        $btn_editCards              : $('#btn-editCards'),
        $modal                      : $("#modal"),
        $btnSave                    : $("#btnSave"),
        $inpt_location              : $("#inputHouse-location"),
        $inpt_address               : $("#inputHouse-address"),
        $inpt_rooms                 : $("#inputNumberOf-rooms"),
        $houseCards                 : $("#houseCardsContainer"),
        $viewID                     : $("#viewID"),
        $lbl_modalName              : $('#lbl-modalName')
    });

    });

</script>
</body>
</html>
