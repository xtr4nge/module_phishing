<? 
/*
    Copyright (C) 2013-2014 xtr4nge [_AT_] gmail.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<?
//include "../login_check.php";
include "../../../config/config.php";
include "../_info_.php";
include "../../../functions.php";

include "options_config.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($_GET["page"], "../msg.php", $regex_extra);
    regex_standard($io_action, "../msg.php", $regex_extra);
    regex_standard($_GET["id_data"], "../msg.php", $regex_extra);
    regex_standard($_GET["install"], "../msg.php", $regex_extra);
}

$service = $_GET['service'];
$action = $_GET['action'];
$page = $_GET['page'];
$id_data =  strtoupper($_GET['id_data']);
$install = $_GET['install'];

if($service == $mod_name) {
    
    if ($action == "start") {
        
	// START MODULE
        
        // COPY LOG
        if ( 0 < filesize( $mod_logs ) ) {
            $exec = "cp $mod_logs $mod_logs_history/".gmdate("Ymd-H-i-s").".log";
            //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
            exec_fruitywifi($exec);
            
            $exec = "echo '' > $mod_logs";
            //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
            exec_fruitywifi($exec);
        }
	
        $exec = "ln -s $mod_path/includes/www.site /var/www/site";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
	
        $exec = "$bin_sed -i 1i'<? include \\\"site\/index.php\\\"; \/\* FruityWifi-Phishing \*\/ ?>' /var/www/index.php";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
    } else if($action == "stop") {
	
	// STOP MODULE
	
        $exec = "$bin_sed -i '/FruityWifi-Phishing/d' /var/www/index.php";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
        $exec = "rm /var/www/site";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
	
	// COPY LOG
        if ( 0 < filesize( $mod_logs ) ) {
            $exec = "cp $mod_logs $mod_logs_history/".gmdate("Ymd-H-i-s").".log";
            //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
            exec_fruitywifi($exec);
            
            $exec = "echo '' > $mod_logs";
            //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
            exec_fruitywifi($exec);
        }
	
    }

}

/*
if($service == "install_portal") {
    $exec = "/bin/ln -s /usr/share/fruitywifi/www/modules/captive/www.captive /var/www/site/captive";
    //exec("$bin_danger \"$exec\""); //DEPRECATED
    exec_fruitywifi($exec);
}
*/

$filename = $file_users;

if ($service == "users" and $id_data != "") {
	$id_data = trim($id_data,'*');
    
	if ($action == "delete") {
        
        $exec = "$bin_sed -i '/$id_data/d' $filename";
        //exec("$bin_danger \"$exec\"", $output); //DEPRECATED
        $output = exec_fruitywifi($exec);
	
        //$exec = "$bin_iptables -D internet -t mangle -m mac --mac-source $mac -j RETURN";
        //exec("$bin_danger \"$exec\"");
        
        // ADD TO LOGS
        $exec = "$bin_echo 'DELETE: $date|".date("Y-m-d h:i:s")."' >> $mod_logs ";
        //exec("$bin_danger \"$exec\""); //DEPRECATED
        exec_fruitywifi($exec);
        
	} 
    
    header('Location: ../index.php?tab=1');
    exit;
}

if ($install == "install_$mod_name") {

    $exec = "$bin_chmod 755 install.sh";
    //exec("$bin_danger \"$exec\"" ); //DEPRECATED
    exec_fruitywifi($exec);

    $exec = "$bin_sudo ./install.sh > $log_path/install.txt &";
    //exec("$bin_danger \"$exec\"" ); //DEPRECATED
    exec_fruitywifi($exec);
    
    header('Location: ../../install.php?module='.$mod_name);
    exit;
}

if ($page == "status") {
    header('Location: ../../../action.php');
} else {
    header('Location: ../../action.php?page='.$mod_name);
}

//header('Location: ../index.php?tab=0');

?>