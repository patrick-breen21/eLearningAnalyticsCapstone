/* jQuery MaxLength for INPUT and TEXTAREA fields
*/

var uncheckedkeycodes=/(8)|(13)|(16)|(17)|(18)/  //keycodes that are not checked, even when limit has been reached.

function setformfieldsize($fields, maxLength){	
	var $=jQuery
	$fields.each(function(i){
		var $field=$(this)
		$field.data('maxsize', maxLength) //max character limit		
		$field.unbind('keypress.restrict').bind('keypress.restrict', function(e){
			setformfieldsize.restrict($field, e)
		})
		$field.unbind('keyup.show').bind('keyup.show', function(e){
			setformfieldsize.showlimit($field)
		})
		setformfieldsize.showlimit($field) 
	})
}

setformfieldsize.restrict=function($field, e){
	var keyunicode=e.charCode || e.keyCode
	if (!uncheckedkeycodes.test(keyunicode)){
		if ($field.val().length >= $field.data('maxsize')){ //if characters entered exceed allowed
			if (e.preventDefault)
				e.preventDefault()
			return false
		}
	}
}

setformfieldsize.showlimit=function($field){
	if ($field.val().length > $field.data('maxsize')){
		var trimmedtext=$field.val().substring(0, $field.data('maxsize'))
		$field.val(trimmedtext)
	}
}
