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
    <div class="modal" id="modal" tabindex="-1" >
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white" id="lbl-modalName">Maintenance Request</h5>
                    <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card-body p-3" id="request-content">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label fw-bold">Date of Request:</label>
                        <div class="col-sm-8">
                        <p class="form-control-plaintext" id="lbl-dateOfRequest"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label fw-bold text-nowrap">Maintenance Type:</label>
                        <div class="col-sm-8">
                        <p class="form-control-plaintext"  id="lbl-maintenanceType"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label fw-bold">Description:</label>
                        <div class="col-sm-8">
                        <p class="form-control-plaintext" id="lbl-description"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label fw-bold">Priority Level:</label>
                        <div class="col-sm-8">
                        <p class="form-control-plaintext" id="lbl-priorityLevel"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label fw-bold">Status:</label>
                        <div class="col-sm-8">
                        <p class="form-control-plaintext" id="lbl-status"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-process">Process</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
        <main class="content px-4 py-4">
    <div class="container-fluid bg-white">
            <div class="room-content p-2">
                <div class="row">
                    <div class="d-md-flex" id="deliquent-container"></div>
                        <div class="d-flex align-items-center py-2" style="height: 50px;">
                            <div class="d-flex">
                                <label id="lbl-tenantName" ></label>
                            </div>
                </div>
                <div class="row">
                    <div class="d-md-flex" id="deliquent-container"></div>
                        <div class="d-flex align-items-center py-2" style="height: 50px;">
                            <div class="d-flex">
                                <label for="sel-Year" >Select Status</label>
                                <input type="text" id="inpt-selYear" class="form-control" placeholder="Select Status" style="font-size: 15px; height: 40px">
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
            $this.$tbody.on('click', '#btn-view', this.viewRequest.bind(this));
            $this.$btn_process.on('click', this.inProgress.bind(this));
            $this.$tbody.on('click', '#btn-complete', this.doneRequest.bind(this));
        },
        getTenantID: function() {
            const $self = this.config;
            
            const tenantID = localStorage.getItem("tenantID");
            const tenantName = localStorage.getItem("tenantName"); // Retrieve tenantName

            if (tenantID && tenantName) {
                $self.$lbl_tenantName.text('Name: ' + tenantName);  // This should update the text
                $self.$tbody.attr('data-tenantid', tenantID);
            } else {
                console.warn("No tenantID or tenantName found in localStorage.");
            }
        },
        reqeustList: function(){
            const $self = this.config;
            const tenantID = $self.$tbody.data('tenantid');
            $.ajax({
                url : '../controller/listTenantReqController.php',
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
                                            <button type="button" style="width: 80px" class="btn btn-secondary edit-room" id="btn-view" data-requestID="${item.requestID}">View</button>
                                            <button type="button" style="width: 80px" class="btn btn-secondary edit-room" id="btn-complete" data-tenantID="${item.tenantID}">Done</button>
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
        },
        viewRequest: function(e) {
            const $self = this.config;
            const tenantID = $self.$tbody.data('tenantid');
            e.preventDefault();

            const row = $(e.currentTarget).closest('tr');
            const requestID = row.data('requestid');
            const checkStatus = row.find('td').eq(2).text().trim();

            // Assign correct Ajax URL and parameters based on status
            const ajaxData = checkStatus === 'In Progress' || checkStatus === 'Completed'
                ? { processingRequest: true, tenantID: tenantID, requestID: requestID }
                : { requestID: requestID };

            $.ajax({
                url: '../controller/listTenantReqController.php',
                type: 'GET',
                data: ajaxData,
                dataType: 'json',
                success: function(data) {
                    if (Array.isArray(data)) {
                        // For the 'processingRequest' response (multiple rows)
                        $.each(data, function(index, item) {
                            $self.$lbl_dateOfRequest.text(item.requestDate);
                            $self.$lbl_maintenanceType.text(item.maintenanceType);
                            $self.$lbl_description.text(item.description);
                            $self.$lbl_priorityLevel.text(item.priorityLevel);
                            $self.$lbl_status.text(item.requestStatus);
                        });
                    } else if (data) {
                        // For single 'requestID' response
                        $self.$lbl_dateOfRequest.text(data.requestDate);
                        $self.$lbl_maintenanceType.text(data.maintenanceType);
                        $self.$lbl_description.text(data.description);
                        $self.$lbl_priorityLevel.text(data.priorityLevel);
                        $self.$lbl_status.text(data.requestStatus);

                        // Update the row's status in the table if applicable
                        row.find('td').eq(2).text(data.requestStatus);
                    } else {
                        console.error('No data returned from the server');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });

            // Show the modal
            $self.$modal.attr('data-requestid', requestID);
            $self.$modal.modal('show');
        },
        inProgress: function() {
            const $self = this.config;
            const requestID = $self.$modal.data('requestid'); // Get requestID from modal data

            // Sending the PUT request with the proper data
            $.ajax({
                url: '../controller/listTenantReqController.php',
                type: 'PUT',
                data: JSON.stringify({ inProgress: true, requestID: requestID, requestStatus: 3 }), // 3 represents 'In Progress'
                contentType: 'application/json',
                success: function(response) {
                    const data = JSON.parse(response);
                    if(data.status === 'success'){
                        alert(data.message);
                        const updatedStatus = data.data[0].requestStatus; // 'In Progress'

                        // Update the status in the table row for the matching requestID
                        $(`tr[data-requestid="${requestID}"] td:eq(2)`).text(updatedStatus);
                        $self.$modal.modal('hide');
                    }
                },
                error: function(xhr) {
                    console.log("Error response:", xhr.responseText); // Log any error response for debugging
                    alert("Error updating status: " + (xhr.responseText || "Unknown error"));
                }
            });
        },
        doneRequest: function(e){
            const $self = this.config;
            e.preventDefault();
            const row = $(e.currentTarget).closest('tr');
            const requestID = row.data('requestid');

            // Sending the PUT request with the proper data
            $.ajax({
                url: '../controller/listTenantReqController.php',
                type: 'PUT',
                data: JSON.stringify({ completed: true, requestID: requestID, requestStatus: 4 }), // 3 represents 'Completed'
                contentType: 'application/json',
                success: function(response) {
                    const data = JSON.parse(response);
                    if(data.status === 'success'){
                        alert(data.message);
                        const updatedStatus = data.data[0].requestStatus; // 'In Progress'

                        // Update the status in the table row for the matching requestID
                        $(`tr[data-requestid="${requestID}"] td:eq(2)`).text(updatedStatus);
                        $self.$modal.modal('hide');
                    }
                },
                error: function(xhr) {
                    console.log("Error response:", xhr.responseText); // Log any error response for debugging
                    alert("Error updating status: " + (xhr.responseText || "Unknown error"));
                }
            });
        }


    }
    
    maintenancerequestPage.Init({
            $tbody                      : $('#tbody'),
            $modal                      : $('#modal'),
            $lbl_tenantName             : $('#lbl-tenantName'),
            $lbl_dateOfRequest          : $('#lbl-dateOfRequest'),
            $lbl_maintenanceType        : $('#lbl-maintenanceType'),
            $lbl_description            : $('#lbl-description'),
            $lbl_priorityLevel          : $('#lbl-priorityLevel'),
            $lbl_status                 : $('#lbl-status'),
            $request_content            : $('#request-content'),
            $btn_process                : $('#btn-process')
    });
    });

</script>
</body>
</html> 