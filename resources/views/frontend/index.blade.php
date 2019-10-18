@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <div class="row">
        <div class="col col-lg-2"></div>
        <div class="col search-block">
            <h1 class="text-center">True Phone Number Lookup</h1>
            <form id="number_search" class="form-inline justify-content-center"
                  action="{{route('frontend.search-number')}}" method="POST">
                @csrf
                <div class="form-group text-center">
                    <input type="text" class="form-control" id="number" name="number" placeholder="Search a number...">
                    <button type="submit" class="btn btn-primary btn-search">Search</button>
                </div>
            </form>
            <div class="search-loader d-none">
                <i class="fas fa-3x fa-spinner fa-spin"></i>
            </div>
            <div class="row new-search d-none">
                <div class="col col-lg-2 offset-1">
                    <a href="" id="new-search">New search</a>
                </div>
            </div>
            <div class="row search-result">

            </div>
        </div>
        <div class="col col-lg-2"></div>
    </div>
    <div class="row info-block">
{{--        <div class="col col-lg-2"></div>--}}
        <div class="col text-center">
            <h3 class="second-title">How Does Our Phone Number Search Work?</h3>
            <p>Unknown and unwanted phone calls and text messages happen every single day. If you are trying to figure out who is behind a phone number, then our reverse phone number lookup is the perfect place to begin. Simply type the phone number into the search bar and then click the button to begin your search. We will do our best to locate the owner's name, age, address, and much more!</p>
        </div>
{{--        <div class="col col-lg-2"></div>--}}
    </div>
    <div class="row info-3blocks">
        <div class="col col-lg-2"></div>
        <div class="col">
            <div class="row">
                <div class="col text-center">
                    <h3 class="second-title text-center">Features</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                   <p><i class="fas fa-check"></i> Owner's Name</p>
                   <p><i class="fas fa-check"></i> Phone history</p>
                   <p><i class="fas fa-check"></i> Relatives</p>
                </div>
                <div class="col">
                   <p><i class="fas fa-check"></i> Alternative numbers</p>
                   <p><i class="fas fa-check"></i> Address</p>
                   <p><i class="fas fa-check"></i> Spam reports</p>
                </div>
                <div class="col">
                   <p><i class="fas fa-check"></i> Carrier</p>
                   <p><i class="fas fa-check"></i> Line Type</p>
                   <p><i class="fas fa-check"></i> and more...</p>
                </div>
            </div>
        </div>
        <div class="col col-lg-2"></div>
    </div>
@endsection
