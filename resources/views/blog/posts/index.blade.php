@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Все посты</h1>
                <div class="card-body">
                    @foreach($items as $item)
                        <div>{{ $item->id }} | {{ $item->title }} | <small>{{ $item->created_at }}</small></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
