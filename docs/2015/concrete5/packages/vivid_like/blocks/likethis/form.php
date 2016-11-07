<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<div class="form-group">
    <?php  echo $form->label('urlToLike', t('Page to Like'));?>
    <?php  echo $form->select('urlToLike', array("thispage"=>"This Page","another"=>"Another URL"),$urlToLike,array("onChange" => "updateType();"));?>
</div>


<div id="form-donate">
    <div class="form-group">
        <?php  echo $form->label('url', t('Enter Custom URL'));?>
        <?php  echo $form->text('url', $url?$url:"http://");?>
    </div>
</div>

<script type="text/javascript">

    function updateType(){
        $("#urlToLike").each(function(){
            
            if ( $(this).find("option:selected").val() == "thispage" ) {
                $("#form-donate").hide();
            }
            if ($(this).find("option:selected").val() == "another" ) {
                $("#form-donate").show();
            }
        });
    };
    updateType();

</script>