


<?php

class Movie 
{
    private $title;               // string
    private $priority = 1000000;  // default
    private $year = NULL;         // int
    private $genre = NULL;        // array of strings
    private $director = NULL;     // array of strings
    private $writer = NULL;       // array of strings
    private $actor = NULL;        // array of strings
    
    public function __construct($title) {
		$this->setTitle($title);
	}
    
    public function getTitle()
    {
       return $this->title;
    }
	
    public function setTitle($title)
    {                 
       $this->title = chop($title); // chop removes unwanted trailing characters
    }
	
	function getPriority()
    {
    	return $this->priority;	
	}
	
    function setPriority($priority)
    {
       $this->priority = $priority;
    }
	
	function getYear()
    {
    	return $this->year;	
	}
	
    function setYear($year)
    {
       $this->year = $year;
    }
	
	function getDirector()
    {
    	return $this->director;	
	}
	
    function setDirector($director)
    {
       $this->director = $director;
    }
	
    // getter and setters for actor, genre and writer

}

?>
