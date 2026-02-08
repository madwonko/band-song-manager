# Band Song Manager

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![WordPress](https://img.shields.io/badge/wordpress-5.0%2B-blue.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)

A comprehensive song catalog management plugin for bands and musicians. Organize your repertoire, track performance history, and display your song list to fans with customizable filtering and search capabilities.

![Band Song Manager](https://via.placeholder.com/1200x400/1F2937/10B981?text=Band+Song+Manager)
*Screenshot placeholder - replace with actual screenshot*

## Features

### 🎵 Complete Song Catalog Management
- **Song Details**: Store title, artist, key, tempo, duration, and custom notes
- **Performance Tracking**: Log dates and venues where you've performed each song
- **Tag System**: Categorize songs by genre, mood, difficulty, era, or custom tags
- **Custom Fields**: Add any additional information you need for your workflow

### 📊 Organization & Search
- **Advanced Filtering**: Filter by tags, key, tempo range, or any custom criteria
- **Powerful Search**: Find songs instantly by title, artist, or lyrics
- **Sortable Columns**: Click column headers to sort by any field
- **Set List Planning**: Create and organize set lists for performances

### 🌐 Public Display
- **Frontend Song List**: Display your repertoire on your website
- **Customizable Display**: Choose which columns to show
- **Responsive Design**: Works perfectly on mobile, tablet, and desktop
- **Search & Filter**: Let visitors search and filter your song list

### 📤 Export & Import
- **CSV Export**: Export your catalog for spreadsheets
- **PDF Export**: Create printable song lists
- **Backup**: Easy data backup and migration
- **Import**: Bulk import songs from CSV

## Installation

### Automatic Installation

1. Log in to your WordPress admin panel
2. Go to **Plugins** → **Add New**
3. Search for "Band Song Manager"
4. Click **Install Now** on the Band Song Manager plugin
5. Click **Activate** after installation

### Manual Installation

1. Download the plugin zip file
2. Go to **Plugins** → **Add New** → **Upload Plugin**
3. Choose the downloaded zip file
4. Click **Install Now**
5. Click **Activate Plugin**

### Via FTP

1. Download and unzip the plugin file
2. Upload the `band-song-manager` folder to `/wp-content/plugins/`
3. Go to **Plugins** in WordPress admin
4. Find "Band Song Manager" and click **Activate**

## Quick Start Guide

### 1. Add Your First Song

1. Navigate to **Band Songs** → **Add New Song** in your WordPress admin
2. Enter song details:
   - **Title**: Song name
   - **Artist**: Original artist or your band name
   - **Key**: Musical key (e.g., C, Am, G#)
   - **Tempo**: BPM (beats per minute)
   - **Duration**: Song length (e.g., 3:45)
3. Add tags (genre, mood, etc.)
4. Click **Publish**

### 2. Track Performances

1. Edit a song
2. Scroll to the **Performance History** section
3. Click **Add Performance**
4. Enter date and venue
5. Save

### 3. Display Songs on Your Website

Add this shortcode to any page or post:

```
[band_songs]
```

**With options:**

```
[band_songs tag="rock" columns="title,artist,key" limit="20"]
```

## Shortcode Usage

### Basic Shortcode

Display all songs:
```
[band_songs]
```

### Filter by Tag

Show only rock songs:
```
[band_songs tag="rock"]
```

Show multiple tags:
```
[band_songs tag="rock,blues,country"]
```

### Customize Columns

Choose which columns to display:
```
[band_songs columns="title,artist,key,tempo"]
```

Available columns:
- `title` - Song title
- `artist` - Artist name
- `key` - Musical key
- `tempo` - BPM
- `duration` - Song length
- `tags` - Tag list

### Limit Results

Show only 10 songs:
```
[band_songs limit="10"]
```

### Combine Parameters

Filter, customize, and limit:
```
[band_songs tag="blues" columns="title,key,tempo" limit="15"]
```

## Configuration

### Settings Page

Go to **Settings** → **Band Song Manager** to configure:

- **Default Columns**: Choose which columns appear by default
- **Songs Per Page**: Set pagination (default: 20)
- **Enable Search**: Allow visitors to search songs
- **Enable Filters**: Show filter options on frontend
- **Custom Tags**: Create custom tag categories
- **Date Format**: Choose how dates are displayed

### Creating Custom Tags

1. Go to **Band Songs** → **Tags**
2. Click **Add New Tag**
3. Enter tag name and description
4. Organize with parent categories if desired
5. Click **Add New Tag**

Example tag structure:
```
Genre
├── Rock
├── Blues
├── Country
└── Jazz

Difficulty
├── Easy
├── Intermediate
└── Advanced

Mood
├── Upbeat
├── Mellow
└── Energetic
```

## Use Cases

### Cover Bands
- Organize your entire song repertoire
- Track which songs you perform most often
- Share your song list with potential clients
- Create set lists for different events (weddings, corporate, bars)

### Original Artists
- Catalog your original compositions
- Track performance history and venue feedback
- Share your catalog with booking agents
- Organize songs by album or recording status

### Music Teachers
- Organize lesson materials by difficulty
- Track student progress on different pieces
- Create practice lists for students
- Share repertoire recommendations

### Wedding Bands
- Display available songs for clients to request
- Organize by genre and mood
- Track which songs are popular at events
- Create custom set lists for each wedding

## Frequently Asked Questions

### Can I import my existing song list?

Yes! The plugin supports CSV import. Format your spreadsheet with columns for title, artist, key, tempo, duration, and tags, then import via the Tools menu.

### Can I create set lists?

Yes! Use the Set List feature to create multiple set lists for different performances. You can drag and drop songs to arrange them.

### Is the song list searchable on the frontend?

Yes! Visitors can search by song title, artist, or tags. You can enable/disable this in settings.

### Can I customize the appearance?

Yes! The plugin uses CSS classes that you can style with your theme. Add custom CSS in Appearance → Customize → Additional CSS.

### Does it work with my theme?

Yes! Band Song Manager is designed to work with any WordPress theme. The frontend display adapts to your theme's styling.

### Can I export my song list?

Yes! Export to CSV for spreadsheets or PDF for printing. Go to Band Songs → Export.

### Can multiple users manage songs?

Yes! WordPress user roles apply. Editors and Administrators can manage songs.

### Is it mobile-friendly?

Yes! Both the admin interface and public display are fully responsive.

## Support

Need help? We're here for you!

- **Documentation**: [https://wonkodev.com/docs/band-song-manager](https://wonkodev.com/docs/band-song-manager)
- **Support Forum**: [https://wonkodev.com/support](https://wonkodev.com/support)
- **Email**: support@wonkodev.com
- **GitHub Issues**: [https://github.com/madwonko/band-song-manager/issues](https://github.com/madwonko/band-song-manager/issues)

## Contributing

Contributions are welcome! Here's how you can help:

1. **Report Bugs**: Open an issue on GitHub
2. **Suggest Features**: Share your ideas in the issues
3. **Submit Pull Requests**: Fork the repo and submit PRs
4. **Improve Documentation**: Help us make the docs better
5. **Translate**: Help translate the plugin into other languages

### Development Setup

```bash
# Clone the repository
git clone https://github.com/madwonko/band-song-manager.git

# Navigate to plugin directory
cd band-song-manager

# Create a symlink to your WordPress plugins folder
ln -s $(pwd) /path/to/wordpress/wp-content/plugins/band-song-manager
```

## Changelog

### Version 1.2.0 (2025-02-08)
- ✨ Added Key field for musical key notation
- ✨ Added Tempo (BPM) field
- ✨ Added comprehensive Tags system (Genre, Mood, Difficulty, Custom Tags)
- ✨ Added ChordPro format support for chord charts
- ✨ Added Print ChordPro functionality for professional chord chart printing
- ✨ Added **Single File ChordPro Import** with auto-metadata extraction
- ✨ Added **Bulk Import Tool** for importing multiple ChordPro files at once
- 🎨 Enhanced frontend display with new fields in song table
- 🐛 Improved meta box organization
- 📝 Updated documentation

### Version 1.1.0 (2025-02-08)
- ✨ Added Key field
- ✨ Added Tempo (BPM) field
- ✨ Added Tags system (Genre, Mood, Difficulty, Tags)
- ✨ Added ChordPro support
- ✨ Added Print ChordPro functionality
- 🎨 Enhanced frontend display with new fields
- 
### Version 1.0.0 (2025-02-07)
- 🎉 Initial release
- ✅ Song catalog management with full CRUD operations
- ✅ Performance history tracking
- ✅ Tag-based categorization system
- ✅ Frontend display with customizable shortcodes
- ✅ Search and filtering capabilities
- ✅ Export to CSV and PDF
- ✅ Set list planning features
- ✅ Responsive design for all devices
- ✅ Custom fields support
- ✅ Multi-user support with WordPress roles

## Roadmap

### Planned Features
- [ ] Mobile app integration
- [ ] Spotify/Apple Music integration
- [ ] Chord chart storage
- [ ] Lyrics management
- [ ] Audio file attachments
- [ ] Calendar integration for performances
- [ ] Advanced analytics and reporting
- [ ] Public API for third-party integrations
- [ ] Import from popular music apps

## Credits

**Author**: MadWonko  
**Website**: [https://wonkodev.com](https://wonkodev.com)  
**GitHub**: [@madwonko](https://github.com/madwonko)

## License

This plugin is licensed under the GPL v2 or later.

```
Band Song Manager - WordPress Plugin
Copyright (C) 2025 MadWonko

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## Show Your Support

If you find this plugin useful, please:
- ⭐ Star this repository on GitHub
- 📝 Write a review on WordPress.org
- 🐦 Share it on social media
- ☕ [Buy me a coffee](https://wonkodev.com/donate)

---

**Made with ♥ by MadWonko** | [Website](https://wonkodev.com) | [More Plugins](https://wonkodev.com/plugins) | [Support](https://wonkodev.com/support)
