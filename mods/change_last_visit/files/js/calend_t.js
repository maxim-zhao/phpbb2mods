/* ============================================== *\
	Calendar
	
	version:	1.3
	copyright:	(C) 2004-2005 Maciej Jaros
	license:	GNU General Public License v2,
				http://opensource.org/licenses/gpl-license.php
\* ============================================== */

/* ============================================== *\
    time en(de)coding + calendar - translator
\* ============================================== */
//
// dzien	1 - 31
// miesiac	0 - 11
// rok		-9999 - 9999
function zegarUpdateDMY(dzien,miesiac,rok) {
	miesiac++;
	if (dzien<10)		dzien	= "0" + dzien;
	if (miesiac<10)	miesiac	= "0" + miesiac;
	
	document.frm.dzien.value = dzien;
	document.frm.miesiac.value = miesiac;
	document.frm.rok.value = rok;
}

//
// for onChange event
//
// this is for an input that will containe time in format 33:33:33 or 33:33
// ":" is not important - might use "." or any else (then a number) e.g 33-33 33.33
var timeReg3 = /^(\d{1,2}).(\d{1,2}).(\d{1,2})$/;
var timeReg2 = /^(\d{1,2}).(\d{1,2})$/;
function time_Change () {
	str = "" + document.frm.time.value;
	arr = str.match(timeReg3);
	if (!arr)
	{
		arr = str.match(timeReg2);
		if (arr)	arr[3] = 0
		;
	}
	
	if (arr)
	{
		// modulus
		arr[1] %= 24;	// hours = 0 - 23
		arr[2] %= 60;	// minutes = 0 - 59
		arr[3] %= 60;	// seconds = 0 - 59

		// set
		document.frm.hours.value = arr[1];
		document.frm.minutes.value = arr[2];
		document.frm.seconds.value = arr[3];
		
		// print it back on screen (with leading zero)
		arr[1] = parseInt(arr[1],10);
		arr[2] = parseInt(arr[2],10);
		arr[3] = parseInt(arr[3],10);
		if (arr[1]<10)	arr[1] = "0" + arr[1]
		;
		if (arr[2]<10)	arr[2] = "0" + arr[2]
		;
		if (arr[3]<10)	arr[3] = "0" + arr[3]
		;
		document.frm.time.value = "" + arr[1] + ":" + arr[2] + ":" + arr[3];

		//alert('jo!');
	}
	else
	{
		alert(err_parse_time);
		//document.frm.time.focus();
	}
}

/* ============================================== *\
    time en(de)coding
\* ============================================== */
function initTimeToday () {
/*
	var today = new Date();

	var hours = today.getHours();
	var minutes = today.getMinutes();
	var seconds = today.getSeconds();
	var dzien = today.getDate();
	var miesiac = today.getMonth()+1;
	var rok = today.getYear();
	if (rok<1000)	rok		+=1900;

	if (hours<10)		hours	= "0" + hours;
	if (minutes<10)	minutes	= "0" + minutes;
	if (seconds<10)	seconds	= "0" + seconds;
	if (dzien<10)		dzien	= "0" + dzien;
	if (miesiac<10)	miesiac	= "0" + miesiac;

	document.frm.time.value = "" + hours + ":" + minutes + ":" + seconds;
	document.frm.hours.value = hours;
	document.frm.minutes.value = minutes;
	document.frm.seconds.value = seconds;
	document.frm.dzien.value = dzien;
	document.frm.miesiac.value = miesiac;
	document.frm.rok.value = rok;

*/
	//
	// set Current time from the one set through PHP
	hours = parseInt(document.frm.hours.value,10);
	minutes = parseInt(document.frm.minutes.value,10);
	seconds = parseInt(document.frm.seconds.value,10);
	
	if (hours<10)		hours	= "0" + hours;
	if (minutes<10)	minutes	= "0" + minutes;
	if (seconds<10)	seconds	= "0" + seconds;


	document.frm.time.value = "" + hours + ":" + minutes + ":" + seconds;

	//
	// onChange event handler
	document.frm.time.onchange = time_Change;
}

/* ============================================== *\
    Calendar
\* ============================================== */
var data = new Date();
var kal_days_holders;
var kal_days_holders_bgcolor;

