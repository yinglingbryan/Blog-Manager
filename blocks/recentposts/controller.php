<?php
namespace Concrete\Package\BlogManager\Block\Recentposts;
use \Concrete\Core\Block\BlockController;

class Controller extends BlockController {

	protected $btDescription = "Displays recent blog posts.";
	protected $btName = "MGH Blog Recent Posts";
	protected $btTable = 'btRecentPosts';
	protected $btInterfaceWidth = "500";
	protected $btInterfaceHeight = "450";
	
	public function view(){
		
		// Fetch Posts
		$db = \Database::connection();
 		$sql = 'SELECT * FROM pkgBlogManager WHERE `status` = 1 ORDER BY `publishDate` DESC LIMIT 3';
		$posts = $db->query($sql)->fetchAll();
				
		// Fetch Categories      
		$db = \Database::connection();
 		$sql = 'SELECT * FROM pkgBlogCategoriesManager ORDER BY `bID` ASC';
		$categories = $db->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR);
		
		// Page Vars
		$this->set('posts',$posts);
		$this->set('categories',$categories);
	}

}
