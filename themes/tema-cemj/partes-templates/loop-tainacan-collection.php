<?php if(have_posts()): ?>
    <div class="tainacan-collection-grid">
        <?php while(have_posts()): the_post(); ?>
            <div class="tainacan-collection-item">
                <a class="tainacan-collection-item-link" href="<?php the_permalink(); ?>">
                    <h5 class="tainacan-collection-title text-black text-left p-3 mb-0 text-truncate"><?php the_title(); ?></h5>
                    <div class="tainacan-collection-thumbnail">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'collection-list-card') ?>" class="tainacan-collection-img" alt="">  
                        <?php else : ?>
                            <div class="image-placeholder">
                                <h4>
                                    <?php echo tainacan_get_initials(get_the_title()); ?>
                                </h4>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="tainacan-collection-description text-oslo-gray">
                        <?php if(get_the_excerpt()) : ?>
                            <p><?php echo wp_trim_words( get_the_excerpt(), 35, '[...]'); ?></p>
                        <?php else : ?>
                            <p style="font-style: italic;">Descrição não informada</p>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>Nada encontrado</p>
<?php endif; ?>
