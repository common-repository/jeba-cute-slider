(function() {
	tinymce.PluginManager.add('jeba_slider_button', function( editor, url ) {
		editor.addButton('jeba_slider_button', {
			text: 'Jeba-Slider',
			icon: false,
			onclick: function() {
				editor.insertContent('[jeba_slider post_type="" category="" count=""]');
			}
		});
	});
})();