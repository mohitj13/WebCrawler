<!DOCTYPE html>
<html>
    <head>
        <title>Web Crawler</title>

        <link href="{{ asset('/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

    </head>
    <body>
		<div class="container">

			<div class="row">
       
      			<div class="col-lg-12">
      				
      				<h1>Hello Web Crawlers</h1>
      				<div class="row">
      					<div class="col-lg-8">
      						<p class="lead">Web Crawling completed!</p>		
      					</div>
      					<div class="col-lg-4">
      						{!! HTML::link('download', 'Download Crawling Result', array('class'=>'btn btn-primary')) !!}
      					</div>
      				</div>
          			
          			<br />
      				
      				<ol>
	      				@foreach($data as $item)
	      					<li>
	      						<table class="table table-bordered table-hover table-responsive">
		      						@foreach($item as $key => $value)
		      						<tr>
		      							<td>
		      								{!! $key !!}
		      							</td>	
		      							<td>
		      								{!! $value !!}
		      							</td>
		      						@endforeach
		      						</tr>
	      						</table>
	      						
	      					</li>	
	      				@endforeach
      				</ol>
      				
      				{!! HTML::link('', 'Back', array('class'=>'btn btn-primary')) !!}
      				
        		</div>
        		
			</div>
		</div>
	</body>
</html>