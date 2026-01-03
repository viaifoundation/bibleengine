<?php
/**
 * Internationalization (i18n) Language File
 * Supports: zh_tw (Traditional Chinese), zh_cn (Simplified Chinese), en (English)
 * Default: zh_tw
 */

// Language detection and setting
function detectLanguage(): string {
    // Check if language is set in URL parameter
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['zh_tw', 'zh_cn', 'en'])) {
        setcookie('bibleengine_lang', $_GET['lang'], time() + (365 * 24 * 60 * 60), '/');
        return $_GET['lang'];
    }
    
    // Check cookie
    if (isset($_COOKIE['bibleengine_lang']) && in_array($_COOKIE['bibleengine_lang'], ['zh_tw', 'zh_cn', 'en'])) {
        return $_COOKIE['bibleengine_lang'];
    }
    
    // Detect from browser
    $browser_lang = '';
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
    }
    
    // Map browser language to our language codes
    if (strpos($browser_lang, 'zh-Hant') !== false || strpos($browser_lang, 'zh-TW') !== false || strpos($browser_lang, 'zh-HK') !== false) {
        return 'zh_tw';
    } elseif (strpos($browser_lang, 'zh') !== false || strpos($browser_lang, 'zh-CN') !== false) {
        return 'zh_cn';
    } elseif (strpos($browser_lang, 'en') !== false) {
        return 'en';
    }
    
    // Default to zh_tw
    return 'zh_tw';
}

// Set current language
$current_lang = detectLanguage();

