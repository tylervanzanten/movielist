<?php
Things to do:

ask "are you sure?"  when a user clicks clear list

make the: 
Add a movie to get started! Click the link above. 
text larger size font.

make it look nice      (have the criteria it's currently sorted by be a different color)   '
add search capability
make the title in the list a link to the imdb URL for that movie

probably change the class name from CMS to MovieList or something

//title, year, genre, cast, director, writer, runtime, imdb rating, mpaa rating,




// round corners on the tables
http://www.htmlgoodies.com/tutorials/tables/article.php/3479841


// have the column names be links to sort by that value, here's the CSS for that
{text-decoration: none;}


// Genres
if(is_array($obj->genres)){
    $genre = implode(", ", $obj->genres);
    $genres = $obj->genres;
} else {
    $genre = "";
    $genres = "";
}


// automatically loads classes that would other would have to be specified
// manually like: include("class.php");
// http://www.php.net/manual/en/function.spl-autoload-register.php
function my_autoloader($class) {
    include 'class_' . $class . '.php';
}

spl_autoload_register('my_autoloader');

?>


