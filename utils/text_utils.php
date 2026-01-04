<?php
/**
 * Text processing utilities for Bible text
 */

/**
 * Fix character encoding issues in text
 * @param string $text Text to fix
 * @return string Fixed text
 */
function fixTextEncoding(string $text): string {
    if (empty($text)) {
        return $text;
    }
    
    $utf8_replacement_char = "\xEF\xBF\xBD";
    $replacement_sequence = 'ï¿½';
    $has_replacement_sequence = (strpos($text, $replacement_sequence) !== false);
    $has_replacement_char = (strpos($text, $utf8_replacement_char) !== false || 
                             mb_strpos($text, "\xEF\xBF\xBD", 0, 'UTF-8') !== false);
    $is_valid_utf8 = mb_check_encoding($text, 'UTF-8');
    
    if ($has_replacement_char || $has_replacement_sequence || !$is_valid_utf8) {
        $best_text = $text;
        $best_score = 10000;
        if ($has_replacement_sequence) $best_score += substr_count($text, $replacement_sequence);
        if ($has_replacement_char) $best_score += substr_count($text, $utf8_replacement_char);
        if (!$is_valid_utf8) $best_score += 500;
        
        $encodings_to_try = ['ISO-8859-1', 'Windows-1252', 'CP1252'];
        foreach ($encodings_to_try as $enc) {
            $test = @mb_convert_encoding($text, 'UTF-8', $enc);
            if ($test !== false && mb_check_encoding($test, 'UTF-8')) {
                $test_score = substr_count($test, $utf8_replacement_char);
                if (strpos($test, $replacement_sequence) !== false) {
                    $test_score += substr_count($test, $replacement_sequence);
                }
                if (mb_strpos($test, "\xEF\xBF\xBD", 0, 'UTF-8') !== false) {
                    $test_score += 1;
                }
                
                if ($test_score < $best_score) {
                    $best_text = $test;
                    $best_score = $test_score;
                }
            }
        }
        $text = $best_text;
        
        // Final cleanup
        $text = str_replace($utf8_replacement_char, '', $text);
        $text = str_replace($replacement_sequence, '', $text);
    }
    
    return $text;
}

/**
 * Process formatting tags (FI, FR, FO, RF, font color)
 * @param string $text Text to process
 * @return string Processed text
 */
function processFormattingTags(string $text): string {
    // Red letter (words of Christ) - <FR>...</Fr>
    $text = str_replace(['<FR>', '<Fr>'], ['<span style="color:red;">', '</span>'], $text);
    
    // Orange letter (words of angels/divine speech) - <FO>...</Fo>
    $text = str_replace(['<FO>', '<Fo>'], ['<span style="color:orange;">', '</span>'], $text);
    
    // Italics (supplied words) - <FI>...</Fi>
    $text = str_replace(['<FI>', '<Fi>'], ['<i>', '</i>'], $text);
    
    // Footnotes/References - <RF>...</Rf>
    $text = str_replace(['<RF>', '<Rf>'], ['<span class="footnote">', '</span>'], $text);
    
    // Fix font color attributes
    $text = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $text);
    
    return $text;
}

/**
 * Process Strong's codes - add as links in parentheses
 * @param string $text Text to process
 * @return string Processed text
 */
function processStrongsCodes(string $text): string {
    // Process <WG...> format (Greek, long form) - supports optional suffix like "a"
    $text = preg_replace('/([^\s<>]+)<WG(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $text);
    
    // Process <WH...> format (Hebrew, long form) - supports optional suffix like "a"
    $text = preg_replace('/([^\s<>]+)<WH(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $text);
    
    // Process <G...> format (Greek, short form) - supports optional suffix like "a"
    $text = preg_replace('/(?<!>)([^\s<>]+)<G(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $text);
    
    // Process <H...> format (Hebrew, short form) - supports optional suffix like "a"
    $text = preg_replace('/(?<!>)([^\s<>]+)<H(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $text);
    
    return $text;
}

/**
 * Remove Strong's codes from text
 * @param string $text Text to process
 * @return string Processed text
 */
function removeStrongsCodes(string $text): string {
    // Remove Strong's codes from within <sup> tags, then remove empty <sup> tags
    $text = preg_replace('/<sup>([^<]*)<[WH]?[GH]\d{1,4}[a-z]?>(.*?)<\/sup>/i', '<sup>${1}${2}</sup>', $text);
    
    // Remove <sup> tags that only contain Strong's codes (with optional whitespace)
    $text = preg_replace('/<sup>\s*<[WH]?[GH]\d{1,4}[a-z]?>\s*<\/sup>/i', '', $text);
    
    // Remove standalone Strong's code tags (not in sup tags)
    $text = preg_replace('/<[WH]?[GH]\d{1,4}[a-z]?>/i', '', $text);
    
    return $text;
}

/**
 * Highlight search terms in text
 * @param string $text Text to highlight
 * @param array $queries Array of search terms
 * @return string Text with highlighted terms
 */
function highlightSearchTerms(string $text, array $queries): string {
    foreach ($queries as $query_word) {
        if (!empty($query_word)) {
            $text = str_replace($query_word, "<strong>$query_word</strong>", $text);
        }
    }
    return $text;
}

/**
 * Process Bible text: encoding, formatting, Strong's codes, highlighting
 * @param string $text Original text
 * @param array $queries Search terms for highlighting
 * @param bool $strongs Enable Strong's codes
 * @return string Processed text
 */
function processBibleText(string $text, array $queries = [], bool $strongs = false): string {
    // Fix encoding
    $text = fixTextEncoding($text);
    
    // Process formatting tags (always)
    $text = processFormattingTags($text);
    
    // Process or remove Strong's codes
    if ($strongs) {
        $text = processStrongsCodes($text);
    } else {
        $text = removeStrongsCodes($text);
    }
    
    // Highlight search terms
    if (!empty($queries)) {
        $text = highlightSearchTerms($text, $queries);
    }
    
    return $text;
}

