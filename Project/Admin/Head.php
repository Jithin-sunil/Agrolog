<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['aid']) || empty($_SESSION['aid'])) {
    ?>
    <script>
        alert("Please login to continue");
        window.location = "../Guest/Login.php";
    </script>
    <?php
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agrolog</title>
    <link rel="shortcut icon" type="image/png" href="../Assets/Templates/Admin/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../Assets/Templates/Admin/assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="Homepage.php" class="text-nowrap logo-img">
                        <h3>Agrolog</h3>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>

                <!-- Sidebar navigation -->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="fa-solid fa-ellipsis-vertical nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Admin Menu</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="HomePage.php" aria-expanded="false">
                                <span><i class="fa-solid fa-house"></i></span>
                                <span class="hide-menu">Home</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="Category.php" aria-expanded="false">
                                <span><i class="fa-solid fa-list"></i></span>
                                <span class="hide-menu">Category</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="Tower.php" aria-expanded="false">
                                <span><i class="fa-solid fa-tower-broadcast"></i></span>
                                <span class="hide-menu">Tower</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="Product.php" aria-expanded="false">
                                <span><i class="fa-solid fa-box-open"></i></span>
                                <span class="hide-menu">Add Product</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="ViewRequest.php" aria-expanded="false">
                                <span><i class="fa-solid fa-clipboard-list"></i></span>
                                <span class="hide-menu">View Request</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="ViewComplaint.php" aria-expanded="false">
                                <span><i class="fa-solid fa-triangle-exclamation"></i></span>
                                <span class="hide-menu">View Complaints</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="Viewfeedback.php" aria-expanded="false">
                                <span><i class="fa-solid fa-comments"></i></span>
                                <span class="hide-menu">View Feedback</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- Sidebar End -->

        <!-- Main Wrapper -->
        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../Assets/Templates/Admin/assets/images/profile/user-1.jpg" alt=""
                                        width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">

                                        <a href="../Guest/Logout.php"
                                            class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">
