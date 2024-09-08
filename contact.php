<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('./includes/links.php'); ?>
    <title>SkillHub</title>
</head>

<body class="">
    <?php include ('./includes/navbar.php');?>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-start flex-column  py-lg-5">
                    <img src="./img/worker2.jpg" class="img-fluid me-lg-auto my-auto d-none d-md-block w-75 img-secure rounded shadow-small" alt="">
                </div>
                <div class="col-md-6 py-5 d-flex flex-column justify-content-between">
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
    
                    

    <?php include('./includes/footer.php')?>
    <?php include('./includes/scriptlinks.php')?>
</body>

</html>