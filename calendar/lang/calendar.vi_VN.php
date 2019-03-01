<?php 
# vi_VN translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.69
# Language: Vietnamese / Ti?ng Vi?t
# Translator: Marshall <hellomarshal_lookatme@yahoo.com.vn>
# Last file update: 19.05.2013

// Class strings localization
define("L_DAYC", "Ngаy");
define("L_MONTHC", "Thбng");
define("L_YEARC", "Nam");
define("L_TODAY", "Hфm nay");
define("L_PREV", "Tru?c");
define("L_NEXT", "Ti?p theo");
define("L_REF_CAL", "L?ch lаm m?i...");
define("L_CHK_VAL", "Ki?m tra giб tr?");
define("L_SEL_LANG", "L?a ch?n ngфn ng?");
define("L_SEL_ICON", "L?a ch?n");
define("L_SEL_DATE", "L?a ch?n ngаy");
define("L_ERR_SEL", "S? l?a ch?n c?a b?n khфng h?p l?");
define("L_NOT_ALLOWED", "Ngаy khфng du?c ch?p nh?n d? ch?n");
define("L_DATE_BEFORE", "Lаm on ch?n ngаy tru?c %s");
define("L_DATE_AFTER", "Lаm on ch?n ngаy sau %s");
define("L_DATE_BETWEEN", "Lаm on ch?n ngаy gi?a\\n%s vа %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "B? l?a ch?n");
define("L_CLOSE", "Руng l?i");
define("L_TRANAME", "Marshall");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "Thбng M?t");
define("L_FEB", "Thбng Hai");
define("L_MAR", "Thбng Ba");
define("L_APR", "Thбng Tu");
define("L_MAY", "Thбng Nam");
define("L_JUN", "Thбng Sбu");
define("L_JUL", "Thбng B?y");
define("L_AUG", "Thбng Tбm");
define("L_SEP", "Thбng Chнn");
define("L_OCT", "Thбng Mu?i");
define("L_NOV", "Thбng Mu?i m?t");
define("L_DEC", "Thбng Ch?p"); //Thбng Mu?i hai
// Months Short Names
define("L_S_JAN", "Thбng 1");
define("L_S_FEB", "Thбng 2");
define("L_S_MAR", "Thбng 3");
define("L_S_APR", "Thбng 4");
define("L_S_MAY", "Thбng 5");
define("L_S_JUN", "Thбng 6");
define("L_S_JUL", "Thбng 7");
define("L_S_AUG", "Thбng 8");
define("L_S_SEP", "Thбng 9");
define("L_S_OCT", "Thбng 10");
define("L_S_NOV", "Thбng 11");
define("L_S_DEC", "Thбng 12");
// Week days Long Names
define("L_MON", "Th? Hai");
define("L_TUE", "Th? Ba");
define("L_WED", "Th? Tu");
define("L_THU", "Th? Nam");
define("L_FRI", "Th? Sбu");
define("L_SAT", "Th? B?y");
define("L_SUN", "Ch? Nh?t");
// Week days Short Names
define("L_S_MON", "Hai");
define("L_S_TUE", "Ba");
define("L_S_WED", "Tu");
define("L_S_THU", "Nam");
define("L_S_FRI", "Sбu");
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