<?php

class simpleCMS {

  var $host;
  var $username;
  var $password;
  //var $table = "testDB";
  var $table;
  var $database;
  private $link; //object returned by mysqli_connect()

  public function display_public() {
    $q = "SELECT * FROM testDB ORDER BY created DESC";
    $r = mysqli_query($this->link, $q);

    if ( $r !== false && mysqli_num_rows($r) > 0 ) {
      while ( $a = mysqli_fetch_assoc($r) ) {
        $title = stripslashes($a['title']);
        $bodytext = stripslashes($a['bodytext']);

        $entry_display .= <<<ENTRY_DISPLAY

    <div class="post">
    	<h2>
    		$title
    	</h2>
	    <p>
	      $bodytext
	    </p>
	</div>

ENTRY_DISPLAY;
      }
    } else {
      $entry_display = <<<ENTRY_DISPLAY

    <h2> This Page Is Under Construction </h2>
    <p>
      No entries have been made on this page. 
      Please check back soon, or click the
      link below to add an entry!
    </p>

ENTRY_DISPLAY;
    }
    $entry_display .= <<<ADMIN_OPTION

    <p class="admin_link">
      <a href="{$_SERVER['PHP_SELF']}?admin=1">Add a New Entry</a>
    </p>

ADMIN_OPTION;

    return $entry_display;
  }

  public function display_admin() {
    return <<<ADMIN_FORM

    <form action="{$_SERVER['PHP_SELF']}" method="post">
    
      <label for="title">Title:</label><br />
      <input name="title" id="title" type="text" maxlength="150" />
      <div class="clear"></div>
     
      <label for="bodytext">Body Text:</label><br />
      <textarea name="bodytext" id="bodytext"></textarea>
      <div class="clear"></div>
      
      <input type="submit" value="Create This Entry!" />
    </form>
    
    <br />
    
    <a href="display.php">Back to Home</a>

ADMIN_FORM;
  }

  public function write($p) {
    if ( $_POST['title'] )
      $title = mysqli_real_escape_string($this->link, $_POST['title']);
    if ( $_POST['bodytext'])
      $bodytext = mysqli_real_escape_string($this->link, $_POST['bodytext']);
    if ( $title && $bodytext ) {
      $created = date('Y M d');   // Format: YYYY-MM-DD;
      $sql = "INSERT INTO testDB VALUES('$title','$bodytext','$created')";
      return mysqli_query($this->link, $sql);
    } else {
      return false;
    }
  }

  public function connect() {
    $this->link = mysqli_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysqli_connect_error());
    mysqli_select_db($this->link, $this->database) or die("Could not select database. " . mysqli_error($link));

    return $this->buildDB();
  }

  private function buildDB() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS testDB (
title		VARCHAR(150),
bodytext	TEXT,
created		VARCHAR(100)
)
MySQL_QUERY;

    return mysqli_query($this->link, $sql);
  }

}

?>