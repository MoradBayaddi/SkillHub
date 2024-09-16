<?php
if(isset($_SESSION['email']))
{
    // $worker_id= $_SESSION['user_id'];
    if ($_SESSION['role']==='client'){
        // check the user if is the post owner to show him the edite button
        $job_id=$_GET['job_id'];
        $user_id=$_SESSION['user_id'];

        include './includes/connectiondb.php';
        $query = "SELECT * FROM jobs WHERE job_id = ? and posted_by=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $job_id,$user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            ?>
            <div class="col-md-3 ">
                    <div class="card mb-4 shadow-small">
                        <div class="card-body text-center">
                            <a href="./editeJob.php?job_id=<?php echo $_GET['job_id']?>" 
                            class="btn btn-sec btn-lg w-100 mb-3">
                                <i class="fa fa-pen-to-square"></i> Edite</a>
                            <a href="#" class="btn btn-secondary btn-lg w-100 mb-3" id="share-button">
                                <i class="fa-solid fa-share"></i> Share</a>
                            <a href="#" class="btn btn-danger delete-job shadow-small btn-lg w-100">
                                <i class="fa-solid fa-trash"></i> Delete</a>
                        </div>
                    </div>
                </div>
            <?php
            
        }
        else{
            ?>
            <div class="col-md-3 ">
                    <div class="card mb-4 shadow-small">
                        <div class="card-body text-center">
                            
                            <a href="#" class="btn btn-secondary btn-lg w-100 mb-3" id="share-button">
                                <i class="fa-solid fa-share"></i> Share</a>
                            
                            
                        </div>
                    </div>
                </div>
            <?php
        }
            
        
    }
    else
    {
        ?>
        <div class="col-md-3">
                <div class="card mb-4 shadow-small">
                    <div class="card-body text-center">
                        
                        <a href="#" class="btn btn-secondary btn-lg w-100" id="share-button">
                            <i class="fa-solid fa-share"></i> Share</a>
                    </div>
                </div>
            </div>
        <?php
    }
}
else{
    ?>
    <div class="col-md-3">
            <div class="card mb-4 shadow-small">
                <div class="card-body text-center">
                    <a href="#" class="btn btn-secondary btn-lg w-100" id="share-button">
                        <i class="fa-solid fa-share"></i> Share</a>
                </div>
            </div>
        </div>
    <?php
}

?>
            