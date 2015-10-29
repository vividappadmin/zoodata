/**
* SUSHI DOLL TALK PLUGIN
* By: ~Atsusa Kai~
*/
;(function($) {

$.fn.SushiDollTalk = function(options) {

	return this.each( function() {

		var o = {
			'initialIndex': 0,
			'initialDelay': 6000,
			'classes': 'any-class yet-another-class',
			'dialogues': [
				{
					'speech': 'This is a sample dialogue.',
					'duration': 5000,
					'classes': 'any-class'
				},
				{
					'speech': 'This is a another sample dialogue.',
					'duration': 6000,
					'classes': 'yet-another-class'
				}
			],
			'debug': false
		};

		if (options)
			$.extend(o, options);

		if (o.initialDelay < 1000)
			o.initialDelay = 1000;

		var $this = $(this);
		$this.o = o;

		$this.talk = function() {
			
			if ( $this.o.dialogues.length <= 0 )
				return;
				
			clearTimeout(t);
			t = setTimeout( $this.talk, $this.o.dialogues[index].duration );

			$this.stop().fadeOut( 500, function() {

				if ( $this.o.debug )
					console.log( 'Talk[' + index + ']: ' + $this.o.dialogues[index].speech + ' (for ' + $this.o.dialogues[index].duration + ' milliseconds.) / (' + $this.o.dialogues[index].classes + ')' );

				$this.html( $this.o.dialogues[index].speech );
				$this.parent().removeClass( $this.o.classes ).addClass( $this.o.dialogues[index].classes );
				$this.stop().fadeIn( 500, function() {
					index++;
					if ( index >= $this.o.dialogues.length )
						index = 0;
				});
			});
		}

		var index = $this.o.initialIndex;
		var t = setTimeout( $this.talk, $this.o.initialDelay );

	});

};

})(jQuery);