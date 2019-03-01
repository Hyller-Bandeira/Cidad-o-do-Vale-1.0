<?php 
# cs_CZ translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.69
# Language: Czech / ce�tina
# Translator: Chenzee <chenzee@email.cz>
# Last file update: 19.05.2013

// Class strings localization
define("L_DAYC", "Den");
define("L_MONTHC", "Mes�c");
define("L_YEARC", "Rok");
define("L_TODAY", "Dnes");
define("L_PREV", "Predchoz�"); 
define("L_NEXT", "N�sleduj�c�");
define("L_REF_CAL", "Obnovit Kalend�r...");
define("L_CHK_VAL", "Zkontroluj hodnotu");
define("L_SEL_LANG", "Vyber jazyk");
define("L_SEL_ICON", "Vyber");
define("L_SEL_DATE", "Vyber datum");
define("L_ERR_SEL", "Nespr�vn� volba");
define("L_NOT_ALLOWED", "Toto datum nen� povolen� pro v�ber");
define("L_DATE_BEFORE", "Vyberte datum pred %s");
define("L_DATE_AFTER", "Vyberte datum po %s");
define("L_DATE_BETWEEN", "Vyberte datum mezi\\n%s a %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Zru�it");
define("L_CLOSE", "Zavr�t");
define("L_TRANAME", "Chenzee");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
# Menu - nominative
define("L_JAN", "leden");
define("L_FEB", "�nor");
define("L_MAR", "brezen");
define("L_APR", "duben");
define("L_MAY", "kveten");
define("L_JUN", "cerven");
define("L_JUL", "cervenec");
define("L_AUG", "srpen");
define("L_SEP", "z�r�");
define("L_OCT", "r�jen");
define("L_NOV", "listopad");
define("L_DEC", "prosinec");
# Dates - genitive
define("L_JANG", "ledna");
define("L_FEBG", "�nora");
define("L_MARG", "brezna");
define("L_APRG", "dubna");
define("L_MAYG", "kvetna");
define("L_JUNG", "cervna");
define("L_JULG", "cervence");
define("L_AUGG", "srpna");
define("L_SEPG", "z�r�");
define("L_OCTG", "r�jna");
define("L_NOVG", "listopadu");
define("L_DECG", "prosince");
// Months Short Names
define("L_S_JAN", "01");
define("L_S_FEB", "02");
define("L_S_MAR", "03");
define("L_S_APR", "04");
define("L_S_MAY", "05");
define("L_S_JUN", "06");
define("L_S_JUL", "07");
define("L_S_AUG", "08");
define("L_S_SEP", "09");
define("L_S_OCT", "10");
define("L_S_NOV", "11");
define("L_S_DEC", "12");
// Week days Long Names
define("L_MON", "pondel�");
define("L_TUE", "�ter�");
define("L_WED", "streda");
define("L_THU", "ctvrtek");
define("L_FRI", "p�tek");
define("L_SAT", "sobota");
define("L_SUN", "nedele");
// Week days Short Names
define("L_S_MON", "po");
define("L_S_TUE", "�t");
define("L_S_WED", "st");
define("L_S_THU", "ct");
define("L_S_FRI", "p�");
define("L_S_SAT", "so");
define("L_S_SUN", "ne");

// Windows encoding
define("WIN_DEFAULT", "windows-1250");
define("L_CAL_FORMAT", "%d. %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "cs_CZ"); // en_US format of your language

// Set the CS specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "cs-CZ.ISO-8859-1", "ces-cze.ISO-8859-1", "ces-cze", "Czech.ISO-8859-1", "Czech");
} else {
setlocale(LC_ALL, "cs_CZ.ISO-8859-1", "ces.ISO-8859-1", "cze.ISO-8859-1", "ces_cze.ISO-8859-1", "Czech.ISO-8859-1");
}
?>