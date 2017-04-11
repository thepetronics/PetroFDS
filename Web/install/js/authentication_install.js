function validateForm()
{
var x=$petrojs('#database_host').getval();
if (x==null || x=="")
  {
  alert("Please Enter the database host");
  return false;
  }
var x=$petrojs('#database_name').getval();
if (x==null || x=="")
  {
  alert("Please Enter the database name");
  return false;
  }
var x=$petrojs('#database_username').getval();
if (x==null || x=="")
  {
  alert("Please Enter the database username");
  return false;
  }
var x=$petrojs('#admin_firstname').getval();
if (x==null || x=="")
  {
  alert("Please Enter the administrator firstname");
  return false;
  }
var x=$petrojs('#admin_lastname').getval();
if (x==null || x=="")
  {
  alert("Please Enter the administrator lastname");
  return false;
  }
var x=$petrojs('#admin_username').getval();
if (x==null || x=="")
  {
  alert("Please Enter the administrator username");
  return false;
  }
var x=$petrojs('#admin_password').getval();
if (x==null || x=="")
  {
  alert("Please Enter the administrator password");
  return false;
  }
}

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

arrTexts = new Array();

for(var i=0; i<zones.length; i++)  {
  arrTexts[i] = zones[i];
}

arrTexts.sort();

var HTML = '<select required class="form-select" name="timezone" id="timezone">';
HTML += '<option value=""></option>';
for (var i = 0; i < zones.length; i++) {
	HTML += '<option value="'+arrTexts[i]+'">'+arrTexts[i]+'</option>';
}
HTML += '</select>';
document.getElementById("zone").innerHTML=HTML;