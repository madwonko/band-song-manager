<?php
/**
 * Plugin Name: Band Song Manager
 * Plugin URI: https://wonkodev.com/plugins/band-song-manager
 * Description: A comprehensive song catalog management plugin for bands and musicians. Organize your repertoire with URLs, tabs, gear notes, ChordPro charts, performance tracking, and more.
 * Version: 2.0.0
 * Author: MadWonko
 * Author URI: https://wonkodev.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: band-song-manager
 * Requires at least: 5.0
 * Tested up to: 6.9
 * Requires PHP: 7.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Plugin Action Links
 */
function bsm_add_action_links($links) {
    $settings_link = '<a href="' . admin_url('edit.php?post_type=bsm_song') . '">' . __('Songs', 'band-song-manager') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'bsm_add_action_links');

/**
 * Add Plugin Row Meta (View Details link)
 */
function bsm_add_plugin_row_meta($links, $file) {
    if (plugin_basename(__FILE__) === $file) {
        $row_meta = array(
            'details' => '<a href="#" class="bsm-view-details" style="font-weight: bold; color: #2271b1;">' . __('View Details', 'band-song-manager') . '</a>',
        );
        return array_merge($links, $row_meta);
    }
    return $links;
}
add_filter('plugin_row_meta', 'bsm_add_plugin_row_meta', 10, 2);

/**
 * Add View Details Modal to Admin Footer
 */
