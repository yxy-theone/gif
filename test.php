<?php
require_once 'head.php';
require_once 'GIFEncoder.class.php';

$name = 'wangjingze';
$font_file = ROOT_PATH.'/msyhbd.ttf';

ob_start();  
$width = 300;
$height = 184;

//读取目录下的所有文件
$res = scanFile(ROOT_PATH.'/'.$name.'/layer');
$layer_imgs = array();
foreach ($res as $v) {
	$k = intval($v);
	$layer_imgs[$k] = $v;
}
ksort($layer_imgs);

$data = array();
$data[0] = '我就是饿死';
$data[1] = '死外边 从这跳下去';
$data[2] = '也不会吃你们一点东西';
$data[3] = '真香';

$str = implode('', $data);
$id = md5($str);

$imagedata = array();
// 开始合成图片
foreach ($layer_imgs as $k => $v) {
	$img_src = ROOT_PATH.'/'.$name.'/layer/'.$v;
	$bg = imagecreatefromstring(file_get_contents($img_src));
	/*list($width, $height) = getimagesize($img_src);*/

	$text_color = imagecolorallocate($bg, 255, 255, 255);
	$fontSize = 14;//14号字体
	$fontWidth = imagefontwidth($fontSize);

	$text = '';
	if($k < 9){
		$text = $data[0];
	}else if($k > 11 && $k<24){
		$text = $data[1];
	}else if($k > 24 && $k<35){
		$text = $data[2];
	}else if($k > 36 && $k<48){
		$text = $data[3];
	}else{
		$text = '';
	}

	if($text){
		$arr = imagettfbbox($fontSize,0,$font_file,$text);
        $textWidth = $arr[2]-$arr[0];
		imagettftext($bg, $fontSize, 0, ($width-$textWidth)/2, 170, $text_color, $font_file , $text);
	}


	imagegif($bg);  
	imagedestroy($bg);  
	$imagedata[] = ob_get_contents();  
	ob_clean();
}

$gif = new GIFEncoder(  
    $imagedata,  
    100,  
    0,  
    0,  
    0, 0, 1,
    "bin"
);  
          
/*Header ('Content-type:image/gif');  
$gif->GetAnimation();*/
$res = $gif->GetAnimation();
$filename = ROOT_PATH."/images/".$name."/".$id.".gif";
mkFolder(ROOT_PATH."/images/".$name);
file_put_contents($filename, $res);