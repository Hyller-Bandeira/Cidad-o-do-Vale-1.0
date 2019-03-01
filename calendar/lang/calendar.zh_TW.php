<?php 
# zh_TW translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Chinese Traditional / ????
# Translator: clouds_music <clouds.music@gmail.com>
# Last file update: 25.07.2013

// Class strings localization
define("L_DAYC", "?");
define("L_MONTHC", "?");
define("L_YEARC", "?");
define("L_TODAY", "??");
define("L_PREV", "??");
define("L_NEXT", "??");
define("L_REF_CAL", "????...");
define("L_CHK_VAL", "???");
define("L_SEL_LANG", "????");
define("L_SEL_ICON", "??");
define("L_SEL_DATE", "????");
define("L_ERR_SEL", "????????");
define("L_NOT_ALLOWED", "??????????");
define("L_DATE_BEFORE", "?????%s????");
define("L_DATE_AFTER", "???%s?????");
define("L_DATE_BETWEEN", "?????%s?%s??");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "??");
define("L_CLOSE", "??");
define("L_WARN_2038", "??PHP??????????2038???!(< 5.3.0 )");
define("L_ERR_NOSET", "??!???,????!");
define("L_VERSION", "??: %s (%s??)");
define("L_POWBY", "????:"); //or "Based on:", "Supported by"
define("L_HERE", "??");
define("L_UPDATE", "????%s!");
define("L_TRANAME", "clouds_music");
define("L_TRABY", "??????<br />%s????? ");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday ... 6 for Saturday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "??");
define("L_FEB", "??");
define("L_MAR", "??");
define("L_APR", "??");
define("L_MAY", "??");
define("L_JUN", "??");
define("L_JUL", "??");
define("L_AUG", "??");
define("L_SEP", "??");
define("L_OCT", "??");
define("L_NOV", "???");
define("L_DEC", "???");
// Months Short Names
define("L_S_JAN", "1?");
define("L_S_FEB", "2?");
define("L_S_MAR", "3?");
define("L_S_APR", "4?");
define("L_S_MAY", "5?");
define("L_S_JUN", "6?");
define("L_S_JUL", "7?");
define("L_S_AUG", "8?");
define("L_S_SEP", "9?");
define("L_S_OCT", "10?");
define("L_S_NOV", "11?");
define("L_S_DEC", "12?");
// Week days Long Names
define("L_MON", "???");
define("L_TUE", "???");
define("L_WED", "???");
define("L_THU", "???");
define("L_FRI", "???");
define("L_SAT", "???");
define("L_SUN", "???");
// Week days Short Names
define("L_S_MON", "?");
define("L_S_TUE", "?");
define("L_S_WED", "?");
define("L_S_THU", "?");
define("L_S_FRI", "?");
define("L_S_SAT", "?");
define("L_S_SUN", "?");

// Display extratext beside years, months and/or days in dropdowns (eg. Korean and Japan)
define("L_USE_YMD_DROP", 1);

// Windows encoding
define("WIN_DEFAULT", "ISO-8859-1");
define("L_CAL_FORMAT", "%Y?%B%d?");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "zh_TW"); // en_US format of your language

// Set the ZH specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "zh-tw.ISO-8859-1", "Chinese.ISO-8859-1", "zh-tw", "Chinese_Taiwan");
} else {
setlocale(LC_ALL, "zh_TW.ISO-8859-1", "Chinese.ISO-8859-1");
}
?>