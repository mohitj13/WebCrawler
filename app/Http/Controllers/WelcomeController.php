<?php

namespace App\Http\Controllers;

// It may take a whils to crawl a site ...
set_time_limit(10000);

use Illuminate\Http\Request;
use Response;
use View;

use App\Http\Requests;
use App\Http\Requests\CrawlingFormRequest;
use App\Http\Controllers\Controller;
use Sunra\PhpSimple\HtmlDomParser;

use PHPCrawlerUrlCacheTypes;

class WelcomeController extends Controller
{
	public $data = array('Requested URL,Http Status,Referrer Page,Meta Attribute');
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CrawlingFormRequest $request)
    {
    	
		$inputText = $request->get('inputText');
		$inputText = str_replace(" ", "+", $inputText);
		$no = $request->get('number');
		$depthLimit = $request->get('depthLimit');
		
		// Return data
		$htmlData = array();
		
		// Creating an URL of google search
        $url  = "http://www.google.com/search?hl=en&safe=active&tbo=d&site=&source=hp&num=".$no."&q=".$inputText."&oq=".$inputText."&start=0";
		
		// Parse the html page of google search and filter the links
		$html = HtmlDomParser::file_get_html($url);
		$linkObjs = $html->find('h3.r a');		
		
		foreach ($linkObjs as $linkObj) {
			$htmlView = array();
		    $title = trim($linkObj->plaintext);
		    $link  = trim($linkObj->href);
		    
		    // if it is not a direct link but url reference found inside it, then extract
		    if (!preg_match('/^https?/', $link) && preg_match('/q=(.+)&amp;sa=/U', $link, $matches) && preg_match('/^https?/', $matches[1])) {
		        $link = $matches[1];
		    } else if (!preg_match('/^https?/', $link)) { // skip if it is not a valid link
		        continue;    
		    }
		    
			// Crawl the Links and store the data
		    $htmlView['Title'] = $title;
		    $htmlView['Link'] = $link;		
        	$htmlView['Summary'] =	$this->getCrawled($link,$depthLimit, $request);
			
			// Add the htmlView
			array_push($htmlData, $htmlView);	
		}

		// Store the crawling data into a csv file
		$fp = fopen(public_path().'/output.csv', 'w');
		foreach ( $this->data as $line ) {
		    $val = explode(",", $line);
		    fputcsv($fp, $val);
		}
		fclose($fp);
		
		// Return the view page
		return View::make('crawlSummary')->with('data', $htmlData);
		
    }
    
    /**
	 * Crawled the selected link
	 * @param link
	 */
	private function getCrawled($link, $depthLimit, $request){
				
		// html view to render
		$htmlView = "";		
		
		// Now, create a instance of your class, define the behaviour
		// of the crawler (see class-reference for more options and details)
		// and start the crawling-process.		
		$crawler = new WebCrawler();
		
		// URL to crawl
		$crawler->setURL($link);
		
		// Only receive content of files with content-type "text/html"
		$crawler->addContentTypeReceiveRule("#text/html#");
		
		// Ignore links to pictures, dont even request pictures
		$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png|css|js)$# i");
		
		// Store and send cookie-data like a browser does
		$crawler->enableCookieHandling(true);
		
		// Set caching to SQLITE
		$crawler->setUrlCacheType(PHPCrawlerUrlCacheTypes::URLCACHE_SQLITE);
		
		$crawler->setFollowRedirects(false);
		$crawler->setFollowRedirectsTillContent(false);
		$crawler->setCrawlingDepthLimit($depthLimit);
		
		// Set the user agent string
		$crawler->setUserAgentString($request->server('HTTP_USER_AGENT'));
		
		// Set the traffic-limit to 1 MB (in bytes,
		// for testing we dont want to "suck" the whole site)
		$crawler->setTrafficLimit(1000 * 1024);
		
		// Thats enough, now here we go
		$crawler->go();
		
		// At the end, after the process is finished, we print a short
		// report (see method getProcessReport() for more information)
		$report = $crawler->getProcessReport();
		
		// Get the crawled data	
		$this->data = array_merge($this->data, $crawler->getCrawlingData());
		
		if (PHP_SAPI == "cli") $lb = "\n";
		else $lb = "<br />";
		    
		$htmlView = $htmlView . "Links followed: ".$report->links_followed.$lb;
		$htmlView = $htmlView . "Documents received: ".$report->files_received.$lb;
		$htmlView = $htmlView . "Bytes received: ".$report->bytes_received." bytes".$lb;
		$htmlView = $htmlView . "Process runtime: ".$report->process_runtime." sec".$lb;
		
		return $htmlView; 
	}
    
    /**
	 * Download the array data
	 */
	public function download(){
			
		//CSV file is stored under project/public/download/info.pdf
	    $file= public_path(). "/output.csv";
	
	    $headers = array(
	              'Content-Type: application/excel',
	              'Content-Disposition: attachment; filename="output.csv"'
	            );
	
	    return Response::download($file, 'output.csv', $headers);

	}

}
