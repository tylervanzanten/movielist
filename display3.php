<!DOCTYPE html> 

  <!--
  	
  	DOCUMENTATION
  	
  -->

  <head>
    <meta http-equiv="Movie" content="text/html; charset=UTF-8" />
    
    <title>Movie Watch List</title>
    
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>

  <body>
  	<div id="page-wrap">
    <?php
    
      include_once('CMS.php');
      include_once('\imdbphp\imdb.class.php');
      $obj = new CMS();

	  /* CHANGE THESE SETTINGS FOR YOUR OWN DATABASE */
      $obj->host     = 'localhost';
      $obj->username = 'root';
      $obj->password = '';
      $obj->table    = 'movielistdb';
	  $obj->database = 'movielistdb';
      $obj->connect();
    
      if ( $_POST )
        $obj->write($_POST);
      
      $admin = isset($_GET['admin']) ? $_GET['admin'] : '';
	  echo ( $admin == 1 ) ? $obj->display_new_form() : $obj->display();
      
      //echo ( $_GET['admin'] == 1 ) ? $obj->display_new_form() : $obj->display();
	  
	  
	  if(isset($_POST['deleteItem']) and is_numeric($_POST['deleteItem']))
      {
          // here comes your delete query: use $_POST['deleteItem'] as your id
          $user = $_POST['user'];
          $sql = "DELETE FROM users WHERE user_name = $user";
          // might need     $sql = sprintf("DELETE FROM users WHERE user_name = '".$user."'");   instead
          $result = mysql_query($sql);
           
          echo "Account has been deleted.";
      }
	  
      $deleteItem = isset($_GET['deleteItem']) ? $_GET['deleteItem'] : '';
      //echo ( $deleteItem ) ? $obj->delete($deleteItem) : $obj->display();
      if ($deleItem) {
          //print $deleteItem;
          echo $obj->display_new_form();
          print "Deleted!!!!!";
      }
      
    ?>
    
	</div>
  </body>

</html>