<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class AllVideoGallery_Table extends WP_List_Table {

	var $table_name;
	var $wpdb;
    
    function __construct(){
        global $status, $page;                
        parent::__construct( array( 'singular' => 'video', 'plural' => 'videos', 'ajax' => false ) );        
    }
    
    function column_default($item, $column_name){
		switch($column_name) {
			case 'actions' :
				$act  = '<div style="margin-top:9px;"><a class="button-secondary" href="?page=allvideogallery_videos&opt=edit&id='.$item->id.'" title="Edit">Edit</a>';
				$act .= '&nbsp;&nbsp;&nbsp;<a class="button-secondary" href="?page=allvideogallery_videos&opt=delete&id='.$item->id.'" title="Delete">Delete</a></div>';
				return $act;
				break;
			case 'featured'  :
				$output = ( $item->featured == 1 ) ? 'Yes' : 'No';
				return '<div style="margin-top:4px;">'.$output.'</div>';
				break;
			case 'published' :
				$output = ( $item->published == 1 ) ? 'Yes' : 'No';
				return '<div style="margin-top:4px;">'.$output.'</div>';
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
			'title'       => 'Video Title',
            'id'          => 'Video ID',            
			'category'    => 'Category',
			'ordering'    => 'Ordering',
			'featured'    => 'Featured',
			'published'   => 'Published',			
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
			foreach($_GET['video'] as $video) {
				$this->wpdb->query("DELETE FROM $this->table_name WHERE id=".$video);
        	}
			echo '<script>window.location="?page=allvideogallery_videos";</script>';
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
$data  = $wpdb->get_results("SELECT * FROM $table_name ORDER BY ordering");
$table->prepare_items( $data, $table_name, $wpdb );

?>

<br />
<br />
<div><a href="?page=allvideogallery_videos&opt=add" class="button-primary" title="addnew"><?php _e("Add New Video" ); ?></a></div>
<br />
<form id="allvideogallery-filter" method="get" style="width:99%;">
  <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
  <?php $table->display(); ?>
</form>