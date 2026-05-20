<?php
// upper_menu.php
// Requires arrays from index.php: $book_short, $book_tw, $book_cn, $book_chinese, $book_english, $short_url_base, $script, $book, $chapter

global $book_short, $book_tw, $book_cn, $book_chinese, $book_english, $short_url_base, $script, $book, $chapter;

if (!isset($book_short) || !isset($book_tw) || !isset($book_cn)) {
    return;
}

$ot_text = function_exists('t') ? t('old_testament') : 'OT 旧约';
$nt_text = function_exists('t') ? t('new_testament') : 'NT 新约';
$lang = function_exists('getCurrentLang') ? getCurrentLang() : 'zh_tw';
?>
<style>
.upper-chapter-menu {
    text-align: center;
    padding: 4px 8px;
    font-size: 12px;
    max-width: 1000px;
    margin: 4px auto 8px auto;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 4px 8px;
}
.upper-chapter-menu strong {
    color: #1e293b;
    font-size: 12px;
    border-right: 1px solid #cbd5e1;
    padding-right: 8px;
    margin-right: 2px;
    font-weight: 700;
}
.upper-chapter-menu a {
    text-decoration: none;
    color: #0f766e;
    padding: 2px 4px;
    border-radius: 3px;
    transition: all 0.2s ease;
    font-weight: 500;
}
.upper-chapter-menu a:hover {
    background-color: #e2f1e8;
    color: #0d9488;
}
.upper-chapter-menu strong a {
    background-color: #0f766e;
    color: #ffffff !important;
}
.upper-chapter-menu strong a:hover {
    background-color: #0d9488;
}

.upper-book-menu {
    text-align: center;
    padding: 6px 10px;
    max-width: 1000px;
    margin: 0 auto 8px auto;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
}
.upper-book-menu .book-group {
    margin-bottom: 6px;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}
.upper-book-menu .book-group:last-child {
    margin-bottom: 0;
}
.upper-book-menu .book-group strong {
    font-size: 11px;
    color: #475569;
    background-color: #e2e8f0;
    padding: 2px 5px;
    border-radius: 3px;
    white-space: nowrap;
    margin-top: 1px;
    min-width: 45px;
    text-align: center;
}
.upper-book-menu .book-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 3px 6px;
    flex-grow: 1;
}
.upper-book-menu a {
    text-decoration: none;
    color: #334155;
    font-size: 12px;
    white-space: nowrap;
    padding: 1px 4px;
    border-radius: 3px;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}
.upper-book-menu a:hover {
    background-color: #e2e8f0;
    color: #0f172a;
}
.upper-book-menu a.active {
    background-color: #0f766e;
    color: #ffffff;
    font-weight: bold;
}
.upper-book-menu a.active:hover {
    background-color: #0d9488;
}

/* Dark mode compatibility based on .dark body class */
.dark .upper-book-menu,
.dark .upper-chapter-menu {
    background-color: #1e293b;
    border-color: #334155;
}
.dark .upper-book-menu .book-group strong {
    color: #cbd5e1;
    background-color: #334155;
}
.dark .upper-book-menu a {
    color: #cbd5e1;
}
.dark .upper-book-menu a:hover {
    background-color: #334155;
    color: #ffffff;
}
.dark .upper-chapter-menu strong {
    color: #ffffff;
    border-color: #334155;
}
.dark .upper-chapter-menu a {
    color: #38bdf8;
}
.dark .upper-chapter-menu a:hover {
    background-color: #334155;
    color: #38bdf8;
}
</style>

<div class="upper-book-menu">
    <div class="book-group">
        <strong><?php echo $ot_text; ?></strong>
        <div class="book-links">
            <?php
            for ($i = 1; $i <= 39; $i++) {
                $book_title = ($book_chinese[$i] ?? '') . " (" . ($book_english[$i] ?? '') . ")";
                
                if ($lang === 'zh_tw') {
                    $book_display = ($book_short[$i] ?? '') . " " . ($book_tw[$i] ?? '');
                } elseif ($lang === 'zh_cn') {
                    $book_display = ($book_short[$i] ?? '') . " " . ($book_cn[$i] ?? '');
                } else {
                    $book_display = $book_short[$i] ?? '';
                }
                
                $url = $short_url_base ? "$short_url_base/{$book_short[$i]}.htm" : "$script?q={$book_short[$i]} 1";
                $active_class = ($i == $book) ? ' class="active"' : '';
                echo '<a href="' . $url . '"' . $active_class . ' title="' . htmlspecialchars($book_title) . '">' . htmlspecialchars($book_display) . '</a>';
            }
            ?>
        </div>
    </div>
    
    <div class="book-group">
        <strong><?php echo $nt_text; ?></strong>
        <div class="book-links">
            <?php
            for ($i = 40; $i <= 66; $i++) {
                $book_title = ($book_chinese[$i] ?? '') . " (" . ($book_english[$i] ?? '') . ")";
                
                if ($lang === 'zh_tw') {
                    $book_display = ($book_short[$i] ?? '') . " " . ($book_tw[$i] ?? '');
                } elseif ($lang === 'zh_cn') {
                    $book_display = ($book_short[$i] ?? '') . " " . ($book_cn[$i] ?? '');
                } else {
                    $book_display = $book_short[$i] ?? '';
                }
                
                $url = $short_url_base ? "$short_url_base/{$book_short[$i]}.htm" : "$script?q={$book_short[$i]} 1";
                $active_class = ($i == $book) ? ' class="active"' : '';
                echo '<a href="' . $url . '"' . $active_class . ' title="' . htmlspecialchars($book_title) . '">' . htmlspecialchars($book_display) . '</a>';
            }
            ?>
        </div>
    </div>
</div>
