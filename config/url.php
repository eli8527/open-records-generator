<?php

class URL extends URL_Base
{	
	// $this->urls = array of all object urls
	// $this->url = this object's url
	// $this->ids = array of all object ids
	// $this->id = this object's id
	// if no object selected, 
	// $this->urls, $this->url, and $this->ids are not set
	// $this->id is 0
	function __construct($urls=null)
	{
		global $oo;
	
		try 
		{
			$ids = $oo->urls_to_ids($urls);
		}
		// check that the object that this URL refers to exists
 		// FIX THIS CODE (balks at writing before header)   
		catch(Exception $e)
		{
			$urls = array_slice($urls, 0, $e->getMessage());
			$ids = $oo->urls_to_ids($urls);
			$loc = $host.implode("/".$base)."/".implode("/", $urls);
			header("Location: ".$loc);
		}

        // decode all urls to catch utf-8 characters
        // do this after checking to see if url maps to an object
        // as the encoded url slug is what is written to the database
        foreach ($urls as &$thisurl) {
            $thisurl = urldecode($thisurl);
        }

		$id = $ids[count($ids)-1];
		if(!$id)
			$id = 0;
		if(sizeof($ids) == 1 && empty($ids[0]))
			unset($ids);
		
		$this->urls = $urls;
		$this->url = end($urls);
		$this->ids = $ids;
		$this->id = $id;
		$this->url_str = implode($urls);
		// $this->back_url = 
	}
}

?>
