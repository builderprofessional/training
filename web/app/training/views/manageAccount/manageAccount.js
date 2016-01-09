(function ()
{
  trainingApp.config(['engStateProvider', function (state)
  {
    state.add({view: 'trainingViewManageAccount', title: 'Manage Account', url: '/manage-account', role: 'ROLE_ADMIN', menus: {'account': 100}});
  }]);
  trainingApp.directive("trainingViewManageAccount", ['$modal','$aside','engAlert', manageAccount]);
  function manageAccount($modal,$aside,engAlert)
  {
    return {
      restrict: "A",
      scope: {},
      templateUrl: "/app/training/views/manageAccount/partial.html",
      controller: ['$scope', '$http', '$location', 'PropelSOAService', 'engValidation', 'engState', 'Pagination',
        function ($scope, $http, $location, PropelSOAService, engValidation, state, Pagination)
        {
          var pQuery = PropelSOAService.getQuery('Engine', 'Billing', 'Product');

          var pmQuery = PropelSOAService.getQuery('Engine', 'Billing', 'PaymentMethod');
          pmQuery.addInnerJoin('StrategyVault');
          var query = PropelSOAService.getQuery('Engine', 'Billing', 'Client');
          query.addInnerJoin('User->Person->Email');
          query.addInnerJoin('Company->Address');
          /*
          query.addInnerJoin('Company->Phone');
          query.addInnerJoin('Company->Email');
          */
          query.addLinkedData('Status');
          query.addInnerJoin('ClientProduct->Product');
          query.addLinkedData('ClientProduct->ScheduledChange');
          $scope.reloadData = reloadData = function ()
          {
            pmQuery.runQueryOne($scope, 'paymentMethod').then(function ()
            {
              $scope.StrategyVault = $scope.paymentMethod.relations.StrategyVault;
            });
            pQuery.runQuery($scope, 'products').then(function ()
            {
              $scope.Products = $scope.products.collection;
            });
            query.runQueryOne($scope, 'BillingClient').then(function ()
              {
                $scope.Company = $scope.BillingClient.relations.Company;
                $scope.BillingClientProduct = $scope.BillingClient.relations.ClientProducts.collection[0];
                $scope.Address = $scope.Company.relations.Address;
                $scope.Product = $scope.BillingClient.relations.ClientProducts.collection[0].relations.Product;
                $scope.Person = $scope.BillingClient.relations.Users.collection[0].relations.Person;
                $scope.Emails = $scope.Person.relations.Emails.collection;
                /*
                $scope.Phones = $scope.Company.relations.Phones.collection;
                */
              });
          };
          reloadData();
          $scope.editPaymentInfo = function()
          {
            $scope.paymentInfoAside = $aside(
              {
                title:'Edit Credit Card Info',
                contentTemplate: 'payment-info-aside.html',
                scope:$scope
              });
          };
          $scope.editYourInfo = function()
          {
            $scope.yourInfoAside = $aside(
                {
                  title:'Edit Your Info',
                  contentTemplate: 'your-info-aside.html',
                  scope:$scope
                });
          };
          $scope.confirmCancel = function ()
          {
            $scope.modal = $modal(
              {
                template: '/app/training/views/manageAccount/confirm_cancel.html',
                show: true,
                backdrop: 'static',
                animation: 'am-fade',
                scope: $scope
              });
          };
          $scope.cancelService = function ()
          {
            $scope.BillingClient.cancel().then(function (result)
              {
                if (result.Type == 'success' && result.Data.canceled)
                {
                  //success
                  $scope.modal.hide();
                  engAlert.success("Your account has successfully been cancelled.  Thanks for your business.", 'accountCancel');
                  reloadData();
                }
                else
                {
                  engAlert.error("Your account could not be cancelled for some reason. We're really sorry about this.  Please call or email us and we will be happy to process your cancellation.", 'accountCancel');
                }
              });
          };
          $scope.undo = function (sid)
          {
            var change = PropelSOAService.getNewObject('Engine', 'Billing', 'ClientProductScheduledChange');
            change.model.ClientProductScheduledChangeId = sid;
            change.delete().then(function ()
              {
                engAlert.success("Your scheduled change has been undone!  Thanks.", 'accountUndo');
                reloadData();
              });
          };
        }]
    };
  }
})();