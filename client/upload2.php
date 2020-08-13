<?php
if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['evidence']['tmp_name'])) {
$sourcePath = $_FILES['evidence']['tmp_name'];
$targetPath = "evidence/".$_FILES['evidence']['name'];
if(move_uploaded_file($sourcePath,$targetPath)) {
?>
<img class="image-preview" src="<?php echo $targetPath; ?>" class="upload-preview" />
<?php
}
}
}
?>