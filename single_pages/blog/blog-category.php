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
			<h1><?php print $c->getCollectionName() . " - " . ucfirst($categories[$currentCategory]); ?></h1>
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

				<div class="entries clearfix">
					<?php 
					foreach( $posts as $key=>$post ){
						// Featured Photo
						if( $post['photo'] ){
							
							$fv = \File::getByID($post['photo']);
							
							// Photo
							$featuredAsset = $ih->getThumbnail($fv, 700, 460, $post['title']." asset", false, true);
							$featuredAsset = $featuredAsset->src;
							
							// Alt Text
							$featuredAlt = $fv->getAttribute('alt_text');
							
						} else {
							$featuredAsset = "/application/files/8214/7991/3800/blog-photo-1.png";
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
							echo '<p class="excerpt">'. mb_strimwidth($post["excerpt"], 0, 166, "...") .'</p>';
			        	echo '</div>';
					}
					?>
				</div>
						
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
