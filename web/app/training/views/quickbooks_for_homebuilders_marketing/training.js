(function()
{
	  trainingApp.config(['engStateProvider', function (state)
		{
			state.add({view: 'trainingViewQuickbooksForHomebuildersMarketing', title: "Quickbooks For Homebuilders", url: '/training/quickbooksForHomebuildersInfo', role: 'ROLE_ALL',menus:{main:10}});
		}]);
		trainingApp.directive("trainingViewQuickbooksForHomebuildersMarketing",["PropelSOAService","engState","engAlert",'$timeout',trainingQBM]);
		function trainingQBM(PropelSOAService,engState,engAlert,$timeout)
		{
			return {
				restrict: "A",
				scope: {},
				templateUrl: "/app/training/views/quickbooks_for_homebuilders_marketing/partial.html",
				controller: ['$scope',
					function($scope)
					{
					}
				]
			};
		}
	   
})();
