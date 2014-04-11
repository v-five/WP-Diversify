<?php

class BWGModelBWGShortcode {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public function get_gallery_rows_data() {
    global $wpdb;
    $query = "SELECT * FROM " . $wpdb->prefix . "bwg_gallery WHERE published=1 ORDER BY name";
    $rows = $wpdb->get_results($query);
    return $rows;
  }

  public function get_album_rows_data() {
    global $wpdb;
    $query = "SELECT * FROM " . $wpdb->prefix . "bwg_album WHERE published=1 ORDER BY name";
    $rows = $wpdb->get_results($query);
    return $rows;
  }

  public function get_option_row_data() {
    global $wpdb;
    $query = "SELECT * FROM " . $wpdb->prefix . "bwg_option WHERE id=1";
    $rows = $wpdb->get_row($query);
    return $rows;
  }

  public function get_theme_rows_data() {
    global $wpdb;
    $query = "SELECT * FROM " . $wpdb->prefix . "bwg_theme ORDER BY name";
    $rows = $wpdb->get_results($query);
    return $rows;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}