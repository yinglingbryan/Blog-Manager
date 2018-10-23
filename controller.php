<?php

namespace Concrete\Package\BlogManager;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Single as SinglePage;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package
{
	protected $pkgHandle = 'blog_manager';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.1.6';

	public function getPackageDescription()
	{
		return t("A simple manager for MGH blog.");
	}

	public function getPackageName()
	{
		return t("Blog Manager");
	}

	public function view() {
   		$html = Loader::helper('html');
 	}

	public function install()
	{
		$pkg = parent::install();
		SinglePage::add('/blog', $pkg);
		SinglePage::add('/dashboard/blog_manager', $pkg);
		SinglePage::add('/dashboard/blog_manager/categories', $pkg);
		BlockType::installBlockTypeFromPackage('recentposts', $pkg);
	}
	
	public function upgrade() {
		
		parent::upgrade();
		
		$bt = BlockType::getByHandle('recentposts');
		if( !is_object($bt) ){
			BlockType::installBlockTypeFromPackage('recentposts', $this); 
		}
		
	}

}