function bsm_add_details_modal() {
    $screen = get_current_screen();
    if ($screen && $screen->id === 'plugins') {
        ?>
        <div id="bsm-details-modal" style="display: none;">
            <div class="bsm-modal-overlay"></div>
            <div class="bsm-modal-content">
                <div class="bsm-modal-header">
                    <h2>Band Song Manager</h2>
                    <span class="bsm-version-badge">Version 2.0.0</span>
                    <button class="bsm-modal-close">&times;</button>
                </div>
                
                <div class="bsm-modal-tabs">
                    <button class="bsm-tab-btn active" data-tab="overview">Overview</button>
                    <button class="bsm-tab-btn" data-tab="features">Features</button>
                    <button class="bsm-tab-btn" data-tab="usage">Usage</button>
                    <button class="bsm-tab-btn" data-tab="import">Import</button>
                    <button class="bsm-tab-btn" data-tab="shortcodes">Shortcodes</button>
                </div>
                
                <div class="bsm-modal-body">
                    <!-- Overview Tab -->
                    <div class="bsm-tab-content active" data-tab="overview">
                        <div class="bsm-modal-section">
                            <h3>🎵 Professional Song Catalog Management</h3>
                            <p>A comprehensive WordPress plugin for bands and musicians to organize their repertoire with complete metadata tracking, performance history, and beautiful ChordPro chart rendering.</p>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h3>✨ What's New in Version 2.0</h3>
                            <ul class="bsm-feature-list">
                                <li><strong>Merged Edition:</strong> Combines all features from both previous versions</li>
                                <li><strong>Performance Tracking:</strong> Log dates and venues for each song</li>
                                <li><strong>Taxonomies:</strong> Organize by Genre, Mood, Difficulty, and Tags</li>
                                <li><strong>Enhanced Fields:</strong> Key, Tempo, Duration, Original Artist, and more</li>
                                <li><strong>Better ChordPro:</strong> Improved rendering with chords above lyrics</li>
                                <li><strong>Collapsible Sections:</strong> Clean display with expandable content</li>
                            </ul>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h3>🎸 Perfect For</h3>
                            <div class="bsm-use-cases">
                                <div class="bsm-use-case">
                                    <strong>🎤 Cover Bands</strong>
                                    <p>Track your entire repertoire with keys, tempos, and performance history</p>
                                </div>
                                <div class="bsm-use-case">
                                    <strong>🎼 Music Teachers</strong>
                                    <p>Build lesson libraries organized by difficulty with tabs and gear notes</p>
                                </div>
                                <div class="bsm-use-case">
                                    <strong>🎸 Solo Artists</strong>
                                    <p>Catalog originals and covers with ChordPro charts and recording URLs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Features Tab -->
                    <div class="bsm-tab-content" data-tab="features">
                        <div class="bsm-modal-section">
                            <h3>📋 Complete Field Set</h3>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div>
                                    <h4>Basic Information</h4>
                                    <ul>
                                        <li>Song Title</li>
                                        <li>Lyrics/Description (main content)</li>
                                        <li>Artist/Composer</li>
                                        <li>Original Artist</li>
                                        <li>Year of Publication</li>
                                    </ul>
                                </div>
                                <div>
                                    <h4>Musical Details</h4>
                                    <ul>
                                        <li>Key</li>
                                        <li>Tempo (BPM)</li>
                                        <li>Duration</li>
                                        <li>ChordPro Chart</li>
                                    </ul>
                                </div>
                                <div>
                                    <h4>Resources</h4>
                                    <ul>
                                        <li>Original Recording URL</li>
                                        <li>Rehearsal Recording URL</li>
                                        <li>Tabs/Charts/Notes</li>
                                        <li>Pedalboard/Gear Notes</li>
                                    </ul>
                                </div>
                                <div>
                                    <h4>Organization</h4>
                                    <ul>
                                        <li>Genres (hierarchical)</li>
                                        <li>Moods (tags)</li>
                                        <li>Difficulty Levels</li>
                                        <li>Custom Tags</li>
                                        <li>Performance History</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h3>🎼 ChordPro Features</h3>
                            <ul class="bsm-feature-list">
                                <li><strong>Beautiful Rendering:</strong> Chords positioned above lyrics</li>
                                <li><strong>Collapsible Display:</strong> View/hide chart with button</li>
                                <li><strong>Import Support:</strong> .cho, .chopro, .txt, .pro files</li>
                                <li><strong>Metadata Extraction:</strong> Auto-extracts title, artist, key, tempo, year</li>
                                <li><strong>Bulk Import:</strong> Import up to 20 files at once</li>
                                <li><strong>Print Ready:</strong> Professional chart formatting</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Usage Tab -->
                    <div class="bsm-tab-content" data-tab="usage">
                        <div class="bsm-modal-section">
                            <h3>🚀 Quick Start</h3>
                            <ol class="bsm-numbered-list">
                                <li><strong>Create Your First Song</strong>
                                    <ul>
                                        <li>Go to <code>Band Songs → Add New</code></li>
                                        <li>Enter the song title</li>
                                        <li>Add lyrics in the main editor</li>
                                        <li>Fill in song details fields</li>
                                        <li>Add genres, moods, difficulty</li>
                                        <li>Click Publish</li>
                                    </ul>
                                </li>
                                <li><strong>Display on Your Site</strong>
                                    <ul>
                                        <li>Copy the Song ID from the admin</li>
                                        <li>Use shortcode: <code>[song_details id="123"]</code></li>
                                        <li>Or use in template: <code>&lt;?php display_song_details(); ?&gt;</code></li>
                                    </ul>
                                </li>
                                <li><strong>Track Performances</strong>
                                    <ul>
                                        <li>Use the "Performance Tracking" box in sidebar</li>
                                        <li>Add dates and venue names</li>
                                        <li>View history on the front end</li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h3>📍 Finding Song IDs</h3>
                            <p>Song IDs are needed for shortcodes. You can find them in three places:</p>
                            <ol>
                                <li><strong>Song List:</strong> Check the "ID" column when viewing all songs</li>
                                <li><strong>While Editing:</strong> Look at the top of the "Song Details" box</li>
                                <li><strong>In URL:</strong> When editing, see <code>post=123</code> in the browser address bar</li>
                            </ol>
                        </div>
                    </div>
                    
                    <!-- Import Tab -->
                    <div class="bsm-tab-content" data-tab="import">
                        <div class="bsm-modal-section">
                            <h3>📥 ChordPro Import</h3>
                            <p>Go to <code>Band Songs → Import ChordPro</code> to access the import tools.</p>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h4>Single File Import</h4>
                            <p>Upload one ChordPro file at a time (.cho, .chopro, .txt, .pro)</p>
                            <ul>
                                <li>Perfect for adding individual songs</li>
                                <li>Choose to publish immediately or save as draft</li>
                            </ul>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h4>Bulk Import</h4>
                            <p>Upload up to 20 ChordPro files at once</p>
                            <ul>
                                <li>Great for building your song library quickly</li>
                                <li>Drag and drop multiple files</li>
                                <li>All files processed automatically</li>
                            </ul>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h4>What Gets Imported</h4>
                            <div class="bsm-import-mapping">
                                <div><code>{title:...}</code> → Post Title</div>
                                <div><code>{artist:...}</code> → Artist/Composer Field</div>
                                <div><code>{year:...}</code> → Year Field</div>
                                <div><code>{key:...}</code> → Key Field</div>
                                <div><code>{tempo:...}</code> → Tempo Field</div>
                                <div>Lyrics (chords removed) → Main Content</div>
                                <div>Full ChordPro → ChordPro Chart Field</div>
                            </div>
                            <p><em>After import, you can edit songs to add URLs, tabs, gear notes, and performance tracking.</em></p>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h4>Example ChordPro File</h4>
                            <pre class="bsm-code-example">{title: 25 or 6 to 4}
{artist: Chicago}
{year: 1970}
{key: Am}
{tempo: 120}

[Am]Waiting for the break of day
[G]Searching for something to say
[F]Flashing lights against the sky
[Am]Giving up I close my eyes</pre>
                        </div>
                    </div>
                    
                    <!-- Shortcodes Tab -->
                    <div class="bsm-tab-content" data-tab="shortcodes">
                        <div class="bsm-modal-section">
                            <h3>🔧 Available Shortcodes</h3>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h4>[song_details]</h4>
                            <p><strong>Displays complete song information</strong></p>
                            <p>Shows: Title, lyrics, all fields, collapsible sections, ChordPro chart, performance history</p>
                            <div class="bsm-code-block">
                                <code>[song_details id="123"]</code>
                            </div>
                            <p class="bsm-note">Replace <code>123</code> with your actual song ID</p>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h4>[song_chordpro]</h4>
                            <p><strong>Displays only the ChordPro chart</strong></p>
                            <p>Shows: Just the chord chart with view/hide button</p>
                            <div class="bsm-code-block">
                                <code>[song_chordpro id="123"]</code>
                            </div>
                            <p class="bsm-note">If used within a song post, you can omit the id: <code>[song_chordpro]</code></p>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h4>Template Function</h4>
                            <p><strong>For use in theme template files</strong></p>
                            <div class="bsm-code-block">
                                <code>&lt;?php display_song_details(); ?&gt;</code>
                            </div>
                            <p class="bsm-note">Automatically uses current post ID within the loop</p>
                        </div>
                        
                        <div class="bsm-modal-section">
                            <h4>Custom Template</h4>
                            <p>Create <code>single-bsm_song.php</code> or <code>single-song.php</code> in your theme to customize the song display.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .bsm-modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.7);
                z-index: 100000;
            }
            
            .bsm-modal-content {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                width: 90%;
                max-width: 900px;
                max-height: 85vh;
                border-radius: 8px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                z-index: 100001;
                display: flex;
                flex-direction: column;
            }
            
            .bsm-modal-header {
                padding: 20px 30px;
                border-bottom: 2px solid #2271b1;
                display: flex;
                align-items: center;
                gap: 15px;
                background: #f0f6fc;
            }
            
            .bsm-modal-header h2 {
                margin: 0;
                font-size: 24px;
                color: #2271b1;
                flex: 1;
            }
            
            .bsm-version-badge {
                background: #2271b1;
                color: white;
                padding: 5px 12px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 600;
            }
            
            .bsm-modal-close {
                background: none;
                border: none;
                font-size: 32px;
                cursor: pointer;
                color: #666;
                line-height: 1;
                padding: 0;
                width: 32px;
                height: 32px;
            }
            
            .bsm-modal-close:hover {
                color: #d63638;
            }
            
            .bsm-modal-tabs {
                display: flex;
                gap: 5px;
                padding: 15px 30px 0;
                background: white;
                border-bottom: 1px solid #ddd;
            }
            
            .bsm-tab-btn {
                background: #f0f0f0;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 5px 5px 0 0;
                font-size: 14px;
                font-weight: 600;
                color: #666;
                transition: all 0.2s;
            }
            
            .bsm-tab-btn:hover {
                background: #e0e0e0;
                color: #333;
            }
            
            .bsm-tab-btn.active {
                background: white;
                color: #2271b1;
                border-bottom: 3px solid #2271b1;
            }
            
            .bsm-modal-body {
                padding: 30px;
                overflow-y: auto;
                flex: 1;
            }
            
            .bsm-tab-content {
                display: none;
            }
            
            .bsm-tab-content.active {
                display: block;
            }
            
            .bsm-modal-section {
                margin-bottom: 25px;
            }
            
            .bsm-modal-section h3 {
                color: #2271b1;
                margin-top: 0;
                margin-bottom: 15px;
                font-size: 18px;
            }
            
            .bsm-modal-section h4 {
                color: #333;
                margin-top: 0;
                margin-bottom: 10px;
                font-size: 16px;
            }
            
            .bsm-feature-list {
                list-style: none;
                padding: 0;
            }
            
            .bsm-feature-list li {
                padding: 8px 0 8px 25px;
                position: relative;
                line-height: 1.6;
            }
            
            .bsm-feature-list li:before {
                content: "✓";
                position: absolute;
                left: 0;
                color: #2271b1;
                font-weight: bold;
                font-size: 18px;
            }
            
            .bsm-use-cases {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
                margin-top: 15px;
            }
            
            .bsm-use-case {
                padding: 15px;
                background: #f0f6fc;
                border-radius: 5px;
                border-left: 4px solid #2271b1;
            }
            
            .bsm-use-case strong {
                display: block;
                color: #2271b1;
                margin-bottom: 8px;
                font-size: 15px;
            }
            
            .bsm-use-case p {
                margin: 0;
                font-size: 13px;
                line-height: 1.5;
                color: #666;
            }
            
            .bsm-numbered-list {
                padding-left: 20px;
            }
            
            .bsm-numbered-list li {
                margin-bottom: 15px;
                line-height: 1.6;
            }
            
            .bsm-numbered-list ul {
                margin-top: 8px;
                list-style: disc;
            }
            
            .bsm-import-mapping {
                background: #f9f9f9;
                padding: 15px;
                border-radius: 5px;
                border-left: 4px solid #2271b1;
            }
            
            .bsm-import-mapping > div {
                padding: 5px 0;
                font-family: monospace;
                font-size: 13px;
            }
            
            .bsm-code-example {
                background: #2d2d2d;
                color: #f8f8f8;
                padding: 15px;
                border-radius: 5px;
                overflow-x: auto;
                font-family: 'Courier New', monospace;
                font-size: 13px;
                line-height: 1.6;
            }
            
            .bsm-code-block {
                background: #f9f9f9;
                border: 1px solid #ddd;
                padding: 12px;
                border-radius: 4px;
                margin: 10px 0;
            }
            
            .bsm-code-block code {
                background: none;
                padding: 0;
                color: #d63638;
                font-size: 14px;
            }
            
            .bsm-note {
                font-size: 13px;
                color: #666;
                font-style: italic;
                margin: 8px 0;
            }
            
            code {
                background: #f0f0f0;
                padding: 2px 6px;
                border-radius: 3px;
                font-size: 13px;
                color: #d63638;
            }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            // Open modal
            $(document).on('click', '.bsm-view-details', function(e) {
                e.preventDefault();
                $('#bsm-details-modal').fadeIn(200);
                $('body').css('overflow', 'hidden');
            });
            
            // Close modal
            $(document).on('click', '.bsm-modal-close, .bsm-modal-overlay', function() {
                $('#bsm-details-modal').fadeOut(200);
                $('body').css('overflow', '');
            });
            
            // Tab switching
            $(document).on('click', '.bsm-tab-btn', function() {
                var tab = $(this).data('tab');
                
                $('.bsm-tab-btn').removeClass('active');
                $(this).addClass('active');
                
                $('.bsm-tab-content').removeClass('active');
                $('.bsm-tab-content[data-tab="' + tab + '"]').addClass('active');
            });
            
            // Prevent modal close when clicking inside content
            $(document).on('click', '.bsm-modal-content', function(e) {
                e.stopPropagation();
            });
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'bsm_add_details_modal');
class BandSongManager {
    
