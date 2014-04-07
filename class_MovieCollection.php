
<?php
class MovieCollection
{
    private $collection;
    private $size;  // this might not be necessary
    // string array  directors  ?? use this for sorting, searching
    // string array  genres     ?? use this for sorting, searching
    // etc. array


    public function getCollection($size)
    {
       return $this->collection;
    }
    public function setCollection($collection)
    {
       $this->collection = $collection;
    }

    public function getSize($size)
    {
       return $this->size;
    }
    public function setSize($size)
    {
       $this->size = $size;
    }
	
	//addMovie
	
	//deleteMovie
	
}
	
?>

