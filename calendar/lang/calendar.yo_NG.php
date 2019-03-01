<?php 
# yo_NG translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.69
# Language: Yoruba (Nigeria) / Yorщbб
# Last file update: 26.05.2013

// Class strings localization
define("L_DAYC", "Day");
define("L_MONTHC", "Month");
define("L_YEARC", "Year");
define("L_TODAY", "Today");
define("L_PREV", "Previous");
define("L_NEXT", "Next");
define("L_REF_CAL", "Refreshing Calendar...");
define("L_CHK_VAL", "Check the value");
define("L_SEL_LANG", "Select Language");
define("L_SEL_ICON", "Select");
define("L_SEL_DATE", "Select Date");
define("L_ERR_SEL", "Your selection is not valid");
define("L_NOT_ALLOWED", "This date is not allowed to be selected");
define("L_DATE_BEFORE", "Please choose a date before %s");
define("L_DATE_AFTER", "Please choose a date after %s");
define("L_DATE_BETWEEN", "Please choose a date between\\n%s and %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Unset");
define("L_CLOSE", "Close");
define("L_WARN_2038", "This php server’s version does not have support for year 2038 and later! (<5.3.0)");
define("L_ERR_NOSET", "Error! The calendar value cannot be set!");
define("L_VERSION", "Version: %s (%s languages)");
define("L_POWBY", "Powered by:"); //or "Based on:", "Supported by"
define("L_HERE", "here");
define("L_UPDATE", "Update available %s !");
define("L_TRANAME", "Google"); //Keep a short name
define("L_TRABY", "Translated by %s");
define("L_DONATE", "Do you wish to donate?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "Jбnъбrм");
define("L_FEB", "F?ґbъбrм");
define("L_MAR", "Mба?м");
define("L_APR", "Йpнrм");
define("L_MAY", "Mйи");
define("L_JUN", "Jъщnщ");
define("L_JUL", "Jъlбм");
define("L_AUG", "?ґ?ґg?sм");
define("L_SEP", "S?`t?`nbа");
define("L_OCT", "?tуbа");
define("L_NOV", "Nтf?`nbа");
define("L_DEC", "Dмs?`nbа");
// Months Short Names
define("L_S_JAN", "Jбn");
define("L_S_FEB", "F?ґb");
define("L_S_MAR", "Mба");
define("L_S_APR", "Йpн");
define("L_S_MAY", "Mйи");
define("L_S_JUN", "Jъщ");
define("L_S_JUL", "Jъl");
define("L_S_AUG", "?ґ?ґg");
define("L_S_SEP", "S?`t");
define("L_S_OCT", "?tу");
define("L_S_NOV", "Nтf");
define("L_S_DEC", "Dмs");
// Week days Long Names
define("L_MON", "Ajй");
define("L_TUE", "М??ґgun");
define("L_WED", "Rъ");
define("L_THU", "B?`");
define("L_FRI", "?`tм");
define("L_SAT", "Аbбm?ґta");
define("L_SUN", "Амkъ");
// Week days Short Names
define("L_S_MON", "Aj");
define("L_S_TUE", "М?");
define("L_S_WED", "Rъ");
define("L_S_THU", "B?`");
define("L_S_FRI", "?`t");
define("L_S_SAT", "Аb");
define("L_S_SUN", "Ам");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%B %d %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "yo_NG"); // en_US format of your language

// Set the YO specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "yor-yor.ISO-8859-1", "yor-nga.ISO-8859-1", "yor", "Yoruba");
} else {
setlocale(LC_ALL, "yo_NG.ISO-8859-1", "yor.ISO-8859-1", "yor_yor.ISO-8859-1", "yor_nga.ISO-8859-1", "Yoruba.ISO-8859-1"); // For American formats
}
?>