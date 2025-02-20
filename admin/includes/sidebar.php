<!-- Sidebar -->
<div id="sidebar" class="bg-dark text-white position-fixed vh-100">
    <!-- <h4 class="text-center mt-3">Admin Menu</h4> -->
    <ul class="nav flex-column text-start mt-3">
        <li class="nav-item">
            <a class="nav-link text-white" href="dashboard.php">🏠 Dashboard</a>
        </li>

        <!-- Dropdown for Manage Cars -->
        <li class="nav-item">
            <a class="nav-link text-white dropdown-toggle" href="#" id="carsDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#carsMenu">
                🚗 Manage Cars
            </a>
            <div class="collapse" id="carsMenu">
                <ul class="list-group bg-dark" style="list-style:none;">
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="add_car.php">➕ Add Car</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="list_cars.php">📋 List Cars</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="sold_cars.php">✅ Sold Cars</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="users.php">👤 Manage Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="reports.php">📊 Reports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-danger" href="authentication/logout.php">🚪 Logout</a>
        </li>
    </ul>
</div>
