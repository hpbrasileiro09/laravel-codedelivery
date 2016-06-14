angular.module('starter.controllers', [])

.controller('LoginCtrl', 
	['$scope', '$state', 'OAuth', '$cookies', '$ionicPopup', 
	function($scope, $state, OAuth, $cookies, $ionicPopup) {

  $scope.user = {
  	username: '',
  	password: '' 
  };

  $scope.login = function() {
  	OAuth.getAccessToken($scope.user).then(function(data) {
  		console.log(data);
  		console.log($cookies.getObject('token'));
		var alertPopup = $ionicPopup.alert({
			title: 'Login Success',
			template: 'Welcome Folk!'
		});
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
