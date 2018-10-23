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
							
				// Get Preview
				$curPhoto = \File::getByID($entry["photo"]);

				if( $curPhoto ){
					if( $curPhoto->getType() == "PNG" || $curPhoto->getType() == "JPEG" || $curPhoto->getType() == "GIF" ){
						$ih = \Loader::helper('image');
						$max_width = 65;
						$max_height = 65;
						$alt = 'Preview Image';

						$curPhoto = $ih->getThumbnail($curPhoto, $max_width, $max_height, $alt);
						$curPhoto = $curPhoto->src;
					} else {
						$curPhoto = "/packages/client_manager/icon.png";
					}
				} else {
					$curPhoto = "/packages/client_manager/icon.png";
				}

				echo "<li id='".$entry["bID"]."'>";
					echo '<img class="cPreview" src="'.$curPhoto.'" alt="" width="65" />';
					echo '<div class="cContent">';
						echo '<span class="cTitle">'. $entry["title"] .'</span>';
						echo '<span class="cSubTitle">'.$entry["publishDate"].'</span>';
						echo '<span class="edit"><a href="?edit='.$entry["bID"].'">Edit</a></span>';
						echo '<span class="delete"><a href="'.$this->action('delete').'?delete='.$entry["bID"].'" onclick="return confirm(\'Are you sure you want to delete this?\')">Delete</a></span>';
					echo '</div>';
					echo '<div class="clear" style="clear:both;"></div>';
				echo '</li>';
			}
		?>
	</ul>
	
	<div class="form-container rounded-element">
		<form method="post" action="<?php if( isset($_GET['edit']) ){ echo $this->action('update'); } else { echo $this->action('save'); } ?>">
			
			<input type="hidden" name="bID" value="<?php echo $editData['bID']; ?>" />
			
			<div class="formElem">
				<label for="publishDate">Published Date
					<span>This sets the publish date.</span>
				</label>
				
				<input class="text form-control datepicker" id="publishDate" name="publishDate" value="<?php echo $editData["publishDate"]; ?>" />
			</div>
			
			<div class="formElem">
				<label for="status">Status
					<span>This sets the status.</span>
				</label>
								
				<select id="status" name="status" class="form-control">
					<option value="0" disabled="disabled" selected="selected">-- Please Choose --</option>
					<option value="1" <?php if( $editData['status'] == '1' ) echo "selected='selected'"; ?> >Active</option>
					<option value="0" <?php if( $editData['status'] == '0' ) echo "selected='selected'"; ?> >Inactive</option>
				</select>
			</div>
			
			<div class="formElem">
				<label for="title">Title
					<span>This sets the title.</span>
				</label>
				<input class="text form-control" id="title" name="title" value="<?php echo $editData["title"]; ?>" />
			</div>
			
			<div class="formElem">
				<label for="body">Body
					<span>This sets the caption.</span>
				</label>
								
				<div class="white">
				<?php
					$editor = Core::make('editor');
					$editor->setAllowFileManager(true);
					$editor->setAllowSitemap(true);
					echo $editor->outputBlockEditModeEditor('body', $editData["body"]);
				?>
				</div>
			</div>
			
			<div class="formElem">
				<label for="excerpt">Excerpt
					<span>This sets a short excerpt to be used on the main blog page.</span>
				</label>
				
				<textarea class="textarea form-control" id="excerpt" name="excerpt" rows="5" maxlength="500"><?php echo $editData["excerpt"]; ?></textarea>
			</div>
			
			<div class="formElem">
				<label for="photo">Featured Photo
					<span>This sets the featured photo.</span>
				</label>
				<?php 				
					if ($editData['photo'] && File::getByID($editData['photo'])) {
						echo $al->file('photo', 'photo', 'Please Select A File', File::getByID($editData['photo']));
					} else {
						echo $al->file('photo', 'photo', 'Please Select A File');
					}
				?>
			</div>
			
			<div class="formElem">
				<label for="categories">Primary Category
					<span>This sets the primary category.</span>
				</label>
				
				<select id="primaryCategory" name="primaryCategory" class="form-control">
					<option value="" disabled="disabled" selected="selected">-- Please Choose --</option>
					<?php
					foreach( $categories as $key=>$category ){
						if( $editData['primaryCategory'] == $category["bID"] ){
							echo '<option value="'.$category["bID"].'" selected="selected">'.ucfirst($category["name"]).'</option>';
						} else {
							echo '<option value="'.$category["bID"].'">'.ucfirst($category["name"]).'</option>';
						}
						
					}
					?>
				</select>
			</div>
			
			<div class="formElem">
				<label for="categories">Categories
					<span>This sets the categories.</span>
				</label>
				
				<?php
					// Parse Categories
					$editData['categories'] = explode(",", $editData['categories']);
					
					// Render Categories
					foreach( $categories as $key=>$category ){
						
						echo '<label class="checkbox-group">';

						if( in_array($category['bID'], $editData['categories']) ){
							echo '	<input class="checkbox" type="checkbox" name="categories[]" value="'.$category['bID'].'" checked="checked" />';
						} else {
							echo '	<input class="checkbox" type="checkbox" name="categories[]" value="'.$category['bID'].'" />';
						}
						
						echo '	<strong>'.$category['name'].'</strong>';
						echo '	<div class="clear"></div>';
						echo '</label>';
						
					}
				?>
			</div>
			
			<div class="formElem">
				<label for="url" style="margin-bottom: 0;">Url</label>
				<div class="plabel">http://mghus.com/blog/</div><input class="text form-control" id="url" name="url" value="<?php echo $editData["url"]; ?>" />
				<div class="clear"></div>
			</div>	
			
			<?php /*
			<div class="formElem">
				<label for="author">Author
					<span>This sets the author.</span>
				</label>
				<input class="text form-control" id="author" name="author" value="<?php echo $editData["author"]; ?>" />
			</div>
			*/ ?>
			
			<div class="formElem">
				<label for="metaTitle">SEO Title
					<span>This sets the page's meta title.</span>
				</label>
				<input class="text form-control" id="metaTitle" name="metaTitle" value="<?php echo $editData["metaTitle"]; ?>" />
			</div>
			
			<div class="formElem">
				<label for="metaDesc">SEO Description
					<span>This sets the page's meta description.</span>
				</label>
				
				<textarea class="textarea form-control" id="metaDesc" name="metaDesc" rows="5" maxlength="500"><?php echo $editData["metaDesc"]; ?></textarea>
			</div>
			
			<div class="formElem">
				<label for="author-control">Author
					<span>This sets the author.</span>
				</label>
				
				<select id="author-control" name="author" class="form-control">
					<option value="" disabled="disabled" selected="selected">-- Please Choose --</option>
					<option value="" <?php if( $editData['author'] == '' ){ echo 'selected="selected"'; } ?>>No Author</option>
					<?php
					foreach( $authors as $key=>$author ){
						if( $editData['author'] == $author["bID"] ){
							echo '<option value="'.$author["bID"].'" selected="selected">'.ucfirst($author["name"]).'</option>';
						} else {
							echo '<option value="'.$author["bID"].'">'.ucfirst($author["name"]).'</option>';
						}
					}
					?>
				</select>
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
	
	.lc-container .callout-list li h4 { background:url("/application/themes/mgh/css/images/icon-select-arrow.png") no-repeat right 5px center; color:#333; }
	.lc-container .callout-list li.active h4 { background-image:url("/application/themes/mgh/css/images/icon-select-arrow-active.png"); } 
	.lc-container .callout-list li ul { display:none; padding:0; }
	.lc-container .callout-list li ul li { padding-left:0; }
	.lc-container .callout-list li ul li:last-child { border:none; }
	
	.lc-container div.ccm-editor-controls { border: solid 1px #aaa; margin-bottom: 2px; width: 436px; }
	.lc-container .textarea-large { height:150px; width:430px; }
	.lc-container .redactor-editor { padding:15px; }
	.lc-container .cPreview { float:left; }
	.lc-container .cContent { float:left; margin-left:10px; width: 240px; }

	.lc-container .cContent .cTitle { color:#333; display:block; font-size: 16px; font-weight: bold; line-height: 18px; margin-bottom: 3px; }
	.lc-container .cContent .cSubTitle { color:#666; display:block; font-size: 12px; line-height: 18px; margin-bottom: 3px; }

	.lc-container .cContent .delete a { font-size:11px; margin-left:3px; }
	.lc-container .cContent .edit a { font-size:11px; }

	.lc-container .formElem .checkbox-group { margin-bottom: 5px; }
	.lc-container .formElem .checkbox-group input { display:inline-block; float:left; margin-right:5px; }
	.lc-container .formElem .checkbox-group strong { display:inline-block; float:left; font-size:12px; margin-top: 4px; }
	
	.lc-container .formElem .plabel { color: #666; float: left; font-size: 12px; margin-right: 10px; margin-top: 10px; }
	.lc-container .formElem input#url { float:left; width:50%; }
	.lc-container .formElem .white { background:#fff; }
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$('.formElem input#title').keyup(function(){
			var curVal = ($(this).val()).replace(/\s+/g, '-').toLowerCase();
			$(".formElem input#url").val(curVal);
		});
		
		$(".datepicker").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});
</script>

