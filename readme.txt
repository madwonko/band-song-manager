=== Band Song Manager ===
Contributors: madwonko
Tags: band, music, songs, chordpro, setlist, performance
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 2.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Comprehensive song catalog management for bands and musicians with ChordPro support, performance tracking, and complete metadata.

== Description ==

Band Song Manager is a comprehensive WordPress plugin for bands and musicians to organize their repertoire with complete metadata tracking, performance history, and beautiful ChordPro chart rendering.

= Features =

* **Complete Song Catalog** - Store title, artist, key, tempo, duration, and notes
* **ChordPro Support** - Import .cho files with automatic metadata extraction
* **Bulk Import** - Import up to 20 songs at once
* **Performance Tracking** - Log dates and venues for each song
* **Taxonomies** - Organize by Genre, Mood, Difficulty, and Tags
* **Recording URLs** - Link to original and rehearsal recordings
* **Tabs & Gear Notes** - Store tabs, charts, and pedalboard settings
* **Beautiful Display** - Professional rendering with collapsible sections
* **Shortcodes** - Display songs anywhere with `[song_details]` and `[song_chordpro]`

= Perfect For =

* Cover Bands - Track your entire repertoire
* Music Teachers - Build lesson libraries by difficulty
* Solo Artists - Catalog originals and covers
* Musicians - Manage performance history and gear setups

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/band-song-manager/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to Settings → Permalinks and click "Save Changes" to flush rewrite rules
4. Use the Band Songs menu to start adding songs

== Frequently Asked Questions ==

= How do I display a song on my site? =

Use the shortcode `[song_details id="123"]` where 123 is your song ID. You can find the song ID in the admin song list or while editing a song.

= Can I import existing ChordPro files? =

Yes! Go to Band Songs → Import ChordPro to upload single or multiple .cho files. The plugin will automatically extract title, artist, key, tempo, and lyrics.

= What ChordPro directives are supported? =

The plugin recognizes: {title:}, {artist:}, {year:}, {key:}, {tempo:}, {capo:}, {comment:}, and chord annotations like [Am], [G7], etc.

= How do I track performances? =

When editing a song, use the "Performance Tracking" box in the sidebar to add dates and venues.

== Screenshots ==

1. Song details admin interface with all fields
2. ChordPro import page
3. Frontend song display with collapsible sections
4. Performance tracking interface

== Changelog ==

= 2.0.0 =
* Merged edition combining all features from both previous versions
* Added performance tracking with dates and venues
* Added taxonomies (Genre, Mood, Difficulty, Tags)
* Added Key, Tempo, Duration, Original Artist fields
* Improved ChordPro rendering with chords above lyrics
* Enhanced import supporting more metadata extraction
* Better post type naming with bsm_ prefix
* Professional admin interface with grid layout
* Added View Details modal in plugins page

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 2.0.0 =
Major update with merged features. Note: This version uses bsm_song post type instead of song. Your existing songs from previous versions will remain but won't automatically migrate.

== Additional Info ==

For more information, visit [github.com/madwonko/band-song-manager](https://github.com/madwonko/band-song-manager)
