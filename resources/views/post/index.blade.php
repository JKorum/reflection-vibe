@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col p-0">
      @foreach($posts as $post)
      <div class='pb-3'>
        <div class='pt-2 pb-2 pl-3 pr-3 d-flex align-items-center'>
          <div class='pr-2'>
            <a href="/profiles/{{ $post->user->id }}">
              <img src="{{ $post->user->profile->getAvatar() }}" style="width: 40px;" class='rounded-circle'>
            </a>
          </div>
          <div class='mr-auto'>
            <a href="/profiles/{{ $post->user->id }}" class='text-decoration-none text-reset'>
              <p class='m-0 font-weight-bold'>{{ $post->user->username }}</p>
            </a>
          </div>
          <div>
            <i class="fas fa-ellipsis-h"></i>
          </div>
        </div>
        <img src="/storage/{{ $post->image }}" class="w-100">

        <!-- React component ImgActionBar.js-->
        <div class='img-action-bars pt-1 pb-2 pl-3 pr-3' data-post-id="{{ $post->id }}" data-liked="{{ $post->authUserLikedPost() }}" data-likers="{{ $post->countLikers()[0] }}" data-others="{{$post->countLikers()[1] }}"></div>


        <!-- comments preview -->
        <div class="pl-5 pr-5 pb-2">

          <!-- post caption -->
          @if($post->caption)
          <p class='m-0'><a href="/profiles/{{ $post->user->id }}" class='text-decoration-none text-reset'><span class="font-weight-bold">{{ $post->user->username }}</span></a> {{ $post->shortenCaption($post->caption, 90)['short'] }}@if($post->shortenCaption($post->caption, 90)['more'])<a href="/posts/{{$post->id}}" class='text-decoration-none text-reset'><small class='text-muted'> ...more</small></a>@endif</p>
          @endif

          <!-- post comments -->
          @if($post->comments()->count() > 0)
          @foreach($post->getFirstComments(2) as $comment)
          <p class='m-0'><a href="/profiles/{{ $comment->user_id }}" class='text-decoration-none text-reset'><span class="font-weight-bold">{{ $comment->username }}</span></a> {{ $post->shortenCaption($comment->comment, 60)['short'] }}@if($post->shortenCaption($comment->comment, 60)['more'])<a href="/posts/{{$post->id}}" class='text-decoration-none text-reset'><small class='text-muted'> ...more</small></a>@endif</p>
          @endforeach
          @endif

          <!-- comments total -->
          @if($post->comments()->count() > 2)
          <a href="/posts/{{$post->id}}" class='text-decoration-none text-reset'><small class='text-muted'>View all {{ $post->comments()->count() }} comments</small></a>
          @endif

        </div>
        <!-- React component Date -->
        <div class="posted-ago pl-3 pr-3" data-date='{{ $post->created_at }}'></div>


      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection