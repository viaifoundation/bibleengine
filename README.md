# Goshen Bible Engine (歌珊地圣经引擎)

A powerful Bible study and search engine supporting multiple Bible translations in Chinese (Simplified, Traditional), English, and Pinyin. Built with PHP 8 and MySQL/MariaDB.

## Features

- **Multi-translation Support**: Supports multiple Bible translations including:
  - Chinese: CUVS (Simplified), CUVT (Traditional), NCVS, LCVS, CCSB, CLBS, CKJVS, CKJVT
  - English: KJV, NASB, ESV, UKJV, KJV1611, BBE
  - Pinyin: Pinyin transliteration for Chinese text

- **Flexible Search**:
  - Keyword search across Bible text
  - Verse reference lookup (e.g., "John 3:16", "约 3:16")
  - Book range filtering (e.g., "@创-申" for Pentateuch, "@40-43" for Gospels)
  - Multi-verse range support (e.g., "John 3:16-18,20-22")

- **Multiple Interfaces**:
  - Web interface (`index.php`)
  - Mobile/portable version (`m/index.php`)
  - API endpoints (`api.php`)
  - WeChat integration (`wechat.php`, `wechata.php`, `wxb.php`)
  - Weibo integration (`weibo.php`)

- **Wiki Integration**: Integration with Bible wiki for additional study resources

- **Cross-platform**: Works on desktop and mobile devices

## Requirements

- **PHP**: 8.0 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Web Server**: Apache, Nginx, or similar
- **PHP Extensions**:
  - `mysqli` (for database connectivity)
  - `mbstring` (for multi-byte string handling)
  - `xml` (for XML parsing)

## Installation

1. **Clone or download the repository**:
   ```bash
   git clone https://github.com/yourusername/bibleengine.git
   cd bibleengine
   ```

2. **Configure database connection**:
   Create a `dbconfig.php` file with your database credentials:
   ```php
   <?php
   $dbhost = 'localhost';
   $dbuser = 'your_db_user';
   $dbpassword = 'your_db_password';
   $database = 'your_database_name';
   $dbport = 3306; // Optional, defaults to 3306
   ?>
   ```

3. **Import database schema**:
   Import your Bible database schema. The application expects tables named `bible_books` and `bible_search` with appropriate structure.

4. **Configure application settings**:
   Edit `index.php` to set your domain and URLs:
   ```php
   $short_url_base = 'https://yourdomain.com';
   $long_url_base = 'https://yourdomain.com';
   $img_url = 'https://yourdomain.com';
   $sitename = 'Your Site Name';
   ```

5. **Set file permissions**:
   Ensure the web server has read access to all files.

## Configuration

### Main Configuration Variables

In `index.php`, you can configure:

- `$short_url_base`: Short URL base for links
- `$long_url_base`: Full URL base for the site
- `$img_url`: Base URL for images and assets
- `$sitename`: Site name displayed in headers
- `$wiki_base`: Base URL for wiki integration
- `$wiki_search_base`: Base URL for wiki search
- `$engine_name_en`: English engine name (default: "Goshen Bible Engine")
- `$engine_name_cn`: Chinese engine name (default: "歌珊地圣经引擎")
- `$copyright_text`: Copyright text (default: "2004-2026 VI AI Foundation (歌珊地科技 Goshen Tech)")

### Database Configuration

The `dbconfig.php` file should contain:
- `$dbhost`: Database host
- `$dbuser`: Database username
- `$dbpassword`: Database password
- `$database`: Database name
- `$dbport`: Database port (optional, defaults to 3306)

## Usage

### Web Interface

Access the main interface at `index.php`:
- Enter Bible references: `John 3:16`, `约 3:16`, `Rom 5:8-10`
- Search keywords: `Jesus Christ`, `上帝 爱`
- Use book range filters: `神 说 @创-申` (search "神 说" in Pentateuch)

### Mobile Interface

Access the mobile-optimized version at `m/index.php`:
- Same functionality as web interface
- Optimized for mobile devices
- Portable mode available

### API

The API supports multiple output formats:
- `api=plain`: Plain text output
- `api=html`: HTML formatted output
- `api=json`: JSON response

Example API call:
```
/api.php?q=John 3:16&api=json
```

