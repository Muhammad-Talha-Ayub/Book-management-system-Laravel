@if($paginator->hasPages())
<ul class="pagination">
    {{-- Previous page link --}}
    @if($paginator->onFirstPage())
	<li><a href="#" aria-label="Previous">Prev</a></li>
	@else
	<li><a href="{{ $paginator->previousPageurl() }}" rel="prev">Prev</a></li>
    @endif
    {{-- Pagination Elements --}}
    @foreach($elements as $element)
    {{-- "Three Dots" separator   --}}
    @if(is_string($element))
	<li class="disabled"><span>{{ $element }}</span></li>
    @endif
    {{-- Array of links --}}
    @if(is_array($element))
    @foreach($element as $page => $url)
    @if($page == $paginator->currentPage())
	<li><a href="#">1</a></li>
	@else
	<li><a href="{{ $url }}">{{ $page }}</a></li>
    @endif
    @endforeach
    @endif
    @endforeach  
    {{-- Next Page link --}}
    @if ($paginator->hasMorePages())  
	<li class="next"><a href="{{ $paginator->nextPageurl() }}" rel="next">Next</a></li>
	@else
	<li class="next disabled"><a>Next</a></li>
	@endif
</ul>
@endif

