<?php 
include('./conn/conn.php'); 

// Protect this page – allow access only if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Dashboard</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/style.css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
    <style>
        /* Example inline style to hide video container initially */
        #videoContainer { display: none; margin-top: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand ml-5" href="home.php">User Registration and Login System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px; margin-left: 80%;">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        My Account
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Updated logout link to call the logout script -->
                        <li><a class="dropdown-item" href="endpoint/logout.php">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5 text-center">
        <?php 
            // Place video content on page
            $videoID = "dQw4w9WgXcQ";  // Video id link
        ?>
        <!-- Button to Show and Autoplay Video (just an example feature on the dashboard) -->
        <button class="btn btn-primary" onclick="showVideo()">Play YouTube Video</button>

        <!-- Video Container -->
        <div id="videoContainer">
            <iframe id="youtubeFrame" width="560" height="315" frameborder="0" allow="autoplay" allowfullscreen></iframe>
        </div>
    </div>

    <!-- JavaScript to Show and Autoplay Video -->
    <script>
        function showVideo() {
            let videoContainer = document.getElementById("videoContainer");
            let youtubeFrame = document.getElementById("youtubeFrame");
            let videoID = "<?php echo $videoID; ?>";
            // Set embed URL with autoplay
            let embedURL = "https://www.youtube.com/embed/" + videoID + "?autoplay=1&mute=0";
            youtubeFrame.src = embedURL;
            videoContainer.style.display = "block";
        }
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
