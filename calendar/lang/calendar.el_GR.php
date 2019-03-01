<?php 
# el_GR translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Greek / e??????? (in your lang)
# Translator: Kostas Filios
# Last file update: 30.07.2013

// Class strings localization
define("L_DAYC", "?�??a");
define("L_MONTHC", "???a?");
define("L_YEARC", "??????");
define("L_TODAY", "S?�e?a");
define("L_PREV", "???????�e??");
define("L_NEXT", "?p?�e??");
define("L_REF_CAL", "?pa?af??t?s? ?�e????????...");
define("L_CHK_VAL", "??e??e t?? t?�?");
define("L_SEL_LANG", "?p??e?e ???ssa");
define("L_SEL_ICON", "?p??e?e");
define("L_SEL_DATE", "?p??e?e ?�??a");
define("L_ERR_SEL", "????? ep?????");
define("L_NOT_ALLOWED", "?e? ep?t??pete ? ep????? a?t?? t?? ?�??a?");
define("L_DATE_BEFORE", "?p????te �?a ?�e??�???a p??? ap? t?? %s");
define("L_DATE_AFTER", "?p????te �?a ?�e??�???a �et? t?? %s");
define("L_DATE_BETWEEN", "?p????te �?a ?�e??�???a �eta??\\n%s ?a? %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "?p?ep?????");
define("L_CLOSE", "??e?s?�?");
define("L_WARN_2038", "? ??d?s? php t?? server de? ?p?st????e? t?? ?????? 2038 ? �e?a??te?? (<5.3.0)");
define("L_ERR_NOSET", "?a???s??st??e p??�??�a! t? ?�e??????? de? �p??e? ?a ???�?ste?");
define("L_VERSION", "??d?s?: %s (%s ???sse?)");
define("L_POWBY", "?as?s�??? sePowered by:"); //or "Based on:", "Supported by"
define("L_HERE", "ed?");
define("L_UPDATE", "a?a�??�?s? d?a??s?�? %s !"); 
define("L_TRANAME", "Exoskeletor");
define("L_TRABY", "?etaf??st??e ap?t??<br />%s");
define("L_DONATE", "??p?? ep???�e?te ?a<br />d???sete ???�ata?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
# Menu - nominative
define("L_JAN", "?a????????");
define("L_FEB", "Fe�????????");
define("L_MAR", "???t???");
define("L_APR", "?p??????");
define("L_MAY", "?????");
define("L_JUN", "???????");
define("L_JUL", "???????");
define("L_AUG", "?????st??");
define("L_SEP", "Sept?��????");
define("L_OCT", "??t?�????");
define("L_NOV", "???��????");
define("L_DEC", "?e??��????");
# Dates - genitive
define("L_JANG", "?a???a????");
define("L_FEBG", "Fe�???a????");
define("L_MARG", "?a?t???");
define("L_APRG", "?p??????");
define("L_MAYG", "?a???");
define("L_JUNG", "???????");
define("L_JULG", "???????");
define("L_AUGG", "?????st??");
define("L_SEPG", "Septe��????");
define("L_OCTG", "??t?�????");
define("L_NOVG", "??e��????");
define("L_DECG", "?e?e��????");
// Months Short Names
define("L_S_JAN", "?a?");
define("L_S_FEB", "Fe�");
define("L_S_MAR", "?a?");
define("L_S_APR", "?p?");
define("L_S_MAY", "???");
define("L_S_JUN", "????");
define("L_S_JUL", "????");
define("L_S_AUG", "???");
define("L_S_SEP", "Sep");
define("L_S_OCT", "??t");
define("L_S_NOV", "??e");
define("L_S_DEC", "?e?");
// Week days Long Names
define("L_MON", "?e?t??a");
define("L_TUE", "???t?");
define("L_WED", "?et??t?");
define("L_THU", "??�pt?");
define("L_FRI", "?a?as?e??");
define("L_SAT", "Sa��?t?");
define("L_SUN", "????a??");
// Week days Short Names
define("L_S_MON", "?e?");
define("L_S_TUE", "???");
define("L_S_WED", "?et");
define("L_S_THU", "?e�");
define("L_S_FRI", "?a?");
define("L_S_SAT", "Sa�");
define("L_S_SUN", "???");

// Windows encoding
define("WIN_DEFAULT", "windows-1253");
define("L_CAL_FORMAT", "%d? %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "el_GR"); // en_US format of your language

// Set the EL specific date/time format;
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "ell-ath.ISO-8859-1", "ell-ath", "Greek-athens.ISO-8859-1", "Greek.ISO-8859-1", "Greek");
} else {
setlocale(LC_ALL, "el_GR.ISO-8859-1", "ell.ISO-8859-1", "athens.ISO-8859-1", "ell_ell.ISO-8859-1", "Greek-ath.ISO-8859-1");
}
?>