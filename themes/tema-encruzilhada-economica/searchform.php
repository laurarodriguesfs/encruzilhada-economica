<?php
/**
 * Template for displaying search forms.
 *
 * @package Newspack
 */

$unique_id = wp_unique_id( 'search-form-' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    
    <div class="search-main-row">
        <span class="search-icon-especial">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
            </svg>
        </span>

        <input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-field" placeholder="Pesquisar..." value="<?php echo get_search_query(); ?>" name="s" />
        
        <button type="submit" class="search-submit">Buscar</button>
    </div>

    <?php if ( ( is_search() || is_page_template('search-archive.php') ) && !is_admin() && did_action('wp_body_open') ) : ?>

        <div class="search-filters-row">
            <div>
                <h3>Filtro por categoria</h3>
                <select name="cat_filtrada" onchange="this.form.submit()">
                    <option value="">Todas as categorias</option>
                    <?php 
                    foreach(get_categories() as $category) {
                        echo '<option value="'.$category->term_id.'" '.selected(get_query_var('cat_filtrada'), $category->term_id, false).'>'.$category->name.'</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <h3>Filtro por autor</h3>
                <select name="autor_filtrado" onchange="this.form.submit()">
                    <option value="">Todos os autores</option>
                    <?php 
                    foreach(get_users(['capability' => 'edit_posts']) as $user) {
                        echo '<option value="'.$user->ID.'" '.selected(get_query_var('autor_filtrado'), $user->ID, false).'>'.$user->display_name.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    <?php endif; ?>
</form>