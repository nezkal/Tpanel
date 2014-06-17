var Tpanel = angular.module('Tpanel', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});


angular.module('Tpanel').filter('datetime', function ($filter) {

    return function (input) {
        if (input == null) {
            return "";
        }

        var _date = $filter('date')(new Date(input),
            'dd/MM/yy H:mm:ss');

        return _date.toUpperCase();

    };
});

Tpanel.controller('Emails', function ($scope, $http) {

    $http.get('get.json')
        .then(function (res) {
            $scope.emails = res.data;
        });

    $scope.predicate = 'dominio';
});


Tpanel.controller('Vhosts', function ($scope, $http) {

    $http.get('get.json')
        .then(function (res) {
            $scope.vhosts = res.data;
        });

    $scope.predicate = 'dominio';
});
