@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-2 pr-0">
      <img src="{{ $user->profile->getAvatar() }}" class='rounded-circle w-100'>
    </div>
    <div class="col-10">
      <div>
        <h5 class='lead m-0'>{{ $user->username }}</h5>
        <button type='button' class="btn btn-primary btn-sm mt-1">Follow</button>
      </div>

    </div>
  </div>
  <div class='row'>
    <div class="col">
      <div class='pt-2'>
        <p class='m-0'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum repudiandae cum corporis excepturi optio magni ut similique sit nemo vel.</p>
        <a href="#">http://smth.com</a>
      </div>
      <div class='pt-2 pb-2'>
        <small>Followed by <span class='font-weight-bold'>Lilu, Korum</span>, <span class='text-muted'>and + 156 more</span></small>
      </div>
    </div>
  </div>

  <!-- hide on larger screens -->
  <div class="row border-top border-bottom p-2">
    <div class='col-4 text-center'>
      <p class="m-0 font-weight-bold">1234</p>
      <p class="m-0">posts</p>
    </div>
    <div class='col-4 text-center'>
      <p class="m-0 font-weight-bold">456</p>
      <p class="m-0">followers</p>
    </div>
    <div class='col-4 text-center'>
      <p class="m-0 font-weight-bold">4567</p>
      <p class="m-0">following</p>
    </div>
  </div>

  <!-- transform into grid? -->
  <div class="row pt-1 pl-1">
    <div class="col-4 p-0 pb-1 pr-1">
      <img src="https://source.unsplash.com/random/200x200" class='w-100'>
    </div>
    <div class="col-4 p-0 pb-1 pr-1">
      <img src="https://source.unsplash.com/random/200x200" class='w-100'>
    </div>
    <div class="col-4 p-0 pb-1 pr-1">
      <img src="https://source.unsplash.com/random/200x200" class='w-100'>
    </div>
    <div class="col-4 p-0 pb-1 pr-1">
      <img src="https://source.unsplash.com/random/200x200" class='w-100'>
    </div>
    <div class="col-4 p-0 pb-1 pr-1">
      <img src="https://source.unsplash.com/random/200x200" class='w-100'>
    </div>
    <div class="col-4 p-0 pb-1 pr-1">
      <img src="https://source.unsplash.com/random/200x200" class='w-100'>
    </div>
  </div>

</div>
@endsection