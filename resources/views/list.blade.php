@extends('surl::_master')

@section('content')
    <div class="col-md-12">
        @if (session('message'))
            <div class="alert alert-{{ session('message.type') }} alert-dismissible fade show" role="alert">
                {{ session('message.content') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="float-right my-3">
            <a class="btn btn-sm btn-primary" href="{{ route('surl.create') }}" role="button">Create new SURL</a>
        </div>

        <div class="table-responsive mb-3">
            <table class="table text-center">
                <tr>
                    <th>Title</th>
                    <th>Url</th>
                    <th>Identifier</th>
                    <th>Impressions</th>
                    <th style="min-width: 120px;">Expires At</th>
                    <th style="min-width: 200px;"></th>
                </tr>

                @foreach ($list as $surl)
                    <tr>
                        <td class="text-truncate">{{ $surl->title ?? '--' }} </td>
                        <td class="text-truncate">{{ $surl->url }} </td>
                        <td><a href="{{route('surl.redirect',$surl->identifier)}}" target="_blank">{{ $surl->identifier }}</a></td>
                        <td>{{ $surl->impression_count }}</td>
                        <td>{!! $surl->toArray()['expires_at'] ?? "&infin;" !!}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info copy-btn" data-clipboard-text="{{ route('surl.redirect', $surl->identifier) }}">Copy</button>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('surl.edit', $surl->id) }}" role="button">Edit</a>
                            <form method="POST" action="{{ route('surl.destroy', $surl->id) }}" onsubmit="return confirm('Do you really want to delete this record?');">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-outline-danger" href="#" role="button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{ $list->links() }}
    </div>
@endsection

@section('styles')
    <style>
        form {
            display: inline-block;
        }
        table{
            min-width: 800px;
        }
        .text-truncate{
            max-width: 200px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        let clipboard = new ClipboardJS('.copy-btn');

        clipboard.on('success', function(e) {
            e.trigger.innerText = 'Copied!';
        });
    </script>
@endsection
