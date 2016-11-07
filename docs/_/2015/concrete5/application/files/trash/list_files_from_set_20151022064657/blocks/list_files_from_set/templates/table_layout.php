<?php      defined('C5_EXECUTE') or die("Access Denied.");


$c = Page::getCurrentPage();

if($c instanceof Page) {
	$cID = $c->getCollectionID();
}

?>

<?php    if ($displaySetTitle && $filesetname = $controller->getFileSetName()) { ?>
<h3><?php    echo $filesetname; ?></h3>
<?php    } ?>
	
<?php    if (!empty($files)) { ?>	
<table class="fileset-table">

	<tr><th><?php  echo t('File');?></th>
	
		<?php   
			if($extension == 'brackets') {
				echo '<th>' . t('Type') . '</th>';
			}
			
			if ($displaySize) {
			 		echo '<th>' . t('Size') . '</th>';
			}
			
			 
			if ($displayDateAdded) {
			 		echo '<th>' . t('Date') . '</th>';
			}
		?>
	
	
	</tr>

	
	<?php   	
	foreach($files as $f) {
		 
		$fv = $f->getApprovedVersion();
		// although the 'title' for a file is used for display,
		// the filename is retreived here so we can always get a file extension
		$filename = $fv->getFileName();
		$ext =  pathinfo($filename, PATHINFO_EXTENSION);

        if ($forceDownload) {
            $url = $f->getForceDownloadURL();
        } else{
            $url = $f->getDownloadURL();
        }
		
		// if you wish to directly link to the file, bypassing permissons, logging, etc,
		// use instead of the above line:  $url = $fv->getURL();
		
		// if we are overriding the filename (e.g. showing only 1 file)
		if ($titleOverride) {
			$title = $titleOverride;
		} else {
		
			$title = $f->getTitle();
			
			// want to always use the filename and not the title?  uncomment line below
			// $title = $filename;
			
			// removes or puts in brackets the file extension
			if ($extension == 'hide') {
				if(strlen($title) - strlen($ext) == strrpos($title,$ext)) {
					$title = pathinfo($title, PATHINFO_FILENAME);
				}
			} elseif ($extension == 'brackets') {
									
				if(strlen($title) - strlen($ext) == strrpos($title,$ext)) {
					$title = pathinfo($title, PATHINFO_FILENAME);
				}
			}
			
			if ($replaceUnderscores) {
				 $title = str_replace('_', ' ', $title);
			}  
			
			if ($uppercaseFirst) {
				$title = ucfirst(strtolower($title));
			}
			 
		}
			
		?>
	 
		
		<tr><td><a href="<?php    echo $url; ?>">
		<?php    echo $title; ?>
		</a></td>
		
		<?php   
		
		if ($extension == 'brackets') {
			echo '<td>' . $ext . '</td>';
		}
		
		if ($displaySize) {
		 	echo '<td>' . $fv->getSize() . '</td>';
		}
		
		 
		if ($displayDateAdded) {
            $dh = Core::make('helper/date');
            echo '<td>' . $dh->formatDate($fv->getDateAdded()) . '</td>';
		}
		?>
		
		
		</tr>
		


<?php    }	?>

</table>
<?php    }	?>

<?php  if ($pagination): ?>
    <?php  echo $pagination;?>
<?php  endif; ?>


<?php    if (empty($files) && $noFilesMessage) { ?>
<p><?php    echo $noFilesMessage; ?></p>
<?php    } ?>
