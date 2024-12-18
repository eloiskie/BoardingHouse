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
        <main class="content px-4 py-4">
    <div class="container-fluid bg-white">
        <div class="room-content p-2">
            <div class="row">
                <div class="d-md-flex"> <h3>Monthly Income Report</h3></div>
                <div class="input-group mb-3 align-items-center">
                    <label for="sel-house" class="form-label mb-1 pe-3">Month of:</label>
                    <input type="month" id="inpt-monthYear" name="monthYear" style="width : 280px">
                </div>
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Moth of</th>
                                    <th scope="col">House Location</th>
                                    <th scope="col">Monthly Income</th>
                                    <th scope="col">Generate</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
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

    const monthlyReportPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
            this.setDefaultDate();
        },
        BindEvents: function() {
            const $this = this.config;
            $this.$inpt_monthYear.on('change', this.specifyDate.bind(this));
            $this.$tbody.on('click', '#btn-generate', this.PDFgenerate.bind(this));
        },
        specifyDate: function() {
            const $self = this.config;
            const reportMonth = $self.$inpt_monthYear.val();
    
            if (reportMonth) {
                const [year, month] = reportMonth.split("-");
                $.ajax({
                    url: "../controller/monthlyReportController.php",
                    method: "POST", 
                    contentType: "application/json",
                    data: JSON.stringify({date: true, year: year, month: month }), 
                    dataType: "json",
                    success: function(response) { 
                        $self.$tbody.empty(); 

                        if (response.data.length === 0) { // Access data within response
                            $self.$tbody.append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                        } else {
                            $.each(response.data, function(index, item) {
                                const row = ` <tr class="text-capitalize" data-houseID="${item.houseID}">
                                    <td>${month} ${year}</td>
                                    <td> ${item.houselocation}</td>
                                    <td>${item.totalMonthlyIncome}</td>
                                    <td>
                                        <button type="button" style="width: 80px" class="btn btn-secondary" id="btn-generate" data-houseID="${item.houseID}">Generate</button>
                                    </td>
                                </tr>`
                                $self.$tbody.append(row);
                            });
                        }
                    },
                    error: function() {
                        alert("Error retrieving data.");
                    }
                });

            }
        },
        setDefaultDate: function() {
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Pad month with leading zero
                this.config.$inpt_monthYear.val(`${year}-${month}`);
                this.specifyDate(); // Trigger the specifyDate function to load the report for the current month
        },
        PDFgenerate: function(event) {
            const $self = this.config;
            const row = $(event.currentTarget).closest('tr');
            const houseID = row.data('houseid');
            const reportMonth = $self.$inpt_monthYear.val();
            const [year, month] = reportMonth.split("-");

            // Trigger PDF generation by calling the correct URL
            window.open(`../controller/monthlyReportController.php?houseID=${houseID}&year=${year}&month=${month}`, '_blank');
        }
    };

    monthlyReportPage.Init({
        $tbody              : $('#tbody'),
        $inpt_monthYear     : $('#inpt-monthYear')
    });
});
</script>
</body>
</html>

