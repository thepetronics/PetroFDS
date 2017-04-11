var lineno;
var prodLine = 0;

var zones = new Array(
// FIRST DST TIMEZONES
    [ 'Pacific/Apia' ]/* For Opera Linux. Unexpectedly winter-offset. */,

    [ 'Pacific/Apia' ]/* STD: -660 */,

    [ 'America/Adak' ]/* STD: -600 */,

    [ 'America/Anchorage' ]/* STD: -540 */,

    [ 'America/Los_Angeles' ]/* STD: -480 */,
    [ 'America/Santa_Isabel' ]/* STD: -480 */,

    [ 'America/Denver' ]/* STD: -420 */,
    [ 'America/Mazatlan' ]/* STD: -420 */,

    [ 'America/Chicago' ]/* STD: -360 */,
    [ 'America/Mexico_City' ]/* STD: -360 */,
    [ 'Pacific/Easter' ]/* STD: -360 */,

    [ 'America/Havana' ]/* STD: -300 */,
    [ 'America/New_York' ]/* STD: -300 */,

    [ 'America/Goose_Bay' ]/* STD: -240 */,
    [ 'America/Halifax' ]/* STD: -240 */,
    [ 'Atlantic/Stanley' ]/* STD: -240 */,
    [ 'America/Asuncion' ]/* STD: -240 */,
    [ 'America/Santiago' ]/* STD: -240 */,
    [ 'America/Campo_Grande' ]/* STD: -240 */,

    [ 'America/St_Johns' ]/* STD: -210 */,

    [ 'America/Miquelon' ]/* STD: -180 */,
    [ 'America/Godthab' ]/* STD: -180 */,
    [ 'America/Montevideo' ]/* STD: -180 */,
    [ 'America/Sao_Paulo' ]/* STD: -180 */,

    [ 'Atlantic/Azores' ]/* STD: -60 */,
    [ 'Atlantic/Azores' ], /* Windows fix */

    [ 'Europe/London' ]/* STD: 0 */,

    [ 'Europe/Berlin' ]/* STD: 60 */,
    [ 'Africa/Windhoek' ]/* STD: 60 */,

    [ 'Asia/Gaza' ]/* STD: 120 */,
    [ 'Asia/Beirut' ]/* STD: 120 */,
    [ 'Europe/Minsk' ]/* STD: 120 */,
    [ 'Europe/Helsinki' ]/* STD: 120 */,
    [ 'Asia/Jerusalem' ]/* STD: 120 */,
    [ 'Africa/Cairo' ]/* STD: 120 */,
    [ 'Asia/Damascus' ]/* Unexpectedly here winter-offset */,
    [ 'Asia/Amman' ]/* Unexpectedly here winter-offset */,

    [ 'Europe/Moscow' ]/* STD: 180 */,

    [ 'Asia/Tehran' ]/* STD: 210 */,

    [ 'Asia/Yerevan' ]/* STD: 240 */,
    [ 'Asia/Baku' ]/* STD: 240 */,

    [ 'Asia/Yekaterinburg' ]/* STD: 300 */,

    [ 'Asia/Omsk' ]/* STD: 360 */,

    [ 'Asia/Krasnoyarsk' ]/* STD: 420 */,

    [ 'Asia/Irkutsk' ]/* STD: 480 */,

    [ 'Asia/Yakutsk' ]/* STD: 540 */,

    [ 'Australia/Adelaide' ]/* STD: 570 */,

    [ 'Asia/Vladivostok' ]/* STD: 600 */,
    [ 'Australia/Lord_Howe' ]/* STD: 630 */,
    [ 'Australia/Sydney' ]/* STD: 600 */,

    [ 'Pacific/Fiji' ]/* STD: 660 */,
    [ 'Pacific/Fiji' ]/* STD: 660 */,
    [ 'Asia/Kamchatka' ]/* STD: 660 */,

    [ 'Pacific/Auckland' ]/* STD: 720 */,

    [ 'Pacific/Chatham' ]/* STD: 765 */,

// AND THEN NON-DST TIMEZONES: 

    [ 'Etc/GMT+12' ]/* STD: -720 */,

    [ 'Pacific/Pago_Pago' ]/* STD: -660 */,

    [ 'Pacific/Kiritimati' ], /* To prevent Firefox detecting Pacific/Kiritimati as Pacific Honolulu */
    [ 'Pacific/Honolulu' ]/* STD: -600 */,

    [ 'Pacific/Marquesas' ]/* STD: -570 */,

    [ 'Pacific/Gambier' ]/* STD: -540 */,

    [ 'Pacific/Pitcairn' ]/* STD: -480 */,

    [ 'America/Phoenix' ]/* STD: -420 */,

    [ 'America/Guatemala' ]/* STD: -360 */,

    [ 'America/Bogota' ]/* STD: -300 */,

    [ 'America/Caracas' ]/* STD: -270 */,

    [ 'America/Santo_Domingo' ]/* STD: -240 */,

    [ 'America/Argentina/Buenos_Aires' ]/* STD: -180 */,

    [ 'America/Noronha' ]/* STD: -120 */,

    [ 'Atlantic/Cape_Verde' ]/* STD: -60 */,

    [ 'Africa/Casablanca' ]/* STD: 0 */,

    [ 'Africa/Lagos' ]/* STD: 60 */,

    [ 'Africa/Johannesburg' ]/* STD: 120 */,

    [ 'Asia/Baghdad' ]/* STD: 180 */,

    [ 'Asia/Dubai' ]/* STD: 240 */,

    [ 'Asia/Kabul' ]/* STD: 270 */,

    [ 'Asia/Karachi' ]/* STD: 300 */,

    [ 'Asia/Kolkata' ]/* STD: 330 */,

    [ 'Asia/Kathmandu' ]/* STD: 345 */,

    [ 'Asia/Dhaka' ]/* STD: 360 */,

    [ 'Asia/Rangoon' ]/* STD: 390 */,

    [ 'Asia/Jakarta' ]/* STD: 420 */,

    [ 'Asia/Shanghai' ]/* STD: 480 */,

    [ 'Australia/Eucla' ]/* STD: 525 */,

    [ 'Asia/Tokyo' ]/* STD: 540 */,

    [ 'Australia/Darwin' ]/* STD: 570 */,

    [ 'Australia/Brisbane' ]/* STD: 600 */,

    [ 'Pacific/Noumea' ]/* STD: 660 */,

    [ 'Pacific/Norfolk' ]/* STD: 690 */,

    [ 'Pacific/Tarawa' ]/* STD: 720 */,

    [ 'Pacific/Tongatapu' ]/* STD: 780 */,

    [ 'Pacific/Kiritimati' ]/* STD: 840 */
);

