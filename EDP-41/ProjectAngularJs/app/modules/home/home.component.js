(function () {
    'use strict';

    angular
        .module('app.home')
        .component('homeComponent', {
            templateUrl: 'app/modules/home/home.html',           
            controller: HomeController
        });

    HomeController.$inject = ['apiService', '$rootScope'];


    function HomeController(apiService, $rootScope) {
        var vm = this;

        vm.title = 'naves do universo Star Wars';
        vm.starships = [];
        vm.allStarships = [];
        vm.isLoading = true;

        vm.$onInit = function () {
            $rootScope.$on('UPDATE_FILTERS', function (event, filters) {
                var filterHelpers = {
                    matchesText: function (value, filterValue) {
                        if (!filterValue) return true;
                        var normalized = (value || '').toLowerCase();
                        return normalized.includes(filterValue.toLowerCase());
                    },
                    matchesRange: function (value, range) {
                        if (!range || (!range.min && !range.max)) return true;
                        var numValue = parseInt(value);
                        if (isNaN(numValue)) return false;
                        
                        if (range.min && numValue < range.min) return false;
                        if (range.max && numValue > range.max) return false;
                        return true;
                    },
                    matchesExact: function (value, filterValue) {
                        if (!filterValue) return true;
                        return (value || '').trim() === filterValue.trim();
                    }
                };

                vm.starships = vm.allStarships.filter(function (nave) {
                    return filterHelpers.matchesText(nave.name, filters.name) &&
                           filterHelpers.matchesText(nave.manufacturer, filters.manufacturer) &&
                           filterHelpers.matchesRange(nave.cost_in_credits, filters.cost) &&
                           filterHelpers.matchesRange(nave.cargo_capacity, filters.cargo) &&
                           filterHelpers.matchesExact(nave.starship_class, filters.starshipClass);
                });
            });
            vm.isLoading = true;
            apiService.getStarships()
            .then(function (data) {
                vm.allStarships = data;
                vm.starships = angular.copy(data);
            })
            .catch(function (error) {
                console.log("Error ao busca nave", error);
            })
            .finally(function () {
                vm.isLoading = false;                    
            });
        };
    }
})();
