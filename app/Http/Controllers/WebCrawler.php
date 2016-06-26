<?php

namespace App\Http\Controllers;

use PHPCrawler;
use PHPCrawlerDocumentInfo;

class WebCrawler extends PHPCrawler
{
		
	public $data = array();
		
	/**
	 * Handle the document information while scraping the URL's
	 * @param DocInfo
	 */
	function handleDocumentInfo(PHPCrawlerDocumentInfo $DocInfo) 
	  {
	    
		// Met Attributes string
		$metaString = str_replace(",", ";", implode(";", $DocInfo->meta_attributes));
		
	    // Print the URL and the HTTP-status-Code
	    array_push($this->data, "$DocInfo->url, $DocInfo->http_status_code, $DocInfo->referer_url, $metaString");
	    
	    flush();
	  } 
	  
	  /**
	   * Get the crawling data
	   * @return String
	   */
	  function getCrawlingData(){
	  	return $this->data;
	  }
}
