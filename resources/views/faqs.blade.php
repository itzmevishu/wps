
@extends('layouts.default')
@section('content')

   
    <div class="row">
        <div class="col-md-12" style="">
            <h3 class="ecomm_pageTitle">FAQs</h3>

            <!-- Data -->
            <div class="alert alert-warning">
                To quickly find a specific word or phrase on this page, use the "Find on this Page" tool. First, select
                "Edit" from the tool bar and choose "Find on this page..." In the box that opens, type the word or phrase
                you are looking for. Hit the enter key to be taken to any highlighted matches.
            </div>


<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  @foreach($faqs as $faq)
   
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading_{{ $faq->unique_key }}">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $faq->unique_key }}" aria-expanded="true" aria-controls="collapseOne">
              {!! $faq->getQuestion('en') !!}
            </a>
          </h4>
        </div>
        <div id="collapse_{{ $faq->unique_key }}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_{{ $faq->unique_key }}">
          <div class="panel-body">
             {!! $faq->getAnswer('en') !!}
          </div>
        </div>
          @if(!empty($faq->tags))
              <div>
                  @foreach($faq->tags as $maven_tag)
                      <a href="?tag={{ urlencode($maven_tag) }}" class="btn btn-xs btn-default">{{ $maven_tag }}</a>
                  @endforeach
              </div>
          @endif
      </div>
  @endforeach

</div>



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

