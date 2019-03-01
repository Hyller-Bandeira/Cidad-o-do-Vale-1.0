<?php 
# en_GB - this file includes only the format settings;
# the specific strings are already included as default en_GB/en_US in localization.lib.php
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 2.30
# Language: British / English UK
# Translator: Ciprian Murariu <ciprianmp@yahoo.com>
# Last file update: 01.05.2010

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "en_GB");

// Set the UK specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "eng-eng.ISO-8859-1", "eng-eng");
} else {
setlocale(LC_ALL, "en_GB.ISO-8859-1", "en_GB.ISO-8859-1@euro", "eng.ISO-8859-1", "uk.ISO-8859-1", "eng_eng.ISO-8859-1", "English-uk.ISO-8859-1"); // For UK formats
}
?>