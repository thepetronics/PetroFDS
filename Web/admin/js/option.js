 var lineno;
 var prodLine = 0;

function get_type()
{
  	//RestFull WebService
	petrojs.GET('Ajax/get_option_type.php', function(data){
		if(data!=''){
			$petrojs("#opt_type").html(data);
		}else{
			$petrojs("#opt_type").html('<option value="error loading data">error loading data</option>')
		}
	});
}

petrojs.onload(function(){
	get_type();
},window.petrojs);

function is_yes_no_check(id){
	if(id.value == '1'){
		$petrojs('#option_val_line').hide();
	}else{
		$petrojs('#option_val_line').show();
	}
}

function opt_type_change(id){
	var opt_type = document.getElementById('opt_type').value;
	if(opt_type == ''){
		$petrojs('#option_val_line').hide();
	}else{
		$petrojs('#option_val_line').show();
	}
}

/**
 * OPTION Insert line
 */
 
function insertOptLine(ln)
{	
	var x=document.getElementById('OptLine').insertRow(-1);
	x.id='opt_line'+ln;

	var a=x.insertCell(0);
	var b=x.insertCell(1);
	var c=x.insertCell(2);
	var d=x.insertCell(3);		
			
	a.innerHTML="<input type='text' name='title[]' id='title" + ln + "' value='' title='' class='form-text required fluid'  />";
	b.innerHTML="<input type='text' name='price[]' id='price" + ln + "' value='' title='' class='form-text required fluid'  />";
	c.innerHTML="<input type='text' name='sort_order[]' id='sort_order" + ln + "' value='' title='' class='form-text required fluid'  />";
	d.innerHTML="<input type='hidden' name='opt_deleted[]' id='opt_deleted" + ln + "' value='0'><input type='button' class='form-submit' value='Remove Row' tabindex='116' onclick='markOptLineDeleted(" + ln + ")'/><br>";

	ln++;
	prodLine++;

	document.getElementById('addOptLine').onclick = function() {
		insertOptLine(ln);
	}
}

/**
 * Mark product line deleted
 */
function markOptLineDeleted(ln)
{
	//if(confirm("Are you sure you want to remove this line?"))
	//{
		// collapse product line; update deleted value
		document.getElementById('opt_line' + ln).style.display = 'none';
		document.getElementById('opt_deleted' + ln).value = '1';
		prodLine--;
	//}
}

function option_add(ln){
	var opt_type = document.getElementById("opt_type"+ln).value;
	if(opt_type == 0){
		$petrojs('#finLine').hide();
		$petrojs('#finmore').hide();
	}else{
		$petrojs('#finLine').show();
		$petrojs('#finmore').show();
	}
	
}
