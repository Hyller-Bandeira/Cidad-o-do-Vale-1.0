<?php 
# sv_SE translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Swedish / svenska
# Translator: Fimpen H�gstr�m <fimpen@relative-work.se>
# Last file update: 05.08.2013

// Class strings localization
define("L_DAYC", "Dag");
define("L_MONTHC", "M�nad");
define("L_YEARC", "�r");
define("L_TODAY", "I dag");
define("L_PREV", "Tidigare");
define("L_NEXT", "N�sta");
define("L_REF_CAL", "Uppdatera Kalendern...");
define("L_CHK_VAL", "Kolla v�rdet");
define("L_SEL_LANG", "V�lj spr�k");
define("L_SEL_ICON", "V�lj");
define("L_SEL_DATE", "V�lj datum");
define("L_ERR_SEL", "Ditt val �r inte giltig");
define("L_NOT_ALLOWED", "Detta datum �r inte till�tet att v�lja");
define("L_DATE_BEFORE", "V�lj ett datum f�re %s");
define("L_DATE_AFTER", "V�lj ett datum efter %s");
define("L_DATE_BETWEEN", "V�lj ett datum mellan\\n%s och %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Avbryt");
define("L_CLOSE", "St�ng");
define("L_WARN_2038", "Denna version av php server st�djer inte datum efter �r 2038! (<5.3.0)");
define("L_ERR_NOSET", "FEL! Kalenderv�rdet kan inte anv�ndas!");
define("L_VERSION", "Version: %s (%s spr�k)");
define("L_POWBY", "Baserat p�:"); //or "Based on:", "Supported by"
define("L_HERE", "h�r");
define("L_UPDATE", "Uppdatering tillg�nglig %s !");
define("L_TRANAME", "Fimpen H�gstr�m");
define("L_TRABY", "�versatt till svenska av<br />%s");
define("L_DONATE", "Om du vill l�mna ett<br />ekonomiskt bidrag?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "januari");
define("L_FEB", "februari");
define("L_MAR", "mars");
define("L_APR", "april");
define("L_MAY", "maj");
define("L_JUN", "juni");
define("L_JUL", "juli");
define("L_AUG", "augusti");
define("L_SEP", "september");
define("L_OCT", "oktober");
define("L_NOV", "november");
define("L_DEC", "december");
// Months Short Names
define("L_S_JAN", "jan");
define("L_S_FEB", "feb");
define("L_S_MAR", "mar");
define("L_S_APR", "apr");
define("L_S_MAY", "maj");
define("L_S_JUN", "jun");
define("L_S_JUL", "jul");
define("L_S_AUG", "aug");
define("L_S_SEP", "sep");
define("L_S_OCT", "okt");
define("L_S_NOV", "nov");
define("L_S_DEC", "dec");
// Week days Long Names
define("L_MON", "m�ndag");
define("L_TUE", "tisdag");
define("L_WED", "onsdag");
define("L_THU", "torsdag");
define("L_FRI", "fredag");
define("L_SAT", "l�rdag");
define("L_SUN", "s�ndag");
// Week days Short Names
define("L_S_MON", "m�");
define("L_S_TUE", "ti");
define("L_S_WED", "on");
define("L_S_THU", "to");
define("L_S_FRI", "fr");
define("L_S_SAT", "l�");
define("L_S_SUN", "s�");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "sv_SE");

// Set the SV specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "sve.ISO-8859-1", "swedish.ISO-8859-1", "swedish");
} else {
setlocale(LC_ALL, "sv_SE.ISO-8859-1", "sv_SE.ISO-8859-1@euro", "swedish.ISO-8859-1", "sve.ISO-8859-1", "sv.ISO-8859-1", "sve_sve.ISO-8859-1");
}
?>