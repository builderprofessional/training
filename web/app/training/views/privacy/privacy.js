(function ()
{
  trainingApp.directive("viewPrivacy", ['$http', '$location', '$stateParams', 'engState',
    'engAlert','$modal', privacy]);
  function privacy($http, $location, $stateParams, engState, engAlert, $modal)
  {
    return {
      restrict: "A",
      scope: {},
      templateUrl: "/app/training/views/privacy/partial.html",
      controller: ['$scope',
        function ($scope)
        {
          $scope.Privacy = {};

          $scope.cancel = function(){
            $scope.privacyModal.hide();
          };
        }
      ]
    };
  }
})();