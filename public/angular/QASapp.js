var app = angular.module('QASapp',['ng-showdown','bootstrap-tagsinput','ui.bootstrap','ngAnimate','rzModule']);
app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});