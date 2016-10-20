<?php

class wp_ng_theme {
	
	function enqueue_scripts() {
		
		wp_enqueue_style( 'bootstrapCSS', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css', array(), '20161020', 'all' );
		wp_enqueue_script( 'angular-core', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js', array( 'jquery' ), '20161020', false );
		wp_enqueue_script( 'angular-resource', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-resource.js', array( 'angular-core' ), '20161020', false );
                wp_enqueue_script( 'ui-router', 'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.min.js', array( 'angular-core' ), '20161020', false );
		wp_enqueue_script( 'ngScripts', get_template_directory_uri() . '/assets/js/angular-theme.js', array( 'ui-router' ), '20161020', false );
		wp_localize_script( 'ngScripts', 'appInfo',
			array(
				
				'api_url'		=> rest_get_url_prefix() . '/wp/v2/',
				'template_directory'    => get_template_directory_uri() . '/',
				'nonce'			=> wp_create_nonce( 'wp_rest' ),
				'is_admin'		=> current_user_can( 'administrator' )
				
			)
		);
		
	}
        
        function register_new_field() {
            
            register_rest_field( 'post', 'this_fun_field',
                    array(
                        'get_callback' => array( $this, 'fun_field' )
                    )
            );
            
        }
        
        function fun_field( $object, $field_name, $request ) {
            // Can get post meta here if desire using $object[ 'id' ]
            // Also, plugin ACF to WP-API makes Advanced Custom Fields data available in the WP-API
            // https://github.com/times/acf-to-wp-api
            return "This is a fun field";
        }
	
}

$ngTheme = new wp_ng_theme();
add_action( 'wp_enqueue_scripts', array( $ngTheme, 'enqueue_scripts' ) );

?>