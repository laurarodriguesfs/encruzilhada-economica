<?php
/**
 * Template Name: Archive de publicações: posters do conpedi
*/
get_header();
session_start();

?>

	<section id="primary" class="content-area">

		<header class="page-header">

		</header><!-- .page-header -->

		<div class=div-titulo>
			<h2 class=titulo-centralizado>Pôsteres Conpedi</h2>
		</div>

		<main id="main" class="site-main">

		<?php
	
		$url=$api_campo_1;

		//  Initiate curl
			$artigo = curl_init();
			// Will return the response, if false it print the response
			curl_setopt($artigo, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($artigo, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($artigo);
			// Closing
			curl_close($artigo);

			// Will dump a beauty json :3
			$artigo_decode=(json_decode($result, true));


			foreach ($artigo_decode as $key => $value) { ?>
				<div class=div-principal><?
					echo "<div class=div-evento-publicacoes><a class=evento-publicacoes href=/grupos-de-trabalho?tipo=POSTER_CONPEDI&evento=".$artigo_decode[$key]['id']."&id-evento=".$artigo_decode[$key]['id']."><strong>".$artigo_decode[$key]['titulo']."</strong></a></div>";
					echo "<div class=div-evento-publicacoes><a class=evento-publicacoes href=/grupos-de-trabalho?tipo=POSTER_CONPEDI&evento=".$artigo_decode[$key]['id']."&id-evento=".$artigo_decode[$key]['id'].">".$artigo_decode[$key]['tema']."</a></div>";
					echo "<div class=div-evento-publicacoes-data><a class=evento-publicacoes href=/grupos-de-trabalho?tipo=POSTER_CONPEDI&evento=".$artigo_decode[$key]['id']."&id-evento=".$artigo_decode[$key]['id'].">".$artigo_decode[$key]['textoDataEvento']."</a></div>";
				?></div><?
			}

			foreach ($artigo_decode as $key => $value) {
				$array_id_evento[] = $artigo_decode[$key]['id'];
			}

			// $arr is now array(2, 4, 6, 8)
			unset($value); // break the reference with the last element


			/*session is started if you don't write this line can't use $_Session  global variable*/
			?>
		</main><!-- #main -->
		<div class="pagination-posts">

		</div>
		<?php
		$archive_layout = get_theme_mod( 'archive_layout', 'default' );
		if ( 'default' === $archive_layout ) {
			get_sidebar();
		}
		?>
	</section><!-- #primary -->

<?php
get_footer();
