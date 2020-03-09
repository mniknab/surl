@extends('surl::_master')

@section('content')
    <div class="col-md-10 offset-md-1">
        <form method="POST" action="{{ route('surl.store') }}">
            @csrf

            @if($errors->any())
                <ul class="alert alert-danger pl-5">
                    @foreach($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            @endif

            <div class="form-group">
                <label for="url">Long URL</label>
                <input type="url" required class="form-control" id="url" name="url" placeholder="Paste an long url" value="{{old('url')}}">
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="identifier">Custom link (optional)</label>
                    <input type="text" class="form-control" id="identifier" aria-describedby="identifierHelp" name="identifier" placeholder="Your custom link" value="{{old('identifier')}}">
                    <small id="identifierHelp" class="form-text text-muted">Leave it empty for auto-generate link</small>
                </div>
                <div class="form-group col-md-4">
                    <label for="expires_at">Expires at (optional)</label>
                    <input type="date" class="form-control" id="expires_at" aria-describedby="expiresAtHelp" name="expires_at" value="{{old('expires_at')}}">
                    <small id="expiresAtHelp" class="form-text text-muted">Leave it empty for permanent link</small>
                </div>
                <div class="form-group col-md-4">
                    <label for="title">Title (optional)</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Set your title" value="{{old('title')}}">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description (optional)</label>
                <input type="email" class="form-control" id="description" name="description" placeholder="Set your description" value="{{old('description')}}">
            </div>

            <button class="btn btn-primary" type="submit"> Submit </button>
        </form>
    </div>
@endsection
