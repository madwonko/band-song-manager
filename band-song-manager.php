<?php
/**
 * Plugin Name: Band Song Manager
 * Plugin URI: https://wonkodev.com/plugins/band-song-manager
 * Description: A comprehensive song catalog management plugin for bands and musicians. Organize your repertoire, track performance history, and display your song list with key, tempo, tags, and ChordPro charts.
 * Version: 1.1.0
 * Author: MadWonko
 * Author URI: https://wonkodev.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: band-song-manager
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Type: Songs
 */
function bsm_register_song_post_type() {
    $labels = array(
        'name' => __('Songs', 'band-song-manager'),
        'singular_name' => __('Song', 'band-song-manager'),
        'add_new' => __('Add New Song', 'band-song-manager'),
        'add_new_item' => __('Add New Song', 'band-song-manager'),
        'edit_item' => __('Edit Song', 'band-song-manager'),
        'new_item' => __('New Song', 'band-song-manager'),
        'view_item' => __('View Song', 'band-song-manager'),
        'search_items' => __('Search Songs', 'band-song-manager'),
        'not_found' => __('No songs found', 'band-song-manager'),
        'not_found_in_trash' => __('No songs found in trash', 'band-song-manager'),
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-playlist-audio',
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'songs'),
        'show_in_rest' => true,
        'menu_position' => 20,
    );
    
    register_post_type('bsm_song', $args);
}
add_action('init', 'bsm_register_song_post_type');

/**
 * Register Taxonomies
 */
function bsm_register_taxonomies() {
    // Genre taxonomy
    register_taxonomy('bsm_genre', 'bsm_song', array(
        'label' => __('Genres', 'band-song-manager'),
        'rewrite' => array('slug' => 'genre'),
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));
    
    // Mood taxonomy
    register_taxonomy('bsm_mood', 'bsm_song', array(
        'label' => __('Moods', 'band-song-manager'),
        'rewrite' => array('slug' => 'mood'),
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));
    
    // Difficulty taxonomy
    register_taxonomy('bsm_difficulty', 'bsm_song', array(
        'label' => __('Difficulty', 'band-song-manager'),
        'rewrite' => array('slug' => 'difficulty'),
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));
    
    // General tags
    register_taxonomy('bsm_tag', 'bsm_song', array(
        'label' => __('Tags', 'band-song-manager'),
        'rewrite' => array('slug' => 'tag'),
        'hierarchical' => false,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));
}
add_action('init', 'bsm_register_taxonomies');

/**
 * Add Meta Boxes
 */
