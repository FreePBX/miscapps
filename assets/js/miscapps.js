var theForm = document.editMiscapp;
if(typeof theForm !== 'undefined'){
	theForm.description.focus();
}
function checkMiscapp() {
	var msgInvalidDescription = _('Invalid description specified');

	// set up the Destination stuff
	setDestinations(theForm, '_post_dest');

	// form validation
	defaultEmptyOK = false;
	if (isEmpty(theForm.description.value))
		return warnInvalid(theForm.description, msgInvalidDescription);

	if (!validateDestinations(theForm, 1, true))
		return false;

	return checkExt();
}
$(document).ready(function() {
	$('form').unbind( "submit");
	$('form[name="editMiscapp"]').submit(checkMiscapp);
	$('form').submit(function(e) {
		if (!e.isDefaultPrevented()){
			$(".destdropdown2").filter(".hidden").remove();
		}
	});
});	

//Make sure the Feature code is only letters and numbers.
$('#ext').on('keyup',function(){
	var cval = $(this).val();
	var patt = new RegExp("^[\*\._0-9XN]+$");
	if(!patt.test(cval) && cval.length > 0){
		warnInvalid($(this),_("This field must only contain numbers and *'s"));
	}
});
//Check for conflicts
function checkExt(){
	var cval = theForm.ext.value.trim();
	var id = 'miscapp_'+ $( "input[name='miscapp_id']" ).val();
	if(cval in extmap && cval.length > 0){
		var foundid = extmap[cval];
		if (foundid.indexOf(id) == -1){
			theForm.ext.focus();
			warnInvalid(theForm.ext,_("The number provided for the feature code is already in use by ") + extmap[cval]);
			return false;
		}
	}
	return true;
}

