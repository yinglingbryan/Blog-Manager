<?php
namespace Concrete\Package\BlogManager\Controller\SinglePage\Dashboard;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Editor\LinkAbstractor;

class BlogManager extends DashboardPageController
{
	
	public function view(){
		
		// Fetch All Projects
		$db = \Database::connection();
 		$sql = 'SELECT * FROM pkgBlogManager ORDER BY `publishDate` DESC';
		$data = $db->query($sql)->fetchAll();
		$this->set('data',$data);
		
		// Fetch Selected Project
		if( isset($_GET['edit']) ){
			$sql = 'SELECT * FROM pkgBlogManager WHERE bID = '. $_GET["edit"];
			$editData = $db->query($sql)->fetchRow();
			$this->set('editData',$editData);
		}
		
		// Fetch All Categories 
 		$sql = 'SELECT * FROM pkgBlogCategoriesManager ORDER BY `name` ASC';
		$categories = $db->query($sql)->fetchAll();
		$this->set('categories',$categories);
		
		// Fetch All Authors
		$sql = 'SELECT name, bID FROM pkgStaffManager ORDER BY name ASC';
		$authors = $db->query($sql)->fetchAll();
		$this->set('authors',$authors);
		
	}	
	
	public function save(){
		
		// Prevent Duplicate URLS
		$db = \Database::connection();
 		$sql = 'SELECT * FROM pkgBlogManager WHERE `url` = "'. $_POST['url'].'"';
		$match = $db->query($sql)->fetchAll();

		if( $match ){
			$_POST['url'] = $_POST['url'] . "2";
		}
				
		// Fallback
		if( $_POST['title'] == ""){
			$_POST['title'] = "Blog Post";
		}
				
		// Parse Data
		if( $_POST['categories'] ){
			$_POST['categories'] = implode(",",$_POST['categories']);
		}
				
		$v = array($_POST['status'],$_POST['title'],$_POST['body'],$_POST['excerpt'],$_POST['photo'],$_POST['primaryCategory'],$_POST['categories'],$_POST['publishDate'],$_POST['url'],$_POST['author'],$_POST['metaTitle'],$_POST['metaDesc']);
		$q = "INSERT INTO pkgBlogManager (status,title,body,excerpt,photo,primaryCategory,categories,publishDate,url,author,metaTitle,metaDesc) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
		$db->execute($q, $v);
		
		// Redirecting
		$this->redirect('/dashboard/blog_manager/');
		
	}
	
	public function update(){
		
		// Prevent Duplicate URLS
		$db = \Database::connection();
 		$sql = 'SELECT * FROM pkgBlogManager WHERE `url` = "'. $_POST['url'].'" AND bID <> "'. $_POST['bID'] .'"';
		$match = $db->query($sql)->fetchAll();

		if( $match ){
			// Logic not bulletproof in the event that you rename this 
			// to a "value" that has already been updated to "value2". 
			// In that case, there would be duplicates.
			$_POST['url'] = $_POST['url'] . "copy";
		}
		
		// Fallback
		if( $_POST['title'] == ""){
			$_POST['title'] = "Blog Post";
		}
				
		// Parse Data
		if( $_POST['categories'] ){
			$_POST['categories'] = implode(",",$_POST['categories']);
		}
		
		$v = array($_POST['status'],$_POST['title'],$_POST['body'],$_POST['excerpt'],$_POST['photo'],$_POST['primaryCategory'],$_POST['categories'],$_POST['publishDate'],$_POST['url'],$_POST['author'],$_POST['metaTitle'],$_POST['metaDesc'],$_POST['bID']);
		$q = "UPDATE pkgBlogManager SET status = ?, title = ?, body = ?, excerpt = ?, photo = ?, primaryCategory = ?, categories = ?, publishDate = ?, url = ?, author = ?, metaTitle = ?, metaDesc = ? WHERE bID = ?";
		$db->execute($q, $v);
		
		// Redirecting
		$this->redirect('/dashboard/blog_manager/');
		
	}
	
	public function delete(){
		
		// Deleting
		$db = \Database::connection();
		
		$q = "DELETE FROM pkgBlogManager WHERE bID = ?";
		$db->execute($q, $_GET['delete']);
		
		// Redirecting
		$this->redirect('/dashboard/blog_manager/');
		
	}

}