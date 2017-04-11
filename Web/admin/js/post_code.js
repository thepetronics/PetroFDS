 var lineno;
 var prodLine = 0;

/**
 * OPTION Insert line
 */
 
function insertPostCodeLine(ln)
{	
	var x=document.getElementById('PostCodeLine').insertRow(-1);
	x.id='code_line'+ln;
	
	var a=x.insertCell(0);
	var b=x.insertCell(1);
	var c=x.insertCell(2);
	var d=x.insertCell(3);
	var d1=x.insertCell(4);
	var d2=x.insertCell(5);
	var e=x.insertCell(6);		
			
	a.innerHTML="<input type='text' name='postcode[]' id='postcode" + ln + "' value='' title='' class='form-text required fluid'  />";
	b.innerHTML="<input type='text' name='price[]' id='price" + ln + "' value='' title='' class='form-text required fluid'  />";
	c.innerHTML="<input type='hidden' name='code_deleted[]' id='code_deleted" + ln + "' value='0'><input type='button' class='form-submit' value='Remove Row' tabindex='116' onclick='markPostCodeLineDeleted(" + ln + ")'/><br>";

	ln++;
	prodLine++;

	document.getElementById('addPostCodeLine').onclick = function() {
		insertPostCodeLine(ln);
	}
}

/**
 * Mark product line deleted
 */
function markPostCodeLineDeleted(ln)
{
	if(confirm("Are you sure you want to remove this line?"))
	{
		// collapse product line; update deleted value
		document.getElementById('code_line' + ln).style.display = 'none';
		document.getElementById('code_deleted' + ln).value = '1';
		prodLine--;
	}
}
