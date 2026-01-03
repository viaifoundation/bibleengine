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

- **Responsive Design**: Modern, mobile-friendly interface that automatically adapts to desktop and mobile devices - no separate mobile version needed

- **Dual Display Format**:
  - **Verse-by-Verse Comparison**: Each verse shows all enabled translations side-by-side with clickable verse references
  - **Whole Chapter/Block Display**: Each enabled translation displays the full chapter/block with verse number links

- **Multiple Interfaces**:
  - Web interface (`index.php`) - responsive design works on all devices
  - API endpoints (`api.php`)
  - WeChat integration (`wechat.php`, `wechata.php`, `wxb.php`)
  - Weibo integration (`weibo.php`)

- **Wiki Integration**: Integration with Bible wiki for additional study resources

- **Default Translations**: CUVS (Simplified Chinese), CUVT (Traditional Chinese), and KJV (English) are enabled by default

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
   $short_url_base = 'https://bibleengine.ai';
   $long_url_base = 'https://bibleengine.ai';
   $img_url = 'https://bibleengine.ai';
   $sitename = 'BibleEngine.ai';
   $wiki_base = 'https://engine.bible.world';
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

### Responsive Design

The main interface (`index.php`) uses modern responsive CSS that automatically adapts to:
- Desktop computers
- Tablets
- Mobile phones
- All screen sizes

No separate mobile version is needed - the same interface works perfectly on all devices.

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
├── index.php              # Main web interface (responsive design)
├── m/
│   └── index.php          # Legacy mobile interface (deprecated - use main interface)
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
| `<WHxxxx>`      | Hebrew Strong's number (OT)      | 1-8674       | `word<WH7225>`           | `word (<a href="...">H7225</a>)`    |
| `<WGxxxx>`      | Greek Strong's number (NT)       | 1-5624       | `word<WG2316>`          | `word (<a href="...">G2316</a>)`    |
| `<Hxxxx>`       | Hebrew Strong's (alternative)    | 1-8674       | `word<H430>`              | `word (<a href="...">H430</a>)`     |
| `<Gxxxx>`       | Greek Strong's (alternative)     | 1-5624       | `word<G2316>`             | `word (<a href="...">G2316</a>)`    |

**Examples from Genesis 1:1:**

