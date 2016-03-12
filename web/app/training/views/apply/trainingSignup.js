(function()
{
  trainingApp.directive("trainingSignup",["$http","engAlert","engValidation",
  function ($http,engAlert,engValidation)
  {
    return {
      restrict: "E",
      replace:true,
      scope: {},
      templateUrl: "/app/training/views/apply/partial.html",
      controller: ['$scope',
        function($scope)
        {
          $scope.SignUp = {};
          engValidation.getRuleset("signup").then(function(){
            $scope.validator = engValidation.getValidator('signup');
            $scope.validator.watch($scope, $scope.SignUp);
          });
          $scope.save = function () {
            $scope.loading=true;
            $scope.validator.isValid($scope.SignUp).then(function(result) {
              $http.post(env_url + "/public/training/signup/json", $scope.SignUp).then(function (result) {
                engAlert.success("Your request has been received, please check your email for the next steps.");
                $scope.SignUp.signupId = result.data.Data.signupId;
                $scope.loading=false;
              },function(){
                $scope.loading=false;
              });
            },function(result){
              engAlert.error("We didn't quite get that.  Check the signup form for errors and try again.");
              $scope.loading=false;
              return result;
            });
          };
        }
      ]
    };
  }]);

})();