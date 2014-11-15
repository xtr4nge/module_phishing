<?
$mod_name="phishing";
$mod_version="1.0";
$mod_logs="/usr/share/FruityWifi/logs/$mod_name.log"; 
$mod_logs_history="/usr/share/FruityWifi/www/modules/$mod_name/includes/logs/";
$mod_path="/usr/share/FruityWifi/www/modules/$mod_name";
$mod_panel="show";
$mod_isup="grep 'FruityWifi-Phishing' /var/www/index.php";
$mod_alias="Phishing";
# EXEC
$bin_danger = "/usr/share/FruityWifi/bin/danger";
$bin_sudo = "/usr/bin/sudo";
$bin_sed = "/bin/sed";
$bin_iptables = "/sbin/iptables";
$bin_awk = "/usr/bin/awk";
$bin_grep = "/bin/grep";
$bin_sed = "/bin/sed";
$bin_conntrack = "/usr/sbin/conntrack";
$bin_cat = "/bin/cat";
$bin_echo = "/bin/echo";
$bin_ln = "/bin/ln";
# FILE
$file_users = "$mod_path/includes/www.site/data.txt";
?>
