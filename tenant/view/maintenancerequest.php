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
                        Payment History
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
                            <div class="d-flex">
                                <label for="sel-Year" >Select Status</label>
                                <input type="text" id="inpt-selYear" class="form-control" placeholder="Select Status" style="font-size: 15px; height: 40px">
                            </div>
                            <div class="ms-auto">
                            <a href="requestMaintenance.php" class=" nav-link text-primary">Request Maintenance</a>
                            </div>
                           
                </div>
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <table class="table table-hover">
                                <thead class="table-dark    ">
                                    <tr>
                                        <th scope="col">Date of Request</th>
                                        <th scope="col">Maintenance Type</th>
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

    const maintenancerequestPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.getTenantID();
            this.reqeustList();
        },
        BindEvents: function() {
            const $this = this.config;
         
        },
        getTenantID: function() {
            const $self = this.config;
            
            const tenantID = localStorage.getItem("tenantID");

            if (tenantID) {
                $self.$tbody.attr('data-tenantid', tenantID);
            } else {
                console.warn("No tenantID found in localStorage.");
            }
        },
        reqeustList: function(){
            const $self = this.config;
            const tenantID = $self.$tbody.data('tenantid');
            $.ajax({
                url : '../controller/maintenancerequestController.php',
                Type: 'GET',
                data: {
                    tenantID : tenantID
                },
                dataType: 'json',
                success: function(data){
                    $self.$tbody.empty(); // Clear the existing table rows
                        if (data.length === 0) {
                            $self.$tbody.append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                        } else {
                            $.each(data, function(index, item) {
                                const row = `
                                    <tr  class="text-capitalize" data-requestID="${item.requestID}">
                                        <td>
                                            Date: ${item.requestDate} <br/>
                                            Time: ${item.requestTime}
                                        </td>
                                        <td>${item.maintenanceType}</td>
                                        <td>${item.requestStatus}</td>
                                        <td>
                                            <button type="button" style="width: 80px" class="btn btn-secondary edit-room" id="btn-edit" data-roomID="${item.requestID}">Edit</button>
                                        </td>
                                    </tr>
                                    `;
                                $self.$tbody.append(row); // Append new filtered rows to the table
                            });
                        }
                },
                error: function(){

                }
            });
        }
       

    }

    maintenancerequestPage.Init({
            $tbody      : $('#tbody')
    });
});

    </script>
</body>
</html> 