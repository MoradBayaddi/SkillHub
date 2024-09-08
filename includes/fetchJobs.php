<?php

// Database connection
include('connectiondb.php'); 

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 10; // Number of jobs per page
$offset = ($page - 1) * $limit;

// Fetch filter parameters
$location = isset($_POST['location']) ? $_POST['location'] : '';
$category = isset($_POST['category']) ? (int)$_POST['category'] : '';
$datePosted = isset($_POST['datePosted']) ? (int)$_POST['datePosted'] : '';
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';

// Construct the SQL query
$query = "SELECT * FROM jobs WHERE 1=1";

if ($location) {
    $query .= " AND location LIKE '%$location%'";
}
if ($category) {
    $query .= " AND categorie_id = $category";
}
if ($datePosted) {
    $dateCondition = "";
    switch ($datePosted) {
        case 1:
            $dateCondition = "AND DATE(created_at) >= CURDATE() - INTERVAL 1 DAY";
            break;
        case 2:
            $dateCondition = "AND DATE(created_at) >= CURDATE() - INTERVAL 7 DAY";
            break;
        case 3:
            $dateCondition = "AND DATE(created_at) >= CURDATE() - INTERVAL 30 DAY";
            break;
    }
    $query .= " $dateCondition";
}
if ($searchTerm) {
    $query .= " AND (title LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%')";
}

// Get the count of the filtered results
$countQuery = str_replace("SELECT *", "SELECT COUNT(*) as total", $query);
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalCount = $countRow['total'];

$query .= " LIMIT $limit OFFSET $offset";

// Execute the query
$result = mysqli_query($conn, $query);
$jobs = array();

while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row;
}

// Return jobs and count as JSON
echo json_encode(['jobs' => $jobs, 'totalCount' => $totalCount]);
?>