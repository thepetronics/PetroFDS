 var lineno;
 var prodLine = 0;


/**
 * OPTION VALUE Insert line
 */
 
function insertFinLine(ln)
{
	
	var x=document.getElementById('finLine').insertRow(-1);
	x.id='fin_line'+ln;
	
	var a=x.insertCell(0);
	var b=x.insertCell(1);
	var c=x.insertCell(2);
	var d=x.insertCell(3);
	var e=x.insertCell(4);
	var f=x.insertCell(5);	
	

			
	a.innerHTML="<select name='fin_adp_year[]' id='fin_adp_year" + ln + "' class='form-select'><option value=''></option><option value='1'>1</option><option value='2'>2</option></select>";
	b.innerHTML="<input type='text' name='fin_alloc_cost[]' id='fin_alloc_cost" + ln + "' size='14' value='' title='' class='form-text required fluid'  />";
	c.innerHTML="<input type='text' name='fin_alloc_rev[]' id='fin_alloc_rev" + ln + "' size='14' value='' title='' class='form-text required fluid'  />";	
	d.innerHTML="<input type='text' name='fin_alloc_real[]' id='fin_alloc_real" + ln + "' size='8' value='0' title=''  class='form-text required fluid'  />";	
	e.innerHTML="<input type='text' name='fin_alloc_exp[]' id='fin_alloc_exp" + ln + "' size='8' value='' title='' class='form-text required fluid'  />";

	f.innerHTML="<input type='hidden' name='fin_deleted[]' id='fin_deleted" + ln + "' value='0'><input type='button' class='form-submit' value='Remove Row' tabindex='116' onclick='markFinLineDeleted(" + ln + ")'/><br>";
	

	ln++;
	prodLine++;

	document.getElementById('addFinLine').onclick = function() {
		insertFinLine(ln);
		
	}
}

/**
 * Mark product line deleted
 */
function markFinLineDeleted(ln)
{
	if(confirm("Are you sure you want to remove this line?"))
	{
		// collapse product line; update deleted value
		document.getElementById('fin_line' + ln).style.display = 'none';
		document.getElementById('fin_deleted' + ln).value = '1';
		prodLine--;
	}
}

