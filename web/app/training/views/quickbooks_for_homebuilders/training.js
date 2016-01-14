(function()
{
	  trainingApp.config(['engStateProvider', function (state)
		{
			state.add({view: 'trainingViewQuickbooksForHomebuilders', title: "Quickbooks For Homebuilders", url: '/training/quickbooksForHomebuilders', role: 'ROLE_ALL', menus: {'main': 1}});
		}]);
		trainingApp.directive("trainingViewQuickbooksForHomebuilders",["PropelSOAService","engState","engAlert",'$timeout',trainingQB]);
		function trainingQB(PropelSOAService,engState,engAlert,$timeout)
		{
			return {
				restrict: "A",
				scope: {},
				templateUrl: "/app/training/views/quickbooks_for_homebuilders/partial.html",
				controller: ['$scope',
					function($scope)
					{
            var pQuery = PropelSOAService.getQuery('Training', 'Training', 'Course');
            pQuery.addLinkedData('Authorized');
						pQuery.addEqualFilter('Code','QUICKBOOKS_FOR_HOMEBUILDERS');
            pQuery.runQueryOne($scope, 'course').then(function(){
							if (! $scope.course || ! $scope.course.linkedDataModel || ! $scope.course.linkedDataModel.Authorized)
							{
								engAlert("Access to the Quickbooks for Homebuilders Course requires logging in");
                engState.go('engViewDashboard');
							}
						},function(){
							engAlert.error("Access to the Quickbooks for Homebuilders Course requires logging in");
							engState.go('engViewDashboard');
						});
						/*
						$scope.$on('event:auth-bufferRejected',function(){
							$timeout(function(){
								engAlert.error("You are not authorized to access the Quickbooks for Homebuilders Course");
								engState.go('engViewDashboard');
							},250);
						});
						*/



						$scope.tabs = [
							{
								"title":"Video",
								"name":"video",
								"disabled":false,
								"src":"/app/training/views/quickbooks_for_homebuilders/video.html"
							},
							{
								"title":"E-book",
								"name":"ebook",
								"disabled":false,
								"src":"/app/training/views/quickbooks_for_homebuilders/ebook.html"
							},
							{
								"title":"Resources",
								"name":"resources",
								"disabled":false,
								"src":"/app/training/views/quickbooks_for_homebuilders/resources.html"
							},
							{
								"title":"Questions And Answers",
								"name":"qanda",
								"disabled":true,
								"src":"/app/training/views/quickbooks_for_homebuilders/qanda.html"
							},
						];
						$scope.tabs.activeTab = 1;
						$scope.switchTo = function(tab)
						{
							for(i=0;i<$scope.tabs.length;i++)
							{
								if (tab == $scope.tabs[i].name)
								{
									$scope.tabs.activeTab = i;
								}
							}
						};
					}
				]
			};
		}
	   
})();
