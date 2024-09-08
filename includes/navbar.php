<!-- navbar -->
<nav class="navbar container-lg navbar-expand-lg navbar-light">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand px-0 mx-0 mx-lg-1" href="./index.php">
                <img class="img-logo img-secure" src="./img/logo.png" alt="">
            </a>
            <button class="navbar-toggler shadow-none border-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon  "></span>
            </button>
            <div class="sidebar offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title fs-2" id="offcanvasNavbarLabel">SkillHub</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>



                <?php
if(isset($_SESSION['email'])) {
    if ($_SESSION['role'] === 'worker'){  // Corrected here
        ?>
        <!-- worker navbar -->
        <div class="offcanvas-body mt-3 mt-lg-0 d-flex flex-column flex-lg-row justify-content-lg-end align-items-center p-3 px-lg-0">
            <ul class="navbar-nav justify-content-lg-end align-items-center  pe-lg-3">
                <li class="nav-item">
                    <a class="nav-link px-md-3" href="./jobs.php">Find Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-md-3" href="./appliedJobs.php">My Applications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-md-3" id="contactbtn" href="./contact.php">Contact</a>
                </li>
            </ul>
            <div class="d-flex flex-column flex-lg-row justify-content-end align-items-center gap-3">
                <a class="btn-link me-lg-3" href="./includes/logout.php">Logout</a>
                <a class="btn-primary shadow-large" href="./profile.php">Profile</a>
            </div>
        </div>
        <?php
    } else {
        ?>
        <!-- client navbar -->
        <div class="offcanvas-body mt-3 mt-lg-0 d-flex flex-column flex-lg-row justify-content-lg-end align-items-center p-3 px-lg-0">
            <ul class="navbar-nav justify-content-lg-end align-items-center  pe-lg-3">
                <li class="nav-item">
                    <a class="nav-link px-md-3" href="./dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-md-3" aria-current="page" href="./jobs.php">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-md-3" href="./addJob.php">Post Jobs</a>
                </li>                
                <li class="nav-item">
                    <a class="nav-link px-md-3" id="contactbtn" href="./myJobs.php">My Jobs</a>
                </li>
            </ul>
            <div class="d-flex flex-column flex-lg-row justify-content-end align-items-center gap-3">
                <a class="btn-link me-lg-3" href="./includes/logout.php">Logout</a>
                <a class="btn-primary shadow-large" href="./profile.php">Profile</a>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <!-- not connected navbar -->
    <div class="offcanvas-body mt-3 mt-lg-0 d-flex flex-column flex-lg-row justify-content-lg-end align-items-center p-3 px-lg-0">
        <ul class="navbar-nav justify-content-lg-end align-items-center  pe-lg-3">
            <li class="nav-item">
                <a class="nav-link px-md-3" href="./jobs.php">Jobs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-md-3" href="#">About</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-md-3" id="contactbtn" href="./contact.php">Contact</a>
            </li>
        </ul>
        <div class="d-flex flex-column flex-lg-row justify-content-end align-items-center gap-3">
            <a class="btn-link me-lg-3" href="./login.php">Login</a>
            <a class="btn-primary shadow-large" href="./register.php">Sign up</a>
        </div>
    </div>
    <?php
}
?>

                
            </div>
        </div>
    </nav>











