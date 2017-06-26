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
                        <a ng-href="list/@{{list.list_name}}" ng-bind="list.list_name"></a>
                    </li>
                </ul>

                <div>
                    <h4>Create a List</h4>
                    <form name="createForm" novalidate>
                        {{csrf_field()}}
                        <input type="text" name="name" ng-model="list.create.name" required>

                        <button ng-disabled="createForm.$invalid" ng-click="list.createList();">Create </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
