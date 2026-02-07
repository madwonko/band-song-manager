<?php
/**
 * Default Single Song Template
 * 
 * This template is used when the theme doesn't have its own single-song.php file.
 */

get_header(); ?>

<div id="primary" class="content-area" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
    <main id="main" class="site-main">
        
        <?php
        while (have_posts()) : the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <?php
                // Use the song_details shortcode to display everything
                echo do_shortcode('[song_details id="' . get_the_ID() . '"]');
                ?>
                
                <?php
                // Optional: Add navigation to previous/next songs
                the_post_navigation(array(
                    'prev_text' => '<span style="color: #2271b1;">←</span> Previous Song',
                    'next_text' => 'Next Song <span style="color: #2271b1;">→</span>',
                ));
                ?>
                
            </article>
            
            <?php
        endwhile;
        ?>
        
    </main>
</div>

<?php
get_footer();
?>
