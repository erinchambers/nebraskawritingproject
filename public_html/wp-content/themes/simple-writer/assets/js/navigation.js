/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
    var simple_writer_primary_container, simple_writer_primary_button, simple_writer_primary_menu, simple_writer_primary_links, simple_writer_primary_i, simple_writer_primary_len;

    simple_writer_primary_container = document.getElementById( 'simple-writer-primary-navigation' );
    if ( ! simple_writer_primary_container ) {
        return;
    }

    simple_writer_primary_button = simple_writer_primary_container.getElementsByTagName( 'button' )[0];
    if ( 'undefined' === typeof simple_writer_primary_button ) {
        return;
    }

    simple_writer_primary_menu = simple_writer_primary_container.getElementsByTagName( 'ul' )[0];

    // Hide menu toggle button if menu is empty and return early.
    if ( 'undefined' === typeof simple_writer_primary_menu ) {
        simple_writer_primary_button.style.display = 'none';
        return;
    }

    simple_writer_primary_menu.setAttribute( 'aria-expanded', 'false' );
    if ( -1 === simple_writer_primary_menu.className.indexOf( 'nav-menu' ) ) {
        simple_writer_primary_menu.className += ' nav-menu';
    }

    simple_writer_primary_button.onclick = function() {
        if ( -1 !== simple_writer_primary_container.className.indexOf( 'simple-writer-toggled' ) ) {
            simple_writer_primary_container.className = simple_writer_primary_container.className.replace( ' simple-writer-toggled', '' );
            simple_writer_primary_button.setAttribute( 'aria-expanded', 'false' );
            simple_writer_primary_menu.setAttribute( 'aria-expanded', 'false' );
        } else {
            simple_writer_primary_container.className += ' simple-writer-toggled';
            simple_writer_primary_button.setAttribute( 'aria-expanded', 'true' );
            simple_writer_primary_menu.setAttribute( 'aria-expanded', 'true' );
        }
    };

    // Get all the link elements within the menu.
    simple_writer_primary_links    = simple_writer_primary_menu.getElementsByTagName( 'a' );

    // Each time a menu link is focused or blurred, toggle focus.
    for ( simple_writer_primary_i = 0, simple_writer_primary_len = simple_writer_primary_links.length; simple_writer_primary_i < simple_writer_primary_len; simple_writer_primary_i++ ) {
        simple_writer_primary_links[simple_writer_primary_i].addEventListener( 'focus', simple_writer_primary_toggleFocus, true );
        simple_writer_primary_links[simple_writer_primary_i].addEventListener( 'blur', simple_writer_primary_toggleFocus, true );
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function simple_writer_primary_toggleFocus() {
        var self = this;

        // Move up through the ancestors of the current link until we hit .nav-menu.
        while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

            // On li elements toggle the class .focus.
            if ( 'li' === self.tagName.toLowerCase() ) {
                if ( -1 !== self.className.indexOf( 'simple-writer-focus' ) ) {
                    self.className = self.className.replace( ' simple-writer-focus', '' );
                } else {
                    self.className += ' simple-writer-focus';
                }
            }

            self = self.parentElement;
        }
    }

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    ( function( simple_writer_primary_container ) {
        var touchStartFn, simple_writer_primary_i,
            parentLink = simple_writer_primary_container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

        if ( 'ontouchstart' in window ) {
            touchStartFn = function( e ) {
                var menuItem = this.parentNode, simple_writer_primary_i;

                if ( ! menuItem.classList.contains( 'simple-writer-focus' ) ) {
                    e.preventDefault();
                    for ( simple_writer_primary_i = 0; simple_writer_primary_i < menuItem.parentNode.children.length; ++simple_writer_primary_i ) {
                        if ( menuItem === menuItem.parentNode.children[simple_writer_primary_i] ) {
                            continue;
                        }
                        menuItem.parentNode.children[simple_writer_primary_i].classList.remove( 'simple-writer-focus' );
                    }
                    menuItem.classList.add( 'simple-writer-focus' );
                } else {
                    menuItem.classList.remove( 'simple-writer-focus' );
                }
            };

            for ( simple_writer_primary_i = 0; simple_writer_primary_i < parentLink.length; ++simple_writer_primary_i ) {
                parentLink[simple_writer_primary_i].addEventListener( 'touchstart', touchStartFn, false );
            }
        }
    }( simple_writer_primary_container ) );
} )();