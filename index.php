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
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>FruityWifi</title>
<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../css/jquery-ui.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="../../../style.css" />

<script>
$(function() {
    $( "#action" ).tabs();
    $( "#result" ).tabs();
});
</script>

</head>
<body>

<? include "../menu.php"; ?>

<br>

<?

include "_info_.php";
include "../../config/config.php";
include "../../login_check.php";
include "../../functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_POST["newdata"], "msg.php", $regex_extra);
    regex_standard($_GET["logfile"], "msg.php", $regex_extra);
    regex_standard($_GET["action"], "msg.php", $regex_extra);
    regex_standard($_POST["service"], "msg.php", $regex_extra);
}

$newdata = $_POST['newdata'];
$logfile = $_GET["logfile"];
$action = $_GET["action"];
$tempname = $_GET["tempname"];
$service = $_POST["service"];


// DELETE LOG
if ($logfile != "" and $action == "delete") {
    $exec = "rm ".$mod_logs_history.$logfile.".log";
    exec("$bin_danger \"$exec\"", $dump);
}

?>

<div class="rounded-top" align="left"> &nbsp; <b><?=$mod_alias?></b> </div>
<div class="rounded-bottom">

    &nbsp;&nbsp;version <?=$mod_version?><br>
    <?
    $exec = "$mod_isup";
    $ismoduleup = exec("$bin_danger \"$exec\"" );
    //$ismoduleup = exec("ps auxww | grep ngrep | grep -v -e 'grep ngrep'");
    if ($ismoduleup != "") {
        echo "&nbsp;$mod_alias  <font color='lime'><b>enabled</b></font>.&nbsp; | <a href='includes/module_action.php?service=$mod_name&action=stop&page=module'><b>stop</b></a>";
    } else { 
        echo "&nbsp;$mod_alias  <font color='red'><b>disabled</b></font>. | <a href='includes/module_action.php?service=$mod_name&action=start&page=module'><b>start</b></a>"; 
    }
    ?>
    
</div>

<br>


<div id="msg" style="font-size:largest;">
Loading, please wait...
</div>

<div id="body" style="display:none;">


    <div id="result" class="module">
        <ul>
            <li><a href="#result-1">Output</a></li>
            <li><a href="#result-2">Users</a></li>
            <li><a href="#result-3">History</a></li>
        </ul>
        <div id="result-1">
            <form id="formLogs-Refresh" name="formLogs-Refresh" method="POST" autocomplete="off" action="index.php">
            <input type="submit" value="refresh">
            <br><br>
            <?
                if ($logfile != "" and $action == "view") {
                    $filename = $mod_logs_history.$logfile.".log";
                } else {
                    $filename = $mod_logs;
                }
            
                $data = open_file($filename);
                
                // REVERSE
                //$data_array = explode("\n", $data);
                //$data = implode("\n",array_reverse($data_array));
                
            ?>
            <textarea id="output" class="module-content" style="font-family: courier;"><?=htmlspecialchars($data)?></textarea>
            <input type="hidden" name="type" value="logs">
            </form>
            
        </div>
        
        <!-- USERS -->
        
        <div id="result-2" class="module-options">
            <form action="index.php" method="GET">
                <input type="hidden" name="tab" value="1">
                <input type="submit" value="refresh">
            </form>
            <br>
            <div class="module-options" s-tyle="background-color:#000; border:1px dashed; padding:5px">
            <?
            
            $filename = $file_users;
            
            $exec = "$bin_cat $filename";
            exec("$bin_danger \"$exec\"", $output);
            ?>
            
            <table border='0'>
            <tr>
                <td></td>
                <td style="padding-right:10px"><b>Date</b></td>
                <td style="padding-right:10px"><b>IP</b></td>
                <td style="padding-right:10px"><b>User</b></td>
                <td style="padding-right:10px"><b>Pass</b></td>
            </tr>
            <? 
            for ($i=0; $i < count($output); $i++) { 
                $row = explode("--", $output[$i]);
                if ($row[1] != "") {
            ?>
                <tr>
                    <td style="padding-right:5px"><a href="includes/module_action.php?service=users&action=delete&id_data=<?=$row[0]?>" style="color:#000">Delete</a></td>
                    <td style="background-color:#DDD; padding-right:10px"><?=$row[0];?></td>
                    <td style="background-color:#DDD; padding-right:10px"><?=$row[1];?></td>
                    <td style="background-color:#DDD; padding-right:10px"><?=$row[2];?></td>
                    <td style="background-color:#DDD; padding-right:10px"><?=$row[3];?></td>
                </tr>
            <?  } 
            } 
            ?>
            </table>
            </div>
            
            <br>
            
        </div>

        <!-- HISTORY -->

        <div id="result-3" class="history">
            <input type="submit" value="refresh">
            <br><br>
            
            <?
            $logs = glob($mod_logs_history.'*.log');
            print_r($a);

            for ($i = 0; $i < count($logs); $i++) {
                $filename = str_replace(".log","",str_replace($mod_logs_history,"",$logs[$i]));
                echo "<a href='?logfile=".str_replace(".log","",str_replace($mod_logs_history,"",$logs[$i]))."&action=delete&tab=3'><b>x</b></a> ";
                echo $filename . " | ";
                echo "<a href='?logfile=".str_replace(".log","",str_replace($mod_logs_history,"",$logs[$i]))."&action=view'><b>view</b></a>";
                echo "<br>";
            }
            ?>
            
        </div>
        
    </div>

    <div id="loading" class="ui-widget" style="width:100%;background-color:#000; padding-top:4px; padding-bottom:4px;color:#FFF">
        Loading...
    </div>

    <script>
    $('#loading').hide();
    </script>

    <?
    if ($_GET["tab"] == 1) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 1 });";
        echo "</script>";
    } else if ($_GET["tab"] == 2) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 2 });";
        echo "</script>";
    } else if ($_GET["tab"] == 3) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 3 });";
        echo "</script>";
    } else if ($_GET["tab"] == 4) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 4 });";
        echo "</script>";
    } 
    ?>

</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#body').show();
    $('#msg').hide();
});
</script>

</body>
</html>
