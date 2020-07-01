<!DOCTYPE html>
<html lang="en">
<head>
	<title>CodeIgniter Image Upload</title>
	<meta charset="UTF-8">
</head>
<body>
<div>
	<h2>Select an image to upload</h2>
	<?php
	if (isset($error)) {
		echo $error;
	}
	echo form_open_multipart();
	?>
	<input type="file" id="images" name="images[]" size="33" multiple="multiple"/>
	<input type="submit" name="upload" value="Upload"/>
	</form>
</div>
<hr/>
<div>
	<h2>Uploaded Images</h2>
	<?php
	if ($images) {
		foreach ($images as $image) { ?>
			<div style="float:left;width: 150px;">
				<a href="/images/get/<?php echo $image->id; ?>" target="_blank">
					<img src="/images/get/<?php echo $image->id; ?>" width=100/>
				</a><br/>
				<span><?php echo $image->filename; ?></span>
			</div>
		<?php }
	} else { ?>
		No images found
		<?php
	}
	?>
</div>
</body>
</html>
