<?php
require_once 'head.php';
require_once 'GIFEncoder.class.php';

if($_SESSION['request_lasttime']){
	if((time()-$_SESSION['request_lasttime'])<3){//3秒内
		 json_output(1,false,"请求太频繁，请稍后再试！");
	}
	$_SESSION['request_lasttime'] = time();
}else{
	json_output(999,false,"非法请求");
}

$name = $_POST['name'];
$data = $_POST['data'];
if(empty($name)||empty($data)||!is_array($data)){
	json_output(500,false,"数据错误");
}

$font_file = ROOT_PATH.'/msyhbd.ttf';
switch ($name) {
	case 'wangjingze':
		if(count($data) < 4) json_output(500,false,"数据错误");
		$str = implode('', $data);
		if(empty($str)) json_output(500,false,"数据错误");
		$id = md5($str);

		$base_path = ROOT_PATH."/images/".$name;
		mkFolder($base_path);

		$filename = $base_path."/".$id.".gif";
		if(!file_exists($filename)){
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
			    200,  
			    0,  
			    0,  
			    0, 0, 1,  
			    "bin"
			);

			$res = $gif->GetAnimation();
			file_put_contents($filename, $res);
		}
		json_output(0,true,str_replace(ROOT_PATH, "", $filename));
		break;
	default:
		json_output(404,false,"资源不存在");
		break;
}


/*
 * JSON方式输出
 */
function json_output($code=0,$is_success=true,$data=""){
    @header("Content-Type: application/json; charset=utf-8");
    //@header('Access-Control-Allow-Origin:*'); //*代表可访问的地址，可以设置指定域名
    @header('Access-Control-Allow-Methods:POST,GET');
    exit(json_encode(array("code"=>$code,"success"=>$is_success,"data"=>$data),JSON_UNESCAPED_UNICODE));
}
function scanFile($path) {
  global $result;
  $files = scandir($path);
  foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
      if (is_dir($path . '/' . $file)) {
        scanFile($path . '/' . $file);
      } else {
        $result[] = basename($file);
      }
    }
  }
  return $result;
}

function mkFolder($path,$mode=0700)  {  
    if(!is_readable($path)){  
        is_file($path) or mkdir($path,$mode,true);
    }  
}