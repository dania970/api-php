<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>YouTube Search</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
      color: #333;
      background-color: #666;
    }

    h1 {
      margin-top: 40px;
      font-size: 2em;
      color: #444;
    }


    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }


    #search-form {
      display: flex;
      margin-bottom: 30px;
    }

    #search-form input[type="text"] {
      padding: 10px;
      width: 250px;
      border-radius: 5px;
      border: 1px solid #ddd;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    #search-form input[type="text"]:focus {
      border-color: #007BFF;
      outline: none;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    #search-form button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      background-color: #007BFF;
      color: white;
      font-size: 16px;
      cursor: pointer;
      margin-left: 10px;
      transition: background-color 0.3s ease;
    }

    #search-form button:hover {
      background-color: #0056b3;
    }


    #video-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }


    .video {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      width: 320px;
      transition: transform 0.3s ease;
    }

    .video img {
      width: 100%;
      height: auto;
      display: block;
    }

    .video h3 {
      font-size: 18px;
      margin: 15px;
      color: #007BFF;
    }

    .video p {
      font-size: 14px;
      margin: 0 15px 15px;
      color: #666;
    }

    .video:hover {
      transform: translateY(-10px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }


    @media (max-width: 768px) {
      #search-form {
        flex-direction: column;
        align-items: center;
      }

      #search-form input[type="text"],
      #search-form button {
        width: 100%;
        max-width: 300px;
        margin: 5px 0;
      }
    }

    @media (max-width: 480px) {
      .video {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>YouTube Video Search</h1>
    <form id="search-form" method="post">
      <input type="text" name="search-input" placeholder="Enter search term" required />
      <button type="submit" id="search-button">Search</button>
    </form>
    <div id="video-container">
      <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $query = urlencode($_POST['search-input']);
        $apiKey = "AIzaSyDI7igg3jfKJyXD4Tsu8Xe9yt0lVcOVFvU";
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=$query&key=$apiKey&maxResults=10";

        $response = file_get_contents($url);
        if ($response) {
          $data = json_decode($response, true);
          $videos = $data['items'];

          foreach ($videos as $video) {
            $title = htmlspecialchars($video['snippet']['title']);
            $description = htmlspecialchars($video['snippet']['description']);
            $thumbnailUrl = $video['snippet']['thumbnails']['medium']['url'];

            echo "<div class='video'>";
            echo "<img src='$thumbnailUrl' alt='$title'>";
            echo "<h3>$title</h3>";
            echo "<p>$description</p>";
            echo "</div>";
          }
        } else {
          echo "<p>Error fetching videos</p>";
        }
      }
      ?>
    </div>
  </div>
</body>

</html>