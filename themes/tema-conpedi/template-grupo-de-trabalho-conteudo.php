<?php
/**
 * Template Name: Single grupos de trabalho*/
get_header();
session_start();

?>

	<section id="primary" class="content-area">

		<header class="page-header">

		</header><!-- .page-header -->

		<main id="main" class="site-main">

		<?php

		//Using GET
		$id_grupo= $_GET["grupo"];
		$id_evento= $_GET["id-evento"];
		$tipo=$_GET["tipo"];

		$url_evento="http://conpedi-api-wp.18.228.224.9.nip.io/api/publicacao/evento/$tipo";

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
					echo "<h5 class=titulo-centralizado class=titulo-centralizado>".$artigo_decode[$key]['titulo']."</h5>";
				}
			}


		$url="http://conpedi-api-wp.18.228.224.9.nip.io/api/publicacao/trabalho/$tipo/$id_evento/$id_grupo"; //alterar para não utilizar toda a url

		//  Initiate curl
			$grupo_conteudo = curl_init();
			// Will return the response, if false it print the response
			curl_setopt($grupo_conteudo, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($grupo_conteudo, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($grupo_conteudo);
			// Closing
			curl_close($grupo_conteudo);

			// Will dump a beauty json :3
			$grupo_conteudo_decode=(json_decode($result, true));

			echo "<h6>".$grupo_conteudo_decode['grupoTrabalho']['descricao']."</h6><br>";
			$texto = str_replace( "\r\n", '<p>', $grupo_conteudo_decode['grupoTrabalho']['textoApresentacao'] );

			echo "<div class=texto-apresentacao><p>".$texto."</div>";
			echo "<p><strong> ISBN:".$grupo_conteudo_decode['grupoTrabalho']['isbn']."</strong></p>";

			?>
			<div class="section-button">
				<? echo "<a class=button href=".$grupo_conteudo_decode['grupoTrabalho']['caminhoFichaCatalografica'].">Ficha catalográfica </a>";
			?>
			</div>

			<div class="section">
				<p><strong> Trabalhos publicados neste livro:</strong></p>
				<?php
				foreach ($grupo_conteudo_decode['trabalhos'] as $key => $trabalhos_array) {
					echo "<div class=div-trabalho><a class=trabalho href=".$trabalhos_array['caminhoArquivo'].">".$trabalhos_array['titulo']."</a><br></div>";
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
