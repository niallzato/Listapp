(function () {
    'use strict';

    angular.module('ListApp',[])
    .controller('ListController', ListController)
    .service('ListService', ListService);

    ListController.$inject = ['ListService'];
    function ListController(ListService) {
        var list = this;

        list.mylist= "";
        list.warn = '';


        var promise = ListService.getList();

        promise.then(function (response) {
            list.mylist = response.data;
        });


        list.updateList = function() {
            var add = ListService.addToList(list.item);

            add.then(function (response){
                return ListService.getList();
            })
            .catch(function (error){
                list.warn = error;
            })
            .then(function(response){
                list.mylist = response.data;
            });
        }


        list.deleteFromList = function() {
            var del = ListService.deleteFromList(list.del);

            del.then(function (response){
                return ListService.getList();
            })
            .catch(function (error){
                list.warn = error;
            })
            .then(function(response){
                list.mylist = response.data;
            });
        }

    }

    ListService.$inject = ['$http'];
    function ListService($http){
        var service = this;

        service.addToList = function(item){
            var response = $http({
                method: 'POST',
                url:'/add',
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

        service.getList = function(){
            var response = $http({
                method: 'GET',
                url:'/get'
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

    }
})();