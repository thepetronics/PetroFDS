 var lineno;
 var prodLine = 0;
 var prodLine1 = 0;

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function get_option(ln)
{
  	//RestFull WebService
	petrojs.GET('Ajax/get_type_option.php', function(data){
		if(data!=''){
			$petrojs("#option_no_type" + ln).html(data);
		}else{
			$petrojs("#option_no_type" + ln).html('<option value="error loading data">error loading data</option>')
		}
	});
}

function get_opt_type(ln){
	//RestFull WebService
	petrojs.GET('Ajax/get_opt_type.php?ln='+ln+'', function(data){
		if(data!=''){
			$petrojs("#opt_types" + ln).html(data);
		}else{
			$petrojs("#opt_types" + ln).html('<label>error loading data</label>')
		}
	});
}

function get_category()
{
	var product_id = getParameterByName('id');
	
	if(product_id != ''){
		//RestFull WebService
		petrojs.GET('Ajax/get_category.php?product_id='+product_id+'', function(data){
			if(data!=''){
				$petrojs("#cate_menu").html(data);
			}else{
				$petrojs("#cate_menu").html('<option value="error loading data">error loading data</option>')
			}
		});
	}else{
		//RestFull WebService
		petrojs.GET('Ajax/get_category.php', function(data){
			if(data!=''){
				$petrojs("#cate_menu").html(data);
			}else{
				$petrojs("#cate_menu").html('<option value="error loading data">error loading data</option>')
			}
		});
	}
}

function change(cat_id){
	alert(cat_id)
}

petrojs.onload(function(){
	get_category();
},window.petrojs);

/**
 * OPTION Insert line
 */
function insertMenuOptLine(ln)
{	
	get_option(ln);
	var x=document.getElementById('Opt_menu_Line').insertRow(-1);
	x.id='opt_menu_line'+ln;
	
	var a=x.insertCell(0);
	var b=x.insertCell(1);
	var c=x.insertCell(2);
	var d=x.insertCell(3);
	var d1=x.insertCell(4);
	var d2=x.insertCell(5);
	var e=x.insertCell(6);		
			
	a.innerHTML='<input type="text" name="name[]" id="name" class="form-text required fluid" />';
	b.innerHTML="<select name='option_no_type[]' id='option_no_type" + ln + "' class='form-select'></select>";
	c.innerHTML="<input type='hidden' name='opt_menu_deleted[]' id='opt_menu_deleted" + ln + "' value='0'><input type='button' class='form-submit' value='Remove Row' tabindex='116' onclick='markOptLineDeleted(" + ln + ")'/><br>";

	ln++;
	prodLine++;

	document.getElementById('addOptLine').onclick = function() {
		insertMenuOptLine(ln);
	}
}

/**
 * Mark product line deleted
 */
function markOptLineDeleted(ln)
{
	if(confirm("Are you sure you want to remove this line?"))
	{
		// collapse product line; update deleted value
		document.getElementById('opt_menu_line' + ln).style.display = 'none';
		document.getElementById('opt_menu_deleted' + ln).value = '1';
		prodLine--;
	}
}

function check_click(ln,n,val){
	s = n+"_check"+ln;
	if(document.getElementById(s).checked){
		document.getElementById(n+ln).value=val;
		$petrojs('#'+n+ln).newAttr('name','option[]');
	}else{
		document.getElementById(n+ln).value='0';
		$petrojs('#'+n+ln).removeAttr('name');
	}
}

function check_click_custom(ln,count,n,val){
	s = n+"_check_"+count+"_"+ln;
	if(document.getElementById(s).checked){
		if(document.getElementById("option_cust"+ln).value != ''){
			var v = document.getElementById("option_cust"+ln).value;
			document.getElementById("option_cust"+ln).value=v+','+val;
		}else{
			document.getElementById("option_cust"+ln).value=val;
		}
		document.getElementById(n+"_"+count+"_"+ln).value=val;
		$petrojs('#'+n+"_"+count+"_"+ln).newAttr('name','option_custom[]');
	}else{
		if(document.getElementById("option_cust"+ln).value != ''){
			var t = document.getElementById("option_cust"+ln).value;
			if(t==val){
				t = t.replace(val,'');
			}else if(t.indexOf(','+val) > -1){
				t = t.replace(','+val,'');
			}else{
				t = t.replace(val+',','');
			}
			document.getElementById("option_cust"+ln).value = t;
		}
		document.getElementById(n+"_"+count+"_"+ln).value='0';
		$petrojs('#'+n+"_"+count+"_"+ln).removeAttr('name');
	}
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

/**
 * CUSTOMOPTION Insert line
 */
 
function insertCustomLine(ln1)
{	
	get_opt_type(ln1);
	var x=document.getElementById('Opt_custom_Line').insertRow(-1);
	x.id='custom_line'+ln1;
	
	var a=x.insertCell(0);
	var b=x.insertCell(1);
	var c=x.insertCell(2);
	var d=x.insertCell(3);
	var d1=x.insertCell(4);
	var d2=x.insertCell(5);
	var e=x.insertCell(6);
			
	a.innerHTML="<input type='hidden' name='option_cust[]' id='option_cust"+ln1+"' /><input type='text' name='title[]' id='title" + ln1 + "' value='' title='' class='form-text required fluid'  />";
	b.innerHTML="<input type='text' name='price[]' id='price" + ln1 + "' value='' title='' class='form-text required fluid'  />";
	c.innerHTML="<div id='opt_types" + ln1 + "'></div>";
	d.innerHTML="<input type='hidden' name='opt_deleted[]' id='opt_deleted" + ln1 + "' value='0'><input type='button' class='form-submit' value='Remove Row' tabindex='116' onclick='markCustomLineDeleted(" + ln1 + ")'/><br>";

	ln1++;
	prodLine1++;

	document.getElementById('CustomLine').onclick = function() {
		insertCustomLine(ln1);
	}
}

/**
 * Mark product line deleted
 */
function markCustomLineDeleted(ln1)
{
	if(confirm("Are you sure you want to remove this line?"))
	{
		// collapse product line; update deleted value
		document.getElementById('custom_line' + ln1).style.display = 'none';
		document.getElementById('custom_deleted' + ln1).value = '1';
		prodLine1--;
	}
}

// upload section
document.getElementById("uploadBtn").onchange = function () {
	document.getElementById("uploadFile").innerHTML = this.value;
};