// Translation arrays
$translations = [
    'zh_tw' => [
        // Navigation
        'help' => '幫助',
        'help_full' => '幫助 Help',
        'source_code' => '源碼',
        'source_code_full' => '源碼 Source Code',
        'options' => '選項',
        'options_full' => '選項 Options',
        'portable' => '便攜',
        'portable_full' => '便攜 Portable',
        'copyright' => '版權',
        'copyright_full' => '版權 Copyright',
        'web_version' => '網頁版',
        'web_version_full' => '網頁版 Web',
        
        // Search and results
        'search_hint' => '提示：請輸入聖經章節，如 \'John 3:16\' 或 \'約 3:16\'。',
        'found_records' => '共查到<b>%d</b>條記錄：',
        'no_records' => '沒有查到記錄，請修改搜索條件重新搜索',
        'too_many_records' => '結果超出<b>%d</b>條記錄，請增加關鍵詞或者設定查詢範圍來準確查詢',
        
        // Display sections
        'verse_by_verse' => '逐節對照',
        'verse_by_verse_full' => '逐節對照 Verse-by-Verse Comparison',
        'whole_chapter' => '整章/整段顯示',
        'whole_chapter_full' => '整章/整段顯示 Whole Chapter/Block Display',
        
        // Form labels
        'books' => '書卷',
        'books_full' => '書卷 Books',
        'whole_bible' => '整本聖經',
        'whole_bible_full' => '整本聖經 Whole Bible',
        'old_testament' => '舊約全書',
        'old_testament_full' => '舊約全書 Old Testament',
        'new_testament' => '新約全書',
        'new_testament_full' => '新約全書 New Testament',
        'multi' => '多',
        'multi_full' => '多 Multi',
        'single_verse' => '單節',
        'single_verse_full' => '單節 Single Verse',
        'multi_verse' => '多節',
        'multi_verse_full' => '多節 Multi Verse',
        'extend' => '擴展',
        'extend_full' => '擴展 Ext',
        'verses' => '節',
        'verses_full' => '節 VV',
        'simplified' => '簡',
        'simplified_full' => '簡CN',
        'traditional' => '繁',
        'traditional_full' => '繁TW',
        'english' => '英',
        'english_full' => '英EN',
        'strongs_code' => '帶原文編號',
        'strongs_code_full' => '帶原文編號 W/ Strong\'s Code*',
        'study' => '研讀',
        'study_full' => '研讀 STUDY',
        
        // Bible study resources
        'bible_study' => '本節研經資料',
        'bible_study_full' => '本節研經資料 Bible Study',
        'quick_link' => '直達',
        'quick_link_full' => '直達 Quick Link:',
        'like_verse' => '喜愛本節',
        'like_verse_full' => '喜愛本節 Like the Verse',
        'please_select' => '請選擇',
        'please_select_full' => '請選擇 Please Select',
        
        // Errors
        'format_error' => '章節格式錯誤，可能章號不正確，正確格式參考：',
        'verse_format_error' => '章節格式錯誤，可能節號不正確，正確格式參考：',
        'index_format_error' => '索引格式錯誤，請檢查輸入的索引格式',
        'no_translation_selected' => '請至少選擇一個聖經譯本',
        'too_many_translations' => '選擇查詢的聖經譯本超出<b>%d</b>個，請縮減同時查詢的譯本個數以降低服務器開銷',
        
        // Language names
        'lang_zh_tw' => '繁體中文',
        'lang_zh_cn' => '簡體中文',
        'lang_en' => 'English',
        'language' => '語言',
        'language_full' => '語言 Language',
    ],
    
    'zh_cn' => [
        // Navigation
        'help' => '帮助',
        'help_full' => '帮助 Help',
        'source_code' => '源码',
        'source_code_full' => '源码 Source Code',
        'options' => '选项',
        'options_full' => '选项 Options',
        'portable' => '便携',
        'portable_full' => '便携 Portable',
        'copyright' => '版权',
        'copyright_full' => '版权 Copyright',
        'web_version' => '网页版',
        'web_version_full' => '网页版 Web',
        
        // Search and results
        'search_hint' => '提示：请输入圣经章节，如 \'John 3:16\' 或 \'约 3:16\'。',
        'found_records' => '共查到<b>%d</b>条记录：',
        'no_records' => '没有查到记录，请修改搜索条件重新搜索',
        'no_wiki_records' => '没有查到搜索的词条，请更换关键词再搜索。',
        'too_many_records' => '结果超出<b>%d</b>条记录，请增加关键词或者设定查询范围来准确查询',
        
        // Display sections
        'verse_by_verse' => '逐节对照',
        'verse_by_verse_full' => '逐节对照 Verse-by-Verse Comparison',
        'whole_chapter' => '整章/整段显示',
        'whole_chapter_full' => '整章/整段显示 Whole Chapter/Block Display',
        
        // Form labels
        'books' => '书卷',
        'books_full' => '书卷 Books',
        'whole_bible' => '整本圣经',
        'whole_bible_full' => '整本圣经 Whole Bible',
        'old_testament' => '旧约全书',
        'old_testament_full' => '旧约全书 Old Testament',
        'new_testament' => '新约全书',
        'new_testament_full' => '新约全书 New Testament',
        'multi' => '多',
        'multi_full' => '多 Multi',
        'single_verse' => '单节',
        'single_verse_full' => '单节 Single Verse',
        'multi_verse' => '多节',
        'multi_verse_full' => '多节 Multi Verse',
        'extend' => '扩展',
        'extend_full' => '扩展 Ext',
        'verses' => '节',
        'verses_full' => '节 VV',
        'simplified' => '简',
        'simplified_full' => '简CN',
        'traditional' => '繁',
        'traditional_full' => '繁TW',
        'english' => '英',
        'english_full' => '英EN',
        'strongs_code' => '带原文编号',
        'strongs_code_full' => '带原文编号 W/ Strong\'s Code*',
        'study' => '研读',
        'study_full' => '研读 STUDY',
        
        // Bible study resources
        'bible_study' => '本节研经资料',
        'bible_study_full' => '本节研经资料 Bible Study',
        'quick_link' => '直达',
        'quick_link_full' => '直达 Quick Link:',
        'like_verse' => '喜爱本节',
        'like_verse_full' => '喜爱本节 Like the Verse',
        'please_select' => '请选择',
        'please_select_full' => '请选择 Please Select',
        
        // Errors
        'format_error' => '章节格式错误，可能章号不正确，正确格式参考：',
        'verse_format_error' => '章节格式错误，可能节号不正确，正确格式参考：',
        'index_format_error' => '索引格式错误，请检查输入的索引格式',
        'no_translation_selected' => '请至少选择一个圣经译本',
        'too_many_translations' => '选择查询的圣经译本超出<b>%d</b>个，请缩减同时查询的译本个数以降低服务器开销',
        
        // Language names
        'lang_zh_tw' => '繁體中文',
        'lang_zh_cn' => '简体中文',
        'lang_en' => 'English',
        'language' => '语言',
        'language_full' => '语言 Language',
    ],
    
    'en' => [
        // Navigation
        'help' => 'Help',
        'help_full' => 'Help',
        'source_code' => 'Source Code',
        'source_code_full' => 'Source Code',
        'options' => 'Options',
        'options_full' => 'Options',
        'portable' => 'Portable',
        'portable_full' => 'Portable',
        'copyright' => 'Copyright',
        'copyright_full' => 'Copyright',
        'web_version' => 'Web',
        'web_version_full' => 'Web',
        
        // Search and results
        'search_hint' => 'Hint: Please enter a Bible reference, e.g., \'John 3:16\' or \'约 3:16\'.',
        'found_records' => 'Found <b>%d</b> record(s):',
        'no_records' => 'No records found. Please modify your search criteria and try again.',
        'no_wiki_records' => 'No wiki entries found. Please try different keywords.',
        'too_many_records' => 'Results exceed <b>%d</b> records. Please add more keywords or set a query scope to narrow the search.',
        
        // Display sections
        'verse_by_verse' => 'Verse-by-Verse Comparison',
        'verse_by_verse_full' => 'Verse-by-Verse Comparison',
        'whole_chapter' => 'Whole Chapter/Block Display',
        'whole_chapter_full' => 'Whole Chapter/Block Display',
        
        // Form labels
        'books' => 'Books',
        'books_full' => 'Books',
        'whole_bible' => 'Whole Bible',
        'whole_bible_full' => 'Whole Bible',
        'old_testament' => 'Old Testament',
        'old_testament_full' => 'Old Testament',
        'new_testament' => 'New Testament',
        'new_testament_full' => 'New Testament',
        'multi' => 'Multi',
        'multi_full' => 'Multi',
        'single_verse' => 'Single Verse',
        'single_verse_full' => 'Single Verse',
        'multi_verse' => 'Multi Verse',
        'multi_verse_full' => 'Multi Verse',
        'extend' => 'Extend',
        'extend_full' => 'Extend',
        'verses' => 'VV',
        'verses_full' => 'Verses VV',
        'simplified' => 'CN',
        'simplified_full' => 'Simplified CN',
        'traditional' => 'TW',
        'traditional_full' => 'Traditional TW',
        'english' => 'EN',
        'english_full' => 'English EN',
        'strongs_code' => 'W/ Strong\'s Code',
        'strongs_code_full' => 'W/ Strong\'s Code*',
        'study' => 'STUDY',
        'study_full' => 'STUDY',
        
        // Bible study resources
        'bible_study' => 'Bible Study',
        'bible_study_full' => 'Bible Study',
        'quick_link' => 'Quick Link:',
        'quick_link_full' => 'Quick Link:',
        'like_verse' => 'Like the Verse',
        'like_verse_full' => 'Like the Verse',
        'please_select' => 'Please Select',
        'please_select_full' => 'Please Select',
        
        // Errors
        'format_error' => 'Chapter format error. The chapter number may be incorrect. Correct format example:',
        'verse_format_error' => 'Verse format error. The verse number may be incorrect. Correct format example:',
        'index_format_error' => 'Index format error. Please check the input index format.',
        'no_translation_selected' => 'Please select at least one Bible translation.',
        'too_many_translations' => 'The number of selected Bible translations exceeds <b>%d</b>. Please reduce the number of translations to lower server load.',
        
        // Language names
        'lang_zh_tw' => '繁體中文',
        'lang_zh_cn' => '简体中文',
        'lang_en' => 'English',
        'language' => 'Language',
        'language_full' => 'Language',
    ],
];

