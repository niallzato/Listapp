@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                Choose a List
            </div>
        </div>

        <div class="content">
            <div ng-controller="ListController as list">
            </div>
        </div>

    </div>
@endsection
