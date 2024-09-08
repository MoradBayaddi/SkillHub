<?php
if(isset($_SESSION['email']))
{
    if ($_SESSION['role']==='client'){
       ?>
       <nav class="navbar container-lg d-md-none navbar-expand-lg navbar-light">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand px-0 mx-0 mx-lg-1" href="/index.html">
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


                <div
                    class="offcanvas-body mt-3 mt-lg-0 d-flex flex-column flex-lg-row justify-content-lg-end align-items-center p-3 px-lg-0">
                    
                    
                    <ul class="nav flex-column align-items-center ">
                        <li class="nav-item">
                            <a class="nav-link active" href="./dashboard.php">
                                Dashboard 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./profil.php">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./myJobs.php">
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
                    <ul class="navbar-nav align-items-center  ">
                        <li class="nav-item">
                            <a class="nav-link px-md-3" href="./jobs.php">Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-md-3" href="./contact.php">Contact</a>
                        </li>
                    </ul>
                    <div class="d-flex  flex-column flex-lg-row justify-content-end align-items-center gap-3">
                        <a class="btn-link me-lg-3" href="/pages/login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
       <?php
    } 
}
else{
    ?>
    <nav class="navbar container-lg d-md-none navbar-expand-lg navbar-light">
     <div class="container-fluid d-flex justify-content-between align-items-center">
         <a class="navbar-brand px-0 mx-0 mx-lg-1" href="/index.html">
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


             <div
                 class="offcanvas-body mt-3 mt-lg-0 d-flex flex-column flex-lg-row justify-content-lg-end align-items-center p-3 px-lg-0">
                 
                 
                 <ul class="nav flex-column align-items-center ">
                     <li class="nav-item">
                         <a class="nav-link active" href="./dashboard.php">
                             Dashboard 
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="./profil.php">
                             Profile
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="./myJobs.php">
                             My Jobs
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="./addJob.php">
                             Find a Job
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="./applications.php">
                             Applications
                         </a>
                     </li>
                     
                     
                 </ul>
                 <ul class="navbar-nav align-items-center  ">
                     <li class="nav-item">
                         <a class="nav-link px-md-3" href="./jobs.php">Jobs</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link px-md-3" href="./contact.php">Contact</a>
                     </li>
                 </ul>
                 <div class="d-flex  flex-column flex-lg-row justify-content-end align-items-center gap-3">
                     <a class="btn-link me-lg-3" href="/pages/login.html">Logout</a>
                 </div>
             </div>
         </div>
     </div>
 </nav>
    <?php
}
?>


