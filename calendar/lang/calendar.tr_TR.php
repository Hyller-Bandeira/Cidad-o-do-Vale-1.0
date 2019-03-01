<?php 
# tr_TR translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.69
# Language: Turkish / T�rk�e
# Translator: Volkan �v�n <vovun@hotmail.com>
# Last file update: 28.05.2013

// Class strings localization
define("L_DAYC", "G�n");
define("L_MONTHC", "Ay");
define("L_YEARC", "Yil");
define("L_TODAY", "Bu g�n");
define("L_PREV", "�nceki");
define("L_NEXT", "Sonraki");
define("L_REF_CAL", "Takvimi Yenile...");
define("L_CHK_VAL", "Se�ilmis tarihi kontrol et");
define("L_SEL_LANG", "Dil Se�imi");
define("L_SEL_ICON", "Se�");
define("L_SEL_DATE", "Tarih Se�imi");
define("L_ERR_SEL", "Ge�ersiz bir se�im yeptiniz");
define("L_NOT_ALLOWED", "Bu tarihin se�ilmesine izin verilmiyor");
define("L_DATE_BEFORE", "%s �ncesi bir tarih se�in");
define("L_DATE_AFTER", "%s sonra bir tarih se�in");
define("L_DATE_BETWEEN", "%s ve %s\\narasindaki bir tarih se�in");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Iptal"); // Se�imi kaldir
define("L_CLOSE", "Kapat");
define("L_WARN_2038", "Bu php sunucusu s�r�m� 2038 yili ve sonrasini desteklemiyor! (<5.3.0)");
define("L_TRANAME", "Volkan �v�n");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday... 6 for Saturday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "Ocak");
define("L_FEB", "Subat");
define("L_MAR", "Mart");
define("L_APR", "Nisan");
define("L_MAY", "Mayis");
define("L_JUN", "Haziran");
define("L_JUL", "Temmuz");
define("L_AUG", "Agustos");
define("L_SEP", "Eyl�l");
define("L_OCT", "Ekim");
define("L_NOV", "Kasim");
define("L_DEC", "Aralik");
// Months Short Names
define("L_S_JAN", "Oca");
define("L_S_FEB", "Sub");
define("L_S_MAR", "Mar");
define("L_S_APR", "Nis");
define("L_S_MAY", "May");
define("L_S_JUN", "Haz");
define("L_S_JUL", "Tem");
define("L_S_AUG", "Agu");
define("L_S_SEP", "Eyl");
define("L_S_OCT", "Eki");
define("L_S_NOV", "Kas");
define("L_S_DEC", "Ara");
// Week days Long Names
define("L_MON", "Pazartesi");
define("L_TUE", "Sali");
define("L_WED", "�arsamba");
define("L_THU", "Persembe");
define("L_FRI", "Cuma");
define("L_SAT", "Cumartesi");
define("L_SUN", "Pazar");
// Week days Short Names
define("L_S_MON", "Pzt");
define("L_S_TUE", "Sali");
define("L_S_WED", "�ar");
define("L_S_THU", "Per");
define("L_S_FRI", "Cum");
define("L_S_SAT", "Cmt");
define("L_S_SUN", "Paz");

// Windows encoding
define("WIN_DEFAULT", "windows-1254");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "tr_TR");

// Set the TR specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "turkish.ISO-8859-1", "turkish");
} else {
#setlocale(LC_ALL, "tr_TR.ISO-8859-1", "tr_TR", "tr-TR", "turkish.ISO-8859-1");
}
?>