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
    <div class="modal" id="modal" tabindex="-1">
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
                    <select id="sel-houseLocation" class="form-select" style="font-size: 15px; height: 40px">
                                    <option>Select Room Number</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="inputNumberOf-rooms" class="form-label">Name</label>
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
                                            <th scope="col">Other Bill Type</th>
                                            <th scope="col">Amount</th>
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
 
    },
    BindEvents: function() {
        const $this = this.config;
      
        
    },
    
}

housePage.Init({

});

});

</script>
</body>
</html>
