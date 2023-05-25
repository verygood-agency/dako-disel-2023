( function( $ ) {
	"use strict";

	var $win = $(window), $doc = $(document), $body = $('body');

$.fn['contentGrid'] = function() {
	return this.each(function() {
		var $this = $(this);

		$this.imagesLoaded().then(function() {
			$this.isotope(
				$.extend({}, $this.data('grid'), {
					layoutMode: 'packery',
					percentPosition: true
				})
			);
		});
	});
};
$.fn['contentGridFilter'] = function() {
	return this.each(function() {
		var targetSelector = $(this).attr('data-filter-target'),
			target = $(targetSelector),
			filter = $(this);

		filter.on('click', 'a', function(e) {
			e.preventDefault();

			$('.active', filter).removeClass('active');
			$(this).closest('li').addClass('active');

			target.isotope({
				filter: $( this ).parent().attr( 'data-filter' )
			});
		});
	});
};

$.headerSticky = function() {
	$win.on( 'scroll load', function() {
		$win.scrollTop() > $( '#site-header' ).outerHeight()
			? $( '.site-header-sticky' ).addClass( 'active' )
			: $( '.site-header-sticky' ).removeClass( 'active' );
	} );
};

$.mobileMenu = function () {
  $('ul.menu li.menu-item-has-children, ul.menu li.page_item_has_children').each(function () {
    var menuItem = $(this)
    var menuToggle = $('<span class="menu-item-toggle"><span></span></span>')

    menuToggle.insertAfter(menuItem.find('> a'))
      .on('click', function () {
        menuItem.toggleClass('menu-item-expand');
        menuItem.nextAll().removeClass('menu-item-expand');
        menuItem.prevAll().removeClass('menu-item-expand');
      })
  })
}

function NavSearch( element ) {
	this.element = $( element );
	this.toggler = $( '> a:first-child', this.element );
	this.input   = $( 'input', this.element );

	$doc.on( 'click', this.hide.bind( this ) );

	this.toggler.on( 'click', this.toggle.bind( this ) );
	this.element.on( 'click', function( e ) {
		e.stopPropagation();
	});

	this.element.on( 'keydown', ( function( e ) {
		if ( e.keyCode == 27 )
			this.hide();
	} ).bind( this ) );

	$.each( ['transitionend', 'oTransitionEnd', 'webkitTransitionEnd'], ( function( index, eventName ) {
		$( '> div', this.element ).on( eventName, ( function() {
			if ( this.element.hasClass( 'active' ) )
				this.input.get( 0 ).focus();
		} ).bind( this ) );
	} ).bind( this ) );
};

NavSearch.prototype = {
	toggle: function( e ) {
		e.preventDefault();
		e.stopPropagation();

		this.element.toggleClass( 'active' );
	},

	hide: function() {
		this.element.removeClass( 'active' );
	}
};

$.fn.navSearch = function( options ) {
	return this.each( function() {
		$( this ).data( '_navSearch', new NavSearch( this, options ) );
	} );
};

$.fn['offCanvasToggle'] = function() {
	return this.each(function() {
		var activeClass = $(this).attr('data-target') + '-active';

		$(this).on('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			$('body').toggleClass(activeClass);
		});

		$doc.on('click', function() {
			$('body').removeClass(activeClass);
		});

		$('.off-canvas').on('click', function(e) {
			e.stopPropagation();
		});
	});
};

$.gotop = function() {
	$('.go-to-top a').on('click', function() {
		$( 'html, body' ).animate({ scrollTop: 0 });
	});

	$win.on('scroll', function() {
		if ($win.scrollTop() > 0) $('.go-to-top').addClass('active');
		else $('.go-to-top').removeClass('active');
	}).on('load', function() {
		$win.trigger('scroll');
	});
};

$(function() {
	// Initialize the header sticky
	$.headerSticky();

	// Initialize the menu mobile
	$.mobileMenu();

	// Initialize go-to-top button
	$.gotop();

	// Initialize scroll down arrow
	$('.content-header .down-arrow a').on('click', function() {
		var stickyHeaderHeight = $('#site-header-sticky').height() || 0;
		var adminbarHeight = $('#wpadminbar').height() || 0;
		var contentOffset = $('.content-header').offset().top + $('.content-header').outerHeight();

		$( 'html, body' ).animate({
			scrollTop: contentOffset - (stickyHeaderHeight + adminbarHeight)
		});
	});

	// Initialize the off-canvas toggler
	$('.off-canvas-toggle').offCanvasToggle();

	// Initialize the search box toggler on the
	// navigation bar
	$('.navigator .search-box').navSearch();

	// Initialize the grid component
	$('[data-grid]').contentGrid();

	// Initialize the grid items filter
	$('[data-filter-target]').contentGridFilter();

});

$(window).on('load', function() {
  $('body').addClass('is-loaded');
});

var lastScrollTop = 0;
$(window).scroll(function(event){
   var st = $(this).scrollTop();
   if (st > lastScrollTop){
	   $('.site').addClass('scrolling_down');
	   $('.site').removeClass('scrolling_up');
   } else {
	   $('.site').addClass('scrolling_up');
	   $('.site').removeClass('scrolling_down');
   }
   lastScrollTop = st;
});


} ).call( this, jQuery )