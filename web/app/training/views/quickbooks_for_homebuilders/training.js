(function()
{
	  trainingApp.config(['engStateProvider', function (state)
		{
			state.add({view: 'trainingViewQuickbooksForHomebuilders', title: "Quickbooks For Homebuilders", url: '/training/quickbooksForHomebuilders', role: 'ROLE_ALL', menus: {'main': 1}});
		}]);
		trainingApp.directive("trainingViewQuickbooksForHomebuilders",["PropelSOAService","engState","engAlert",trainingQB]);
		function trainingQB(PropelSOAService,engState,engAlert)
		{
			return {
				restrict: "A",
				scope: {},
				templateUrl: "/app/training/views/quickbooks_for_homebuilders/partial.html",
				controller: ['$scope',
					function($scope)
					{
            var pQuery = PropelSOAService.getQuery('Engine', 'Training', 'Course');
            pQuery.addLinkedData('Authorized');
						pQuery.addEqualFilter('Code','QUICKBOOKS_FOR_HOMEBUILDERS');
            pQuery.runQuery($scope, 'course').then(function(){
							if (! course.linkedData.Authorized)
							{
								engAlert("You are not authorized to access the Quickbooks for Homebuilders Course");
                engState.go('engViewDashboard');
							}
						});



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
								"disabled":false,
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
