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
                    <a class="sidebar-link" href="payment.php">
                        <i class="bi bi-credit-card-2-front"></i>
                        Payment</a>
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
<!-- start modal paymentTransaction -->
<div class="modal" id="transactionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Payment Type</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Date Payment</th>
                                <th scope="col">Payment Amount</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyPaymentList">
                            <!-- Table rows go here -->
                        </tbody>
                    </table>
                </div>
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
                                <label for="sel-Year" >Select Year</label>
                                <input type="text" id="inpt-selYear" class="form-control" placeholder="Select Year" style="font-size: 15px; height: 40px">
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-primary btn-sm p-2" type="button" id="btnFilter" style="font-size: 12px;">Filter</button>
                            </div>
                           
                </div>
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <table class="table table-hover">
                                <thead class="table-dark    ">
                                    <tr>
                                        <th scope="col">Payment Type</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Balance</th>
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

    const paymentPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.getTenantID();
            this.viewTable();
        },
        BindEvents: function() {
            const $this = this.config;
            $this.$tbody.on('click', '#btn-viewPayment', this.transaction.bind(this));
           
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
        viewTable: function() {
                const $self = this.config;
                const tenantID = $self.$tbody.data('tenantid');

                if (!tenantID) {
                    console.error('Tenant ID is missing.');
                    return;
                }

                $.ajax({
                    url: '../controller/paymentController.php',
                    type: 'GET',
                    data: { tenantID: tenantID },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $self.$tbody.empty(); // Clear table body

                            if (response.data.length > 0) {
                                $.each(response.data, function(index, item) {
                                    // Determine payment status
                                    let status = (item.remainingBalance == 0) 
                                        ? 'paid' 
                                        : (item.remainingBalance > 0 && item.remainingBalance < item.totalAmount) 
                                        ? 'partial' 
                                        : 'pending';

                                    // Create row template
                                    const row = `
                                        <tr class="text-capitalize" data-paymentDetailsID="${item.paymentDetailsIDs.join(',')}">
                                            <td>${item.paymentTypes}</td>
                                            <td>${item.totalAmount}</td>
                                            <td>${item.dueDate}</td>
                                            <td id="remainingBalance">${item.remainingBalance}</td>
                                            <td>${status}</td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" id="btn-viewPayment" data-tenantid="${tenantID}">View</button>
                                            </td>
                                        </tr>`;
                                    $self.$tbody.append(row); // Append row to table
                                });
                            } else {
                                $self.$tbody.append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                            }
                        } else {
                            console.error('Error fetching data: ' + response.message);
                            $self.$tbody.html('<tr><td colspan="6">Error loading payment records.</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        $self.$tbody.html('<tr><td colspan="6">Error loading payment records.</td></tr>');
                    }
                });
        },
        transaction: function(event) {
                const $self = this.config;
                const $row = $(event.currentTarget).closest('tr'); // Get the closest row
                const tenantID = $self.$tbody.data('tenantid');
                const dueDate = $row.find('td').eq(2).text(); // Get due date from the third cell
                $self.$transactionModal.modal('show');
                $.ajax({
                    url: '../controller/paymentController.php',
                    type: 'GET',
                    data: { 
                        paymentList: true,
                        tenantID: tenantID,
                        dueDate: dueDate 
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $self.$tbodyPaymentList.empty(); // Clear previous results
                            if (response.data.length > 0) { 
                                $.each(response.data, function(index, item) {
                                    const row = `
                                        <tr class="text-capitalize">
                                            <td>${item.PaymentType}</td>
                                            <td>${parseFloat(item.Amount).toFixed(2)}</td>
                                            <td>${item.DueDate}</td>
                                            <td>${item.PaymentDate}</td>
                                            <td>${parseFloat(item.PaymentAmount).toFixed(2)}</td>
                                            <td>${parseFloat(item.Balance).toFixed(2)}</td>
                                        </tr>`;
                                    $self.$tbodyPaymentList.append(row);
                                });
                            } else { 
                                $self.$tbodyPaymentList.append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                            }
                        } else { 
                            console.error('Error fetching data: ' + response.message);
                            $self.$tbodyPaymentList.append('<tr><td colspan="6" class="text-center">Error fetching data</td></tr>');
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' ' + error);
                    }
                });
            }

    }

    paymentPage.Init({
        $tbody                  : $('#tbody'),
        $transactionModal       : $('#transactionModal'),
        $tbodyPaymentList       : $('#tbodyPaymentList')
    });
});
</script>
</body>
</html> 