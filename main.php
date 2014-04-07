

<?php

// automatically loads classes that would other would have to be specified
// manually like: include("class.php");
// http://www.php.net/manual/en/function.spl-autoload-register.php
function my_autoloader($class) {
    include 'class_' . $class . '.php';
}

spl_autoload_register('my_autoloader');

?>


<?php

// IMDb ( [bool $anonymise = false [, bool $summary = true [, int $titlesLimit = 0]]] )
//$imdb = new IMDb(true, true, 0);    // anonymise requests to prevent IP address getting banned, summarise returned data, unlimited films returned

// Returns an array containing objects of matching titles
//$movies = $imdb->find_by_title("The Godfather");

// $movies[0]->title => "The Godfather"
// $movies[0]->year => "1972"


$collection = new MovieCollection();
?>


<?php
// OPENING & CLOSING A CONNECTION TO mySQL
$con=mysqli_connect("example.com","peter","abc123","my_db");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_close($con);
?> 