<?php

//documentation
class CMS {
  var $host;
  var $username;
  var $password;
  var $table;
  //var $movieTable;
  //var $actorTable;
  //var $directorTable;
  //var $writerTable;
  var $database;
  private $link; //object returned by mysqli_connect()

  
  //documentation
  public function display() {
    $query = "SELECT * FROM $this->table ORDER BY priority ASC";
    $result = mysqli_query($this->link, $query);

    $table_display = <<<NEW_MOVIE_LINK

    <p class="new_movie_link">
      <a href="{$_SERVER['PHP_SELF']}?admin=1" id = newMovie>Add a Movie</a>
    </p>
    <br>
    
NEW_MOVIE_LINK;

    if ( $result !== false ) {
      $table_display .= <<<TABLE_START

    <form action="" method="post">
    <table id="movie_table" >
    	<thead>
        	<tr>
            	<th>Delete</th>
            	<th>Edit</th>
            	<th>Priority</th>
           		<th>Title</th>
           		<th>Year</th>
            	<th>Genre</th>
            	<th>Director</th>
            	<th>Writer</th>
            	<th>Runtime</th>
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
        $Title = $row['title'];

        $table_display .= <<<TABLE_ROW

    		<tr>
    		    <td><a href="{$_SERVER['PHP_SELF']}?deleteItem=$Title">
                    <img src="images/x-mark4.jpg" alt="Error! Image cannot be displayed."></a></td>
    		    <td><input type="submit" name="editItem" value="Edit" /></td>
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
    <p>
      Add a movie to get started!  Click the link above.
    </p>

EMPTY_LIST;
    }

    return $table_display;
  }

  //documentation
  public function display_new_form() {
    return <<<NEW_MOVIE_FORM

    <form action="{$_SERVER['PHP_SELF']}" method="post">
    
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
    <!--Comment: Make sure the link below points to the .php file you want it to-->
    <a href="display3.php">Back to Home</a>

NEW_MOVIE_FORM;
  }

  //documentation
  public function write($p) {
	$genre    = "";
	$year     = "";
    $director = "";
    $writer   = "";
	$runtime  = "";
	$imdbRating = "";
  	// do type checking on these to make sure, for example priority cannot be "abc"
    if ( $_POST['title'] )
        $title = mysqli_real_escape_string($this->link, $_POST['title']);
    if ( $title ) {
        $created = date('Y M d');   // Format: YYYY-MM-DD;
        //Set the priority
        $query = "SELECT * FROM $this->table ORDER BY priority ASC";
        $result = mysqli_query($this->link, $query);
        $size = 0; // default for when the table doesn't exist
        if ($result !== FALSE) {  // if the table exists
            $size = mysqli_num_rows($result);
        }
    	$priority = $size + 1;
    	if ( $_POST['priority'] ) {
    	    $priority = mysqli_real_escape_string($this->link, $_POST['priority']);
            $priorityStr = mysqli_real_escape_string($this->link, $_POST['priority']);
            $priority    = intval($priorityStr);
    	    if ($priority > $size) {
    		    $priority = $size + 1;
    	    } else {   // if ($priority <= $size)
                $i = $priority;
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
        $fetchIMDb = isset($_POST['fetchIMDb']) ? $_POST['fetchIMDb'] : '';
        if ( $fetchIMDb ) {
        $movie = new IMDB($title);
        if ($movie->isReady) {
            $title = $movie->getTitle();
            // might need to check to see if there's a movie with that title already if I change the primary key to Priority
    	    if ( empty($genre) ) {
              $genre = $movie->getGenre();
            }
            $year = $movie->getYear();
            $director = $movie->getDirector();
            $writer = $movie->getWriter();
            // info that can only be set by fetching from IMDb
    	  	$runtime = $movie->getRuntime();
            $imdbRating = $movie->getRating();
    	}}
    	echo var_dump($priority,$title,$year,$genre,$director,$writer,$runtime,$imdbRating,$created,$size); //REMOVE LATER, FOR TESTING ONLY
    	// (maybe add mpaa rating)
        //$sql  = "INSERT INTO $this->table VALUES('$priority','$title','$year','$genre',";
        //$sql .= "'$director','$writer','$runtime','$imdbRating','$created')";
        $sql  = "INSERT INTO $this->table VALUES('$priority','$title','$year','$genre','$director','$writer','$runtime','$imdbRating','$created')";
        return mysqli_query($this->link, $sql);
    } else {
        return false;
    }
  }

  //documentation
  public function connect() {
    $this->link = mysqli_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysqli_connect_error());
    mysqli_select_db($this->link, $this->database) or die("Could not select database. " . mysqli_error($link));

    //$this->buildActorDB();
    
    return $this->buildMovieDB();
  }
 
  //documentation
  private function buildMovieDB() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS $this->table (
priority    INT NOT NULL,
title		VARCHAR(150),
year	    VARCHAR(5),
genre		VARCHAR(240),
director    VARCHAR(240),
writer      VARCHAR(240),
runtime     VARCHAR(10),
imdbRating  VARCHAR(4),
created	    VARCHAR(100),
PRIMARY KEY(title)
)
MySQL_QUERY;

    return mysqli_query($this->link, $sql);
  }
  
  //needs to be severely fixed
  public function delete($deleteItem) {
    return <<<NEW_MOVIE_FORM

    <form action="{$_SERVER['PHP_SELF']}" method="post">
    
      <label for="title">Title:</label><br />
      <input name="title" id="title" type="text" maxlength="150" tabindex="2" />
      <div class="clear"></div>
      
      <label for="priority">Priority:</label><br />
      <input name="priority" id="priority" type="text" maxlength="5" tabindex="1" />
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
    <!--Comment: Make sure the link below points to the .php file you want it to-->
    <a href="display3.php">Back to Home</a>

NEW_MOVIE_FORM;
  }
  
  
  //documentation
  public function display_edit_form() {
    return <<<NEW_MOVIE_FORM

    <form action="{$_SERVER['PHP_SELF']}" method="post">
    
      <label for="priority">Priority:</label><br />
      <input name="priority" id="priority" type="text" maxlength="5" tabindex="1" />
      <div class="clear"></div>
    
      <label for="title">Title:</label><br />
      <input name="title" id="title" type="text" maxlength="150" tabindex="2" />
      <div class="clear"></div>
      
      <label for="genre">Genre:</label><br />
      <input name="genre" id="genre" type="text" maxlength="150" tabindex="3" />
      <div class="clear"></div>
     
      <label for="year">Year:</label><br />
      <input name="year" id="year" type="text" maxlength="4" tabindex="4" />
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
    <!--Comment: Make sure the link below points to the .php file you want it to-->
    <a href="display3.php">Back to Home</a>

NEW_MOVIE_FORM;
  }

}

?>