<?php
Things to do:

maybe (link three DBs together for director, writer, actor, and maybe genre)
add delete capability  (and make sure the priorities get updated everytime something gets deleted)
add edit capability
add "clear list" button  and then ask "are you sure?"
make it look nice
add search capability
automatically fetch the RIGHT info from imdb (be able to search by year and title)
make the title in the list a link to the imdb URL for that movie

probably change the class name from CMS to MovieList or something

//title, year, genre, cast, director, writer, runtime, imdb rating, mpaa rating,


// deleting an entry
$query = "DELETE FROM $this->table WHERE title = '$deleteItem' ";
$query = "DELETE FROM $this->table WHERE title = $deleteItem ";

//image address link

<p>Create a link of an image:
<a href="default.asp"><img src="smiley.gif" alt="HTML tutorial" width="42" height="42"></a></p>

// updating the priorities when a movie gets deleted from the list
                
                mysqli_query("
                UPDATE '".$this->table."'
                SET priority = priority - 1
                WHERE priority > '".$i."'
                ");



// a form image button, I think I need something different for my delete and edit buttons
<input type="image" src="rainbow.gif" name="image" width="60" height="60">
// http://www.echoecho.com/htmlforms14.htm


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


