# Band Song Manager - Merged Version 2.0

A comprehensive WordPress plugin combining the best features from both previous versions for complete band song catalog management.

## What's New in Version 2.0 (Merged)

This version combines ALL features from both previous plugins:

### From Original Version:
- ✅ Year of Publication field
- ✅ Original Recording URL
- ✅ Rehearsal Recording URL  
- ✅ Tabs/Charts/Notes field
- ✅ Pedalboard/Gear Notes field
- ✅ Improved ChordPro rendering (chords above lyrics)
- ✅ Collapsible sections for tabs and gear
- ✅ Better template system

### From Other Version:
- ✅ Taxonomies (Genre, Mood, Difficulty, Tags)
- ✅ Performance tracking (dates and venues)
- ✅ Key, Tempo, Duration fields
- ✅ Original Artist field (separate from composer)
- ✅ Better post type naming (`bsm_song` prefix)

### New Unified Features:
- ✅ All fields from both versions in one plugin
- ✅ Enhanced import supporting all field types
- ✅ Unified display with all information
- ✅ Professional admin interface

## Complete Feature List

### Song Information Fields:
- Title (post title)
- Main Content (lyrics/description)
- Artist / Composer
- Original Artist (for covers)
- Year of Publication
- Key
- Tempo (BPM)
- Duration
- Original Recording URL
- Rehearsal Recording URL
- Tabs/Charts/Notes
- Pedalboard/Gear Notes
- ChordPro Chart

### Organization:
- **Genres** (hierarchical taxonomy)
- **Moods** (tags)
- **Difficulty** levels
- **Custom Tags**

### Performance Tracking:
- Log performance dates
- Track venues
- View performance history

### ChordPro Features:
- Import .cho, .chopro, .txt, .pro files
- Single or bulk import (up to 20 files)
- Automatic metadata extraction
- Beautiful chord chart rendering
- Chords positioned above lyrics
- Collapsible chart display

## Installation

1. Download the plugin ZIP file
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Activate the plugin
5. Go to Settings → Permalinks and click "Save Changes" to flush rewrite rules

## Usage

### Creating Songs

**Manual Creation:**
1. Go to Band Songs → Add New
2. Enter song title
3. Add lyrics/description in main editor
4. Fill in all fields in "Song Details" meta box
5. Add genres, moods, difficulty in sidebar
6. Track performances in "Performance Tracking" box
7. Publish or save as draft

**Import from ChordPro:**
1. Go to Band Songs → Import ChordPro
2. Choose single or bulk import
3. Select your .cho files
4. Click import
5. Edit imported songs to add URLs, tabs, gear notes

### Displaying Songs

**Full Song Details:**
```
[song_details id="123"]
```
Shows everything: lyrics, all fields, collapsible sections, ChordPro chart

**ChordPro Chart Only:**
```
[song_chordpro id="123"]
```
Shows just the chord chart with view/hide button

**In Theme Template:**
```php
<?php display_song_details(); ?>
```

## ChordPro Format

Example file structure:
```
{title: 25 or 6 to 4}
{artist: Chicago}
{year: 1970}
{key: Am}
{tempo: 120}

[Am]Waiting for the break of day
[G]Searching for something to say
[F]Flashing lights against the sky
[Am]Giving up I close my eyes
```

Import will extract:
- Title → Post title
- Artist → Artist/Composer field
- Year → Year field
- Key → Key field
- Tempo → Tempo field
- Lyrics (without chords) → Main content
- Full ChordPro → ChordPro Chart field

## Post Type & Meta Keys

**Post Type:** `bsm_song`

**Meta Keys:**
- `_bsm_artist` - Artist/Composer
- `_bsm_original_artist` - Original Artist
- `_bsm_year` - Year
- `_bsm_key` - Key
- `_bsm_tempo` - Tempo (BPM)
- `_bsm_duration` - Duration
- `_bsm_original_url` - Original Recording URL
- `_bsm_rehearsal_url` - Rehearsal Recording URL
- `_bsm_tabs_notes` - Tabs/Charts/Notes
- `_bsm_gear_notes` - Gear Notes
- `_bsm_chordpro` - ChordPro Chart
- `_bsm_performances` - Performance array

**Taxonomies:**
- `bsm_genre` - Genres
- `bsm_mood` - Moods
- `bsm_difficulty` - Difficulty
- `bsm_tag` - Tags

## Upgrading from Previous Versions

### From "song" Post Type Version:

**IMPORTANT:** The old version used `song` post type and this uses `bsm_song`. They are separate and won't conflict, but your data won't automatically transfer.

**To migrate your data:**

1. Install this merged version alongside the old one
2. Your old songs will still be accessible at Band Songs (old)
3. You can either:
   - **Option A:** Manually recreate songs in the new version
   - **Option B:** Export old songs as ChordPro and import into new version
   - **Option C:** Keep both plugins active (they won't conflict)

4. Once satisfied with new version, deactivate old plugin

**Note:** Post URLs will change from `/song/title/` to `/song/title/` (same slug, different post type)

## File Structure

```
band-song-manager/
├── band-song-manager.php  (Main plugin)
├── css/
│   ├── song-style.css     (Frontend styles)
│   └── admin-style.css    (Admin styles)
├── js/
│   └── song-script.js     (JavaScript)
├── templates/
│   └── single-song.php    (Song template)
└── README.md              (This file)
```

## Support

For questions or issues, check:
- Song ID display in admin for shortcode usage
- Permalinks settings if song pages show 404
- Clear cache after updates

## Changelog

### Version 2.0.0 (Merged Edition)
- Merged all features from both versions
- Added performance tracking
- Added taxonomies (Genre, Mood, Difficulty, Tags)
- Added Key, Tempo, Duration, Original Artist fields
- Improved ChordPro import with more metadata extraction
- Better post type naming with `bsm_` prefix
- Enhanced admin interface
- Professional frontend display

### Version 1.0.0 (Original Versions)
- Initial releases of both versions

## License

GPL v2 or later
