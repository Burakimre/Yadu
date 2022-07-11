@extends('layouts/app')

@section('banner')
<div class="container-fluid masthead" style="background-image: url(../images/about-header-bg.jpg);">
    <div class="overlay">
        <div class="banner-container">
            <div class="banner-text">
                <div class="banner-title">
                    {{__('about.title')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm text-center">
            <h2>
                <b>{{__('about.our_story_title')}}</b>
            </h2>
        </div>
    </div>
    <div class="row about-text">
        <div class="col-sm text-left">
            {{__('about.our_story_content')}}
        </div>
    </div>

    <div class="accordion" id="accordionExample">

      <div class="card">
        <div class="card-header" id="headingOne"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <h5 class="mb-0 btn btn-link">
              {{__('about.why_title')}}
          </h5>
        </div>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
              {!! __('about.why_content')!!}
          </div>
        </div>
      </div>

        <div class="card">
            <div class="card-header" id="headingTwo"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.how_title')}}
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.how_content')!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingThree"  data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.why_now_title')}}
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.why_now_content')!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingFour"  data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.how_does_it_work_title')}}
                </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.how_does_it_work_content')!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingFive"  data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.for_who_title')}}
                </h5>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.for_who_content')!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingSix"  data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.what_we_offer_title')}}
                </h5>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.what_we_offer_content')!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingSeven"  data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.what_we_think_we_offer_title')}}
                </h5>
            </div>
            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.what_we_think_we_offer_content')!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingEight"  data-toggle="collapse" data-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.four_pillars_title')}}
                </h5>
            </div>
            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.four_pillars_content')!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingNine"  data-toggle="collapse" data-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.social_enterprise_title')}}
                </h5>
            </div>
            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.social_enterprise_content')!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTen"  data-toggle="collapse" data-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
                <h5 class="mb-0 btn btn-link">
                    {{__('about.sustainability_title')}}
                </h5>
            </div>
            <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordionExample">
                <div class="card-body">
                    {!! __('about.sustainability_content')!!}
                </div>
            </div>
        </div>

    </div>
@endsection