function get_zone()
{
  	//RestFull WebService
	petrojs.GET('../setups/Ajax/get_zone.php', function(data){
		arrTexts = new Array();			
		for(var index=0; index<zones.length; index++)  {
		  arrTexts[index] = zones[index];
		}
		arrTexts.sort();
		if(data!=''){
			var HTML = '<select required class="form-select" name="country_region" id="country_region">';
			HTML += '<option value=""></option>';
			for (var index = 0; index < zones.length; ++index) {
				if(arrTexts[index] == data){
					HTML += '<option selected="selected" value="'+arrTexts[index]+'">'+arrTexts[index]+'</option>';
				}else{
					HTML += '<option value="'+arrTexts[index]+'">'+arrTexts[index]+'</option>';
				}
			}
			HTML += '</select>';
			$petrojs('#zone').html(HTML);
		}else{
			var HTML = '<select required class="form-select" name="country_region" id="country_region">';
			HTML += '<option value=""></option>';
			for (var index = 0; index < zones.length; ++index) {
				HTML += '<option value="'+arrTexts[index]+'">'+arrTexts[index]+'</option>';
			}
			HTML += '</select>';
			$petrojs('#zone').html(HTML);
		}
	});
}

petrojs.onload(function(){
	get_zone();
},window.petrojs);

/**
 * OPTION Days line
 */
 
function insertDaysLine(ln)
{	
	var x=document.getElementById('DaysLine_row').insertRow(-1);
	x.id='days_line'+ln;
	
	var a=x.insertCell(0);
	var b=x.insertCell(1);
	var c=x.insertCell(2);
	var d=x.insertCell(3);
	var d1=x.insertCell(4);
	var d2=x.insertCell(5);
	var e=x.insertCell(6);		
			
	a.innerHTML='<input type="text" name="days[]" id="days'+ ln +'" required class="form-text required fluid" />';
	b.innerHTML='<input type="text" name="open_time[]" id="open_time'+ ln +'" required class="form-text required fluid" placeholder="hours:minutes:seconds" />';
	c.innerHTML='<input type="text" name="close_time[]" id="close_time'+ ln +'" required class="form-text required fluid" placeholder="hours:minutes:seconds" />';
	d.innerHTML='<input type="text" name="total_hours[]" id="total_hours'+ ln +'" required class="form-text required fluid" />';
	d1.innerHTML="<input type='hidden' name='opt_deleted[]' id='opt_deleted" + ln + "' value='0'><input type='button' class='form-submit' value='Remove Row' tabindex='116' onclick='markOptLineDeleted(" + ln + ")'/><br>";

	ln++;
	prodLine++;

	document.getElementById('DaysLine').onclick = function() {
		insertDaysLine(ln);
	};
}

/**
 * Mark product line deleted
 */
function markOptLineDeleted(ln)
{
	if(confirm("Are you sure you want to remove this line?"))
	{
		document.getElementById('days_line' + ln).style.display = 'none';
		document.getElementById('opt_deleted' + ln).value = '1';
		prodLine--;
	}
}