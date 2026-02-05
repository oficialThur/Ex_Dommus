angular.module('app.shared')
    .directive('classSelect', ['$timeout', function ($timeout) {
        return{
            restrict: 'A',
            require: 'ngModel',
             link: function(scope, element, attrs, ngModelCtrl) {
                scope.$watch(attrs.sourceData, function(newVal) {
                    if (newVal && newVal.length > 0) {
                        
                        $timeout(function() {
                            var allClasses = newVal.map(function(ship) {
                                return ship.starship_class;
                            });
                            
                            var uniqueClasses = allClasses.filter(function(item, index) {
                                return item && allClasses.indexOf(item) === index;
                            }).sort(); 

                            var htmlOptions = '<option value="">Todas as Classes</option>';
                            angular.forEach(uniqueClasses, function(cls) {
                                htmlOptions += '<option value="' + cls + '">' + cls + '</option>';
                            });

                            element.html(htmlOptions);

                            if (ngModelCtrl.$viewValue) {
                                element.val(ngModelCtrl.$viewValue);
                            }
                        });
                    }
                });

                element.on('change', function() {
                    scope.$apply(function() {
                        ngModelCtrl.$setViewValue(element.val());
                    });
                });
            }
        } 
    }]);