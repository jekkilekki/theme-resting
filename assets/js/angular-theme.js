var wpApp = new angular.module( 'wpAngularTheme', [ 'ui.router', 'ngResource' ] );

// Angular Factory
wpApp.factory( 'Posts', function( $resource ) {
    return $resource( appInfo.api_url + 'posts/:ID', {
        ID: '@id'
    });
});

// Angular Controller for Index Pages
wpApp.controller( 'ListCtrl', [ '$scope', 'Posts', function( $scope, Posts ) {
    console.log( 'ListCtrl' );
    $scope.page_title = 'Blog Listing';
    Posts.query( function( res ) {
        $scope.posts = res;
    });
}]);

// Angular Controller for Single Pages
wpApp.controller( 'DetailCtrl', [ '$scope', '$stateParams', 'Posts', function( $scope, $stateParams, Posts ) {
        console.log( $stateParams );
        Posts.get( { ID: $stateParams.id }, function( res ) {
           $scope.post = res; 
        });
}]);

// Angular Route
wpApp.config( function( $stateProvider, $urlRouterProvider ) {
    $urlRouterProvider.otherwise( '/' );
    $stateProvider
            .state( 'list', {
                url: '/',
                controller: 'ListCtrl',
                templateUrl: appInfo.template_directory + 'templates/list.html'
            })
            .state( 'detail', {
                url: '/posts/:id',
                controller: 'DetailCtrl',
                templateUrl: appInfo.template_directory + 'templates/detail.html'
            });
});

// Trust our HTML
wpApp.filter( 'to_trusted', [ '$sce', function( $sce ) {
    return function( text ) {
        return $sce.trustAsHtml( text );
    }    
}]);