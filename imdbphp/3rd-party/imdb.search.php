<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>PHP-IMDB-Grabber by Fabian Beiner | Search by xsabianus</title>
  <!-- Small modifications by Fabian Beiner. Anyhow, no support for this script. -->
  <style>
    body {
      background-color:#fff;
      color:#111;
      font-family:Corbel, "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu  Sans", "Bitstream Vera Sans", "Liberation Sans", Verdana, sans-serif;
      font-size:14px;
      margin:20px auto;
      width:700px;
    }

    p {
      margin:0 0 5px;
      padding:0;
    }

    hr {
      background:#F0F0F0;
      color:gray;
      height:20px;
      width:100%;
    }

    #searchform {
      background-color:#444;
      border:2px solid #333;
      margin:10px auto;
    }

    #searchform div {
      border:1px solid #565656;
      padding:5px 0;
      text-align:center;
    }

    #searchform label {
      background-image:url(http://i269.photobucket.com/albums/jj49/minyx_blog/thicon_search.gif);
      background-position:0 0;
      background-repeat:no-repeat;
      height:14px;
      padding:2px 0 10px 25px;
    }

    #s {
      font-size:11px;
      padding:2px;
      width:72%;
    }

    #searchform img {
      border:none;
      margin:0;
      padding:0;
    }

    #searchsubmit {
      float:right;
      height:22px;
      margin:0 5px 0 0;
      padding:0;
      position:relative;
      width:34px;
    }

    #footer {
      background:#F0F0F0;
      color:gray;
      font-size:10px;
      height:220px;
      margin:4px 10px 10px 0;
      width:700px;
    }
  </style>
</head>
<body>
  <div class="search">
    <form id="searchform" method="POST" action="imdb.search.php">
    <div>
      <input id="searchsubmit" src="http://lh3.ggpht.com/_9nphYWWWTBQ/TOANchoA4FI/AAAAAAAAERM/2AiWduQ2YIM/ara_buton.jpg" type="image" />
      <label><input name="movie_link" type="text" value="" size="85" /></label>
    </div>
    </form>
  </div>
<?php
include_once '../imdb.class.php';

$strSearch = @$_POST['movie_link'];

if ($strSearch) {
    $oIMDB = new IMDB($strSearch, 10);
    if ($oIMDB->isReady) {
        echo '<p>Budget: <b>' . $oIMDB->getBudget() . '</b></p>';
        echo '<p>Cast (limited to 5): <b>' . $oIMDB->getCast(5) . '</b></p>';
        echo '<p>Cast as URL (default limited to 20): <b>' . $oIMDB->getCastAsUrl() . '</b></p>';
        echo '<p>Cast and Character (limited to 10): <b>' . $oIMDB->getCastAndCharacter(10) . '</b></p>';
        echo '<p>Cast and Character as URL (limited to 10): <b>' . $oIMDB->getCastAndCharacterAsUrl(10) . '</b></p>';
        echo '<p>Countries as URL: <b>' . $oIMDB->getCountryAsUrl() . '</b></p>';
        echo '<p>Countries: <b>' . $oIMDB->getCountry() . '</b></p>';
        echo '<p>Creators as URL: <b>' . $oIMDB->getCreatorAsUrl() . '</b></p>';
        echo '<p>Creators: <b>' . $oIMDB->getCreator() . '</b></p>';
        echo '<p>Directors as URL: <b>' . $oIMDB->getDirectorAsUrl() . '</b></p>';
        echo '<p>Directors: <b>' . $oIMDB->getDirector() . '</b></p>';
        echo '<p>Genres as URL: <b>' . $oIMDB->getGenreAsUrl() . '</b></p>';
        echo '<p>Genres: <b>' . $oIMDB->getGenre() . '</b></p>';
        echo '<p>Languages as URL: <b>' . $oIMDB->getLanguagesAsUrl() . '</b></p>';
        echo '<p>Languages: <b>' . $oIMDB->getLanguages() . '</b></p>';
        echo '<p>Location as URL: <b>' . $oIMDB->getLocationAsUrl() . '</b></p>';
        echo '<p>Location: <b>' . $oIMDB->getLocation() . '</b></p>';
        echo '<p>MPAA: <b>' . $oIMDB->getMpaa() . '</b></p>';
        echo '<p>Plot (shortened to 150 chars): <b>' . $oIMDB->getPlot(150) . '</b></p>';
        echo '<p>Poster: <b>' . $oIMDB->getPoster() . '</b></p>';
        echo '<p>Rating: <b>' . $oIMDB->getRating() . '</b></p>';
        echo '<p>Release Date: <b>' . $oIMDB->getReleaseDate() . '</b></p>';
        echo '<p>Runtime: <b>' . $oIMDB->getRuntime() . '</b></p>';
        echo '<p>Seasons: <b>' . $oIMDB->getSeasons() . '</b></p>';
        echo '<p>Tagline: <b>' . $oIMDB->getTagline() . '</b></p>';
        echo '<p>Title: <b>' . $oIMDB->getTitle() . '</b></p>';
        echo '<p>Url: <b><a href="' . $oIMDB->getUrl() . '">' . $oIMDB->getUrl() . '</a></b></p>';
        echo '<p>Votes: <b>' . $oIMDB->getVotes() . '</b></p>';
        echo '<p>Writers as URL: <b>' . $oIMDB->getWriterAsUrl() . '</b></p>';
        echo '<p>Writers: <b>' . $oIMDB->getWriter() . '</b></p>';
        echo '<p>Year: <b>' . $oIMDB->getYear() . '</b></p>';
    }
    else {
        echo '<p>Movie not found!</p>';
    }
}
?>
  <div id="footer">&nbsp;</div>
</body>
</html>