### WeChat Integration

Configure WeChat integration in `wechat.php` or `wechata.php`:
- Set WeChat token and app credentials
- Configure message handlers
- Enable auto-reply functionality

## File Structure

```
bibleengine/
├── index.php              # Main web interface
├── m/
│   └── index.php          # Mobile/portable interface
├── api.php                # API endpoint
├── config.php             # Configuration file
├── dbconfig.php           # Database configuration (create this)
├── common.php             # Common functions and variables
├── header.php             # HTML header template
├── footer.php             # HTML footer template
├── banner.php             # Site banner template
├── votd.php               # Verse of the day
├── wechat.php             # WeChat integration
├── weibo.php              # Weibo integration
├── api/                   # API modules
│   ├── wechat.php
│   ├── wechat_bible.php
│   └── wechat_wiki.php
├── css/                   # Stylesheets
│   └── css.css
└── js/                    # JavaScript files
    └── momo.js
```

## Search Syntax

### Verse References
- Single verse: `John 3:16`
- Verse range: `John 3:16-18`
- Multiple verses: `John 3:16,18,20-22`
- Multiple references: `John 3:16-18; Rom 5:8-10`

### Book Range Filters
- Single book: `@创` or `@Gen`
- Book range: `@创-申` or `@1-5`
- By number: `@40-43` (Gospels)

### Output Options
- `/E` or `/EN`: English output
- `/C` or `/CN`: Simplified Chinese
- `/T` or `/TW`: Traditional Chinese
- `/P` or `/PINYIN`: Pinyin
- `/KJV`, `/NASB`, `/ESV`: Specific translations

## Bible Text Tag Formats

The Goshen Bible Engine supports MySword/theWord-style tagged Bible modules. The following tags are processed when Strong's codes are enabled:

### 1. Strong's Number Tags (Lexical/Concordance Tags)

