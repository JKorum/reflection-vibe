@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">

      <div class='row mb-3'>
        <div class="col-2">
          <a href="/profiles/{{$post->user->id}}"><img src="{{ $post->user->profile->getAvatar() }}" class='rounded-circle w-100'></a>
        </div>
        <div class="col-8 pl-0">
          <h5 class='m-0'>{{ $post->user->username }}</h5>
          <small class='text-muted'>Reflected {{ $post->created_at->format('d/m/y') }}</small>
        </div>
        <div class="col-2 text-right">
          <i class="fas fa-ellipsis-h"></i>
        </div>

      </div>

      <div>
        <img src="/storage/{{ $post->image }}" class="img-fluid">
      </div>

      <div id="img-action-bar" data-post-id="{{ $post->id }}" data-liked="{{ $liked }}" data-likers="{{ $likers }}" data-others="{{ $others }}">
      </div>

      <hr class='mt-2 mb-2'>
      <div>
        {{ $post->caption }}
      </div>

    </div>
  </div>
</div>
@endsection