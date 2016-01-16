(function()
{
  trainingApp.directive("trainingFooter",["APP_CONFIG",
  function (APP_CONFIG)
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
        }
      ]
    };
  }]);

})();