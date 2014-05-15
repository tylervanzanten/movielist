<?php

/** 
 * MovieListCMS is a class used to manage a movie watch list.
 * It is a content management system that uses MySQL.
 * 
 * Author: Tyler VanZanten
 * Date: May 3, 2014
 */ 
class MovieListCMS {
  var $host;      // host name or an IP address
  var $username;  // MySQL user name. 
  var $password;  // MySQL password
  var $table;     // SQL table name that stores the list
  var $database;  // SQL database name
  private $link;  //object returned by mysqli_connect()

  
  // Connect to the mySQL table
  // PRE: the member variables of the class have been set.
  // Return: mysqli_result object which was returned from buildMovieDB()
  public function connect() {
    $this->link = mysqli_connect($this->host,$this->username,$this->password) or 
                                 die("Could not connect. " . mysqli_connect_error());
    mysqli_select_db($this->link, $this->database) or die("Could not select database. " . mysqli_error($link));
    
    return $this->buildMovieDB();
  }
 
 
  // Constructs the SQL table to store the movie watch list
  // if it does not already exist.
  // Return: mysqli_result object
  private function buildMovieDB() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS $this->table (
priority    INT NOT NULL,
title       VARCHAR(150),
year        VARCHAR(5),
genre       VARCHAR(240),
director    VARCHAR(240),
writer      VARCHAR(240),
runtime     INT,
imdbRating  VARCHAR(4),
created     VARCHAR(100),
PRIMARY KEY(title)
)
MySQL_QUERY;

