<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://kingsdesign.com.au
 * @since      1.0.0
 *
 * @package    Kd_Ajax_Search_Bar
 * @subpackage Kd_Ajax_Search_Bar/public/partials
 */
?>

<div class="kd-ajax-search-bar">
    <?php /*<div class="kdasb-container">*/ ?>
        <form role="search" method="get" class="kdasb-form" action="<?= esc_url( home_url( '/' ) ); ?>">
            <div class="kdasb-form-group">
                <label class="kdasb-sr-only"><?= _x( 'Search for:', 'label' ); ?></label>
                <input type="search" class="kdasb-search-field" placeholder="<?= esc_attr_x( 'Search our Catalogue &hellip;', 'placeholder' ); ?>" value="<?= get_search_query(); ?>" name="s" />
            </div>
            <input type="submit" class="kdasb-button" value="<?= esc_attr_x( 'Search', 'submit button' ); ?>" />
            <div class="kdasb-search-form-results-ajax"></div>
        </form>
    <?php /*</div>*/ ?>
</div>