    public function __construct() {
        add_action('init', array($this, 'register_song_post_type'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('add_meta_boxes', array($this, 'add_song_meta_boxes'));
        add_action('save_post_bsm_song', array($this, 'save_song_meta'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // Shortcodes
        add_shortcode('song_chordpro', array($this, 'render_chordpro_shortcode'));
        add_shortcode('song_details', array($this, 'render_song_details_shortcode'));
        
        // Admin columns
        add_filter('manage_bsm_song_posts_columns', array($this, 'add_song_columns'));
        add_action('manage_bsm_song_posts_custom_column', array($this, 'render_song_columns'), 10, 2);
        add_filter('manage_edit-bsm_song_sortable_columns', array($this, 'song_sortable_columns'));
        
        // Template loading
        add_filter('single_template', array($this, 'load_song_template'));
        
        // Import menu
        add_action('admin_menu', array($this, 'add_import_menu'));
        add_action('admin_post_import_chordpro', array($this, 'handle_import'));
    }
    
    /**
     * Register custom post type
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
            'taxonomies'            => array('bsm_genre', 'bsm_mood', 'bsm_difficulty', 'bsm_tag'),
        );

        register_post_type('bsm_song', $args);
    }
    
    /**
     * Register taxonomies
     */
    public function register_taxonomies() {
        // Genre
        register_taxonomy('bsm_genre', 'bsm_song', array(
            'label' => __('Genres', 'band-song-manager'),
            'hierarchical' => true,
            'show_admin_column' => true,
        ));
        
        // Mood
        register_taxonomy('bsm_mood', 'bsm_song', array(
            'label' => __('Moods', 'band-song-manager'),
            'hierarchical' => false,
            'show_admin_column' => true,
        ));
        
        // Difficulty
        register_taxonomy('bsm_difficulty', 'bsm_song', array(
            'label' => __('Difficulty', 'band-song-manager'),
            'hierarchical' => false,
            'show_admin_column' => true,
        ));
        
        // Tags
        register_taxonomy('bsm_tag', 'bsm_song', array(
            'label' => __('Tags', 'band-song-manager'),
            'hierarchical' => false,
        ));
    }
    
    /**
     * Load custom template
     */
    public function load_song_template($template) {
        global $post;
        
        if ($post && $post->post_type == 'bsm_song') {
            $theme_file = locate_template(array('single-bsm_song.php', 'single-song.php'));
            
            if ($theme_file) {
                return $theme_file;
            } else {
                $plugin_template = plugin_dir_path(__FILE__) . 'templates/single-song.php';
                if (file_exists($plugin_template)) {
                    return $plugin_template;
                }
            }
        }
        
        return $template;
    }
    
    /**
     * Add meta boxes
     */
    public function add_song_meta_boxes() {
        add_meta_box(
            'song_details',
            'Song Details',
            array($this, 'render_song_details_meta_box'),
            'bsm_song',
            'normal',
            'high'
        );
        
        add_meta_box(
            'song_performance',
            'Performance Tracking',
            array($this, 'render_performance_meta_box'),
            'bsm_song',
            'side',
            'default'
        );
    }
    
    /**
     * Render song details meta box
     */
    public function render_song_details_meta_box($post) {
        wp_nonce_field('song_details_nonce', 'song_details_nonce_field');
        
        // Get all meta data
        $artist = get_post_meta($post->ID, '_bsm_artist', true);
        $original_artist = get_post_meta($post->ID, '_bsm_original_artist', true);
        $year = get_post_meta($post->ID, '_bsm_year', true);
        $key = get_post_meta($post->ID, '_bsm_key', true);
        $tempo = get_post_meta($post->ID, '_bsm_tempo', true);
        $duration = get_post_meta($post->ID, '_bsm_duration', true);
        $original_url = get_post_meta($post->ID, '_bsm_original_url', true);
        $rehearsal_url = get_post_meta($post->ID, '_bsm_rehearsal_url', true);
        $tabs_notes = get_post_meta($post->ID, '_bsm_tabs_notes', true);
        $gear_notes = get_post_meta($post->ID, '_bsm_gear_notes', true);
        $chordpro = get_post_meta($post->ID, '_bsm_chordpro', true);
        ?>
        
        <div class="song-details-fields">
            <?php if ($post->ID): ?>
            <div class="song-id-display">
                <strong>Song ID:</strong> 
                <span class="song-id-number"><?php echo esc_html($post->ID); ?></span>
                <button type="button" class="button button-small copy-id-btn" onclick="copySongId(<?php echo esc_js($post->ID); ?>)">Copy ID</button>
                <span class="copy-feedback" style="display:none; color: green; margin-left: 10px;">✓ Copied!</span>
            </div>
            <hr style="margin: 15px 0;">
            <?php endif; ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <p>
                    <label for="bsm_artist"><strong>Artist / Composer</strong></label><br>
                    <input type="text" id="bsm_artist" name="bsm_artist" 
                           value="<?php echo esc_attr($artist); ?>" style="width: 100%;">
                </p>
                
                <p>
                    <label for="bsm_original_artist"><strong>Original Artist</strong></label><br>
                    <input type="text" id="bsm_original_artist" name="bsm_original_artist" 
                           value="<?php echo esc_attr($original_artist); ?>" style="width: 100%;">
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <p>
                    <label for="bsm_year"><strong>Year</strong></label><br>
                    <input type="text" id="bsm_year" name="bsm_year" 
                           value="<?php echo esc_attr($year); ?>" style="width: 100%;">
                </p>
                
                <p>
                    <label for="bsm_key"><strong>Key</strong></label><br>
                    <input type="text" id="bsm_key" name="bsm_key" 
                           value="<?php echo esc_attr($key); ?>" placeholder="C, Am, etc." style="width: 100%;">
                </p>
                
                <p>
                    <label for="bsm_tempo"><strong>Tempo (BPM)</strong></label><br>
                    <input type="number" id="bsm_tempo" name="bsm_tempo" 
                           value="<?php echo esc_attr($tempo); ?>" style="width: 100%;">
                </p>
                
                <p>
                    <label for="bsm_duration"><strong>Duration</strong></label><br>
                    <input type="text" id="bsm_duration" name="bsm_duration" 
                           value="<?php echo esc_attr($duration); ?>" placeholder="3:45" style="width: 100%;">
                </p>
            </div>
            
            <p>
                <label for="bsm_original_url"><strong>Original Recording URL</strong></label><br>
                <input type="url" id="bsm_original_url" name="bsm_original_url" 
                       value="<?php echo esc_url($original_url); ?>" placeholder="https://..." style="width: 100%;">
            </p>
            
            <p>
                <label for="bsm_rehearsal_url"><strong>Rehearsal Recording URL</strong></label><br>
                <input type="url" id="bsm_rehearsal_url" name="bsm_rehearsal_url" 
                       value="<?php echo esc_url($rehearsal_url); ?>" placeholder="https://..." style="width: 100%;">
            </p>
            
            <p>
                <label for="bsm_tabs_notes"><strong>Tabs / Charts / Notes</strong></label><br>
                <textarea id="bsm_tabs_notes" name="bsm_tabs_notes" rows="8" 
                          style="width: 100%;"><?php echo esc_textarea($tabs_notes); ?></textarea>
            </p>
            
            <p>
                <label for="bsm_gear_notes"><strong>Pedalboard / Gear Notes</strong></label><br>
                <textarea id="bsm_gear_notes" name="bsm_gear_notes" rows="6" 
                          style="width: 100%;"><?php echo esc_textarea($gear_notes); ?></textarea>
            </p>
            
            <p>
                <label for="bsm_chordpro"><strong>ChordPro Chart (optional)</strong></label><br>
                <small>Enter ChordPro text here. A "View Chart" button will appear on the front-end.</small><br>
                <small>Example: {title: Song Title}<br>{artist: Artist}<br>[C]Hello [G]world ...</small><br>
                <textarea id="bsm_chordpro" name="bsm_chordpro" rows="10" 
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
     * Render performance tracking meta box
     */
    public function render_performance_meta_box($post) {
        $performances = get_post_meta($post->ID, '_bsm_performances', true);
        if (!is_array($performances)) {
            $performances = array();
        }
        ?>
        <div class="performance-tracking">
            <p><strong>Track Performance History</strong></p>
            <div id="performances-list">
                <?php foreach ($performances as $index => $perf): ?>
                <div class="performance-entry" style="margin-bottom: 10px; padding: 10px; background: #f5f5f5; border-radius: 3px;">
                    <input type="date" name="performances[<?php echo esc_attr(); ?>][date]" 
                           value="<?php echo esc_attr($perf['date']); ?>" style="width: 100%; margin-bottom: 5px;">
                    <input type="text" name="performances[<?php echo esc_attr(); ?>][venue]" 
                           value="<?php echo esc_attr($perf['venue']); ?>" 
                           placeholder="Venue name" style="width: 100%;">
                    <button type="button" class="button button-small remove-performance" style="margin-top: 5px;">Remove</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-performance" class="button button-secondary" style="margin-top: 10px;">+ Add Performance</button>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            var performanceIndex = <?php echo count($performances); ?>;
            
            $('#add-performance').on('click', function() {
                var html = '<div class="performance-entry" style="margin-bottom: 10px; padding: 10px; background: #f5f5f5; border-radius: 3px;">' +
                    '<input type="date" name="performances[' + performanceIndex + '][date]" style="width: 100%; margin-bottom: 5px;">' +
                    '<input type="text" name="performances[' + performanceIndex + '][venue]" placeholder="Venue name" style="width: 100%;">' +
                    '<button type="button" class="button button-small remove-performance" style="margin-top: 5px;">Remove</button>' +
                    '</div>';
                $('#performances-list').append(html);
                performanceIndex++;
            });
            
            $(document).on('click', '.remove-performance', function() {
                $(this).closest('.performance-entry').remove();
            });
        });
        </script>
        <?php
    }
    
    /**
     * Save song meta data
     */
    public function save_song_meta($post_id) {
        if (!isset($_POST['song_details_nonce_field']) || 
            !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['song_details_nonce_field'])), 'song_details_nonce')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save all fields
        $fields = array(
            'bsm_artist' => '_bsm_artist',
            'bsm_original_artist' => '_bsm_original_artist',
            'bsm_year' => '_bsm_year',
            'bsm_key' => '_bsm_key',
            'bsm_tempo' => '_bsm_tempo',
            'bsm_duration' => '_bsm_duration',
            'bsm_original_url' => '_bsm_original_url',
            'bsm_rehearsal_url' => '_bsm_rehearsal_url',
            'bsm_tabs_notes' => '_bsm_tabs_notes',
            'bsm_gear_notes' => '_bsm_gear_notes',
            'bsm_chordpro' => '_bsm_chordpro',
        );
        
        foreach ($fields as $field_name => $meta_key) {
            if (isset($_POST[$field_name])) {
                $value = wp_unslash($_POST[$field_name]);
                
                if (strpos($field_name, 'url') !== false) {
                    $value = esc_url_raw($value);
                } elseif ($field_name === 'bsm_tempo') {
                    $value = intval($value);
                } else {
                    $value = sanitize_textarea_field($value);
                }
                
                update_post_meta($post_id, $meta_key, $value);
            }
        }
        
        // Save performances
        if (isset($_POST['performances']) && is_array($_POST['performances'])) {
            $performances = array();
            $performances_raw = wp_unslash($_POST['performances']);
            foreach ($performances_raw as $perf) {
                if (!empty($perf['date']) || !empty($perf['venue'])) {
                    $performances[] = array(
                        'date' => sanitize_text_field($perf['date']),
                        'venue' => sanitize_text_field($perf['venue']),
                    );
                }
            }
            update_post_meta($post_id, '_bsm_performances', $performances);
        }
    }
    
    /**
     * Enqueue scripts
     */
    public function enqueue_frontend_scripts() {
        if (is_singular('bsm_song')) {
            wp_enqueue_style('band-song-style', plugin_dir_url(__FILE__) . 'css/song-style.css', array(), '2.0.0');
            wp_enqueue_script('band-song-script', plugin_dir_url(__FILE__) . 'js/song-script.js', array('jquery'), '2.0.0', true);
        }
    }
    
    public function enqueue_admin_scripts($hook) {
        global $post_type;
        if (($hook == 'post.php' || $hook == 'post-new.php') && $post_type == 'bsm_song') {
            wp_enqueue_style('band-song-admin-style', plugin_dir_url(__FILE__) . 'css/admin-style.css', array(), '2.0.0');
        }
    }
    
    /**
     * Add custom columns
     */
    public function add_song_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['song_id'] = 'ID';
        $new_columns['title'] = $columns['title'];
        $new_columns['artist'] = 'Artist';
        $new_columns['key'] = 'Key';
        $new_columns['tempo'] = 'Tempo';
        $new_columns['year'] = 'Year';
        $new_columns['taxonomy-bsm_genre'] = 'Genres';
        $new_columns['date'] = $columns['date'];
        return $new_columns;
    }
    