function bsm_add_meta_boxes() {
    // Song Details
    add_meta_box(
        'bsm_song_details',
        __('Song Details', 'band-song-manager'),
        'bsm_song_details_callback',
        'bsm_song',
        'normal',
        'high'
    );
    
    // ChordPro
    add_meta_box(
        'bsm_chordpro',
        __('ChordPro Chart', 'band-song-manager'),
        'bsm_chordpro_callback',
        'bsm_song',
        'normal',
        'high'
    );
    
    // Performance History
    add_meta_box(
        'bsm_performance_history',
        __('Performance History', 'band-song-manager'),
        'bsm_performance_history_callback',
        'bsm_song',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'bsm_add_meta_boxes');

/**
 * Song Details Meta Box Callback
 */
function bsm_song_details_callback($post) {
    wp_nonce_field('bsm_song_details_nonce', 'bsm_song_details_nonce');
    
    $artist = get_post_meta($post->ID, '_bsm_artist', true);
    $key = get_post_meta($post->ID, '_bsm_key', true);
    $tempo = get_post_meta($post->ID, '_bsm_tempo', true);
    $duration = get_post_meta($post->ID, '_bsm_duration', true);
    $original_artist = get_post_meta($post->ID, '_bsm_original_artist', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="bsm_artist"><?php _e('Artist/Band:', 'band-song-manager'); ?></label></th>
            <td>
                <input type="text" id="bsm_artist" name="bsm_artist" value="<?php echo esc_attr($artist); ?>" class="regular-text">
                <p class="description"><?php _e('Who performs this song (your band or the original artist)', 'band-song-manager'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="bsm_original_artist"><?php _e('Original Artist:', 'band-song-manager'); ?></label></th>
            <td>
                <input type="text" id="bsm_original_artist" name="bsm_original_artist" value="<?php echo esc_attr($original_artist); ?>" class="regular-text">
                <p class="description"><?php _e('Original artist (if this is a cover)', 'band-song-manager'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="bsm_key"><?php _e('Key:', 'band-song-manager'); ?></label></th>
            <td>
                <input type="text" id="bsm_key" name="bsm_key" value="<?php echo esc_attr($key); ?>" class="small-text" placeholder="C, Am, G#, etc.">
                <p class="description"><?php _e('Musical key (e.g., C, Am, G#, Bb)', 'band-song-manager'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="bsm_tempo"><?php _e('Tempo (BPM):', 'band-song-manager'); ?></label></th>
            <td>
                <input type="number" id="bsm_tempo" name="bsm_tempo" value="<?php echo esc_attr($tempo); ?>" class="small-text" min="0" max="300" placeholder="120">
                <p class="description"><?php _e('Beats per minute', 'band-song-manager'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="bsm_duration"><?php _e('Duration:', 'band-song-manager'); ?></label></th>
            <td>
                <input type="text" id="bsm_duration" name="bsm_duration" value="<?php echo esc_attr($duration); ?>" class="small-text" placeholder="3:45">
                <p class="description"><?php _e('Song length (e.g., 3:45, 4:12)', 'band-song-manager'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * ChordPro Meta Box Callback
 */
function bsm_chordpro_callback($post) {
    wp_nonce_field('bsm_chordpro_nonce', 'bsm_chordpro_nonce');
    
    $chordpro = get_post_meta($post->ID, '_bsm_chordpro', true);
    ?>
    <p>
        <label for="bsm_chordpro"><?php _e('ChordPro Format:', 'band-song-manager'); ?></label>
    </p>
    <textarea id="bsm_chordpro" name="bsm_chordpro" rows="15" class="large-text code" style="font-family: monospace;"><?php echo esc_textarea($chordpro); ?></textarea>
    <p class="description">
        <?php _e('Enter chords using ChordPro format. Example:', 'band-song-manager'); ?><br>
        <code>{title: Amazing Grace}<br>
{artist: Traditional}<br>
{key: G}<br>
<br>
[G]Amazing [G7]grace how [C]sweet the [G]sound<br>
That saved a [Em]wretch like [D]me[D7]<br>
[G]I once was [G7]lost but [C]now I'm [G]found<br>
Was [Em]blind but [D7]now I [G]see</code>
    </p>
    <p>
        <a href="#" id="bsm_print_chordpro" class="button button-secondary"><?php _e('Print ChordPro Chart', 'band-song-manager'); ?></a>
        <a href="#" id="bsm_preview_chordpro" class="button button-secondary"><?php _e('Preview ChordPro', 'band-song-manager'); ?></a>
    </p>
    
    <!-- Preview Modal -->
    <div id="bsm-chordpro-modal" style="display:none;">
        <div id="bsm-chordpro-preview"></div>
    </div>
    <?php
}

/**
 * Performance History Meta Box Callback
 */
function bsm_performance_history_callback($post) {
    wp_nonce_field('bsm_performance_nonce', 'bsm_performance_nonce');
    
    $performances = get_post_meta($post->ID, '_bsm_performances', true);
    if (!is_array($performances)) {
        $performances = array();
    }
    ?>
    <div id="bsm-performances">
        <?php foreach ($performances as $index => $performance) : ?>
            <div class="bsm-performance-item" style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd;">
                <p>
                    <label><?php _e('Date:', 'band-song-manager'); ?></label><br>
                    <input type="date" name="bsm_performance_date[]" value="<?php echo esc_attr($performance['date']); ?>" style="width: 100%;">
                </p>
                <p>
                    <label><?php _e('Venue:', 'band-song-manager'); ?></label><br>
                    <input type="text" name="bsm_performance_venue[]" value="<?php echo esc_attr($performance['venue']); ?>" style="width: 100%;">
                </p>
                <p>
                    <button type="button" class="button bsm-remove-performance"><?php _e('Remove', 'band-song-manager'); ?></button>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
    <p>
        <button type="button" id="bsm-add-performance" class="button button-secondary"><?php _e('Add Performance', 'band-song-manager'); ?></button>
    </p>
    <?php
}

/**
 * Save Meta Box Data
 */
function bsm_save_meta_boxes($post_id) {
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save song details
    if (isset($_POST['bsm_song_details_nonce']) && wp_verify_nonce($_POST['bsm_song_details_nonce'], 'bsm_song_details_nonce')) {
        if (isset($_POST['bsm_artist'])) {
            update_post_meta($post_id, '_bsm_artist', sanitize_text_field($_POST['bsm_artist']));
        }
        if (isset($_POST['bsm_original_artist'])) {
            update_post_meta($post_id, '_bsm_original_artist', sanitize_text_field($_POST['bsm_original_artist']));
        }
        if (isset($_POST['bsm_key'])) {
            update_post_meta($post_id, '_bsm_key', sanitize_text_field($_POST['bsm_key']));
        }
        if (isset($_POST['bsm_tempo'])) {
            update_post_meta($post_id, '_bsm_tempo', intval($_POST['bsm_tempo']));
        }
        if (isset($_POST['bsm_duration'])) {
            update_post_meta($post_id, '_bsm_duration', sanitize_text_field($_POST['bsm_duration']));
        }
    }
    
    // Save ChordPro
    if (isset($_POST['bsm_chordpro_nonce']) && wp_verify_nonce($_POST['bsm_chordpro_nonce'], 'bsm_chordpro_nonce')) {
        if (isset($_POST['bsm_chordpro'])) {
            update_post_meta($post_id, '_bsm_chordpro', wp_kses_post($_POST['bsm_chordpro']));
        }
    }
    
    // Save performance history
    if (isset($_POST['bsm_performance_nonce']) && wp_verify_nonce($_POST['bsm_performance_nonce'], 'bsm_performance_nonce')) {
        $performances = array();
        if (isset($_POST['bsm_performance_date']) && isset($_POST['bsm_performance_venue'])) {
            $dates = $_POST['bsm_performance_date'];
            $venues = $_POST['bsm_performance_venue'];
            
            for ($i = 0; $i < count($dates); $i++) {
                if (!empty($dates[$i]) || !empty($venues[$i])) {
                    $performances[] = array(
                        'date' => sanitize_text_field($dates[$i]),
                        'venue' => sanitize_text_field($venues[$i]),
                    );
                }
            }
        }
        update_post_meta($post_id, '_bsm_performances', $performances);
    }
}
add_action('save_post_bsm_song', 'bsm_save_meta_boxes');

/**
 * Enqueue Admin Scripts
 */
function bsm_enqueue_admin_scripts($hook) {
    global $post_type;
    
    if ($post_type == 'bsm_song') {
        wp_enqueue_style('bsm-admin-css', plugin_dir_url(__FILE__) . 'css/admin-style.css', array(), '1.1.0');
        wp_enqueue_script('bsm-admin-js', plugin_dir_url(__FILE__) . 'js/admin-script.js', array('jquery'), '1.1.0', true);
    }
}
add_action('admin_enqueue_scripts', 'bsm_enqueue_admin_scripts');

/**
 * Enqueue Frontend Scripts
 */
function bsm_enqueue_frontend_scripts() {
    wp_enqueue_style('bsm-frontend-css', plugin_dir_url(__FILE__) . 'css/frontend-style.css', array(), '1.1.0');
    wp_enqueue_script('bsm-frontend-js', plugin_dir_url(__FILE__) . 'js/frontend-script.js', array('jquery'), '1.1.0', true);
}
add_action('wp_enqueue_scripts', 'bsm_enqueue_frontend_scripts');

/**
 * Shortcode: [band_songs]
 */
function bsm_songs_shortcode($atts) {
    $atts = shortcode_atts(array(
        'genre' => '',
        'mood' => '',
        'difficulty' => '',
        'tag' => '',
        'key' => '',
        'limit' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ), $atts);
    
    $args = array(
        'post_type' => 'bsm_song',
        'posts_per_page' => intval($atts['limit']),
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
    );
    
    // Tax query
    $tax_query = array('relation' => 'AND');
    
    if (!empty($atts['genre'])) {
        $tax_query[] = array(
            'taxonomy' => 'bsm_genre',
            'field' => 'slug',
            'terms' => explode(',', $atts['genre']),
        );
    }
    
    if (!empty($atts['mood'])) {
        $tax_query[] = array(
            'taxonomy' => 'bsm_mood',
            'field' => 'slug',
            'terms' => explode(',', $atts['mood']),
        );
    }
    
    if (!empty($atts['difficulty'])) {
        $tax_query[] = array(
            'taxonomy' => 'bsm_difficulty',
            'field' => 'slug',
            'terms' => explode(',', $atts['difficulty']),
        );
    }
    
    if (!empty($atts['tag'])) {
        $tax_query[] = array(
            'taxonomy' => 'bsm_tag',
            'field' => 'slug',
            'terms' => explode(',', $atts['tag']),
        );
    }
    
    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }
    
    // Meta query for key
    if (!empty($atts['key'])) {
        $args['meta_query'] = array(
            array(
                'key' => '_bsm_key',
                'value' => $atts['key'],
                'compare' => '=',
            ),
        );
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    ?>
    <div class="bsm-song-list">
        <table class="bsm-table">
            <thead>
                <tr>
                    <th><?php _e('Title', 'band-song-manager'); ?></th>
                    <th><?php _e('Artist', 'band-song-manager'); ?></th>
                    <th><?php _e('Key', 'band-song-manager'); ?></th>
                    <th><?php _e('Tempo', 'band-song-manager'); ?></th>
                    <th><?php _e('Duration', 'band-song-manager'); ?></th>
                    <th><?php _e('Tags', 'band-song-manager'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $artist = get_post_meta(get_the_ID(), '_bsm_artist', true);
                        $key = get_post_meta(get_the_ID(), '_bsm_key', true);
                        $tempo = get_post_meta(get_the_ID(), '_bsm_tempo', true);
                        $duration = get_post_meta(get_the_ID(), '_bsm_duration', true);
                        $genres = get_the_terms(get_the_ID(), 'bsm_genre');
                        ?>
                        <tr>
                            <td><strong><?php the_title(); ?></strong></td>
                            <td><?php echo esc_html($artist); ?></td>
                            <td><?php echo esc_html($key); ?></td>
                            <td><?php echo $tempo ? esc_html($tempo) . ' BPM' : '-'; ?></td>
                            <td><?php echo esc_html($duration); ?></td>
                            <td>
                                <?php
                                if ($genres && !is_wp_error($genres)) {
                                    $genre_names = array();
                                    foreach ($genres as $genre) {
                                        $genre_names[] = $genre->name;
                                    }
                                    echo esc_html(implode(', ', $genre_names));
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <tr>
                        <td colspan="6"><?php _e('No songs found.', 'band-song-manager'); ?></td>
                    </tr>
                    <?php
                endif;
                ?>
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('band_songs', 'bsm_songs_shortcode');

/**
 * Print ChordPro AJAX Handler
 */
function bsm_print_chordpro() {
    check_ajax_referer('bsm_print_nonce', 'nonce');
    
    $post_id = intval($_POST['post_id']);
    $chordpro = get_post_meta($post_id, '_bsm_chordpro', true);
    $title = get_the_title($post_id);
    
    wp_send_json_success(array(
        'title' => $title,
        'chordpro' => $chordpro,
    ));
}
add_action('wp_ajax_bsm_print_chordpro', 'bsm_print_chordpro');