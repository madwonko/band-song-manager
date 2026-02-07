# Band Song Manager - WordPress Plugin

A comprehensive WordPress plugin for managing band songs with detailed information including recordings, tabs, gear notes, and ChordPro charts.

## Features

- **Custom Post Type**: Dedicated "Songs" post type for organizing your band's repertoire
- **Comprehensive Song Details**:
  - Author/Composer information
  - Year of publication
  - Original recording URL
  - Rehearsal recording URL
  - Tabs/Charts/Notes (text area)
  - Pedalboard/Gear notes (text area)
  - ChordPro chart support with viewer
- **ChordPro Integration**: View and print ChordPro formatted chord charts
- **ChordPro Import**: Import single or multiple ChordPro files to automatically create songs
- **Clean Admin Interface**: Easy-to-use meta boxes in the WordPress editor
- **Template Function**: Display song details anywhere in your theme
- **Shortcode Support**: `[song_details]` for complete song info, `[song_chordpro]` for charts only

## Installation

### Option 1: Upload via WordPress Admin

1. Download the `band-song-manager` folder
2. Compress it into a ZIP file (band-song-manager.zip)
3. Go to WordPress Admin → Plugins → Add New
4. Click "Upload Plugin"
5. Choose the ZIP file and click "Install Now"
6. Activate the plugin

### Option 2: Manual Installation

1. Download the `band-song-manager` folder
2. Upload it to `/wp-content/plugins/` directory on your server
3. Go to WordPress Admin → Plugins
4. Find "Band Song Manager" and click "Activate"

### Option 3: FTP Upload

1. Download the entire `band-song-manager` folder
2. Connect to your server via FTP
3. Navigate to `/wp-content/plugins/`
4. Upload the `band-song-manager` folder
5. Activate the plugin in WordPress Admin

## Usage

### Finding Song IDs

The plugin makes it easy to find song IDs in multiple ways:

1. **In the Song List** - When viewing "Band Songs" → "All Songs", you'll see an "ID" column showing each song's ID
2. **When Editing a Song** - At the top of the "Song Details" box, the Song ID is displayed prominently with a "Copy ID" button
3. **In the URL** - When editing a song, look at the browser URL: `post.php?post=123&action=edit` (123 is the ID)

### Creating a New Song

1. In WordPress Admin, go to "Band Songs" → "Add New"
2. Enter the song title
3. Fill in the "Song Details" meta box with relevant information:
   - Author/Composer
   - Year of Publication
   - Original Recording URL (e.g., YouTube, Spotify link)
   - Rehearsal Recording URL (your band's version)
   - Tabs/Charts/Notes (paste your tabs or notes here)
   - Pedalboard/Gear Notes (effects settings, gear used)
   - ChordPro Chart (optional - use ChordPro format)
4. Click "Publish"

### Importing ChordPro Files

Instead of manually creating songs, you can import ChordPro files:

1. Go to "Band Songs" → "Import ChordPro"
2. Choose either:
   - **Single File Import**: Upload one ChordPro file (.cho, .chopro, .txt, .pro)
   - **Bulk Import**: Upload multiple files at once (up to 20 files)
3. Check "Publish immediately" to publish right away, or leave unchecked to save as drafts
4. Click the import button

**What gets imported:**
- **Title** → Post title (from `{title:...}` directive)
- **Artist/Composer** → Author/Composer field (from `{artist:...}` or `{composer:...}`)
- **Year** → Year of Publication field (from `{year:...}`)
- **Lyrics** → Main content area (chords removed, plain text)
- **Full ChordPro** → ChordPro Chart field (complete with all directives and chords)

After import, you can edit each song to add:
- Recording URLs
- Tabs/Charts/Notes
- Pedalboard/Gear Notes

### ChordPro Format Example

```
{title: Song Title}
{artist: Artist Name}
{key: C}

[C]Hello [G]world, how [Am]are you [F]today?
[C]Everything is [G]fine and [Am]dandy [F]now

{comment: Chorus}
[F]This is the [C]chorus [G]section
[Am]With multiple [F]chords [C]here
```

### Displaying Song Details in Your Theme

Add this code to your theme's `single-song.php` template (create it if it doesn't exist):

```php
<?php
get_header();

while (have_posts()) : the_post();
    ?>
    <article>
        <h1><?php the_title(); ?></h1>
        
        <?php the_content(); ?>
        
        <?php display_song_details(); ?>
    </article>
    <?php
endwhile;

get_footer();
?>
```

### Using the Shortcodes

**Display Complete Song Details:**

To display ALL song information (author, year, URLs, tabs, gear notes, and ChordPro chart) anywhere on your site:

```
[song_details id="123"]
```

Replace `123` with the actual song post ID. This will show a nicely formatted card with all the song information.

**Display Only ChordPro Chart:**

To display just the ChordPro chart with the view button:

```
[song_chordpro id="123"]
```

Replace `123` with the actual song post ID. If used within a song post, you can omit the ID:

```
[song_chordpro]
```

## File Structure

```
band-song-manager/
├── band-song-manager.php  (Main plugin file)
├── css/
│   ├── song-style.css     (Frontend styles)
│   └── admin-style.css    (Admin styles)
├── js/
│   └── song-script.js     (JavaScript functionality)
└── README.md              (This file)
```

## Customization

### Styling

You can override the plugin's styles by adding custom CSS to your theme:

```css
/* Custom song details styling */
.song-details-display {
    background: #your-color;
    /* Your custom styles */
}
```

### Template Override

To completely customize the song display, create a `single-song.php` file in your theme directory.

## Template Functions

### display_song_details()

Display all song details for the current post or a specific post ID:

```php
<?php display_song_details(); ?>

// Or for a specific song:
<?php display_song_details(123); ?>
```

### Getting Individual Fields

```php
<?php
$composer = get_post_meta(get_the_ID(), '_song_author_composer', true);
$year = get_post_meta(get_the_ID(), '_song_year_publication', true);
$original_url = get_post_meta(get_the_ID(), '_song_original_url', true);
$rehearsal_url = get_post_meta(get_the_ID(), '_song_rehearsal_url', true);
$tabs = get_post_meta(get_the_ID(), '_song_tabs_notes', true);
$gear = get_post_meta(get_the_ID(), '_song_gear_notes', true);
$chordpro = get_post_meta(get_the_ID(), '_song_chordpro', true);
?>
```

## Support

For issues, questions, or feature requests, please contact the plugin developer.

## License

This plugin is licensed under GPL v2 or later.

## Changelog

### Version 1.0.0
- Initial release
- Custom post type for songs
- Meta boxes for song details
- ChordPro chart viewer
- Frontend display functionality
- Shortcode support