    public function render_song_columns($column, $post_id) {
        switch ($column) {
            case 'song_id':
                echo '<strong>' . esc_html($post_id) . '</strong>';
                break;
            case 'artist':
                $artist = get_post_meta($post_id, '_bsm_artist', true);
                echo $artist ? esc_html($artist) : '—';
                break;
            case 'key':
                $key = get_post_meta($post_id, '_bsm_key', true);
                echo $key ? esc_html($key) : '—';
                break;
            case 'tempo':
                $tempo = get_post_meta($post_id, '_bsm_tempo', true);
                echo $tempo ? esc_html($tempo) . ' BPM' : '—';
                break;
            case 'year':
                $year = get_post_meta($post_id, '_bsm_year', true);
                echo $year ? esc_html($year) : '—';
                break;
        }
    }
    
    public function song_sortable_columns($columns) {
        $columns['song_id'] = 'ID';
        $columns['artist'] = 'artist';
        $columns['year'] = 'year';
        return $columns;
    }
    
    /**
     * Add import menu
     */
    public function add_import_menu() {
        add_submenu_page(
            'edit.php?post_type=bsm_song',
            'Import ChordPro Files',
            'Import ChordPro',
            'manage_options',
            'import-chordpro',
            array($this, 'render_import_page')
        );
    }
    
