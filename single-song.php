<?php
/**
 * Single Song Template
 * 
 * Copy this file to your theme directory to customize how individual songs are displayed.
 * Place it in your theme's root folder as: single-song.php
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php
        while (have_posts()) : the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="song-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                
                <?php
                // Display all song details
                display_song_details();
                ?>
                
                <footer class="entry-footer">
                    <?php
                    // Optional: Add navigation to previous/next songs
                    the_post_navigation(array(
                        'prev_text' => '&larr; Previous Song',
                        'next_text' => 'Next Song &rarr;',
                    ));
                    ?>
                </footer>
                
            </article>
            
            <?php
        endwhile;
        ?>
        
    </main>
</div>

<?php
get_sidebar();
get_footer();
?>
