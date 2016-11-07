/*
// Validation is currently broken in 5.7
var JPAudioPlayerBlock = {
	validate:function(){
		var failed=0;
		if ($("#audioBlock-singleAudio input[name=fID]").val() <= 0) {
			alert(ccm_t('choose-file'));
			failed = 1;
		}
		if(failed){
			ccm_isBlockError=1;
			return false;
		}
		return true;
	}
}

ccmValidateBlockForm = function() { return JPAudioPlayerBlock.validate(); }
*/