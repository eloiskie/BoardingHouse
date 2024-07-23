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
            <div class="mb-3">
                <label for="tenantName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="inpt-name" >
            </div>
            <div class="mb-3">
                <label for="contactNumber" class="form-label">Contact Number</label>
                <input type="number" class="form-control" id="inpt-number">
            </div>
            <div class="mb-3">
                <label for="homeAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inpt-address">
            </div>
            <div class="row mb-3">
            <div class="col">
                <label for="province-input" class="form-label">Province</label>
                <input type="text" id="inpt-province" class="form-control" placeholder="Province">
            </div>
            <div class="col">
                <label for="city-input" class="form-label">City/Municipality</label>
                <input type="text" id="inpt-city" class="form-control" placeholder="City">
            </div>
            <div class="col">
                <label for="zip-input" class="form-label">Zip Code</label>
                <input type="text" id="inpt-zipCode" class="form-control" placeholder="Zip Code">
            </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-nextInfo">Next</button>
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
                    <h1>Tenant</h1>
                    <div class="d-flex align-items-center py-2" style="height: 50px;">
                        <div class="d-flex align-items-center">
                            <label for="sel-roomType" class="form-label m-2">Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <button class="btn btn-primary btn-sm p-2" type="button" id="btn-add" style="font-size: 12px;">Add Tenant</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <table class="table table-hover">
                                <thead class="table-dark    ">
                                    <tr>
                                        <th scope="col">Tenant Name</th>
                                        <th scope="col">House Location</th>
                                        <th scope="col">Room Number</th>
                                        <th scope="col">Data Started</th>
                                        <th scope="col">Room Fee</th>
                                        <th scope="col">Balance</th>
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
            $this.$btn_next.on('click', this.nextModal.bind(this));
            
    },
    modalShow: function(){
        const $self = this.config;
            $self.$modal_1.modal('show');
    },
    nextModal: function(){
        const $self = this.config;
            const modalContent = 

    }
    }
    housePage.Init({
        $btn_add                    : $('#btn-add'),
        $modal_1                    : $('#modal-1'),
        $btn_next                   : $('#btn-nextInfo'),
        
    });

    });

</script>
</body>
</html>
