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
      <div class="modal" id="modal" action="new" tabindex="-1" data-tenantID="" data-dueDate="">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                    <h5 class="modal-title" style="color: white">Payment</h5>
                    <button type="button" id="btn-closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <form id="chargesForm" method="post">
            <div class="form-content p-4">
                <div class="mb-3">
                    <label for="inpt-amount" class="form-label" style="font-size: 14px">Amount</label>
                    <input type="number" name="inpt-amount" class="form-control text-capitalize" id="inpt-amount" style="font-size: 15px; height: 30px"> 
                </div>
                <div class="mb-3">
                    <label for="inpt-datepayment" class="form-label" style="font-size: 14px">Date</label>
                    <input type="date" name="inpt-datepayment" class="form-control text-capitalize" id="inpt-datePayment" style="font-size: 15px; height: 30px"> 
                </div>
            </div>
            </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnPay">Pay</button>
                </div>
            </div>
        </div>
    </div>
    <!-- close modal -->
    <main class="content px-4 py-4">
    <div class="container-fluid bg-white">
            <div class="room-content p-2">
                <div class="row">
                    <div class="d-md-flex" id="tenantName-container"></div>
                        <div class="d-flex align-items-center py-2" style="height: 50px;">
                </div>
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <table class="table table-hover">
                                <thead class="table-dark    ">
                                    <tr>
                                        
                                        <th scope="col" style="font-size: 14px">Payment Type</th>
                                        <th scope="col" style="font-size: 14px">Amount</th>
                                        <th scope="col" style="font-size: 14px">Due Date</th>
                                        <th scope="col" style="font-size: 14px">Total Amount</th>
                                        <th scope="col" style="font-size: 14px">Balance</th>
                                        <th scope="col" style="font-size: 14px">Status</th>
                                        <th scope="col" style="font-size: 14px">Action</th>
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

    const rentalPaymentPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.getTenantName();
            this.viewTable();
           
        
        },
        BindEvents: function() {
            const $this = this.config;
                $this.$tbody.on('click', '#btn-view', this.getTenantName.bind(this));
                $this.$tbody.on('click', '#btn-pay', this.payButton.bind(this));
                $this.$btn_pay.on('click', this.addPayment.bind(this));
        },
        getTenantName: function() {
            const $self = this.config;
            const tenantName = localStorage.getItem("tenantName");
            const tenantID = localStorage.getItem("tenantID");
          
            
            if (tenantName) {
                const label = `<h1 id="tenantName" data-tenantID="${tenantID}" class="text-uppercase">${tenantName }</h1>`;
                $self.$tenantName.append(label); 
            } else {
                console.warn("No house name found in localStorage.");
            }
      
        },
        modalShow: function(){
            const $self = this.config;
            $self.$modal.modal('show');
        },
            viewTable: function() {
                const $self = this.config;
                const tenantID = $('#tenantName').data('tenantid'); // Fetch tenant ID
                // Check if tenant ID exists
                if (!tenantID) {
                    console.error('Tenant ID is missing.');
                    return;
                }

                $.ajax({
                    url: '../controller/viewPaymentController.php',
                    type: 'GET',
                    data: { tenantID: tenantID },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Response:', response); // Log the response for debugging
                        if (response.status === 'success') {
                            $self.$tbody.empty();
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, item) {
                                    // Determine the status based on remaining balance
                                    let status;
                                    if (item.remainingBalance == 0) {
                                        status = 'paid';
                                    } else if (item.remainingBalance > 0 && item.remainingBalance < item.totalAmount) {
                                        status = 'partial';
                                    }else {
                                        status = 'pending';
                                    }

                                    const row = `
                                        <tr class="text-capitalize">
                                            <td>${item.chargeTypes}</td>
                                            <td>${item.amounts}</td>
                                            <td>${item.dueDate}</td>
                                            <td>${item.totalAmount}</td>
                                            <td id="remainingBalance">${item.remainingBalance}</td>
                                            <td id="paymentStatus">${status}</td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-pay" data-tenantid="${item.tenantID}">Pay</button>
                                                <button type="button" class="btn btn-secondary" style="width: 80px; font-size: 12px;" id="btn-view" data-tenantid="${item.tenantID}">View</button>
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
                        console.error('Error fetching data:', error);
                        $self.$tbody.html('<tr><td colspan="7">Error loading payment records.</td></tr>');
                    }
                });
            },


            payButton: function(event) {
                const $self = this.config;
                const $row = $(event.currentTarget).closest('tr');
                const tenantID = $(event.currentTarget).data('tenantid');
                const dueDate = $row.find('td').eq(2).text();
                console.log(dueDate);

                // Set data attributes on the modal
                $self.$modal.attr('data-tenantID', tenantID);
                $self.$modal.attr('data-dueDate', dueDate);

                // Show the modal
                $self.$modal.modal('show');
            },

            addPayment: function(event) {
    const $self = this.config;
    const $row = $(event.currentTarget).closest('tr');
    const paymentDetailsID = $self.$modal.data('paymentdetailsid');
    const tenantID = $self.$modal.data('tenantid');
    const dueDate = $self.$modal.data('duedate');
    
    // Get input values and trim them
    const amount = $self.$inpt_amount.val().trim();
    const paymentDate = $self.$inpt_datePayment.val().trim();

    // Validate inputs before sending
    if (!amount || !paymentDate) {
        alert("Please fill in all required fields.");
        return;
    }

    $.ajax({
        url: '../controller/viewPaymentController.php',
        type: 'POST',
        data: {
            amount: amount,
            paymentDate: paymentDate,
            paymentDetailsID: paymentDetailsID,
            tenantID: tenantID,
            dueDate: dueDate
        },
        dataType: 'json',
        success: function(response) {
            console.log('Response from addPayment:', response); // Log the response

            if (response.status === "success") {
                alert(response.message);
                console.log("Remaining Balance:", response.balance);
                
                // Update remaining balance and payment status
                let balance = response.balance;
                let totalAmount = response.totalCharges; // Adjusted to match your PHP response

                // Determine payment status based on remaining balance
                let paymentStatus;
                if (balance === 0) {
                    paymentStatus = 'paid';
                } else if (balance > 0 && balance < totalAmount) {
                    paymentStatus = 'partial';
                } else {
                    paymentStatus = 'pending';
                }

                // Update the respective cells in the row
                $row.find(".remainingBalance").text(remainingBalance);
                $row.find(".paymentStatus").text(paymentStatus);

                // Optionally update other relevant fields if needed
                // $row.find(".totalAmount").text(totalAmount); // Example

                // Hide modal and reset the form
                $self.$modal.modal('hide');
                $('#chargesForm')[0].reset();
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status + ' ' + error);
            alert('An error occurred while processing your request. Please try again.');
        }
    });
}

    }
    rentalPaymentPage.Init({
        $tbody                      : $('#tbody'),
        $tenantName                 : $('#tenantName-container'),
        $modal                      : $('#modal'),
        $btn_pay                    : $('#btnPay'),
        $inpt_paymentType           : $('#inpt-paymentType'),
        $inpt_amount                : $('#inpt-amount'),
        $inpt_datePayment           : $('#inpt-datePayment')
    });
});
</script>
</body>
</html>
