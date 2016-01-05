(function()
{
	  trainingApp.config(['engStateProvider', function (state)
		{
			state.add({view: 'engViewDashboard', title: "Builder Professional Training", url: '/dashboard', role: 'ROLE_ALL', menus: {'main': 1}});
			state.add({view: 'false', title: "Software", url: 'http://www.builderprofessional.com', external:true, role: 'ROLE_ALL', menus: {'main': 2}});
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
					}
				]
			};
		}
	   
})();
