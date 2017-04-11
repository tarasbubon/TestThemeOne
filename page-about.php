<?php

get_header(); ?>
	
	<!-- site-content -->
	<div class="site-content clearfix">
		
		<?php if (have_posts()) :
			while (have_posts()) : the_post(); ?>
				
				<article class="post page">
			
					<?php
						
					if ( has_children() OR $post->post_parent > 0 ) { ?>
							
						<nav class="site-nav children-links clearfix">

							<span class="parent-link"><a href="<?php echo get_the_permalink(get_top_ancestor_id()); ?>"><?php echo get_the_title(get_top_ancestor_id()); ?></a></span>

							<ul>
								<?php

								$args = array(
									'child_of' => get_top_ancestor_id(),
									'title_li' => ''
								);
								
								?>

								<?php wp_list_pages($args); ?>

							</ul>
						</nav>
							
					<?php } ?>
						
					<h2><?php the_title(); ?></h2>
					<p><?php the_content(); ?></p>
				</article> <?php

			endwhile;

		else :
			echo '<p>No content found</p>';

		endif;
		?>
		
		<h1>Blog posts about us</h1>
		<?php 
			
			$ourCurrentPage = get_query_var('paged');
			
			$aboutPosts = new WP_Query(array(
				'category_name' => 'about',
				'posts_per_page' => 3,
				'paged' => $ourCurrentPage
			));
			
			if ($aboutPosts->have_posts()) :
				while($aboutPosts->have_posts()) :
					$aboutPosts->the_post();
					?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php
				endwhile;
				
				echo paginate_links(array(
					'total' => $aboutPosts->max_num_pages
				));
				
			endif;
			
		?>
		
	</div><!-- /site-content -->
	
	<?php get_footer();

?>








