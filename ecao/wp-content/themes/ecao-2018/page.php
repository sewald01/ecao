<?php get_header(); ?>
<div style="background-color:floralwhite">
	<div class="content-wrapper opaque">
		<div class="container" id="home">
			<div class="row">
				<div class="col-md-1 col-sm-0">
				</div>
				<div class="col-md-10 col-sm-12">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>">
					<h1><?php the_title(); ?>:</h1>
					<?php
					// Get children pages AND the sibling pages ONLY when on child pages 
					  if($post->post_parent)
					  $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&sort_column=menu_order&depth=1");
					  else
					  $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&sort_column=menu_order&depth=1");
					  if ($children) : 
					?>
					<div id="child-menu" >
						<ul>
							
							<?php echo $children; ?>
						</ul> 
					</div>
					<?php endif; ?>
					
					<?php the_content('<p class="serif">More &raquo;</p>'); ?>
					<?php edit_post_link('Edit this entry.', '<p class="clear"><small>', '</small></p>'); ?>
					
					<?php wp_link_pages(); ?>
				</div>
			   
				<?php endwhile; endif; ?>  
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>