<?php  
defined('C5_EXECUTE') or die("Access Denied.");

/*
Editor Comment by John Liddiard (aka JohntheFish)
www.c5magic.co.uk
This software is licensed under the terms described in the concrete5.org marketplace.
Please find the add-on there for the latest license copy.
*/


if ($comment_text && $controller->show_comment()) {
	?>
	<div class="jl_editor_comment">
		<span style="position:absolute;right:5px;top:5px"><?php  
			echo $by_user;
			echo '&nbsp;';
			echo $timestamp;
		?></span>
		<span style="position:absolute;left:5px;top:5px"><?php  echo  htmlentities('/*');?></span>
		<span style="position:absolute;right:5px;bottom:5px"><?php  echo htmlentities('*/');?></span>
		<?php 
		echo nl2br($comment_text);		
		/*
		The script is just in case something accidentally gets cached
		or when the block is first added. No need to wait for ready
		because this works on styles, not the DOM.
		*/
		?><script type="text:JavaScript">
		(function(){
			if( CCM_EDIT_MODE || $('#ccm-dashboard-page').length){
				if($("style:contains('jl_editor_comment')").length){
					return;
				}
				var comment_styles = '<?php  echo addslashes($controller->comment_styles());?>';
				$('head').append(comment_styles);
				return;
			}
			$('.jl_editor_comment').empty();
		})();		
		</script>
	</div>
	<?php 
}