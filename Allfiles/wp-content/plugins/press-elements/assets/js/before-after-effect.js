( function( $ ) {

	var PressElementsBeforeAfterEffect = function( $scope, $ ) {

		var $settings = $( '.twentytwenty-container', $scope );

		$settings.twentytwenty( {
			default_offset_pct: $settings.data( 'starting-position' ),
			orientation: $settings.data( 'orientation' )
		} );

	}

	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/before-after-effect.default', PressElementsBeforeAfterEffect );
	} );

} )( jQuery );
