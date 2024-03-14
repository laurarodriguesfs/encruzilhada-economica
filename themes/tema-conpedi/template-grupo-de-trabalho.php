<?php
/**
 * Template Name: Archive de grupos de trabalho de acordo com o evento
*/
get_header();
session_start();

?>

	<section id="primary" class="content-area">

		<header class="page-header">

		</header><!-- .page-header -->

		<main id="main" class="site-main">

		<?php

		//Using GET
		$evento= $_GET["evento"];
		$id_evento= $_GET["id-evento"];

		$url_evento="http://conpedi.18.228.224.9.nip.io/api/v1/publicacao/evento/TODOS/TODOS";

		//  Initiate curl
			$artigo = curl_init();
			// Will return the response, if false it print the response
			curl_setopt($artigo, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($artigo, CURLOPT_URL,$url_evento);
			// Execute
			$result=curl_exec($artigo);
			// Closing
			curl_close($artigo);

			// Will dump a beauty json :3
			$artigo_decode=(json_decode($result, true));


			foreach ($artigo_decode as $key => $value) {
				if($artigo_decode[$key]['id']==$id_evento){
					echo "<h5 class=titulo-centralizado><strong>".$artigo_decode[$key]['titulo']."</strong></h5>";
				}
			}


		$url="http://conpedi.18.228.224.9.nip.io/api/v1/publicacao/evento/grupoTrabalho/$id_evento";

		//  Initiate curl
			$grupo = curl_init();
			// Will return the response, if false it print the response
			curl_setopt($grupo, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($grupo, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($grupo);
			// Closing
			curl_close($grupo);

			// Will dump a beauty json :3
			$grupo_decode=(json_decode($result, true));

			?>
			<div class=trabalhos>
			<?
			foreach ($grupo_decode as $key => $value) {
				echo "<div class=div-trabalho><a class=trabalho href=./grupo-de-trabalho?grupo=".$grupo_decode[$key]['id']."&id-evento=".$id_evento.">".$grupo_decode[$key]['descricao']."<br></a></div>";
            }
			?>
			</div>
			<?
			// $arr is now array(2, 4, 6, 8)
			unset($value); // break the reference with the last element
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
