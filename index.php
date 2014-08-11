<?php 
	require_once('header.php'); 
	$result = mysql_query("SELECT COUNT(*) FROM `dru_file_managed`, `dru_file_usage` WHERE `dru_file_usage`.`type` = 'node' AND `dru_file_usage`.`fid` = `dru_file_managed`.`fid`; "); 
	$row = mysql_fetch_array($result); 
	$max = $row[0];
?>
	<head>
		<title>愛奇藝</title>
			<meta name="title" content="愛奇藝" />
			<meta name="keywords" content="" />
		<style type="text/css">
			table {
				width: 240px; 
				border: 0; 
				background-color: #333333; 
				opacity: 0.7;
				-webkit-filter: drop-shadow(#FFFFFF 0px 0px 15px); 
				-moz-filter: drop-shadow(#FFFFFF 0px 0px 15px); 
				-o-filter: drop-shadow(#FFFFFF 0px 0px 15px); 
				-ms-filter: drop-shadow(#FFFFFF 0px 0px 15px); 
				zoom: 1; 
				border-radius: 15px;   
			}
			a {
				color: #EEEEEE;  	
				text-decoration: none; 
			}
			tr {
				height: 40px;
				background-color: #505050; 
				color: #EEEEEE; 
				opacity: 0.7; 
				zoom: 1; 
			}
			ol {
				list-style-type: none; 		
				position: absolute; 
				top: -5px; 
				left: -25px; 
			}
			li {
				height: 41px; 		
			}
			.selected {
				background-color: #EAEA00; 
				color: #EEEEEE; 
			}
		</style>
		<script>
			var list_num = 1; 
			var t; 
			function rotate(){
				var list_num_max = <?php echo $max; ?>; 
				if(window.list_num > list_num_max)
					window.list_num = 1; 
				for(var i=1;i<=list_num_max;i++){
					document.getElementById('list_'+i).removeAttribute("class"); 
					document.getElementById('col_'+i).removeAttribute("class"); 
					document.getElementById('banner_'+i).style.display = "none"; 
				}
				document.getElementById('list_'+window.list_num).setAttribute("class", "seleceted"); 
				document.getElementById('col_'+window.list_num).setAttribute("class", "selected"); 
				document.getElementById('banner_'+window.list_num).style.display = "block"; 
				window.list_num++; 
				window.t = setTimeout('rotate()',5000); 
			}

			function doSel(num){
				var list_num_max = <?php echo $max; ?>; 
				window.list_num = num;
				for(var i=1;i<=list_num_max;i++){
					document.getElementById('list_'+i).removeAttribute("class"); 
					document.getElementById('col_'+i).removeAttribute("class"); 
					document.getElementById('banner_'+i).style.display = "none"; 
				}
				document.getElementById('list_'+window.list_num).setAttribute("class", "seleceted"); 
				document.getElementById('col_'+window.list_num).setAttribute("class", "selected"); 
				document.getElementById('banner_'+window.list_num).style.display = "block"; 
				clearTimeout(window.t); 
			}

		</script>
	</head>
	<body onload="rotate(); ">
	<!-- Picture -->
	<div name="banner" style="text-align: center; ">
		<?php 
			$count = 0; 
			$result = mysql_query("SELECT * FROM `dru_file_managed` AS m, `dru_file_usage` AS u, `dru_node` AS n WHERE u.`id` = n.`nid` AND u.`fid` = m.`fid` AND u.`type` = 'node' ORDER BY n.`created` DESC; ");  
			while($row = mysql_fetch_array($result)){
				$count++; 
				$len = strlen($row['uri']); 
				$url = substr($row['uri'], 9, $len-9); 
				echo '<a href="article/?q=node/' . $row['nid'] . '"><img id="banner_' . $count . '" src="article/files/' . $url . '" alt="' . $row['title'] . '" title="' . $row['title'] . '" style="height: 460px; width: 1280px; '; 
				if($count==1)
					echo 'display: block; "/></a>'; 
				else
					echo 'display: none; "/></a>'; 
				if($count==$max)
					break;
			}
		?>
	</div>
	<!-- Picture End-->
	<!-- Select List -->
	<div name="list" style="position: absolute; top: 80px; left: 1035px; ">
		<table>
			<?php
					if($max==1)
						echo '<tr><td id="col_1" style="border-radius: 15px 15px 15px 15px; "></td></tr>'; 
					else if($max<10){
						echo '<tr><td id="col_1" style="border-radius: 15px 15px 0px 0px; "></td></tr>'; 
						for($i=2;$i<$max;$i++)
							echo "<tr><td id='col_{$i}'></td></tr>"; 
						echo "<tr><td id='col_{$i}' style='border-radius: 0px 0px 15px 15px'></td></tr>"; 
					}
					else{
						echo '<tr><td id="col_1" style="border-radius: 15px 15px 0px 0px; "></td></tr>'; 
						for($i=2;$i<10;$i++)
							echo "<tr><td id='col_{$i}'></td></tr>"; 
						echo "<tr><td id='col_{$i}' style='border-radius: 0px 0px 15px 15px; ></td></tr>"; 
					}
			?>
		</table>
		<ol>
			<?php
				$count = 0; 
				$result = mysql_query("SELECT * FROM `dru_file_managed` AS m, `dru_file_usage` AS u, `dru_node` AS n WHERE u.`id` = n.`nid` AND u.`fid` = m.`fid` AND u.`type` = 'node' ORDER BY n.`created` DESC; ");
				while($row = mysql_fetch_array($result)){
					$count++; 
			?>
					<li id="list_<?php echo $count; ?>" onmouseover="doSel(<?php echo $count; ?>)" onmousefocus="doSel(<?php echo $count; ?>)" onmouseout="rotate(); "><a href="article/?q=node/<?php echo $row['nid']; ?>"><?php echo $row['title']; ?></a></li> 
			<?php
					if($count==10)
						break; 	
				}
			?>
		</ol>
	</div>
	<!-- Select List End -->

	</body>
<?php require_once('footer.php'); ?>
