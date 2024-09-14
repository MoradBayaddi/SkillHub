<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('./includes/links.php'); ?>
    
    <title>SkillHub</title>
</head>

<body  class="">
    <?php include ('includes/navbar.php');?>
    <!-- hero section -->
    <div  
        data-aos-once="true"
        data-aos="fade-down"
        data-aos-easing="linear"
        data-aos-duration="500"
     class="hero container mb-5 mt-lg-2 p-3 p-lg-5">
        <div class="row d-flex align-items-center">
            <div class="col-md-6 d-flex flex-column gap-lg-5 pb-5 py-lg-1 justify-content-lg-around">
                <h3 data-aos-once="true"
                    data-aos="fade-down"
                    data-aos-easing="ease"
                    data-aos-duration="1000" 
                >Connect with Skilled Tradespeople Anytime, Anywhere</h3>
                <p  data-aos-once="true"
                    data-aos="fade-right"
                    data-aos-easing="ease"
                    data-aos-duration="1200" 
                class="fs-5 ">
                    Welcome to SkillHub, your go-to platform for finding reliable handworkers. From quick repairs to
                    major projects, our skilled professionals in plumbing, construction, electrical work, and more are
                    here to help.
                </p>
                <div    
                 class="d-flex gap-3">
                 
                 <?php
                 if (!isset($_SESSION['email'])){
                    ?>  
                    <a href="./register.php" class="btn shadow-small btn-sec">Register</a>
                    <a href="./jobs.php" class="btn shadow-small btn-sec">Explore Jobs</a>

                    <?php
                 }
                 else{
                    if($_SESSION['role']==='worker'){
                        ?>
                        <a href="./jobs.php" class="btn shadow-small btn-sec">Find Jobs</a>
                        <?php
                    }
                else{
                    ?>
                        <a href="./dashboard.php" class="btn shadow-small btn-sec">Go to Dashboard</a>
                        <?php
                }
                    
                 }
                 ?>
                
                
                </div>
            </div> 
            <div 
                    data-aos-once="true"
                    data-aos="fade-left"
                    data-aos-easing="ease"
                    data-aos-duration="1500"
                    class="col-md-6  d-flex justify-content-center justify-content-md-end ">
                <img class="image-hero img-secure floating-image" src="img/mecanic.jpg" alt="">
            </div>
        </div>
    </div>



    <!-- <div id="content-area">
    </div> -->
    <!-- how it works -->
    <section  id="how-it-works" class="py-5 ">
        <div class="container">
            <h2 class="text-center text-uppercase mb-5">How SkillHub Works</h2>
            <div class="row">
                <div data-aos="fade-right"
                     data-aos-once="true"
                     data-aos-easing="ease-in-sine"
                class="col-lg-4 mb-5 mb-lg-1 align-items-start gap-2  d-flex justify-content-between flex-column">
                    <h3 class="text-primary">For Handworkers</h3>
                    <p>Find and apply for handworking jobs that match your skills.</p>

                    <div>
                        <li class="text-secondary ">Create a profile</li>
                        <li class="text-secondary ">Browse job listings</li>
                        <li class="text-secondary ">Apply for jobs</li>
                        <li class="text-secondary ">Get hired and complete jobs</li>
                    </div>
                    <?php
                 if (!isset($_SESSION['email'])){
                    ?>  
                    <a href="./jobs.php" class="btn shadow-small btn-sec">Explore Jobs</a>
                    <?php
                 }
                 ?>
                </div>
                <div data-aos="fade-down" 
                 
                data-aos-duration="1000" 
                data-aos-offset="150"
                class="col-lg-4  mb-5 mb-lg-1 align-items-start d-flex justify-content-between flex-column">
                    <img class="img-secure img shadow-small floating-image" src="img/woman1.jpg" alt="">
                </div>
                <div data-aos="fade-left"
                     data-aos-once="true"
                     data-aos-easing="ease-in-sine"
                class="col-lg-4  mb-5 mb-lg-1 align-items-start gap-2  d-flex justify-content-between flex-column">
                    <h3 class="text-primary">For Clients</h3>
                    <p>Post jobs and hire skilled handworkers for your projects.</p>

                    <div>
                        <li class="text-secondary ">Create a job posting</li>
                        <li class="text-secondary ">Review handworker profiles</li>
                        <li class="text-secondary ">Hire and manage jobs</li>
                        <li class="text-secondary ">Provide feedback</li>
                    </div>
                    <?php
                 if (!isset($_SESSION['email'])){
                    ?>  
                    <a href="./addJob.php" class="btn shadow-small btn-sec">Post Jobs</a>
                    <?php
                 }
                 ?>
                </div>

            </div>
        </div>

    </section>

    <section id="find-handworker" class="parallax-section text-white py-5">
        <div class="container text-center">
            <h2 class="display-4 mb-4">Find the Right Handworker for Your Needs</h2>
            <p class="lead mb-4">Plumbers, construction experts, electricians, and more. Connect with the right professional for any task.</p>
            <p class="lead">15K+ Skills represented by handworkers on SkillHub</p>
        </div>
    </section>

    

        <div class="container-fluid px-5 ">


                <section id="popular-jobs" class="container py-5">
    <h2 class="text-center mb-4">Most Popular Jobs</h2>
        
        <div class="row">
            <!-- First Job --> 
            <div class="col-md-6 col-lg-3 col-sm-6 mb-4">
                <a href="./jobs.php">
   
                </a>
                <div class="card">
                    <img src="./img/plumber1.jpg" class="card-img-top img-secure" alt="Plumber">
                    <div class="card-body text-center">
                        <h5 class="card-title">Plumber</h5>
                        <p class="card-text">Expert plumbing services for homes and businesses.</p>
                    </div>
                </div>
            </div>
            <!-- Second Job --> 
            <div class="col-md-6 col-lg-3 col-sm-6 mb-4">
                <a href="./jobs.php">
    
                 </a>
                <div class="card">
                    <img src="./img/electrician.jpg" class="card-img-top img-secure" alt="Electrician">
                    <div class="card-body text-center">
                        <h5 class="card-title">Electrician</h5>
                        <p class="card-text">Qualified electricians for all your electrical needs.</p>
                    </div>
                </div>
            </div>
            <!-- Third Job --> 
            <div class="col-md-6 col-lg-3 col-sm-6 mb-4">
                <a href="./jobs.php">
   
                </a>
                <div class="card">
                    <img src="./img/carpenter.jpg" class="card-img-top img-secure" alt="Carpenter">
                    <div class="card-body text-center">
                        <h5 class="card-title">Carpenter</h5>
                        <p class="card-text">Skilled carpentry for furniture, repairs, and more.</p>
                    </div>
                </div>
            </div>
            <!-- Fourth Job --> 
            <div class="col-md-6 col-lg-3 col-sm-6 mb-4">
                <a href="./jobs.php">
   
                </a>
                <div class="card">
                    <img src="./img/mechanic.jpg" class="card-img-top  img-secure" alt="Mechanic">
                    <div class="card-body text-center">
                        <h5 class="card-title">Mechanic</h5>
                        <p class="card-text">Professional automotive repairs and maintenance.</p>
                    </div>
                </div>
            </div>
        </div> 
        
    </section>
        </div>
    


    <!-- <section class="testimonial-slider  py-5">
        <div class="container-lg container-fluid">
            <h2 class="text-uppercase text-center mb-lg-5 mb-5">What our Clients say</h2>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">


                <div class="carousel-item active">
                        <div class="d-flex justify-content-center">
                            <div class="row d-flex justify-content-lg-center">
                                <div class="col-lg-4 col-sm-6 mb-5 mb-lg-2">
                                    <div class="testimonial-card text-center p-3 mx-2">
                                        <img src="./img/woman1.jpg" 
                                        alt="">
                                        <p class="testimonial-text">"Thanks to SkillHub, I found an electrician quickly
                                            and efficiently."</p>
                                        <h6 class="testimonial-author">- Jane Doe, Homeowner</h6>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 mb-2 mb-lg-5">
                                    <div class="testimonial-card text-center p-3 mx-2">
                                        <img src="./img/hero-worker1.jpg" alt="">
                                        <p class="testimonial-text">"SkillHub made finding a reliable plumber a breeze.
                                            Highly
                                            recommend!"</p>
                                        <h6 class="testimonial-author">- Jane Doe, Homeowner</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 mb-2 mb-lg-5">
                                    <div class="testimonial-card text-center p-3 mx-2">
                                        <img src="./img/worker2.jpg" alt="">
                                        <p class="testimonial-text">"Thanks to SkillHub, I found an electrician quickly
                                            and efficiently."</p>
                                        <h6 class="testimonial-author">- Jane Doe, Homeowner</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item ">
                        <div class="d-flex justify-content-center">
                            <div class="row d-flex justify-content-lg-center">
                                <div class="col-lg-4 col-sm-6 mb-5 mb-lg-2">
                                    <div class="testimonial-card text-center p-3 mx-2">
                                        <img src="./img/woman1.jpg" 
                                        alt="">
                                        <p class="testimonial-text">"Thanks to SkillHub, I found an electrician quickly
                                            and efficiently."</p>
                                        <h6 class="testimonial-author">- Jane Doe, Homeowner</h6>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 mb-2 mb-lg-5">
                                    <div class="testimonial-card text-center p-3 mx-2">
                                        <img src="./img/hero-worker1.jpg" alt="">
                                        <p class="testimonial-text">"SkillHub made finding a reliable plumber a breeze.
                                            Highly
                                            recommend!"</p>
                                        <h6 class="testimonial-author">- Jane Doe, Homeowner</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 mb-2 mb-lg-5">
                                    <div class="testimonial-card text-center p-3 mx-2">
                                        <img src="./img/worker2.jpg" alt="">
                                        <p class="testimonial-text">"Thanks to SkillHub, I found an electrician quickly
                                            and efficiently."</p>
                                        <h6 class="testimonial-author">- Jane Doe, Homeowner</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section> -->
    
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-center flex-column  py-lg-5">
                    <img src="./img/worker2.jpg" class="img-fluid m-auto  w-75 img-secure rounded shadow-small" alt="">
                </div>
                <div class="col-md-6 p-5 d-flex flex-column justify-content-between">
                    <h2>Contact</h2>
                    <form action="" class="d-flex flex-column justify-content-between">
                        <input class="my-2" placeholder="Name" type="text" name="name" id="name">
                        <input class="my-2" type="text" placeholder="E-mail" name="email" id="email">
                        <textarea class="my-2" placeholder="Your Message" name="message" id="message" cols="30"
                            rows="8"></textarea>
                        <button class="btn-primary shadow-small  btn">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


   <?php include ('./includes/footer.php');?>




    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://kit.fontawesome.com/f7066038ac.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
        
    <script src="script.js"></script>
    <script>
        AOS.init();
        
    </script>
</body>

</html>