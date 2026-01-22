(function (){
    'use strict';
    angular
        .module('app.shared')
        .component('filterModal', {
            templateUrl: 'app/shared/filter-modal/filter-modal.html',
            bindings: {
                dataset: '<'
            },
            controller: FilterModalController
        });
    FilterModalController.$inject = ['$rootScope'];
    
    function FilterModalController($rootScope) {
        var vm = this;
        vm.filters ={
            name: '',
            manufacturer: '',
            cost: { min: null, max: null },
            cargo: { min: null, max: null },
            starshipClass:""        
        };
        vm.apply = function(){
            $rootScope.$broadcast('UPDATE_FILTERS', vm.filters);
        };

        vm.clear = function() {
            vm.filters = {
                name: '',
                manufacturer: '',
                cost: { min: null, max: null },
                cargo: { min: null, max: null },
                starshipClass: ""
            };
            vm.apply();
        };
    }

})();