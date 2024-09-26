<?php
// API URL
$apiUrl = "http://localhost:8006/api/v1/selection";

//Fetch data from the API
$response = file_get_contents($apiUrl);

$currentPage = isset($_GET['Page']) ? (int)$_GET['page'] : 1;

// Decode JSON response into an array
$data = json_decode($response, true);

// Check if data is available
if ($data && is_array($data))
{
    //Pagination Setup
    $limit = 10; //Number of posts per page
    $totalRecords = count($data); //Total Number of Records
    $totalPages = ceil($totalRecords / $limit); //Calculate Total Pages

    // Get the current page is within valid range
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    //Calculate the starting index of the current page
    $startIndex = ($currentPage -1) * $limit;

    // Get the subset of data for the current page
    $pageData = array_slice($data, $startIndex, $limit);

    //Display data in a GridView (HTML Table)
    echo "<table border='1' cellpadding='10'>";
    echo "<thead";
    echo "<tr>";
    echo "<th>id</th>";
    echo "<th>artist</th>";
    echo "<th>album</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    //Loop through the data and display each post
    foreach ($pageData as $post) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($post['id']) ."</td>";
        echo "<td>" . htmlspecialchars($post['artist']) ."</td>";
        echo "<td>" . htmlspecialchars($post['album']) ."</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table";

    //Pagination Links
    echo "<div style='margin-top: 20px;'>";

    //Display "Previous" link if not on the first page
    if ($currentPage > 1) {
        echo '<a href="?page=' . ($currentPage - 1) . '"> Previous</a>';
    }

    //Display page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            echo "<strong>$i</strong> ";
        } else {
            echo '<a href="?page=' . $i . ' ">' . $i . ' </a> ';
        }
    }

    //Display "Next" link if not on the last page
    if($currentPage < $totalPages) {
        echo '<a href="?page=' . ($currentPage + 1) . '"> Next</a>';

echo "</div>";
        } else {
            echo "No data available.";
        }    
    }
?>