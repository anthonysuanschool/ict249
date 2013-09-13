 
 function updateOptionVal(id, valcont) {
	alert(valcont);
	$('option_'+id).val(valcont);
}

$(document).ready(function(){  

	$(".option_type").change(function(){	
		var option_type = $(this).val();
		if(option_type == 2) {
			if($.cookie('option_count') == null)	
				var option_count = 0;
			else 
				var option_count = $.cookie('option_count');
			if($.cookie('option_array') == null)	
				var option_array = new Array();
			else 
				var option_array =  JSON.parse($.cookie('option_array'));
			option_count++;	
			option_array.push(option_count);
			$.cookie('option_array', JSON.stringify(option_array));
			var quiz_blogurl = $('#quiz_blogurl').val();
			var answer_field = '<span class="answer_option" id="optionspan_'+option_count+'"><table><tr><td class="optioncheck" valign="top"><input type="radio" name="option_answer" id="optionans_'+option_count+'" value="'+option_count+'"> Choose<br> <input type="hidden" id="option_'+option_count+'" name="optionans_'+option_count+'"><textarea  id="optionmce_'+option_count+'" class="mceEditor"></textarea> </td><td><span onclick="optionAdd();" class="option_add"><img src="'+quiz_blogurl+'/add.png"></span> <span onclick="optionSubtract(this);" id="opt_'+option_count+'" class="option_subtract"><img src="'+quiz_blogurl+'/sub.png"></span></td></tr></table><br></span>';			
			$(".answer_div").html(answer_field);
			
			$.cookie('option_count', option_count);
			
			var config = {
				toolbar:
				[
				['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
				['UIColor']
				]
			};
			$('#optionmce_'+option_count).ckeditor(config);
			
		} else {
			var answer_field = '<table class="answer_table"><tr><td class="optioncheck" valign="top"><textarea  id="tcme_answer" class="mceEditor mce_editor" name="answer"></textarea></td></tr></table>';
			$(".answer_div").html(answer_field);
		}
	})
	
	
});

function optionAdd() {
	if($.cookie('option_count') == null)	
		var option_count = 0;
	else 
		var option_count = $.cookie('option_count');	
	if($.cookie('option_array') == null)	
				var option_array = new Array();
			else 
				var option_array =  JSON.parse($.cookie('option_array'));
	option_count++;	
	option_array.push(option_count);
			$.cookie('option_array', JSON.stringify(option_array));
	var quiz_blogurl = $('#quiz_blogurl').val();
			var answer_field = '<span class="answer_option" id="optionspan_'+option_count+'"><table><tr><td class="optioncheck" valign="top"><input type="radio" name="option_answer" id="optionans_'+option_count+'" value="'+option_count+'"> Choose<br> <input type="hidden" id="option_'+option_count+'" name="optionans_'+option_count+'"><textarea  id="optionmce_'+option_count+'" class="mceEditor"></textarea> </td><td><span onclick="optionAdd();" class="option_add"><img src="'+quiz_blogurl+'/add.png"></span> <span onclick="optionSubtract(this);" id="opt_'+option_count+'" class="option_subtract"><img src="'+quiz_blogurl+'/sub.png"></span></td></tr></table><br></span>';			
	$(".answer_div").append(answer_field);
	$.cookie('option_count', option_count);
	var config = {
				toolbar:
				[
				['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
				['UIColor']
				]
			};
			$('#optionmce_'+option_count).ckeditor(config);
	tinymce.triggerSave();
}

function optionSubtract(obj) {
	var obj_id = $(obj).attr('id');
	var obj_id_arr = obj_id.split('_');
	var obj_no = obj_id_arr[1];
	$('#optionspan_'+obj_no).fadeOut();
	$('#option_'+obj_no).val('');
}

function initialText() {
	var answer_field = '<table class="answer_table"><tr><td class="optioncheck" valign="top"><textarea id="tcme_answer"  class="mceEditor mce_editor" name="answer"></textarea></td></tr></table>';
	
}

function submitForm() {
	
	var option_array = JSON.parse($.cookie('option_array'));
	alert(option_array);
	for(var i = 0; i < option_array.length; i++) {
		var tmce_name = '#optionmce_'+option_array[i];
		$(tmce_name).ckeditor(function(){
			$('#option_'+option_array[i]).val(this.getData());
		});
	}
	
	//alert(1);
	document.forms["quiz_form"].submit();
}


window.onload = initialText;