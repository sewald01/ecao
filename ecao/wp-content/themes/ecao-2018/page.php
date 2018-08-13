<?php get_header(); ?>

<div class="content-wrapper-b opaque">
	<div class="container" id="home">
		<div class="row">
			<div class="col-md-1 col-sm-0">
			</div>
			<div class="col-md-10 col-sm-12">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>">
				<h1><?php the_title(); ?>:</h1>
				<?php the_content('<p class="serif">More &raquo;</p>'); ?>
				<?php edit_post_link('Edit this entry.', '<p class="clear"><small>', '</small></p>'); ?>
				
				<?php wp_link_pages(); ?>
			</div>
		   
			<?php endwhile; endif; ?>  
			</div>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>