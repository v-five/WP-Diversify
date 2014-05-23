<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class AllVideoGallery_Table extends WP_List_Table {

	var $table_name;
	var $wpdb;
    
    function __construct(){
        global $status, $page;                
        parent::__construct( array( 'singular' => 'profile', 'plural' => 'profiles', 'ajax' => false ) );        
    }
    
    function column_default($item, $column_name){
		switch($column_name) {
			case 'actions' :
				$act  = '<div style="margin-top:9px;"><a class="button-secondary" href="?page=allvideogallery_profiles&opt=edit&id='.$item->id.'" title="Edit">Edit</a>';
				$act .= '&nbsp;&nbsp;&nbsp;<a class="button-secondary" href="?page=allvideogallery_profiles&opt=delete&id='.$item->id.'" title="Delete">Delete</a></div>';
				return $act;
				break;
			default :
				return '<div style="margin-top:4px;">'.$item->$column_name.'</div>';
				break;
		}
    }

    function column_cb($item){
        return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], $item->id );
    }
	
	function get_columns(){
        $columns = array(
            'cb'          => '<input type="checkbox" />',
			'name'        => 'Profile Name',
            'id'          => 'Profile ID',            
			'width'       => 'Player Width',
			'height'      => 'Player Height',
			'actions'     => 'Actions'
        );
        return $columns;
    }

    function get_bulk_actions() {
        $actions = array( 'delete' => 'Delete' );
        return $actions;
    }

    function process_bulk_action() {
		if( 'delete'===$this->current_action() ) {			
			foreach($_GET['profile'] as $profile) {
				$this->wpdb->query("DELETE FROM $this->table_name WHERE id=".$profile);
        	}
			echo '<script>window.location="?page=allvideogallery_profiles";</script>';
		}
    }

    function prepare_items( $data, $table_name, $wpdb ) {
		$this->table_name = $table_name;
		$this->wpdb = $wpdb;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
		
        $this->process_bulk_action();

 		$per_page = 5;
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;

        $this->set_pagination_args( array( 'total_items' => $total_items, 'per_page' => $per_page, 'total_pages' => ceil($total_items/$per_page) ) );
    }
    
}

$table = new AllVideoGallery_Table();
$data  = $wpdb->get_results("SELECT * FROM $table_name");
$table->prepare_items( $data, $table_name, $wpdb );

?>

<div style="width:99%; margin:15px 0px;">
  <table class="widefat" cellpadding="0">
    <thead>
      <tr>
        <th><?php _e( "Our Website" ); ?></th>
        <th><?php _e( "Support Mail ID" ); ?></th>
        <th><?php _e( "Forum Link" ); ?></th>
        <th><?php _e( "Report Bugs" ); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr height="30">
        <td><?php _e( "http://allvideogallery.mrvinoth.com/" ); ?></td>
        <td><?php _e( "support@mrvinoth.com" ); ?></td>
        <td><?php _e( "http://allvideogallery.mrvinoth.com/forum/" ); ?></td>
        <td><?php _e( "issues@mrvinoth.com" ); ?></td>
      </tr>
    </tbody>
  </table>
</div>
<div style="clear:both; margin:15px 0px;"><a href="?page=allvideogallery_profiles&opt=add" class="button-primary" title="addnew"><?php _e("Add New Profile" ); ?></a></div>
<form id="allvideogallery-filter" method="get" style="width:99%;">
  <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
  <?php $table->display(); ?>
</form>