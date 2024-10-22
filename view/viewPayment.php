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
      <!-- start modal -->
<!-- Start Modal -->
<div class="modal" id="modal" action="new" tabindex="-1" data-tenantID="" data-dueDate="" data-paymentDetailsID="">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                <h5 class="modal-title" style="color: white">Payment</h5>
                <button type="button" id="btn-closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="paymentForm" method="post">
                <div class="form-content p-4">
                    <div class="mb-3">
                        <label for="text">Balance: </label>
                        <label for="text" id="txt-balance"></label>
                    </div>
                    <!-- <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btn-fullpayment" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="btn-fullpayment">Full Payment</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-partial" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btn-partial">Partial Payment</label>
                    </div> -->

                    <!-- Partial Payment Section -->
                    <div class="mb-3" id="partial-payment-section" >
                        <label for="inpt-paymentType" class="form-label" style="font-size: 14px">Payment Type</label>
                        <div id="payment-type-selections">
                            <select name="inpt-paymentType" class="form-control" id="inpt-paymentType" style="font-size: 15px; height: 30px">
                                <option value="" style="font-size: 15px;">Select Payment Type</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inpt-datepayment" class="form-label" style="font-size: 14px">Date</label>
                            <input type="date" name="inpt-datepayment" class="form-control text-capitalize" id="inpt-partialDatePayment" style="font-size: 15px; height: 30px"> 
                        </div>
                    </div>
                     <!-- Amount Input Section -->
                    <!-- <div class="mb-3" id="inpt-amount-section">
                        <label for="inpt-amount" class="form-label" style="font-size: 14px">Amount</label>
                        <input type="number" name="inpt-amount" class="form-control" id="inpt-amount" style="font-size: 15px; height: 30px">
                    </div> -->
                    <!-- Date Input Section -->
                    <!-- <div class="mb-3">
                        <label for="inpt-datepayment" class="form-label" style="font-size: 14px">Date</label>
                        <input type="date" name="inpt-datepayment" class="form-control text-capitalize" id="inpt-datePayment" style="font-size: 15px; height: 30px"> 
                    </div> -->
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
                                        <th scope="col" style="font-size: 14px">Total Amount</th>
                                        <th scope="col" style="font-size: 14px">Due Date</th>
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
                const $self = this.config;
                $self.$tbody.on('click', '#btn-view', this.getTenantName.bind(this));
                $self.$tbody.on('click', '#btn-pay', this.payButton.bind(this));
                $self.$btn_pay.on('click', this.addPayment.bind(this));
               
            //     $('input[name="btnradio"]').change(function() {
            //     if ($('#btn-partial').is(':checked')) {
            //         $self.$btn_pay.attr('data-payment-basis', 'partial'); // Changed to 'data-payment-basis'
            //         $('#partial-payment-section').show();
            //         $('#inpt-amount-section').hide();
            //         $('#inpt-datePayment').closest('.mb-3').hide();
            //     } else {
            //         console.log('Full payment selected');
            //         $self.$btn_pay.attr('data-payment-basis', 'fullPayment'); // Changed to 'data-payment-basis'
            //         $('#partial-payment-section').hide();
            //         $('#inpt-amount-section').show();
            //         $('#inpt-datePayment').closest('.mb-3').show();
            //     }
            // });
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
                const tenantID = $('#tenantName').data('tenantid');

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
                                                <button type="button" class="btn btn-secondary" id="btn-pay" data-tenantid="${tenantID}">Pay</button>
                                                <button type="button" class="btn btn-secondary" id="btn-view" data-tenantid="${tenantID}">View</button>
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
            payButton: function(event) {
                const $self = this.config;
                const $row = $(event.currentTarget).closest('tr'); // Get the closest <tr>
                const tenantID = $(event.currentTarget).data('tenantid'); // Get tenant ID
                const dueDate = $row.find('td').eq(2).text(); // Get due date from the 3rd <td>
                const balance = $row.find('td').eq(3).text(); // Get balance from the 4th <td>
                $self.$btn_pay.attr('data-payment-basis', 'payment'); 
                
                // Get paymentDetailsIDs from the data attribute and set it on the modal
                const paymentDetailsIDs = $row.data('paymentdetailsid'); // This should be a comma-separated string
                $self.$modal.attr('data-paymentDetailsID', paymentDetailsIDs); // Set paymentDetailsID on modal

                // Set data attributes on the modal
                $self.$modal.attr('data-tenantID', tenantID);
                $self.$modal.attr('data-dueDate', dueDate);
                $('#txt-balance').text(balance);

                // Make AJAX call to fetch payment types based on tenantID and dueDate
                $.ajax({
                    url: '../controller/viewPaymentController.php',
                    type: 'GET',
                    data: { dueDate: dueDate, tenantID: tenantID },
                    dataType: 'json',
                    success: function(response) {
                        const paymentTypeSelections = $('#payment-type-selections'); // Reference to payment type selections container
                        paymentTypeSelections.empty(); // Clear previous labels

                        // Append labels for each payment type
                        $.each(response.data, function(index, item) {
                            const label = `
                                <div>
                                    <label style="font-size: 15px;">
                                        ${item.paymentType} <br/>
                                        Remaining balance: ${item.balance} <br/>
                                        <input type="number" name="paymentType" data-paymentDetailsID="${item.paymentDetailsID}" style="margin-right: 5px;">
                                    </label>
                                </div>`;
                            paymentTypeSelections.append(label); // Append label to the container
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' ' + error);
                    }
                });

                // Show the modal
                $self.$modal.modal('show');
            },



            addPayment: function(e) {
                const $self = this.config;
                e.preventDefault();
                const tenantID = $self.$modal.data('tenantid');
                const paymentBasis = $self.$btn_pay.attr('data-payment-basis');
                const partialPaymentDate = $self.$inpt_partialDatePayment.val().trim();

                // Initialize the request data
                let requestData = {
                    tenantID: tenantID,
                    paymentBasis: paymentBasis
                };

                // Handle partial payments
                if (paymentBasis === 'payment') {
                    let paymentDetails = [];
                    $('#payment-type-selections input[name="paymentType"]').each(function() {
                        const paymentDetailsID = $(this).data('paymentdetailsid');
                        const partialPaymentAmount = $(this).val().trim();
                        if (paymentDetailsID && partialPaymentAmount && !isNaN(partialPaymentAmount) && parseFloat(partialPaymentAmount) > 0) {
                            paymentDetails.push({ paymentDetailsID, partialPaymentAmount });
                        }
                    });

                    // Validate partial payments
                    if (paymentDetails.length > 0) {
                        requestData.paymentDetails = JSON.stringify(paymentDetails);
                        requestData.partialPaymentDate = partialPaymentDate; // Include the date for partial payments
                    } else {
                        alert('Please provide valid partial payment details.');
                        return; // Exit if inputs are invalid
                    }
                } else {
                    alert('Invalid payment basis.'); // Alert if payment basis is not recognized
                    return; // Exit if payment basis is invalid
                }

                // AJAX request to submit the payment data
                $.ajax({
                    url: '../controller/viewPaymentController.php',
                    type: 'POST',
                    data: requestData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            console.log(response.message);
                            alert('Payment added successfully!');
                            $self.$modal.modal('hide');
                            $self.viewTable(); // Refresh the table to show updated payments
                        } else {
                            console.error(response.message);
                            alert('Error adding payment: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', xhr.responseText);
                        alert('An error occurred while processing the payment. Please try again.');
                    }
                });
            }


        }
            rentalPaymentPage.Init({
                $tbody                      : $('#tbody'),
                $tenantName                 : $('#tenantName-container'),
                $modal                      : $('#modal'),
                $btn_pay                    : $('#btnPay'),
                $btn_partial                : $('#btn-partial'),
                $btn_fullpayment            : $('#btn-fullpayment'),
                $inpt_paymentType           : $('#inpt-paymentType'),
                $inpt_amount                : $('#inpt-amount'),
                $inpt_datePayment           : $('#inpt-datePayment'),
                $inpt_partialDatePayment    : $('#inpt-partialDatePayment')
            });
        });
    </script>
</body>
</html>
