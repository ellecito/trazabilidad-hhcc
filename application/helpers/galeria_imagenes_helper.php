<?php
	
	function galeriaImagenes($imagenes, $video = false){
		
		$limit_image = 3;
		$width_img = 101;
		$height_img = 101;
	
		$html = '
		<link rel="stylesheet" type="text/css"  href="/js/jquery/easyslider/1.7/slider-galeria.css" />
		<link rel="stylesheet" type="text/css"  href="/js/jquery/colorbox/1.4.15/version_black/colorbox.css" />
		
		<script type="text/javascript" src="/js/jquery/easyslider/1.7/easy_slider.js"></script>
		<script type="text/javascript" src="/js/jquery/colorbox/1.4.15/jquery.colorbox-min.js"></script>
		<script type="text/javascript" src="/js/sistema/galeria/index.js"></script>
			
		<div class="multimedia">
			<ul>
				<li class="tabL">
					<a href="#pics">
						'._("Fotografías").'
					</a>		
				</li>
				';
				if($video != ""):
				$html .= '
				<li class="tabR">
					<a href="#videos">
						Video
					</a>		
				</li>	
				';
				endif;
				$html .=' 
			</ul>
		<div class="imagenes" id="pics">';
			$i = array_shift($imagenes);
			$html.= '<a href="'.$i->ruta_grande.'" rel="galeria" title="'.htmlentities($i->descripcion).'">
				<img src="'.$i->ruta_interna.'" alt="'.htmlentities($i->descripcion).'" />
			</a>
			<div class="clear"></div>';
				$total_img = count($imagenes);
				if($total_img){
					$html.= '
			<!-- [MINIATURAS] -->	
			<div id="'.(($total_img > $limit_image)?'content-slider':'content').'" class="contSlider">
				<div id="slider">	
					<ul style="width:30000000px;">';
						$i = 0;
						foreach($imagenes as $imagen):	
							
							
								if($i == 0):
									$html .= '<li>';
								else:
									if($i % $limit_image == 0 && $i != $total_img):
										$html.='</li><li>';
									endif;
								endif;					
								$html.= '
									<a href="'.$imagen->ruta_grande.'" class="img" rel="galeria" title="'.htmlentities($imagen->descripcion).'">
										<img src="'.$imagen->ruta_galeria.'" alt="'.htmlentities($imagen->descripcion).'" width="'.$width_img.'" height="'.$height_img.'" />
									</a>';
								$i++;
								if($i == $total_img)
									$html.='</li>';
						endforeach;
						$html.= '
					</ul>
				</div>
			</div>';
				}
				$html.= '
		</div>';
		
		if($video != ""):
			$html.='
			<div id="videos">
				<iframe src="//www.youtube.com/embed/'.$video.'?rel=0" width="400" height="225" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
			</div>';
		endif;

		$html.='</div>';
		
		return $html;
	}
?>