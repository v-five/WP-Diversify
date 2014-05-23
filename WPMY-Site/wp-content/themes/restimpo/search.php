<?php
/**
 * The search results template file.
 * @package RestImpo
 * @since RestImpo 1.0.0
*/
get_header(); ?>

<div id="wrapper-content">
<?php if ( have_posts() ) : ?>
  <div class="content-headline-wrapper">
    <div class="content-headline">
      <h1><?php printf( __( 'Search Results for: %s', 'restimpo' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </div>
  </div>
  <div class="container">
  <div id="main-content">
    <div id="content"> 
<p class="number-of-results"><?php _e( '<strong>Number of Results</strong>: ', 'restimpo' ); ?><?php echo $wp_query->found_posts; ?></p>
<?php while (have_posts()) : the_post(); ?>      
<?php get_template_part( 'content', 'archives' ); ?>
<?php endwhile; ?>

<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		<div class="navigation" role="navigation">
			<h2 class="navigation-headline section-heading"><?php _e( 'Search results navigation', 'restimpo' ); ?></h2>
      <div class="nav-wrapper">
			<p class="nav-previous"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Previous results', 'restimpo' ) ); ?></p>
      <p class="nav-next"><?php next_posts_link( __( 'Next results <span class="meta-nav">&rarr;</span>', 'restimpo' ) ); ?></p>
      </div>
		</div>
<?php endif; ?>

<?php else : ?>
  <div class="content-headline-wrapper">
    <div class="content-headline">
      <h1><?php _e( 'Nothing Found', 'restimpo' ); ?></h1>
    </div>
  </div>
  <div class="container">
  <div id="main-content">
    <div id="content">
    <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'restimpo' ); ?></p><?php get_search_form(); ?>
<?php endif; ?>
    </div> <!-- end of content -->
  </div>
<?php get_sidebar(); ?>
  </div>
</div>     <!-- end of wrapper-content -->
<?php get_footer(); ?>