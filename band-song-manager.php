<?php
/**
 * Plugin Name: Band Song Manager
 * Plugin URI: https://wonkoworld.com/band-song-manager
 * Description: A comprehensive song catalog management plugin for bands and musicians. Organize your repertoire, track performance history, and display your song list to fans with customizable filtering and search capabilities.
 * Version: 1.0.0
 * Author: MadWonko
 * Author URI: https://wonkoworld.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: band-song-manager
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// ADD THE "VIEW DETAILS" CODE HERE
// ============================================

// Add custom plugin details link
add_filter('plugin_row_meta', 'bsm_add_details_link', 10, 2);
function bsm_add_details_link($links, $file) {
    if (plugin_basename(__FILE__) == $file) {
        $details_link = '<a href="' . admin_url('admin.php?page=bsm-details') . '">View Details</a>';
        $links[] = $details_link;
    }
    return $links;
}

// Add details page
add_action('admin_menu', 'bsm_add_details_page');
function bsm_add_details_page() {
    add_submenu_page(
        null, // No parent menu (hidden page)
        'Band Song Manager Details',
        'Details',
        'manage_options',
        'bsm-details',
        'bsm_render_details_page'
    );
}

// Render details page
function bsm_render_details_page() {
    ?>
    <div class="wrap">
        <h1>Band Song Manager</h1>
        <p><strong>Version:</strong> 1.0.0 | <strong>Author:</strong> MadWonko</p>
        
        <h2>Description</h2>
        <p>A comprehensive song catalog management plugin for bands and musicians. Organize your repertoire, track performance history, and display your song list to fans with customizable filtering and search capabilities.</p>
        
        <h2>Features</h2>
        <ul>
            <li>✓ Complete song catalog management (title, artist, key, tempo, duration)</li>
            <li>✓ Performance tracking with date and venue history</li>
            <li>✓ Tag-based categorization (genre, mood, difficulty, etc.)</li>
            <li>✓ Public song list display with search and filtering</li>
            <li>✓ Sortable columns (title, artist, key, tempo, duration)</li>
            <li>✓ Set list planning and organization</li>
            <li>✓ Custom fields support</li>
            <li>✓ Export capabilities (CSV, PDF)</li>
            <li>✓ Responsive design for mobile and desktop</li>
        </ul>
        
        <h2>Shortcode Usage</h2>
        <p><strong>Full Song List:</strong><br>
        <code>[band_songs]</code></p>
        
        <p><strong>Filtered by Tag:</strong><br>
        <code>[band_songs tag="rock"]</code></p>
        
        <p><strong>Show Specific Columns:</strong><br>
        <code>[band_songs columns="title,artist,key"]</code></p>
        
        <p><strong>Limit Number of Songs:</strong><br>
        <code>[band_songs limit="20"]</code></p>
        
        <h2>Configuration</h2>
        <p>Go to <strong>Settings → Band Song Manager</strong> to configure display options:</p>
        <ul>
            <li>Default visible columns</li>
            <li>Songs per page</li>
            <li>Enable/disable search</li>
            <li>Enable/disable filters</li>
            <li>Custom tag categories</li>
            <li>Date format preferences</li>
        </ul>
        
        <h2>Support</h2>
        <p>For support, visit <a href="https://wonkoworld.com" target="_blank">wonkoworld.com</a></p>
    </div>
    <?php
}

// ============================================
// END OF "VIEW DETAILS" CODE
// ============================================


// YOUR EXISTING PLUGIN CODE CONTINUES HERE...
// Define constants, classes, other functions, etc.

class BandSongManager {
    
    public function __construct() {
        add_action('init', array($this, 'register_song_post_type'));
        add_action('add_meta_boxes', array($this, 'add_song_meta_boxes'));
        add_action('save_post_song', array($this, 'save_song_meta'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_shortcode('song_chordpro', array($this, 'render_chordpro_shortcode'));
        add_shortcode('song_details', array($this, 'render_song_details_shortcode'));
        
        // Add custom columns to song list
        add_filter('manage_song_posts_columns', array($this, 'add_song_columns'));
        add_action('manage_song_posts_custom_column', array($this, 'render_song_columns'), 10, 2);
        add_filter('manage_edit-song_sortable_columns', array($this, 'song_sortable_columns'));
        
        // Template loading
        add_filter('single_template', array($this, 'load_song_template'));
        
        // ChordPro Import
        add_action('admin_menu', array($this, 'add_import_menu'));
        add_action('admin_post_import_chordpro', array($this, 'handle_import'));
    }
    
    /**
     * Load custom template for song post type
     */
    public function load_song_template($template) {
        global $post;
        
        if ($post->post_type == 'song') {
            // Check if theme has a single-song.php template
            $theme_file = locate_template(array('single-song.php'));
            
            if ($theme_file) {
                return $theme_file;
            } else {
                // Use plugin's default template
                $plugin_template = plugin_dir_path(__FILE__) . 'templates/single-song.php';
                if (file_exists($plugin_template)) {
                    return $plugin_template;
                }
            }
        }
        
        return $template;
    }
    
    /**
     * Register custom post type for songs
     */
    public function register_song_post_type() {
        $labels = array(
            'name'                  => 'Songs',
            'singular_name'         => 'Song',
            'menu_name'             => 'Band Songs',
            'name_admin_bar'        => 'Song',
            'add_new'               => 'Add New',
            'add_new_item'          => 'Add New Song',
            'new_item'              => 'New Song',
            'edit_item'             => 'Edit Song',
            'view_item'             => 'View Song',
            'all_items'             => 'All Songs',
            'search_items'          => 'Search Songs',
            'parent_item_colon'     => 'Parent Songs:',
            'not_found'             => 'No songs found.',
            'not_found_in_trash'    => 'No songs found in Trash.',
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'song'),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-format-audio',
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        );

        register_post_type('song', $args);
    }
    
    /**
     * Add meta boxes for song details
     */
    public function add_song_meta_boxes() {
        add_meta_box(
            'song_details',
            'Song Details',
            array($this, 'render_song_details_meta_box'),
            'song',
            'normal',
            'high'
        );
    }
    
    /**
     * Render the song details meta box
     */
    public function render_song_details_meta_box($post) {
        wp_nonce_field('song_details_nonce', 'song_details_nonce_field');
        
        $author_composer = get_post_meta($post->ID, '_song_author_composer', true);
        $year_publication = get_post_meta($post->ID, '_song_year_publication', true);
        $original_url = get_post_meta($post->ID, '_song_original_url', true);
        $rehearsal_url = get_post_meta($post->ID, '_song_rehearsal_url', true);
        $tabs_notes = get_post_meta($post->ID, '_song_tabs_notes', true);
        $gear_notes = get_post_meta($post->ID, '_song_gear_notes', true);
        $chordpro = get_post_meta($post->ID, '_song_chordpro', true);
        ?>
        
        <div class="song-details-fields">
            <?php if ($post->ID): ?>
            <div class="song-id-display">
                <strong>Song ID:</strong> 
                <span class="song-id-number"><?php echo $post->ID; ?></span>
                <button type="button" class="button button-small copy-id-btn" onclick="copySongId(<?php echo $post->ID; ?>)">Copy ID</button>
                <span class="copy-feedback" style="display:none; color: green; margin-left: 10px;">✓ Copied!</span>
            </div>
            <hr style="margin: 15px 0;">
            <?php endif; ?>
            <p>
                <label for="song_author_composer"><strong>Author / Composer</strong></label><br>
                <input type="text" id="song_author_composer" name="song_author_composer" 
                       value="<?php echo esc_attr($author_composer); ?>" style="width: 100%;">
            </p>
            
            <p>
                <label for="song_year_publication"><strong>Year of Publication</strong></label><br>
                <input type="text" id="song_year_publication" name="song_year_publication" 
                       value="<?php echo esc_attr($year_publication); ?>" style="width: 200px;">
            </p>
            
            <p>
                <label for="song_original_url"><strong>Original Recording URL</strong></label><br>
                <input type="url" id="song_original_url" name="song_original_url" 
                       value="<?php echo esc_url($original_url); ?>" placeholder="https://..." style="width: 100%;">
            </p>
            
            <p>
                <label for="song_rehearsal_url"><strong>Rehearsal Recording URL</strong></label><br>
                <input type="url" id="song_rehearsal_url" name="song_rehearsal_url" 
                       value="<?php echo esc_url($rehearsal_url); ?>" placeholder="https://..." style="width: 100%;">
            </p>
            
            <p>
                <label for="song_tabs_notes"><strong>Tabs / Charts / Notes</strong></label><br>
                <textarea id="song_tabs_notes" name="song_tabs_notes" rows="8" 
                          style="width: 100%;"><?php echo esc_textarea($tabs_notes); ?></textarea>
            </p>
            
            <p>
                <label for="song_gear_notes"><strong>Pedalboard / Gear Notes</strong></label><br>
                <textarea id="song_gear_notes" name="song_gear_notes" rows="6" 
                          style="width: 100%;"><?php echo esc_textarea($gear_notes); ?></textarea>
            </p>
            
            <p>
                <label for="song_chordpro"><strong>ChordPro Chart (optional)</strong></label><br>
                <small>Enter ChordPro text here. A "View Chart" button will appear on the front-end.</small><br>
                <small>Example format: {title: Song Title}<br>{artist: Artist}<br>[C]Hello [G]world ...</small><br>
                <textarea id="song_chordpro" name="song_chordpro" rows="10" 
                          style="width: 100%; font-family: monospace;"><?php echo esc_textarea($chordpro); ?></textarea>
            </p>
        </div>
        
        <style>
            .song-details-fields p {
                margin-bottom: 15px;
            }
            .song-details-fields label {
                display: block;
                margin-bottom: 5px;
            }
            .song-id-display {
                background: #f0f6fc;
                border: 2px solid #0073aa;
                border-radius: 5px;
                padding: 12px 15px;
                margin-bottom: 15px;
            }
            .song-id-display strong {
                color: #0073aa;
                font-size: 14px;
            }
            .song-id-number {
                font-size: 18px;
                font-weight: bold;
                color: #333;
                margin: 0 10px;
            }
            .copy-id-btn {
                vertical-align: middle;
            }
        </style>
        <script>
        function copySongId(id) {
            navigator.clipboard.writeText(id).then(function() {
                var feedback = document.querySelector('.copy-feedback');
                feedback.style.display = 'inline';
                setTimeout(function() {
                    feedback.style.display = 'none';
                }, 2000);
            });
        }
        </script>
        <?php
    }
    
    /**
     * Save song meta data
     */
    public function save_song_meta($post_id) {
        // Check nonce
        if (!isset($_POST['song_details_nonce_field']) || 
            !wp_verify_nonce($_POST['song_details_nonce_field'], 'song_details_nonce')) {
            return;
        }
        
        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save fields
        $fields = array(
            'song_author_composer' => '_song_author_composer',
            'song_year_publication' => '_song_year_publication',
            'song_original_url' => '_song_original_url',
            'song_rehearsal_url' => '_song_rehearsal_url',
            'song_tabs_notes' => '_song_tabs_notes',
            'song_gear_notes' => '_song_gear_notes',
            'song_chordpro' => '_song_chordpro',
        );
        
        foreach ($fields as $field_name => $meta_key) {
            if (isset($_POST[$field_name])) {
                $value = $_POST[$field_name];
                
                // Sanitize based on field type
                if (strpos($field_name, 'url') !== false) {
                    $value = esc_url_raw($value);
                } else {
                    $value = sanitize_textarea_field($value);
                }
                
                update_post_meta($post_id, $meta_key, $value);
            }
        }
    }
    
    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_frontend_scripts() {
        if (is_singular('song')) {
            wp_enqueue_style('band-song-style', plugin_dir_url(__FILE__) . 'css/song-style.css', array(), '1.0.0');
            wp_enqueue_script('band-song-script', plugin_dir_url(__FILE__) . 'js/song-script.js', array('jquery'), '1.0.0', true);
        }
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        global $post_type;
        if (($hook == 'post.php' || $hook == 'post-new.php') && $post_type == 'song') {
            wp_enqueue_style('band-song-admin-style', plugin_dir_url(__FILE__) . 'css/admin-style.css', array(), '1.0.0');
        }
    }
    
    /**
     * Parse and render ChordPro format
     */
    private function render_chordpro($chordpro_text) {
        $lines = explode("\n", $chordpro_text);
        $output = '';
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Handle directives like {title:...}, {artist:...}, etc.
            if (preg_match('/^\{(title|t|subtitle|st|artist|composer|key|time|tempo|capo|comment|c):\s*(.+?)\}\s*$/i', $line, $matches)) {
                $directive = strtolower($matches[1]);
                $value = trim($matches[2]);
                
                if (in_array($directive, ['title', 't'])) {
                    $output .= '<div style="font-size: 20px; font-weight: bold; color: #2271b1; margin-bottom: 5px;">' . esc_html($value) . '</div>';
                } elseif (in_array($directive, ['subtitle', 'st', 'artist', 'composer'])) {
                    $output .= '<div style="font-size: 16px; color: #666; margin-bottom: 10px;">' . esc_html($value) . '</div>';
                } elseif (in_array($directive, ['key', 'time', 'tempo', 'capo'])) {
                    $output .= '<div style="font-size: 14px; color: #444; font-style: italic; margin-bottom: 5px;">' . ucfirst($directive) . ': ' . esc_html($value) . '</div>';
                } elseif (in_array($directive, ['comment', 'c'])) {
                    $output .= '<div style="font-size: 14px; color: #d63638; font-weight: bold; margin: 15px 0 5px 0;">[' . esc_html($value) . ']</div>';
                }
                continue;
            }
            
            // Skip other directive types
            if (preg_match('/^\{.+\}$/', $line)) {
                continue;
            }
            
            // Handle lines with chords [Am], [G], etc.
            if (preg_match('/\[([^\]]+)\]/', $line)) {
                // Process the line to create inline chord/lyric display
                $processed_line = '';
                $position = 0;
                
                // Find all chord positions
                preg_match_all('/\[([^\]]+)\]/', $line, $matches, PREG_OFFSET_CAPTURE);
                
                foreach ($matches[0] as $i => $match) {
                    $full_chord = $match[0]; // e.g., "[Am]"
                    $chord = $matches[1][$i][0]; // e.g., "Am"
                    $chord_pos = $match[1];
                    
                    // Add any lyrics before this chord
                    if ($chord_pos > $position) {
                        $lyrics_before = substr($line, $position, $chord_pos - $position);
                        $processed_line .= '<span style="display: inline-block;">' . esc_html($lyrics_before) . '</span>';
                    }
                    
                    // Get the lyrics after this chord (until the next chord or end of line)
                    $next_chord_pos = isset($matches[0][$i + 1]) ? $matches[0][$i + 1][1] : strlen($line);
                    $lyrics_after_chord_start = $chord_pos + strlen($full_chord);
                    $lyrics_after = substr($line, $lyrics_after_chord_start, $next_chord_pos - $lyrics_after_chord_start);
                    
                    // Create a container with chord above lyrics
                    $processed_line .= '<span style="display: inline-block; position: relative; padding-top: 18px;">';
                    $processed_line .= '<span style="position: absolute; top: 0; left: 0; color: #2271b1; font-weight: bold; font-size: 12px; white-space: nowrap;">' . esc_html($chord) . '</span>';
                    $processed_line .= '<span>' . esc_html($lyrics_after) . '</span>';
                    $processed_line .= '</span>';
                    
                    $position = $next_chord_pos;
                }
                
                $output .= '<div style="font-family: monospace; margin-bottom: 5px; line-height: 1.4;">' . $processed_line . '</div>';
            } else {
                // Regular line without chords
                if (trim($line) === '') {
                    $output .= '<div style="height: 10px;"></div>';
                } else {
                    $output .= '<div style="font-family: monospace; margin-bottom: 5px;">' . esc_html($line) . '</div>';
                }
            }
        }
        
        return $output;
    }
    
    /**
     * Shortcode to display ChordPro chart
     */
    public function render_chordpro_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => get_the_ID(),
        ), $atts);
        
        $chordpro = get_post_meta($atts['id'], '_song_chordpro', true);
        
        // Debug: If no chordpro content, show a message for admins
        if (empty($chordpro)) {
            if (current_user_can('edit_posts')) {
                return '<div style="padding: 15px; background: #fff3cd; border: 2px solid #ffc107; border-radius: 5px; color: #856404;">
                    <strong>⚠️ No ChordPro Chart:</strong> This song (ID: ' . $atts['id'] . ') doesn\'t have any ChordPro content yet. 
                    <a href="' . get_edit_post_link($atts['id']) . '" style="color: #0073aa;">Edit the song</a> to add ChordPro chart data.
                </div>';
            }
            return '';
        }
        
        // Generate unique ID for this chart
        $unique_id = 'chordpro-' . uniqid();
        
        ob_start();
        ?>
        <div class="chordpro-chart" style="margin: 20px 0; clear: both;">
            <button id="<?php echo $unique_id; ?>-btn" class="view-chart-btn" style="
                background: #2271b1 !important;
                color: #fff !important;
                border: 2px solid #2271b1 !important;
                padding: 12px 24px !important;
                border-radius: 6px !important;
                cursor: pointer !important;
                font-size: 15px !important;
                font-weight: 600 !important;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                outline: none;
            ">🎵 View Chart</button>
            <div id="<?php echo $unique_id; ?>-content" class="chordpro-content" style="display: none; margin-top: 15px;">
                <div class="chordpro-text" style="
                    background: #ffffff !important;
                    border: 2px solid #8c8f94 !important;
                    border-radius: 5px !important;
                    padding: 20px !important;
                    font-size: 14px !important;
                    line-height: 1.8 !important;
                    color: #1e1e1e !important;
                "><?php echo $this->render_chordpro($chordpro); ?></div>
            </div>
        </div>
        <script type="text/javascript">
        (function() {
            var btn = document.getElementById('<?php echo $unique_id; ?>-btn');
            var content = document.getElementById('<?php echo $unique_id; ?>-content');
            
            if (btn && content) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (content.style.display === 'none' || content.style.display === '') {
                        content.style.display = 'block';
                        btn.innerHTML = '🎵 Hide Chart';
                        btn.style.background = '#d63638 !important';
                        btn.style.borderColor = '#d63638 !important';
                    } else {
                        content.style.display = 'none';
                        btn.innerHTML = '🎵 View Chart';
                        btn.style.background = '#2271b1 !important';
                        btn.style.borderColor = '#2271b1 !important';
                    }
                });
            }
        })();
        </script>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Shortcode to display complete song details
     * Usage: [song_details id="123"]
     */
    public function render_song_details_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => get_the_ID(),
        ), $atts);
        
        $post_id = intval($atts['id']);
        
        // Check if post exists and is a song
        $post = get_post($post_id);
        if (!$post || $post->post_type !== 'song') {
            if (current_user_can('edit_posts')) {
                return '<div style="padding: 15px; background: #f8d7da; border: 2px solid #dc3545; border-radius: 5px; color: #721c24;">
                    <strong>❌ Error:</strong> Song ID ' . $post_id . ' not found or is not a valid song.
                </div>';
            }
            return '';
        }
        
        // Get all meta data
        $author_composer = get_post_meta($post_id, '_song_author_composer', true);
        $year_publication = get_post_meta($post_id, '_song_year_publication', true);
        $original_url = get_post_meta($post_id, '_song_original_url', true);
        $rehearsal_url = get_post_meta($post_id, '_song_rehearsal_url', true);
        $tabs_notes = get_post_meta($post_id, '_song_tabs_notes', true);
        $gear_notes = get_post_meta($post_id, '_song_gear_notes', true);
        $chordpro = get_post_meta($post_id, '_song_chordpro', true);
        
        ob_start();
        ?>
        <div class="song-details-display" style="
            background: #ffffff !important;
            border: 2px solid #ddd !important;
            border-radius: 8px !important;
            padding: 25px !important;
            margin: 20px 0 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        ">
            <h2 style="margin-top: 0; color: #2271b1; border-bottom: 3px solid #2271b1; padding-bottom: 10px;">
                <?php echo esc_html(get_the_title($post_id)); ?>
            </h2>
            
            <?php 
            // Display main post content (song lyrics/text)
            $content = $post->post_content;
            if (!empty($content)): 
            ?>
                <div class="song-main-content" style="
                    margin-bottom: 25px; 
                    padding: 20px;
                    padding-bottom: 20px; 
                    border-bottom: 2px solid #e0e0e0; 
                    font-size: 15px; 
                    line-height: 1.8;
                    background: #f9f9f9;
                    border-radius: 5px;
                    white-space: pre-wrap;
                    font-family: inherit;
                ">
                    <?php echo nl2br(esc_html($content)); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($author_composer): ?>
                <div class="song-field" style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
                    <strong style="display: block; color: #2271b1; font-size: 13px; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">
                        🎼 Author / Composer
                    </strong>
                    <div style="font-size: 16px; color: #333;">
                        <?php echo esc_html($author_composer); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($year_publication): ?>
                <div class="song-field" style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
                    <strong style="display: block; color: #2271b1; font-size: 13px; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">
                        📅 Year of Publication
                    </strong>
                    <div style="font-size: 16px; color: #333;">
                        <?php echo esc_html($year_publication); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($original_url): ?>
                <div class="song-field" style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
                    <strong style="display: block; color: #2271b1; font-size: 13px; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">
                        🎵 Original Recording
                    </strong>
                    <div style="font-size: 16px;">
                        <a href="<?php echo esc_url($original_url); ?>" target="_blank" rel="noopener" style="color: #2271b1; text-decoration: none; font-weight: 600;">
                            Listen to Original →
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($rehearsal_url): ?>
                <div class="song-field" style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
                    <strong style="display: block; color: #2271b1; font-size: 13px; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">
                        🎤 Rehearsal Recording
                    </strong>
                    <div style="font-size: 16px;">
                        <a href="<?php echo esc_url($rehearsal_url); ?>" target="_blank" rel="noopener" style="color: #2271b1; text-decoration: none; font-weight: 600;">
                            Listen to Rehearsal →
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($tabs_notes): ?>
                <?php $tabs_id = 'tabs-' . uniqid(); ?>
                <div class="song-field" style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
                    <strong style="display: block; color: #2271b1; font-size: 13px; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">
                        📝 Tabs / Charts / Notes
                    </strong>
                    <button id="<?php echo $tabs_id; ?>-btn" style="
                        background: #50575e !important;
                        color: #fff !important;
                        border: 2px solid #50575e !important;
                        padding: 10px 20px !important;
                        border-radius: 6px !important;
                        cursor: pointer !important;
                        font-size: 14px !important;
                        font-weight: 600 !important;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        outline: none;
                        margin-bottom: 10px;
                    ">📄 View Tabs/Notes</button>
                    <div id="<?php echo $tabs_id; ?>-content" style="display: none; margin-top: 10px;">
                        <pre style="
                            background: #f5f5f5 !important;
                            border: 1px solid #ddd !important;
                            border-radius: 5px !important;
                            padding: 15px !important;
                            margin-top: 8px !important;
                            font-family: 'Courier New', Courier, monospace !important;
                            font-size: 13px !important;
                            line-height: 1.6 !important;
                            white-space: pre-wrap !important;
                            word-wrap: break-word !important;
                            overflow-x: auto !important;
                            color: #333 !important;
                        "><?php echo esc_html($tabs_notes); ?></pre>
                    </div>
                </div>
                <script type="text/javascript">
                (function() {
                    var btn = document.getElementById('<?php echo $tabs_id; ?>-btn');
                    var content = document.getElementById('<?php echo $tabs_id; ?>-content');
                    
                    if (btn && content) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            if (content.style.display === 'none' || content.style.display === '') {
                                content.style.display = 'block';
                                btn.innerHTML = '📄 Hide Tabs/Notes';
                                btn.style.background = '#d63638 !important';
                                btn.style.borderColor = '#d63638 !important';
                            } else {
                                content.style.display = 'none';
                                btn.innerHTML = '📄 View Tabs/Notes';
                                btn.style.background = '#50575e !important';
                                btn.style.borderColor = '#50575e !important';
                            }
                        });
                    }
                })();
                </script>
            <?php endif; ?>
            
            <?php if ($gear_notes): ?>
                <?php $gear_id = 'gear-' . uniqid(); ?>
                <div class="song-field" style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
                    <strong style="display: block; color: #2271b1; font-size: 13px; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">
                        🎸 Pedalboard / Gear Notes
                    </strong>
                    <button id="<?php echo $gear_id; ?>-btn" style="
                        background: #50575e !important;
                        color: #fff !important;
                        border: 2px solid #50575e !important;
                        padding: 10px 20px !important;
                        border-radius: 6px !important;
                        cursor: pointer !important;
                        font-size: 14px !important;
                        font-weight: 600 !important;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        outline: none;
                        margin-bottom: 10px;
                    ">🎸 View Gear Notes</button>
                    <div id="<?php echo $gear_id; ?>-content" style="display: none; margin-top: 10px;">
                        <pre style="
                            background: #f5f5f5 !important;
                            border: 1px solid #ddd !important;
                            border-radius: 5px !important;
                            padding: 15px !important;
                            margin-top: 8px !important;
                            font-family: 'Courier New', Courier, monospace !important;
                            font-size: 13px !important;
                            line-height: 1.6 !important;
                            white-space: pre-wrap !important;
                            word-wrap: break-word !important;
                            overflow-x: auto !important;
                            color: #333 !important;
                        "><?php echo esc_html($gear_notes); ?></pre>
                    </div>
                </div>
                <script type="text/javascript">
                (function() {
                    var btn = document.getElementById('<?php echo $gear_id; ?>-btn');
                    var content = document.getElementById('<?php echo $gear_id; ?>-content');
                    
                    if (btn && content) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            if (content.style.display === 'none' || content.style.display === '') {
                                content.style.display = 'block';
                                btn.innerHTML = '🎸 Hide Gear Notes';
                                btn.style.background = '#d63638 !important';
                                btn.style.borderColor = '#d63638 !important';
                            } else {
                                content.style.display = 'none';
                                btn.innerHTML = '🎸 View Gear Notes';
                                btn.style.background = '#50575e !important';
                                btn.style.borderColor = '#50575e !important';
                            }
                        });
                    }
                })();
                </script>
            <?php endif; ?>
            
            <?php if ($chordpro): ?>
                <div class="song-field" style="margin-bottom: 0;">
                    <strong style="display: block; color: #2271b1; font-size: 13px; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">
                        🎼 ChordPro Chart
                    </strong>
                    <?php echo do_shortcode('[song_chordpro id="' . $post_id . '"]'); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Add custom columns to song list
     */
    public function add_song_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['song_id'] = 'ID';
        $new_columns['title'] = $columns['title'];
        $new_columns['author_composer'] = 'Author/Composer';
        $new_columns['year'] = 'Year';
        $new_columns['date'] = $columns['date'];
        return $new_columns;
    }
    
    /**
     * Render custom column content
     */
    public function render_song_columns($column, $post_id) {
        switch ($column) {
            case 'song_id':
                echo '<strong>' . $post_id . '</strong>';
                break;
            case 'author_composer':
                $author = get_post_meta($post_id, '_song_author_composer', true);
                echo $author ? esc_html($author) : '—';
                break;
            case 'year':
                $year = get_post_meta($post_id, '_song_year_publication', true);
                echo $year ? esc_html($year) : '—';
                break;
        }
    }
    
    /**
     * Make custom columns sortable
     */
    public function song_sortable_columns($columns) {
        $columns['song_id'] = 'ID';
        $columns['year'] = 'year';
        return $columns;
    }
    
    /**
     * Add import menu page
     */
    public function add_import_menu() {
        add_submenu_page(
            'edit.php?post_type=song',
            'Import ChordPro Files',
            'Import ChordPro',
            'manage_options',
            'import-chordpro',
            array($this, 'render_import_page')
        );
    }
    
    /**
     * Render the import page
     */
    public function render_import_page() {
        ?>
        <div class="wrap">
            <h1>Import ChordPro Files</h1>
            
            <?php if (isset($_GET['imported'])): ?>
                <div class="notice notice-success is-dismissible">
                    <p><strong>Success!</strong> Imported <?php echo intval($_GET['imported']); ?> song(s).</p>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="notice notice-error is-dismissible">
                    <p><strong>Error:</strong> <?php echo esc_html(urldecode($_GET['error'])); ?></p>
                </div>
            <?php endif; ?>
            
            <div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 5px; max-width: 800px; margin-top: 20px;">
                
                <h2>Single File Import</h2>
                <p>Upload a single ChordPro file (.cho, .chopro, .txt, or .pro)</p>
                
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="import_chordpro">
                    <input type="hidden" name="import_type" value="single">
                    <?php wp_nonce_field('import_chordpro', 'import_nonce'); ?>
                    
                    <p>
                        <input type="file" name="chordpro_file" accept=".cho,.chopro,.txt,.pro" required>
                    </p>
                    
                    <p>
                        <label>
                            <input type="checkbox" name="publish_immediately" value="1">
                            Publish immediately (otherwise save as draft)
                        </label>
                    </p>
                    
                    <p>
                        <button type="submit" class="button button-primary">Import Single File</button>
                    </p>
                </form>
                
                <hr style="margin: 30px 0;">
                
                <h2>Bulk Import</h2>
                <p>Upload multiple ChordPro files at once (up to 20 files)</p>
                
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="import_chordpro">
                    <input type="hidden" name="import_type" value="bulk">
                    <?php wp_nonce_field('import_chordpro', 'import_nonce'); ?>
                    
                    <p>
                        <input type="file" name="chordpro_files[]" accept=".cho,.chopro,.txt,.pro" multiple required>
                    </p>
                    
                    <p>
                        <label>
                            <input type="checkbox" name="publish_immediately" value="1">
                            Publish all immediately (otherwise save as drafts)
                        </label>
                    </p>
                    
                    <p>
                        <button type="submit" class="button button-primary">Import Multiple Files</button>
                    </p>
                </form>
                
                <hr style="margin: 30px 0;">
                
                <h3>ChordPro Format Info</h3>
                <p>The importer will extract:</p>
                <ul style="list-style: disc; margin-left: 20px;">
                    <li><strong>Title:</strong> from {title:...} or {t:...}</li>
                    <li><strong>Artist/Composer:</strong> from {artist:...} or {composer:...}</li>
                    <li><strong>Year:</strong> from {year:...}</li>
                    <li><strong>Key, Tempo, Capo:</strong> Added to ChordPro content</li>
                    <li><strong>Lyrics:</strong> Extracted without chords for main content</li>
                    <li><strong>Full ChordPro:</strong> Saved in ChordPro Chart field</li>
                </ul>
                
                <p><em>After import, you can edit the songs to add URLs, tabs, and gear notes.</em></p>
            </div>
        </div>
        <?php
    }
    
    /**
     * Handle ChordPro import
     */
    public function handle_import() {
        // Check nonce
        if (!isset($_POST['import_nonce']) || !wp_verify_nonce($_POST['import_nonce'], 'import_chordpro')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to import files');
        }
        
        $import_type = $_POST['import_type'];
        $publish_immediately = isset($_POST['publish_immediately']);
        $imported_count = 0;
        
        try {
            if ($import_type === 'single') {
                // Single file import
                if (isset($_FILES['chordpro_file']) && $_FILES['chordpro_file']['error'] === UPLOAD_ERR_OK) {
                    $this->import_chordpro_file($_FILES['chordpro_file']['tmp_name'], $_FILES['chordpro_file']['name'], $publish_immediately);
                    $imported_count = 1;
                }
            } else {
                // Bulk import
                if (isset($_FILES['chordpro_files'])) {
                    $files = $_FILES['chordpro_files'];
                    $file_count = count($files['name']);
                    
                    for ($i = 0; $i < min($file_count, 20); $i++) {
                        if ($files['error'][$i] === UPLOAD_ERR_OK) {
                            $this->import_chordpro_file($files['tmp_name'][$i], $files['name'][$i], $publish_immediately);
                            $imported_count++;
                        }
                    }
                }
            }
            
            wp_redirect(admin_url('edit.php?post_type=song&page=import-chordpro&imported=' . $imported_count));
            exit;
            
        } catch (Exception $e) {
            wp_redirect(admin_url('edit.php?post_type=song&page=import-chordpro&error=' . urlencode($e->getMessage())));
            exit;
        }
    }
    
    /**
     * Import a single ChordPro file
     */
    private function import_chordpro_file($file_path, $file_name, $publish = false) {
        $content = file_get_contents($file_path);
        
        if ($content === false) {
            throw new Exception('Could not read file: ' . $file_name);
        }
        
        // Parse ChordPro content
        $parsed = $this->parse_chordpro_import($content);
        
        // Create post
        $post_data = array(
            'post_title'    => $parsed['title'] ?: sanitize_text_field(pathinfo($file_name, PATHINFO_FILENAME)),
            'post_content'  => $parsed['lyrics'],
            'post_type'     => 'song',
            'post_status'   => $publish ? 'publish' : 'draft',
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (is_wp_error($post_id)) {
            throw new Exception('Failed to create post: ' . $post_id->get_error_message());
        }
        
        // Save meta data
        if ($parsed['artist']) {
            update_post_meta($post_id, '_song_author_composer', $parsed['artist']);
        }
        
        if ($parsed['year']) {
            update_post_meta($post_id, '_song_year_publication', $parsed['year']);
        }
        
        // Save full ChordPro content
        update_post_meta($post_id, '_song_chordpro', $content);
        
        return $post_id;
    }
    
    /**
     * Parse ChordPro content for import
     */
    private function parse_chordpro_import($content) {
        $lines = explode("\n", $content);
        $title = '';
        $artist = '';
        $year = '';
        $lyrics = '';
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Extract title
            if (preg_match('/^\{(title|t):\s*(.+?)\}\s*$/i', $line, $matches)) {
                $title = trim($matches[2]);
                continue;
            }
            
            // Extract artist/composer
            if (preg_match('/^\{(artist|composer|st|subtitle):\s*(.+?)\}\s*$/i', $line, $matches)) {
                if (!$artist) { // Use first one found
                    $artist = trim($matches[2]);
                }
                continue;
            }
            
            // Extract year
            if (preg_match('/^\{year:\s*(.+?)\}\s*$/i', $line, $matches)) {
                $year = trim($matches[1]);
                continue;
            }
            
            // Skip other directives (key, tempo, etc.)
            if (preg_match('/^\{.+\}$/', $line)) {
                continue;
            }
            
            // Extract lyrics (remove chords)
            if (!empty($line)) {
                // Remove chord annotations [Am], [G7], etc.
                $lyric_line = preg_replace('/\[[^\]]+\]/', '', $line);
                $lyric_line = trim($lyric_line);
                
                if (!empty($lyric_line)) {
                    $lyrics .= $lyric_line . "\n";
                } else {
                    // Keep blank lines for spacing
                    $lyrics .= "\n";
                }
            } else {
                $lyrics .= "\n";
            }
        }
        
        return array(
            'title'  => $title,
            'artist' => $artist,
            'year'   => $year,
            'lyrics' => trim($lyrics),
        );
    }
}

