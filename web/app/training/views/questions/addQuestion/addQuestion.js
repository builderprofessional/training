(function ()
{
  trainingApp.directive("trainingViewAddQuestion", ['$http', 'PropelSOAService',
                                                     'engAlert','$timeout','engValidation', addQuestion]);
  function addQuestion($http, PropelSOAService, engAlert,$timeout,engValidation)
  {
    return {
      restrict: "A",
      scope: {
        course:"="
      },
      templateUrl: "/app/training/views/questions/addQuestion/partial.html",
      controller: ['$scope',
        function ($scope)
        {
          $scope.Question = PropelSOAService.getNewObject('Training', 'Training', 'Question');

          $scope.Question.model.CourseId=$scope.course.getPk();
          $scope.Question.model.QuestionText='';
          $scope.validator = engValidation.getValidator({'QuestionText':['required']});
          $scope.validator.setRules({'QuestionText':['required']});
          $scope.validator.watch($scope, $scope.Question.model);
          $scope.save = function ()
          {
            $scope.waiting=true;
            $timeout(function(){
              $scope.waiting=false;
            },3000);
            $scope.validator.isValid().then(function(){
              $http.post(env_url+'/training/question',$scope.Question.model).then(function(result){
                engAlert.success("Your Question has been submitted.");
                $scope.Question = PropelSOAService.getNewObject('Training', 'Training', 'Question');
                $scope.Question.model.CourseId=$scope.course.getPk();
                $scope.Question.model.QuestionText='';
                $scope.$parent.reloadData();
              },
              function(result){
                engAlert.error("There was a problem submitting your question.");
                $scope.waiting=false;
              });
            },function(){
              engAlert.error("You must submit a question to receive an answer.");
              $scope.waiting=false;
            });
          };
        }
      ]
    };
  }
})();