
<?php
	// Libs
	$ih = Core::make('helper/image');

	// Print Recent Posts
	// var_dump($posts);
	
	echo '<ul class="clearfix">';
	if( $posts ){
		foreach( $posts as $key=>$post ){
			
			// Featured Photo
			if( $post['photo'] != 0 ){
				
				$fv = \File::getByID($post['photo']);
				
				// Photo
				$featuredAsset = $ih->getThumbnail($fv, 700, 400, $post['title']." asset", false, true);
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
			
			// URL
			$post['url'] = "/blog/".$post['url'];
						
			echo '<li>';
			echo	'<span class="meta">'. date("m.d.y", strtotime($post["publishDate"])) .' / <strong>'.$categories[$post["primaryCategory"]].'</strong></span>';
			echo	'<a class="img-wrap" href="'.$post['url'].'"><img src="'.$featuredAsset.'" alt="'.$featuredAlt.'" /></a>';
			echo	'<h3><a href="'.$post['url'].'">'.$post['title'].'</a></h3>';
			echo	'<p>'. mb_strimwidth($post["excerpt"], 0, 160, "") .'... <a href="'.$post['url'].'">Read More</a></p>';
			echo '</li>';
		}
	}
	echo '</ul>';
?>
