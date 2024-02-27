<?php
        session_start();

        // Check if the user is logged in, otherwise redirect to login page
        if (!isset($_SESSION['username'])) {
            header("location:login.html?pesan=belum_login");
            exit;
        }

        // Include database connection file
        include 'koneksi.php';

        // Retrieve search query from the GET request
        $search_query = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, $_GET['q']) : '';

        // Initialize an array to store search results
        $search_results = [];

        // Check if the search query is not empty
        if ($search_query !== '') {
            // Search query to find matching records in the sertifikat table
            $query = "SELECT * FROM sertifikat WHERE Id_NoSertif LIKE '%$search_query%'";
            
            // Execute the query
            $result = mysqli_query($koneksi, $query);
            
            // Fetch all matching records and store them in the search_results array
            while ($row = mysqli_fetch_assoc($result)) {
                $search_results[] = $row;
            }
        }

        // Include a view file to display the search results (create a separate view file for this)
        include 'search_results_view.php';
        ?>