<?php
// upper_menu.php
// Requires arrays from index.php: $book_short, $book_tw, $book_chinese, $book_english, $short_url_base, $script
if (!isset($book_short) || !isset($book_tw)) return;

$ot_text = function_exists('t') ? t('old_testament') : '旧约 (OT)';
$nt_text = function_exists('t') ? t('new_testament') : '新约 (NT)';
?>
<style>
.upper-book-menu {
    text-align: center;
    padding: 10px;
    font-size: 14px;
    max-width: 1000px;
    margin: 0 auto;
}
.upper-book-menu .book-group {
    margin-bottom: 12px;
}
.upper-book-menu .book-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 6px 12px;
    margin-top: 4px;
}
.upper-book-menu a {
    text-decoration: none;
    color: #0066cc;
    white-space: nowrap;
    padding: 2px 4px;
    border-radius: 3px;
}
.upper-book-menu a:hover {
    background-color: #f0f0f0;
    text-decoration: underline;
}
.dark .upper-book-menu a {
    color: #4da6ff;
}
.dark .upper-book-menu a:hover {
    background-color: #333;
}
</style>

<div class="upper-book-menu">
    <div class="book-group">
        <strong><?php echo $ot_text; ?></strong>
        <div class="book-links">
            <?php
            for ($i = 1; $i <= 39; $i++) {
                $book_title = ($book_chinese[$i] ?? '') . " (" . ($book_english[$i] ?? '') . ")";
                $book_display = ($book_short[$i] ?? '') . " " . ($book_tw[$i] ?? '');
                $url = $short_url_base ? "$short_url_base/{$book_short[$i]}.htm" : "$script?q={$book_short[$i]} 1";
                echo '<a href="' . $url . '" title="' . htmlspecialchars($book_title) . '">' . htmlspecialchars($book_display) . '</a>';
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
                $book_display = ($book_short[$i] ?? '') . " " . ($book_tw[$i] ?? '');
                $url = $short_url_base ? "$short_url_base/{$book_short[$i]}.htm" : "$script?q={$book_short[$i]} 1";
                echo '<a href="' . $url . '" title="' . htmlspecialchars($book_title) . '">' . htmlspecialchars($book_display) . '</a>';
            }
            ?>
        </div>
    </div>
</div>
