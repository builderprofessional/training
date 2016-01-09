(function ()
{
  trainingApp.directive("trainingViewAddQuestion", ['$http', 'PropelSOAService',
                                                     'engAlert','$timeout', addQuestion]);
  function addQuestion($http, PropelSOAService, engAlert,$timeout)
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
          $scope.save = function ()
          {
            $scope.waiting=true;
            $timeout(function(){
              $scope.waiting=false;
            },3000);
            $http.post(env_url+'/training/question',$scope.Question.model).then(function(result){
              engAlert.success("Your Question has been submitted.");
              $scope.Question = PropelSOAService.getNewObject('Training', 'Training', 'Question');
              $scope.Question.model.CourseId=$scope.course.getPk();
              $scope.Question.model.QuestionText='';
              $scope.$parent.reloadData();
            },
            function(result){
              engAlert.error("There was a problem submitting your question.");
            });
          };
        }
      ]
    };
  }
})();