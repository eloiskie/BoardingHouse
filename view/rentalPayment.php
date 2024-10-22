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
        <div class="modal" id="modal" tabindex="-1" action="new">
        <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                                <h5 class="modal-title" style="color: white">Add Payment</h5>
                                <button type="button" id="btn-closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        <form id="chargesForm" method="post">
                        <div class="form-content p-4">
                            <div class="row align-items-start">
                                <div class="col">
                                <label for="tenatName" class="form-label" style="font-size: 14px">Tenant Name</label>
                                <select id="sel-tenantName" class="form-select" style="font-size: 15px; height: 40px">
                                                <option>Select Tenant</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                                <div class="row align-items-start">
                                    <div class="col">
                                        <label for="inpt-number" class="form-label" style="font-size: 14px">Payment Type</label>
                                        <input type="text" class="form-control" id="inpt-chargeType" style="font-size: 15px; height: 30px">
                                    </div>
                                    <div class="col">
                                        <label for="inpt-gender" class="form-label" style="font-size: 14px">Amount</label>
                                        <input type="text" class="form-control" id="inpt-amount" style="font-size: 15px; height: 30px">
                                    </div>
                                </div>
                        </div>
                        <div id="paymentType-container">

                        </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary" id="btn-addPaymentType">Add</button>
                            </div>
                            <div class="mb-3">
                                <label for="input-dueDate" class="form-label" style="font-size: 14px">Due Date</label>
                                <input type="date" name="input-dueDate" class="form-control" id="inpt-dueDate" style="font-size: 15px; height: 30px">
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
                                    <button class="btn btn-primary btn-sm p-2" type="button" id="btn-add" style="font-size: 12px;">Add Payments</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div class="table-wrapper">
                                    <table class="table table-hover">
                                        <thead class="table-dark">
                                            <tr style="font-size: 15px">
                                                <th scope="col">Name</th>
                                                <th scope="col">House Rented</th>
                                                <th scope="col">Room Number</th>
                                                <th scope="col">Room Fee</th>
                                                <th scope="col">Balance</th>
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

    const rentalPaymentPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.viewTenants();
            this.getTenantName();
        },
        BindEvents: function() {
            const $this = this.config;
            $this.$tbody.on('click', '#btn-view', this.passViewPayment.bind(this));
            $this.$btn_add.on('click', this.modalShow.bind(this));
            $this.$btn_save.on('click', this.addPaymentDetails.bind(this));
            $this.$btn_addPaymentType.on('click', this.addPaymentType.bind(this));
        },
        passViewPayment: function(event) {
            const $row = $(event.currentTarget).closest('tr');
            const tenantID = $row.data('tenantid');
            console.log(tenantID);
            const tenantName = $row.find('td').eq(0).text();
            localStorage.setItem("tenantName", tenantName);
            localStorage.setItem("tenantID", tenantID);
            window.location.href = "viewPayment.php";
        },
        viewTenants: function() {
            const $self = this.config;

            $.ajax({
                url: '../controller/rentalPaymentController.php',
                type: 'GET',
                data: { tenant: true },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $self.$tbody.empty();
                        if (response.data.length > 0) {
                            $.each(response.data, function(index, item) {
                                const row = `
                                    <tr class="text-capitalize" data-tenantName="${item.tenantName}" data-tenantid="${item.tenantID}">
                                        <td>${item.tenantName}</td>
                                        <td>${item.houselocation}</td> 
                                        <td>${item.roomNumber}</td>
                                        <td>${item.roomfee}</td>
                                        <td class="tblBalance" id="totalAmountCell">${item.remainingBalance}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-view" data-roomID="${item.tenantID}">View</button>
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

        modalShow: function() {
            const $self = this.config;
            $self.$modal.modal('show');
        },
        getTenantName: function() {
            const $self = this.config;
            $.ajax({
                url: '../controller/rentalPaymentController.php', // Ensure this path is correct
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const selectTenant = $self.$sel_tenantName;
                        selectTenant.empty();
                        selectTenant.append('<option value="" style="font-size: 15px;">Select Tenant</option>');

                        if (response.data.length > 0) {
                            $.each(response.data, function(index, item) {
                                selectTenant.append('<option value="' + item.tenantID + '">' + item.tenantName + '</option>');
                            });
                        } else {
                            console.log("No tenants found.");
                        }
                    } else {
                        console.error('Error fetching tenant names: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        },

        addPaymentType: function() {
            const $self = this.config;
            const row = `
                <div class="row align-items-start payment-type-row">
                    <div class="col">
                        <label for="inpt-chargeType" class="form-label" style="font-size: 14px">Payment Type</label>
                        <input type="text" class="form-control inpt-chargeType" style="font-size: 15px; height: 30px">
                    </div>
                    <div class="col">
                        <label for="inpt-amount" class="form-label" style="font-size: 14px">Amount</label>
                        <input type="text" class="form-control inpt-amount" style="font-size: 15px; height: 30px">
                    </div>
                </div>`;
            $self.$paymentType_container.append(row);
        },
        addPaymentDetails: function(e) {
            const $self = this.config;
            e.preventDefault();

            const paymentTypes = [];
            const amounts = [];
            const dueDate = $self.$inpt_dueDate.val();
            const tenantID = $self.$sel_tenantName.val();

            if (!tenantID) {
                alert("Please select a tenant.");
                return;
            }

            if (!dueDate) {
                alert("Please select a due date.");
                return;
            }

            const defaultPaymentType = $self.$inpt_chargeType.val();
            const defaultAmount = parseFloat($self.$inpt_amount.val());

            if (defaultPaymentType && !isNaN(defaultAmount)) {
                paymentTypes.push(defaultPaymentType);
                amounts.push(defaultAmount);
            }

            // Loop through additional payments entered
            $self.$paymentType_container.find('.payment-type-row').each(function() {
                const paymentType = $(this).find('.inpt-chargeType').val();
                const amount = parseFloat($(this).find('.inpt-amount').val());

                if (paymentType && !isNaN(amount)) {
                    paymentTypes.push(paymentType);
                    amounts.push(amount);
                }
            });

            if (paymentTypes.length === 0) {
                alert("Please enter at least one payment.");
                return;
            }

            const formData = {
                paymentTypes: paymentTypes,
                amounts: amounts,
                dueDate: dueDate,
                tenantID: tenantID
            };

            if ($self.$submitButton) {
                $self.$submitButton.prop('disabled', true).text('Processing...');
            }

            $.ajax({
                type: 'POST',
                url: '../controller/rentalPaymentController.php',
                data: formData,
                dataType: 'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                success: function(response) {
                    console.log("AJAX response:", response);
                    if (response.status === "success") {
                        alert(response.message);

                        $('#chargesForm')[0].reset();

                        const totalCharges = response.totalCharges || 0;
                        const totalPayments = response.totalPayments || 0;
                        const remainingBalance = response.remainingBalance || 0;
                        console.log(remainingBalance);
                        // Update total amount and balance in the UI
                        $('#totalAmountCell').text(response.remainingBalance.toFixed(2));

                        // Hide modal after success
                        $self.$modal.modal('hide');
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' ' + error);
                    alert("An error occurred while processing the request. Please try again.");
                },
                complete: function() {
                    if ($self.$submitButton) {
                        $self.$submitButton.prop('disabled', false).text('Submit');
                    }
                }
            });
        }

    }

    rentalPaymentPage.Init({
        $tbody: $('#tbody'),
        $modal: $('#modal'),
        $paymentType_container: $('#paymentType-container'),
        $btn_add: $('#btn-add'),
        $btn_addPaymentType: $('#btn-addPaymentType'),
        $btn_save: $('#btnSave'),
        $sel_tenantName: $('#sel-tenantName'),
        $inpt_chargeType: $('#inpt-chargeType'),
        $inpt_amount: $('#inpt-amount'),
        $inpt_dueDate: $('#inpt-dueDate'),
        $submitButton: $('#btnSave') // Ensure to define this variable
    });
});


    </script>
    </body>
    </html>