// Translation function
function t(string $key, ...$args): string {
    global $current_lang, $translations;
    
    if (!isset($translations[$current_lang][$key])) {
        // Fallback to English if translation missing
        if (isset($translations['en'][$key])) {
            $text = $translations['en'][$key];
        } else {
            return $key; // Return key if no translation found
        }
    } else {
        $text = $translations[$current_lang][$key];
    }
    
    // Support sprintf-style formatting
    if (!empty($args)) {
        return sprintf($text, ...$args);
    }
    
    return $text;
}

// Get current language
function getCurrentLang(): string {
    global $current_lang;
    return $current_lang;
}

// Get language switcher HTML
function getLanguageSwitcher(): string {
    global $current_lang;
    $current_url = $_SERVER['REQUEST_URI'];
    $separator = strpos($current_url, '?') !== false ? '&' : '?';
    
    $switcher = '<select name="lang" onchange="window.location.href=\'' . htmlspecialchars($current_url . $separator . 'lang=') . '\' + this.value" style="display:inline;font-size:12px;">';
    $switcher .= '<option value="zh_tw"' . ($current_lang === 'zh_tw' ? ' selected' : '') . '>繁體中文</option>';
    $switcher .= '<option value="zh_cn"' . ($current_lang === 'zh_cn' ? ' selected' : '') . '>简体中文</option>';
    $switcher .= '<option value="en"' . ($current_lang === 'en' ? ' selected' : '') . '>English</option>';
    $switcher .= '</select>';
    
    return $switcher;
}

