
@extends('layouts.default')
@section('content')

   
    <div class="row">
        <div class="col-md-12" style="">
            <h3 class="ecomm_pageTitle">FAQs</h3>

            <!-- Data -->

@foreach($faqs as $faq)
    <a id="{{ $faq->unique_key }}"></a>
    {!! $faq->question !!}<br><br>
    {!! $faq->answer !!}<br><br>
    <hr>
@endforeach

<!-- Pager -->

{!! $faqs->links() !!}
            
        </div>
    </div>
    
@stop
@section('scripts')
    <script>
        $( "div.rowVC:even" ).css( "background-color", "#dbe5eb" );
    </script>


@stop

