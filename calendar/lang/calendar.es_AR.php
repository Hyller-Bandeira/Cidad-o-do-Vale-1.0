<?php 
# es_AR translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Argentinian Spanish / espa�ol Argentina
# Translator: Mat�as Olivera <matiolivera@yahoo.com>
# Last file update: 23.07.2013

// Class strings localization
define("L_DAYC", "D�a");
define("L_MONTHC", "Mes");
define("L_YEARC", "A�o");
define("L_TODAY", "Hoy");
define("L_PREV", "Anterior");
define("L_NEXT", "Pr�ximo");
define("L_REF_CAL", "Actualizando Calendario...");
define("L_CHK_VAL", "Verifica el valor");
define("L_SEL_LANG", "Selecciona lenguage");
define("L_SEL_ICON", "Selecciona");
define("L_SEL_DATE", "Selecciona d�a");
define("L_ERR_SEL", "Tu selecci�n no es v�lida");
define("L_NOT_ALLOWED", "Este d�a no puede ser seleccionado");
define("L_DATE_BEFORE", "Elija una fecha anterior a %s");
define("L_DATE_AFTER", "Elija una fecha posterior al %s");
define("L_DATE_BETWEEN", "Elija una fecha entre el\\n%s y el %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Cancelar");
define("L_CLOSE", "Cerrar");
define("L_WARN_2038", "La versi�n de este servidor php no tiene soporte para el a�o 2038 o posterior! (<5.3.0)");
define("L_ERR_NOSET", "Error! No se puede definir este valor de calendario!");
define("L_VERSION", "Versi�n: %s (%s lenguajes)");
define("L_POWBY", "Desarrollado por:"); //or "Based on:", "Supported by"
define("L_HERE", "aqu�");
define("L_UPDATE", "Actualizaci�n disponible %s !");
define("L_TRANAME", "Mat�as Olivera");
define("L_TRABY", "Traducido por %s");

// Set the first day of the week in your language
define("FIRST_DAY", "0"); // 1 for Monday, 0 for Sunday

// Months Long Names
define("L_JAN", "enero");
define("L_FEB", "febrero");
define("L_MAR", "marzo");
define("L_APR", "abril");
define("L_MAY", "mayo");
define("L_JUN", "junio");
define("L_JUL", "julio");
define("L_AUG", "agosto");
define("L_SEP", "septiembre");
define("L_OCT", "octubre");
define("L_NOV", "noviembre");
define("L_DEC", "diciembre");
// Months Short Names
define("L_S_JAN", "ene");
define("L_S_FEB", "feb");
define("L_S_MAR", "mar");
define("L_S_APR", "abr");
define("L_S_MAY", "may");
define("L_S_JUN", "jun");
define("L_S_JUL", "jul");
define("L_S_AUG", "ago");
define("L_S_SEP", "sep");
define("L_S_OCT", "oct");
define("L_S_NOV", "nov");
define("L_S_DEC", "dic");
// Week days Long Names
define("L_MON", "lunes");
define("L_TUE", "martes");
define("L_WED", "mi�rcoles");
define("L_THU", "jueves");
define("L_FRI", "viernes");
define("L_SAT", "s�bado");
define("L_SUN", "domingo");
// Week days Short Names
define("L_S_MON", "lu");
define("L_S_TUE", "ma");
define("L_S_WED", "mi");
define("L_S_THU", "ju");
define("L_S_FRI", "vi");
define("L_S_SAT", "s�");
define("L_S_SUN", "do");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "es_AR");

// Set the AR specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "ESP_ARG.ISO-8859-1", "ESP_ARG");
} else {
setlocale(LC_ALL, "es_AR.ISO-8859-1", "esp_arg.ISO-8859-1");
}
?>