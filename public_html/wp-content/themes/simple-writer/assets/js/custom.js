jQuery(document).ready(function($) {
    'use strict';

    if(simple_writer_ajax_object.primary_menu_active){

        if(simple_writer_ajax_object.sticky_menu_active){
        // grab the initial top offset of the navigation 
        var simplewriterstickyNavTop = $('.simple-writer-primary-menu-container').offset().top;
        
        // our function that decides weather the navigation bar should have "fixed" css position or not.
        var simplewriterstickyNav = function(){
            var simplewriterscrollTop = $(window).scrollTop(); // our current vertical position from the top
                 
            // if we've scrolled more than the navigation, change its position to fixed to stick to top,
            // otherwise change it back to relative

            if(simple_writer_ajax_object.sticky_mobile_menu_active){
                if (simplewriterscrollTop > simplewriterstickyNavTop) {
                    $('.simple-writer-primary-menu-container').addClass('simple-writer-fixed');
                } else {
                    $('.simple-writer-primary-menu-container').removeClass('simple-writer-fixed');
                }
            } else {
                if(window.innerWidth > 1112) {
                    if (simplewriterscrollTop > simplewriterstickyNavTop) {
                        $('.simple-writer-primary-menu-container').addClass('simple-writer-fixed');
                    } else {
                        $('.simple-writer-primary-menu-container').removeClass('simple-writer-fixed'); 
                    }
                }
            }
        };

        simplewriterstickyNav();
        // and run it again every time you scroll
        $(window).on( "scroll", function() {
            simplewriterstickyNav();
        });
        }

        $(".simple-writer-nav-primary .simple-writer-primary-nav-menu").addClass("simple-writer-primary-responsive-menu");

        $( ".simple-writer-primary-responsive-menu-icon" ).on( "click", function() {
            $(this).next(".simple-writer-nav-primary .simple-writer-primary-nav-menu").slideToggle();
        });

        $(window).on( "resize", function() {
            if(window.innerWidth > 1112) {
                $(".simple-writer-nav-primary .simple-writer-primary-nav-menu, nav .sub-menu, nav .children").removeAttr("style");
                $(".simple-writer-primary-responsive-menu > li").removeClass("simple-writer-primary-menu-open");
            }
        });

        $( ".simple-writer-primary-responsive-menu > li" ).on( "click", function(event) {
            if (event.target !== this)
            return;
            $(this).find(".sub-menu:first").toggleClass('simple-writer-submenu-toggle').parent().toggleClass("simple-writer-primary-menu-open");
            $(this).find(".children:first").toggleClass('simple-writer-submenu-toggle').parent().toggleClass("simple-writer-primary-menu-open");
        });

        $( "div.simple-writer-primary-responsive-menu > ul > li" ).on( "click", function(event) {
            if (event.target !== this)
                return;
            $(this).find("ul:first").toggleClass('simple-writer-submenu-toggle').parent().toggleClass("simple-writer-primary-menu-open");
        });

    }

    if($(".simple-writer-social-icon-search").length){
        $( ".simple-writer-social-icon-search" ).on( "click", function(e) {
            e.preventDefault();
            document.getElementById("simple-writer-search-overlay-wrap").style.display = "block";
            const simple_writer_focusableelements = 'button, [href], input';
            const simple_writer_search_modal = document.querySelector('#simple-writer-search-overlay-wrap');
            const simple_writer_firstfocusableelement = simple_writer_search_modal.querySelectorAll(simple_writer_focusableelements)[0];
            const simple_writer_focusablecontent = simple_writer_search_modal.querySelectorAll(simple_writer_focusableelements);
            const simple_writer_lastfocusableelement = simple_writer_focusablecontent[simple_writer_focusablecontent.length - 1];
            document.addEventListener('keydown', function(e) {
              let isTabPressed = e.key === 'Tab' || e.keyCode === 9;
              if (!isTabPressed) {
                return;
              }
              if (e.shiftKey) {
                if (document.activeElement === simple_writer_firstfocusableelement) {
                  simple_writer_lastfocusableelement.focus();
                  e.preventDefault();
                }
              } else {
                if (document.activeElement === simple_writer_lastfocusableelement) {
                  simple_writer_firstfocusableelement.focus();
                  e.preventDefault();
                }
              }
            });
            simple_writer_firstfocusableelement.focus();
        });
    }

    if($(".simple-writer-search-closebtn").length){
        $( ".simple-writer-search-closebtn" ).on( "click", function(e) {
            e.preventDefault();
            document.getElementById("simple-writer-search-overlay-wrap").style.display = "none";
        });
    }

    if(simple_writer_ajax_object.fitvids_active){
        $(".post").fitVids();
    }

    if(simple_writer_ajax_object.backtotop_active){
        if($(".simple-writer-scroll-top").length){
            var simple_writer_scroll_button = $( '.simple-writer-scroll-top' );
            simple_writer_scroll_button.hide();

            $( window ).on( "scroll", function() {
                if ( $( window ).scrollTop() < 20 ) {
                    $( '.simple-writer-scroll-top' ).fadeOut();
                } else {
                    $( '.simple-writer-scroll-top' ).fadeIn();
                }
            } );

            simple_writer_scroll_button.on( "click", function() {
                $( "html, body" ).animate( { scrollTop: 0 }, 300 );
                return false;
            } );
        }
    }

    if(simple_writer_ajax_object.sticky_sidebar_active){
        $('.simple-writer-main-wrapper, .simple-writer-sidebar-wrapper').theiaStickySidebar({
            containerSelector: ".simple-writer-content-wrapper",
            additionalMarginTop: 0,
            additionalMarginBottom: 0,
            minWidth: 960,
        });

        $(window).on( "resize", function() {
            $('.simple-writer-main-wrapper, .simple-writer-sidebar-wrapper').theiaStickySidebar({
                containerSelector: ".simple-writer-content-wrapper",
                additionalMarginTop: 0,
                additionalMarginBottom: 0,
                minWidth: 960,
            });
        });
    }

});