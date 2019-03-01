<?php 
# hu_HU translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Hungarian / magyar
# Translator: J�cint Zsuzsanna <jacint.zsuzsanna@yahoo.com>
# Last file update: 29.07.2013

// Class strings localization
define("L_DAYC", "Nap");
define("L_MONTHC", "H�nap");
define("L_YEARC", "�v");
define("L_TODAY", "Ma");
define("L_PREV", "Elozo");
define("L_NEXT", "K�vetkezo");
define("L_REF_CAL", "Napt�r friss�t�se...");
define("L_CHK_VAL", "Ellenorizd az �rt�ket");
define("L_SEL_LANG", "V�lassz nyelvet");
define("L_SEL_ICON", "Kiv�laszt");
define("L_SEL_DATE", "V�lassz d�tumot");
define("L_ERR_SEL", "A v�laszt�sod nem �rv�nyes");
define("L_NOT_ALLOWED", "Ezt a d�tumot nem lehet kiv�lasztani");
define("L_DATE_BEFORE", "K�rj�k, v�lasszon egy d�tumot elott %s");
define("L_DATE_AFTER", "K�rj�k, v�lasszon egy d�tumot k�vetoen %s");
define("L_DATE_BETWEEN", "K�rj�k, v�lasszon egy d�tumot k�z�tti\\n%s �s %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "M�gse");
define("L_CLOSE", "Bez�r");
define("L_WARN_2038", "A php szerver ezen verzi�ja nem t�mogatja a 2038-as illetve az ezt k�veto �veket! (<5.3.0)");
define("L_ERR_NOSET", "Hiba! A napt�ri �rt�ket nem lehet be�ll�tani!");
define("L_VERSION", "Verzi�: %s (%s nyelvek)");
define("L_POWBY", "�zemelteti:"); //or "Based on:", "Supported by"
define("L_HERE", "itt");
define("L_UPDATE", "Friss�t�s %s el�rheto.");
define("L_TRANAME", "J�cint Zsuzsanna");
define("L_TRABY", "Ford�totta %s");
define("L_DONATE", "Szeretn�l adom�nyozni?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "janu�r");
define("L_FEB", "febru�r");
define("L_MAR", "m�rcius");
define("L_APR", "�prilis");
define("L_MAY", "m�jus");
define("L_JUN", "j�nius");
define("L_JUL", "j�lius");
define("L_AUG", "augusztus");
define("L_SEP", "szeptember");
define("L_OCT", "okt�ber");
define("L_NOV", "november");
define("L_DEC", "december");
// Months Short Names
define("L_S_JAN", "jan.");
define("L_S_FEB", "febr.");
define("L_S_MAR", "m�rc.");
define("L_S_APR", "�pr.");
define("L_S_MAY", "m�j.");
define("L_S_JUN", "j�n.");
define("L_S_JUL", "j�l.");
define("L_S_AUG", "aug.");
define("L_S_SEP", "szept.");
define("L_S_OCT", "okt.");
define("L_S_NOV", "nov.");
define("L_S_DEC", "dec.");
// Week days Long Names
define("L_MON", "h�tfo");
define("L_TUE", "kedd");
define("L_WED", "szerda");
define("L_THU", "cs�t�rt�k");
define("L_FRI", "p�ntek");
define("L_SAT", "szombat");
define("L_SUN", "vas�rnap");
// Week days Short Names
define("L_S_MON", "H");
define("L_S_TUE", "K");
define("L_S_WED", "Sze");
define("L_S_THU", "Cs");
define("L_S_FRI", "P");
define("L_S_SAT", "Szo");
define("L_S_SUN", "V");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%Y. %B %d.");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "hu_HU");

// Set the HU specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "hun_hun.ISO-8859-1", "hungarian.ISO-8859-1", "hungarian");
} else {
setlocale(LC_ALL, "hu_HU.ISO-8859-1", "hu_HU.ISO-8859-1@euro", "hun_hun.ISO-8859-1", "hungarian.ISO-8859-1", "hun.ISO-8859-1", "hu.ISO-8859-1"); // For HU formats
}
?>