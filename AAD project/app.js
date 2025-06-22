var app=angular.module("myApp",[]);
app.controller("MainCtrl", function($scope){
    function supportsAVIF(callback){
        var avif = new Image();
        avif.src="data:image/avif;base64,AAAAIGZ0eXBhdmlmAAACAGF2aWZtAAAAAAAAAAEAAAEAAAAAAAAAAQAAAAEAAAEAAQAAAAEAAQAAAAAAAAAAAAAA";
        avif.onload=avif.onerror=function(){
            callback(avif.height==2);
        };
    }
    supportsAVIF(function(isSupported){
        $scope.$apply(function(){
            $scope.backgroundImage=isSupported ? "a_nime.avif":"an_ime.jpg";
        })
    })
})