    /**
     * Render import page
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
                
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
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
                
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
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
                    <li><strong>Key:</strong> from {key:...}</li>
                    <li><strong>Tempo:</strong> from {tempo:...}</li>
                    <li><strong>Lyrics:</strong> Extracted without chords for main content</li>
                    <li><strong>Full ChordPro:</strong> Saved in ChordPro Chart field</li>
                </ul>
                
                <p><em>After import, you can edit the songs to add URLs, tabs, gear notes, and performance tracking.</em></p>
            </div>
        </div>
        <?php
    }
    
    /**
     * Handle import
     */
    public function handle_import() {
        if (!isset($_POST['import_nonce']) || !wp_verify_nonce($_POST['import_nonce'], 'import_chordpro')) {
            wp_die('Security check failed');
        }
        
        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to import files');
        }
        
        $import_type = $_POST['import_type'];
        $publish_immediately = isset($_POST['publish_immediately']);
        $imported_count = 0;
        
        try {
            if ($import_type === 'single') {
                if (isset($_FILES['chordpro_file']) && $_FILES['chordpro_file']['error'] === UPLOAD_ERR_OK) {
                    $this->import_chordpro_file($_FILES['chordpro_file']['tmp_name'], $_FILES['chordpro_file']['name'], $publish_immediately);
                    $imported_count = 1;
                }
            } else {
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
            
            wp_redirect(admin_url('edit.php?post_type=bsm_song&page=import-chordpro&imported=' . $imported_count));
            exit;
            
        } catch (Exception $e) {
            wp_redirect(admin_url('edit.php?post_type=bsm_song&page=import-chordpro&error=' . urlencode($e->getMessage())));
            exit;
        }
    }
    
