(function () {
    'use strict';

    angular.module('ListApp',[], function($locationProvider){
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });
    })
    .controller('ListController', ListController)
    .service('ListService', ListService);

    ListController.$inject = ['ListService'];
    function ListController(ListService) {

        var list = this;

        list.mylist= "";
        list.warn = '';
        list.name = ListService.getName();


        var mylist = ListService.getList(list.name);

        mylist.then(function (response) {
            list.mylist = response.data;
        });

        var mylists = ListService.getLists();

        mylists.then(function (response) {
            list.mylists = response.data;
        });


        list.createList = function() {
            var create = ListService.createList(list.create);

            create.then(function (response){
                return ListService.getLists();
            })
            .catch(function (error){
                list.warn = error;
            })
            .then(function(response){
                list.mylists = response.data;
            });
        }

        list.updateList = function() {
            var add = ListService.addToList(list.name, list.item);

            add.then(function (response){
                return ListService.getList(list.name);
            })
            .catch(function (error){
                list.warn = error;
            })
            .then(function(response){
                list.mylist = response.data;
            });
        }


        list.deleteFromList = function() {
            var del = ListService.deleteFromList(list.name, list.del);

            del.then(function (response){
                return ListService.getList(list.name);
            })
            .catch(function (error){
                list.warn = error;
            })
            .then(function(response){
                list.mylist = response.data;
            });
        }

        list.deleteList = function() {
            var del = ListService.deleteList(list.name);

            del.then(function (response){
                return ListService.getList(list.name);
            })
            .catch(function (error){
                list.warn = error;
            })
            .then(function(response){
                list.mylist = response.data;
            });
        }

    }

    ListService.$inject = ['$http', '$location'];
    function ListService($http, $location){
        var service = this;

        service.getName = function(){
            var path = $location.path();
            path = path.split('/')

            return path[path.length-1];
        }

        service.createList = function(list){
            var response = $http({
                method: 'POST',
                url:'/addlist',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                params: {
                    name: list.name
                }
            })

            return response;
        }


        service.addToList = function(item, name){
            var response = $http({
                method: 'POST',
                url:'/add/'+name,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                params: {
                    name: item.name,
                    quant: item.quantity
                }
            })

            return response;
        }

        service.getLists = function(){
            var response = $http({
                method: 'GET',
                url:'/getlists'
            })

            return response;
        }

        service.getList = function(name){
            var response = $http({
                method: 'GET',
                url:'/getlist/'+name
            })

            return response;
        }

        service.deleteFromList = function(del){
            var response = $http({
                method: 'POST',
                url:'/del',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                params: {
                    name: del.name
                }
            })

            return response;
        }

        service.deleteList = function(){
            var response = $http({
                method: 'POST',
                url:'/delete',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            return response;
        }


    }
})();