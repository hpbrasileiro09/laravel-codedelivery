angular.module('starter.controllers', [])

.controller('LoginCtrl', 
	['$scope', '$state', 'OAuth', '$ionicPopup', 
	function($scope, $state, OAuth, $ionicPopup) {

  $scope.user = {
  	username: '',
  	password: '' 
  };

  $scope.login = function() {
  	OAuth.getAccessToken($scope.user).then(function(data) {
		$state.go('home', {}, {reload: true});
  	}, function(responseError) {
		var alertPopup = $ionicPopup.alert({
			title: 'Login failed',
			template: 'Please check your credentials!'
		});
		console.debug(responseError);
  	});
  };

}])
