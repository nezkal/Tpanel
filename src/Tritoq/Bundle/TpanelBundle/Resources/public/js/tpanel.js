/*var tpanel = angular.module('Tpanel', [], function ($interpolateProvider) {
 $interpolateProvider.startSymbol('[[');
 $interpolateProvider.endSymbol(']]');
 });
 */


var Tpanel = angular.module('Tpanel', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});


Tpanel.controller('Emails', function ($scope, $http) {

    $http.get('get.json')
        .then(function (res) {
            $scope.emails = res.data;
        });

    $scope.editEvent = function (event) {
        alert(event);
    }

    $scope.predicate = 'dominio';
});
