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
                    <a class="sidebar-link" href="agreement.php">
                        <i class="bi bi-envelope-paper"></i>
                        Agreement
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
        <main class="content px-2 py-2">
        <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4 d-flex p-3">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="card-content w-100">
                                        <div class="pt-3  px-3 m-1">
                                            <i class="bi bi-houses" style="font-size:50px"></i>
                                            <label for="text" style="font-size: 30px">Houses</label>
                                        </div>
                                        <div class="ps-3 m-1">
                                            <label for="text" class="text-capitalize" style="font-size:15px" id="lbl-numberOfhouses"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="house.php" class="nav-link">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex p-3">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="card-content w-100">
                                        <div class="pt-3  px-3 m-1">
                                            <i class="bi bi-people" style="font-size: 50px"></i>
                                            <label for="text" style="font-size: 30px">Tenant</label>
                                        </div>
                                        <div class="ps-3 m-1">
                                            <label for="text" class="text-capitalize" style="font-size:15px" id="lbl-numberOfTenant"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="tenant.php" class="nav-link">View</a>
                                 </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex p-3">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="card-content w-100">
                                        <div class="p-3 m-1">
                                            <i class="bi bi-file-earmark-text" style="font-size:50px"></i>
                                            <label for="text" style="font-size: 30px">Report</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="tenant.php" class="nav-link">View</a>
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

    const indexPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.viewData();
         
        },
        BindEvents: function() {
            const $this = this.config;
           
        },
       

    }

    indexPage.Init({
     

    });
});
</script>
</body>
</html>

