<?php
namespace Concrete\Package\BlogManager\Controller\SinglePage\Dashboard\BlogManager;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Editor\LinkAbstractor;

class Categories extends DashboardPageController
{
	
	public function view(){
		
		// Fetch Data
		$db = \Database::connection();
 		$sql = 'SELECT * FROM pkgBlogCategoriesManager ORDER BY `name` ASC';
		$data = $db->query($sql)->fetchAll();
		$this->set('data',$data);
		
		// Fetch Selected Data
		if( isset($_GET['edit']) ){
			$sql = 'SELECT * FROM pkgBlogCategoriesManager WHERE bID = '. $_GET["edit"];
			$editData = $db->query($sql)->fetchRow();
			$this->set('editData',$editData);
		}
				
	}	
	
	public function save(){

		// Saving
		if( $_POST['name'] == ""){
			$_POST['name'] = "Empty Category";
		}
		
		$db = \Database::connection();
		$v = array($_POST['name']);
		$q = "INSERT INTO pkgBlogCategoriesManager (name) VALUES (?)";
		$db->execute($q,$v);
		
		// Redirecting
		$this->redirect('/dashboard/blog_manager/categories');
		
	}
	
	public function update(){
		
		// Updating
		if( $_POST['name'] == ""){
			$_POST['name'] = "Empty Category";
		}
		
		$db = \Database::connection();
		$v = array($_POST['name'],$_POST['bID']);
		$q = "UPDATE pkgBlogCategoriesManager SET name = ? WHERE bID = ?";
		$db->execute($q,$v);
		
		// Redirecting
		$this->redirect('/dashboard/blog_manager/categories');
		
	}
	
	public function delete(){
		
		// Deleting
		$db = \Database::connection();
		
		$q = "DELETE FROM pkgBlogCategoriesManager WHERE bID = ?";
		$db->execute($q, $_GET['delete']);
		
		// Redirecting
		$this->redirect('/dashboard/blog_manager/categories');
		
	}

}