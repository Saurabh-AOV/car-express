<?php
// session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Car Express</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        body {
            /* display: flex; */
            min-height: 100vh;
        }
        #sidebar {
            width: 250px;
            transition: 0.3s ease-in-out;
        }
        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
            margin-left: 250px; /* Default width of sidebar */
        }
        .logoutDesign:hover {
            background-color: white;
            padding: 5px;
            transition: 0.5s ease-in-out all;
        }
        /* Responsive Sidebar */
        @media (max-width: 768px) {
            #sidebar {
                width: 0;
                overflow: hidden;
            }
            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button -->
        <button class="btn btn-outline-light d-md-none" onclick="toggleSidebar()">☰</button>

        <a class="navbar-brand ms-2" href="dashboard.php">Car Express - Admin</a>
        

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="logoutDesign nav-link text-danger" href="authentication/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
