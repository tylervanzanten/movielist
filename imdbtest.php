<?php

// Used to verify that the imdb.class.php is working correctly

include_once '\imdbphp\imdb.class.php';

$name = "godfather";   
$movie = new IMDB('the godfather');  

echo $movie->getRuntime();
echo $movie->getRating();
echo $movie->getTitle();
echo $movie->getYear();
echo $movie->getGenre();
echo $movie->getDirector();
echo $movie->getCast();
echo $movie->getMpaa();
echo $movie->getWriter();

?>
