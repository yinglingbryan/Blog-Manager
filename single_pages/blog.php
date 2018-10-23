<?php  
	defined('C5_EXECUTE') or die("Access Denied.");
	$this->inc('elements/header.php'); 
	
	// Helpers
	$ih = Core::make('helper/image');
	
	// Featured Image
	$featuredImage = $c->getAttribute('featured_image');
	if( $featuredImage ){
		$featuredImage = $featuredImage->getURL();
	}
?>
	<div class="section masthead" style="background-image:url('<?php echo $featuredImage; ?>');">
		<div class="overlay"></div>
		
		<div class="content">
			<h1><?php print $c->getAttribute('display_title'); ?></h1>
		</div>
	</div>
	
	<div class="section blog-full">
		<div class="content">
			<ul class="category-menu">
				<li class="disabled"><a>Category</a></li>
				<?php 
					if( $categories ){
						foreach( $categories as $key=>$category ){
							echo '<li><a href="/blog/category/'.$key.'">'.$category.'</a></li>';
						}
					}
				?>
				<li><a href="/blog/">All</a></li>
			</ul>
			
			<?php if( $posts ){	?>

				<?php
				// Featured Photo
				if( $posts[0]['photo'] ){
					
					$fv = \File::getByID($posts[0]['photo']);
					
					// Photo
					$featuredAsset = $ih->getThumbnail($fv, 1180, 500, $posts[0]['title']." asset", false, true);
					$featuredAsset = $featuredAsset->src;
					
					// Alt Text
					$featuredAlt = $fv->getAttribute('alt_text');
					
				} else {
					$featuredAsset = "/application/themes/mgh/css/images/blog-featured-1-large.jpg";
				}
				
				// Alt Text Fallback
				if( !$featuredAlt ){
					$featuredAlt = "Blog Image";
				}
				?>
			
				<div class="entry featured">
					<span class="date"><?php echo date("m.d.y", strtotime($posts[0]["publishDate"])); ?> /</span>
					<span class="category"><?php echo $categories[$posts[0]["primaryCategory"]]; ?></span>
					
					<a href="/blog/<?php echo $posts[0]['url']; ?>" class="img-wrap">
						<img src="<?php echo $featuredAsset; ?>" class="featured" alt="<?php echo $featuredAlt; ?>" />
					</a>
			
					<h4><a href="/blog/<?php echo $posts[0]['url']; ?>"><?php echo $posts[0]['title']; ?></a></h4>
				
					<div class="excerpt">
						<?php echo '<p class="excerpt">'.$posts[0]['excerpt'].'</p>'; ?>
					</div>
				</div>
						
				<div class="entries clearfix">
					<?php 
					foreach( $posts as $key=>$post ){
						// Skip First
						if( $key != 0 ){ 
							// Featured Photo
							if( $post['photo'] ){
								
								$fv = \File::getByID($post['photo']);
								
								// Photo
								$featuredAsset = $ih->getThumbnail($fv, 700, 400, $post['title']." asset", false, true);
								$featuredAsset = $featuredAsset->src;
								
								// Alt Text
								$featuredAlt = $fv->getAttribute('alt_text');
								
							} else {
								$featuredAsset = "/application/themes/mgh/css/images/blog-featured-1.jpg";
							}
							
							// Alt Text Fallback
							if( !$featuredAlt ){
								$featuredAlt = "Blog Image";
							}
													
							echo '<div class="entry">';
								echo '<span class="date">'. date("m.d.y", strtotime($post["publishDate"])) .' /</span>';
								echo '<span class="category">'.$categories[$post["primaryCategory"]].'</span>';
					
			            		echo '<a href="/blog/'.$post["url"].'" class="img-wrap">';
									echo '<img src="'.$featuredAsset.'" alt="'.$featuredAlt.'" class="img-responsive" width="330" height="240">';
			            		echo '</a>';
		            
								echo '<h4><a href="/blog/'.$post["url"].'">'.$post["title"].'</a></h4>';
								echo '<p class="excerpt">'. mb_strimwidth($post["excerpt"], 0, 160, "...") .'</p>';
				        	echo '</div>';
						}
					}
					?>
				</div>
			
				<?php
					if( $pageCount ){
						
						$prev = $pageCurrent - 1;
						$next = $pageCurrent + 1;
												
						echo '<ul class="pager">';
							
							if( $prev != 0 ){
								// Jump Button
								if( ($prev - 3) > 0 ){
									echo '<li><a href="/blog/archive/'.($prev - 3).'"><<</a></li>';
								}
								
								echo '<li><a href="/blog/archive/'.$prev.'"><</a></li>';
							}
							
							for( $i = 1; $i <= $pageCount; $i++ ){
								
								if( $pageCurrent == $i ){
									echo '<li><a class="active" href="/blog/archive/'.$i.'">'.$i.'</a></li>';
								} else {
									
									if( $i < $pageCurrent && $i > ($pageCurrent - 3) ){
										echo '<li><a href="/blog/archive/'.$i.'">'.$i.'</a></li>';
									}
									
									if( $i > $pageCurrent && $i < ($pageCurrent + 3) ){
										echo '<li><a href="/blog/archive/'.$i.'">'.$i.'</a></li>';
									}
									
								}
								
							}
														
							if( $next < $i ){
								echo '<li><a href="/blog/archive/'.$next.'">></a></li>';
								
								// Jump Button
								if( ($next + 3) <= $pageCount ){
									echo '<li><a href="/blog/archive/'.($next + 3).'">>></a></li>';
								}
							}
							
						echo '</ul>';
					} 
				?>
			
			<?php } else { ?>
				<div class="entry featured">
					<h4>No Results Found , Please Try Again.</h4>
				</div>
			<?php } ?>
			
		</div>
	</div>
		
	<div class="section ctabanner">
		<?php
		    $a = new Area('Footer Callout Content');
			$a->display($c);
		?>
	</div>
	
		
<?php $this->inc('elements/footer.php'); ?>
