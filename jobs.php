<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('./includes/links.php')?>
    <title>SkillHub Jobs Page</title>
</head>

<body class="">
    <!-- navbar -->
    <?php include ('./includes/navbar.php')?>

    <div class="container-lg container-fluid mt-4">
        <div class="row jobs-container">
            <!-- Sidebar for Filters -->
            <aside class="col-md-3 filter-section bg-accent rounded mb-5">
                <h5>Filter Jobs</h5>

                <!-- Location Filter -->
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" placeholder="Enter location">
                </div>

                <!-- Category Filter -->
                
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" aria-label="Category select">
                    <option selected>All Jobs</option>
                        <?php
                        // Include the database connection file
                        include('./includes/connectiondb.php');

                        

                        // Query to fetch categories
                        $query = "SELECT * FROM `categories`";
                        $query_run = mysqli_query($conn, $query);

                        // Check if the query was successful
                        if (!$query_run) {
                            die('Query failed: ' . mysqli_error($conn));
                        }

                        // Loop through the results and populate the select options
                        while ($row = mysqli_fetch_array($query_run)) {
                            $categorie_id = htmlspecialchars($row['categorie_id'], ENT_QUOTES, 'UTF-8');
                            $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                            echo "<option value=\"$categorie_id\">$name</option>";
                        }

                        // Close the database connection
                        mysqli_close($conn);
                        ?>
                    </select>
                </div>


                <!-- Date Posted Filter -->
                <div class="mb-3">
                    <label class="form-label">Date Posted</label>
                    <select class="form-select" aria-label="Date posted select">
                        <option selected>Anytime</option>
                        <option value="1">Last 24 hours</option>
                        <option value="2">Last 7 days</option>
                        <option value="3">Last 30 days</option>
                    </select>
                </div>
            </aside>

            <!-- Job Listings -->
            <section class="col-md-9 mb-5">
            
            <form class="input-group mb-3" id="job-search-form">
                <input type="text" class="form-control" id="search-input" placeholder="Search for jobs..." aria-label="Search jobs">
                <button class="btn btn-sec" type="button" id="search-button">Search</button>
            </form>
                <h4 id="results-count" class="mb-3 text-primary"></h4>
                <div class="row" id="job-cards">
                   
                </div>
                
            <div class="text-center mt-4">
                <button id="load-more" class="btn btn-primary">Show More Jobs</button>
            </div>
            </section>

        </div>
    </div>

   <?php include ('./includes/footer.php')?>

   <!-- <a href="#" class="btn btn-primary px-3">Apply Now</a> -->



    <script src="https://kit.fontawesome.com/f7066038ac.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
        <script>
   $(document).ready(function() {
    function loadJobs(page = 1, filters = {}) {
        $.ajax({
            url: './includes/fetchJobs.php',
            method: 'POST',
            data: {
                page: page,
                location: filters.location || '',
                category: filters.category || '',
                datePosted: filters.datePosted || '',
                searchTerm: filters.searchTerm || ''
            },
            success: function(response) {
                const result = JSON.parse(response);
                const jobs = result.jobs;
                const totalCount = result.totalCount;

                let jobCards = '';
                jobs.forEach(function(job) {
                    jobCards += `
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">${job.title}</h5>
                                    <p class="card-text">${job.description}</p>
                                    <p class="card-location text-accent"><strong>${job.location}</strong> </p>
                                </div>
                                <div class="card-footer d-flex">
                                    <?php
                                    if(isset($_SESSION['role'])){
                                        if($_SESSION['role']==='worker'){
                                            ?>
                                            <a href="./jobPage.php?job_id=${job.job_id}&worker_id=<?php echo $_SESSION['user_id'];?>" class="btn mx-0 px-0 btn-link">More Details</a>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <a href="./jobPage.php?job_id=${job.job_id}" class="btn mx-0 px-0 btn-link">More Details</a>
                                            <?php
                                        }
                                        
                                    }
                                    else{
                                        ?>
                                        <a href="./jobPage.php?job_id=${job.job_id}" class="btn mx-0 px-0 btn-link">More Details</a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    `;
                });

                if (page === 1) {
                    $('#job-cards').html(jobCards); // Replace current jobs with new jobs
                } else {
                    $('#job-cards').append(jobCards); // Append new jobs
                }

                if (jobs.length < 10) {
                    $('#load-more').hide(); // Hide button if no more jobs
                } else {
                    $('#load-more').show(); // Show button if more jobs available
                }

                $('#results-count').text(`${totalCount} Jobs found`);
            }
        });
    }

    function applyFilters() {
    const filters = {
        location: $('#location').val(),
        category: $('select[aria-label="Category select"]').val(),
        datePosted: $('select[aria-label="Date posted select"]').val(),
        searchTerm: $('#search-input').val()
    };
    
    $('#job-cards').html(''); // Clear existing jobs
    loadJobs(1, filters); // Load jobs with new filters
}

    
    // Apply filters when the search button is clicked
    $('#search-button').on('click', function() {
        applyFilters();
    });

    // filter in real time: (on input or change)
    $('#search-input').on('input', function() {
        applyFilters();
    });
    $('#location').on('input', function() {
        applyFilters();
    });
    $('select[aria-label="Category select"]').on('change', function() {
        applyFilters();
    });
    $('select[aria-label="Date posted select"]').on('change', function() {
        applyFilters();
    });

    // Load more jobs with pagination
    $('#load-more').on('click', function() {
        const currentPage = $(this).data('page') || 1;
        const nextPage = currentPage + 1;
        $(this).data('page', nextPage);
        const filters = {
            location: $('#location').val(),
            category: $('select[aria-label="Category select"]').val(),
            datePosted: $('select[aria-label="Date posted select"]').val(),
            searchTerm: $('#search-input').val()
        };
        loadJobs(nextPage, filters);
    });

    // Initial load of jobs
    loadJobs();
});

        </script>


</body>

</html>