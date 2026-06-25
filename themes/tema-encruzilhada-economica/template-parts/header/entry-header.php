<?php
/**
 * Displays the post header
 *
 * @package Newspack
 */

$discussion = ! is_page() && newspack_can_show_post_thumbnail() ? newspack_get_discussion_data() : null;

if ( function_exists( 'newspack_get_all_sponsors' ) ) {
    $all_sponsors         = newspack_get_all_sponsors( get_the_id() );
    $native_sponsors      = newspack_get_native_sponsors( $all_sponsors );
    $underwriter_sponsors = newspack_get_underwriter_sponsors( $all_sponsors );
}

$page_hide_title = get_post_meta( $post->ID, 'newspack_hide_page_title', true );

$subtitle = get_post_meta( $post->ID, 'newspack_post_subtitle', true );

$image_html = ( ! is_page() ) ? get_the_post_thumbnail( get_the_ID(), 'large' ) : '';
// Verifica se tem imagem e NÃO é página
$tem_imagem = ! empty( $image_html );
$classe_layout = $tem_imagem ? 'com-imagem' : 'sem-imagem';
?>

<div class="entry-header-inner custom-grid-layout <?php echo $classe_layout; ?>">
    <?php if ( is_singular() ) : ?>
        
        <?php if ( $tem_imagem ) : // SÓ CRIA A COLUNA SE TIVER IMAGEM ?>
            <div class="header-column-left">
                <div class="featured-image-safe">
                    <?php the_post_thumbnail( 'large' ); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="header-column-right">
            <?php
         if ( ! is_page() ) :
            if ( ! empty( $native_sponsors ) ) {
                newspack_sponsor_label( $native_sponsors, null, true );
            } else {
                // Obtém todas as categorias vinculadas ao post atual
                $categories = get_the_category();
                $has_news_slug = false;

                // Verifica se o slug 'noticias-news' está presente
                foreach ( $categories as $category ) {
                    if ( 'noticias-news' === $category->slug ) {
                        $has_news_slug = true;
                        break;
                    }
                }

                // Só exibe as categorias se o slug NÃO foi encontrado
                if ( ! $has_news_slug ) {
                    newspack_categories();
                }
            }
        endif;
            
            if ( ! $page_hide_title ) : ?>
                <div>
                    <h1 class="entry-title <?php echo $subtitle ? 'entry-title--with-subtitle' : ''; ?>">
                        <?php echo wp_kses_post( get_the_title() ); ?>
                    </h1>
            </div>
            <?php endif; 

            if ( is_singular() && ! is_page() ) {
                exibir_barra_compartilhamento_personalizada( get_permalink(), get_the_title(), get_the_excerpt() );
            }

            if ( $subtitle ) : ?>
                <div class="newspack-post-subtitle">
                    <?php echo esc_html( $subtitle ); ?>
                </div>
            <?php endif; ?>
        </div>

    <?php else : ?>
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark">
                <?php echo wp_kses_post( get_the_title() ); ?>
            </a>
        </h2>
    <?php endif; ?>
</div>