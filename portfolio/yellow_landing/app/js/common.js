jQuery(document).ready(function($) {
	$('.slider').owlCarousel({
		loop:true,
		items: 1,
		margin: 1
	});
	
	var menu = $("#main-menu");
	var menuIcon = $('.top-section__hamburger');
	
	menu.mmenu({
		"extensions": [
			"pagedim-black"
		],
		"navbar": {
			title: '<img class="" src="img/logo.png" alt="Unique Tech">'
		},
		"navbars": [
			{
				"position": "bottom",
				"content": '<span>(+966-322 322)</span>'
			}
		]

	},
	{
		clone: true,
		"position": "bottom",
		"content": [
			"<a class='fa fa-envelope' href='#/'></a>",
			"<a class='fa fa-twitter' href='#/'></a>",
			"<a class='fa fa-facebook' href='#/'></a>"
		]
	});

	//   Get the API
	var mmMenu = $("#mm-main-menu");
	var api = mmMenu.data( "mmenu" );
	api.close( mmMenu );


	api.bind( "open:finish", function() {
		setTimeout(function() {
			menuIcon.addClass( "is-active" );
		}, 50);
	});

	api.bind( "close:finish", function() {
		setTimeout(function() {
			menuIcon.removeClass( "is-active" );
		}, 50);
	});

});
