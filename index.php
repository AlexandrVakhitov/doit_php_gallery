<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <!--    <link rel="stylesheet" href="css/bootstrap.min.css">-->
    <!--    <link rel="stylesheet" href="css/bootstrap-grid.min.css">-->
    <!--    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">-->
    <!--    <link rel="stylesheet" href="style.css">-->
</head>
<body>


<?php
	include_once('connect_db.php');		
	//error_reporting( E_ERROR );
	$gallery = '<h1>Вывод фото</h1>';
	$cc = 0;
	
	$path = $_SERVER['DOCUMENT_ROOT'] . "/modul_15/img";
	
	if ($query = mysqli_query($conn, "SELECT * FROM `catalog_items` ORDER BY name ASC")) {
		mysqli_data_seek($query, 0);
		while ($row = mysqli_fetch_assoc($query)) {
			$cc++;
			if (is_file($path . '/' . $row['photo'])) {
				$size = getimagesize($path . '/' . $row['photo']);
				$max_width = '125';
				$max_height = '125';
				$width = $size[0];
				$height = $size[1];
				$x_ratio = $max_width / $width;
				$y_ratio = $max_height / $height;
				
				if (($width <= $max_width) && ($height <= $max_height)) {
					$tn_width = $width;
					$tn_height = $height;
				} else if (($x_ratio * $height) < $height) {
					$tn_height = $x_ratio * $height;
					$tn_width = $max_width;
				} else {
					$tn_width = $y_ratio * $width;
					$tn_height = $max_height;
				}
				$img = '<a href="./img/' . $row['photo'] . '" target="_blank" style="text-decoration: none;">
                            <img src="./img/' . $row['photo'] . '" border="0" width="' . $tn_width . '">
                        </a>
                        ';
			} else {
				$img .= 'Нет фото';
			}
			
			
			$gallery .= '
<div style="position: relative; float: left; width: 125px; height: 165px; border: 2px solid #ccc; margin-right: 5px; margin-bottom: 5px; text-align: center">
    <div style="position: relative; width: 125px; height: 125px; overflow: hidden; margin-bottom: 5px;">
        <table style="width: 100%; height: 100%;">
            <tr>
                <td valign="middle" align="center">
                    ' . $img . '
                </td>
            </tr>
        </table>
    </div>
    <b>' . $row['name'] . '</b>
</div>
';
			
			if ($cc == 4) {
				$cc = 0;
				$gallery .= '<div style="clear: both"></div>';
			}
		}
		
		$gallery .= '<div style="clear: both"></div>';
		if ($gallery != '') {
			echo $gallery;
		}
	}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>