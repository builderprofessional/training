(function ()
{
  trainingApp.directive("trainingViewQuestions", ["$filter","PropelSOAService","Pagination","$sce",
    function ($filter, PropelSOAService, Pagination, $sce)
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
            var uQuery = PropelSOAService.getNewObject(
                'Engine', 'Auth', 'User'
            );
            uQuery.current($scope,'user',{skip:{error:true}}).then(function(){
              console.log('have user');
            });
            cQuery.addEqualFilter('CourseId',$scope.course.model.CourseId);
            cQuery.addLinkedData('QuestionText');
            cQuery.addInnerJoin('Answer');
            cQuery.addLinkedData('Answer->AnswerText');
            cQuery.runQuery($scope, 'questions').then(
                function() {
                  angular.forEach($scope.questions.collection,
                      function (q) {
                        angular.forEach(q.relations.Answers.collection, function (a) {
                          a.linkedDataModel.AnswerText = $sce.trustAsHtml(a.linkedDataModel.AnswerText);
                        });
                      }
                  );
                }
            );
          };
          $scope.reloadData();

        }]
      };
    }]
  );
})();
