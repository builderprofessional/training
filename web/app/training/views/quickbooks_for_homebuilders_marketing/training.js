(function()
{
	  trainingApp.config(['engStateProvider', function (state)
		{
			state.add({view: 'trainingViewQuickbooksForHomebuildersMarketing', title: "Quickbooks For Homebuilders", url: '/training/quickbooksForHomebuildersInfo', role: 'ROLE_ALL',menus:{main:10}});
		}]);
		trainingApp.directive("trainingViewQuickbooksForHomebuildersMarketing",["$http",trainingQBM]);
		function trainingQBM($http)
		{
			return {
				restrict: "A",
				scope: {},
				templateUrl: "/app/training/views/quickbooks_for_homebuilders_marketing/partial.html",
				controller: ['$scope',
					function($scope)
					{
						$http.post(env_url + '/public/auth/check' + env_postfix).success(function (response)
						{
							if ( response.LoggedIn != "No" )
							{
								$scope.isLoggedIn = true;
							}
						});
					}
				]
			};
		}
	   
})();
