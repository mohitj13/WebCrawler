<!DOCTYPE html>
<html>
    <head>
        <title>Web Crawler</title>

        <link href="{{ asset('/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
        <script type="text/javascript">
		    
		    function showLoading(){
		    	$('#gif').css('visibility', 'visible');
		    	$('#form_submit').addClass("disabled");  
		        return true;
		    }
		</script>

    </head>
    <body>
<div class="container">

      <div class="row">
       
        <div class="col-lg-12 text-center v-center">
          
          <h1>Hello Web Crawlers</h1>
          <p class="lead">Start Web scrawling using google links!</p>
          
          <br>
          <div style="color:red;">
	          <ul>
				  @foreach($errors->all() as $error)
				    <li>{{ $error }}</li>
				  @endforeach
			  </ul>
		  </div>
		  <br />
          
          
          {!! Form::open(array('route' => 'start.crawl', 'class' => 'col-lg-12', 'id' => 'crawl_form', 'onsubmit' => 'showLoading()')) !!}
         	<div class="col-sm-offset-4 col-sm-4" id="center-panel">
            	{!! Form::text('inputText', '', array( 'required', 'class' => 'center-block form-control input-lg',
            									   'title' => 'Text to crawl',
            									   'placeholder' => 'Enter text to crawl') ) !!}
			    <br />	
			    {!! Form::text('number', '', array( 'required', 'class' => 'center-block form-control input-lg',
            									   'title' => 'Number of links',
            									   'placeholder' => 'Number of google links to crawl') ) !!}
			    <br />
			    {!! Form::text('depthLimit', '1', array( 'required', 'class' => 'center-block form-control input-lg',
            									   'title' => 'Crawling Depth Limit',
            									   'placeholder' => 'Crawling Depth Limit') ) !!}
			    <br />	
              
              <button id="form_submit" class="btn btn-lg btn-primary round" type="submit">Start Crawling</button>
              
              <img src="{{ asset('img/loader.gif') }}" id="gif" style="visibility: hidden;">
            </div>
            <div class="col-sm-4" id="center-panel">
      			      	
        	</div>
          
          {!! Form::close() !!}
            
        </div>
        
      </div> <!-- /row -->
  
  	  <div class="row">
       
        <div class="col-lg-12 text-center v-center" style="font-size:39pt;">
          <a href="#"><i class="icon-google-plus"></i></a> <a href="#"><i class="icon-facebook"></i></a>  <a href="#"><i class="icon-twitter"></i></a> <a href="#"><i class="icon-github"></i></a> <a href="#"><i class="icon-pinterest"></i></a>
        </div>
      
      </div>
  
  	<br><br><br><br><br>

</div> <!-- /container full -->


    </body>
</html>
