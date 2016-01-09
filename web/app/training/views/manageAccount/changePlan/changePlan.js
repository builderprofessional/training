(function ()
{
  trainingApp.config(['engStateProvider', function (state)
  {
    state.add(
      {
        view: 'engViewChangePlan',
        title: 'Edit Account',
        url: '/change-plan',
        role: 'ROLE_ALL',
        parent: 'engViewManageAccount'
      });
  }]);
  trainingApp.directive("engViewChangePlan", ['engAlert', 'PropelSOAService', 'engValidation', '$q', '$filter','$state',
                                               changePlan]);
  function changePlan(engAlert, PropelSOAService, engValidation, $q, $filter, $state)
  {
    return {
      restrict: "A",
      scope: {},
      templateUrl: "/app/training/views/manageAccount/changePlan/partial.html",
      controller: ['$scope',
        function ($scope)
        {
          var query = PropelSOAService.getQuery(
            'Engine', 'Billing', 'Client'
          );

          query.addInnerJoin('ClientProduct->Product');
          query.addLinkedData('ClientProduct->ScheduledChange');
          query.addLinkedData('UserCount');

          var pQuery = PropelSOAService.getQuery('Engine', 'Billing', 'Product');
          pQuery.addLinkedData('UpgradePrice');

          var qClient = query.runQueryOne($scope, 'BillingClient');
          var qRes = pQuery.runQuery($scope, 'productresult');

          var qRules = engValidation.getRuleset('strategyvault');
          $q.all([qRes, qClient, qRules]).then(function ()
            {
              $scope.Products = $scope.productresult.collection;
              $scope.ClientProduct = $scope.BillingClient.relations.ClientProducts.collection[0];
              $scope.Product = $scope.BillingClient.relations.ClientProducts.collection[0].relations.Product;
              $scope.Products.sort(function (a, b)
                {
                  return  ((a.model.Position < b.model.Position) ? -1 : (a.model.Position > b.model.Position) ? 1 : 0 );
                });
            });
          $scope.selectedProductId = false;
          $scope.isSelected = function (myval)
          {
            return function (inval)
            {
              var valid = ($scope.selectedProductId && inval.model.ProductId == $scope.selectedProductId) || !$scope.selectedProductId;
              return valid;
            };
          };
          $scope.change = function (plan)
          {
            if ($.isEmptyObject(plan))
            {
              $scope.selectedProductId = false;
            }
            else
            {
              $scope.selectedProductId = plan.model.ProductId;
            }
          };
          $scope.confirm = function (plan)
          {
            $scope.ClientProduct.model.ProductId = plan.model.ProductId;

            $scope.ClientProduct.save().then(function (what)
              {
                var charged = plan.linkedDataModel.UpgradePrice.total > 0 ? "Your card has been charged " + $filter('engCurrency')(plan.linkedDataModel.UpgradePrice.total) + '.' : '';
                $scope.ProductChanged = true;
                $state.go('engViewManageAccount');
                engAlert.success('Your plan change request has been processed. ' + charged + " Thank you.",'planChangeSuccess');
              });
          };
        }]
    };
  }
})();
