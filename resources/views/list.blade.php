@extends('layouts.app')

@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            List App
        </div>
    </div>

    <div class="content">
        <div ng-controller="ListController as list">
            <div ng-bind="list.warn"></div>
            <div>
                <div>Add To List</div>
                <form name="listForm" novalidate>
                    {{csrf_field()}}
                    <input placeholder="item" type="text" name="name" ng-model="list.item.name" required>
                    <input placeholder="quantity" type="number" name="quantity" ng-model="list.item.quantity" required>

                    <button ng-disabled="listForm.$invalid" ng-click="list.updateList();">Update </button>
                </form>
            </div>
            <ul>
                <li ng-repeat="(key, val) in list.mylist track by $index">
                    <span ng-bind="key"></span>
                    <span ng-bind="val"></span>
                </li>
            </ul>
            <div ng-if="list.mylist">
                <div>Delete from List</div>
                <form name="deleteForm" novalidate>
                    {{csrf_field()}}
                    <input type="text" name="name" ng-model="list.del.name" required>

                    <button ng-disabled="deleteForm.$invalid" ng-click="list.deleteFromList();">Update </button>
                </form>
                <br>
                <br>
                <form name="deleteList" novalidate>
                    {{csrf_field()}}
                    <button ng-click="list.deleteList();">Clear List</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
