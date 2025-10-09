<?php get_header('full'); ?>

<?php get_template_part( 'template-parts/menuBellowBanner' ); ?>
<section id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="row">
            <div class="col col-sm mx-sm-auto">
                <?php if(have_posts()): ?>
                    <?php do_action('tainacan-interface-single-item-top'); ?>
                    <?php while(have_posts()): the_post(); ?>
                        <div class="tainacan-title">
                            <div class="border-bottom border-jelly-bean tainacan-title-page">
                                <ul class="list-inline mb-1">
                                    <li class="list-inline-item text-midnight-blue font-weight-bold title-page">
                                        <h1><?php the_title(); ?></h1>
                                    </li>
                                    <li class="list-inline-item pull-right title-back"><a href="javascript:history.go(-1)">Voltar</a></li>
                                </ul>
                            </div>
                        </div>

                        <?php do_action('tainacan-interface-single-item-after-title'); ?>

                        <div class="tainacan-item-layout">

                            <div class="item-document-column">
                                <div class="mt-3 tainacan-single-post collection-single-item">
                                    <article role="article">
                                        <?php if (tainacan_has_document()): ?>
                                            <h3 class="title-content-items">Documento</h3>
                                            <section class="tainacan-content single-item-collection">
                                                <div class="single-item-collection--document">
                                                    <?php tainacan_the_document(); ?>
                                                </div>
                                            </section>
                                        <?php endif; ?>
                                    </article>
                                </div>
                            </div> <div class="item-information-column">

                                <?php
                                    $attachment = array_values( get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'numberposts'  => -1 ) ) );
                                ?>

                                <?php if ( !empty($attachment) ) : ?>
                                    <div class="mt-3 tainacan-single-post">
                                        <article role="article">
                                            <h3 class="title-content-items">Anexos</h3>
                                            <section class="tainacan-content single-item-collection">
                                                <div class="single-item-collection--attachments">
                                                    <?php foreach ( $attachment as $attach ) { ?>
                                                        <div class="single-item-collection--attachments-img">
                                                            <a href="<?php echo $attach->guid; ?>" target="_BLANK">
                                                                <?php echo wp_get_attachment_image( $attach->ID, 'tainacan-item-attachments' ); ?>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </section>
                                        </article>
                                    </div>
                                    <div class="tainacan-title my-5">
                                        <div class="border-bottom border-silver tainacan-title-page" style="border-width: 1px !important;"></div>
                                    </div>
                                <?php endif; ?>

                                <?php do_action('tainacan-interface-single-item-after-attachments'); ?>

                                <div class="mt-3 tainacan-single-post">
                                    <article role="article">
                                        <section class="tainacan-content single-item-collection">
                                            <div class="single-item-collection--information justify-content-center">
                                                <div class="s-item-collection--metadata">
                                                    <?php // Bloco de compartilhamento ?>
                                                    <div class="card border-0 my-3">
                                                        <div class="card-body bg-white border-0 pl-0 pt-0 pb-1">
                                                            <h3>Compartilhar</h3>
                                                            <div class="btn-group" role="group">
                                                                <?php if ( get_theme_mod( 'facebook_share', true ) ) : ?>
                                                                    <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="item-card-link--sharing" target="_blank" title="Compartilhar no Facebook">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v7.034C18.343 21.128 22 16.991 22 12z"></path></svg>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if ( get_theme_mod( 'twitter_share', true ) ) : ?>
                                                                    <a href="http://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=<?php the_title_attribute(); ?>" target="_blank" class="item-card-link--sharing" title="Compartilhar no Twitter">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.49-1.74.85-2.7 1.03A4.26 4.26 0 0 0 16.46 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.22-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21A12.07 12.07 0 0 0 20.38 8.82c0-.18 0-.37-.01-.56.84-.6 1.56-1.36 2.13-2.26z"></path></svg>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php do_action('tainacan-interface-single-item-metadata-begin'); ?>
                                                    <div class="metadata-grid-wrapper">
                                                        <?php
                                                        tainacan_the_metadata([
                                                            'before_title' => '<h3>', 'after_title' => '</h3>',
                                                            'before_value' => '<p>', 'after_value' => '</p>',
                                                            'before_each' => '<div class="metadata-grid-item"><div>', 'after_each' => '</div></div>',
                                                        ]);
                                                        ?>
                                                    </div>
                                                    <?php do_action('tainacan-interface-single-item-metadata-end'); ?>
                                                </div>
                                            </div>
                                        </section>
                                    </article>
                                </div>
                            </div> </div> <?php do_action('tainacan-interface-single-item-after-metadata'); ?>

                        <div class="tainacan-title my-5">
                            <div class="border-bottom border-silver tainacan-title-page" style="border-width: 1px !important;">
                            </div>
                        </div>
                        <div class="mt-3 tainacan-single-post">
                            <div class="row">
                                <div class="col mt-3 mx-auto">
                                    <?php
                                    if ( comments_open() || get_comments_number() ) :
                                        comments_template();
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php do_action('tainacan-interface-single-item-bottom'); ?>
                <?php else: ?>
                    Nada encontrado
                <?php endif; ?>
            </div>
        </div></main>
</section>
<?php get_footer('full'); ?>
<script>
    jQuery('#topNavbar').addClass('b-bottom-top');
    jQuery('nav.menu-belowheader').removeClass('border-bottom');
    jQuery('nav.menu-belowheader .max-large').addClass('b-bottom-bellow');
</script>