    return mysqli_query($this->link, $sql);
  }
  
  
  // displays the movie list as an html table
  // Receive: $sortType, a string specifying what field
  // to sort the list by.
  // Return: html code.
  public function display($sortType) {
    $query = "SELECT * FROM $this->table ORDER BY $sortType ASC";
    $result = mysqli_query($this->link, $query);

    $table_display = <<<NEW_MOVIE_LINK

      <div class = "topOfList" align="right">
        <a href="{$_SERVER['PHP_SELF']}?admin=2" id = clearList>Clear List</a>
      </div> 
      <div class = "topOfList" align="left">
        <a href="{$_SERVER['PHP_SELF']}?admin=1" id = newMovie style="color:blue;">Add a Movie</a>
      </div>
    <br>

NEW_MOVIE_LINK;


    if ( $result !== false && mysqli_num_rows($result) !== 0 ) {  // selection
      $table_display .= <<<TABLE_START

      <form action="" method="post">
      <table id="movie_table" >
    	<thead>
        	<tr>
            	<th>Delete</th>
                <th></th>
                <th><a href="{$_SERVER['PHP_SELF']}?sort=priority" id=sortLink>Priority</a></th>
                <th><a href="{$_SERVER['PHP_SELF']}?sort=title" id=sortLink>Title</a></th>
                <th><a href="{$_SERVER['PHP_SELF']}?sort=year" id=sortLink>Year</a></th>
                <th><a href="{$_SERVER['PHP_SELF']}?sort=genre" id=sortLink>Genre</a></th>
                <th><a href="{$_SERVER['PHP_SELF']}?sort=director" id=sortLink>Director</a></th>
                <th><a href="{$_SERVER['PHP_SELF']}?sort=writer" id=sortLink>Writer</a></th>
                <th><a href="{$_SERVER['PHP_SELF']}?sort=runtime" id=sortLink>Runtime</a></th>
                <th>IMDb Rating</th>
        	</tr>
    	</thead>
    	<tbody>

TABLE_START;

      while ( $row = mysqli_fetch_assoc($result) ) {  // repetition
        $priority = stripslashes($row['priority']);
        $title    = stripslashes($row['title']);
        $year     = stripslashes($row['year']);
		$genre    = stripslashes($row['genre']);
		$director = stripslashes($row['director']);
        $writer   = stripslashes($row['writer']);
        $runtime  = stripslashes($row['runtime']);
        $imdbRating  = stripslashes($row['imdbRating']);

        $table_display .= <<<TABLE_ROW

    		<tr>
    		    <td><a href="{$_SERVER['PHP_SELF']}?deleteItem=$title">
                    <img src="images/x-mark.jpg" alt="Error! Image cannot be displayed."></a></td>
    		    <td><a href="{$_SERVER['PHP_SELF']}?admin=$title" id = update>Edit</a></td>
           		<td>$priority</td>
            	<td>$title</td>
            	<td>$year</td>
            	<td>$genre</td>
            	<td>$director</td>
            	<td>$writer</td>
            	<td>$runtime</td>
            	<td>$imdbRating</td>
        	</tr>

TABLE_ROW;
      }
      $table_display .= <<<TABLE_END

        </tbody>
	</table>
	</form>

TABLE_END;
    } else {
      $table_display .= <<<EMPTY_LIST

    <h2> Your Watch List Is Empty </h2>
    <br>
    <p style="font-size: 16px;">
      Add a movie to get started!  Click the link above.
    </p>

EMPTY_LIST;
    }

    return $table_display;
  }


  // Displays an html form for a movie to be added to the list
  // Receive: none
  // Return: an html form
  public function display_new_form() {
    return <<<NEW_MOVIE_FORM

    <form action="{$_SERVER['PHP_SELF']}" method="post">
      <input type="hidden" name="type" id="type" value="new_form" />
      
      <label for="title">Title:</label><br />
      <input name="title" id="title" type="text" maxlength="150" tabindex="1" />
      <div class="clear"></div>
      
      <label for="priority">Priority:</label><br />
      <input name="priority" id="priority" type="text" maxlength="5" tabindex="2" />
      <div class="clear"></div>
      
      <label for="genre">Genre:</label><br />
      <input name="genre" id="genre" type="text" maxlength="150" tabindex="3" />
      <div class="clear"></div>
     
      <label for="year">Year:</label><br />
      <input name="year" id="year" type="text" maxlength="4" tabindex="4" />
      <div class="clear"></div>
      
      <label for="director">Director:</label><br />
      <input name="director" id="director" type="text" maxlength="250" tabindex="5" />
      <div class="clear"></div>
      
      <label for="writer">Writer:</label><br />
      <input name="writer" id="writer" type="text" maxlength="250" tabindex="6" />
      <div class="clear"></div>
      
      <br>
      <label for="fetchIMDb">
      <input type="checkbox" name="fetchIMDb" value="fetchIMDb" id="fetchIMDb" tabindex="8" checked>
      Automatically add missing info from IMDb
      </label>
      <br>
      <br>
      <br />
      <input type="submit" value="Add This Movie!"  tabindex="9"/>
    </form>
    
    <br />
    <a href="display.php">Back to Home</a>

NEW_MOVIE_FORM;
  }


  // Adds a movie to the mySQL table
  // Receive: $p, a $_POST variable which was created by
  // calling display_new_form().
  // Return: the object returned by the MySQL query or false if the user
  // did not specify a title for the movie to be added.
  public function write($p) {
   $genre    = "";
   $year     = "";
   $director = "";
   $writer   = "";
   $runtime  = "";
   $imdbRating = "";
   if ( $_POST['title'] )    // selection
        $title = mysqli_real_escape_string($this->link, $_POST['title']);
   if ( $title ) {
        $created = date('Y M d');   // Format: YYYY-MM-DD;
        $query = "SELECT * FROM $this->table ORDER BY priority ASC";
        $result = mysqli_query($this->link, $query);
        $size = 0; // default for when the table doesn't exist
        if ($result !== FALSE) {  // if the table exists
            $size = mysqli_num_rows($result);
        }
    	$priority = $size + 1;
    	if ( $_POST['priority'] ) {
            $priorityStr = mysqli_real_escape_string($this->link, $_POST['priority']);
            $priority    = intval($priorityStr);
    	    if ($priority > $size) {
    		    $priority = $size + 1;
    	    } else {   // if ($priority <= $size)
                $query = "UPDATE $this->table SET priority = priority + 1 WHERE priority >= $priority";
    	        mysqli_query($this->link, $query);
            }
        }
        if ( $_POST['genre']) {
            $genre = mysqli_real_escape_string($this->link, $_POST['genre']);
        }
        if ( $_POST['year'] ) {
    	    $year = mysqli_real_escape_string($this->link, $_POST['year']);
        }
        if ( $_POST['director'] ) {
            $director = mysqli_real_escape_string($this->link, $_POST['director']);
        }
        if ( $_POST['writer'] ) {
            $writer = mysqli_real_escape_string($this->link, $_POST['writer']);
        }
        $fetchIMDb = isset($_POST['fetchIMDb']) ? $_POST['fetchIMDb'] : '';
        if ( $fetchIMDb ) {
        $movie = new IMDB($title);
        if ($movie->isReady) {
            $title = $movie->getTitle();
    	    if ( empty($genre) ) {
              $genre = $movie->getGenre();
            }
            $year = $movie->getYear();
            $director = $movie->getDirector();
            $writer = $movie->getWriter();
            // info that can only be set by fetching from IMDb
    	  	$runtime = $movie->getRuntime();
            $length = strlen($runtime);
            $runtime = intval(substr($runtime, 0, $runtime - 4));
            $imdbRating = $movie->getRating();
    	}}
        $sql  = "INSERT INTO $this->table VALUES('$priority','$title','$year','$genre',
                '$director','$writer','$runtime','$imdbRating','$created')";
        return mysqli_query($this->link, $sql);
    } else {
        return false;
    }
  }



  // Deletes a movie from the database table
  // Receive: $deleteItem, a string specifying the name of a movie.
  // PRE: $deleteItem is in the table.
  // Return: none.
  // POST: $deleteItem has been deleted from the table.
  public function delete($deleteItem) {
    $query = "SELECT * FROM $this->table WHERE title='$deleteItem'";
    $result = mysqli_query($this->link, $query);
    $row = mysqli_fetch_array($result); 
    $priority = stripslashes($row['priority']);
    $priority = intval($priority);
    $query = "UPDATE $this->table SET priority = priority - 1 WHERE priority > $priority";
    mysqli_query($this->link, $query);            
    $query = "DELETE FROM $this->table WHERE title='$deleteItem'";
    mysqli_query($this->link, $query);
  }
  
  
  // Displays a form for editing an entry in the list
  // Receive: $title, a string specifying the name of a movie.
  // PRE: $title is the name of a movie in the table.
  // Return: an HTML form.
  // POST: the entry has been successfully updated.
  public function display_edit_form( $title ) {
    $query = "SELECT * FROM $this->table WHERE title='$title'";
    $result = mysqli_query($this->link, $query);
    $row = mysqli_fetch_array($result); 
    $titleup    = stripslashes($row['title']);
    $priorityup = stripslashes($row['priority']);
    $yearup     = stripslashes($row['year']);
    $genreup    = stripslashes($row['genre']);
    $directorup = stripslashes($row['director']);
    $writerup   = stripslashes($row['writer']);

    return <<<EDIT_MOVIE_FORM

    <form action="{$_SERVER['PHP_SELF']}" method="post">
      <input type="hidden" name="type" id="type" value="edit_form" />
      <input type="hidden" name="oldTitle" id="oldTitle" value="$titleup" />
    
      <label for="title">Title:</label><br />
      <input name="title" id="title" type="text" value="$titleup" maxlength="150" tabindex="1" />
      <div class="clear"></div>
      
      <label for="priority">Priority:</label><br />
      <input name="priority" id="priority" type="text" value="$priorityup" maxlength="5" tabindex="1" />
      <div class="clear"></div>
      
      <label for="genre">Genre:</label><br />
      <input name="genre" id="genre" type="text" value="$genreup" maxlength="150" tabindex="3" />
      <div class="clear"></div>
     
      <label for="year">Year:</label><br />
      <input name="year" id="year" type="text" value="$yearup" maxlength="4" tabindex="4" />
      <div class="clear"></div>
      
      <label for="director">Director:</label><br />
      <input name="director" id="director" type="text" value="$directorup" maxlength="250" tabindex="5" />
      <div class="clear"></div>
      
      <label for="writer">Writer:</label><br />
      <input name="writer" id="writer" type="text" value="$writerup" maxlength="250" tabindex="6" />
      <div class="clear"></div>
      
      <br>
      <label for="fetchIMDb">
      <input type="checkbox" name="fetchIMDb" value="fetchIMDb" id="fetchIMDb" tabindex="8">
      Automatically add missing info from IMDb
      </label>
      <br>
      <br>
      <br />
      <input name="updateDone" type="submit" id="updateDone" value="Update this Movie" tabindex="9"/>
    </form>
    
    <br />
    <a href="display.php">Back to Home</a>

EDIT_MOVIE_FORM;

  }


  // Used after display_edit_form() is called.  It updates the an entry in the database.
  // Receive: $p, a $_POST variable.
  // Return: the object returned by the MySQL query or false if the user
  // erased the name of the movie to be updated.
  // Post: the entry in the table has been updated.
  public function update($p) {
    $genre    = "";
    $year     = "";
    $director = "";
    $writer   = "";
    $runtime  = "";
    $imdbRating = "";
    if ( $_POST['title'] )
        $title = mysqli_real_escape_string($this->link, $_POST['title']);
    if ( $title ) {
        $oldTitle = mysqli_real_escape_string($this->link, $_POST['oldTitle']);
        $created = date('Y M d');   // Format: YYYY-MM-DD;
        $query = "SELECT * FROM $this->table ORDER BY priority ASC";
        $result = mysqli_query($this->link, $query);
        $size = 0; // default for when the table doesn't exist
        if ($result !== FALSE) {  // if the table exists
            $size = mysqli_num_rows($result);
        }
        $priority = $size + 1;
        if ( $_POST['priority'] ) {
            $priorityStr = mysqli_real_escape_string($this->link, $_POST['priority']);
            $priority    = intval($priorityStr);
            if ($priority > $size) {
                $priority = $size + 1;
            } else {   // if ($priority <= $size)
                $query = "UPDATE $this->table SET priority = priority + 1 WHERE priority >= $priority";
                mysqli_query($this->link, $query);
                $query = "UPDATE $this->table SET priority = priority - 1 WHERE priority < $priority";
                mysqli_query($this->link, $query);
            }
        }
        if ( $_POST['genre']) {
            $genre = mysqli_real_escape_string($this->link, $_POST['genre']);
        }
        if ( $_POST['year'] ) {
            $year = mysqli_real_escape_string($this->link, $_POST['year']);
        }
        if ( $_POST['director'] ) {
            $director = mysqli_real_escape_string($this->link, $_POST['director']);
        }
        if ( $_POST['writer'] ) {
            $writer = mysqli_real_escape_string($this->link, $_POST['writer']);
        }
        $fetchIMDb = isset($_POST['fetchIMDb']) ? $_POST['fetchIMDb'] : '';
        if ( $fetchIMDb ) {
        $movie = new IMDB($title);
        if ($movie->isReady) {
            $title = $movie->getTitle();
            if ( empty($genre) ) {
              $genre = $movie->getGenre();
            }
            $year = $movie->getYear();
            $director = $movie->getDirector();
            $writer = $movie->getWriter();
            // info that can only be set by fetching from IMDb
            $runtime = $movie->getRuntime();
            $length = strlen($runtime);
            $runtime = intval(substr($runtime, 0, $runtime - 4));
            $imdbRating = $movie->getRating();
            $sql  = "UPDATE $this->table SET title = '$title', priority = '$priority', year = '$year', genre = '$genre', 
                     director = '$director', writer = '$writer', runtime = '$runtime', 
                     imdbRating = '$imdbRating', created = '$created' WHERE title = '$oldTitle'";
        return mysqli_query($this->link, $sql);
        }}
        $sql  = "UPDATE $this->table SET title = '$title', priority = '$priority', year = '$year', genre = '$genre', 
                 director = '$director', writer = '$writer', created = '$created' WHERE title = '$oldTitle'";
        return mysqli_query($this->link, $sql);
    } else {
        return false;
    }
  }


  // deletes the table
  // Receive: none.
  // Return: none.
  // POST: $this->table has been deleted from $this->database
  public function clear_list() {
    $query = "DROP TABLE $this->table";
    mysqli_query($this->link, $query);
  }
  
  
  // cleans up the gaps in the priorities that are created by update().
  // Receive: none.
  // Return: none.
  // POST: the priorities of the movies go from 1 to # of movies in collection.
  public function priority_update() {
      $query = "SELECT * FROM $this->table ORDER BY priority ASC";
      $result = mysqli_query($this->link, $query);
      $array = array();
      $priority = 0;
      $size = 0; // default for when the table doesn't exist
      if ($result !== FALSE) {  // if the table exists
          $size = mysqli_num_rows($result);
      }      
      while ( $row = mysqli_fetch_assoc($result) ) {  // repetition
        $priority = $priority + 1;
        $title    = stripslashes($row['title']);
        $array[$priority-1] = array($title, $priority);
      }
      for ($i = 0; $i < $size; $i++) {                // repetition
        $title    = $array[$i][0];
        $priority = $array[$i][1];
        $query = "UPDATE $this->table SET priority = '$priority' WHERE title = '$title'";
        mysqli_query($this->link, $query);
      }
  }
}

?>