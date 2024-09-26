<?php
    $API_URL = "http://localhost:8006/api/v1/selection";

    //Fetching Data
    $response = file_get_contents( $API_URL );

    //Decode JSON
    $data = json_decode( $response, true );

    
    //Validating that Data Exists
    if ($data && is_array($data)) {
        //Building Table

        //Pagination
        $limit = 10;
        $totalRecords = count($data);
        $totalPages = ceil($totalRecords / $limit); //Calculation to Set Number of Pages Per Record

        //Capture Current Page. Also sets default page
        
        //Could be causing issues
       
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; //P instead of p

        //Calculate Starting Index of the Current Page
       if ($currentPage < 1) {
        $currentPage = 1;
       } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
       }
       
        $starIndex = ($currentPage - 1) * $limit;
        $pageData = array_slice($data, $starIndex, $limit);



        echo "<table border = '1' cellpadding='10'>";
       
        // <thead> not <thread>
        //echo "<thread>";

        echo "<thead>";
       
        echo "<tr>";
        echo "<th>id</th>";
        echo "<th>artist</th>";
        echo "<th>album</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        

        //Loop Through The Data
        foreach ($pageData as $post)
        {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($post['id']) ."</td>";
            echo "<td>" . htmlspecialchars($post['artist']) ."</td>";
            echo "<td>" . htmlspecialchars($post['album']) ."</td>";
        }

        echo "</tbody>";
        echo "</table>";

        echo "<div style='margin-top: 20px;'>";

        //Display Previous link if not on first page
        if ($currentPage > 1) {
            echo '<a href=?page=' . ($currentPage - 1) .'">Previous</a> ';
        }

        //Displaying Page Numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo "<strong> $i</strong";
        }
        else {
            echo '<a href=?page' . $i . '">' . $i . '</a> ';
        }

        //Next Page
        if ($currentPage < $totalPages) {
            //$currentPage + 1 not $currentPage - 1
            echo '<a href=?page=' . ($currentPage + 1) . '">Next</a> ';
        }
        echo "</div>";
    }
    } else {
        echo "Data isn't available or an error is occuring ";
    }
?>