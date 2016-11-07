<?php  
defined('C5_EXECUTE') or die('Access Denied.');

/*
Editor Comment by John Liddiard (aka JohntheFish)
www.c5magic.co.uk
This software is licensed under the terms described in the concrete5.org marketplace.
Please find the add-on there for the latest license copy.
*/

/*
Notes for upgrade to inline editing
http://www.concrete5.org/community/forums/5-7-discussion/a-table-block-asset-registering-and-inline-block-editing/
http://www.mesuva.com.au/blog/concrete5/a-table-block-for-concrete5-57-with-inline-editing-and-asset-registering/
https://github.com/Mesuva/msv_table

Font awesome icons
http://fortawesome.github.io/Font-Awesome/icons/
*/

?>

<ul class="ccm-inline-toolbar">
	<li class="ccm-inline-toolbar-button ccm-inline-toolbar-button-cancel">
		<button  class="btn cancel-inline"><?php  echo t('Cancel'); ?></button>
	</li>
	<li title="<?php  echo t('Enter comment text, this will only be shown in edit mode and will be not be shown on the actual viewed page.');?>" style="cursor:help;">
		<span class="fa fa-question-circle">
		</span>
	</li>
	<li class="ccm-inline-toolbar-button ccm-inline-toolbar-button-save">
		<button class="btn btn-primary save-inline"><?php  echo t('Save'); ?></button>
	</li>
</ul>
</span>

<div id="jl_editor_comment_dialog" class="ccm-ui">
	<?php  
		/*
		http://www.concrete5.org/documentation/developers/5.7/background/migrating-to-5-7
		*/
		$form = Core::make('helper/form');
	?>
	<?php  
		echo $form->textarea('comment_text', $comment_text, 
								array(	'class'			=> 'input-block-level jl_editor_comment', 
										'style'			=> 'overflow-y:hidden;padding-top: 1.1em;'.$controller->raw_comment_styles(),
										'placeholder'	=> t('Leave a comment, only shown in edit mode.') 
										)
							);
	?>
</div>
<?php 
/*
The below tweaks the document styles on add, so the comment styles can be relied upon.
Its here in edit as a safety measure and to keep the code simple.

v7.0.1 - also adds handlers for the inline editing Save/Cancel buttons and auto sizing inline text area
http://stackoverflow.com/questions/454202/creating-a-textarea-with-auto-resize?lq=1#answer-8522283
*/
?>
<script type="text/javascript">
(function () { 
    $('.cancel-inline').on('click',function(){
        ConcreteEvent.fire('EditModeExitInline');
        Concrete.getEditMode().scanBlocks();
    });
    $('.save-inline').on('click',function(){
        $('#ccm-block-form').submit();
        ConcreteEvent.fire('EditModeExitInlineSaved');
        ConcreteEvent.fire('EditModeExitInline', {
            action: 'save_inline'
        });
    });

	$('#jl_editor_comment_dialog textarea.jl_editor_comment').on('keydown keyup', function(e){
		$(this).height( 0 );
		$(this).height( this.scrollHeight );
	});
	$('#jl_editor_comment_dialog textarea.jl_editor_comment').trigger('keydown');

	if($("style:contains('jl_editor_comment')").length){
		return;
	}
	var comment_styles = '<?php  echo addslashes($controller->comment_styles());?>';
	$('head').append(comment_styles);
})();
</script>

