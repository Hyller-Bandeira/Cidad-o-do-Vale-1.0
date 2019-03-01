<?php 
# fr_FR translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: French / fran�ais
# Translator: Pierre Liget <sourceforge@pliget.freesurf.fr>
# Last file update: 30.07.2013

// Class strings localization
define("L_DAYC", "Jour");
define("L_MONTHC", "Mois");
define("L_YEARC", "Ann�e");
define("L_TODAY", "Aujourd�hui");
define("L_PREV", "Pr�c�dent");
define("L_NEXT", "Suivant");
define("L_REF_CAL", "Actualisation du calendrier en cours ...");
define("L_CHK_VAL", "V�rifiez la valeur");
define("L_SEL_LANG", "S�lection de la langue");
define("L_SEL_ICON", "S�lectionner");
define("L_SEL_DATE", "S�lection de la date");
define("L_ERR_SEL", "La s�lection n�est pas valide");
define("L_NOT_ALLOWED", "Cette date ne peut pas �tre s�lectionn�e");
define("L_DATE_BEFORE", "Veuillez s�lectionner une date\\nant�rieure au %s");
define("L_DATE_AFTER", "Veuillez s�lectionner une date\\npost�rieure au %s");
define("L_DATE_BETWEEN", "Veuillez s�lectionner une date entre le\\n%s et le %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Annuler"); //Remise � z�ro
define("L_CLOSE", "Fermer");
define("L_WARN_2038", "Cette version de PHP ne supporte pas les ann�es 2038 et au del�! (<5.3.0)");
define("L_ERR_NOSET", "Erreur! La valeur du calendrier ne peut pas �tre fix�e!");
define("L_VERSION", "Version: %s (%s langues)");
define("L_POWBY", "Bas� sur:"); //or "Based on:", "Supported by"
define("L_HERE", "ici");
define("L_UPDATE", "Mise � jour disponible %s !");
define("L_TRANAME", "Pierre Liget");
define("L_TRABY", "Traduit par %s");
define("L_DONATE", "Souhaitez vous faire un don?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "janvier");
define("L_FEB", "f�vrier");
define("L_MAR", "mars");
define("L_APR", "avril");
define("L_MAY", "mai");
define("L_JUN", "juin");
define("L_JUL", "juillet");
define("L_AUG", "ao�t");
define("L_SEP", "septembre");
define("L_OCT", "octobre");
define("L_NOV", "novembre");
define("L_DEC", "d�cembre");
// Months Short Names
define("L_S_JAN", "janv.");
define("L_S_FEB", "f�vr.");
define("L_S_MAR", "mars");
define("L_S_APR", "avr.");
define("L_S_MAY", "mai");
define("L_S_JUN", "juin");
define("L_S_JUL", "juil.");
define("L_S_AUG", "ao�t");
define("L_S_SEP", "sept.");
define("L_S_OCT", "oct.");
define("L_S_NOV", "nov.");
define("L_S_DEC", "d�c.");
// Week days Long Names
define("L_MON", "lundi");
define("L_TUE", "mardi");
define("L_WED", "mercredi");
define("L_THU", "jeudi");
define("L_FRI", "vendredi");
define("L_SAT", "samedi");
define("L_SUN", "dimanche");
// Week days Short Names
define("L_S_MON", "lun.");
define("L_S_TUE", "mar.");
define("L_S_WED", "mer.");
define("L_S_THU", "jeu.");
define("L_S_FRI", "ven.");
define("L_S_SAT", "sam.");
define("L_S_SUN", "dim.");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "fr_FR");

// Set the FR specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_ALL, "fra_fra.ISO-8859-1", "french.ISO-8859-1", "french");
} else {
setlocale(LC_ALL, "fr_FR.ISO-8859-1", "fr.ISO-8859-1", "fr_FR.ISO-8859-1@euro"); // For French formats
}
?>