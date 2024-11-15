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
     <div class="modal" id="modalEdit" tabindex="-1" action="new">
        <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header bg-dark border-bottom border-body" data-bs-theme="dark">
                                <h5 class="modal-title" style="color: white">Edit Payment</h5>
                                <button type="button" id="btn-closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        <form id="chargesForm" method="post">
                        <div class="form-content p-4">
                            <div class="row align-items-start">
                                <div class="col">
                                <label for="tenatName" class="form-label fw-bold" style="font-size: 14px">Tenant Name</label>
                                <select id="sel-tenantName" class="form-select" style="font-size: 15px; height: 40px">
                                                <option>Select Tenant</option>
                                </select>
                                </div>
                        </div>
                        <div class="mb-3">
                        </div>
                        <div id="paymentType-container">

                        </div>
                        </div>
                        </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-save">Save</button>
                            </div>
                        </div>
                    
                </div>
        </div>
        <!-- end modal -->
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
                    <div class="mb-3" id="partial-payment-section" >
                        <label for="inpt-paymentType" class="form-label" style="font-size: 14px">Payment Type</label>
                        <div id="payment-type-selections">

                        </div>
                        <div class="mb-3">
                            <label for="inpt-datepayment" class="form-label" style="font-size: 14px">Date</label>
                            <input type="date" name="inpt-datepayment" class="form-control text-capitalize" id="inpt-partialDatePayment" style="font-size: 15px; height: 30px"> 
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnPay">Pay</button>
            </div>
        </div>
    </div>
