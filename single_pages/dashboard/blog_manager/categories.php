<?php $al = Loader::helper('concrete/asset_library'); ?>

<div class="ccm-dashboard-header-buttons">
	<a href="/dashboard/blog_manager" class="btn btn-primary"><i class="fa fa-newspaper-o"></i> Add New</a>
</div>

<?php
if ($_GET['errormsg']) {
	echo '<div class="alert alert-danger">' . $_GET['errormsg'] . '</div>';
}

if ($_GET['msg']) {
	echo '<div class="alert alert-info">' . $_GET['msg'] . '</div>';
}

if( $_GET['errors'] == 1 ){
	echo '<div class="alert alert-danger">Photo is required!</div>';
}
?>

<div class="lc-container ccm-ui">
		
	<ul class="callout-list rounded-element sortable-list" rel="<?php echo $this->action('updateSequence'); ?>">
		<?php
			foreach( $data as $entry ){
								
				$curPhoto = "/packages/client_manager/icon.png";
				
				echo "<li id='".$entry["bID"]."'>";
					echo '<img class="cPreview" src="'.$curPhoto.'" alt="" width="65" />';
					echo '<div class="cContent">';
						echo '<span class="cTitle">'. $entry["name"] .'</span>';
						echo '<span class="cSubTitle">'.$entry["caption"].'</span>';
						echo '<span class="edit"><a href="?edit='.$entry["bID"].'">Edit</a></span>';
						echo '<span class="delete"><a href="'.$this->action('delete').'?delete='.$entry["bID"].'" onclick="return confirm(\'Are you sure you want to delete this?\')">Delete</a></span>';
					echo '</div>';
					echo '<div class="clear" style="clear:both;"></div>';
				echo '</li>';
			}
		?>
	</ul>
	
	<div class="form-container rounded-element">
		<form id="locationCallouts" name="locationCallouts" method="post" action="<?php if( isset($_GET['edit']) ){ echo $this->action('update'); } else { echo $this->action('save'); } ?>">
			
			<input type="hidden" name="bID" value="<?php echo $editData['bID']; ?>" />
			
			<div class="formElem">
				<label for="name">Name
					<span>This sets the name of the category.</span>
				</label>
				<input class="text form-control" id="name" name="name" value="<?php echo $editData["name"]; ?>" />
			</div>
											
			<div class="formElem right-jus">
				<?php if( isset($_GET['edit']) ){ ?>
					<a class="cancel btn" href="<?php echo $this->action(''); ?>">Cancel</a>
				<?php } ?>
				
				<input type="submit" id="crSave" value="Save" class="btn btn-primary" />				
			</div>
		</form>
	</div>
	
	<div class="clear"></div>
</div>

<style type="text/css">

	.lc-container .rounded-element {
		border: 1px solid #E1E1E8;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
	}

	.lc-container .clear { clear:both; }

	.lc-container { background: #fff; border-radius: 5px; height: 560px; width: 100%; }
	.lc-container .form-container { background: #F7F7F9; float: left; height: 540px; overflow: auto; margin-top: 22px; padding: 8px 15px 0; width: 55%; }
	.lc-container .formElem { padding: 7px 2%; }

	.lc-container .formElem.right-jus { padding-right: 16px; text-align: right; }

	.lc-container .formElem label { display: block; float: none; font-size: 16px; font-weight: bold; line-height: 18px; margin-bottom: 9px; }
	.lc-container .formElem label.subLabel { color: #6C6C6C; display: inline-block; font-size: 12px; font-weight: normal; margin-left:5px; }

	.lc-container .formElem label span { color: #6C6C6C; display: block; font-size: 12px; font-weight: normal; }

	.lc-container .callout-list { float: left; height: 541px; overflow: auto; margin-right: 2%; margin-top: 23px; padding: 0 0 0; margin-left: 29px; width: 40%; }
	.lc-container .callout-list li { color: #0088CC; cursor:pointer; border-bottom: 1px solid #E1E1E8; list-style:none; margin-bottom: 0; padding: 21px 20px; }

	.lc-container .callout-list li:hover { background:#f1fdff; }

	.lc-container .callout-list li .callout-nane span { color: #999; font-size: 12px; }

	.lc-container div.ccm-editor-controls { border: solid 1px #aaa; margin-bottom: 2px; width: 436px; }
	.lc-container .textarea-large { height:150px; width:430px; }
	.lc-container .cPreview { float:left; }
	.lc-container .cContent { float:left; margin-left:10px; width: 240px; }

	.lc-container .cContent .cTitle { color:#333; display:block; font-size: 16px; font-weight: bold; line-height: 18px; margin-bottom: 3px; }
	.lc-container .cContent .cSubTitle { color:#666; display:block; font-size: 12px; line-height: 18px; margin-bottom: 3px; }

	.lc-container .cContent .delete a { font-size:11px; margin-left:3px; }
	.lc-container .cContent .edit a { font-size:11px; }

	.lc-container .formElem .checkbox-group { margin-bottom: 5px; }
	.lc-container .formElem .checkbox-group input { display:inline-block; float:left; margin-right:5px; }
	.lc-container .formElem .checkbox-group strong { display:inline-block; float:left; font-size:12px; margin-top: 4px; }
	
</style>

