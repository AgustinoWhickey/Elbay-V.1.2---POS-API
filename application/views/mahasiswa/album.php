<div class="container">
	<div class="row mt-3">
		<div class="col-md-12">
			<div id="photo">
				<div class="gambar text-center">
					<?php
						$pertama = '';
						if(isset($images) && count($images)){
							foreach($images as $image){
								$pertama = $image['url'];
								break;
							}
							echo ("<img src='".$pertama."' name='besar' width='600' height='450'>");
						}
					?>
				</div>
			</div>

			<div id="gallery"class="container">
				<div class="row">
				<?php 
					if(isset($images) && count($images)){
						$i = 0;
						foreach ($images as $image) { ?>
							<div class="item col-md">
								<a href="<?= "Javascript: Pilih('".$image['url']."',".$i++.")"; ?>">
									<img src="<?= $image['thumb_url'] ?>" alt="">
								</a>
							 	<div class="caption"><?= basename($image['url']); ?></div>
							</div>
					<?php	}
					} else {
						echo '<div id="blank_galery">Please Upload an Image</div>';
					}
				?>
				</div>
			</div>
			<div id="mask"></div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		var move = 0;
		var zoom = 1.1;

		$('.item').hover(function(){
			var width = $('.item').width() * zoom; 
			var height = $('.item').height() * zoom; 

			$(this).find('img').stop(false,true).animate({
				'width':width,
				'height':height,
				'top':move,
				'left':move,
				'padding':'10px'
			},
			{duration:300});

			$(this).find('div.caption').stop(false,true).fadeIn(300);
		},
		function(){
			$(this).find('img').stop(false,true).animate({
				'width':$('.item').width(),
				'height':$('.item').height(),
				'top':'0',
				'left':'0',
				'padding': '10px'
			},
			{duration:300});
		});

		$('a[name=modal]').click(function(e){
			e.preventDefault();

			var id = $(this).attr('href');
			var maskHeight = $(document).height();
			var maskWidth = $(document).width();

			$('#mask').css({'width':maskWidth,'height':maskHeight});
			$('#mask').fadeIn(1000);
			$('#mask').fadeTo('slow',0.8);

			var winH = $(window).height();
			var winW = $(window).width();

			$(id).css('top',winH/2-$(id).height()/2);
			$(id).css('left',winH/2-$(id).width()/2);

			$(id).fadeIn(2000);
		});

		$('.window .close').click(function(e){
			e.preventDefault();
			$('#mask').hide();
			$('.window').hide();
		});

		$('#mask').click(function(){
			$(this).hide();
			$('.window').hide();
		});
	});

	function Pilih(Gambar,indeks){
		document.images.besar.src=Gambar;
	}
</script>