@extends('surl::_master')

@section('content')
    <div class="col-md-10 offset-md-1">
        <form method="POST" action="{{ route('surl.update',$surl['id']) }}">
            @method('PUT')
            @csrf

            @if($errors->any())
                <ul class="alert alert-danger pl-5">
                    @foreach($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            @endif

            <div class="form-group">
                <label for="url">{{__('surl::inputs.url')}}</label>
                <input type="url" required class="form-control" id="url" name="url" placeholder="{{__('surl::inputs.url_placeholder')}}" value="{{old('url',$surl['url'])}}">
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="identifier">{{__('surl::inputs.identifier')}}</label>
                    <input type="text" class="form-control" id="identifier" aria-describedby="identifierHelp" name="identifier" placeholder="{{__('surl::inputs.identifier_placeholder')}}" value="{{old('identifier',$surl['identifier'])}}">
                    <small id="identifierHelp" class="form-text text-muted">{{__('surl::inputs.identifier_help')}}</small>
                </div>
                <div class="form-group col-md-4">
                    <label for="expires_at">{{__('surl::inputs.expires_at')}}</label>
                    <input type="date" class="form-control" id="expires_at" aria-describedby="expiresAtHelp" name="expires_at" value="{{old('expires_at',$surl['expires_at'])}}">
                    <small id="expiresAtHelp" class="form-text text-muted">{{__('surl::inputs.expires_at_help')}}</small>
                </div>
                <div class="form-group col-md-4">
                    <label for="title">{{__('surl::inputs.title')}}</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="{{__('surl::inputs.title_placeholder')}}" value="{{old('title',$surl['title'])}}">
                </div>
            </div>

            <div class="form-group">
                <label for="description">{{__('surl::inputs.description')}}</label>
                <input type="email" class="form-control" id="description" name="description" placeholder="{{__('surl::inputs.description_placeholder')}}" value="{{old('description',$surl['description'])}}">
            </div>

            <button class="btn btn-primary" type="submit"> {{__('surl::inputs.submit_button')}} </button>
        </form>
    </div>
@endsection
