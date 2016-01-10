(function()
{
	  trainingApp.config(['engStateProvider', function (state)
		{
			state.add({view: 'engViewDashboard', title: "Training Home", url: '/dashboard', role: 'ROLE_ALL', menus: {'main': 1}});
		}]);
		trainingApp.directive("engViewDashboard",["engState","$http",dashboard]);
		function dashboard(engState,$http)
		{
			return {
				restrict: "A",
				scope: {},
				templateUrl: "/app/training/views/dashboard/partial.html",
				controller: ['$scope',
					function($scope)
					{
						$http.post(env_url + '/public/auth/check' + env_postfix).success(function (response)
						{
							if ( response.LoggedIn != "No" )
							{
								engState.go("trainingViewQuickbooksForHomebuilders");
							}
						});
						$scope.$on('event:auth-loginConfirmed', function () {
							engState.go("trainingViewQuickbooksForHomebuilders");
						});
					}
				]
			};
		}
	   
})();
