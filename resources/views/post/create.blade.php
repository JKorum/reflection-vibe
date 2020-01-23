@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <div class='mb-3'>
        <img id='image-preview' src="" class='img-fluid'>
      </div>
      <form method="POST" action="/posts" enctype="multipart/form-data">
        @csrf
        <div class="custom-file mb-3">
          <div id="choose-image"></div>
        </div>

        <div class="form-group">
          <label for="caption">Caption</label>
          <textarea class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption"></textarea>
          @error('caption')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-outline-primary">Post</button>
      </form>
    </div>
  </div>
</div>
@endsection