    /**
     * Import single ChordPro file
     */
    private function import_chordpro_file($file_path, $file_name, $publish = false) {
        $content = file_get_contents($file_path);
        
        if ($content === false) {
            throw new Exception(esc_html('Could not read file: ' . $file_name));
        }
        
        $parsed = $this->parse_chordpro_import($content);
        
        $post_data = array(
            'post_title'    => $parsed['title'] ?: sanitize_text_field(pathinfo($file_name, PATHINFO_FILENAME)),
            'post_content'  => $parsed['lyrics'],
            'post_type'     => 'bsm_song',
            'post_status'   => $publish ? 'publish' : 'draft',
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (is_wp_error($post_id)) {
            throw new Exception(esc_html('Failed to create post: ' . $post_id->get_error_message()));
        }
        
        // Save meta data
        if ($parsed['artist']) {
            update_post_meta($post_id, '_bsm_artist', $parsed['artist']);
        }
        
        if ($parsed['year']) {
            update_post_meta($post_id, '_bsm_year', $parsed['year']);
        }
        
        if ($parsed['key']) {
            update_post_meta($post_id, '_bsm_key', $parsed['key']);
        }
        
        if ($parsed['tempo']) {
            update_post_meta($post_id, '_bsm_tempo', $parsed['tempo']);
        }
        
        update_post_meta($post_id, '_bsm_chordpro', $content);
        
        return $post_id;
    }
    
    /**
     * Parse ChordPro for import
     */
    private function parse_chordpro_import($content) {
        $lines = explode("\n", $content);
        $title = '';
        $artist = '';
        $year = '';
        $key = '';
        $tempo = '';
        $lyrics = '';
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            if (preg_match('/^\{(title|t):\s*(.+?)\}\s*$/i', $line, $matches)) {
                $title = trim($matches[2]);
                continue;
            }
            
            if (preg_match('/^\{(artist|composer|st|subtitle):\s*(.+?)\}\s*$/i', $line, $matches)) {
                if (!$artist) {
                    $artist = trim($matches[2]);
                }
                continue;
            }
            
            if (preg_match('/^\{year:\s*(.+?)\}\s*$/i', $line, $matches)) {
                $year = trim($matches[1]);
                continue;
            }
            
            if (preg_match('/^\{key:\s*(.+?)\}\s*$/i', $line, $matches)) {
                $key = trim($matches[1]);
                continue;
            }
            
            if (preg_match('/^\{tempo:\s*(.+?)\}\s*$/i', $line, $matches)) {
                $tempo = trim($matches[1]);
                continue;
            }
            
            if (preg_match('/^\{.+\}$/', $line)) {
                continue;
            }
            
            if (!empty($line)) {
                $lyric_line = preg_replace('/\[[^\]]+\]/', '', $line);
                $lyric_line = trim($lyric_line);
                
                if (!empty($lyric_line)) {
                    $lyrics .= $lyric_line . "\n";
                } else {
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
            'key'    => $key,
            'tempo'  => $tempo,
            'lyrics' => trim($lyrics),
        );
    }
    
    /**
     * Parse and render ChordPro
     */
    private function render_chordpro($chordpro_text) {
        $lines = explode("\n", $chordpro_text);
        $output = '';
        
        foreach ($lines as $line) {
            $line = trim($line);
            
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
            
            if (preg_match('/^\{.+\}$/', $line)) {
                continue;
            }
            
            if (preg_match('/\[([^\]]+)\]/', $line)) {
                $processed_line = '';
                $position = 0;
                
                preg_match_all('/\[([^\]]+)\]/', $line, $matches, PREG_OFFSET_CAPTURE);
                
                foreach ($matches[0] as $i => $match) {
                    $full_chord = $match[0];
                    $chord = $matches[1][$i][0];
                    $chord_pos = $match[1];
                    
                    if ($chord_pos > $position) {
                        $lyrics_before = substr($line, $position, $chord_pos - $position);
                        $processed_line .= '<span style="display: inline-block;">' . esc_html($lyrics_before) . '</span>';
                    }
                    
                    $next_chord_pos = isset($matches[0][$i + 1]) ? $matches[0][$i + 1][1] : strlen($line);
                    $lyrics_after_chord_start = $chord_pos + strlen($full_chord);
                    $lyrics_after = substr($line, $lyrics_after_chord_start, $next_chord_pos - $lyrics_after_chord_start);
                    
                    $processed_line .= '<span style="display: inline-block; position: relative; padding-top: 18px;">';
                    $processed_line .= '<span style="position: absolute; top: 0; left: 0; color: #2271b1; font-weight: bold; font-size: 12px; white-space: nowrap;">' . esc_html($chord) . '</span>';
                    $processed_line .= '<span>' . esc_html($lyrics_after) . '</span>';
                    $processed_line .= '</span>';
                    
                    $position = $next_chord_pos;
                }
                
                $output .= '<div style="font-family: monospace; margin-bottom: 5px; line-height: 1.4;">' . $processed_line . '</div>';
            } else {
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
     * ChordPro shortcode
     */
    public function render_chordpro_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => get_the_ID(),
        ), $atts);
        
        $chordpro = get_post_meta($atts['id'], '_bsm_chordpro', true);
        
        if (empty($chordpro)) {
            if (current_user_can('edit_posts')) {
                return '<div style="padding: 15px; background: #fff3cd; border: 2px solid #ffc107; border-radius: 5px; color: #856404;">
                    <strong>⚠️ No ChordPro Chart:</strong> This song (ID: ' . $atts['id'] . ') doesn\'t have any ChordPro content yet. 
                    <a href="' . get_edit_post_link($atts['id']) . '" style="color: #0073aa;">Edit the song</a> to add ChordPro chart data.
                </div>';
            }
            return '';
        }
        
        $unique_id = 'chordpro-' . uniqid();
        
        ob_start();
        ?>
        <div class="chordpro-chart" style="margin: 20px 0; clear: both;">
            <button id="<?php echo esc_attr(); ?>-btn" class="view-chart-btn" style="
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
            <div id="<?php echo esc_attr(); ?>-content" class="chordpro-content" style="display: none; margin-top: 15px;">
                <div class="chordpro-text" style="
                    background: #ffffff !important;
                    border: 2px solid #8c8f94 !important;
                    border-radius: 5px !important;
                    padding: 20px !important;
                    font-size: 14px !important;
                    line-height: 1.8 !important;
                    color: #1e1e1e !important;
                "><?php echo wp_kses_post($this->render_chordpro($chordpro)); ?></div>
            </div>
        </div>
        <script type="text/javascript">
        (function() {
            var btn = document.getElementById('<?php echo esc_attr(); ?>-btn');
            var content = document.getElementById('<?php echo esc_attr(); ?>-content');
            
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
     * Song details shortcode
     */
    public function render_song_details_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => get_the_ID(),
        ), $atts);
        
        $post_id = intval($atts['id']);
        $post = get_post($post_id);
        
        if (!$post || $post->post_type !== 'bsm_song') {
            if (current_user_can('edit_posts')) {
                return '<div style="padding: 15px; background: #f8d7da; border: 2px solid #dc3545; border-radius: 5px; color: #721c24;">
                    <strong>❌ Error:</strong> Song ID ' . $post_id . ' not found or is not a valid song.
                </div>';
            }
            return '';
        }
        
        // Get all meta
        $artist = get_post_meta($post_id, '_bsm_artist', true);
        $original_artist = get_post_meta($post_id, '_bsm_original_artist', true);
        $year = get_post_meta($post_id, '_bsm_year', true);
        $key = get_post_meta($post_id, '_bsm_key', true);
        $tempo = get_post_meta($post_id, '_bsm_tempo', true);
        $duration = get_post_meta($post_id, '_bsm_duration', true);
        $original_url = get_post_meta($post_id, '_bsm_original_url', true);
        $rehearsal_url = get_post_meta($post_id, '_bsm_rehearsal_url', true);
        $tabs_notes = get_post_meta($post_id, '_bsm_tabs_notes', true);
        $gear_notes = get_post_meta($post_id, '_bsm_gear_notes', true);
        $chordpro = get_post_meta($post_id, '_bsm_chordpro', true);
        $performances = get_post_meta($post_id, '_bsm_performances', true);
        
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
            $content = $post->post_content;
            if (!empty($content)): 
            ?>
                <div class="song-main-content" style="
                    margin-bottom: 25px; 
                    padding: 20px;
                    border-bottom: 2px solid #e0e0e0; 
                    font-size: 15px; 
                    line-height: 1.8;
                    background: #f9f9f9;
                    border-radius: 5px;
                    white-space: pre-wrap;
                ">
                    <?php echo nl2br(esc_html($content)); ?>
                </div>
            <?php endif; ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <?php if ($artist): ?>
                    <div class="song-field">
                        <strong style="color: #2271b1; font-size: 13px; text-transform: uppercase;">🎼 Artist / Composer</strong>
                        <div style="font-size: 16px; margin-top: 5px;"><?php echo esc_html($artist); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if ($original_artist): ?>
                    <div class="song-field">
                        <strong style="color: #2271b1; font-size: 13px; text-transform: uppercase;">🎤 Original Artist</strong>
                        <div style="font-size: 16px; margin-top: 5px;"><?php echo esc_html($original_artist); ?></div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; padding: 15px; background: #f0f6fc; border-radius: 5px;">
                <?php if ($year): ?>
                    <div><strong style="font-size: 12px; color: #666;">Year:</strong><br><?php echo esc_html($year); ?></div>
                <?php endif; ?>
                <?php if ($key): ?>
                    <div><strong style="font-size: 12px; color: #666;">Key:</strong><br><?php echo esc_html($key); ?></div>
                <?php endif; ?>
                <?php if ($tempo): ?>
                    <div><strong style="font-size: 12px; color: #666;">Tempo:</strong><br><?php echo esc_html($tempo); ?> BPM</div>
                <?php endif; ?>
                <?php if ($duration): ?>
                    <div><strong style="font-size: 12px; color: #666;">Duration:</strong><br><?php echo esc_html($duration); ?></div>
                <?php endif; ?>
            </div>
            
            <?php if ($original_url): ?>
                <div class="song-field" style="margin-bottom: 15px;">
                    <strong style="color: #2271b1; font-size: 13px; text-transform: uppercase;">🎵 Original Recording</strong>
                    <div style="margin-top: 5px;">
                        <a href="<?php echo esc_url($original_url); ?>" target="_blank" rel="noopener" style="color: #2271b1; text-decoration: none; font-weight: 600;">
                            Listen to Original →
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($rehearsal_url): ?>
                <div class="song-field" style="margin-bottom: 15px;">
                    <strong style="color: #2271b1; font-size: 13px; text-transform: uppercase;">🎤 Rehearsal Recording</strong>
                    <div style="margin-top: 5px;">
                        <a href="<?php echo esc_url($rehearsal_url); ?>" target="_blank" rel="noopener" style="color: #2271b1; text-decoration: none; font-weight: 600;">
                            Listen to Rehearsal →
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (is_array($performances) && count($performances) > 0): ?>
                <div class="song-field" style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
                    <strong style="color: #2271b1; font-size: 13px; text-transform: uppercase; display: block; margin-bottom: 10px;">
                        📅 Performance History
                    </strong>
                    <div style="background: #f9f9f9; padding: 10px; border-radius: 5px;">
                        <?php foreach ($performances as $perf): ?>
                            <div style="padding: 5px 0; border-bottom: 1px solid #e0e0e0;">
                                <strong><?php echo esc_html($perf['date']); ?></strong>
                                <?php if (!empty($perf['venue'])): ?>
                                    - <?php echo esc_html($perf['venue']); ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($tabs_notes): ?>
                <?php $tabs_id = 'tabs-' . uniqid(); ?>
                <div class="song-field" style="margin-bottom: 20px;">
                    <strong style="color: #2271b1; font-size: 13px; text-transform: uppercase; display: block; margin-bottom: 10px;">
                        📝 Tabs / Charts / Notes
                    </strong>
                    <button id="<?php echo esc_attr(); ?>-btn" style="
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
                        outline: none;
                    ">📄 View Tabs/Notes</button>
                    <div id="<?php echo esc_attr(); ?>-content" style="display: none; margin-top: 10px;">
                        <pre style="
                            background: #f5f5f5 !important;
                            border: 1px solid #ddd !important;
                            border-radius: 5px !important;
                            padding: 15px !important;
                            font-family: 'Courier New', Courier, monospace !important;
                            font-size: 13px !important;
                            line-height: 1.6 !important;
                            white-space: pre-wrap !important;
                            color: #333 !important;
                        "><?php echo esc_html($tabs_notes); ?></pre>
                    </div>
                </div>
                <script type="text/javascript">
                (function() {
                    var btn = document.getElementById('<?php echo esc_attr(); ?>-btn');
                    var content = document.getElementById('<?php echo esc_attr(); ?>-content');
                    if (btn && content) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            if (content.style.display === 'none') {
                                content.style.display = 'block';
                                btn.innerHTML = '📄 Hide Tabs/Notes';
                                btn.style.background = '#d63638 !important';
                            } else {
                                content.style.display = 'none';
                                btn.innerHTML = '📄 View Tabs/Notes';
                                btn.style.background = '#50575e !important';
                            }
                        });
                    }
                })();
                </script>
            <?php endif; ?>
            
