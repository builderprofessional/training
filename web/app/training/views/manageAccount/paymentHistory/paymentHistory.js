(function ()
{
  trainingApp.directive("engViewPaymentHistory", paymentHistory);
  function paymentHistory()
  {
    return {
      restrict: "A",
      scope: {
        limit: "@",
        paginate: "="
      },
      templateUrl: "/app/training/views/manageAccount/paymentHistory/partial.html",
      controller: ['$scope', '$http', '$location', 'PropelSOAService', 'engValidation', 'engState', 'Pagination',
        function ($scope, $http, $location, PropelSOAService, engValidation, state, Pagination)
        {
          $scope.paymentPagination = new Pagination("PaymentList");
          clientQuery = PropelSOAService.getQuery(
            'Engine', 'Billing', 'PaymentAttempt'
          );
          clientQuery.addInnerJoin('PaymentAttemptStatus');
          clientQuery.addInnerJoin('Product');
          clientQuery.runQuery($scope, 'payments').then(function ()
            {
              $scope.limit = parseInt($scope.limit);
              if ($scope.limit === 0)
              {
                $scope.limit = 99999;
              }
              if (!$scope.paginate)
              {
                $scope.paymentPagination.setPerPageOptions([$scope.limit]);
                $scope.paymentPagination.setPerPage($scope.limit);
              }
            });
          $scope.sortCol = 'model.DateCreated.date';
          $scope.sortRev = true;
        }]
    };
  }
})();