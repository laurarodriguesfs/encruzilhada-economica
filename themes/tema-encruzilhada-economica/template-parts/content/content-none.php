<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title">
            <?php 
            if ( is_search() ) {
                printf( esc_html__( 'Sem resultados para: %s', 'newspack' ), '<span>' . get_search_query() . '</span>' );
            } else {
                esc_html_e( 'Nada encontrado', 'newspack' );
            }
            ?>
        </h1>
    </header>

    <div class="page-content">
        <?php if ( is_search() || get_query_var('cat_filtrada') || get_query_var('autor_filtrado') ) : ?>

            <p>Lamentamos, mas não encontramos nenhum conteúdo que corresponda à sua busca ou aos filtros selecionados (Categoria/Autor).</p>
            
            <div class="search-form-retry">
                <p><strong>Tente uma nova combinação:</strong></p>
                <?php get_search_form(); // Isso carrega seu form centralizado com os selects ?>
            </div>

        <?php elseif ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <p><?php printf( wp_kses( __( 'Pronta para publicar seu primeiro post? <a href="%1$s">Comece aqui</a>.', 'newspack' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

        <?php else : ?>

            <p>Parece que não encontramos o que você procura.</p>

        <?php endif; ?>
    </div>
</section>