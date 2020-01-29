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

        @can('update', $user->profile)
        <a href="/profiles/{{ $user->id }}/edit" class='btn btn-outline-primary btn-sm mt-2'>Profile</a>
        @else
        @if(auth()->check())
        <!-- React component FollowButton -->
        <div id='follow-btn' data-following='{{ $following ? 1 : 0 }}'></div>
        @else
        <a href="/login" class='btn btn-outline-primary btn-sm mt-2'>Follow</a>
        @endif
        @endcan

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
        @if($user->profile->description)
        <p class='m-0'>{{ $user->profile->description }}</p>
        @endif
        @if($user->profile->website)
        <a href="{{ $user->profile->website }}" target="_blank" rel="noopener noreferrer">{{ $user->profile->website }}</a>
        @endif
      </div>

      <!-- React component ProfileInfo -->
      <div id="profile-info-section" class='pt-2' data-posts-count='{{$user->posts->count()}}' data-profile-followers-count='{{$user->profile->followers()->count()}}' data-profile-following-count='{{$user->following()->count()}}' data-first-followers-names='{{ $firstFollowersNames }}' data-rest-followers='{{ $restFollowers > 0 ? $restFollowers : 0 }}'>
      </div>

    </div>
  </div>

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