(function ()
{
  trainingApp.directive("trainingViewAddAnswer", ['$http', 'PropelSOAService',
                                                     'engAlert','$timeout','engValidation', addAnswer]);
  function addAnswer($http, PropelSOAService, engAlert,$timeout,engValidation)
  {
    return {
      restrict: "A",
      scope: {
        question:"="
      },
      templateUrl: "/app/training/views/questions/addAnswer/partial.html",
      controller: ['$scope',
        function ($scope)
        {
          $scope.Answer = PropelSOAService.getNewObject('Training', 'Training', 'Answer');

          $scope.Answer.model.QuestionId=$scope.question.getPk();
          $scope.Answer.model.AnswerText='';
          $scope.validator = engValidation.getValidator({'AnswerText':['required']});
          $scope.validator.setRules({'AnswerText':['required']});
          $scope.validator.watch($scope, $scope.Answer.model);
          $scope.save = function ()
          {
            $scope.waiting=true;
            $timeout(function(){
              $scope.waiting=false;
            },3000);
            $scope.validator.isValid().then(function(){
              $http.post(env_url+'/training/answer',$scope.Answer.model).then(function(result){
                engAlert.success("Your Answer has been submitted.");
                $scope.Answer = PropelSOAService.getNewObject('Training', 'Training', 'Answer');
                $scope.Answer.model.QuestionId=$scope.question.getPk();
                $scope.Answer.model.AnswerText='';
                $scope.$parent.reloadData();
              },
              function(result){
                engAlert.error("There was a problem submitting your answer.");
                $scope.waiting=false;
              });
            },function(){
              engAlert.error("You must submit an answer.");
              $scope.waiting=false;
            });
          };
        }
      ]
    };
  }
})();