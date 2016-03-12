(function()
{
	  trainingApp.config(['engStateProvider', function (state)
		{
			state.add({view: 'trainingViewQuickbooksForHomebuildersMarketing', title: "Quickbooks For Homebuilders", url: '/training/quickbooksForHomebuildersInfo', role: 'ROLE_ALL',menus:{main:10}});
		}]);
		trainingApp.directive("trainingViewQuickbooksForHomebuildersMarketing",["$http","$modal","engState",trainingQBM]);
		function trainingQBM($http,$modal,engState)
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
						$scope.showLightbox = function (template,title)
						{
							$scope.modal = $modal(
									{
										contentTemplate: template,
										show: true,
										backdrop: true,
										title:title,
										animation: 'lightbox-fade',
										backdropAnimation: 'lightbox-fade-bg',
										id:'lightboxModal',
										scope: $scope
									});
						};
						$scope.signup = function ()
						{
							if ( $scope.isLoggedIn )
							{
								engState.go('engViewDashboard');
							}
							else
							{
							$scope.modal = $modal(
									{
										contentTemplate: 'show-signup',
										show: true,
										backdrop: true,
										title:'Sign Up Now',
										animation: 'am-fade',
										backdropAnimation: 'am-fade',
										id:'signupModal',
										scope: $scope
									});
						};
						}
					}
				]
			};
		}
	   
})();
