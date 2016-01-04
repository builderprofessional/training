(function()
{
	  trainingApp.config(['engStateProvider', function (state)
		{
			state.add({view: 'trainingViewQuickbooksForHomebuilders', title: "Quickbooks For Homebuilders", url: '/training/quickbooksForHomebuilders', role: 'ROLE_ALL', menus: {'main': 1}});
		}]);
		trainingApp.directive("trainingViewQuickbooksForHomebuilders",traingQB);
		function trainingQB()
		{
			return {
				restrict: "A",
				scope: {},
				templateUrl: "/app/training/views/quickbooks_for_homebuilders/partial.html",
				controller: ['$scope',
					function($scope)
					{
						angular.noop();
					}
				]
			};
		}
	   
})();
