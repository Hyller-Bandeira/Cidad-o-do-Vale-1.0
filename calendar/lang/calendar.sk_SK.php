<?php 
# sk_SK translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.69
# Language: Slovak / slovencina
# Translator: trolo_vk <admin@ompnet.sk>
# Last file update: 19.05.2013

// Class strings localization
define("L_DAYC", "Den");
define("L_MONTHC", "Mesiac");
define("L_YEARC", "Rok");
define("L_TODAY", "Dnes");
define("L_PREV", "Predch�dzaj�ci"); 
define("L_NEXT", "Nasleduj�ci");
define("L_REF_CAL", "Obnovit Kalend�r...");
define("L_CHK_VAL", "Skontroluj hodnotu");
define("L_SEL_LANG", "Vyber jazyk");
define("L_SEL_ICON", "Vyber");
define("L_SEL_DATE", "Vyber d�tum");
define("L_ERR_SEL", "Nespr�vn� volba");
define("L_NOT_ALLOWED", "Toto d�tum nie je povolen� pre v�ber");
define("L_DATE_BEFORE", "Vyberte d�tum pred %s");
define("L_DATE_AFTER", "Vyberte d�tum po %s");
define("L_DATE_BETWEEN", "Vyberte d�tum medzi\\n%s a %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Zru�it");
define("L_CLOSE", "Zavriet");
define("L_TRANAME", "Trolo");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
# Menu - nominative
define("L_JAN", "janu�r");
define("L_FEB", "febru�r");
define("L_MAR", "marec");
define("L_APR", "apr�l");
define("L_MAY", "m�j");
define("L_JUN", "j�n");
define("L_JUL", "j�l");
define("L_AUG", "august");
define("L_SEP", "september");
define("L_OCT", "okt�ber");
define("L_NOV", "november");
define("L_DEC", "december");
# Dates - genitive
define("L_JANG", "janu�ra");
define("L_FEBG", "febru�ra");
define("L_MARG", "mareca");
define("L_APRG", "apr�la");
define("L_MAYG", "m�ja");
define("L_JUNG", "j�na");
define("L_JULG", "j�la");
define("L_AUGG", "augusta");
define("L_SEPG", "septembera");
define("L_OCTG", "okt�bera");
define("L_NOVG", "novembera");
define("L_DECG", "decembera");
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
define("L_MON", "pondelok");
define("L_TUE", "utorok");
define("L_WED", "streda");
define("L_THU", "�tvrtok");
define("L_FRI", "piatok");
define("L_SAT", "sobota");
define("L_SUN", "nedela");
// Week days Short Names
define("L_S_MON", "po");
define("L_S_TUE", "ut");
define("L_S_WED", "st");
define("L_S_THU", "�t");
define("L_S_FRI", "pi");
define("L_S_SAT", "so");
define("L_S_SUN", "ne");

// Windows encoding
define("WIN_DEFAULT", "windows-1250");
define("L_CAL_FORMAT", "%d. %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "sk_SK"); // en_US format of your language

// Set the SK specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "sk-SK.ISO-8859-1", "sk-svk.ISO-8859-1", "sk-svk", "Slovak.ISO-8859-1", "Slovak");
} else {
setlocale(LC_ALL, "sk_SK.ISO-8859-1", "sk.ISO-8859-1", "svk.ISO-8859-1", "sk_svk.ISO-8859-1", "Slovak.ISO-8859-1");
}
?>