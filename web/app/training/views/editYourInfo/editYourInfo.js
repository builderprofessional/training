(function ()
{
  engApp.directive("trainingViewEditYourInfo", ['$http', '$location', 'PropelSOAService', '$stateParams', 'engState',
                                                    'engValidation', '$q', 'engAlert', editYourInfo]);
  function editYourInfo($http, $location, PropelSOAService, $stateParams, engState, engValidation, $q, engAlert)
  {
    return {
      restrict: "A",
      scope: {},
      templateUrl: "/app/training/views/editYourInfo/partial.html",
      controller: ['$scope',
        function ($scope)
        {
          var query = PropelSOAService.getQuery(
            'Engine', 'Billing', 'Client'
          );
          query = PropelSOAService.getQuery('Engine', 'Billing', 'Client');
          query.addLinkedData('Status');
          query.addInnerJoin('User->Person->Email');
          query.addInnerJoin('Company->Address');
          var qClient = query.runQueryOne($scope, 'BillingClient');
          var qRules = engValidation.getRuleset('person');
          var qeRules = engValidation.getRuleset('email');
          var qaRules = engValidation.getRuleset('address');
          $scope.BrainTree = {};
          $q.all([qeRules,qaRules,qClient, qRules]).then(function ()
            {
              $scope.Person = $scope.BillingClient.relations.Users.collection[0].relations.Person;
              $scope.Email = $scope.Person.relations.Emails.collection[0];
              $scope.Address = $scope.BillingClient.relations.Company.relations.Address;
              $scope.pvalidator = engValidation.getValidator('person');
              $scope.pvalidator.watch($scope, $scope.Person.model);
              $scope.evalidator = engValidation.getValidator('email');
              $scope.evalidator.watch($scope, $scope.Email.model);
              $scope.avalidator = engValidation.getValidator('address');
              $scope.avalidator.watch($scope, $scope.Address.model);
            });
          $scope.cancel = function(){
            $scope.$parent.$hide();
            $scope.$parent.reloadData();
          };
          $scope.save = function ()
          {
            var personValid = $scope.pvalidator.isValid();
            var emailValid = $scope.evalidator.isValid();
            var addressValid = $scope.avalidator.isValid();
            $q.all([personValid,emailValid,addressValid]).then(function(result){
              var personSaved = $scope.Person.save({alert:'yourInfo',alertTypePrefix:'your_',messageDefault:{error:'Could not process your name change'}});
              var emailSaved = $http.post(env_url+'/auth/user/changeLogin',{'Login':$scope.Email.model.Email});
              var addressSaved = $scope.Address.save({alert:'yourInfo',alertTypePrefix:'your_',messageDefault:{error:'Could not process your address change'}});
              $q.all([personSaved,emailSaved,addressSaved]).then(function ()
              {
                $scope.$parent.$hide();
                $scope.$parent.reloadData();
                engAlert.success('Your info has been updated! Thanks.','yourInfo');
              });
            },function(result){
              engAlert.alert('your_error','Please ensure all information is correct before saving.', 'yourInfo');
            });
          };
        }
      ]
    };
  }
})();