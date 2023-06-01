<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Máy Rút Tiền ATM</title>
<meta content="text/html ; charset = utf-8" http-equiv="content-Type">
<link type ="text/css" href ="ATM.css" rel ="stylesheet" media = "screen">
</head>
<body>
 <?php
$flag = false;
$error="";
if (! isset($_POST["tienRut"])) {
    $tien = 0;
} else {
    $tien = $_POST["tienRut"];
    if ($tien % 100 == 0 && $tien >= 5000) {
        $flag = true;
        $arrTien = [100,200,500,1000,2000,5000,10000,20000,50000,100000,200000,500000];
        $lengh = count($arrTien);
        $tienXuly = $tien;
        $menhGia = array();
        $Soto = array();
        $thanhTien = array();
        $tongTien = 0;
        for ($i = $lengh - 1; $i >= 0; $i --) {
            $tienvn = $arrTien[$i];
            if ($tienXuly >= $tienvn) {
                $menhGia[] = $tienvn;
                $a = floor($tienXuly / $tienvn);
                $Soto[] = $a;
                $tienXuly %= ($tienvn * $a);
                $thanhTien[] = $Soto[count($Soto) - 1] * $tienvn;
            }
            if ($tienXuly == 0) {
                break;
            }
        }
        $tongTien += array_sum($thanhTien);
    } else {
        $error = "Mức Tiền rút phải lớn hơn 5.000 đồng.";
    }
}

function readNumber($value)
{
    if ($value == 1) {
        return " Một ";
    }
    if ($value == 2) {
        return " Hai ";
    }
    if ($value == 3) {
        return " Ba ";
    }
    if ($value == 4) {
        return " Bốn ";
    }
    if ($value == 5) {
        return " Năm ";
    }
    if ($value == 6) {
        return " Sáu ";
    }
    if ($value == 7) {
        return " Bảy ";
    }
    if ($value == 8) {
        return " Tám ";
    }
    if ($value == 9) {
        return " Chín ";
    }
    if ($value == 0) {
        return " Không ";
    }
}

function ReadPosition($value)
{
    if ($value != 1) {
        if ($value % 6 == 1) {
            return "Triệu";
        }
        if ($value % 9 == 1) {
            return "Tỷ";
        }
        if ($value % 3 == 2) {
            return "Mươi";
        }
        if ($value % 3 == 0) {
            return "Trăm";
        }
        if ($value % 3 == 1) {
            return " Ngàn";
        }
    }
}

function IntoLetter($value)
{
    $str = (string) $value;
    $Strnum = "";
    $strPosi = "";
    $strResult = "";
    $leng = strlen($str);
    for ($i = 0; $i < $leng; $i ++) {
        $position = $leng - $i;
        if ($str[$i] == 0) {
            if ($position % 3 == 1) {
                if ($str[$i - 2] != 0) {
                    $strPosi = ReadPosition($position);
                    $strResult .= $strPosi;
                }
            } elseif ($position % 3 == 2) {
                if ($str[$i + 1] != 0) {
                    $strResult .= " Lẻ ";
                }
            } elseif ($position % 3 == 0) {
                if ($str[$i + 2] != 0) {
                    $Strnum = readNumber($str[$i]);
                    $strPosi = ReadPosition($position);
                    $strResult .= $Strnum . $strPosi;
                }
            }
        } elseif ($str[$i] == 1) {
            if ($position % 3 == 1) {
                if ($str[$i - 1] > 1) {
                    $strPosi = ReadPosition($position);
                    $strResult .= " Mốt " . $strPosi;
                } else {
                    $Strnum = readNumber($str[$i]);
                    $strPosi = ReadPosition($position);
                    $strResult .= $Strnum . $strPosi;
                }
            } elseif ($position % 3 == 2) {
                $strResult .= " Mười ";
            } elseif ($position % 3 == 0) {
                $Strnum = readNumber($str[$i]);
                $strPosi = ReadPosition($position);
                $strResult .= $Strnum . $strPosi;
            }
        } elseif ($str[$i] == 5) {
            if ($position % 3 == 1) {
                if ($str[$i - 1] != 0) {
                    $strPosi = ReadPosition($position);
                    $strResult .= " Lăm " . $strPosi;
                } else {
                    $Strnum = readNumber($str[$i]);
                    $strPosi = ReadPosition($position);
                    $strResult .= $Strnum . $strPosi;
                }
            } else {
                $Strnum = readNumber($str[$i]);
                $strPosi = ReadPosition($position);
                $strResult .= $Strnum . $strPosi;
            }
        } else {
            $Strnum = readNumber($str[$i]);
            $strPosi = ReadPosition($position);
            $strResult .= $Strnum . $strPosi;
        }
    }
    return $strResult;
}
?> 
	<div class="content">
		<h1>Máy Rút Tiền ATM</h1>
		<hr>
		<hr>
		<form action="#" method="post" name="form_main">
			<div class = "input">
				<span>Số tiền bạn muốn rút(>5000 vnd):<br/><input type="text" name="tienRut"
					value="<?php echo number_format($tien) ?>"></span>
			</div>
			<div class ="submit">
				<input type="submit" name="xuly">
			</div>
                    <hr>
			<div class="result">
			<?php
                if ($flag == true) {
                    ?>
                <div>
					<span class="column1">Mệnh Giá:</span> <span class="column2">Số Tờ:</span>
					<span class="column3">Thành Tiền:</span>
				</div>
                    			<?php
                    			$leng1 = count($menhGia);
                    			for ($j = 0; $j < $leng1; $j ++) {
                        ?>
                			    <span class="column1"><?php echo str_pad(number_format($menhGia[$j]), 10,"_",STR_PAD_LEFT) ?></span>
                				<span class="column2"><?php echo str_pad(number_format($Soto[$j]), 5,'_',STR_PAD_BOTH)?></span>
                				<span class="column3"><?php echo str_pad(number_format($thanhTien[$j]), 10,'_',STR_PAD_LEFT)  ?></span><br>
                			<?php
                    }
                    ?>
                  
    			<div class="Total">
    			<br>
    			<br>
					<span>Tổng tiền: <?php if ($flag == true) echo number_format($tongTien) ?></span>
				</div>
				<div class="IntoLetters">
				<br>
					<span>Thành chữ:<?php  echo IntoLetter($tongTien) ." Đồng.";?>
                </span>
				</div>
                    <?php
                } else {
                    echo $error;
                }
                ?>
		</div>
 <hr>
                   <hr>
		</form>
	</div>
</body>
</html>