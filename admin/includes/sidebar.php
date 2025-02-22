<style>
    .nav-link:hover {
        background-color:#007bff ;
        color: #f0f0f0; /* Light gray background n hover */
    }
</style>


<!-- Sidebar -->
<div id="sidebar" class="bg-dark text-white position-fixed mb-5" style="overflow-y: auto; height: calc(100vh - 100px);top: 56px;">
    <ul class="nav flex-column text-start mt-3">
        <li class="nav-item">
            <a class="nav-link text-white" href="<?= BASE_URL ?>dashboard.php"><i class="fa fa-dashboard" style="font-size:18px; margin-right:6px;"></i> Dashboard</a>
        </li>

        <!-- Dropdown for Manage Users -->
        <li class="nav-item">
            <a class="nav-link text-white dropdown-toggle" id="carsDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#userMenu">
                <i class="fa fa-user" style="font-size:18px; margin-right:6px;" aria-hidden="true"></i> Users
            </a>
            <div class="collapse" id="userMenu">
                <ul class="list-group bg-dark" style="list-style:none;">
                    <!-- <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="add_car.php">➕ Add Car</a></li> -->
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>users/list.php"><i class="fa fa-address-book" style="font-size:18px; margin-right:6px;"></i> List</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>users/edit.php"><i class="fa fa-edit" style="font-size:18px; margin-right:6px;"></i> Edit</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>users/user_detail.php"><i class="fa fa-eye" style="font-size:18px; margin-right:6px;"></i> Profile</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>users/delete.php"><i class="fa fa-trash" style="font-size:18px; margin-right:6px;"></i> Delete</a></li>
                </ul>
            </div>
        </li>

        <!-- Dropdown for Manage Cars -->
        <li class="nav-item">
            <a class="nav-link text-white dropdown-toggle" href="#" id="carsDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#carsMenu">
                <i class="fa fa-car" style="font-size:18px; margin-right:6px;"></i> Listings
            </a>
            <div class="collapse" id="carsMenu">
                <ul class="list-group bg-dark" style="list-style:none;">
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>cars/add.php"><i class="fa fa-plus" style="font-size:18px; margin-right:6px;"></i> Add Car</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>cars/list.php"><i class="fa fa-list" style="font-size:18px; margin-right:6px;"></i> List</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>cars/edit.php"><i class="fa fa-edit" style="font-size:18px; margin-right:6px;"></i> Edit</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>cars/delete.php"><i class="fa fa-trash" style="font-size:18px; margin-right:6px;"></i> Delete</a></li>
                </ul>
            </div>
        </li>


        <!-- Dropdown for Manage Cars -->
        <li class="nav-item">
            <a class="nav-link text-white dropdown-toggle" href="#" id="carsDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#categoryMenu">
                <i class="fa fa-list-alt" style="font-size:18px; margin-right:6px;"></i> Categories
            </a>
            <div class="collapse" id="categoryMenu">
                <ul class="list-group bg-dark" style="list-style:none;">
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>categories/brand/list.php"><i class="fa fa-list" style="font-size:18px; margin-right:6px;"></i> Brand</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>categories/model/list.php"><i class="fa fa-list" style="font-size:18px; margin-right:6px;"></i> Model</a></li>
                </ul>
            </div>
        </li>
        <!-- Dropdown for Manage Cars -->
        <li class="nav-item">
            <a class="nav-link text-white dropdown-toggle" href="#" id="carsDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#addressMenu">
                <i class="fa fa-address-card" style="font-size:18px; margin-right:6px;"></i> Address
            </a>
            <div class="collapse" id="addressMenu">
                <ul class="list-group bg-dark" style="list-style:none;">
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>location/city.php"><i class="fa fa-list" style="font-size:18px; margin-right:6px;"></i> City</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>location/state.php"><i class="fa fa-list" style="font-size:18px; margin-right:6px;"></i> State</a></li>
                </ul>
            </div>
        </li>

        <!-- Dropdown for Manage Cars -->
        <li class="nav-item">
            <a class="nav-link text-white dropdown-toggle" href="#" id="carsDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#languageMenu">
                <i class="fa fa-language" style="font-size:18px; margin-right:6px;"></i> Language
            </a>
            <div class="collapse" id="languageMenu">
                <ul class="list-group bg-dark" style="list-style:none;">
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>language/list.php"><i class="fa fa-list" style="font-size:18px; margin-right:6px;"></i> Language list</a></li>
                    <li><a class="list-group-item list-group-item-action bg-dark text-white border-0" href="<?= BASE_URL ?>language/add-language.php"><i class="fa fa-plus" style="font-size:18px; margin-right:6px;"></i> Add Language</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-danger" href="../authentication/logout.php"><i class="fa fa-solid fa-sign-out">‌</i> Logout</a>
        </li>
    </ul>
</div>