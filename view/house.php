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
    <!-- start modal -->
    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white">Add House</h5>
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
        <main class="content px-4 py-4">
    <div class="container-fluid bg-white">
            <div class="room-content p-2">
                <div class="row">
                    <div class="d-md-flex" id="house-location-container"></div>
                    <div class="d-flex align-items-center py-2" style="height: 50px;">
                        <div class="d-flex align-items-center">
                            <label for="sel-roomType" class="form-label me-2">Room Type</label>
                            <select id="sel-roomType" class="form-select" style="width: 200px;">
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
        this.displayHouse();
    },
    BindEvents: function() {
        const $this = this.config;
        $this.$btn_addHouse.on('click', this.addHouseBtn.bind(this));
        $this.$btn_Save.on('click', this.addHouse.bind(this));
        $this.$btn_close.on('click', this.closeModal.bind(this));
        $this.$btnMenu_house.on('click', this.displayHouse.bind(this));
        $this.$houseCards.on('click', '#btn-viewData', this.passHouseID.bind(this));
        
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
                                const newCard = `<div class="col-12 col-md-4 d-flex p-3" action="room.php">
                                <div class="card flex-fill border-0 illustration">
                                    <div class="card-body p-0 d-flex flex-fill">
                                        <div class="card-content w-100">
                                            <div class="p-3 m-1">
                                                <i class="bi bi-houses" style="font-size:50px"></i>
                                                <label for="text" style="font-size: 30px">Houses</label>
                                                <div class="m-1">
                                                    <label for="text" id="house-name" class="text-capitalize" style="font-size:15px">${item.houselocation}</label><br/>
                                                    <label for="text" id="house-name" class="text-capitalize" style="font-size:12px">${item.houseAddress}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="#" id="btn-viewData" class="nav-link view-house" data-houseName="${item.houselocation}" data-houseID="${item.houseID}" >View</a>
                                    </div>
                                </div>
                            </div>`;
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
    },
    addHouseBtn: function() {
        const $self = this.config;
        $self.$modal.modal('show');
    },
    addHouse: function(e) {
        e.preventDefault();
        const $self = this.config;
        if ($self.$inputHouse_location.val().trim() === "" || $self.$inputHouse_address.val().trim() === "" || $self.$inputNumberOf_rooms.val().trim() === "") {
            alert("Please input fields");
            return;
        } else if ($self.$inputNumberOf_rooms.val() < 0) {
            alert("Number of rooms cannot be negative");
            return;
        } else {
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
            const container = $self.$houseCards; // Assuming this is where you want to append the new cards

            // Iterate over each item in the data array
            $.each(data.data, function(index, item) {
                const newCard = `<div class="col-12 col-md-4 d-flex p-3" action="room.php">
                    <div class="card flex-fill border-0 illustration">
                        <div class="card-body p-0 d-flex flex-fill">
                            <div class="card-content w-100">
                                <div class="p-3 m-1">
                                    <i class="bi bi-houses" style="font-size:50px"></i>
                                    <label for="text" style="font-size: 30px">Houses</label>
                                    <div class="m-1">
                                        <label for="text" class="text-capitalize" id="house-name" style="font-size:15px">${item.houselocation}</label><br/>
                                        <label for="text" class="text-capitalize" id="house-name" style="font-size:12px">${item.houseAddress}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="#" id="btn-viewData" class="nav-link view-house " data-houseName="${item.houselocation}" data-houseID="${item.houseID}" >View</a>
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
}

housePage.Init({
    $btn_addHouse               : $("#add-house"),
    $btn_close                  : $("#btn-close"),
    $btn                        : $("#btn"),
    $btnMenu_house              : $("#btnMenu-house"),
    $btn_viewData               : $("#btn-viewData"),
    $modal                      : $("#modal"),
    $btn_Save                   : $("#btnSave"),
    $inputHouse_location        : $("#inputHouse-location"),
    $inputHouse_address         : $("#inputHouse-address"),
    $inputNumberOf_rooms        : $("#inputNumberOf-rooms"),
    $houseCards                 : $("#houseCardsContainer"),
    $viewID                     : $("#viewID")
});

});

</script>
</body>
</html>
