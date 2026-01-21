(function () {
    'use strict';

    angular
        .module('app.home')
        .component('homeComponent', {
            templateUrl: 'app/modules/home/home.html',           
            controller: HomeController
        });

    HomeController.$inject = ['apiService'];


    function HomeController(apiService) {
        var vm = this;

        vm.title = 'naves do universo Star Wars';
        vm.starships = [];
        vm.isloading = true;
        vm.isLoading = true;

        vm.$onInit = function () {
            vm.isloading = true;
            vm.isLoading = true;
            apiService.getStarships()
            .then(function (data) {
                vm.starships = data;
            })
            .catch(function (error) {
                console.log("Error ao busca nave", error);
            })
            .finally(function () {
                vm.isloading = false;                    
                vm.isLoading = false;                    
            });
        };
    }
})();
