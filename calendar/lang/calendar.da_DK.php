<?php 
# da_DK translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Danish / dansk
# Translator: Bente Feldballe
# Last file update: 28.07.2013

// Class strings localization
define("L_DAYC", "Dato");
define("L_MONTHC", "M�ned");
define("L_YEARC", "�r");
define("L_TODAY", "I dag");
define("L_PREV", "Forrige");
define("L_NEXT", "N�ste");
define("L_REF_CAL", "Opdat�r kalender...");
define("L_CHK_VAL", "Tjek v�rdi");
define("L_SEL_LANG", "V�lg sprog");
define("L_SEL_ICON", "V�lg");
define("L_SEL_DATE", "V�lg dato");
define("L_ERR_SEL", "Ugyldigt valg");
define("L_NOT_ALLOWED", "Du kan ikke v�lge denne dato");
define("L_DATE_BEFORE", "V�lg en dato f�r %s");
define("L_DATE_AFTER", "V�lg en dato, efter %s");
define("L_DATE_BETWEEN", "V�lg en dato mellem\\n%s og %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Frakoblet"); //Annuller
define("L_CLOSE", "Luk");
define("L_WARN_2038", "Denne version php-server underst�tter ikke �ret 2038 og senere! (<5.3.0)");
define("L_ERR_NOSET", "Fejl! Kalenderv�rdien kan ikke v�lges!");
define("L_VERSION", "Version: %s (%s sprog)");
define("L_POWBY", "Baseret p�:"); //or "Based on:", "Supported by"
define("L_HERE", "her");
define("L_UPDATE", "Opdatering tilg�ngelig %s !");
define("L_TRANAME", "Bente Feldballe");
define("L_TRABY", "Oversat af %s");
define("L_DONATE", "Vil du give et bidrag?");

// Set the first day of the week in your language
define("FIRST_DAY", "1"); // 1 for Monday, 0 for Sunday

// Months Long Names
define("L_JAN", "januar");
define("L_FEB", "februar");
define("L_MAR", "marts");
define("L_APR", "april");
define("L_MAY", "maj");
define("L_JUN", "juni");
define("L_JUL", "juli");
define("L_AUG", "august");
define("L_SEP", "september");
define("L_OCT", "oktober");
define("L_NOV", "november");
define("L_DEC", "december");
// Months Short Names
define("L_S_JAN", "jan.");
define("L_S_FEB", "feb.");
define("L_S_MAR", "mrs.");
define("L_S_APR", "apr.");
define("L_S_MAY", "maj");
define("L_S_JUN", "juni");
define("L_S_JUL", "juli");
define("L_S_AUG", "aug.");
define("L_S_SEP", "sept.");
define("L_S_OCT", "okt.");
define("L_S_NOV", "nov.");
define("L_S_DEC", "dec.");
// Week days Long Names
define("L_MON", "mandag");
define("L_TUE", "tirsdag");
define("L_WED", "onsdag");
define("L_THU", "torsdag");
define("L_FRI", "fredag");
define("L_SAT", "l�rdag");
define("L_SUN", "s�ndag");
// Week days Short Names
define("L_S_MON", "ma");
define("L_S_TUE", "ti");
define("L_S_WED", "on");
define("L_S_THU", "to");
define("L_S_FRI", "fr");
define("L_S_SAT", "l�");
define("L_S_SUN", "s�");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d. %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "da_DK");

// Set the DK specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "danish.ISO-8859-1", "danish"); // For DK formats
} else {
setlocale(LC_ALL, "da_DK.ISO-8859-1", "da_DK.ISO-8859-1@euro", "dnk.ISO-8859-1", "dnk.ISO-8859-1"); // For DK formats
}
?>