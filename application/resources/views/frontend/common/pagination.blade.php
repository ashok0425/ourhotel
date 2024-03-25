@if ($paginator->hasPages())

    <!-- Pagination -->
    <div class="pagination my-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="text-white custom-fw-700"><i class="fa fa-caret-left"></i></i></a>
        @else
   
 @if (count(Request()->all())>2)
                    
 <?php 
 $p=$paginator->currentPage()-1;
      $page="&page=$p";

 ?>
 @else  
 <?php 

 $page=''
 ?>
             @endif
            <a class="prevposts-link  custom-bg-primary text-white custom-fw-700" href="{{ Request::fullUrl()."$page" }}"><i class="fa fa-caret-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
           
                @if (count(Request()->all())>2)
                    
    <?php 
         $url=Request::fullUrl()."&page=$page";
    ?>
                @endif

                    @if ($page == $paginator->currentPage())

                        <span class="current-page text-white custom-fw-700" style ="background-color:#007f80;padding: 5px 8px;">{{ $page }}</span>
                    @elseif ((($page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() - 1) || $page == $paginator->lastPage()) && !isMobile())
                        <a href="{{ $url }}" class="text-white custom-fw-700">{{ $page }}</a>
                    @elseif (($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2) || $page == $paginator->lastPage())
                        <a href="{{ $url }}" class="text-white custom-fw-700">{{ $page }}</a>
                    @elseif ($page == $paginator->lastPage() - 1)
                        <a class="text-white custom-fw-700">...</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
     
 @if (count(Request()->all())>2)
                    
 <?php 
 $p=$paginator->currentPage()+1;
      $page="&page=$p";

 ?>
 @else  
 <?php 

 $page=''
 ?>
             @endif
            <a class="nextposts-link text-white custom-fw-700" href="{{ Request::fullUrl()."$page" }}">
               <i class="fa fa-caret-right"></i>
            </a>
        @else
            <a>
                <i class="fa fa-caret-right text-white custom-fw-700"></i>
            </a>
        @endif
    </div>
    <!-- Pagination -->
@endif