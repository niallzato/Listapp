@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                My Lists
            </div>
        </div>
        <div class="content">
            <div ng-controller="ListController as list">
                <ul>
                    <li ng-repeat="list in list.mylists" ng-if="list.list_name">
                        <a ng-href="list/@{{list.name}}" ng-bind="list.id"></a>
                    </li>
                </ul>

                <div>
                    <h4>Create a List</h4>
                    <form>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
