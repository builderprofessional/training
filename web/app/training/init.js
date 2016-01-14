// define our angular app that encompasses all of our pages and inject all
// module dependencies
trainingApp = angular.module('TrainingApp', ['engApp', 'engAuth', 'ngAnimate', 'engState', 'mgcrea.ngStrap', 'LocalStorageModule','vjs.video']);
engApp.constant('APP_CONFIG',{
  App: {
    Name: "Builder Professional Training"
  },
  contactMethods:[
    {
        'cssClass' : 'address',
        'label' : 'Address: ',
        'value' : 'PO Box 121068 Arlington, TX 76012',
    },
    {
        'cssClass' : 'phone',
        'label' : 'Phone: ',
        'value' : '(844) 63-BUILD / (844) 632-8453',
    },
    {
        'cssClass' : 'email',
        'label' : 'Support: ',
        'value' : 'support@builderprofessional.com',
    },
    {
        'cssClass' : 'email',
        'label' : 'Sales: ',
        'value' : 'sales@builderprofessional.com',
    },
  ]

});
//configure routing defaults
trainingApp.config(function ($locationProvider, $urlRouterProvider, $httpProvider)
{
    $httpProvider.defaults.headers.common['Cache-Control'] = 'no-cache';
    $urlRouterProvider.otherwise('/dashboard');

    // this will allow us to communicate cross domain
    $httpProvider.defaults.useXDomain = true;
    $locationProvider.html5Mode(false);
});


//configure datepicker defaults
trainingApp.config(function($datepickerProvider) {
  angular.extend($datepickerProvider.defaults, {
    dateFormat: 'MM/dd/yyyy',
    startWeek: 1,
    autoclose: true
  });
});

//configure modal/aside defaults
trainingApp.config(function($asideProvider){
  angular.extend($asideProvider.defaults,
     {
       template: '/app/engine/engApp/components/elements/aside/eng-aside.html',
       show: true
     }
  );
});

//bootstrap the app when the page is done loading
angular.element(document).ready(function ()
{
    angular.bootstrap(document.body, ['TrainingApp']);
});
