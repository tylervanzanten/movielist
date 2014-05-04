<!DOCTYPE html> 

  <!--
  	display.php is a PHP file which creates an instance of the class MovieClassCMS
  	and calls methods to make it function as it should.  It serves as an interactive
  	movie watch list.  Note: there is no warning after "Clear List" is clicked, so
  	avoid clicking it recklessly
  	
  	Author: Tyler VanZanten
  	Date: May 3, 2014
  -->

  <head>
    <meta http-equiv="Movie" content="text/html; charset=UTF-8" />
    
    <title>Movie Watch List</title>
    
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>

  <body>
  	<div id="page-wrap">
    <?php
    
      include_once('MovieListCMS.php');
      include_once('\imdbphp\imdb.class.php');
      $obj = new MovieListCMS();

	  /* CHANGE THESE SETTINGS FOR YOUR OWN DATABASE */
      $obj->host     = 'localhost';
      $obj->username = 'root';
      $obj->password = '';
      $obj->table    = 'movielistdb';
	  $obj->database = 'movielistdb';
      $obj->connect();


      $postType = isset($_POST['type']) ? $_POST['type'] : '';
      if ( $postType === "new_form" ) {
          $obj->write($_POST);
      }
      elseif ( $postType === "edit_form" ) {
          $obj->update($_POST);
          $obj->priority_update();
      }
      
      $deleteItem = isset($_GET['deleteItem']) ? $_GET['deleteItem'] : '';
      if( $deleteItem !== "" )
      {
          $obj->delete($deleteItem);
          echo $obj->display("priority");                          // display the HTML table
          echo "$deleteItem has been removed from the list."; 
      }       

      $admin = isset($_GET['admin']) ? $_GET['admin'] : '';
      if ( $admin == 1 )
      {
          echo $obj->display_new_form();
      }
      elseif ( $admin == 2 ) 
      {
          $obj->clear_list();
          echo $obj->display("priority");
      }
      elseif ( $admin !== ''  ) 
      {
          echo $obj->display_edit_form($admin);
      }
	  
      $sort = isset($_GET['sort']) ? $_GET['sort'] : 'priority';  // sort by priority is default
      if ( $admin === "" && $deleteItem === "") {
	      echo $obj->display($sort);                          // display the HTML table
      }      
      
    ?>
    
	</div>
  </body>

</html>
