<?php
            // Ensure that the search_results variable is available in this scope
            if (!isset($search_results)) {
                echo "Search results are not available.";
                exit;
            }

            // Check if there are any search results
            if (count($search_results) > 0) {
                echo "<h2>Search Results</h2>";
                echo "<ul>";
                // Iterate over each search result and display it
                foreach ($search_results as $result) {
                    echo "<button>" . htmlspecialchars($result['Id_NoSertif']) . "</button>";
                }
                echo "</ul>";
            } else {
                echo "<p>No results found for your search query.</p>";
            }
        ?>