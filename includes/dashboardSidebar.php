<?php
if(isset($_SESSION['email']))
{
    if ($_SESSION['role']==='client'){
       ?>
       <nav class="col-md-2 d-none d-md-block sidebar-dashboard ">
                <div class="position-sticky">
                    <a class="navbar-brand " href="./index.php">
                        <img class="img-logo img-secure" src="./img/logo-dark.png" alt="">
                    </a>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="./dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./myjobs.php">
                                My Jobs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./addJob.php">
                                Post a Job
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./applications.php">
                                Applications
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
       <?php
    }
    else{
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./index.php"';
        echo '</script>';
    }
}
else{
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./login.php"';
        echo '</script>';
}
?>

