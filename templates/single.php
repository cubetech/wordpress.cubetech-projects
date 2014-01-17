<div class="page-content">
	<?php while (have_posts()) : the_post(); ?>
	<p class="content-title-mobile"><?php the_title(); ?></p>
	<div class="content-box" >	
		<?php 
			$contentreturn = '<ul class="cubetech-projects">';	
			$i = 0;
			
			foreach ($posts as $post) {		
				$post_meta_data = get_post_custom($post->ID);
				$post_meta = get_post($post->ID);
				
				
				//var_dump($cat);exit;
				$youtube = '';
				$titlelink = array('', '');
				if(isset($post_meta_data['cubetech_projects_movie']))
					$youtube = $post_meta_data['cubetech_projects_movie'];
				
				if($youtube[0] != '') {
					$contentreturn .= '
					<iframe width="100%" height="100%" src="//www.youtube.com/embed/' . $youtube[0] . '" frameborder="0" allowfullscreen></iframe>';
				}
				foreach($post_meta_data as $p) {
					$image = wp_get_attachment_image($p[0], 'cubetech-projects-icon');
					if ( $image && $youtube[0] == '' ) {
						$contentreturn .= '
							<li class="cubetech-projects-icon cubetech-projects-slide-' . $i . '">
								' . $image . '
							</li>';
					}
				}
			}
			echo $contentreturn . '</ul> '; 
		?>
			<div class="content-overlay">
			<div class="overlay">
			<p class="content-date"><?php the_date(); ?>  <?php $cat = get_the_term_list( $post->ID, 'cubetech_projects_group', '', '', '' ); if(strpos($cat,'2013') == false){ echo '<a href="?pdf=true"><img src="/media/fileicons/file-extension-pdf-icon.png"></a>'; }?></p>
			<p class="content-title"><?php the_title(); ?></p>
			<?php the_content(); ?>
			
			</div>
			<?php $cat = get_the_term_list( $post->ID, 'cubetech_projects_group', '', '', '' ); if(strpos($cat,'News') == false){ echo '<a id="projectsminimize" href="#"><span class="minuscontent">-</span> Info</a>'; } ?>
		</div>
		<?php $cat = get_the_term_list( $post->ID, 'cubetech_projects_group', '', '', '' ); if(strpos($cat,'News') == false){ echo '<a id="projectsmaximize" href="#"><span class="pluscontent">+</span> Info</a>'; } ?>
	</div>

	<?php if(preg_match("!MSIE\ [876]\.!i",$_SERVER['HTTP_USER_AGENT'])) { ?>
	<div id="left_arrow_projects" style="background: url(/assets/img/arrow-left.png) center center no-repeat;"></div>
	<div id="right_arrow_projects" style="background: url(/assets/img/arrow-right.png) center center no-repeat;"></div>
	<?php } else { ?>
	<div id="left_arrow_projects"></div>
	<div id="right_arrow_projects"></div>
	<?php } ?>	
	

	<div class="button-left-mobile"><a href="#">Projektinfos</a></div>
	<div class="button-right-mobile"><a href="#">Nächstes >></a></div>
	<div class="cubetech-project-progress"></div>
	
	<?php endwhile; ?>
</div>