</div>
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
                            <tr style="font-size: 14px">
                                <th scope="col">Payment Type</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Date Payment</th>
                                <th scope="col">Previous Balance</th>
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
                this.SelTenantName();
            },
            BindEvents: function() {
                const $self = this.config;
                $self.$tbody.on('click', '#btn-view', this.getTenantName.bind(this));
                $self.$tbody.on('click', '#btn-viewPayment', this.viewPayment.bind(this));
                $self.$tbody.on('click', '#btn-pay', this.payButton.bind(this));
                $self.$tbody.on('click', '#btn-edit', this.edit.bind(this));
                $self.$btn_pay.on('click', this.addPayment.bind(this));
                $self.$btn_save.on('click', this.update.bind(this));
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
            SelTenantName: function() {
                const $self = this.config;
                $.ajax({
                    url: '../controller/rentalPaymentController.php', // Ensure this path is correct
                    type: 'GET',
                    data: {tenantName : true},
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
                                    let paymetstatus = '';
                                        const remainingBalance = parseFloat(item.remainingBalance);
                                        const totalAmount = parseFloat(item.totalAmount);

                                        if (remainingBalance === 0) {
                                            paymetstatus = 'paid';
                                        } else if (remainingBalance > 0 && remainingBalance < totalAmount) {
                                            paymetstatus = 'partial';
                                        } else {
                                            paymetstatus = 'pending';
                                        }
                                    // Create row template
                                    const row = `
                                        <tr class="text-capitalize" data-paymentDetailsID="${item.paymentDetailsIDs.join(',')}">
                                            <td>${item.paymentTypes}</td>
                                            <td>${item.totalAmount}</td>
                                            <td>${item.dueDate}</td>
                                            <td id="remainingBalance">${item.remainingBalance}</td>
                                            <td>${paymetstatus}</td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" id="btn-pay" data-tenantid="${item.tenantID}">Pay</button>
                                                <button type="button" class="btn btn-secondary" id="btn-viewPayment" data-tenantid="${item.tenantID}">View</button>
                                                <button type="button" class="btn btn-secondary" id="btn-edit" data-tenantid="${item.tenantID}">Edit</button>
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
                const tenantID = $('#tenantName').data('tenantid');
                const dueDate = $row.find('td').eq(2).text(); // Get due date from the 3rd <td>
                const balance = $row.find('td').eq(3).text(); // Get balance from the 4th <td>
                
                // Set the balance in the modal
                $('#txt-balance').text(balance);

                // Get paymentDetailsIDs from the data attribute and set it on the modal
                const paymentDetailsIDs = $row.data('paymentdetailsid'); // This should be a comma-separated string
                $self.$modal.attr('data-paymentDetailsID', paymentDetailsIDs); // Set paymentDetailsID on modal

                // Set data attributes on the modal
                $self.$modal.attr('data-tenantID', tenantID);
                $self.$modal.attr('data-dueDate', dueDate);

                // Make AJAX call to fetch payment types based on tenantID and dueDate
                $.ajax({
                    url: '../controller/viewPaymentController.php',
                    type: 'GET',
                    data: { pay: true, dueDate: dueDate, tenantID: tenantID },
                    dataType: 'json',
                    success: function(response) {
                            const paymentTypeSelections = $('#payment-type-selections'); // Reference to payment type selections container
                            paymentTypeSelections.empty(); // Clear previous labels

                            // Append labels for each payment type
                            $.each(response.data, function(index, item) {
                                if (item.balance > 0) { // Only display items with a balance greater than zero
                                    const label = `
                                        <div>
                                            <label style="font-size: 15px;">
                                                ${item.paymentType} <br/>
                                                Remaining balance: ${item.balance} <br/>
                                                <input type="number" 
                                                    name="paymentType" 
                                                    data-paymentDetailsID="${item.paymentDetailsID}" 
                                                    class="form-control payment-input" 
                                                    style="margin-right: 5px;" 
                                                    placeholder="Enter amount">
                                            </label>
                                        </div>`;
                                    paymentTypeSelections.append(label); // Append label to the container
                                }
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
                const paymentBasis = 'payment';
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
                            window.location.reload(); 
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
            },
            viewPayment: function(event) {
    const $self = this.config;
    $self.$transactionModal.modal('show');
    const $row = $(event.currentTarget).closest('tr');
    const tenantID = $('#tenantName').data('tenantid');
    const dueDate = $row.find('td').eq(2).text(); // Get due date from the third cell

    let cumulativePayment = 0; // To track cumulative payment amount

    $.ajax({
        url: '../controller/viewPaymentController.php',
        type: 'GET',
        data: { 
            paymentList: true,
            tenantID: tenantID,
            dueDate: dueDate 
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $self.$tbodyPaymentList.empty(); 
                if (response.data.length > 0) { 
                    $.each(response.data, function(index, item) {
                        const amount = parseFloat(item.Amount) || 0;
                        const paymentAmount = parseFloat(item.PaymentAmount) || 0;
                        const previousBalance = parseFloat(item.PreviousBalance) || 0;

                        // Update cumulative payment for previous balance reference
                        cumulativePayment += paymentAmount;

                        const row = `
                            <tr class="text-capitalize" style="font-size: 13px">
                                <td>${item.PaymentType}</td>
                                <td>${amount.toFixed(2)}</td>
                                <td>${item.DueDate}</td>
                                <td>${item.PaymentDate}</td>
                                <td>${previousBalance.toFixed(2)}</td> <!-- Corrected Previous Balance -->
                                <td>${paymentAmount.toFixed(2)}</td>
                                <td>${(amount - cumulativePayment).toFixed(2)}</td> <!-- Remaining Balance -->
                            </tr>`;
                        $self.$tbodyPaymentList.append(row);
                    });
                } else { 
                    $self.$tbodyPaymentList.append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                }
            } else { 
                console.error('Error fetching data: ' + response.message);
                $self.$tbodyPaymentList.append('<tr><td colspan="7" class="text-center">Error fetching data</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status + ' ' + error);
        }
    });
},


            edit: function(event) {
                const $self = this.config;
                const $row = $(event.currentTarget).closest('tr'); // Get the closest row
                const tenantID = $('#tenantName').data('tenantid');
                const dueDate = $row.find('td').eq(2).text(); // Get due date from the third cell
                $.ajax({
                    url: '../controller/viewPaymentController.php',
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
                                // Clear previous payment type rows
                                $('#paymentType-container').empty();

                                $.each(response.data, function(index, item) {
                                    $self.$sel_tenantName.val(tenantID);

                                    // Check if the PaymentType is "Others"
                                    let paymentTypeField;
                                    if (item.PaymentType != 'rent' || 'water' || 'electric') {
                                        // If PaymentType is "Others", display an input field with the value
                                        paymentTypeField = `<input type="text" class="form-control paymentType" data-detailsid="${item.paymentDetailsID}" id="inpt-paymentType-${index}" style="font-size: 15px; height: 39px" value="${item.PaymentType}" readonly />`;
                                    } else {
                                        // Otherwise, display a select dropdown
                                        paymentTypeField = `
                                            <select id="inpt-chargeType-${index}" name="paymentType" data-detailsid="${item.paymentDetailsID}" class="form-select paymentType" style="font-size: 15px; height: 40px">
                                                <option style="font-size: 15px;" disabled ${item.PaymentType ? 'selected' : ''}>Select Payment Type</option>
                                                <option style="font-size: 15px;" value="Rent" ${item.PaymentType === "rent" ? 'selected' : ''}>Rent</option>
                                                <option style="font-size: 15px;" value="Water" ${item.PaymentType === "water" ? 'selected' : ''}>Water</option>
                                                <option style="font-size: 15px;" value="Electric" ${item.PaymentType === "electric" ? 'selected' : ''}>Electric</option>
                                                <option style="font-size: 15px;" value="Others" ${item.PaymentType === "others" ? 'selected' : ''}>Others</option>
                                            </select>
                                        `;
                                    }

                                    // Create the new payment type form dynamically with the appropriate paymentTypeField
                                    var paymentRow = `
                                        <div class="mb-1">
                                            <div class="row align-items-start">
                                                <div class="col">
                                                    <label for="inpt-chargeType" class="form-label fw-bold" style="font-size: 14px">Payment Type</label>
                                                    ${paymentTypeField}
                                                </div>
                                                <div class="col">
                                                    <label for="inpt-amount-${index}" class="form-label fw-bold" style="font-size: 14px">Amount</label>
                                                    <input type="number" class="form-control inpt-amount" id="inpt-amount-${index}" style="font-size: 15px; height: 39px" value="${item.Amount}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inpt-dueDate-${index}" class="form-label fw-bold" style="font-size: 14px">Due Date</label>
                                            <input type="date" class="form-control editDueDate" id="inpt-dueDate-${index}" data-duedate="${item.DueDate}" style="font-size: 15px; height: 30px" value="${item.DueDate}">
                                        </div>
                                    `;

                                    // Append the new row to the paymentType-container
                                    $('#paymentType-container').append(paymentRow);
                                });
                            }
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' ' + error);
                    }
                });
                // Show the modal
                $self.$modalEdit.modal('show');
            },
            update: function(event) {
                const $self = this.config;
                const tenantID = $('#tenantName').data('tenantid');
                const totalRequests = $('#paymentType-container .mb-1').length; // Total number of rows to update
                let completedRequests = 0; // Counter for completed requests
                let hasError = false; // Track if any error occurs

                $('#paymentType-container .mb-1').each(function() {
                    const paymentDetailsID = $(this).find('.paymentType').data('detailsid');
                    const paymentType = $(this).find('.paymentType').val();
                    const amount = $(this).find('.inpt-amount').val();
                    const dueDate = $(this).closest('.mb-1').next('.mb-3').find('.editDueDate').val();

                    // Log parameters to debug
                    console.log('paymentDetailsID:', paymentDetailsID);
                    console.log('paymentType:', paymentType);
                    console.log('amount:', amount);
                    console.log('dueDate:', dueDate);

                    // Check if any required parameter is missing
                    if (!paymentDetailsID || !paymentType || !amount || !dueDate) {
                        console.warn("Missing required parameters: paymentDetailsID, paymentType, amount, or dueDate");
                        return; // Skip this iteration if a parameter is missing
                    }

                    // Send the update request using AJAX for each row
                    $.ajax({
                        url: '../controller/viewPaymentController.php',
                        type: 'PUT',
                        data: JSON.stringify({
                            paymentDetailsID: paymentDetailsID,
                            tenantID: tenantID,
                            dueDate: dueDate,
                            paymentType: paymentType,
                            amount: amount
                        }),
                        contentType: 'application/json',
                        dataType: 'json',
                        processData: false,
                        success: function(response) {
                            if (response.status !== 'success') {
                                hasError = true; // Set error flag if an error occurs
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ' + status + ' ' + error);
                            hasError = true; // Set error flag if AJAX fails
                        },
                        complete: function() {
                            completedRequests++; // Increment completed requests

                            // Show success alert only after all requests have completed
                            if (completedRequests === totalRequests) {
                                if (!hasError) {
                                    alert('All payment details updated successfully!');
                                } else {
                                    alert('Some payment details could not be updated. Please try again.');
                                }
                            }
                        }
                    });
                });
            }



        }
            rentalPaymentPage.Init({
                $tbody                      : $('#tbody'),
                $tbodyPaymentList           : $('#tbodyPaymentList'),
                $tenantName                 : $('#tenantName-container'),
                $modal                      : $('#modal'),
                $btn_pay                    : $('#btnPay'),
                $btn_partial                : $('#btn-partial'),
                $btn_fullpayment            : $('#btn-fullpayment'),
                $inpt_paymentType           : $('#inpt-paymentType'),
                $inpt_amount                : $('#inpt-amount'),
                $inpt_datePayment           : $('#inpt-datePayment'),
                $inpt_partialDatePayment    : $('#inpt-partialDatePayment'),
                $transactionModal           : $('#transactionModal'),
                $modalEdit                  : $('#modalEdit'),
                $sel_tenantName             : $('#sel-tenantName'),
                $btn_save                   : $('#btn-save')
            });
        });
    </script>
</body>
</html>
