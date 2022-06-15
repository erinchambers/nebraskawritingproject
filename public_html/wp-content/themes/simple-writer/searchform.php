<?php
/**
* The file for displaying the search form
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<form role="search" method="get" class="simple-writer-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<label>
    <span class="simple-writer-sr-only"><?php echo esc_html_x( 'Search for:', 'label', 'simple-writer' ); ?></span>
    <input type="search" class="simple-writer-search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'simple-writer' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
</label>
<input type="submit" class="simple-writer-search-submit" value="<?php echo esc_attr_x( '&#xf002;', 'submit button', 'simple-writer' ); ?>" />
</form>