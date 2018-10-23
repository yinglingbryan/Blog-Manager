<?php  
	defined('C5_EXECUTE') or die("Access Denied.");
	$this->inc('elements/header.php'); 
	
	// Helpers
	$ih = Core::make('helper/image');
		
	// Featured Photo
	if( $post['photo'] ){
		$featuredAsset = \File::getByID($post['photo']);
		$featuredAsset = $ih->getThumbnail($featuredAsset, 3000, 3000, $post['title']." asset", false, true);
		$featuredAsset = $featuredAsset->src;
	} else {
		$featuredAsset = "/application/files/8214/7991/3800/blog-photo-1.png";
	}
	
	// Share Varibles
	$shareURL = $c->getCollectionLink() . "/" . $post['url'];
?>
	<div class="section masthead blog <?php if( strlen($post['title']) >= 59 ){ echo 'long-title'; } ?>" style="background-image:url('<?php echo $featuredAsset; ?>');">
		<div class="overlay"></div>
		
		<div class="content">
			<h1><?php echo $post['title']; ?></h1>
		</div>
	</div>
	
	<?php
		// var_dump($post);
		// var_dump($author);
		// var_dump($recentPosts);
	?>
	
	<div class="section generic blog-full">
		<div class="content">
			
			<div class="entry featured">
				<span class="date"><?php echo date("m.d.y", strtotime($post["publishDate"])); ?> / <?php if( $author['name'] ){ echo $author['name'] . ' /'; }  ?></span>
				<span class="category"><?php echo $categories[$post["primaryCategory"]]; ?></span>
			
				<div class="body">
					<?php echo $post['body']; ?>
				</div>
			</div>
			
			<div class="entry-share clearfix">
				<h5>SHARE THIS POST</h5>
			
				<ul class="clearfix">
					<li><a target="_blank" href="mailto:?subject=Check out the latest MGH blog post!&amp;body=<?php echo $post['title']; ?> <?php echo $shareURL; ?>"><img src="/application/themes/mgh/css/images/icon-blog-email.png" alt="email-icon"></a></li>
					<li><a target="_blank" href="http://www.facebook.com/share.php?u=<?php echo $shareURL; ?>&amp;title=<?php echo $post['title']; ?>"><img src="/application/themes/mgh/css/images/icon-blog-facebook.png" alt="facebook-icon"></a></li>
					<li><a target="_blank" href="http://twitter.com/intent/tweet?status=<?php echo $post['title']; ?>+<?php echo $shareURL; ?>"><img src="/application/themes/mgh/css/images/icon-blog-twitter.png" alt="twitter-icon"></a></li>
					<li class="last"><a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $shareURL; ?>&amp;title=<?php echo $post['title']; ?>&amp;source=<?php echo $shareURL; ?>"><img src="/application/themes/mgh/css/images/icon-blog-linkedin.png" alt="linkedin-icon"></a></li>
				</ul>
			</div>
		</div>
	</div>
		
	<div class="section ctabanner">
		<?php
		    $a = new Area('Footer Callout Content');
			$a->display($c);
		?>
	</div>
	
		
<?php $this->inc('elements/footer.php'); ?>
