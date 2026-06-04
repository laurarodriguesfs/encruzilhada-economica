<?php
/**
 * Template Name: Author Archive
 */

get_header(); ?>

<main id="primary" class="site-main container">

    <?php
    // Obtém com precisão o ID do autor da página de arquivo atual
    $author_id = get_queried_object_id();
    $author_data = get_userdata( $author_id );
    ?>

    <div class="author-page-header author-box-container mb-5">
        
        <div class="author-image">
            <?php 
            // Puxa a foto do Pods conforme seu código original
            $pod = pods( 'user', $author_id );
            $author_avatar_url = $pod->display( 'foto_do_autor' ); 
                
            // Fallback para o Gravatar caso esteja vazia
            if ( empty($author_avatar_url) ) {
                $author_avatar_url = get_avatar_url($author_id, ['size' => 250]);
            }

            // Exibe a imagem de forma segura
            if ( strpos($author_avatar_url, '<img') !== false ) {
                echo $author_avatar_url;
            } else {
                echo '<img src="' . esc_url($author_avatar_url) . '" alt="' . esc_attr($author_data->display_name) . '">';
            }
            ?>
        </div>

        <div class="author-info">
            
            <h1 class="author-name">
                <?php echo esc_html( $author_data->display_name ); ?>
            </h1>
            
            <?php if ( ! empty( get_the_author_meta( 'description', $author_id ) ) ) : ?>
                <div class="author-description my-3">
                    <p><?php the_author_meta( 'description', $author_id ); ?></p>
                </div>
            <?php endif; ?>

            <?php if ( $areas = get_the_author_meta( 'areas_de_pesquisa', $author_id ) ) : ?>
                <div class="author-research-areas mb-3">
                    <strong>Áreas de pesquisa:</strong> <?php echo esc_html( $areas ); ?>
                </div>
            <?php endif; ?>

            <?php 
            $lattes = get_the_author_meta( 'curriculo_lattes', $author_id );
            $orcid  = get_the_author_meta( 'orcid', $author_id );
            ?>
            <?php if ( $lattes || $orcid ) : ?>
                <div class="author-academic-identifiers mb-3">
                    <?php if ( $lattes ) : ?>
                        <a href="<?php echo esc_url($lattes); ?>" target="_blank" rel="noopener" class="author-link-btn">
                            📄 Currículo Lattes
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $orcid ) : ?>
                        <a href="<?php echo esc_url($orcid); ?>" target="_blank" rel="noopener" class="author-link-btn">
                            🟢 ORCID
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php 
            $linkedin = get_the_author_meta( 'link_linkedin', $author_id );
            $twitter  = get_the_author_meta( 'link_twitter', $author_id );
            ?>
            <?php if ( $linkedin || $twitter ) : ?>
                <div class="author-social-links mb-3">
                    <strong>Redes sociais: </strong>
                    <?php if ( $linkedin ) : ?>
                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener">LinkedIn</a>
                    <?php endif; ?>
                    <?php if ( $twitter ) : ?>
                        <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener">Twitter/X</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php 
    // Puxa o array de IDs selecionados no perfil do usuário
    $artigos_ids = get_user_meta( $author_id, 'principais_artigos_ids', true );
    ?>
    <?php if ( ! empty( $artigos_ids ) && is_array( $artigos_ids ) ) : ?>
        <div class="author-featured-articles mt-4">
            <h3>Principais Artigos Publicados</h3>
            <ul class="articles-list">
                
                <?php 
                foreach ( $artigos_ids as $artigo_id ) : 
                    // Verifica se o post ainda existe e está publicado antes de renderizar
                    if ( get_post_status( $artigo_id ) === 'publish' ) : 
                        $titulo_artigo = get_the_title( $artigo_id );
                        $link_artigo   = get_permalink( $artigo_id );
                        $data_artigo   = get_the_date( '', $artigo_id );
                        ?>
                        <li>
                            <a href="<?php echo esc_url( $link_artigo ); ?>">
                                <?php echo esc_html( $titulo_artigo ); ?>
                            </a>
                            <span class="article-date">
                                (<?php echo esc_html( $data_artigo ); ?>)
                            </span>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
        </ul>
        </div>
    <?php endif; ?>


    <div class="author-posts-list">
        <h2>
            Todos os posts publicados por <?php echo esc_html(explode(' ', $author_data->display_name)[0]); ?>
        </h2>

        <?php if ( have_posts() ) : ?>
            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('mb-4'); ?>>
                        <header class="entry-header">
                            <h3 class="entry-title">
                                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                            </h3>
                            <div class="entry-meta text-muted">
                                <?php echo get_the_date(); ?>
                            </div>
                        </header>
                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <div class="posts-navigation">
                <?php the_posts_navigation(); ?>
            </div>

        <?php else : ?>
            <p>Este autor ainda não possui publicações.</p>
        <?php endif; ?>
    </div>

</main>

<?php
get_footer();