//
// for onMouseOver event
function kal_MouseOver() {
	if (this.style.backgroundColor == kal_days_holders_bgcolor)
		this.style.backgroundColor = kal_days_holders_bgcolor_hover;
}
//
// for onMouseOver event
function kal_MouseOut() {
	if (this.style.backgroundColor == kal_days_holders_bgcolor_hover)
		this.style.backgroundColor = kal_days_holders_bgcolor;
}

//
// for onClick event
function kal_Click() {
	var dzien = this.innerHTML;
	var miesiac = data.getMonth();
	var rok = data.getYear();

	if (dzien<1)		dzien	= 1;
	if (rok<1000)		rok		+=1900;
	data.setDate(dzien);
	printDate(miesiac,rok);
	
	zegarUpdateDMY(dzien,miesiac,rok);

	for (i=kal_days_holders.length-1; i>=0; i--)
	{
		kal_days_holders.item(i).style.backgroundColor = kal_days_holders_bgcolor;
	}
	if (this.innerHTML == dzien)	// not a blank field
	{
		this.style.backgroundColor = kal_days_holders_bgcolor_mark;
	}
}

// Selecting the current day
function kal_SelectClick() {
	var fake_this;
	var dzien = data.getDate();

	for (i=kal_days_holders.length-1; i>=0; i--)
	{
		kal_days_holders.item(i).style.backgroundColor = kal_days_holders_bgcolor;
		if (kal_days_holders.item(i).innerHTML==dzien)
		{
			fake_this = kal_days_holders.item(i);
		}
	}
	fake_this.style.backgroundColor = kal_days_holders_bgcolor_mark;
}

//
// init the Calendar (inners and the header)
function initKalendarz() {
	//
	// Show the js version, hide the other one
	//
	s = document.getElementById('in_js_shown_holder');
	s.style.display = 'block';
	s = document.getElementById('in_js_hidden_holder');
	s.style.display = 'none';

	//
	// Set date form user's PHP time
	//
	var today = new Date(lastvis_year, lastvis_month, lastvis_day);
	data.setTime(today.getTime());

	kal_days_holders = document.getElementsByName("kal_days");

	//
	// init the bgcolors vars
	//
	// get the default, reinit hover, reinit mark, reset to default
	// reinit is done to avoid different names for colors
	kal_days_holders_bgcolor = kal_days_holders.item(0).style.backgroundColor;
	kal_days_holders.item(0).style.backgroundColor = kal_days_holders_bgcolor_hover;
	kal_days_holders_bgcolor_hover = kal_days_holders.item(0).style.backgroundColor;
	kal_days_holders.item(0).style.backgroundColor = kal_days_holders_bgcolor_mark;
	kal_days_holders_bgcolor_mark = kal_days_holders.item(0).style.backgroundColor;
	kal_days_holders.item(0).style.backgroundColor = kal_days_holders_bgcolor;
	
	rok = data.getYear();
	if (rok<1000)	rok+=1900;
	printDate(data.getMonth(),rok);
	fillKalendarz();

	for (i=kal_days_holders.length-1; i>=0; i--)
	{
		kal_days_holders.item(i).onclick = kal_Click;
		kal_days_holders.item(i).onmouseover = kal_MouseOver;
		kal_days_holders.item(i).onmouseout = kal_MouseOut;
	}
}

//
// month	0 - 11
// year		-9999 - 9999
function maxDayMY(month,year) {
	var day;
	
	// till july
	if (month<7)	// month from 0
	{
		// even (note: january=0 and is even)
		if (month%2==0)
			day = 31;
		// odd, but not february
		else if (month!=1)
			day = 30;
		// february in leap year
		else if (year%4==0 && year%100!=0 || year%400==0)
			day = 29;
		// february in normal year
		else
			day = 28;
	}
	// from april
	else
	{
		// even
		if (month%2==0)
			day = 30;
		// odd
		else if (month!=1)
			day = 31;
	}
	
	return day;
}

//
// month	0 - 11
// year		-9999 - 9999
function printDate(month,year) {
	document.getElementById("kal_dateMY").innerHTML = "" + data.getDate() + "&nbsp;" + months[month] + "&nbsp;" + year;
}

