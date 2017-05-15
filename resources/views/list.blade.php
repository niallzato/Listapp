<!doctype html>
<html lang="{{ config('app.locale') }}" ng-app="ListApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 50vh;
            }

            .flex-center {
                align-items: center;
                display: block;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            li{
                color: black;
                font-size: 18px;
            }
        </style>
        <script src="/js/angular.js"></script>
        <script src="/js/jquery.js"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

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
                            <input type="text" name="name" ng-model="list.item.name" required>
                            <input type="number" name="quantity" ng-model="list.item.quantity" required>

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
                    </div>
                </div>
            </div>

        </div>

    </body>
    <script src="/js/my-app.js"></script>
</html>
