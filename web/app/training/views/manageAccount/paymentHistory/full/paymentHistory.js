(function ()
{
  trainingApp.config(['engStateProvider', function (state)
  {
    state.add({view: 'engViewPaymentHistoryFull', url: '/payment-history', role: 'ROLE_ADMIN' });
  }]);
  trainingApp.directive("engViewPaymentHistoryFull", paymentHistoryFull);
  function paymentHistoryFull()
  {
    return {
      restrict: "A",
      scope: {
        limit: "@"
      },
      templateUrl: "/app/training/views/manageAccount/paymentHistory/full/partial.html",
      // Note this is just a wrapper to give statefulness and pagination to the basic functionality of payment history
      // all controller functionality is in the main paymentHistory partial.
    };
  }
})();