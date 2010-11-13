<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>LZYY'S PKM</title>
		<link rel="stylesheet/less" href="media/style/main.less" type="text/css" />
		<link rel="stylesheet" href="media/scripts/prettify/prettify.css" type="text/css" />
		<script src="media/scripts/jquery-1.4.3.min.js"></script>
		<script src="media/scripts/less-1.0.35.min.js"></script>
		<script src="media/scripts/prettify/prettify.js"></script>
		<script>
		$(function(){
			var $data = <?php echo $data ;?>;

			var tag_li = '';
			$.each($data, function(key, cnts){
				tag_li += '<li><a href="#" tag="'+key+'">'+key+'('+cnts.length+')</a></li>';
			});
			$('ul.tag').append(tag_li);

			$('ul.tag').delegate('a', 'click', function(e){
				e.preventDefault();
				var $self = $(this);
				$('ul.tag a').removeClass('selected');
				$self.addClass('selected');
				var tag = $self.attr('tag');
				var list_li = '';
				$.each($data[tag], function(key, cnt){
					list_li += '<li><a href="#" tag="'+tag+'" index="'+key+'">'+cnt.split("\n")[0].replace(/<h1>(.*)<\/h1>/, '$1')+'</a></li>';
				});
				$('ul.list').empty().append(list_li);
				$('ul.list li a').each(function(){
					var tag = $(this).attr('tag');
					var index = $(this).attr('index');
					$(this).data('cnt', $data[tag][index]);
				});
			});

			$('ul.list a').live('click', function(e){
				e.preventDefault();
				show_post($(this));
			});

			$('.main .relate a').live('click', function(e){
				e.preventDefault();
				show_post($(this));
			});


			var show_post = function($self) {
				var cnts = $self.data('cnt').split('<br />tag: ');
				var title = $self.text();
				$('.main .relate').empty();
				$('.main .cnt').empty().append(cnts[0]);
				$(".main .cnt pre").addClass("prettyprint");
				prettyPrint();
				var tags = cnts[1].split(' ');

				var relate_li = '';
				$.each(tags, function(index, tag){
					$.each($data[tag], function(key, cnt){
						var t_title = cnt.split("\n")[0].replace(/<h1>(.*)<\/h1>/, '$1');
						if (title != t_title)
							relate_li += '<li><a href="#" tag="'+tag+'" index="'+key+'">'+cnt.split("\n")[0].replace(/<h1>(.*)<\/h1>/, '$1')+'</a></li>';
					});
					$('.main .relate').css({'background': '#f4f4f4', 'border-top': '1px solid #ccc'});
					$('.main .relate').append('<div class="item"><h3>'+tag+'</h3><ul>'+relate_li+'</ul></div>');
					$('.main .relate a').each(function(){
						var tag = $(this).attr('tag');
						var index = $(this).attr('index');
						$(this).data('cnt', $data[tag][index]);
					});
					relate_li = '';
				});
			}
		});
		</script>
	</head>

	<body>
		<!--
		<div id="header">
			<div class="logo"><a href="<?php echo substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));?>"><?php echo 'LZYY\'S PKM'; ?></a></div>
		</div>
		-->

		<div id="doc" class="clear">
			<ul class="sidebar tag">
			</ul>
			<ul class="sidebar list">
			</ul>

			<div class="main">
				<div class="cnt"></div>
				<div class="relate clear"></div>
			</div>
		</div>
		
		<!--
		<div id="footer">
			<p class="zen">Do have a faith in what you love</p>
		</div>
		-->
	</body>
</html>


