<?php 
# vi_VN translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.69
# Language: Vietnamese / Ti?ng Vi?t
# Translator: Marshall <hellomarshal_lookatme@yahoo.com.vn>
# Last file update: 19.05.2013

// Class strings localization
define("L_DAYC", "Ng�y");
define("L_MONTHC", "Th�ng");
define("L_YEARC", "Nam");
define("L_TODAY", "H�m nay");
define("L_PREV", "Tru?c");
define("L_NEXT", "Ti?p theo");
define("L_REF_CAL", "L?ch l�m m?i...");
define("L_CHK_VAL", "Ki?m tra gi� tr?");
define("L_SEL_LANG", "L?a ch?n ng�n ng?");
define("L_SEL_ICON", "L?a ch?n");
define("L_SEL_DATE", "L?a ch?n ng�y");
define("L_ERR_SEL", "S? l?a ch?n c?a b?n kh�ng h?p l?");
define("L_NOT_ALLOWED", "Ng�y kh�ng du?c ch?p nh?n d? ch?n");
define("L_DATE_BEFORE", "L�m on ch?n ng�y tru?c %s");
define("L_DATE_AFTER", "L�m on ch?n ng�y sau %s");
define("L_DATE_BETWEEN", "L�m on ch?n ng�y gi?a\\n%s v� %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "B? l?a ch?n");
define("L_CLOSE", "��ng l?i");
define("L_TRANAME", "Marshall");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "Th�ng M?t");
define("L_FEB", "Th�ng Hai");
define("L_MAR", "Th�ng Ba");
define("L_APR", "Th�ng Tu");
define("L_MAY", "Th�ng Nam");
define("L_JUN", "Th�ng S�u");
define("L_JUL", "Th�ng B?y");
define("L_AUG", "Th�ng T�m");
define("L_SEP", "Th�ng Ch�n");
define("L_OCT", "Th�ng Mu?i");
define("L_NOV", "Th�ng Mu?i m?t");
define("L_DEC", "Th�ng Ch?p"); //Th�ng Mu?i hai
// Months Short Names
define("L_S_JAN", "Th�ng 1");
define("L_S_FEB", "Th�ng 2");
define("L_S_MAR", "Th�ng 3");
define("L_S_APR", "Th�ng 4");
define("L_S_MAY", "Th�ng 5");
define("L_S_JUN", "Th�ng 6");
define("L_S_JUL", "Th�ng 7");
define("L_S_AUG", "Th�ng 8");
define("L_S_SEP", "Th�ng 9");
define("L_S_OCT", "Th�ng 10");
define("L_S_NOV", "Th�ng 11");
define("L_S_DEC", "Th�ng 12");
// Week days Long Names
define("L_MON", "Th? Hai");
define("L_TUE", "Th? Ba");
define("L_WED", "Th? Tu");
define("L_THU", "Th? Nam");
define("L_FRI", "Th? S�u");
define("L_SAT", "Th? B?y");
define("L_SUN", "Ch? Nh?t");
// Week days Short Names
define("L_S_MON", "Hai");
define("L_S_TUE", "Ba");
define("L_S_WED", "Tu");
define("L_S_THU", "Nam");
define("L_S_FRI", "S�u");
define("L_S_SAT", "B?y");
define("L_S_SUN", "CN");

// Windows encoding
define("WIN_DEFAULT", "windows-1258");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "vi_VN");

// Set the VN specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "vietnamese", "vietnamese.ISO-8859-1", "viet nam.ISO-8859-1", "viet nam");
} else {
setlocale(LC_ALL, "vi_VN.ISO-8859-1", "vnd_vnd.ISO-8859-1", "vie_vie.ISO-8859-1");
}
?>