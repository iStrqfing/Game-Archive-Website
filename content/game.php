<?php
function writeCard($card)
{
  echo "<h2>{$card['title']}</h2>";
  echo "<p>";
  echo "{$card['long_description']}";
  echo "</p>";
  echo "<p>";
  echo "<span class='item-header'>Developed by: </span>{$card['developer']}<br>";
  echo "<span class='item-header'>Released: </span>{$card['release_date']}<br>";
  echo "<span class='item-header'>Platforms: </span>{$card['platforms']}<br>";
  echo "<span class='item-header'>Setting: </span>{$card['setting']}<br>";
  echo "</p>";
}

if (isset($_POST['game']) && isset($_POST['gameKeys'])) {
  $game = explode("|", $_POST['game']);
  $gameKeys = explode("|", $_POST['gameKeys']);

  $gameArray = array_combine($gameKeys, $game);

  $background_img = $gameArray['background_img'];
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

  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header>
    <div class="heading-inner inner">
      <div class="container content-container">
        <div class="heading-content content">
          <h1 id="logo-text">FPS Archives</h1>
          <img id="gun-logo" src="../images/logo.png" alt="gun logo">
        </div>
      </div>
    </div>
  </header>
  <main>
    <div id="intro" style="<?php if ($background_img != null) {
      echo "background: url('../$background_img') no-repeat 50% 50%";
    } ?>">
      <div class="intro-inner">
        <div class="container intro-content-container content-container">
          <div class="intro-content content">

            <?php
            $game = [
              'title' => "CSGO",
              'developer' => "Valve",
              'release_date' => "2012-08-21",
              'platforms' => "PC",
              'setting' => "Counter-terrorism vs. terrorists",
              'long_description' => "Counter-Strike: Global Offensive (CS:GO) is a classic, highly competitive FPS game that brings together terrorists and counter-terrorists in fast-paced, strategic gameplay. Engage in thrilling game modes like bomb defusal and hostage rescue. With a wide array of weapons and gear, you'll need to work with your team to outmaneuver your opponents and achieve victory. This game is renowned for its precise shooting mechanics and intense competition.",
              'filepath' => "images/icons/img-csgo.jpg",
            ];
            // Read the xml file if it exists
            if ($gameArray != null) {
              writeCard($gameArray);
            } else {
              exit('Failed to load game');
            }
            ?>
            <br>
            <a id="search-btn" href="../index.php">Back...</a>
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