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
    
    // Detect from browser - check full Accept-Language header
    $browser_lang = '';
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browser_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }
    
    // Map browser language to our language codes
    // Prioritize Chinese variants first
    if (stripos($browser_lang, 'zh-Hant') !== false || stripos($browser_lang, 'zh-TW') !== false || stripos($browser_lang, 'zh-HK') !== false) {
        return 'zh_tw';
    } elseif (stripos($browser_lang, 'zh-CN') !== false || stripos($browser_lang, 'zh-SG') !== false) {
        return 'zh_cn';
    } elseif (stripos($browser_lang, 'zh') !== false) {
        // Generic Chinese - default to Traditional
        return 'zh_tw';
    } elseif (stripos($browser_lang, 'en') !== false) {
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
        
        // Bible sections
        'old_testament' => '舊約 (OT)',
        'new_testament' => '新約 (NT)',
        
        // Organization names
        'viai_foundation' => '唯愛AI基金會',
        'goshen_tech' => '歌珊地科技',
        
        // Font size
        'font_size' => '字體大小',
        'font_size_full' => '字體大小 FontSize',
        'font_xs' => '更小',
        'font_xs_full' => '更小 XS',
        'font_s' => '小',
        'font_s_full' => '小 S',
        'font_m' => '中',
        'font_m_full' => '中 M',
        'font_l' => '大',
        'font_l_full' => '大 L',
        'font_xl' => '更大',
        'font_xl_full' => '更大 XL',
        
        // Bible translations
        'trans_cuvs' => '簡體和合本CUVS',
        'trans_cuvt' => '繁體和合本CUVT',
        'trans_kjv' => '英王欽定本KJV',
        'trans_nasb' => '新美國標準聖經NASB',
        'trans_esv' => '英文標準版本ESV',
        'trans_cuvc' => '文理和合CUVC',
        'trans_ncvs' => '新譯本NCVS',
        'trans_lcvs' => '呂振中LCVS',
        'trans_ccsb' => '思高本CCSB',
        'trans_clbs' => '當代聖經CLBS',
        'trans_ckjvs' => '簡體欽定本CKJVS',
        'trans_ckjvt' => '繁體欽定本CKJVT',
        'trans_pinyin' => '拼音pinyin',
        'trans_ukjv' => '更新欽定UKJV',
        'trans_kjv1611' => '1611欽定 KJV1611',
        'trans_bbe' => '簡易英文BBE',
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
        
        // Bible sections
        'old_testament' => '旧约 (OT)',
        'new_testament' => '新约 (NT)',
        
        // Organization names
        'viai_foundation' => '唯爱AI基金会',
        'goshen_tech' => '歌珊地科技',
        
        // Font size
        'font_size' => '字体大小',
        'font_size_full' => '字体大小 FontSize',
        'font_xs' => '更小',
        'font_xs_full' => '更小 XS',
        'font_s' => '小',
        'font_s_full' => '小 S',
        'font_m' => '中',
        'font_m_full' => '中 M',
        'font_l' => '大',
        'font_l_full' => '大 L',
        'font_xl' => '更大',
        'font_xl_full' => '更大 XL',
        
        // Bible translations
        'trans_cuvs' => '简体和合本CUVS',
        'trans_cuvt' => '繁体和合本CUVT',
        'trans_kjv' => '英王钦定本KJV',
        'trans_nasb' => '新美国标准圣经NASB',
        'trans_esv' => '英文标准版本ESV',
        'trans_cuvc' => '文理和合CUVC',
        'trans_ncvs' => '新译本NCVS',
        'trans_lcvs' => '吕振中LCVS',
        'trans_ccsb' => '思高本CCSB',
        'trans_clbs' => '当代圣经CLBS',
        'trans_ckjvs' => '简体钦定本CKJVS',
        'trans_ckjvt' => '繁体钦定本CKJVT',
        'trans_pinyin' => '拼音pinyin',
        'trans_ukjv' => '更新钦定UKJV',
        'trans_kjv1611' => '1611钦定 KJV1611',
        'trans_bbe' => '简易英文BBE',
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
        
        // Bible sections
        'old_testament' => 'Old Testament (OT)',
        'new_testament' => 'New Testament (NT)',
        
        // Organization names
        'viai_foundation' => 'VI AI Foundation',
        'goshen_tech' => 'Goshen Tech',
        
        // Font size
        'font_size' => 'Font Size',
        'font_size_full' => 'Font Size',
        'font_xs' => 'XS',
        'font_xs_full' => 'Extra Small XS',
        'font_s' => 'S',
        'font_s_full' => 'Small S',
        'font_m' => 'M',
        'font_m_full' => 'Medium M',
        'font_l' => 'L',
        'font_l_full' => 'Large L',
        'font_xl' => 'XL',
        'font_xl_full' => 'Extra Large XL',
        
        // Bible translations
        'trans_cuvs' => 'CUVS (Simplified Chinese Union Version)',
        'trans_cuvt' => 'CUVT (Traditional Chinese Union Version)',
        'trans_kjv' => 'KJV (King James Version)',
        'trans_nasb' => 'NASB (New American Standard Bible)',
        'trans_esv' => 'ESV (English Standard Version)',
        'trans_cuvc' => 'CUVC (Classical Chinese Union Version)',
        'trans_ncvs' => 'NCVS (New Chinese Version Simplified)',
        'trans_lcvs' => 'LCVS (Lu Zhenzhong Version)',
        'trans_ccsb' => 'CCSB (Chinese Catholic Bible)',
        'trans_clbs' => 'CLBS (Contemporary Chinese Bible)',
        'trans_ckjvs' => 'CKJVS (Chinese KJV Simplified)',
        'trans_ckjvt' => 'CKJVT (Chinese KJV Traditional)',
        'trans_pinyin' => 'Pinyin',
        'trans_ukjv' => 'UKJV (Updated King James Version)',
        'trans_kjv1611' => 'KJV1611 (King James Version 1611)',
        'trans_bbe' => 'BBE (Bible in Basic English)',
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

// Get Bible book names based on current language
function getBookNames(): array {
    global $current_lang;
    
    // Book names in Traditional Chinese (long form)
    $book_names_tw_long = ["", "創世記", "出埃及記", "利未記", "民數記", "申命記", "約書亞記", "士師記", "路得記", "撒母耳記上", "撒母耳記下", "列王紀上", "列王紀下", "歷代志上", "歷代志下", "以斯拉記", "尼希米記", "以斯帖記", "約伯記", "詩篇", "箴言", "傳道書", "雅歌", "以賽亞書", "耶利米書", "耶利米哀歌", "以西結書", "但以理書", "何西阿書", "約珥書", "阿摩司書", "俄巴底亞書", "約拿書", "彌迦書", "那鴻書", "哈巴谷書", "西番雅書", "哈該書", "撒迦利亞書", "瑪拉基書", "馬太福音", "馬可福音", "路加福音", "約翰福音", "使徒行傳", "羅馬書", "哥林多前書", "哥林多後書", "加拉太書", "以弗所書", "腓立比書", "歌羅西書", "帖撒羅尼迦前書", "帖撒羅尼迦後書", "提摩太前書", "提摩太後書", "提多書", "腓利門書", "希伯來書", "雅各書", "彼得前書", "彼得後書", "約翰一書", "約翰二書", "約翰三書", "猶大書", "啟示錄"];
    
    // Book names in Traditional Chinese (short form)
    $book_names_tw_short = ["", "創", "出", "利", "民", "申", "書", "士", "得", "撒上", "撒下", "王上", "王下", "代上", "代下", "拉", "尼", "斯", "伯", "詩", "箴", "傳", "歌", "賽", "耶", "哀", "結", "但", "何", "珥", "摩", "俄", "拿", "彌", "鴻", "哈", "番", "該", "亞", "瑪", "太", "可", "路", "約", "徒", "羅", "林前", "林後", "加", "弗", "腓", "西", "帖前", "帖後", "提前", "提後", "多", "門", "來", "雅", "彼前", "彼後", "約一", "約二", "約三", "猶", "啟"];
    
    // Book names in Simplified Chinese (long form)
    $book_names_cn_long = ["", "创世记", "出埃及记", "利未记", "民数记", "申命记", "约书亚记", "士师记", "路得记", "撒母耳记上", "撒母耳记下", "列王纪上", "列王纪下", "历代志上", "历代志下", "以斯拉记", "尼希米记", "以斯帖记", "约伯记", "诗篇", "箴言", "传道书", "雅歌", "以赛亚书", "耶利米书", "耶利米哀歌", "以西结书", "但以理书", "何西阿书", "约珥书", "阿摩司书", "俄巴底亚书", "约拿书", "弥迦书", "那鸿书", "哈巴谷书", "西番雅书", "哈该书", "撒迦利亚书", "玛拉基书", "马太福音", "马可福音", "路加福音", "约翰福音", "使徒行传", "罗马书", "哥林多前书", "哥林多后书", "加拉太书", "以弗所书", "腓立比书", "歌罗西书", "帖撒罗尼迦前书", "帖撒罗尼迦后书", "提摩太前书", "提摩太后书", "提多书", "腓利门书", "希伯来书", "雅各书", "彼得前书", "彼得后书", "约翰一书", "约翰二书", "约翰三书", "犹大书", "启示录"];
    
    // Book names in Simplified Chinese (short form)
    $book_names_cn_short = ["", "创", "出", "利", "民", "申", "书", "士", "得", "撒上", "撒下", "王上", "王下", "代上", "代下", "拉", "尼", "斯", "伯", "诗", "箴", "传", "歌", "赛", "耶", "哀", "结", "但", "何", "珥", "摩", "俄", "拿", "弥", "鸿", "哈", "番", "该", "亚", "玛", "太", "可", "路", "约", "徒", "罗", "林前", "林后", "加", "弗", "腓", "西", "帖前", "帖后", "提前", "提后", "多", "门", "来", "雅", "彼前", "彼后", "约一", "约二", "约三", "犹", "启"];
    
    // Book names in English (long form)
    $book_names_en_long = ["", "Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalms", "Proverbs", "Ecclesiastes", "Song of Solomon", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habakkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi", "Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation"];
    
    // Book names in English (short form) - using OSIS abbreviations
    $book_names_en_short = ["", "Gen", "Exod", "Lev", "Num", "Deut", "Josh", "Judg", "Ruth", "1Sam", "2Sam", "1Kgs", "2Kgs", "1Chr", "2Chr", "Ezra", "Neh", "Esth", "Job", "Ps", "Prov", "Eccl", "Song", "Isa", "Jer", "Lam", "Ezek", "Dan", "Hos", "Joel", "Amos", "Obad", "Jonah", "Mic", "Nah", "Hab", "Zeph", "Hag", "Zech", "Mal", "Matt", "Mark", "Luke", "John", "Acts", "Rom", "1Cor", "2Cor", "Gal", "Eph", "Phil", "Col", "1Thess", "2Thess", "1Tim", "2Tim", "Titus", "Phlm", "Heb", "Jas", "1Pet", "2Pet", "1John", "2John", "3John", "Jude", "Rev"];
    
    // Return appropriate arrays based on current language
    if ($current_lang === 'zh_tw') {
        return [
            'long' => $book_names_tw_long,
            'short' => $book_names_tw_short
        ];
    } elseif ($current_lang === 'zh_cn') {
        return [
            'long' => $book_names_cn_long,
            'short' => $book_names_cn_short
        ];
    } else { // en
        return [
            'long' => $book_names_en_long,
            'short' => $book_names_en_short
        ];
    }
}

// Get language switcher HTML
function getLanguageSwitcher(): string {
    global $current_lang;
    $current_url = $_SERVER['REQUEST_URI'];
    // Remove existing lang parameter if present
    $current_url = preg_replace('/[?&]lang=[^&]*/', '', $current_url);
    $separator = strpos($current_url, '?') !== false ? '&' : '?';
    
    $switcher = '<span style="display:inline-block;margin:0 5px;">';
    $switcher .= '<select name="lang" onchange="window.location.href=\'' . htmlspecialchars($current_url . $separator . 'lang=') . '\' + this.value" style="display:inline;font-size:12px;padding:2px 5px;border:1px solid #ccc;border-radius:3px;">';
    $switcher .= '<option value="zh_tw"' . ($current_lang === 'zh_tw' ? ' selected' : '') . '>繁體中文</option>';
    $switcher .= '<option value="zh_cn"' . ($current_lang === 'zh_cn' ? ' selected' : '') . '>简体中文</option>';
    $switcher .= '<option value="en"' . ($current_lang === 'en' ? ' selected' : '') . '>English</option>';
    $switcher .= '</select>';
    $switcher .= '</span>';
    
    return $switcher;
}

