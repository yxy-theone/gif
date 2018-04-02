<?php require_once 'head.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>动图生成PHP脚本 - 忙里偷闲</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/common.css">
</head>
<body>
	<div class="container-full">
		<div id="content-wrap">
			<h1>动图生成PHP脚本 - 忙里偷闲</h1>
			<div id="gif-icon">
				<img src="./wangjingze/icon.png">
				<!-- <img src="./wangjingze/this.gif"> -->
			</div>
			<div id="form-wrap">
				<label>第一句：</label>
				<input type="text" name="text[]" placeholder="我就是饿死"  value="我就是饿死">

				<label>第二句：</label>
				<input type="text" name="text[]" placeholder="死外边 从这跳下去" value="死外边 从这跳下去">

				<label>第三句：</label>
				<input type="text" name="text[]" placeholder="也不会吃你们一点东西" value="也不会吃你们一点东西">

				<label>第四句：</label>
				<input type="text" name="text[]" placeholder="真香" value="真香">

				<br>
				<button id="make-gif" class="btn btn-danger" name="wangjingze">生成GIF</button>

				<div id="img-preview" style="display: none;">
					<img src="">
					<br>
					<a href="download.php?id=" target="_blank" class="btn btn-success">下载结果图</a>
				</div>
			</div>
		</div>
	</div>

	<script src="./js/jquery.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/common.js"></script>
</body>
</html>