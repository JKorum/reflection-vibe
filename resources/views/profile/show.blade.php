@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-2 pr-0">
      <img src="{{ $user->profile->getAvatar() }}" class='rounded-circle w-100'>
    </div>
    <div class="col-6">
      <div>
        <h5 class='lead m-0'>
          {{ $user->username }}
          @can('update', $user->profile)
          <a href="/profiles/{{ $user->id }}/edit" class='text-reset'><i class="fas fa-edit fa-xs"></i></a>
          @endcan
        </h5>
        <button type='button' class="btn btn-outline-primary btn-sm mt-2">Follow</button>
      </div>
    </div>
    <div class='col-4 text-right'>
      @can('update', $user->profile)
      <a href="/posts/create" class="text-decoration-none">
        <p class='m-0'>Add Post</p>
      </a>
      @endcan
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
      <p class="m-0 font-weight-bold">{{ $user->posts->count() }}</p>
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
    @foreach($posts as $post)
    <div class="col-4 p-0 pb-1 pr-1 position-relative post-img-container">
      <a href="/posts/{{ $post->id }}"><img src="/storage/{{ $post->image }}" class='w-100'></a>
      <div class="position-absolute post-img-overlay pb-1 pr-1">
        <div>
          <i class="fas fa-heart"></i> {{ $post->likes()->count() }}
        </div>
        <div>
          <i class="fas fa-comment"></i> {{ $post->comments()->count() }}
        </div>
      </div>
    </div>
    @endforeach
  </div>

</div>
@endsection