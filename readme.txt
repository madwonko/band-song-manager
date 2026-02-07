=== Band Song Manager ===
Contributors: madwonko
Tags: band, music, songs, setlist, catalog, repertoire, musician
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A comprehensive song catalog management plugin for bands and musicians.

== Description ==

A comprehensive song catalog management plugin for bands and musicians. Organize your repertoire, track performance history, and display your song list to fans with customizable filtering and search capabilities.

= Features =

* ✓ Complete song catalog management (title, artist, key, tempo, duration)
* ✓ Performance tracking with date and venue history
* ✓ Tag-based categorization (genre, mood, difficulty, etc.)
* ✓ Public song list display with search and filtering
* ✓ Sortable columns (title, artist, key, tempo, duration)
* ✓ Set list planning and organization
* ✓ Custom fields support
* ✓ Export capabilities (CSV, PDF)
* ✓ Responsive design for mobile and desktop

== Installation ==

1. Upload the `band-song-manager` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to 'Band Songs' in the admin menu to start adding songs
4. Go to Settings → Band Song Manager to configure display options

== Shortcode Usage ==

= Full Song List =
`[band_songs]`

= Filtered by Tag =
`[band_songs tag="rock"]`

= Show Specific Columns =
`[band_songs columns="title,artist,key"]`

= Limit Number of Songs =
`[band_songs limit="20"]`

= Multiple Parameters =
`[band_songs tag="blues" columns="title,key,tempo" limit="10"]`

== Configuration ==

Go to Settings → Band Song Manager to configure display options:

* Default visible columns
* Songs per page
* Enable/disable search
* Enable/disable filters
* Custom tag categories
* Date format preferences

== Frequently Asked Questions ==

= How do I add songs to my catalog? =

Navigate to 'Band Songs' in your WordPress admin menu and click "Add New Song". Fill in the song details including title, artist, key, tempo, and any custom fields you've configured.

= Can I export my song list? =

Yes, you can export your entire catalog or filtered results to CSV or PDF format from the main song list page.

= How do I display songs on my website? =

Use the `[band_songs]` shortcode on any page or post. You can customize the display using the parameters listed in the Shortcode Usage section.

= Can I track when and where I've performed songs? =

Yes, each song has a performance history feature where you can log dates and venues.

= Is the plugin mobile-friendly? =

Yes, both the admin interface and public display are fully responsive and work great on mobile devices.

= Can I organize songs into setlists? =

Yes, the plugin includes set list planning and organization features.

== Screenshots ==

1. Song catalog management interface
2. Add/Edit song screen with all available fields
3. Public song list display with search and filters
4. Settings page for customization
5. Performance history tracking

== Changelog ==

= 1.0.0 =
* Initial release
* Song catalog management
* Performance tracking
* Tag-based categorization
* Public display with shortcodes
* Search and filtering
* Export to CSV/PDF
* Responsive design

== Upgrade Notice ==

= 1.0.0 =
Initial release of Band Song Manager.

== Support ==

For support, visit wonkoworld.com

== Additional Info ==

This plugin is perfect for:
* Cover bands managing their repertoire
* Original artists tracking their catalog
* Music teachers organizing lesson materials
* Wedding bands displaying available songs
* Any musician wanting to showcase their song list online
```

---

**Installation Instructions:**

1. **Replace** the header section in your existing `band-song-manager.php` file with File 1 header
2. **Create** a new file called `readme.txt` in your plugin's root directory
3. **Copy** all the content from File 2 into `readme.txt`
4. **Save** both files

**Your plugin folder structure should look like:**
```
/wp-content/plugins/band-song-manager/
    ├── band-song-manager.php
    ├── readme.txt
    └── [your other plugin files]