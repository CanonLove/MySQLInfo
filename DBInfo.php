<?php
###############################################
#
# 2023.04.26 DB Information by CanonLove
# https://github.com/CanonLove/MySQLInfo
# 2023.04.26 ver 1.0.0
# 2023.05.17 ver 1.0.3
# 2023.04.26 program that outputs only one DB information
#
###############################################

function _microtime ( ) { return array_sum(explode(' ',microtime())); }    /* Page loading time check */

function getRealClientIp() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if(getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if(getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if(getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'unknown (알수없음)';
    }
    return $ipaddress;
}


/* Page loading time check (START time) */
$time_start=_microtime();

$ip = getRealClientIp();

/* post value START */
$DB1Ip = isset($_POST['DB1Ip']) ? trim($_POST['DB1Ip']) : "";
$DB1Name = isset($_POST['DB1Name']) ? trim($_POST['DB1Name']) : "";
$DB1User = isset($_POST['DB1User']) ? trim($_POST['DB1User']) : "";
$DB1Pwd = isset($_POST['DB1Pwd']) ? trim($_POST['DB1Pwd']) : "";
/* post value END */
?>
<html>
	<meta charset="UTF-8">
	<style type="text/css">
	body, table, tr, td {  font-size:12px;}
	table, tr, td {  font-size:12px; border-collapse: collapse; padding:2px;}
	.tr1 { background-color:#efefef; }
	.textcenter { text-align:center;; }
	.textbold { font-weight:bold; }
	.h27 { height:27px; }
	.td1 { text-align:center; }
	.td2 { text-align:left; padding-left:3px; }
	.redbox { border:1px solid #ff0000; }
	.greybox { border:1px solid #cdcdcd; }
	.width95 { width:95px;}
	.width130 { width:130px;}

	/* top */
	#layer_fixed { height:170px;width:100%; color: #555; font-size:12px; position:fixed; z-index:999; top:0px; left:0px; -webkit-box-shadow: 0 1px 2px 0 #777; box-shadow: 0 1px 2px 0 #777; background-color:#ccc; }

	.button {background-color: #4CAF50; border-radius: 6px; color: #fff; padding: 3px 3px;}
	.cursorpointer { cursor: pointer; }
    </style>

	<script type="text/javascript" >
	var tableVal = "none";
	function tableViewOnOff() {
		if(tableVal=="none") {
			document.getElementById("div_tableview").style.display = "block"
			tableVal = "block";
		} else {
			document.getElementById("div_tableview").style.display = "none"
			tableVal = "none";

		}
	}

	var procedureListVal = "none";
	function procedureListOnOff() {
		if(procedureListVal=="none") {
			document.getElementById("div_procedurelist").style.display = "block"
			procedureListVal = "block";
		} else {
			document.getElementById("div_procedurelist").style.display = "none"
			procedureListVal = "none";
		}
	}

	function dbClear() {
		document.frm.DB1Ip.value = "";
		document.frm.DB1Name.value = "";
		document.frm.DB1User.value = "";
		document.frm.DB1Pwd.value = "";
	}
	</script>
<body>
<h2>DB</h2>

<!-- DB Info Input Form Start  //-->
<div id="layer_fixed">
	<h1 style="margin : -5px 10px 0 10px; float:left">DB Information ver 1.0.0</h1><h4 style="margin : -2px 10px 0 10px;">You're IP : <?=$ip;?></h4><br>
	<form name="frm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<div style="float:left; margin : 0 10px 0 10px;">
		<table style="border:1px;">
		<tr class="tr1 h27">
			<td colspan=2><b>#DB  :: connection info.</b></td>
		</tr>
		<tr>
			<td  class="tr1">DB IP</td><td><input type="text" name="DB1Ip" value="<?php echo $DB1Ip; ?>"></td>
		</tr>
		<tr>
			<td  class="tr1">DB Name</td><td><input type="text" name="DB1Name" value="<?php echo $DB1Name; ?>"></td>
		</tr>
		<tr>
			<td  class="tr1">DB User</td><td><input type="text" name="DB1User" value="<?php echo $DB1User; ?>"></td>
		</tr>
		<tr>
			<td  class="tr1">DB Pwd</td><td><input type="password" name="DB1Pwd" value="<?php echo $DB1Pwd; ?>"></td>
		</tr>
		</table>
	</div>
	<div style="float:left;  margin-right:10px;">
		<br><br>
		<input type="button" value=" :: DB Info Clear  :: " onclick="dbClear()" class="cursorpointer width130">
		<br><br>
		<input type="submit" value=" :: Submit  :: " class="button cursorpointer width130">
	</div>
	<div  style="float:left;  padding-left:20px;">
		* Verified version : <br>
		1) PHP 5.6.33 + MySQL 5.1.39 (MyISAM) => OK<br>
		2) PHP 7.4.33 + MySQL 8.0.22 (InnoDB) => OK<br>

		<br><br>
		* used mysqli connect()
	</div>
	</form>
</div>
<div style="clear:both"></div>
<!-- DB Info Input Form END  //-->

<?php
if( ($DB1Ip == "") || ($DB1Name=="")  || ($DB1User=="") ) {
	echo "<div style='margin-top:170px;'></div><h1>DB Info ......... blank</h1>";


} else {

########################## ELSE START ###############


	####################################################
	#################### TABLE START ###################
	####################################################
	$TableField = array();
	$TableCreate = array();

	$TableDB = array();

	$TableEngine = array();
	$TableComment = array();


	/*  DB Table schema START */
	$conn = mysqli_connect($DB1Ip, $DB1User, $DB1Pwd, $DB1Name);
	//if( ($conn === false) || ($conn == 0) )
	if (!$conn) {

			echo "<div style='padding-top:110px;'><font style='color:#ff0000; font-weight:bold;'>";
			echo "Error: Unable to connect to MySQL. $DB1Ip (Table)" . PHP_EOL;
		    echo "<br>Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    echo "<br>Debugging error: " . mysqli_connect_error() . PHP_EOL;
			echo "</font></div>"; 

	} else {
		
		mysqli_set_charset($conn, 'utf8');	// Delete if 'utf-8' is not used

		########################## DB Connect START ###############

		$sql = "SELECT TABLE_NAME, ENGINE, TABLE_COMMENT FROM information_schema.tables WHERE table_schema = '$DB1Name' AND TABLE_TYPE='BASE TABLE' ORDER BY table_name;";
		$result = mysqli_query($conn, $sql);

		$RowCnt = 0;
		while ($row = mysqli_fetch_row($result)) {
			$TableDB[$RowCnt] = isset($row[0]) ? $row[0] : "";
			$TableEngine[$RowCnt] = isset($row[1]) ? $row[1] : "";
			$TableComment[$RowCnt] = isset($row[2]) ? $row[2] : "";

			$TB1 = $TableDB[$RowCnt];
			// $result2 = mysqli_query($conn,"SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_KEY, COLUMN_DEFAULT, EXTRA, COLUMN_COMMENT FROM information_schema.columns WHERE table_name='$TB1'ORDER BY ORDINAL_POSITION ASC");
			$result2 = mysqli_query($conn,"SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_KEY, COLUMN_DEFAULT, EXTRA, COLUMN_COMMENT FROM information_schema.columns WHERE TABLE_NAME='$TB1' AND TABLE_SCHEMA='$DB1Name' GROUP BY ORDINAL_POSITION ORDER BY ORDINAL_POSITION ASC");

			if (mysqli_num_rows($result2) > 0) {
				$num=0;
				while ($row2 = mysqli_fetch_assoc($result2)) {
					$TableField[$RowCnt][$num] = isset($row2) ? $row2 : "";
					$num++;
				}
			}

			$result3 = mysqli_query($conn,"SHOW CREATE TABLE $TB1");
			$row3 = mysqli_fetch_assoc($result3);
			$TableCreate[$RowCnt] = isset($row3['Create Table']) ? $row3['Create Table'] : "";

			$RowCnt++;
		}

		mysqli_free_result($result);
		mysqli_free_result($result2);
		mysqli_free_result($result3);
		mysqli_close($conn);
		/*  DB Table schema END */

		$CNT1 = sizeof($TableDB);
		####################################################
		#################### TABLE END #####################
		####################################################



		####################################################
		#################### PROCEDURE START ###############
		####################################################
		$ProName1 = array();
		$ProField1 = array();
		$ProDB1 = array();

		$conn = mysqli_connect($DB1Ip, $DB1User, $DB1Pwd, $DB1Name);
		//if( ($conn === false) || ($conn == 0) )
		if (!$conn)
		{
			echo "<div style='padding-top:110px;'><font style='color:#ff0000; font-weight:bold;'>";
			echo "Error: Unable to connect to MySQL. $DB1Ip (Procedure)" . PHP_EOL;
		    echo "<br>Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    echo "<br>Debugging error: " . mysqli_connect_error() . PHP_EOL;
			echo "</font></div>";

		} else {
			
			mysqli_set_charset($conn, 'utf8');	// Delete if 'utf-8' is not used

			/*  DB Procedure START */
			$sql = "SHOW PROCEDURE STATUS WHERE Db = '$DB1Name';";
			$result = mysqli_query($conn, $sql);

			$ProcedureCNT = 0;
			while ($row = mysqli_fetch_row($result)) {

				//array_push($ProDB1, $row['1']);
				$ProDB1[$ProcedureCNT] = isset($row['1']) ? $row['1'] : "";

				$PRO1 =  $row['1'];

				$result2 = mysqli_query($conn, "SHOW CREATE PROCEDURE $PRO1");
				if (mysqli_num_rows($result2) > 0) {
					$row2 = mysqli_fetch_assoc($result2);
					array_push($ProName1, $PRO1);
					array_push($ProField1, $row2['Create Procedure']);
				}

				$ProcedureCNT++;
			}

			mysqli_free_result($result);
			mysqli_close($conn);
		}
		/*  DB Procedure END  */

		$CNT91 = sizeof($ProDB1);
		####################################################
		#################### PROCEDURE END #################
		####################################################
		?>


		<!-- Top Margin : 100px; //-->
		<div style="margin-top:100px;"></div>

		<hr>
		<h2>#### Table Info ###</h2>
		<div style="float:left; margin-right:10px;">

			<table border=1>
			<tr class="tr1">
				<td colspan=5><b> &nbsp;<?php echo  "'".$DB1Name."' Table List"; ?></b></td>
			</tr>
			<tr class="tr1 td1 textbold">
				<td>No</td><td>Table Name</td><td>Engine</td><td>Field Count</td><td>Table Comment</td>
			</tr>
			<?php
			$fieldCnt1 = 0;
			for($i=0; $i<$CNT1; $i++) {
				echo "<tr>";
				echo "<td class='td1'>".($i+1)."</td>";
				echo "<td>";
						echo $TableDB[$i]."<br>";
						$fieldCnt1 += @sizeof($TableField[$i]);
						// if($i < 2 ) {					print_r($TableField[$i]); }
				echo "</td>";
				echo "<td class='td1'>".$TableEngine[$i]."</td>";
				echo "<td class='td1'>".sizeof($TableField[$i])."</td>";
				echo "<td class='td2'>".$TableComment[$i]."</td>";

				echo "</tr>";
			}
			?>
			<tr class="tr1"><td colspan=3>Total Table Count</td><td class='td1'><b><?php echo $CNT1; ?></b></td><td></td></tr>
			<tr class="tr1"><td colspan=3>Total Field Count</td><td class='td1'><b><?php echo $fieldCnt1; ?></b></td><td></td></tr>
			</table>

		</div>
		<div style="clear:both"></div>



		<br><input type="button" value="TABLE List on/Off" onclick="javascript:tableViewOnOff();">

		<div id="div_tableview" style="display:none">
			<!-- TABLE List START -->
			<hr>
			<table  style="border:0px;">
			<tr><td valign="top">

				<h2><?php echo  $DB1Name;?> >> TABLE </h2>
				<?php

				for($i=0; $i<$CNT1; $i++) {

					$Table = $TableDB[$i];
					?>
					<table border=1 width="800px">
					<tr class="tr1">
						<td colspan=8><b><?php echo $DB1Name.".".$Table; ?></b></td>
					</tr>
					<tr class="tr1">
						<td colspan=8><?=nl2br($TableComment[$i])?></td>
					</tr>
					<tr class="tr1 td1 textbold">
						<td>No</td><td>Field</td><td>Type</td><td>Null</td><td>Key</td><td>Default</td><td>Extra</td><td>Comment</td>
					</tr>
					<?php
					$FieldCnt = sizeof($TableField[$i]);
					for($kk=0; $kk<$FieldCnt; $kk++) {
						echo "<tr>";
						echo "<td class='td1'>".($kk+1)."</td>";
						echo "<td>".$TableField[$i][$kk]['COLUMN_NAME']."</td>";
						echo "<td>".$TableField[$i][$kk]['COLUMN_TYPE']."</td>";
						echo "<td>".$TableField[$i][$kk]['IS_NULLABLE']."</td>";
						echo "<td>".$TableField[$i][$kk]['COLUMN_KEY']."</td>";
						echo "<td>".$TableField[$i][$kk]['COLUMN_DEFAULT']."</td>";
						echo "<td>".$TableField[$i][$kk]['EXTRA']."</td>";
						echo "<td>".$TableField[$i][$kk]['COLUMN_COMMENT']."</td>";
						echo "</tr>";
					}
					?>
					<tr><td colspan=8><?php echo nl2br($TableCreate[$i]); ?></td></tr>
					</table><br>
					<?php

				}
				?>

			</td>
			</tr>
			</table>
			<!-- TABLE List END -->
		</div>

		<hr>

		<h2>#### Procedure Info ###</h2>
		<div style="float:left; margin-right:10px;">

			<table border=1>
			<tr class="tr1">
				<td colspan=2><b>1. <?php echo  $DB1Name." Procedure List"; ?></b></td>
			</tr>
			<tr class="tr1">
				<td>No</td><td>Procedure  Name</td>
			</tr>
			<?php
			for($i=0; $i<$CNT91; $i++) {
				$No = $i+1;
				echo "<tr>";
				echo "<td class='td1'>".$No."</td>";
				echo "<td>";
					echo $ProDB1[$i]."<br>";
				echo "</td>";
				echo "</tr>";
			}
			?>
			<tr class="tr1"><td colspan=2>Total Procedure Count : <b><?php echo $CNT91; ?></b></td></tr>
			</table>

		</div>

		<div style="clear:both"></div>

		<?php
		$CNTPro1 = sizeof($ProField1);
		?>
		<br><input type="button" value="Procedure List on/Off" onclick="javascript:procedureListOnOff();">

		<div id="div_procedurelist" style="display:none">
			<!-- Procedure List START -->
			<hr>
			<table  style="border:0px;">
			<tr><td valign="top">

				<h2><?php echo  $DB1Name;?> >> Procedure </h2>
				<?php

				for($i=0; $i<$CNTPro1; $i++) {

					$Table = $ProField1[$i];
					?>
					<table border=1 width="650px">
					<tr class="tr1">
						<td><b><?php echo "1.[PROCEDURE][$i] - ".$DB1Name.".".$ProName1[$i]; ?></b></td>
					</tr>
					<tr>
						<td><xmp><?php echo $ProField1[$i]; ?></xmp></td>
					</tr>
					</table><br>
					<?php

				}
				?>

			</td>
			</tr>
			</table>
			<!-- Procedure List END -->
		</div>


<?php
		########################## DB Connect END ###############
		}



}
########################## ELSE END ###############
?>

<div style="clear:both"></div>
<hr>
<?php 
/* Page loading time check (END time) */
echo "<br>Page Loading Time : ". ( _microtime() - $time_start ). " sec"; 
?>
</body>
</html>
