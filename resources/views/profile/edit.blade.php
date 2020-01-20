@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <div class='row mb-3'>
        <div class="col-2">
          <img src="{{ $user->profile->getAvatar() }}" class='rounded-circle w-100'>
        </div>
        <div class="col-10 pl-0">
          <h5 class='m-0'>{{ $user->username }}</h5>
          <small class='text-muted'>Reflecting since {{ $user->created_at->format('d/m/y') }}</small>
        </div>
      </div>
      <hr>
      <form method="POST" action="/profiles/{{ Auth::user()->id }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{Auth::user()->profile->description}}</textarea>
          @error('description')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="website">Website</label>
          <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ Auth::user()->profile->website ?? '' }}">
          @error('website')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="custom-file mb-3">
          <div id="choose-avatar"></div>
        </div>
        <button type="submit" class="btn btn-outline-primary">Save</button>
      </form>

    </div>

  </div>
</div>
@endsection