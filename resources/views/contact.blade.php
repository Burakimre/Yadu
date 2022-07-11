@extends('layouts/app')

@section('banner')
<div class="container-fluid masthead" style="background-image: url(../images/contact-header-bg.jpg);">
    <div class="overlay">
        <div class="banner-container">
            <div class="banner-text">
                <div class="banner-title">
                    {{__('contact.contact_title')}}
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
            <b>{{__('contact.contact_us_title')}}</b>
        </h2>
    </div>
</div>

<div class="row about-text">
    <div class="col-sm-6 text-left">
        {!! __('contact.contact_us_content') !!}
    </div>
    <div class="col-sm-6 text-left">
        <div class="contact-item">
            <h5>{{__('contact.email')}}</h5>
            <a href="mailto:{{$socialmedia->find('email')->link}}" class="contact-item">
                <span>{{$socialmedia->find('email')->link}}</span>
            </a>
        </div>

        <div class="contact-item">
            <h5>{{__('contact.kvk')}}</h5>
            <span>62039482</span>
        </div>
        <div class="contact-item">
            <h5>{{__('contact.social')}}</h5>
            <a href="{{$socialmedia->find('linkedin')->link}}" target="_blank">
                <i class="fab fa-linkedin media-icons"></i>
            </a>
            <a href="{{$socialmedia->find('twitter')->link}}" target="_blank" class="contact-item">
                <i class="fab fa-twitter media-icons"></i>
            </a>
            <a href="{{$socialmedia->find('facebook')->link}}" target="_blank" class="contact-item">
                <i class="fab fa-facebook media-icons"></i>
            </a>
            <a href="{{$socialmedia->find('instagram')->link}}" target="_blank" class="contact-item">
                <i class="fab fa-instagram media-icons"></i>
            </a>
        </div>
    </div>
</div>
@endsection