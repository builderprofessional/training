(function ()
{
  trainingApp.directive("trainingViewQuestions", ["$filter","PropelSOAService","Pagination",
    function ($filter, PropelSOAService, Pagination)
    {
      return {
        restrict: "E",
        scope: {
          course:"="
        },
        templateUrl: "/app/training/views/questions/partial.html",
        controller: ['$scope', function ($scope)
        {
          $scope.questionPagination = new Pagination("questions");
          $scope.reloadData = function()
          {
            var cQuery = PropelSOAService.getQuery(
                'Training', 'Training', 'Question'
            );
            var uQuery = PropelSOAService.getQuery(
                'Engine', 'Auth', 'User'
            );
            uQuery.runQueryOne($scope,'user');
            cQuery.addEqualFilter('CourseId',$scope.course.model.CourseId);
            cQuery.addLinkedData('QuestionText');
            cQuery.addInnerJoin('Answer');
            cQuery.addLinkedData('Answer->AnswerText');
            cQuery.runQuery($scope, 'questions');
          };
          $scope.reloadData();

        }]
      };
    }]
  );
})();