            <?php if ($gear_notes): ?>
                <?php $gear_id = 'gear-' . uniqid(); ?>
                <div class="song-field" style="margin-bottom: 20px;">
                    <strong style="color: #2271b1; font-size: 13px; text-transform: uppercase; display: block; margin-bottom: 10px;">
                        🎸 Pedalboard / Gear Notes
                    </strong>
                    <button id="<?php echo esc_attr(); ?>-btn" style="
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
                        outline: none;
                    ">🎸 View Gear Notes</button>
                    <div id="<?php echo esc_attr(); ?>-content" style="display: none; margin-top: 10px;">
                        <pre style="
                            background: #f5f5f5 !important;
                            border: 1px solid #ddd !important;
                            border-radius: 5px !important;
                            padding: 15px !important;
                            font-family: 'Courier New', Courier, monospace !important;
                            font-size: 13px !important;
                            line-height: 1.6 !important;
                            white-space: pre-wrap !important;
                            color: #333 !important;
                        "><?php echo esc_html($gear_notes); ?></pre>
                    </div>
                </div>
                <script type="text/javascript">
                (function() {
                    var btn = document.getElementById('<?php echo esc_attr(); ?>-btn');
                    var content = document.getElementById('<?php echo esc_attr(); ?>-content');
                    if (btn && content) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            if (content.style.display === 'none') {
                                content.style.display = 'block';
                                btn.innerHTML = '🎸 Hide Gear Notes';
                                btn.style.background = '#d63638 !important';
                            } else {
                                content.style.display = 'none';
                                btn.innerHTML = '🎸 View Gear Notes';
                                btn.style.background = '#50575e !important';
                            }
                        });
                    }
                })();
                </script>
            <?php endif; ?>
            
            <?php if ($chordpro): ?>
                <div class="song-field">
                    <strong style="color: #2271b1; font-size: 13px; text-transform: uppercase; display: block; margin-bottom: 12px;">
                        🎼 ChordPro Chart
                    </strong>
                    <?php echo do_shortcode('[song_chordpro id="' . $post_id . '"]'); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize plugin
new BandSongManager();

// Activation hook
register_activation_hook(__FILE__, 'band_song_manager_activate');
function band_song_manager_activate() {
    $plugin = new BandSongManager();
    $plugin->register_song_post_type();
    $plugin->register_taxonomies();
    flush_rewrite_rules();
}

// Template function
function display_song_details($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    echo do_shortcode('[song_details id="' . $post_id . '"]');
}
