(function () {
    'use strict';
    
    angular
        .module('app.shared')
        .component('starshipCard', {
            templateUrl: 'app/shared/starship-card/starship-card.html',
            bindings: {
                nave: '<'
            },
            controller: StarshipCardController
        });
    function StarshipCardController() {
        var vm = this;
    }
}());