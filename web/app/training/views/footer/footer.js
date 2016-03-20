(function()
{
  trainingApp.directive("trainingFooter",["APP_CONFIG", '$modal',
  function (APP_CONFIG, $modal)
  {
    return {
      restrict: "E",
      replace:true,
      scope: {},
      templateUrl: "/app/training/views/footer/partial.html",
      link:function(){
        var a = !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

      },
      controller: ['$scope',
        function($scope)
        {
          $scope.config = APP_CONFIG;

          $scope.privacy = function ()
          {
            $scope.privacyModal = $modal({
              'title': 'Builder Professional Privacy Policy',
              'contentTemplate': 'privacy-modal.html',
              scope: $scope
            });
          };

          $scope.refundPolicy = function ()
          {
            $scope.refundPolicyModal = $modal({
              'title': 'Builder Professional Refund Policy',
              'contentTemplate': 'refund-policy-modal.html',
              scope: $scope
            });
          };
        }
      ]
    };
  }]);

})();