- **CUVS Database:** `起初<WH7225>，　神<WH430>创造<WH1254>天<WH8064>地<WH776>。`
  - **Rendered Output:** `<strong>起初 (<a href="http://bible.fhl.net/new/s.php?N=1&k=7225" target="_blank">H7225</a>)，　神 (<a href="http://bible.fhl.net/new/s.php?N=1&k=430" target="_blank">H430</a>)创造 (<a href="http://bible.fhl.net/new/s.php?N=1&k=1254" target="_blank">H1254</a>)天 (<a href="http://bible.fhl.net/new/s.php?N=1&k=8064" target="_blank">H8064</a>)地 (<a href="http://bible.fhl.net/new/s.php?N=1&k=776" target="_blank">H776</a>)。</strong>`
  - **Visual Result:** **起初 (H7225)，　神 (H430)创造 (H1254)天 (H8064)地 (H776)。** (with clickable Strong's codes)

- **KJV Database:** `In the beginning<WH7225> God<WH430> created<WH1254><WH853> the heaven<WH8064> and<WH853> the earth<WH776>.`
  - **Rendered Output:** `<strong>In the beginning (<a href="http://bible.fhl.net/new/s.php?N=1&k=7225" target="_blank">H7225</a>) God (<a href="http://bible.fhl.net/new/s.php?N=1&k=430" target="_blank">H430</a>) created (<a href="http://bible.fhl.net/new/s.php?N=1&k=1254" target="_blank">H1254</a>) (<a href="http://bible.fhl.net/new/s.php?N=1&k=853" target="_blank">H853</a>) the heaven (<a href="http://bible.fhl.net/new/s.php?N=1&k=8064" target="_blank">H8064</a>) and (<a href="http://bible.fhl.net/new/s.php?N=1&k=853" target="_blank">H853</a>) the earth (<a href="http://bible.fhl.net/new/s.php?N=1&k=776" target="_blank">H776</a>).</strong>`
  - **Visual Result:** **In the beginning (H7225) God (H430) created (H1254) (H853) the heaven (H8064) and (H853) the earth (H776).** (with clickable Strong's codes)

**Note:** 
- The word remains as plain text, and the Strong's code appears in parentheses after the word
- The Strong's code itself (e.g., `H7225`, `G2316`) is the clickable link
- When a verse is highlighted (target verse), the entire verse including links is wrapped in `<strong>` tags
- Multiple tags can appear after a single word (e.g., `created<WH1254><WH853>` becomes `created (H1254) (H853)`)
- All links open in a new tab (`target="_blank"`)
- This approach keeps the text readable while making Strong's references clearly visible and clickable

### 2. Formatting & Emphasis Tags

These tags control visual formatting and are converted to HTML:

| Opening Tag | Closing Tag | Meaning / Rendering                     | HTML Output                              | Common Use                              |
|-------------|-------------|-----------------------------------------|------------------------------------------|------------------------------------------|
| `<FI>`      | `<Fi>`      | Formatted Italics                       | `<i>...</i>`                             | Words added by translators (supplied words) |
| `<FR>`      | `<Fr>`      | Formatted Red (Red Letter)              | `<span style="color:red;">...</span>`   | Words of Christ (Gospels, parts of Acts & Rev) |
| `<FO>`      | `<Fo>`      | Formatted Orange                        | `<span style="color:orange;">...</span>` | Words of angels, Holy Spirit, or divine speech |
| `<RF>`      | `<Rf>`      | Footnote/Reference                      | `<span class="footnote">...</span>`      | Footnotes and cross-references |
| `<b>`       | `</b>`      | Bold (standard HTML)                    | `<strong>...</strong>` or `<b>...</b>`   | Emphasis, headings, or supplied words    |
| `<font color="#008000">` | `</font>` | Inline color | `<font color="#008000">...</font>` | Special emphasis (e.g., OT quotes, divine words) |
| `<sup>`     | `</sup>`    | Superscript (standard HTML)             | `<sup>...</sup>`                         | Verse numbers, references, notes |

### 3. Tag Support by Bible Version

| Version | Strong's Tags       | Italics `<FI>` | Red Letter `<FR>` | Orange `<FO>` | Footnotes `<RF>` | Colored Font | Bold `<b>` |
|---------|---------------------|----------------|-------------------|---------------|-------------------|--------------|------------|
| NASB    | Yes (WH/WG mainly)  | Yes            | Rare/No           | No            | Possible          | Possible (green) | Possible   |
| KJV     | Yes                 | Yes            | Yes               | Yes           | Yes               | Rare         | Yes        |
| CUVS    | Yes                 | Likely         | Possible (in NT)  | Rare          | Possible          | No           | Possible   |
| CUVT    | Yes                 | Likely         | Possible          | Rare          | Possible          | No           | Possible   |

### 4. Processing Order

Tags are always processed in this order (regardless of Strong's code setting):

1. **Formatting tags first**: Red letter (`<FR>`), Orange letter (`<FO>`), Italics (`<FI>`), Footnotes (`<RF>`)
2. **Font color fixes**: Backticks replaced with quotes, missing quotes added
3. **Strong's codes** (if enabled): Long forms (`<WG...>`, `<WH...>`) then short forms (`<G...>`, `<H...>`)
4. **Strong's code removal** (if disabled): All Strong's tags are removed, including those within `<sup>` tags

**Important Notes:**
- Formatting tags (`<FI>`, `<FR>`, `<FO>`, `<RF>`, `<font color>`, `<sup>`) are **always** processed, even if Strong's codes are disabled
- If Strong's codes are disabled, they are removed from the text, but formatting tags remain
- If Strong's codes are disabled, any `<sup>` tags that only contain Strong's codes are removed entirely

### 5. Optional Tags (Not Currently Processed)

These tags may appear in some modules but are not currently processed:

- `<TS>...</Ts>` - Section/Chapter Title
- `<CL>` - Line break (for poetry)
- `<CM>` - Paragraph break

These can be added in future versions if needed.

## Development

### PHP 8 Compatibility

This project has been updated for PHP 8 compatibility:
- Uses strict types (`declare(strict_types=1)`)
- Proper null coalescing operators (`??`)
- Type casting for database ports
- Safe array access with `isset()` checks
- Updated mysqli usage (object-oriented style)
- Proper UTF-8 encoding handling with `utf8mb4` charset
- Character encoding detection and conversion for legacy data (ISO-8859-1, Windows-1252)

### Character Encoding

The engine includes robust character encoding handling:
- Database connection uses `utf8mb4` charset for full Unicode support
- Automatic detection and conversion of legacy encodings (ISO-8859-1, Windows-1252, CP1252)
- Removes invalid UTF-8 replacement characters (`ï¿½`, `?`)
- Ensures all Bible text displays correctly regardless of source encoding

### Display Format

Results are displayed in two sections:

1. **Verse-by-Verse Comparison (逐节对照)**: 
   - Each verse shows all enabled translations in a list
   - Clickable verse reference (e.g., "创 1:1") appears before each verse
   - All translations for that verse are shown together for easy comparison

2. **Whole Chapter/Block Display (整章/整段显示)**:
   - Each enabled translation gets its own section
   - Full chapter/block text is displayed
   - Verse numbers are clickable links (hover shows full reference like "Gen 1:1")
   - Useful for reading complete passages in a single translation

### Default Settings

- **Default Translations**: CUVS (Simplified Chinese), CUVT (Traditional Chinese), and KJV (English) are enabled by default
- **Strong's Codes**: Disabled by default (can be enabled via options)
- **All translations are treated equally** - no special duplicate display for default translations

### Debugging

Enable debug mode by adding `?debug=1` to the URL to see SQL queries and debug information.

## License

Copyright © 2004-2026 VI AI Foundation (歌珊地科技 Goshen Tech)

## Support

For issues, questions, or contributions, please open an issue on the GitHub repository.

## Acknowledgments

- Goshen Bible Engine (歌珊地圣经引擎) - A powerful Bible study and search engine
- Developed by VI AI Foundation (歌珊地科技 Goshen Tech)

