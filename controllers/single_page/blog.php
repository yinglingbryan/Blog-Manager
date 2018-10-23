<?php
namespace Concrete\Package\BlogManager\Controller\SinglePage;
use Concrete\Core\Page\Controller\PageController;

class Blog extends PageController {
	
	// Constants
	protected $perPage = 7;
	
	// Methods
	public function view( $view = "home", $page = 1 ){
		
		// var_dump($view);
				
		// Set
		$this->set('categories',$this->getCategories());
		
		if( $view == "home" ){
			
			// Blog Home
			$db = \Database::connection();
	 		$sql = 'SELECT * FROM pkgBlogManager WHERE `status` = 1 ORDER BY `publishDate` DESC LIMIT '.$this->perPage;
			$posts = $db->query($sql)->fetchAll();
			
			// Page Vars
			$this->set('posts',$posts);
			$this->set('pageCount',$this->getPageCount());
			$this->set('pageCurrent',$page);
		
			// Render
			$this->render('/blog', 'blog_manager');
		
		} elseif( $view == "archive" ){
			
			// Prevents Duplicate Content
			if( $page == 1 ){
				$this->redirect('/blog/');
			}
			
			// Blog Home Archives                    
			$pageStart = ($page - 1) * $this->perPage;
						       
			$db = \Database::connection();
	 		$sql = 'SELECT * FROM pkgBlogManager WHERE `status` = 1 ORDER BY `publishDate` DESC LIMIT '.$pageStart.', '.$this->perPage;
			$posts = $db->query($sql)->fetchAll();
			
			// Page Vars
			$this->set('posts',$posts);
			$this->set('pageCount',$this->getPageCount());
			$this->set('pageCurrent',$page);
                                        
			// Render                
			$this->render('/blog', 'blog_manager');	
						
		} else { 
			
			// Blog Single Post
			$db = \Database::connection();
	 		$sql = 'SELECT * FROM pkgBlogManager WHERE `url` = "'. $view .'"';
			$post = $db->query($sql)->fetchRow();
						
			if( $post['author'] && intval($post['author']) > 0 ){ // Old Data Fallback
				// Blog Author
				$sql = 'SELECT * FROM pkgStaffManager WHERE `bID` = "'. $post['author'] .'"';
				$author = $db->query($sql)->fetchRow();
			
				// Blog Author Recent Posts
				$sql = 'SELECT * FROM pkgBlogManager WHERE `url` <> "'. $view .'" AND `author` = '.$post['author'];
				$recentPosts = $db->query($sql)->fetchAll();
			}
			
			// Page Vars
			$this->set('post',$post);
			$this->set('author',$author);
			$this->set('recentPosts',$recentPosts);
			$this->set('blogMetaTitle',$post['metaTitle']);
			$this->set('blogMetaDesc',$post['metaDesc']);
			
			// Render
			$this->render('/blog/blog-post', 'blog_manager');
		}
				
	}
	
	public function category( $category = "" ){
				
		// Set
		$this->set('categories',$this->getCategories());
		$this->set('currentCategory',$category);
		
		if( $category == "" ){
			// Prevents Duplicate Content
			$this->redirect('/blog/');

		} else {
			// Blog Posts By Category
			$db = \Database::connection();
	 		$sql = 'SELECT * FROM pkgBlogManager WHERE `status` = 1 AND primaryCategory = '.$category.' ORDER BY `publishDate` DESC';
			$posts = $db->query($sql)->fetchAll();
			
			// Page Vars
			$this->set('posts',$posts);
		
			// Render
			$this->render('/blog', 'blog_manager');
		}
				
		// Render
		$this->render('/blog/blog-category', 'blog_manager');
	}
	
	public function getCategories(){
		// Fetch Categories      
		$db = \Database::connection();
 		$sql = 'SELECT * FROM pkgBlogCategoriesManager ORDER BY `bID` ASC';
		$categories = $db->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR);
		
		return $categories;
	}
	
	public function getPageCount(){
		// Fetch Categories      
		$db = \Database::connection();
		$sql = 'SELECT COUNT(bID) as count FROM pkgBlogManager';
		$total = $db->query($sql)->fetchrow();
		$total = ceil(intval($total['count'])/$this->perPage);
		
		return $total;
	}
	
}
