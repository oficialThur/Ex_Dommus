(function(){
    'use strict';
    angular
        .module('app.core')
        .service('apiService', apiService);
        function apiService($http, $q){
            var service = this;
            service.getStarships = function(){
                var deferred = $q.defer();
                $http.get('https://swapi.info/api/starships')
                    .then(function(response){
                        deferred.resolve(response.data.results);
                    })
                    .catch(function(error){
                        deferred.reject(error);
                    });
                return deferred.promise;
            };
        } 
        apiService.$inject = ['$http', '$q'];    
})();