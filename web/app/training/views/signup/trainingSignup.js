(function()
{
  trainingApp.directive("trainingSignup",["$http","engAlert","engValidation",
  function ($http,engAlert,engValidation)
  {
    return {
      restrict: "E",
      replace:true,
      scope: {},
      templateUrl: "/app/training/views/signup/partial.html",
      controller: ['$scope',
        function($scope)
        {
          $scope.SignUp = {};
          $scope.validator = engValidation.getValidator('signup');
          $scope.save = function () {
            $scope.validator.isValid($scope.SignUp).then(function(result) {
              $http.post(env_url + "/public/training/signup", $scope.SignUp).then(function (data) {
                engAlert.success("Your request has been received, please check your email for the next steps.");
              });
            },function(result){
              engAlert.error("We didn't quite get that.  Check the signup form for errors and try again.")
              return result;
            });
          };
        }
      ]
    };
  }]);

})();