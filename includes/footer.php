<section id="footer" class="bg-black text-white">
    <div class="container py-5 px-lg-0 px-5">
        <div class="row d-flex align-items-start">
            <div class="col-md-6">
                <a href=""><img src="./img/logo-dark.png" class="img-fluid mb-4" alt=""></a>
                <p class="mt-2">SkillHub connects clients with skilled handworkers for reliable and efficient service. Find the right professional for any project with ease.</p>
            </div>
            <div class="col-md-3">
                <h4 class="text-white mt-lg-0 mt-3 mb-4">Navigation</h4>
                <?php
                if(isset($_SESSION['user_id'])){
                    if($_SESSION['role']==='worker'){
                ?>
                <div class="d-flex gap-1 flex-column justify-content-between">
                    <a class="link" href="./">Home</a>
                    <a class="link" href="./profile.php">Profile</a>
                    <a class="link" href="./jobs.php">Find A Work</a>
                    <a class="link" href="./applications.php">My Applications</a>
                    <a class="link" href="./contact.php">Contact</a>
                    <a class="link" href="./logout.php">Logout</a>
                </div>
                <?php
                    } else {
                ?>
                <div class="d-flex flex-column justify-content-between">
                    <a class="link" href="./">Home</a>
                    <a class="link" href="./profile.php">Profile</a>
                    <a class="link" href="./dashboard.php">Dashboard</a>
                    <a class="link" href="./addJob.php">Post A Job</a>
                    <a class="link" href="./jobs.php">Jobs</a>
                    <a class="link" href="./applications.php">Applications</a>
                    <a class="link" href="./contact.php">Contact</a>
                    <a class="link" href="./logout.php">Logout</a>
                </div>
                <?php
                    }
                } else {
                ?>
                <div class="d-flex flex-column justify-content-between">
                    <a class="link" href="./">Home</a>
                    <a class="link" href="./jobs.php">Jobs</a>
                    <a class="link" href="./login.php">Sign In</a>
                    <a class="link" href="./register.php">Create an Account</a>
                    <a class="link" href="">About</a>
                    <a class="link" href="./contact.php">Contact</a>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="col-md-3 mt-lg-0 mt-3">
                <h4 class="text-white mb-4">Contact</h4>
                <div class="d-flex flex-column justify-content-between">
                    <a class="link mb-3" href="mailto:m.bayaddi@gmail.com?subject=Service Inquiry&body=Hello, I am interested in your services.">
                        <i class="fa-regular fa-envelope icon text-white me-3"></i>m.bayaddi@gmail.com
                    </a>
                    <a class="link" href="tel:+212695588774">
                        <i class="fa-solid fa-phone icon text-white me-3"></i>+212 695-588-774
                    </a>
                </div>
                <div class="d-flex gap-3 justify-content-lg-between my-3">
                    <a href="" class="fa-brands fa-instagram icon"></a>
                    <a href="" class="fa-brands fa-facebook icon"></a>
                    <a href="" class="fa-brands fa-x-twitter icon"></a>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-4 container">
    <div class="container text-center py-3">
        <p class="mb-0">&copy; 2024 SkillHub. All rights reserved.</p>
        <p class="mb-0">Made by <a href="https://github.com/MoradBayaddi" target="_blank" class="text-white">Yami</a>.</p>
    </div>
</section>
