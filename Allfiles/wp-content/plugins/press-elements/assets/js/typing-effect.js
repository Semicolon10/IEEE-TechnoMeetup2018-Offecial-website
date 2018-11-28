( function( $ ) {

	var PressElementsTypingEffect = function( $scope, $ ) {

		var $settings = $( '.typing-effect-strings', $scope );

		$settings.typed( {
			strings: Array.from( $settings.data( 'strings' ) ),
			typeSpeed: $settings.data( 'speed' ),
			backSpeed: $settings.data( 'back-speed' ),
			startDelay: $settings.data( 'start-delay' ),
			backDelay: $settings.data( 'back-delay' ),
			loop: !!$settings.data( 'loop' ),
			showCursor: !!$settings.data( 'show-cursor' ),
			cursorChar: $settings.data( 'cursor-char' )
		} );

	};

	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/typing-effect.default', PressElementsTypingEffect );
	} );

} )( jQuery );
