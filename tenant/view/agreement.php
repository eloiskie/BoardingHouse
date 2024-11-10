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
                    <a class="sidebar-link" href="profile.php">
                        <i class="bi bi-people"></i>
                        Profile
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="payment.php">
                        <i class="bi bi-credit-card-2-front"></i>
                        Payment
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
    <title>Lease Agreement & Terms and Conditions</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1, h2 {
            color: #2c3e50;
        }
        p {
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .section {
            margin-bottom: 20px;
        }
        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
        }
        ul.b {
            font-size:1.5em;
            
        }
        p{
            margin: 10px 0;
            padding-left: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Lease Agreement & Terms and Conditions</h1>

    <div class="section">
        <ul class="b">• Lease Duration</ul>
        <p>The lease agreement is valid for a period of [insert duration] starting from [insert start date] to [insert end date].</p>
    </div>

    <div class="section">
        <ul class="b">• Rent Payment</ul>
        <p>The monthly rent is [insert amount], due on the [insert due date] of each month. Late payments will incur a fee of [insert fee].</p>
    </div>

    <div class="section">
        <ul class="b">• Security Deposit</ul>
        <p>A security deposit of [insert amount] is required prior to move-in. This deposit will be refunded upon termination of the lease, subject to conditions.</p>
    </div>

    <div class="section">
        <ul class="b">• Maintenance and Repairs</ul>
        <p>The landlord is responsible for maintaining the property in good condition. Tenants must report any issues promptly.</p>
    </div>

    <div class="section">
        <ul class="b">• Termination</ul>
        <p>Either party may terminate the lease with [insert notice period] written notice. Early termination may result in penalties.</p>
    </div>

    <div class="section">
        <ul class="b">• House Rules</ul>
        <p>All tenants are expected to follow the house rules, which include but are not limited to: no smoking, no pets, and maintaining cleanliness in common areas.</p>
    </div>

    <div class="section">
        <ul class="b">• Liability</ul>
        <p>The landlord is not responsible for personal injury or loss of personal property occurring on the premises.</p>
    </div>

    <footer>
        <p>&copy; 2024 [Your Boarding House Name]. All rights reserved.</p>
    </footer>
</div>

</body>
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

    const agreementPage = {
        Init: function(config) {
            this.config = config;
            this.BindEvents();
         
        },
        BindEvents: function() {
            const $this = this.config;
           
        },
     
       

    }

    agreementPage.Init({
    
    });
});


    </script>
</body>
</html> 