These tags link words to Hebrew/Greek dictionary entries at [bible.fhl.net](http://bible.fhl.net). **Important:** In the database, Strong's tags appear **AFTER** the word they reference, not before.

| Tag Format      | Meaning                          | Range        | Database Format          | Rendered Output                      |
|-----------------|----------------------------------|--------------|--------------------------|--------------------------------------|
| `<WHxxxx>`      | Hebrew Strong's number (OT)      | 1-8674       | `word<WH7225>`           | `<a href="...">word</a>`            |
| `<WGxxxx>`      | Greek Strong's number (NT)       | 1-5624       | `word<WG2316>`          | `<a href="...">word</a>`       |
| `<Hxxxx>`       | Hebrew Strong's (alternative)    | 1-8674       | `word<H430>`              | `<a href="...">word</a>`            |
| `<Gxxxx>`       | Greek Strong's (alternative)     | 1-5624       | `word<G2316>`             | `<a href="...">word</a>`            |

**Examples from Genesis 1:1:**

- **CUVS Database:** `起初<WH7225>，　神<WH430>创造<WH1254>天<WH8064>地<WH776>。`
  - **Rendered Output:** `<strong><a href="http://bible.fhl.net/new/s.php?N=1&k=7225" target="_blank">起初</a>，　<a href="http://bible.fhl.net/new/s.php?N=1&k=430" target="_blank">神</a><a href="http://bible.fhl.net/new/s.php?N=1&k=1254" target="_blank">创造</a><a href="http://bible.fhl.net/new/s.php?N=1&k=8064" target="_blank">天</a><a href="http://bible.fhl.net/new/s.php?N=1&k=776" target="_blank">地</a>。</strong>`
  - **Visual Result:** **起初，　神创造天地。** (with clickable links on each word)

- **KJV Database:** `In the beginning<WH7225> God<WH430> created<WH1254><WH853> the heaven<WH8064> and<WH853> the earth<WH776>.`
  - **Rendered Output:** `<strong>In the <a href="http://bible.fhl.net/new/s.php?N=1&k=7225" target="_blank">beginning</a> <a href="http://bible.fhl.net/new/s.php?N=1&k=430" target="_blank">God</a> <a href="http://bible.fhl.net/new/s.php?N=1&k=1254" target="_blank">created</a><a href="http://bible.fhl.net/new/s.php?N=1&k=853" target="_blank"></a> the <a href="http://bible.fhl.net/new/s.php?N=1&k=8064" target="_blank">heaven</a> <a href="http://bible.fhl.net/new/s.php?N=1&k=853" target="_blank">and</a> the <a href="http://bible.fhl.net/new/s.php?N=1&k=776" target="_blank">earth</a>.</strong>`
  - **Visual Result:** **In the beginning God created the heaven and the earth.** (with clickable links on each tagged word)

**Note:** 
- The word immediately before the tag becomes the clickable link text
- When a verse is highlighted (target verse), the entire verse including links is wrapped in `<strong>` tags
- Multiple tags can appear after a single word (e.g., `created<WH1254><WH853>`)
- All links open in a new tab (`target="_blank"`)

### 2. Formatting & Emphasis Tags

These tags control visual formatting and are converted to HTML:

| Opening Tag | Closing Tag | Meaning / Rendering                     | HTML Output                              | Common Use                              |
|-------------|-------------|-----------------------------------------|------------------------------------------|------------------------------------------|
| `<FI>`      | `<Fi>`      | Formatted Italics                       | `<i>...</i>`                             | Words added by translators (supplied words) |
| `<FR>`      | `<Fr>`      | Formatted Red (Red Letter)              | `<span style="color:red;">...</span>`   | Words of Christ (Gospels, parts of Acts & Rev) |
| `<FO>`      | `<Fo>`      | Formatted Orange                        | `<span style="color:orange;">...</span>` | Words of angels, Holy Spirit, or divine speech |
| `<b>`       | `</b>`      | Bold (standard HTML)                    | `<strong>...</strong>` or `<b>...</b>`   | Emphasis, headings, or supplied words    |
| `<font color="#008000">` | `</font>` | Inline color | `<font color="#008000">...</font>` | Special emphasis (e.g., OT quotes, divine words) |

### 3. Tag Support by Bible Version

| Version | Strong's Tags       | Italics `<FI>` | Red Letter `<FR>` | Orange `<FO>` | Colored Font | Bold `<b>` |
|---------|---------------------|----------------|-------------------|---------------|--------------|------------|
| NASB    | Yes (WH/WG mainly)  | Yes            | Rare/No           | No            | Possible (green) | Possible   |
| KJV     | Yes                 | Yes            | Yes               | Yes           | Rare         | Yes        |
| CUVS    | Yes                 | Likely         | Possible (in NT)  | Rare          | No           | Possible   |
| CUVT    | Yes                 | Likely         | Possible          | Rare          | No           | Possible   |

### 4. Processing Order

When Strong's codes are enabled, tags are processed in this order:

1. **Formatting tags first**: Red letter (`<FR>`), Orange letter (`<FO>`), Italics (`<FI>`)
2. **Strong's codes second**: Long forms (`<WG...>`, `<WH...>`) then short forms (`<G...>`, `<H...>`)
3. **Font color fixes**: Backticks replaced with quotes, missing quotes added

### 5. Optional Tags (Not Currently Processed)

These tags may appear in some modules but are not currently processed:

- `<TS>...</Ts>` - Section/Chapter Title
- `<CL>` - Line break (for poetry)
- `<CM>` - Paragraph break
- `<RF>...</Rf>` - Footnote/reference

These can be added in future versions if needed.

## Development

### PHP 8 Compatibility

This project has been updated for PHP 8 compatibility:
- Uses strict types (`declare(strict_types=1)`)
- Proper null coalescing operators (`??`)
- Type casting for database ports
- Safe array access with `isset()` checks
- Updated mysqli usage (object-oriented style)
- Tag processing only occurs when Strong's codes are enabled (prevents HTML escaping)

### Debugging

Enable debug mode by adding `?debug=1` to the URL to see SQL queries and debug information.

## License

Copyright © 2004-2026 VI AI Foundation (歌珊地科技 Goshen Tech)

## Support

For issues, questions, or contributions, please open an issue on the GitHub repository.

## Acknowledgments

- Goshen Bible Engine (歌珊地圣经引擎) - A powerful Bible study and search engine
- Developed by VI AI Foundation (歌珊地科技 Goshen Tech)

