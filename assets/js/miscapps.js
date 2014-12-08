
function checkMiscapp(theForm) {
	var msgInvalidDescription = _('Invalid description specified');

	// set up the Destination stuff
	setDestinations(theForm, '_post_dest');

	// form validation
	defaultEmptyOK = false;	
	if (isEmpty(theForm.description.value))
		return warnInvalid(theForm.description, msgInvalidDescription);

	if (!validateDestinations(theForm, 1, true))
		return false;

	return true;
}
//Make sure the Feature code is only letters and numbers.
$('#ext').keyup(function(){
	var cval = $(this).val();
	var patt = new RegExp("^[\*0-9]+$");
	if(!patt.test(cval) && cval.length > 0){
		warnInvalid($(this),_("This field must only contain numbers and *'s"));
	}	
});
//Check for conflicts
$('#ext').blur(function(){
	var cval = $(this).val();
	var id = 'miscapp_'+ $( "input[name='miscapp_id']" ).val();
	if(cval in extmap && cval.length > 0){
		var foundid = extmap[cval];
		if (foundid.indexOf(id) == -1){
			warnInvalid($(this),_("The number provided for the feature code is already in use by ") + extmap[cval]);
		}
	}
});

//Delete intercept
$( "#delete" ).click(function() {
		var result = confirm(_("Are you sure you want to delete this?"));
		if(result == false){
			return false;
		}
});