// Initialize the plugin
new BandSongManager();

// Activation hook to flush rewrite rules
register_activation_hook(__FILE__, 'band_song_manager_activate');
function band_song_manager_activate() {
    // Register the post type
    $plugin = new BandSongManager();
    $plugin->register_song_post_type();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

/**
 * Template function to display song details
 */
function display_song_details($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $author_composer = get_post_meta($post_id, '_song_author_composer', true);
    $year_publication = get_post_meta($post_id, '_song_year_publication', true);
    $original_url = get_post_meta($post_id, '_song_original_url', true);
    $rehearsal_url = get_post_meta($post_id, '_song_rehearsal_url', true);
    $tabs_notes = get_post_meta($post_id, '_song_tabs_notes', true);
    $gear_notes = get_post_meta($post_id, '_song_gear_notes', true);
    $chordpro = get_post_meta($post_id, '_song_chordpro', true);
    ?>
    
    <div class="song-details-display">
        <?php if ($author_composer): ?>
            <div class="song-field">
                <strong>Author / Composer:</strong> <?php echo esc_html($author_composer); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($year_publication): ?>
            <div class="song-field">
                <strong>Year:</strong> <?php echo esc_html($year_publication); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($original_url): ?>
            <div class="song-field">
                <strong>Original Recording:</strong> 
                <a href="<?php echo esc_url($original_url); ?>" target="_blank" rel="noopener">Listen</a>
            </div>
        <?php endif; ?>
        
        <?php if ($rehearsal_url): ?>
            <div class="song-field">
                <strong>Rehearsal Recording:</strong> 
                <a href="<?php echo esc_url($rehearsal_url); ?>" target="_blank" rel="noopener">Listen</a>
            </div>
        <?php endif; ?>
        
        <?php if ($tabs_notes): ?>
            <div class="song-field">
                <strong>Tabs / Charts / Notes:</strong>
                <pre class="song-tabs"><?php echo esc_html($tabs_notes); ?></pre>
            </div>
        <?php endif; ?>
        
        <?php if ($gear_notes): ?>
            <div class="song-field">
                <strong>Pedalboard / Gear Notes:</strong>
                <pre class="song-gear"><?php echo esc_html($gear_notes); ?></pre>
            </div>
        <?php endif; ?>
        
        <?php if ($chordpro): ?>
            <div class="song-field">
                <?php echo do_shortcode('[song_chordpro id="' . $post_id . '"]'); ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php
}