//
// Fill out the inners of the calendar
function fillKalendarz() {
	var temp = new Date(data);
	temp.setDate(1);
	var fstday = temp.getDay();
	if (fstday==0)
		fstday=7;

	temp.setDate(31);	// ostatni maksimum
	var lstday = temp.getDate();
	if (lstday<20)			// jesli przekrecil sie licznik, to
		lstday=31-lstday;	// ostatni = max - przekret
	lstday = lstday+fstday-1;
	//
	// oczyszczanie
	//
	// przedpola
	for (i=0; i<fstday-1; i++)
	{
		kal_days_holders.item(i).innerHTML = "";
	}
	// zapola
	for (i=kal_days_holders.length-1; i>=lstday; i--)
	{
		kal_days_holders.item(i).innerHTML = "";
	}

	//
	// wypisanie dni
	//
	for (day=0, i=fstday-1; i<lstday; i++)
	{
		day++;
		kal_days_holders.item(i).innerHTML = day;
	}

	kal_SelectClick();
}

//
// decrease year - update the header and the clock
function decYear() {
	// get updated year
	rok = data.getYear()-1;
	if (rok<1000)	rok+=1900;
	// get month
	miesiac = data.getMonth();

	// correct day if needed
	dzien = data.getDate();
	if (dzien>28)	// lowest max
	{
		tmp = maxDayMY(miesiac,rok);
		if (tmp<dzien)
		{
			dzien = tmp;
			data.setDate(dzien);
		}
	}
	
	// set year
	data.setYear(rok);

	// update
	fillKalendarz();
	printDate(miesiac,rok);
	zegarUpdateDMY(dzien,miesiac,rok);
}

//
// increase year - update the header and the clock
function incYear() {
	// get updated year
	rok = data.getYear()+1;
	if (rok<1000)	rok+=1900;
	// get month
	miesiac = data.getMonth();

	// correct day if needed
	dzien = data.getDate();
	if (dzien>28)	// lowest max
	{
		tmp = maxDayMY(miesiac,rok);
		if (tmp<dzien)
		{
			dzien = tmp;
			data.setDate(dzien);
		}
	}
	
	// set year
	data.setYear(rok);

	// update
	fillKalendarz();
	printDate(miesiac,rok);
	zegarUpdateDMY(dzien,miesiac,rok);
}

//
// decrease month - update the header and the clock
function decMonth() {
	// get year
	rok = data.getYear();
	if (rok<1000)	rok+=1900;
	// get updated month
	miesiac = data.getMonth()-1;

	// correct year (and month) if needed
	// the day should stay the same (border months have 31 days)
	if (miesiac<0)		// styczen -> grudzien
	{
		miesiac=11;
		rok--;
		data.setYear(rok);
	}

	// correct day if needed
	dzien = data.getDate();
	if (dzien>28)	// lowest max
	{
		tmp = maxDayMY(miesiac,rok);
		if (tmp<dzien)
		{
			dzien = tmp;
			data.setDate(dzien);
		}
	}
	
	// set month
	data.setMonth(miesiac);

	// update
	fillKalendarz();
	printDate(miesiac,rok);
	zegarUpdateDMY(dzien,miesiac,rok);
}
//
// increase month - update the header and the clock
function incMonth() {
	// get year
	rok = data.getYear();
	if (rok<1000)	rok+=1900;
	// get updated month
	miesiac = data.getMonth()+1;

	// correct year (and month) if needed
	// the day should stay the same (border months have 31 days)
	if (miesiac>11)	// grudzien -> styczen
	{
		miesiac=0;
		rok++;
		data.setYear(rok);
	}

	// correct day if needed
	dzien = data.getDate();
	if (dzien>28)	// lowest max
	{
		tmp = maxDayMY(miesiac,rok);
		if (tmp<dzien)
		{
			dzien = tmp;
			data.setDate(dzien);
		}
	}
	
	// set month
	data.setMonth(miesiac);

	// update
	fillKalendarz();
	printDate(miesiac,rok);
	zegarUpdateDMY(dzien,miesiac,rok);
}
