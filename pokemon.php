<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pokédex</title>
    <style>
      .container {
        display: flex;
        flex-direction: column;
        background-color: green;
        width: 100%;
        height: 100vh;
        align-items: center;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <form id="search-form" method="post" style="padding-top: 10%">
        <input
          type="text"
          name="poke-search"
          placeholder="Enter Pokémon name or ID"
        />
        <button type="submit">Search</button>
      </form>
      <div id="pokemon-container">
        <?php
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $query = strtolower($_POST['poke-search']);
            $url = "https://pokeapi.co/api/v2/pokemon/$query";
            $response = file_get_contents($url);
            if ($response) {
              $data = json_decode($response, true);
              echo "<div>";
              echo "<img src='" . $data['sprites']['front_default'] . "'>";
              echo "<h3>" . ucfirst($data['name']) . "</h3>";
              echo "<p>Type: " . implode(', ', array_map('ucfirst', array_column(array_column($data['types'], 'type'), 'name'))) . "</p>";
              echo "<p>Height: " . ($data['height'] / 10) . " m</p>";
              echo "</div>";
            } else {
              echo "<p>Error fetching Pokémon info</p>";
            }
          }
        ?>
      </div>
    </div>
  </body>
</html>
