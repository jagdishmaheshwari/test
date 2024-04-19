
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medium Zoom Example</title>
    <!-- Include medium-zoom library -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/medium-zoom"></script>
    <!-- CSS for styling (optional) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/medium-zoom/dist/medium-zoom.min.css">
    <style>

       
    </style>
</head>
<body>
    <div class="gallery">
        <div class="row">
        <?php
        // Function to fetch image URLs from a webpage using cURL
        function fetchImageUrls($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $html = curl_exec($ch);
            curl_close($ch);

            // Parse the HTML to extract image URLs using regular expressions
            preg_match_all('/<img[^>]+src="([^"]+)"/i', $html, $matches);
            return $matches[1]; // Return array of image URLs
        }

        // Specify the URL of the webpage to scrape for images
        $webpage_url = 'https://alphatech-software.com/about/';

        // Fetch image URLs from the webpage
        $imageUrls = fetchImageUrls($webpage_url);

        // Display each image on the webpage
        foreach ($imageUrls as $imageUrl) {
            ?>

                <img src="<?php echo $imageUrl ?>" class="col-6 col-md-3" style="height:auto;" alt="Image from example.com"><br>
                <?php
        }
        ?>
    </div>
     </div>

    <script>
        // Initialize medium-zoom on all images within the gallery
        const zoom = mediumZoom('.gallery img');
    </script>
</body>
</html>