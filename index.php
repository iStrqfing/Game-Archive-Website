<?php
function writeCard($card)
{
  $gameData = htmlspecialchars(implode("|", $card));
  $gameKeys = htmlspecialchars(implode("|", array_keys($card)));

  echo "<div class='game-card'>";
  echo "<div class='game-row'>";
  echo "<div class='card-icon-img-container'>";
  echo "<img class='game-icon-img' alt='Game Image' src='{$card['filepath']}'>";
  echo "</div>";
  echo "<div class='card-content-container'>";
  echo "<h3>{$card['title']}</h3>";
  echo "<p>";
  echo "<span class='item-header'>Developed by: </span>{$card['developer']}<br>";
  echo "<span class='item-header'>Released: </span>{$card['release_date']}<br>";
  echo "<span class='item-header'>Platforms: </span>{$card['platforms']}<br>";
  echo "<span class='item-header'>Setting: </span>{$card['setting']}<br>";
  echo "</p>";
  echo "<form action='content/game.php' method='post'>";
  echo "<input type='hidden' name='game' value='$gameData'>";
  echo "<input type='hidden' name='gameKeys' value='$gameKeys'>";
  echo "<button class='btn-styling' type='submit'>";
  echo "Details";
  echo "</button>";
  echo "</form>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

function writeBlank()
{
  echo "<div class='game-card'>";
  echo "<div class='game-row'>";
  echo "<div class='card-icon-img-container'>";
  echo "</div>";
  echo "<div class='card-content-container'>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
//Function sorts the games array based on the name given ie 'developer'
function sortArrayByName($games, $name)
{
  usort($games, function ($a, $b) use ($name) {
    return strcasecmp($a[$name], $b[$name]);
  });
  return $games;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FPS Archives</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link
    href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,700;1,100;1,400&amp;family=Roboto:ital,wght@0,400;0,700;0,900;1,900&amp;display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <div class="heading-inner inner">
      <div class="container content-container">
        <div class="heading-content content">
          <h1 id="logo-text">FPS Archives</h1>
          <img id="gun-logo" src="images/logo.png" alt="gun logo">
        </div>
      </div>
    </div>
  </header>
  <main>
    <div id="intro">
      <div class="intro-inner">
        <div class="container intro-content-container content-container">
          <div class="intro-content content">
            <h2>Welcome to FPS Archives</h2>
            <p>We're proud to have a team of talented and dedicated game who have helped make our website a
              success. Our game have brought their unique perspectives and expertise to our content, creating
              tutorials, guides, and articles that have helped gamers around the world improve their skills and enjoy
              their favorite games even more. Without their hard work and dedication, our website wouldn't be what it is
              today. We're grateful to each and every one of them, and we're excited to introduce them to you on this
              game Page.
            </p>
            <br>
            <div class="search-settings">
              <form action="index.php" method="GET" id="filter-form">
                <div class="row">
                  <div class="col">
                    <input type="search" name="search-query" placeholder="E.g CSGO" value=<?php if (isset($_GET['search-query'])) {
                      echo strtolower($_GET['search-query']);
                    } ?>>
                    <button id="btn-search" class="btn-styling" type="submit">Search</button>
                  </div>
                  <div class="col">
                    <!-- <form action="index.php" method="get"> -->
                    <label for="filter">Filter By:</label>
                    <select id="filter" name="filter" id="filter">
                      <option <?php if (isset($_GET['filter'])) {
                        if ($_GET['filter'] == 'title') {
                          echo "selected";
                        }
                      } ?>
                        value="title">Title</option>
                      <option <?php if (isset($_GET['filter'])) {
                        if ($_GET['filter'] == 'developer') {
                          echo "selected";
                        }
                      } ?>
                        value="developer">Developer</option>
                      <option <?php if (isset($_GET['filter'])) {
                        if ($_GET['filter'] == 'platforms') {
                          echo "selected";
                        }
                      } ?>
                        value="platforms">Platform</option>
                      <option <?php if (isset($_GET['filter'])) {
                        if ($_GET['filter'] == 'setting') {
                          echo "selected";
                        }
                      } ?>
                        value="setting">Setting</option>
                      <option <?php if (isset($_GET['filter'])) {
                        if ($_GET['filter'] == 'release_date') {
                          echo "selected";
                        }
                      } ?>
                        value="release_date">Release Date</option>
                    </select>     
                    <button id="btn-filter" class="btn-styling" type="submit">Go</button>   
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="game">
      <div class="inner">
        <div class="container content-container">
          <div class="game-content content">
            <h2 id="game-header">Games</h2>
            <?php
            // Read the xml file if it exists
            if (file_exists('xml/catalogue.xml')) {
              $xml = simplexml_load_file('xml/catalogue.xml');
              $gameArray = [];

              $counter = 0;

              //Check if a query has been made
              if (isset($_GET['search-query'])) {
                $query = strtolower($_GET['search-query']);
              }

              //Loop through each element in the xml file
              foreach ($xml->children() as $game) {
                //Set the title of the game
                $title = strtolower((string) $game->title);

                //Check if a search query has been made, or if the search query matches a given game title
                if (!isset($query) || stripos($title, $query) !== false) {
                  //Add the game to the game array given its information
                  $gameArray[] = [
                    'title' => (string) $game->title,
                    'developer' => (string) $game->developer,
                    'release_date' => (string) $game->release_date,
                    'platforms' => (string) $game->platforms,
                    'setting' => (string) $game->setting,
                    'filepath' => (string) $game->filepath,
                    'long_description' => (string) $game->long_description,
                    'background_img' => (string) $game->background_img,
                  ];
                }
              }

              if (empty($gameArray)) {
                echo "<h3> No games found... </h3>";
              }
              if (isset($_GET['filter'])) {
                $selectedFilter = $_GET['filter'];
                $gameArray = sortArrayByName($gameArray, $selectedFilter);
              }
              // // Example of how we can sort using the method 
              // $gameArray = sortArrayByName($gameArray, 'developer');
              // $gameArray = sortArrayByName($gameArray, 'title');
              // $gameArray = sortArrayByName($gameArray, 'platforms');
              // $gameArray = sortArrayByName($gameArray, 'setting');
              // $gameArray = sortArrayByName($gameArray, 'release_date');
            
              //Iterate through each game, writing the card each time
              foreach ($gameArray as $game) {
                // Start a new row if row is full or hasnt been created
                if ($counter % 3 == 0) {
                  echo "<div class='game-row'>";
                }
                // Add a game card from node and increase node counter
                writeCard($game);
                $counter++;

                if ($counter % 3 == 0 && $counter != 0) { // End row if 3 nodes have been added
                  echo "</div>";
                }
              }


              $nodes_left = $counter % 3; // How many more nodes needed for a full row
              if ($nodes_left == 0) { // If we have filled the row close it
                echo "</div>";
              } else { // Else fill the row with blanks then close it
                for ($nodes_left; $nodes_left < 3; $nodes_left++) {
                  writeBlank(); // Write blank cards
                }
                echo "</div>";
              }
            } else {
              exit('Failed to load xml file');
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <div class="container">
      <div class="content-container">
        <div class="row">
          <div class="col">
            <h4>Copyright FPS Archives 2023</h4>
          </div>
          <div class="col text-end">
            <h4>Created by Josh, Tanner, Caleb</h4>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>