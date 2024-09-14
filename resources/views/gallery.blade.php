@extends('layout.master')
@section('page-title')
  Gallery
@endsection
@section('main-content')
	<!-- BEGIN MAIN CONTENT -->
		<main class="main-content">

		<!-- Gallery -->
        <div class="gallery tc-padding">
      		<div class="container">
      			<div class="row no-gutters">
					@forelse($galleries as $gallery)
					<!-- in frontend we use forelse works same as foreach -->
      				<div class="col-lg-3 col-xs-6 r-full-width">
      					<div class="gallery-figure style-2"> 
							@if($gallery->media_img == 'No Image Found')
	                  		<img src="/assets/images/no-img.jpg" alt="No Image Found">
							@else
							<img src="/uploads/{{ $gallery->media_img }}" alt="{{ $gallery->title }}">
							@endif
							<div class="overlay"></div>
                            </div>
                            </div>
							@empty
							<div class="alert alert-danger">No record found</div>
							</div>

					@endforelse
      				<div class="col-xs-12">
      					<div class="pagination-holder">
							{{ $galleries->links() }}
		           			<!-- <ul class="pagination">
							    <li><a href="#" aria-label="Previous">Prev</a></li>
							    <li><a href="#">1</a></li>
							    <li class="active"><a href="#">2</a></li>
							    <li><a href="#">3</a></li>
							    <li><a href="#">4</a></li>
							    <li><a href="#">5</a></li>
							    <li><a href="#">6</a></li>
							    <li><a href="#">7</a></li>
							    <li><a href="#">...</a></li>
							    <li><a href="#">23</a></li>
							    <li><a href="#" aria-label="Next">Next</a></li>
							</ul> -->
		           		</div>
      				</div>
      			</div>
            </div>
      	</div>
		<!-- Gallery -->

	</main>
	<!-- END MAIN CONTENT -->
@endsection
	