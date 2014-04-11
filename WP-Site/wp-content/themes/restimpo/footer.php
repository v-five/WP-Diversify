<?php
/**
 * The footer template file.
 * @package RestImpo
 * @since RestImpo 1.0.0
*/
?>
<footer id="wrapper-footer">
  <div id="footer">
<?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
    <div class="footer-widget-area footer-widget-area-1">
<?php dynamic_sidebar( 'sidebar-2' ); ?>
    </div>
<?php } ?>
<?php if ( is_active_sidebar( 'sidebar-3' ) ) { ?>    
    <div class="footer-widget-area footer-widget-area-2">
<?php dynamic_sidebar( 'sidebar-3' ); ?>
    </div>
<?php } ?>
 <?php if ( is_active_sidebar( 'sidebar-4' ) ) { ?>   
    <div class="footer-widget-area footer-widget-area-3">
<?php dynamic_sidebar( 'sidebar-4' ); ?>
    </div>
<?php } ?>
  </div>  
<?php if ( dynamic_sidebar( 'sidebar-5' ) ) : else : ?>
<?php endif; ?>
</footer>  <!-- end of wrapper-footer -->
<?php wp_footer(); ?>      
</body>
</html>