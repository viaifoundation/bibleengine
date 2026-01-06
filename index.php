<?php
declare(strict_types=1);

// Load language system (must be loaded before config.php)
require_once(__DIR__ . '/lang.php');

// Initialize variables to prevent undefined warnings
$echo_string = '';
$wiki_text = '';
$text_cmp = '';
$text_cn = '';
$text_tw = '';
$text_en = '';
$text_py = '';
$chapter_menu = '';
$book_menu = '';
$wiki_book_menu = '';
$wiki_chapter_menu = '';
$osis = '';
$osis_cn = '';
$show_verse = false;
$verse_number = 0;
$quick_link_text = '';
$response = [];
$responsetext = [];
$api_response = '';
$title = '';
$max_record_count = 500;
$max_book_count = 10;
$wiki_base = 'https://bible.world/w';
$wiki_search_base = 'https://bible.world/w'; // Wiki search redirect base
$short_url_base = 'https://bibleengine.ai';
$long_url_base = 'https://bibleengine.ai';
$img_url = 'https://bibleengine.ai'; // Image/asset base URL
$sitename = 'BibleEngine.ai';
// Engine names - will be set from translations if lang.php is loaded
$engine_name_en = 'Goshen Bible Engine'; // English engine name (fallback)
$engine_name_cn = function_exists('t') ? t('engine_name') : '歌珊地圣经引擎'; // Chinese engine name (from translations)
$engine_name_full = function_exists('t') ? t('engine_name_full') : ($engine_name_cn . '——给力的圣经研读和圣经搜索引擎 <br/> <b>' . $engine_name_en . '</b> -- Powerful Bible Study and Bible Search Engine');
$copyright_text = '2004-2024 歌珊地科技 Goshen Tech, 2025-2026 唯爱AI基金会 VI AI Foundation'; // Copyright text

function show_hint(): string {
    return t('search_hint');
}

function show_banner(): string {
    global $long_url_base, $sitename;
    return "<br/><a href='$long_url_base'>$sitename</a>";
}

function search_wiki(string $q, int $p = 1): string {
    global $echo_string, $wiki_base;
    $p = max(1, $p);
    $block_size = 1800;
    $wiki_api_base = rtrim($wiki_base, '/') . '/api.php';
    $url = $wiki_api_base . "?action=query&prop=revisions&rvprop=content|size&format=xml&redirects&titles=" . urlencode($q);

    try {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception("Error fetching wiki content: " . curl_error($ch));
        }
        curl_close($ch);

        $xml = simplexml_load_string($response);
        if (!$xml) {
            throw new Exception("Error parsing XML response.");
        }

        $size = isset($xml->query->pages->page->revisions->rev['size']) ? (int)$xml->query->pages->page->revisions->rev['size'] : 0;
        $page_count = ceil($size / $block_size);
        $p = min($p, $page_count);

        $txt = isset($xml->query->pages->page->revisions->rev) ? (string)$xml->query->pages->page->revisions->rev : '';
        if (strlen($txt) > $block_size) {
            $start = ($p - 1) * $block_size;
            $txt = mb_strcut($txt, $start, $block_size, 'UTF-8') . "\n\n(第" . $p . "/" . $page_count . "页)";
        }

        if (empty($txt)) {
            $url = $wiki_api_base . "?action=query&list=search&format=xml&srlimit=max&srsearch=" . urlencode($q);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            if ($response === false) {
                throw new Exception("Error fetching search results: " . curl_error($ch));
            }
            curl_close($ch);

            $xml = simplexml_load_string($response);
            if (!$xml) {
                throw new Exception("Error parsing search XML response.");
            }

            $search_results = $xml->query->search->p ?? null;
            if ($search_results !== null) {
                $count = 0;
                foreach ($search_results as $result) {
                    $count++;
                }
                if ($count > 0) {
                    $txt .= "$q 共搜索到$count 个词条，请发送完整的词条标题查看内容：\n";
                    foreach ($search_results as $result) {
                        $txt .= "\n " . (string)$result['title'] . "\n";
                    }

                    if (strlen($txt) > 2000) {
                        $txt = mb_strcut($txt, 0, 2000, 'UTF-8') . "\n\n内容太长有删节";
                    }
                } else {
                    $txt = t('no_wiki_records') . show_hint() . show_banner();
                }
            } else {
                $txt = "没有查到搜索的词条，请更换关键词再搜索。" . show_hint() . show_banner();
            }
        }

        return $txt;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

// Book arrays
$book_short = ["", "Gen", "Exod", "Lev", "Num", "Deut", "Josh", "Judg", "Ruth", "1Sam", "2Sam", "1Kgs", "2Kgs", "1Chr", "2Chr", "Ezra", "Neh", "Esth", "Job", "Ps", "Prov", "Eccl", "Song", "Isa", "Jer", "Lam", "Ezek", "Dan", "Hos", "Joel", "Amos", "Obad", "Jonah", "Mic", "Nah", "Hab", "Zeph", "Hag", "Zech", "Mal", "Matt", "Mark", "Luke", "John", "Acts", "Rom", "1Cor", "2Cor", "Gal", "Eph", "Phil", "Col", "1Thess", "2Thess", "1Tim", "2Tim", "Titus", "Phlm", "Heb", "Jas", "1Pet", "2Pet", "1John", "2John", "3John", "Jude", "Rev"];
$book_english = ["", "Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalms", "Proverbs", "Ecclesiastes", "Song of Solomon", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habakkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi", "Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation"];
$book_english2 = ["", "Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalm", "Proverbs", "Ecclesiastes", "Song of Songs", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habakkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi", "Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation"];
$book_en = ["", "Gen", "Ex", "Lev", "Num", "Deut", "Josh", "Judg", "Ruth", "1 Sam", "2 Sam", "1 Kin", "2 Kin", "1 Chr", "2 Chr", "Ezra", "Neh", "Esth", "Job", "Ps", "Prov", "Eccl", "Song", "Is", "Jer", "Lam", "Ezek", "Dan", "Hos", "Joel", "Amos", "Obad", "Jon", "Mic", "Nah", "Hab", "Zeph", "Hag", "Zech", "Mal", "Matt", "Mark", "Luke", "John", "Acts", "Rom", "1 Cor", "2 Cor", "Gal", "Eph", "Phil", "Col", "1 Thess", "2 Thess", "1 Tim", "2 Tim", "Titus", "Philem", "Heb", "James", "1 Pet", "2 Pet", "1 John", "2 John", "3 John", "Jude", "Rev"];
$book_en2 = ["", "Ge", "Ex", "Le", "Nu", "De", "Jos", "Jud", "Ru", "1Sa", "2Sa", "1Ki", "2Ki", "1Ch", "2Ch", "Ezr", "Ne", "Es", "Job", "Psalm", "Pr", "Ec", "So", "Isa", "Jer", "La", "Eze", "Da", "Ho", "Joe", "Am", "Ob", "Jon", "Mic", "Na", "Hab", "Zep", "Hag", "Zec", "Mal", "Mt", "Mr", "Lu", "Joh", "Ac", "Ro", "1Co", "2Co", "Ga", "Eph", "Php", "Col", "1Th", "2Th", "1Ti", "2Ti", "Tit", "Phm", "Heb", "Jas", "1Pe", "2Pe", "1Jo", "2Jo", "3Jo", "Jude", "Re"];
$book_en3 = ["", "Gen", "Exo", "Lev", "Num", "Deu", "Jos", "Jdg", "Rut", "1Sa", "2Sa", "1Ki", "2Ki", "1Ch", "2Ch", "Ezr", "Neh", "Est", "Job", "Psa", "Pro", "Ecc", "Son", "Isa", "Jer", "Lam", "Eze", "Dan", "Hos", "Joe", "Amo", "Oba", "Jon", "Mic", "Nah", "Hab", "Zep", "Hag", "Zec", "Mal", "Mat", "Mar", "Luk", "Joh", "Act", "Rom", "1Co", "2Co", "Gal", "Eph", "Phi", "Col", "1Th", "2Th", "1Ti", "2Ti", "Tit", "Phm", "Heb", "Jam", "1Pe", "2Pe", "1Jo", "2Jo", "3Jo", "Jud", "Rev"];
$book_chinese = ["", "创世记", "出埃及记", "利未记", "民数记", "申命记", "约书亚记", "士师记", "路得记", "撒母耳记上", "撒母耳记下", "列王纪上", "列王纪下", "历代志上", "历代志下", "以斯拉记", "尼希米记", "以斯帖记", "约伯记", "诗篇", "箴言", "传道书", "雅歌", "以赛亚书", "耶利米书", "耶利米哀歌", "以西结书", "但以理书", "何西阿书", "约珥书", "阿摩司书", "俄巴底亚书", "约拿书", "弥迦书", "那鸿书", "哈巴谷书", "西番雅书", "哈该书", "撒迦利亚书", "玛拉基书", "马太福音", "马可福音", "路加福音", "约翰福音", "使徒行传", "罗马书", "哥林多前书", "哥林多后书", "加拉太书", "以弗所书", "腓立比书", "歌罗西书", "帖撒罗尼迦前书", "帖撒罗尼迦后书", "提摩太前书", "提摩太后书", "提多书", "腓利门书", "希伯来书", "雅各书", "彼得前书", "彼得后书", "约翰一书", "约翰二书", "约翰三书", "犹大书", "启示录"];
$book_cn = ["", "创", "出", "利", "民", "申", "书", "士", "得", "撒上", "撒下", "王上", "王下", "代上", "代下", "拉", "尼", "斯", "伯", "诗", "箴", "传", "歌", "赛", "耶", "哀", "结", "但", "何", "珥", "摩", "俄", "拿", "弥", "鸿", "哈", "番", "该", "亚", "玛", "太", "可", "路", "约", "徒", "罗", "林前", "林后", "加", "弗", "腓", "西", "帖前", "帖后", "提前", "提后", "多", "门", "来", "雅", "彼前", "彼后", "约一", "约二", "约三", "犹", "启"];
$book_taiwan = ["", "創世記", "出埃及記", "利未記", "民數記", "申命記", "約書亞記", "士師記", "路得記", "撒母耳記上", "撒母耳記下", "列王紀上", "列王紀下", "歷代志上", "歷代志下", "以斯拉記", "尼希米記", "以斯帖記", "約伯記", "詩篇", "箴言", "傳道書", "雅歌", "以賽亞書", "耶利米書", "耶利米哀歌", "以西結書", "但以理書", "何西阿書", "約珥書", "阿摩司書", "俄巴底亞書", "約拿書", "彌迦書", "那鴻書", "哈巴谷書", "西番雅書", "哈該書", "撒迦利亞書", "瑪拉基書", "馬太福音", "馬可福音", "路加福音", "約翰福音", "使徒行傳", "羅馬書", "哥林多前書", "哥林多後書", "加拉太書", "以弗所書", "腓立比書", "歌羅西書", "帖撒羅尼迦前書", "帖撒羅尼迦後書", "提摩太前書", "提摩太後書", "提多書", "腓利門書", "希伯來書", "雅各書", "彼得前書", "彼得後書", "約翰一書", "約翰二書", "約翰三書", "猶大書", "啟示錄"];
$book_tw = ["", "創", "出", "利", "民", "申", "書", "士", "得", "撒上", "撒下", "王上", "王下", "代上", "代下", "拉", "尼", "斯", "伯", "詩", "箴", "傳", "歌", "賽", "耶", "哀", "結", "但", "何", "珥", "摩", "俄", "拿", "彌", "鴻", "哈", "番", "該", "亞", "瑪", "太", "可", "路", "約", "徒", "羅", "林前", "林後", "加", "弗", "腓", "西", "帖前", "帖後", "提前", "提後", "多", "門", "來", "雅", "彼前", "彼後", "約一", "約二", "約三", "猶", "啟"];
$book_short_index = [
    "" => 0, "Gen" => 1, "Exod" => 2, "Lev" => 3, "Num" => 4, "Deut" => 5, "Josh" => 6, "Judg" => 7, "Ruth" => 8, "1Sam" => 9, "2Sam" => 10, "1Kgs" => 11, "2Kgs" => 12, "1Chr" => 13, "2Chr" => 14, "Ezra" => 15, "Neh" => 16, "Esth" => 17, "Job" => 18, "Ps" => 19, "Prov" => 20, "Eccl" => 21, "Song" => 22, "Isa" => 23, "Jer" => 24, "Lam" => 25, "Ezek" => 26, "Dan" => 27, "Hos" => 28, "Joel" => 29, "Amos" => 30, "Obad" => 31, "Jonah" => 32, "Mic" => 33, "Nah" => 34, "Hab" => 35, "Zeph" => 36, "Hag" => 37, "Zech" => 38, "Mal" => 39, "Matt" => 40, "Mark" => 41, "Luke" => 42, "John" => 43, "Acts" => 44, "Rom" => 45, "1Cor" => 46, "2Cor" => 47, "Gal" => 48, "Eph" => 49, "Phil" => 50, "Col" => 51, "1Thess" => 52, "2Thess" => 53, "1Tim" => 54, "2Tim" => 55, "Titus" => 56, "Phlm" => 57, "Heb" => 58, "Jas" => 59, "1Pet" => 60, "2Pet" => 61, "1John" => 62, "2John" => 63, "3John" => 64, "Jude" => 65, "Rev" => 66
];
$book_count = [
    0, 50, 40, 27, 36, 34, 24, 21, 4, 31, 24, 22, 25, 29, 36, 10, 13, 10, 42, 150, 31, 12, 8, 66, 52, 5, 48, 12, 14, 3, 9, 1, 4, 7, 3, 3, 3, 2, 14, 4, 28, 16, 24, 21, 28, 16, 16, 13, 6, 6, 4, 4, 5, 3, 6, 4, 3, 1, 13, 5, 5, 3, 5, 1, 1, 1, 22
];
$book_offset = [
    0, 0, 50, 90, 117, 153, 187, 211, 232, 236, 267, 291, 313, 338, 367, 403, 413, 426, 436, 478, 628, 659, 671, 679, 745, 797, 802, 850, 862, 876, 879, 888, 889, 893, 900, 903, 906, 909, 911, 925, 929, 957, 973, 997, 1018, 1046, 1062, 1078, 1091, 1097, 1103, 1107, 1111, 1116, 1119, 1125, 1129, 1132, 1133, 1146, 1151, 1156, 1159, 1164, 1165, 1166, 1167
];$book_index = [
    "1Ch" => 13, "1 Chr" => 13, "1Chr" => 13, "1Chronicles" => 13, "1 Chronicles" => 13,
    "1Co" => 46, "1 Cor" => 46, "1Cor" => 46, "1Corinthians" => 46, "1 Corinthians" => 46,
    "1J" => 62, "1Jn" => 62, "1Jo" => 62, "1 John" => 62, "1John" => 62,
    "1K" => 11, "1Kgs" => 11, "1Ki" => 11, "1 Kin" => 11, "1Kings" => 11, "1 Kings" => 11,
    "1P" => 60, "1Pe" => 60, "1 Pet" => 60, "1Pet" => 60, "1Peter" => 60, "1 Peter" => 60,
    "1S" => 9, "1Sa" => 9, "1 Sam" => 9, "1Sam" => 9, "1Samuel" => 9, "1 Samuel" => 9,
    "1Th" => 52, "1 Th" => 52, "1 Thess" => 52, "1Thess" => 52, "1Thessalonians" => 52, "1 Thessalonians" => 52,
    "1Ti" => 54, "1 Tim" => 54, "1Tim" => 54, "1Timothy" => 54, "1 Timothy" => 54, "1Tm" => 54,
    "2Ch" => 14, "2 Chr" => 14, "2Chr" => 14, "2Chronicles" => 14, "2 Chronicles" => 14,
    "2Co" => 47, "2 Cor" => 47, "2Cor" => 47, "2Corinthians" => 47, "2 Corinthians" => 47,
    "2J" => 63, "2Jn" => 63, "2Jo" => 63, "2 John" => 63, "2John" => 63,
    "2K" => 12, "2Kgs" => 12, "2Ki" => 12, "2 Kin" => 12, "2Kings" => 12, "2 Kings" => 12,
    "2P" => 61, "2Pe" => 61, "2 Pet" => 61, "2Pet" => 61, "2Peter" => 61, "2 Peter" => 61,
    "2S" => 10, "2Sa" => 10, "2 Sam" => 10, "2Sam" => 10, "2Samuel" => 10, "2 Samuel" => 10,
    "2Th" => 53, "2 Th" => 53, "2 Thess" => 53, "2Thess" => 53, "2Thessalonians" => 53, "2 Thessalonians" => 53,
    "2Ti" => 55, "2 Tim" => 55, "2Tim" => 55, "2Timothy" => 55, "2 Timothy" => 55, "2Tm" => 55,
    "3J" => 64, "3Jn" => 64, "3Jo" => 64, "3 John" => 64, "3John" => 64,
    "Ac" => 44, "Act" => 44, "Acts" => 44,
    "Am" => 30, "Amo" => 30, "Amos" => 30,
    "Cs" => 51, "Col" => 51, "Colossians" => 51,
    "Da" => 27, "Dan" => 27, "Daniel" => 27,
    "De" => 5, "Deu" => 5, "Deut" => 5, "Deuteronomy" => 5,
    "Dn" => 27, "Dt" => 5,
    "Ec" => 21, "Ecc" => 21, "Eccl" => 21, "Ecclesiastes" => 21,
    "Ep" => 49, "Eph" => 49, "Ephesians" => 49,
    "Es" => 17, "Est" => 17, "Esth" => 17, "Esther" => 17,
    "Ex" => 2, "Exo" => 2, "Exod" => 2, "Exodus" => 2,
    "Eze" => 26, "Ezek" => 26, "Ezekiel" => 26,
    "Ezr" => 15, "Ezra" => 15,
    "Ga" => 48, "Gal" => 48, "Galatians" => 48,
    "Ge" => 1, "Gen" => 1, "Genesis" => 1, "Gn" => 1,
    "Hab" => 35, "Habakkuk" => 35,
    "Hag" => 37, "Haggai" => 37,
    "Hb" => 58, "Heb" => 58, "Hebrews" => 58,
    "Hg" => 37, "Ho" => 28, "Hos" => 28, "Hosea" => 28, "Hs" => 28,
    "Is" => 23, "Isa" => 23, "Isaiah" => 23,
    "Jam" => 59, "James" => 59, "Jas" => 59,
    "Jb" => 18, "Jd" => 65, "Jdg" => 7, "Jer" => 24, "Jeremiah" => 24,
    "Jg" => 7, "Jl" => 29, "Jm" => 59, "Jn" => 43, "Jnh" => 32,
    "Job" => 18, "Joe" => 29, "Joel" => 29, "Joh" => 43, "John" => 43,
    "Jon" => 32, "Jonah" => 32, "Jos" => 6, "Josh" => 6, "Joshua" => 6,
    "Jr" => 24, "Jud" => 65, "Jude" => 65, "Judg" => 7, "Judges" => 7,
    "La" => 25, "Lam" => 25, "Lamentations" => 25,
    "Le" => 3, "Lev" => 3, "Leviticus" => 3,
    "Lk" => 42, "Lm" => 25, "Lu" => 42, "Luk" => 42, "Luke" => 42,
    "Lv" => 3, "Mal" => 39, "Malachi" => 39,
    "Mar" => 41, "Mark" => 41, "Mat" => 40, "Matt" => 40, "Matthew" => 40,
    "Mi" => 33, "Mic" => 33, "Micah" => 33,
    "Mk" => 41, "Mr" => 41, "Mt" => 40,
    "Na" => 34, "Nah" => 34, "Nahum" => 34,
    "Ne" => 16, "Neh" => 16, "Nehemiah" => 16,
    "Nm" => 4, "No" => 4, "Nu" => 4, "Num" => 4, "Numbers" => 4,
    "Ob" => 31, "Oba" => 31, "Obad" => 31, "Obadiah" => 31,
    "Phi" => 50, "Phil" => 50, "Philem" => 57, "Philemon" => 57, "Philippians" => 50,
    "Phlm" => 57, "Phm" => 57, "Php" => 50, "Pm" => 57, "Pp" => 50,
    "Pr" => 20, "Pro" => 20, "Prov" => 20, "Proverbs" => 20,
    "Ps" => 19, "Psa" => 19, "Psalm" => 19, "Psalms" => 19,
    "Re" => 66, "Rev" => 66, "Revelation" => 66,
    "Ro" => 45, "Rom" => 45, "Romans" => 45, "Rm" => 45,
    "Rt" => 8, "Ru" => 8, "Rut" => 8, "Ruth" => 8,
    "Rv" => 66, "Sg" => 22, "So" => 22, "Son" => 22, "Song" => 22,
    "Song of Solomon" => 22, "Song of Songs" => 22, "SS" => 22,
    "Tit" => 56, "Titus" => 56, "Tt" => 56,
    "Zc" => 38, "Zec" => 38, "Zech" => 38, "Zechariah" => 38,
    "Zep" => 36, "Zeph" => 36, "Zephaniah" => 36, "Zp" => 36,
    "书" => 6, "亚" => 38, "亞" => 38, "代上" => 13, "代下" => 14,
    "以弗所书" => 49, "以弗所書" => 49, "以斯帖記" => 17, "以斯帖记" => 17,
    "以斯拉記" => 15, "以斯拉记" => 15, "以西結書" => 26, "以西结书" => 26,
    "以賽亞書" => 23, "以赛亚书" => 23, "传" => 21, "传道书" => 21,
    "伯" => 18, "但" => 27, "但以理书" => 27, "但以理書" => 27,
    "何" => 28, "何西阿书" => 28, "何西阿書" => 28,
    "使徒行传" => 44, "使徒行傳" => 44, "來" => 58, "俄" => 31,
    "俄巴底亚书" => 31, "俄巴底亞書" => 31, "傳" => 21, "傳道書" => 21,
    "出" => 2, "出埃及記" => 2, "出埃及记" => 2, "列王紀上" => 11,
    "列王紀下" => 12, "列王纪上" => 11, "列王纪下" => 12, "创" => 1,
    "创世记" => 1, "利" => 3, "利未記" => 3, "利未记" => 3, "創" => 1,
    "創世記" => 1, "加" => 48, "加拉太书" => 48, "加拉太書" => 48,
    "历代志上" => 13, "历代志下" => 14, "可" => 41, "启" => 66,
    "启示录" => 66, "哀" => 25, "哈" => 35, "哈巴谷书" => 35,
    "哈巴谷書" => 35, "哈該書" => 37, "哈该书" => 37,
    "哥林多前书" => 46, "哥林多前書" => 46, "哥林多后书" => 47,
    "哥林多後書" => 47, "啟" => 66, "啟示錄" => 66, "士" => 7,
    "士师记" => 7, "士師記" => 7, "多" => 56, "太" => 40, "尼" => 16,
    "尼希米記" => 16, "尼希米记" => 16, "希伯來書" => 58, "希伯来书" => 58,
    "帖前" => 52, "帖后" => 53, "帖後" => 53, "帖撒罗尼迦" => 52,
    "帖撒羅尼迦" => 53, "弗" => 49, "弥" => 33, "弥迦书" => 33,
    "彌" => 33, "彌迦書" => 33, "彼前" => 60, "彼后" => 61, "彼後" => 61,
    "彼得前书" => 60, "彼得前書" => 60, "彼得后书" => 61, "彼得後書" => 61,
    "徒" => 44, "得" => 8, "拉" => 15, "拿" => 32, "提前" => 54,
    "提后" => 55, "提多书" => 56, "提多書" => 56, "提後" => 55,
    "提摩太前书" => 54, "提摩太前書" => 54, "提摩太后书" => 55,
    "提摩太後書" => 55, "摩" => 30, "撒上" => 9, "撒下" => 10,
    "撒母耳記上" => 9, "撒母耳記下" => 10, "撒母耳记上" => 9,
    "撒母耳记下" => 10, "撒迦利亚书" => 38, "撒迦利亞書" => 38,
    "斯" => 17, "書" => 6, "来" => 58, "林前" => 46, "林后" => 47,
    "林後" => 47, "歌" => 22, "歌罗西书" => 51, "歌羅西書" => 51,
    "歷代志上" => 13, "歷代志下" => 14, "民" => 4, "民数记" => 4,
    "民數記" => 4, "犹" => 65, "犹大书" => 65, "猶" => 65, "猶大書" => 65,
    "王上" => 11, "王下" => 12, "玛" => 39, "玛拉基书" => 39, "珥" => 29,
    "瑪" => 39, "瑪拉基書" => 39, "申" => 5, "申命記" => 5, "申命记" => 5,
    "番" => 36, "箴" => 20, "箴言" => 20, "約" => 43, "約一" => 62,
    "約壹" => 62, "約三" => 64, "約叁" => 64, "約二" => 63, "約貳" => 63,
    "約伯記" => 18, "約拿書" => 32, "約書亞記" => 6, "約珥書" => 29,
    "約翰一書" => 62, "約翰壹書" => 62, "約翰三書" => 64, "約翰叁書" => 64,
    "約翰二書" => 63, "約翰貳書" => 63, "約翰福音" => 43, "結" => 26,
    "约" => 43, "约一" => 62, "约壹" => 62, "约三" => 64, "约叁" => 64,
    "约书亚记" => 6, "约二" => 63, "约贰" => 63, "约伯记" => 18,
    "约拿书" => 32, "约珥书" => 29, "约翰一书" => 62, "约翰壹书" => 62,
    "约翰三书" => 64, "约翰叁书" => 64, "约翰二书" => 63, "约翰贰书" => 63,
    "约翰福音" => 43, "结" => 26, "罗" => 45, "罗马书" => 45, "羅" => 45,
    "羅馬書" => 45, "耶" => 24, "耶利米书" => 24, "耶利米哀歌" => 25,
    "耶利米書" => 24, "腓" => 50, "腓利門書" => 57, "腓利门书" => 57,
    "腓立比书" => 50, "腓立比書" => 50, "西" => 51, "西番雅书" => 36,
    "西番雅書" => 36, "詩" => 19, "詩篇" => 19, "該" => 37, "诗" => 19,
    "诗篇" => 19, "该" => 37, "賽" => 23, "赛" => 23, "路" => 42,
    "路加福音" => 42, "路得記" => 8, "路得记" => 8, "那鴻書" => 34,
    "那鸿书" => 34, "門" => 57, "门" => 57, "阿摩司书" => 30,
    "阿摩司書" => 30, "雅" => 59, "雅各书" => 59, "雅各書" => 59,
    "雅歌" => 22, "馬可福音" => 41, "馬太福音" => 40, "马可福音" => 41,
    "马太福音" => 40, "鴻" => 34, "鸿" => 34, "bk" => 100, "wiki" => 100,
    "百科" => 100, "baike" => 100, "wk" => 100, "百" => 100, "b" => 100, "w" => 100
];
krsort($book_index);
ini_set('display_errors', '0');

// Request parameter initialization
$request_params = [
    'mode' => '', 'a' => '', 'api' => '', 'b' => '', 'i' => '', 'c' => '',
    'v' => '', 'v2' => '', 'l' => '', 'm' => '', 'n' => '', 'o' => '1',
    'p' => '', 'q' => '', 's' => '', 'w' => '', 'strongs' => ''
];
foreach ($request_params as $key => $default) {
    $_REQUEST[$key] = isset($_REQUEST[$key]) ? trim($_REQUEST[$key]) : $default;
}
$_REQUEST['api'] = $_REQUEST['api'] ?: $_REQUEST['a'];

$mode = $_REQUEST['mode'] ?? '';
$search = $_REQUEST['s'] ?? '';
$index = $_REQUEST['i'] ?? '';
$chapter = (int)$_REQUEST['c'];
$verse = (int)$_REQUEST['v'];
$verse2 = (int)$_REQUEST['v2'];
$books = $_REQUEST['b'] ?? '';
$options = $_REQUEST['o'] ?? '';
[$book, $book2] = array_pad(explode("-", $books, 2), 2, '');
$book = $book ? (int)$book : 0;
$book2 = $book2 ? (int)$book2 : 0;
$name = $_REQUEST['n'] ?? '';
$portable = $_REQUEST['p'] ?? '';
$query = trim($_REQUEST['q'] ?? '');
$multi_verse = (int)($_REQUEST['m'] ?? 0);
$context = isset($_REQUEST['e']) ? (int)$_REQUEST['e'] : 0;
$search_table = 'bible_search';
$language = strtolower($_REQUEST['l'] ?? 'cn') ?: 'cn';
$wiki = $_REQUEST['w'] ?? '';
$api = $_REQUEST['api'] ?? '';
$script = 'index.php';
$strongs = $_REQUEST['strongs'] ?? '';

// Preserve original query for title BEFORE any processing (including votd)
// This captures the query as it comes from the URL (e.g., "Gen 10:21" from Gen.10.21.htm)
$original_query = $query ? trim($query) : '';

if (!$query) {
    require_once __DIR__ . '/votd.php';
    $query = $votd_string ?? '';
    // Update original_query if we got a votd and original was empty
    if ($query && !$original_query) {
        $original_query = $query;
    }
}

$query = str_replace(['　', '：', '，', '.', '—', '－', '–', '；', '／'], [' ', ':', ',', ' ', '-', '-', '-', ';', '/'], $query);
preg_match("/@([^ ]+) /", $query, $query_option_array);
$query_options = $query_option_array[1] ?? '';
$query_without_options = preg_replace("/@([^ ]+) /", "", $query);
[$query_option, $query_option2] = array_pad(explode("-", $query_options, 2), 2, '');

if ($query_options) {
    if (is_numeric($query_option)) {
        $book = (int)$query_option;
    } elseif (isset($book_index[$query_option])) {
        $book = $book_index[$query_option];
    }
    if ($query_option2 && is_numeric($query_option2)) {
        $book2 = (int)$query_option2;
    } elseif ($query_option2 && isset($book_index[$query_option2])) {
        $book2 = $book_index[$query_option2];
    }
}

$queries = explode(" ", $query_without_options);

// CUVS, CUVT, and KJV are enabled by default
$cuvs = (isset($_REQUEST['cuvs']) && ($_REQUEST['cuvs'] === '' || $_REQUEST['cuvs'] === '0')) ? "" : "cuvs";
$cuvt = (isset($_REQUEST['cuvt']) && ($_REQUEST['cuvt'] === '' || $_REQUEST['cuvt'] === '0')) ? "" : "cuvt";
$cuvc = isset($_REQUEST['cuvc']) ? "cuvc" : "";
$ncvs = isset($_REQUEST['ncvs']) ? "ncvs" : "";
$pinyin = isset($_REQUEST['pinyin']) ? "pinyin" : "";
$lcvs = isset($_REQUEST['lcvs']) ? "lcvs" : "";
$ccsb = isset($_REQUEST['ccsb']) ? "ccsb" : "";
$clbs = isset($_REQUEST['clbs']) ? "clbs" : "";
$kjv = (isset($_REQUEST['kjv']) && ($_REQUEST['kjv'] === '' || $_REQUEST['kjv'] === '0')) ? "" : "kjv";
$nasb = isset($_REQUEST['nasb']) ? "nasb" : "";
$esv = isset($_REQUEST['esv']) ? "esv" : "";
$ukjv = isset($_REQUEST['ukjv']) ? "ukjv" : "";
$kjv1611 = isset($_REQUEST['kjv1611']) ? "kjv1611" : "";
$bbe = isset($_REQUEST['bbe']) ? "bbe" : "";
$tr = isset($_REQUEST['tr']) ? "tr" : "";
$wlc = isset($_REQUEST['wlc']) ? "wlc" : "";
$ckjvs = isset($_REQUEST['ckjvs']) ? "ckjvs" : "";
$ckjvt = isset($_REQUEST['ckjvt']) ? "ckjvt" : "";

$cn = isset($_REQUEST['cn']) ? 1 : 0;
$en = isset($_REQUEST['en']) ? 1 : 0;
$tw = isset($_REQUEST['tw']) ? 1 : 0;

if (!$cn && !$en && !$tw) {
    $cn = 1;
    $tw = 0;
    $en = 1;
    $pinyin = "pinyin";
    $cuvc = "cuvc";
}

if ($en) {
    $nasb = "nasb";
}

$bible_books = array_filter([$cuvs, $cuvt, $kjv, $nasb, $esv, $ncvs, $cuvc, $lcvs, $pinyin, $ccsb, $ckjvs, $ckjvt, $clbs, $ukjv, $kjv1611, $bbe]);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/config/dbconfig.php';

try {
    if (!file_exists(__DIR__ . '/config/dbconfig.php')) {
        throw new Exception("Error: " . __DIR__ . "/config/dbconfig.php not found");
    }
    require_once __DIR__ . '/config/dbconfig.php';

    if (!isset($dbhost, $dbuser, $dbpassword, $database)) {
        throw new Exception("Error: Database configuration variables not set in dbconfig.php");
    }

    $dbport_int = isset($dbport) ? (int)$dbport : 3306;
    $db = new mysqli($dbhost, $dbuser, $dbpassword, $database, $dbport_int);
    if ($db->connect_error) {
        throw new Exception("Connection Error: " . $db->connect_error);
    }
    // Use utf8mb4 for full UTF-8 support (including 4-byte characters)
    $db->set_charset('utf8mb4');
    // Also set the connection collation and character set variables
    $db->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    $db->query("SET CHARACTER SET utf8mb4");
    // Set connection charset for client, results, and connection
    $db->query("SET character_set_client = utf8mb4");
    $db->query("SET character_set_results = utf8mb4");
    $db->query("SET character_set_connection = utf8mb4");
    // Ensure binary mode is off for proper text handling
    $db->query("SET sql_mode = ''");
} catch (Exception $e) {
    die($e->getMessage());
}

if (!$mode && !$book && !$query && !$wiki) {
    $name = $name ?: 'John';
    $chapter = $chapter ?: 3;
    $verse = 16;
    $mode = 'READ';
}

if (!$query && $mode === 'READ') {
    $book = $book_index[$name] ?? 43;
    if ($book <= 0 || $book > 66 && $book != 100) {
        $book = 43;
    }
}

if ($book == 100) {
    global $wiki_search_base;
    header("Location: $wiki_search_base/index.php?title=Special%3A%E6%90%9C%E7%B4%A2&go=%E5%89%8D%E5%BE%80&search=" . urlencode($query));
    exit;
}

if (!$wiki && (!$chapter || $chapter < 1)) {
    $chapter = 1;
}
if (isset($book_count[$book]) && $chapter > $book_count[$book]) {
    $chapter = $book_count[$book];
} elseif (!isset($book_count[$book])) {
    $chapter = 1;
}
if (!$verse) {
    $verse = 1;
}

// Query processing
$do_query = true;
$querystr = '';
$sql = '';
$count = 0;

if ($query) {
    $current_bookname = '';
    $current_book = 0;
    if (preg_match("/[0-9]/", $query_without_options)) {
        $query = str_replace(" ", "", strtolower($query_without_options));
        $segments = explode(";", $query);
        foreach ($segments as $segment) {
            $sql_where = '';
            $found = false;
            foreach ($book_index as $book_name => $ii) {
                $pattern = "/^" . preg_quote($book_name, '/') . " ?[0-9]+/i";
                if (preg_match($pattern, $segment)) {
                    $found = true;
                    $current_bookname = $book_name;
                    $book = $ii;
                    $current_book = $book;
                    $sql_where = " (book = $ii) ";
                    $references = str_replace(" ", "", substr($segment, strlen($book_name)));
                    [$reference1, $reference2] = array_pad(explode("-", $references, 2), 2, '');
                    [$r1, $r2] = array_pad(explode(":", $reference1, 2), 2, '');
                    [$r3, $r4] = array_pad(explode(":", $reference2, 2), 2, '');
                    [$ir1, $ir2, $ir3, $ir4] = [(int)$r1, (int)$r2, (int)$r3, (int)$r4];

                    if (!$reference2) {
                        if ($ir1) {
                            $sql_where .= " AND (chapter=$ir1) ";
                            $chapter = $ir1;
                        } else {
                            $echo_string = t('format_error') . " John 3";
                        }
                        if ($r2) {
                            $verses_temp = explode(",", $r2);
                            if ((int)$verses_temp[0]) {
                                $verse = $verse2 = (int)$verses_temp[0];
                                $sql_where .= " AND (verse BETWEEN " . ((int)$verses_temp[0] - $context) . " AND " . ((int)$verses_temp[0] + $context);
                                for ($iii = 1; $iii < count($verses_temp); $iii++) {
                                    $sql_where .= " OR verse BETWEEN " . ((int)$verses_temp[$iii] - $context) . " AND " . ((int)$verses_temp[$iii] + $context);
                                    $verse = $verse2 = (int)$verses_temp[$iii];
                                }
                                $sql_where .= ") ";
                            } else {
                                $echo_string = t('verse_format_error') . " John 3:16或者 John 3:16,19";
                            }
                        }
                    } else {
                        if (!$r2 && !$r4) {
                            if ($ir1 && $ir3) {
                                $sql_where .= " AND (chapter BETWEEN $ir1 AND $ir3)";
                                $chapter = $ir1;
                            } else {
                                $echo_string = t('format_error') . " John 3-4";
                            }
                        } elseif ($r2 && !$r4) {
                            [$chapter_temp, $verse_string_temp] = array_pad(explode(":", $references, 2), 2, '');
                            $verse_array_temp = explode(",", $verse_string_temp);
                            if (count($verse_array_temp) > 0) {
                                $sql_where .= "AND (chapter = " . (int)$chapter_temp . ") AND ( (1 = 0) ";
                                $chapter = (int)$chapter_temp;
                                foreach ($verse_array_temp as $verse_temp) {
                                    [$verse1_temp, $verse2_temp] = array_pad(explode("-", $verse_temp, 2), 2, '');
                                    $verse = (int)$verse1_temp;
                                    $verse2 = (int)$verse2_temp;
                                    if ((int)$verse2_temp) {
                                        $sql_where .= " OR (verse BETWEEN " . (int)$verse1_temp . " AND " . (int)$verse2_temp . ") ";
                                    } else {
                                        $sql_where .= " OR (verse = " . (int)$verse1_temp . ") ";
                                    }
                                }
                                $sql_where .= ") ";
                            } else {
                                $echo_string = t('verse_format_error') . " John 3:16-18 或 John 3:16-18,19-21 或 John 3:16-18,20";
                            }
                        } elseif (!$r2 && $ir3 && $ir4) {
                            $irr = $ir3 - 1;
                            $sql_where .= " AND ( (chapter BETWEEN $ir1 AND $irr) OR ( (chapter = $ir3) AND (verse BETWEEN 1 AND $ir4)))";
                            $chapter = $ir1;
                            $verse = 1;
                            $verse2 = $ir4;
                        } else {
                            $echo_string = t('format_error') . " John 3-5:6";
                        }
                    }
                    break;
                }
            }
            if (!$found && $current_book) {
                $sql_where = " (book = $current_book) ";
                $references = str_replace(" ", "", $segment);
                [$reference1, $reference2] = array_pad(explode("-", $references, 2), 2, '');
                [$r1, $r2] = array_pad(explode(":", $reference1, 2), 2, '');
                [$r3, $r4] = array_pad(explode(":", $reference2, 2), 2, '');
                [$ir1, $ir2, $ir3, $ir4] = [(int)$r1, (int)$r2, (int)$r3, (int)$r4];

                if (!$reference2) {
                    if ($ir1) {
                        $sql_where .= " AND (chapter=$ir1) ";
                        $chapter = $ir1;
                    } else {
                        $echo_string = "章节格式错误，可能章号不正确，正确格式参考： John 3";
                    }
                    if ($r2) {
                        $verses_temp = explode(",", $r2);
                        if ((int)$verses_temp[0]) {
                            $verse = $verse2 = (int)$verses_temp[0];
                            $sql_where .= " AND (verse BETWEEN " . ((int)$verses_temp[0] - $context) . " AND " . ((int)$verses_temp[0] + $context);
                            for ($iii = 1; $iii < count($verses_temp); $iii++) {
                                $sql_where .= " OR verse BETWEEN " . ((int)$verses_temp[$iii] - $context) . " AND " . ((int)$verses_temp[$iii] + $context);
                                $verse = $verse2 = (int)$verses_temp[$iii];
                            }
                            $sql_where .= ") ";
                        } else {
                            $echo_string = "章节格式错误，可能节号不正确，正确格式参考： John 3:16或者 John 3:16,19";
                        }
                    }
                } else {
                    if (!$r2 && !$r4) {
                        if ($ir1 && $ir3) {
                            $sql_where .= " AND (chapter BETWEEN $ir1 AND $ir3)";
                            $chapter = $ir1;
                        } else {
                            $echo_string = "章节格式错误，可能章号不正确，正确格式参考： John 3-4";
                        }
                    } elseif ($r2 && !$r4) {
                        [$chapter_temp, $verse_string_temp] = array_pad(explode(":", $references, 2), 2, '');
                        $verse_array_temp = explode(",", $verse_string_temp);
                        if (count($verse_array_temp) > 0) {
                            $sql_where .= "AND (chapter = " . (int)$chapter_temp . ") AND ( (1 = 0) ";
                            $chapter = (int)$chapter_temp;
                            foreach ($verse_array_temp as $verse_temp) {
                                [$verse1_temp, $verse2_temp] = array_pad(explode("-", $verse_temp, 2), 2, '');
                                $verse = (int)$verse1_temp;
                                $verse2 = (int)$verse2_temp;
                                if ((int)$verse2_temp) {
                                    $sql_where .= " OR (verse BETWEEN " . (int)$verse1_temp . " AND " . (int)$verse2_temp . ") ";
                                } else {
                                    $sql_where .= " OR (verse = " . (int)$verse1_temp . ") ";
                                }
                            }
                            $sql_where .= ") ";
                        } else {
                            $echo_string = t('verse_format_error') . " John 3:16-18 或 John 3:16-18,19-21 或 John 3:16-18,20";
                        }
                    } elseif (!$r2 && $ir3 && $ir4) {
                        $irr = $ir3 - 1;
                        $sql_where .= " AND ( (chapter BETWEEN $ir1 AND $irr) OR ( (chapter = $ir3) AND (verse BETWEEN 1 AND $ir4)))";
                        $chapter = $ir1;
                        $verse = 1;
                        $verse2 = $ir4;
                    } else {
                        $echo_string = t('format_error') . " John 3-5:6";
                    }
                }
            }
            if ($sql_where && !$echo_string) {
                $sql .= ($sql ? " UNION " : "") . "SELECT * FROM $search_table WHERE $sql_where";
            }
        }
    } else {
        // Query doesn't contain numbers, treat as text search
        if (!$mode) {
            $mode = 'QUERY';
        }
    }
}
if ($sql && !$echo_string) {
    try {
        // Debug: Print SQL query
        if (isset($_REQUEST['debug']) || isset($_GET['debug'])) {
            echo "<!-- DEBUG SQL (index query): " . htmlspecialchars($sql) . " -->\n";
            $echo_string .= "<pre style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc;'>DEBUG SQL (index query):\n" . htmlspecialchars($sql) . "</pre>";
        }
        $result = $db->query($sql);
        if ($result === false) {
            $error_msg = "Query Error: " . $db->error;
            if (isset($_REQUEST['debug']) || isset($_GET['debug'])) {
                $error_msg .= "\n\nSQL Query:\n" . htmlspecialchars($sql);
            }
            throw new Exception($error_msg);
        }
        $count = $result->num_rows;
        $querystr = '';
        while ($row = $result->fetch_assoc()) {
            $count++;
            $bid = (int)$row['book'];
            $cid = (int)$row['chapter'];
            $vid = (int)$row['verse'];
            $querystr .= "$bid:$cid:$vid,";
            if ($count > $max_record_count) {
                $echo_string = "索引经文章节超过500条，请缩小范围后重新索引";
                $querystr = '';
                break;
            }
        }
        $querystr = rtrim($querystr, ',');
        $index = $querystr;
        $mode = 'INDEX';
        $do_query = false;
        $result->free();
    } catch (Exception $e) {
        $echo_string = "Database query error: " . $e->getMessage();
    }
}

if ($mode === 'QUERY' && $do_query) {
    // Filter out empty queries
    $queries = array_filter($queries, function($q) { return trim($q) !== ''; });
    $queries = array_values($queries); // Re-index array
    
    $count = count($queries);
    if ($count > 10) {
        $echo_string = "至多10个关键词，请缩小关键词的数量以降低服务器的开销。";
        $do_query = false;
    }

    if ($multi_verse) {
        $search_table = 'bible_multi_search';
    } else {
        $search_table = 'bible_search';
    }

    $sql_where = '';
    if ($book2) {
        $sql_where = " book BETWEEN $book AND $book2 ";
    } elseif ($book) {
        $sql_where = " book = $book";
    } else {
        $sql_where = " 1=1 ";
    }

    if ($do_query && $count > 0 && isset($queries[0]) && trim($queries[0]) !== '') {
        try {
            $sql = "SELECT book, chapter, verse FROM $search_table WHERE txt LIKE '%" . $db->real_escape_string($queries[0]) . "%'";
            for ($i = 1; $i < $count && isset($queries[$i]); ++$i) {
                $sql .= " AND txt LIKE '%" . $db->real_escape_string($queries[$i]) . "%' ";
            }
            if ($sql_where) {
                $sql .= " AND (" . $sql_where . ") ";
            }

                // Debug: Print SQL query
                if (isset($_REQUEST['debug']) || isset($_GET['debug'])) {
                    echo "<!-- DEBUG SQL (search query): " . htmlspecialchars($sql) . " -->\n";
                    $echo_string .= "<pre style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc;'>DEBUG SQL (search query):\n" . htmlspecialchars($sql) . "</pre>";
                }
                $result = $db->query($sql);
                if ($result === false) {
                    $error_msg = "Query Error: " . $db->error;
                    if (isset($_REQUEST['debug']) || isset($_GET['debug'])) {
                        $error_msg .= "\n\nSQL Query:\n" . htmlspecialchars($sql);
                    }
                    throw new Exception($error_msg);
                }

            $querystr = '';
            $querystrtext = '';
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $bid = (int)$row['book'];
                $cid = (int)$row['chapter'];
                $vid = (int)$row['verse'];
                $querystr .= "$bid:$cid:$vid,";
                if ($language === 'tw') {
                    $querystrtext .= $book_tw[$bid] . ":$cid:$vid,";
                    $responsetext[$i] = [$book_tw[$bid], $cid, $vid];
                } elseif ($language === 'en') {
                    $querystrtext .= $book_en[$bid] . ":$cid:$vid,";
                    $responsetext[$i] = [$book_en[$bid], $cid, $vid];
                } else {
                    $querystrtext .= $book_cn[$bid] . ":$cid:$vid,";
                    $responsetext[$i] = [$book_cn[$bid], $cid, $vid];
                }
                $response[$i] = [$bid, $cid, $vid];
                $i++;
                $count = $i;
                if ($i >= $max_record_count) {
                    $echo_string .= "<h2>" . t('too_many_records', $max_record_count) . "</h2>";
                    break;
                }
            }
            $querystr = rtrim($querystr, ',');
            if ($querystr) {
                $index = $querystr;
                $echo_string .= "<p>" . t('found_records', $count) . "</p>";
            } else {
                $index = '';
                $echo_string .= "<h2>" . t('no_records') . "</h2>";
            }
            $result->free();
        } catch (Exception $e) {
            $error_msg = "Database query error: " . $e->getMessage();
            if (isset($_REQUEST['debug']) || isset($_GET['debug'])) {
                $error_msg .= "\n\nSQL Query:\n" . htmlspecialchars($sql ?? 'N/A');
            }
            $echo_string = $error_msg;
        }
    }
}

if ($mode === 'QUERY' && in_array($api, ['json', 'text', 'plain', 'html'])) {
    if ($api === 'json') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } elseif ($api === 'text') {
        header('Content-Type: text/plain');
        echo htmlspecialchars($querystrtext);
        exit;
    } else {
        header('Content-Type: text/plain');
        echo htmlspecialchars($querystr);
        exit;
    }
}

// Build english_title from book/chapter/verse (updated after query parsing)
// Only build if we have a valid book number
$english_title = '';
$short_url_title = '';
if ($book && isset($book_chinese[$book], $book_english[$book])) {
    $english_title = $book_chinese[$book] . " " . $book_english[$book];
    $short_url_title = "$short_url_base/" . ($book_short[$book] ?? '');
    if ($chapter) {
        $english_title .= " $chapter";
        $short_url_title .= ".$chapter";
    }
    if ($verse) {
        $english_title .= ":$verse";
        $short_url_title .= ".$verse";
        $show_verse = true;
    } else {
        $show_verse = false;
    }
    if ($index) {
        $show_verse = true;
    }
    if ($verse2) {
        $english_title .= "-$verse2";
        $short_url_title .= "-$verse2";
    }
} else {
    $show_verse = false;
    // If we have search results (index is set), we should show verses
    if ($index) {
        $show_verse = true;
    }
}

// Build title - prefer original query if it looks like a verse reference
// For short URLs like "Deut.2.10.htm" -> "Deut 2:10", use the original query format
$title = '';
// Always prefer original_query if it exists and looks like a verse reference
// Debug: Check what original_query contains (remove after testing)
if (isset($_REQUEST['debug']) && $_REQUEST['debug'] == '1') {
    echo "<!-- DEBUG: original_query = '" . htmlspecialchars($original_query) . "' -->\n";
    echo "<!-- DEBUG: english_title = '" . htmlspecialchars($english_title) . "' -->\n";
    echo "<!-- DEBUG: book = $book, chapter = $chapter, verse = $verse -->\n";
}
if ($original_query && trim($original_query) !== '') {
    // Check if it looks like a verse reference (book name + numbers)
    // This matches patterns like "Deut 2:10", "Deut2:10", "Gen 10:21", "约 3:16", etc.
    // Pattern: starts with letters (book name) and contains digits
    // Use \x{...} format for Unicode ranges (PCRE2 compatible)
    if (preg_match('/^[a-zA-Z\x{4e00}-\x{9fff}]+/u', $original_query) && preg_match('/\d/', $original_query)) {
        // Normalize the format: ensure space before chapter number if missing
        // "Deut2:10" -> "Deut 2:10", "Deut 2:10" stays "Deut 2:10"
        if (!preg_match('/\s/', $original_query)) {
            // No space found, add it: "Deut2:10" -> "Deut 2:10"
            $title = preg_replace('/([a-zA-Z\x{4e00}-\x{9fff}]+)(\d+):(\d+)/u', '${1} ${2}:${3}', $original_query);
        } else {
            // Space already present, use as-is (e.g., "Gen 10:21", "Deut 2:10")
            $title = $original_query;
        }
    } else {
        // Doesn't look like a verse reference, but use it anyway if it's not empty
        $title = $original_query;
    }
}
// Only use english_title if original_query is empty or doesn't look like a verse reference
if ((!$title || trim($title) === '') && $english_title && trim($english_title) !== '') {
    $title = $english_title;
}
// Final fallback
if (!$title || trim($title) === '') {
    $title = $original_query ?: ($english_title ?: '');
}
$title .= " - $sitename";

$ot_text = function_exists('t') ? t('old_testament') : '旧约 (OT)';
$book_menu = "<p>" . $ot_text . " ";
$wiki_book_menu = "<p>== " . (function_exists('t') ? t('old_testament') : '旧约') . " ==</p><p> </p>\n";
for ($i = 1; $i <= 66; ++$i) {
    if ($book == $i) {
        $book_menu .= " <strong>";
    }
    // Get translated book names based on current language
    $book_names = function_exists('getBookNames') ? getBookNames() : null;
    if ($book_names) {
        $book_long = $book_names['long'][$i];
        $book_short_display = $book_names['short'][$i];
    } else {
        // Fallback to original arrays
        $book_long = $book_chinese[$i];
        $book_short_display = $book_cn[$i];
    }
    // Display format: Show only the current language
    // e.g., for zh_tw: "雅各書(雅)", for zh_cn: "雅各书(雅)", for en: "James(Jas)"
    $book_display = $book_long . "(" . $book_short_display . ")";
    // For title attribute, show both languages for reference
    $book_title = $book_chinese[$i] . " (" . $book_english[$i] . ")";
    
    if ($short_url_base) {
        $book_menu .= "   <a href=\"$short_url_base/{$book_short[$i]}.htm\" title=\"" . htmlspecialchars($book_title) . "\">" . htmlspecialchars($book_display) . "</a> ";
    } else {
        $book_menu .= "   <a href=\"$script?q={$book_short[$i]} 1\" title=\"" . htmlspecialchars($book_title) . "\">" . htmlspecialchars($book_display) . "</a> ";
    }
    if ($book == $i) {
        $book_menu .= "</strong>";
    }
    // Wiki menu uses same format: Show only the current language
    $wiki_display = $book_long . "(" . $book_short_display . ")";
    if ($chapter) {
        $wiki_book_menu .= "<p>[[MHC:{$book_chinese[$i]} | " . htmlspecialchars($wiki_display) . "]]</p>\n";
    } else {
        $wiki_book_menu .= "<p>[[MHC:{$book_chinese[$i]} | " . htmlspecialchars($wiki_display) . "]]</p>\n";
    }
    if ($i == 39) {
        // Use translated "New Testament" text
        $nt_text = function_exists('t') ? t('new_testament') : '新约 (NT)';
        $book_menu .= " <br/>" . $nt_text . " ";
        $wiki_book_menu .= "\n<p> == " . (function_exists('t') ? t('new_testament') : '新约') . " == </p><p> </p>\n";
    }
    $book_menu .= "\n";
    $wiki_book_menu .= "\n";
}
$book_menu .= "</p>";
$wiki_book_menu .= "\n";

$book_chinese_val = $book_chinese[$book] ?? '';
$book_cn_val = $book_cn[$book] ?? '';
$book_english_val = $book_english[$book] ?? '';
$book_short_val = $book_short[$book] ?? '';
$book_count_val = $book_count[$book] ?? 0;

// Build chapter menu with consistent format: "创世记(创) Genesis(Gen)  1  2  3..."
$chapter_menu = '';
if (isset($book_chinese[$book], $book_cn[$book], $book_english[$book], $book_short[$book])) {
    $chapter_menu = "{$book_chinese[$book]}({$book_cn[$book]}) {$book_english[$book]}({$book_short[$book]}) ";
}
$wiki_chapter_menu = "<p>=={$book_chinese_val}目录==</p><p> </p>\n";
for ($i = 1; $i <= $book_count_val; $i++) {
    if ($i == $chapter) {
        $chapter_menu .= "<strong>";
    }
    if ($short_url_base) {
        $chapter_menu .= "<a href=\"$short_url_base/{$book_short_val}.$i.htm\" title=\"{$book_chinese_val} $i   {$book_english_val} $i\"> $i </a>";
    } else {
        $chapter_menu .= "<a href=\"$script?q={$book_short_val} $i\" title=\"{$book_chinese_val} $i   {$book_english_val} $i\"> $i </a>";
    }
    if ($chapter) {
        $wiki_chapter_menu .= "<p>[[MHC:{$book_chinese_val} $i | {$book_cn_val} $i]]</p>\n";
    } else {
        $wiki_chapter_menu .= "<p>[[MHC:{$book_chinese_val} $i | {$book_chinese_val} $i]]</p>\n";
    }
    if ($i == $chapter) {
        $chapter_menu .= "</strong>";
    }
    // Add space after each chapter number (but not newline)
    $chapter_menu .= " ";
    $wiki_chapter_menu .= "\n";
    // Only add line breaks when viewing all chapters (not a specific chapter)
    if (!$chapter && ($i % 5) == 0) {
        $chapter_menu .= "<br/>\n";
        $wiki_chapter_menu .= "<br/>\n";
    }
}

// Initialize SQL variable
$sql = '';

if ($index) {
    if (empty($bible_books)) {
        $echo_string = t('no_translation_selected');
        $sql = '';
    } else {
        $sql = "SELECT bible_books.* ";
        $book_count = 0;
        foreach ($bible_books as $bible_book) {
            if ($bible_book) {
                $sql .= ", $bible_book.Scripture AS text_$bible_book ";
                $book_count++;
                if ($book_count > $max_book_count) {
                    $echo_string .= "<h2>" . t('too_many_translations', $max_book_count) . "</h2>";
                    break;
                }
            }
        }
        $sql .= " FROM bible_books ";
        foreach ($bible_books as $bible_book) {
            if ($bible_book) {
                $sql .= ", bible_book_$bible_book AS $bible_book";
            }
        }
        $sql .= " WHERE (1=1 ";
        foreach ($bible_books as $bible_book) {
            if ($bible_book) {
                $sql .= " AND (bible_books.book=$bible_book.book AND bible_books.chapter=$bible_book.chapter AND bible_books.verse=$bible_book.verse) ";
            }
        }
        $sql .= ") AND ( 1=0 ";
        $verses = explode(",", $index);
        $verse_count = count($verses);
        $has_verses = false;
        for ($i = 0; $i < $verse_count; $i++) {
            [$verse_book, $verse_chapter, $verse_verse] = array_pad(explode(":", $verses[$i]), 3, '');
            if ($verse_book && $verse_chapter && $verse_verse) {
                $sql .= " OR (bible_books.book=" . (int)$verse_book . " AND bible_books.chapter=" . (int)$verse_chapter . " AND bible_books.verse=" . (int)$verse_verse . ")";
                $has_verses = true;
            }
        }
        if (!$has_verses) {
            $echo_string = t('index_format_error');
            $sql = '';
        } else {
            $sql .= ") ";
        }
    }
} else {
    if (($mode === 'QUERY' && !$echo_string) || $mode === 'READ') {
        if (empty($bible_books)) {
            $echo_string = t('no_translation_selected');
            $sql = '';
        } else {
            $sql = "SELECT bible_books.* ";
            foreach ($bible_books as $bible_book) {
                if ($bible_book) {
                    $sql .= ", $bible_book.Scripture AS text_$bible_book ";
                }
            }
            $sql .= " FROM bible_books";
            foreach ($bible_books as $bible_book) {
                if ($bible_book) {
                    $sql .= ", bible_book_$bible_book AS $bible_book ";
                }
            }
            $sql .= " WHERE 1=1 ";
            foreach ($bible_books as $bible_book) {
                if ($bible_book) {
                    $sql .= " AND (bible_books.book=$bible_book.book AND bible_books.chapter=$bible_book.chapter AND bible_books.verse=$bible_book.verse) ";
                }
            }
            if ($chapter) {
                $sql .= " AND bible_books.book = " . (int)$book . " AND bible_books.chapter=" . (int)$chapter;
                if ($verse) {
                    if ($verse2) {
                        $sql .= " AND bible_books.verse >= " . (int)$verse . " AND bible_books.verse <= " . (int)$verse2;
                    } else {
                        $sql .= " AND bible_books.verse >= " . ((int)$verse - 3) . " AND bible_books.verse <= " . ((int)$verse + 3);
                    }
                }
            }
        }
    }
}

if (!empty($sql)) {
    $sql .= " ORDER BY bible_books.book, bible_books.chapter, bible_books.verse";
}

// Debug: Print SQL query (show even if there's an error)
if ((isset($_REQUEST['debug']) || isset($_GET['debug'])) && !empty($sql)) {
    echo "<!-- DEBUG SQL: " . htmlspecialchars($sql) . " -->\n";
    $echo_string .= "<pre style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc;'>DEBUG SQL:\n" . htmlspecialchars($sql) . "</pre>";
}

// Execute SQL query if we have SQL and either:
// 1. We have an index (search results or verse references), OR
// 2. We don't have an error message in echo_string
// Check if echo_string contains "found records" message (translated) or is empty
// Check for translated "found records" message in all languages
$found_patterns = ['共查到', 'Found', '<b>'];
$has_found_message = false;
if (!empty($echo_string)) {
    foreach ($found_patterns as $pattern) {
        if (strpos($echo_string, $pattern) !== false) {
            $has_found_message = true;
            break;
        }
    }
}
if (!empty($sql) && ($index || empty($echo_string) || $has_found_message)) {
    try {
        $result = $db->query($sql);
        if ($result === false) {
            $error_msg = "Query Error: " . $db->error;
            if (isset($_REQUEST['debug']) || isset($_GET['debug'])) {
                $error_msg .= "\n\nSQL Query:\n" . htmlspecialchars($sql);
            }
            throw new Exception($error_msg);
        }

        if (!$index) {
            $book_taiwan_val = $book_taiwan[$book] ?? '';
            $book_tw_val = $book_tw[$book] ?? '';
            $book_chinese_val2 = $book_chinese[$book] ?? '';
            $book_cn_val2 = $book_cn[$book] ?? '';
            $book_english_val2 = $book_english[$book] ?? '';
            $book_en_val = $book_en[$book] ?? '';
            $text_tw .= "<b>" . $book_taiwan_val . " (" . $book_tw_val . ") $chapter</b>\n";
            $text_cn .= "<b>" . $book_chinese_val2 . " (" . $book_cn_val2 . ") $chapter</b>\n";
            $text_en .= "<b>" . $book_english_val2 . " (" . $book_en_val . ") $chapter</b>\n";
        }
        $book_chinese_val3 = $book_chinese[$book] ?? '';
        $wiki_text = "<p> </p> ==" . $book_chinese_val3 . " $chapter 目录==<p> </p>\n";
        $verse_number = 0;
        
        // Initialize arrays to store block text for each translation
        // This will be used for the block/chapter display section
        $block_texts = [];
        foreach ($bible_books as $bible_book) {
            if ($bible_book) {
                $block_texts[$bible_book] = '';
            }
        }
        
        // Detect if we're in whole chapter mode
        // Whole chapter mode: not a search result ($index is empty) and we have a specific book and chapter
        $is_whole_chapter = (!$index && $book > 0 && $chapter > 0);
        
        // Track unique books and chapters during processing to verify whole chapter mode
        $unique_books = [];
        $unique_chapters = [];
        
        // Add section header for verse-by-verse display
        $text_cmp .= "<h2>" . t('verse_by_verse_full') . "</h2>\n";

        while ($row = $result->fetch_assoc()) {
            $bid = isset($row['book']) ? (int)$row['book'] : 0;
            $cid = isset($row['chapter']) ? (int)$row['chapter'] : 0;
            $vid = isset($row['verse']) ? (int)$row['verse'] : 0;
            $likes = isset($row['likes']) ? (int)$row['likes'] : 0;
            
            // Track unique books and chapters to detect whole chapter mode
            if ($bid > 0) {
                $unique_books[$bid] = true;
                if ($cid > 0) {
                    $unique_chapters["$bid:$cid"] = true;
                }
            }
            
            // Fix encoding issues - ensure all text is properly UTF-8
            $txt_tw = isset($row['text_cuvt']) ? $row['text_cuvt'] : '';
            $txt_cn = isset($row['text_cuvs']) ? $row['text_cuvs'] : '';
            $txt_en = isset($row['text_kjv']) ? $row['text_kjv'] : '';
            
            // Fix encoding for KJV text using proper encoding detection and conversion
            // The "" character (U+FFFD) indicates invalid UTF-8 sequences or encoding mismatch
            if (!empty($txt_en)) {
                $utf8_replacement_char = "\xEF\xBF\xBD"; // UTF-8 replacement character bytes
                $has_replacement_sequence = (strpos($txt_en, 'ï¿½') !== false);
                $has_replacement_char = (strpos($txt_en, $utf8_replacement_char) !== false || 
                                         strpos($txt_en, '') !== false);
                $is_valid_utf8 = mb_check_encoding($txt_en, 'UTF-8');
                
                // If we have replacement characters, the data encoding doesn't match the connection charset
                // Try to fix by reading the raw bytes and converting from the actual source encoding
                if ($has_replacement_char || $has_replacement_sequence || !$is_valid_utf8) {
                    // Strategy: The database might be storing data in latin1/ISO-8859-1 but we're reading as UTF-8
                    // OR the data has invalid UTF-8 sequences that need to be cleaned
                    
                    // First, try to get the raw bytes from MySQL by reading as binary, then convert
                    // Since we can't easily do that here, we'll try reverse conversion:
                    // If we see replacement chars, try treating the string as if it came from latin1
                    
                    // Method 1: Try ISO-8859-1 -> UTF-8 conversion
                    // This handles the case where latin1 data is being read as UTF-8
                    $test1 = @mb_convert_encoding($txt_en, 'UTF-8', 'ISO-8859-1');
                    if ($test1 !== false && mb_check_encoding($test1, 'UTF-8')) {
                            // Check if conversion improved things (fewer replacement chars)
                            // Use bytes for replacement character to avoid empty string issues
                            $replacement_bytes = "\xEF\xBF\xBD";
                            $replacement_sequence = 'ï¿½';
                            // Count replacement characters - avoid using empty string in substr_count
                            $original_bad = substr_count($txt_en, $replacement_bytes);
                            if (strpos($txt_en, $replacement_sequence) !== false) {
                                $original_bad += substr_count($txt_en, $replacement_sequence);
                            }
                            // Check for replacement character using mb_strpos to handle UTF-8 properly
                            $replacement_char_code = "\xEF\xBF\xBD";
                            if (mb_strpos($txt_en, $replacement_char_code, 0, 'UTF-8') !== false) {
                                $original_bad += 1;
                            }
                            
                            $test1_bad = substr_count($test1, $replacement_bytes);
                            if (strpos($test1, $replacement_sequence) !== false) {
                                $test1_bad += substr_count($test1, $replacement_sequence);
                            }
                            if (mb_strpos($test1, $replacement_char_code, 0, 'UTF-8') !== false) {
                                $test1_bad += 1;
                            }
                        if ($test1_bad < $original_bad || ($original_bad > 0 && $test1_bad === 0)) {
                            $txt_en = $test1;
                        }
                    }
                    
                    // Method 2: If still has issues, try Windows-1252
                    if (strpos($txt_en, $utf8_replacement_char) !== false || strpos($txt_en, '') !== false) {
                        $test2 = @mb_convert_encoding($txt_en, 'UTF-8', 'Windows-1252');
                        if ($test2 !== false && mb_check_encoding($test2, 'UTF-8')) {
                            // Count replacement characters - avoid using empty string in substr_count
                            $test2_bad = substr_count($test2, $replacement_bytes);
                            if (strpos($test2, $replacement_sequence) !== false) {
                                $test2_bad += substr_count($test2, $replacement_sequence);
                            }
                            if (mb_strpos($test2, $replacement_char_code, 0, 'UTF-8') !== false) {
                                $test2_bad += 1;
                            }
                            
                            $current_bad = substr_count($txt_en, $replacement_bytes);
                            if (strpos($txt_en, $replacement_sequence) !== false) {
                                $current_bad += substr_count($txt_en, $replacement_sequence);
                            }
                            if (mb_strpos($txt_en, $replacement_char_code, 0, 'UTF-8') !== false) {
                                $current_bad += 1;
                            }
                            if ($test2_bad < $current_bad || ($current_bad > 0 && $test2_bad === 0)) {
                                $txt_en = $test2;
                            }
                        }
                    }
                    
                    // Method 3: Clean invalid UTF-8 sequences and replace with nothing
                    // This is a last resort - removes corrupted characters
                    if (strpos($txt_en, $utf8_replacement_char) !== false || strpos($txt_en, '') !== false) {
                        // Remove replacement characters (they indicate lost data anyway)
                        $txt_en = str_replace($utf8_replacement_char, '', $txt_en);
                        $txt_en = str_replace('', '', $txt_en);
                        $txt_en = str_replace('ï¿½', '', $txt_en);
                        // Also clean any other invalid UTF-8 sequences
                        $txt_en = mb_convert_encoding($txt_en, 'UTF-8', 'UTF-8');
                    }
                }
            }
            
            // Also fix encoding for other translations
            if (!empty($txt_tw) && !mb_check_encoding($txt_tw, 'UTF-8')) {
                $txt_tw = @mb_convert_encoding($txt_tw, 'UTF-8', 'Windows-1252') ?: $txt_tw;
            }
            if (!empty($txt_cn) && !mb_check_encoding($txt_cn, 'UTF-8')) {
                $txt_cn = @mb_convert_encoding($txt_cn, 'UTF-8', 'Windows-1252') ?: $txt_cn;
            }

            if (is_array($queries)) {
                foreach ($queries as $query_word) {
                    if (!empty($query_word)) {
                        $txt_tw = str_replace($query_word, "<strong>$query_word</strong>", $txt_tw);
                        $txt_cn = str_replace($query_word, "<strong>$query_word</strong>", $txt_cn);
                        $txt_en = str_ireplace($query_word, "<strong>$query_word</strong>", $txt_en);
                    }
                }
            }

            if ($vid == $verse && ($mode === 'READ' || $mode === 'INDEX')) {
                $txt_tw = "<strong>$txt_tw</strong>";
                $txt_cn = "<strong>$txt_cn</strong>";
                $txt_en = "<strong>$txt_en</strong>";
            }

            // Always process formatting tags (FI, FR, FO, RF, font color)
            // Red letter (words of Christ) - <FR>...</Fr>
            $txt_tw = str_replace(['<FR>', '<Fr>'], ['<span style="color:red;">', '</span>'], $txt_tw);
            $txt_cn = str_replace(['<FR>', '<Fr>'], ['<span style="color:red;">', '</span>'], $txt_cn);
            $txt_en = str_replace(['<FR>', '<Fr>'], ['<span style="color:red;">', '</span>'], $txt_en);
            
            // Orange letter (words of angels/divine speech) - <FO>...</Fo>
            $txt_tw = str_replace(['<FO>', '<Fo>'], ['<span style="color:orange;">', '</span>'], $txt_tw);
            $txt_cn = str_replace(['<FO>', '<Fo>'], ['<span style="color:orange;">', '</span>'], $txt_cn);
            $txt_en = str_replace(['<FO>', '<Fo>'], ['<span style="color:orange;">', '</span>'], $txt_en);
            
            // Italics (supplied words) - <FI>...</Fi>
            $txt_tw = str_replace(['<FI>', '<Fi>'], ['<i>', '</i>'], $txt_tw);
            $txt_cn = str_replace(['<FI>', '<Fi>'], ['<i>', '</i>'], $txt_cn);
            $txt_en = str_replace(['<FI>', '<Fi>'], ['<i>', '</i>'], $txt_en);
            
            // Footnotes/References - <RF>...</Rf>
            $txt_tw = str_replace(['<RF>', '<Rf>'], ['<span class="footnote">', '</span>'], $txt_tw);
            $txt_cn = str_replace(['<RF>', '<Rf>'], ['<span class="footnote">', '</span>'], $txt_cn);
            $txt_en = str_replace(['<RF>', '<Rf>'], ['<span class="footnote">', '</span>'], $txt_en);
            
            // Fix font color attributes
            $txt_tw = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $txt_tw);
            $txt_cn = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $txt_cn);
            $txt_en = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $txt_en);
            
            // Process or remove Strong's codes based on $strongs setting
            if ($strongs) {
                // Process Strong's codes - add in parentheses as links
                // Process <WG...> format (Greek, long form) - supports optional suffix like "a"
                $txt_tw = preg_replace('/([^\s<>]+)<WG(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $txt_tw);
                $txt_cn = preg_replace('/([^\s<>]+)<WG(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $txt_cn);
                $txt_en = preg_replace('/([^\s<>]+)<WG(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $txt_en);
                
                // Process <WH...> format (Hebrew, long form) - supports optional suffix like "a"
                $txt_tw = preg_replace('/([^\s<>]+)<WH(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $txt_tw);
                $txt_cn = preg_replace('/([^\s<>]+)<WH(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $txt_cn);
                $txt_en = preg_replace('/([^\s<>]+)<WH(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $txt_en);
                
                // Process <G...> format (Greek, short form) - supports optional suffix like "a"
                $txt_tw = preg_replace('/(?<!>)([^\s<>]+)<G(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $txt_tw);
                $txt_cn = preg_replace('/(?<!>)([^\s<>]+)<G(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $txt_cn);
                $txt_en = preg_replace('/(?<!>)([^\s<>]+)<G(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $txt_en);
                
                // Process <H...> format (Hebrew, short form) - supports optional suffix like "a"
                $txt_tw = preg_replace('/(?<!>)([^\s<>]+)<H(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $txt_tw);
                $txt_cn = preg_replace('/(?<!>)([^\s<>]+)<H(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $txt_cn);
                $txt_en = preg_replace('/(?<!>)([^\s<>]+)<H(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $txt_en);
            } else {
                // Remove Strong's code tags if not enabled
                // Remove Strong's codes from within <sup> tags, then remove empty <sup> tags
                $txt_tw = preg_replace('/<sup>([^<]*)<[WH]?[GH]\d{1,4}[a-z]?>(.*?)<\/sup>/i', '<sup>${1}${2}</sup>', $txt_tw);
                $txt_cn = preg_replace('/<sup>([^<]*)<[WH]?[GH]\d{1,4}[a-z]?>(.*?)<\/sup>/i', '<sup>${1}${2}</sup>', $txt_cn);
                $txt_en = preg_replace('/<sup>([^<]*)<[WH]?[GH]\d{1,4}[a-z]?>(.*?)<\/sup>/i', '<sup>${1}${2}</sup>', $txt_en);
                
                // Remove <sup> tags that only contain Strong's codes (with optional whitespace)
                $txt_tw = preg_replace('/<sup>\s*<[WH]?[GH]\d{1,4}[a-z]?>\s*<\/sup>/i', '', $txt_tw);
                $txt_cn = preg_replace('/<sup>\s*<[WH]?[GH]\d{1,4}[a-z]?>\s*<\/sup>/i', '', $txt_cn);
                $txt_en = preg_replace('/<sup>\s*<[WH]?[GH]\d{1,4}[a-z]?>\s*<\/sup>/i', '', $txt_en);
                
                // Remove standalone Strong's code tags (not in sup tags)
                $txt_tw = preg_replace('/<[WH]?[GH]\d{1,4}[a-z]?>/i', '', $txt_tw);
                $txt_cn = preg_replace('/<[WH]?[GH]\d{1,4}[a-z]?>/i', '', $txt_cn);
                $txt_en = preg_replace('/<[WH]?[GH]\d{1,4}[a-z]?>/i', '', $txt_en);
            }

            $osis_cn = ($book_cn[$bid] ?? '') . " $cid";
            $osis = ($book_short[$bid] ?? '') . ".$cid";
            if ($vid) {
                $osis .= ".$vid";
                $osis_cn .= ":$vid";
            }

            // Output text without htmlspecialchars to allow HTML tags like <p>, <b>, <strong>
            if ($portable) {
                $text_tw .= " <sup>" . ($book_tw[$bid] ?? '') . " $cid:$vid</sup> " . $txt_tw . "\n";
                $text_cn .= " <sup>" . ($book_cn[$bid] ?? '') . " $cid:$vid</sup> " . $txt_cn . "\n";
                $text_en .= " <sup>" . ($book_short[$bid] ?? '') . " $cid:$vid</sup> " . $txt_en . "\n";
            } elseif ($short_url_base) {
                $text_tw .= " <sup><a href=\"$short_url_base/$osis.htm\">" . ($book_tw[$bid] ?? '') . " $cid:$vid</a></sup> " . $txt_tw . "\n";
                $text_cn .= " <sup><a href=\"$short_url_base/$osis.htm\">" . ($book_cn[$bid] ?? '') . " $cid:$vid</a></sup> " . $txt_cn . "\n";
                $text_en .= " <sup><a href=\"$short_url_base/$osis.htm\">" . ($book_short[$bid] ?? '') . " $cid:$vid</a></sup> " . $txt_en . "\n";
            } else {
                $text_tw .= " <sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\">" . ($book_tw[$bid] ?? '') . " $cid:$vid</a></sup> " . $txt_tw . "\n";
                $text_cn .= " <sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\">" . ($book_cn[$bid] ?? '') . " $cid:$vid</a></sup> " . $txt_cn . "\n";
                $text_en .= " <sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\">" . ($book_short[$bid] ?? '') . " $cid:$vid</a></sup> " . $txt_en . "\n";
            }

            $background = ($verse_number % 2) ? " class=light" : " class=dark";
            $text_cmp .= "<table border=0 width=100%><tr><td $background>";

            // SECTION 1: Verse-by-verse display - all enabled translations for this verse
            // Add clickable verse reference before the translations list
            // Use current language for book short name
            $book_names = function_exists('getBookNames') ? getBookNames() : null;
            if ($book_names) {
                $book_short_current = $book_names['short'][$bid] ?? ($book_short[$bid] ?? '');
            } else {
                // Fallback: use book_cn for Chinese, book_short for English
                $book_short_current = function_exists('getCurrentLang') && getCurrentLang() === 'en' 
                    ? ($book_short[$bid] ?? '') 
                    : ($book_cn[$bid] ?? '');
            }
            $verse_ref = ($book_short[$bid] ?? '') . " $cid:$vid";
            $verse_ref_display = $book_short_current . " $cid:$vid";
            if ($portable) {
                $text_cmp .= "<p><strong>" . htmlspecialchars($verse_ref_display) . "</strong></p>\n";
            } elseif ($short_url_base) {
                $text_cmp .= "<p><strong><a href=\"$short_url_base/$osis.htm\">" . htmlspecialchars($verse_ref_display) . "</a></strong></p>\n";
            } else {
                $text_cmp .= "<p><strong><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\">" . htmlspecialchars($verse_ref_display) . "</a></strong></p>\n";
            }
            $text_cmp .= "<ul>\n";
            foreach ($bible_books as $bible_book) {
                if ($bible_book) {
                    $text_string = $row["text_$bible_book"] ?? '';
                    
                    // Fix encoding issues for all Bible translations using proper encoding detection
                    if (!empty($text_string)) {
                        $utf8_replacement_char = "\xEF\xBF\xBD"; // UTF-8 replacement character bytes
                        $has_replacement_sequence = (strpos($text_string, 'ï¿½') !== false);
                        $has_replacement_char = (strpos($text_string, $utf8_replacement_char) !== false || 
                                                 strpos($text_string, '') !== false);
                        $is_valid_utf8 = mb_check_encoding($text_string, 'UTF-8');
                        
                        if ($has_replacement_char || $has_replacement_sequence || !$is_valid_utf8) {
                            // Try ISO-8859-1 -> UTF-8 conversion
                            $test1 = @mb_convert_encoding($text_string, 'UTF-8', 'ISO-8859-1');
                            if ($test1 !== false && mb_check_encoding($test1, 'UTF-8')) {
                                // Use strpos to check for replacement character to avoid empty string issues
                                $replacement_bytes = "\xEF\xBF\xBD";
                                $replacement_sequence = 'ï¿½';
                                $original_bad = substr_count($text_string, $replacement_bytes) + 
                                              (strpos($text_string, $replacement_sequence) !== false ? substr_count($text_string, $replacement_sequence) : 0);
                                $test1_bad = substr_count($test1, $replacement_bytes) + 
                                            (strpos($test1, $replacement_sequence) !== false ? substr_count($test1, $replacement_sequence) : 0);
                                if ($test1_bad < $original_bad || ($original_bad > 0 && $test1_bad === 0)) {
                                    $text_string = $test1;
                                }
                            }
                            
                            // If still has issues, try Windows-1252
                            if (strpos($text_string, $utf8_replacement_char) !== false || strpos($text_string, '') !== false) {
                                $test2 = @mb_convert_encoding($text_string, 'UTF-8', 'Windows-1252');
                                if ($test2 !== false && mb_check_encoding($test2, 'UTF-8')) {
                                    $test2_bad = substr_count($test2, $replacement_bytes) + 
                                                (strpos($test2, $replacement_sequence) !== false ? substr_count($test2, $replacement_sequence) : 0);
                                    $current_bad = substr_count($text_string, $replacement_bytes) + 
                                                  (strpos($text_string, $replacement_sequence) !== false ? substr_count($text_string, $replacement_sequence) : 0);
                                    if ($test2_bad < $current_bad || ($current_bad > 0 && $test2_bad === 0)) {
                                        $text_string = $test2;
                                    }
                                }
                            }
                            
                            // Clean invalid UTF-8 sequences
                            if (strpos($text_string, $utf8_replacement_char) !== false || strpos($text_string, '') !== false) {
                                $text_string = str_replace($utf8_replacement_char, '', $text_string);
                                $text_string = str_replace('', '', $text_string);
                                $text_string = str_replace('ï¿½', '', $text_string);
                                $text_string = mb_convert_encoding($text_string, 'UTF-8', 'UTF-8');
                            }
                        }
                    }
                    
                    // Always process formatting tags (FI, FR, FO, font color)
                    // Red letter (words of Christ) - <FR>...</Fr>
                    $search_str = ['<FR>', '<Fr>'];
                    $replace_str = ['<span style="color:red;">', '</span>'];
                    $text_string = str_replace($search_str, $replace_str, $text_string);
                    
                    // Orange letter (words of angels/divine speech) - <FO>...</Fo>
                    $search_str = ['<FO>', '<Fo>'];
                    $replace_str = ['<span style="color:orange;">', '</span>'];
                    $text_string = str_replace($search_str, $replace_str, $text_string);
                    
                    // Italics (supplied words) - <FI>...</Fi>
                    $text_string = str_replace(['<FI>', '<Fi>'], ['<i>', '</i>'], $text_string);
                    
                    // Footnotes/References - <RF>...</Rf>
                    $text_string = str_replace(['<RF>', '<Rf>'], ['<span class="footnote">', '</span>'], $text_string);
                    
                    // Fix font color attributes (replace backticks with quotes)
                    $text_string = str_replace('color=`', 'color="', $text_string);
                    $text_string = str_replace('`>', '">', $text_string);
                    $text_string = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $text_string);
                    
                    // Process or remove Strong's codes based on $strongs setting
                    if ($strongs && in_array($bible_book, ['cuvs', 'cuvt', 'kjv', 'nasb'])) {
                        // Process Strong's codes - tags appear AFTER the word they reference
                        // Pattern: word<WHxxxx> becomes word (<a href="...">Hxxxx</a>)
                        // Hebrew: <WHxxxx> where xxxx is 1-8674 (Old Testament)
                        // Greek: <WGxxxx> where xxxx is 1-5624 (New Testament)
                        
                        // Process <WG...> format (Greek, long form) - supports optional suffix like "a"
                        // Matches word<WG1> through word<WG5624> (Greek Strong's numbers)
                        // Replaces with: word (<a href="...">Gxxxx</a>)
                        $text_string = preg_replace('/([^\s<>]+)<WG(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $text_string);
                        
                        // Process <WH...> format (Hebrew, long form) - supports optional suffix like "a"
                        // Matches word<WH1> through word<WH8674> (Hebrew Strong's numbers)
                        // Replaces with: word (<a href="...">Hxxxx</a>)
                        $text_string = preg_replace('/([^\s<>]+)<WH(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $text_string);
                        
                        // Process <G...> format (Greek, short form) - supports optional suffix like "a"
                        // Matches word<G1> through word<G5624> (Greek Strong's numbers)
                        // Replaces with: word (<a href="...">Gxxxx</a>)
                        $text_string = preg_replace('/(?<!>)([^\s<>]+)<G(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}${3}</a>)', $text_string);
                        
                        // Process <H...> format (Hebrew, short form) - supports optional suffix like "a"
                        // Matches word<H1> through word<H8674> (Hebrew Strong's numbers)
                        // Replaces with: word (<a href="...">Hxxxx</a>)
                        $text_string = preg_replace('/(?<!>)([^\s<>]+)<H(\d{1,4})([a-z]?)>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}${3}</a>)', $text_string);
                    } else {
                        // Remove Strong's code tags if not enabled
                        // Remove Strong's codes from within <sup> tags, then remove empty <sup> tags
                        $text_string = preg_replace('/<sup>([^<]*)<[WH]?[GH]\d{1,4}[a-z]?>(.*?)<\/sup>/i', '<sup>${1}${2}</sup>', $text_string);
                        
                        // Remove <sup> tags that only contain Strong's codes (with optional whitespace)
                        $text_string = preg_replace('/<sup>\s*<[WH]?[GH]\d{1,4}[a-z]?>\s*<\/sup>/i', '', $text_string);
                        
                        // Remove standalone Strong's code tags (not in sup tags)
                        $text_string = preg_replace('/<[WH]?[GH]\d{1,4}[a-z]?>/i', '', $text_string);
                    }
                    // Output without htmlspecialchars to allow HTML tags like <p>, <b>, <strong>
                    $text_cmp .= "<li><p>" . $text_string . " (" . strtoupper($bible_book) . ")</p></li>\n";
                    
                    // Also build block text for this translation (for SECTION 2: Block/Chapter display)
                    // Add verse reference link - show only verse number if whole chapter, otherwise show book shortname + chapter:verse
                    // Only build if this translation is enabled and block_texts array has this key
                    if (isset($block_texts[$bible_book])) {
                        // Get book short name in current language
                        $book_names = function_exists('getBookNames') ? getBookNames() : null;
                        if ($book_names) {
                            $book_short_current = $book_names['short'][$bid] ?? ($book_short[$bid] ?? '');
                        } else {
                            // Fallback: use book_cn for Chinese, book_short for English
                            $book_short_current = function_exists('getCurrentLang') && getCurrentLang() === 'en' 
                                ? ($book_short[$bid] ?? '') 
                                : ($book_cn[$bid] ?? '');
                        }
                        
                        $verse_ref_link = ($book_short[$bid] ?? '') . " $cid:$vid"; // Full reference for link (always use OSIS)
                        
                        // Determine display format based on whole chapter mode
                        if ($is_whole_chapter) {
                            // Whole chapter: show only verse number
                            $verse_number_display = (string)$vid;
                        } else {
                            // Multiple chapters/books: show book shortname + chapter:verse
                            $verse_number_display = $book_short_current . " $cid:$vid";
                        }
                        
                        // Ensure $osis is defined (it should be defined earlier in the loop)
                        $osis_block = ($book_short[$bid] ?? '') . ".$cid";
                        if ($vid) {
                            $osis_block .= ".$vid";
                        }
                        if ($portable) {
                            $block_texts[$bible_book] .= " <sup>" . htmlspecialchars($verse_number_display) . "</sup> " . $text_string . " ";
                        } elseif ($short_url_base) {
                            $block_texts[$bible_book] .= " <sup><a href=\"$short_url_base/$osis_block.htm\" title=\"" . htmlspecialchars($verse_ref_link) . "\">" . htmlspecialchars($verse_number_display) . "</a></sup> " . $text_string . " ";
                        } else {
                            $block_texts[$bible_book] .= " <sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\" title=\"" . htmlspecialchars($verse_ref_link) . "\">" . htmlspecialchars($verse_number_display) . "</a></sup> " . $text_string . " ";
                        }
                    }
                }
            }
            $text_cmp .= "</ul>\n";

            if (!$portable) {
                $quick_link_text = t('quick_link_full') . " ";
                $text_cmp .= "<p>" . t('bible_study_full') . " ";
                $text_cmp .= "<select name=\"$osis\" onchange=\"javascript:handleSelect(this)\">\n<option value=\"\">" . t('please_select_full') . "</option>\n";
                $links = [
                    ["http://www.blueletterbible.org/Bible.cfm?b=" . ($book_en[$bid] ?? '') . "&c=$cid&v=$vid", "Blue Letter Bible"],
                    ["http://www.yawill.com/modonline.php?book=$bid&chapter=$cid&node=$vid", "Yawill.com多版本对照"],
                    ["http://bible.fhl.net/new/read.php?VERSION1=unv&strongflag=2&TABFLAG=1&chineses=" . ($book_tw[$bid] ?? '') . "&chap=$cid&sec=$vid&VERSION2=kjv", "原文词典"],
                    ["$wiki_base/圣经:" . ($book_chinese[$bid] ?? '') . " $cid:$vid", "圣经百科"],
                    ["$wiki_base/MHC:" . ($book_chinese[$bid] ?? '') . " $cid", "圣经注释"],
                    ["$wiki_base/MHCC:" . ($book_chinese[$bid] ?? '') . " $cid", "MHCC 亨利马太简明圣经注释"],
                    ["https://www.51zanmei.net/bibleindex-$bid-$cid.html", "51zanmei.net 赞美圣经"],
                    ["http://www.almega.com.hk/bible/bible.asp?langid=1&BibleID=NCB&Site=wbs&BCVNo=" . sprintf("%d%03d%03d", $bid, $cid, $vid), "Chinese New Version 简体新译本"],
                    ["http://www.almega.com.hk/bible/bible.asp?langid=0&BibleID=NCB&Site=wbs&BCVNo=" . sprintf("%d%03d%03d", $bid, $cid, $vid), "Chinese New Version 繁體新譯本"],
                    ["http://www.dbsbible.org/ct50/Bible/LZZ/gb/" . strtolower($book_en3[$bid] ?? '') . "/$cid.htm", "吕振中译本(LZZ)"],
                    ["http://www.esvbible.org/search/" . ($book_en[$bid] ?? '') . "+$cid:$vid", "ESV Bible"],
                    ["http://www.biblegateway.com/passage/?version=ESV&search=" . ($book_en[$bid] ?? '') . "+$cid:$vid", "Bible Gateway"],
                    ["http://biblia.com/books/esv/" . ($book_en[$bid] ?? '') . "$cid.$vid", "Biblia"],
                    ["http://www.bible.is/CHNUN1/" . ($book_short[$bid] ?? '') . "/$cid", "圣经朗读"],
                    ["https://www.bible.com/bible/47/" . ($book_short[$bid] ?? '') . ".$cid.$vid", "优训读经"]
                ];
                foreach ($links as $link) {
                    $text_cmp .= "<option value=\"" . htmlspecialchars($link[0]) . "\">" . htmlspecialchars($link[1]) . "</option>\n";
                    $quick_link_text .= "<a href=\"" . htmlspecialchars($link[0]) . "\" target=\"_blank\">" . htmlspecialchars($link[1]) . "</a> ";
                }
                $text_cmp .= "</select>$quick_link_text";
                $text_cmp .= " <small><a href=\"bible.php?cmd=like&b=$bid&c=$cid&v=$vid\"><img src='like.png' width=14 height=14 border=0 alt='Like'/>" . t('like_verse_full') . "</a>";
                if ($likes > 0) {
                    $text_cmp .= " ($likes)";
                }
                $text_cmp .= "</small></p>\n";
            }
            $text_cmp .= "</td></tr></table>";
            $wiki_text .= "<p>[[MHC:" . htmlspecialchars($book_chinese[$bid] ?? '') . " $cid:$vid | " . htmlspecialchars($book_chinese[$bid] ?? '') . " $cid:$vid]]</p>\n";
            $verse_number++;
            if (!$chapter && !($verse_number % 5)) {
                $text_cmp .= " <p> </p></div>\n";
                $wiki_text .= "<p> </p>\n";
            }
            if ($chapter && !($verse_number % 10)) {
                $text_cmp .= " <p> </p></div>\n";
                $wiki_text .= "<p> </p>\n";
            }
        }
        $result->free();
        
        // Verify whole chapter mode based on actual data processed
        // If we tracked multiple books or chapters, override the initial assumption
        if ($is_whole_chapter && (count($unique_books) > 1 || count($unique_chapters) > 1)) {
            $is_whole_chapter = false;
        }
        
        // SECTION 2: Block/Chapter display - one block per enabled translation showing all verses
        // Build block display HTML for each translation
        $block_display = '';
        if (!empty($block_texts)) {
            $block_display .= "<h2>" . t('whole_chapter_full') . "</h2>\n";
            foreach ($bible_books as $bible_book) {
                if ($bible_book && !empty($block_texts[$bible_book])) {
                    $translation_name = strtoupper($bible_book);
                    // Map translation codes to full names using translations, with short code in parentheses
                    $translation_names = [
                        'CUVS' => t('trans_cuvs') . ' (CUVS)',
                        'CUVT' => t('trans_cuvt') . ' (CUVT)',
                        'KJV' => t('trans_kjv') . ' (KJV)',
                        'NASB' => t('trans_nasb') . ' (NASB)',
                        'ESV' => t('trans_esv') . ' (ESV)',
                        'CUVC' => t('trans_cuvc') . ' (CUVC)',
                        'NCVS' => t('trans_ncvs') . ' (NCVS)',
                        'LCVS' => t('trans_lcvs') . ' (LCVS)',
                        'CCSB' => t('trans_ccsb') . ' (CCSB)',
                        'CLBS' => t('trans_clbs') . ' (CLBS)',
                        'CKJVS' => t('trans_ckjvs') . ' (CKJVS)',
                        'CKJVT' => t('trans_ckjvt') . ' (CKJVT)',
                        'PINYIN' => t('trans_pinyin') . ' (pinyin)',
                        'UKJV' => t('trans_ukjv') . ' (UKJV)',
                        'KJV1611' => t('trans_kjv1611') . ' (KJV1611)',
                        'BBE' => t('trans_bbe') . ' (BBE)'
                    ];
                    $display_name = $translation_names[$translation_name] ?? $translation_name;
                    
                    $block_display .= "<h3>" . htmlspecialchars($display_name) . "</h3>\n";
                    $block_display .= "<p>" . $block_texts[$bible_book] . "</p>\n";
                    $block_display .= "<p> </p>\n";
                }
            }
        }
        // Append block display to text_cmp
        $text_cmp .= $block_display;
        
    } catch (Exception $e) {
        $echo_string = "Database query error: " . htmlspecialchars($e->getMessage());
    }
}

if ($mode === 'QUERY' && in_array($api, ['plain', 'html'])) {
    header('Content-Type: text/plain');
    echo htmlspecialchars($text_cmp);
    exit;
}

?>
<?php include __DIR__ . '/header.php'; ?>
<script type="text/javascript">
function FontZoom(size) {
    var elements = document.getElementsByTagName("p");
    var components = [];
    for (var i = 0, j = 0; i < elements.length; i++) {
        components[j] = elements[i];
        j++;
    }
    for (var i = 0; i < components.length; i++) {
        components[i].style.fontSize = size + 'pt';
    }
    document.cookie = 'fontSize=' + size + '; path=/';
}

if (document.cookie.includes('fontSize')) {
    var fontSize = document.cookie.split('fontSize=')[1].split(';')[0];
    FontZoom(parseInt(fontSize));
}

function handleSelect(elm) {
    if (elm.value) {
        window.open(elm.value, '_blank');
    }
}

function toggleOptions(elm, idx) {
    var options = idx ? document.getElementById("options1") : document.getElementById("options0");
    options.style.display = elm.checked ? 'inline' : 'none';
}

function handleAISearch(seq) {
    seq = seq || '0';
    // Get the search form and query input
    var searchForm = document.getElementById('searchForm' + seq);
    var searchQuery = document.getElementById('searchQuery' + seq);
    
    if (!searchForm || !searchQuery) {
        alert('Search form not found');
        return false;
    }
    
    var query = searchQuery.value.trim();
    
    if (!query || query === '') {
        alert('<?php echo addslashes(t('search_hint')); ?>');
        return false;
    }
    
    // Build API URL with query parameter
    var params = new URLSearchParams();
    params.append('q', query);
    
    // Get translation settings from the search form
    // Add translation checkboxes from form
    var translationCheckboxes = searchForm.querySelectorAll('input[type="checkbox"][name="cuvs"], input[type="checkbox"][name="cuvt"], input[type="checkbox"][name="kjv"], input[type="checkbox"][name="nasb"], input[type="checkbox"][name="esv"]');
    translationCheckboxes.forEach(function(cb) {
        if (cb.checked) {
            params.append(cb.name, cb.value);
        }
    });
    
    // Add other options from form
    var otherCheckboxes = searchForm.querySelectorAll('input[type="checkbox"][name="strongs"]');
    otherCheckboxes.forEach(function(cb) {
        if (cb.checked) {
            params.append(cb.name, cb.value);
        }
    });
    
    // Add book filter if set
    var bookSelect = searchForm.querySelector('select[name="b"]');
    if (bookSelect && bookSelect.value) {
        params.append('b', bookSelect.value);
    }
    
    // Add multi-verse and context if set
    var multiVerse = searchForm.querySelector('select[name="m"]');
    if (multiVerse && multiVerse.value) {
        params.append('m', multiVerse.value);
    }
    
    var context = searchForm.querySelector('select[name="e"]');
    if (context && context.value) {
        params.append('e', context.value);
    }
    
    // Add show thinking flag
    var showThinking = searchForm.querySelector('input[name="show_thinking"]');
    if (showThinking && showThinking.checked) {
        params.append('show_thinking', '1');
    }
    
    // Show loading indicator
    var aiButton = document.getElementById('aiButton' + seq);
    var originalValue = '';
    if (aiButton) {
        originalValue = aiButton.value;
        aiButton.value = '<?php echo addslashes(t('loading') ?? 'Loading...'); ?>';
        aiButton.disabled = true;
    }
    
    // Make API call
    fetch('/api/ai?' + params.toString())
        .then(response => {
            if (!response.ok) {
                // Try to get error message from response
                return response.text().then(text => {
                    try {
                        var errorData = JSON.parse(text);
                        throw new Error(errorData.error || 'Network response was not ok');
                    } catch (e) {
                        throw new Error('Network error: ' + response.status + ' ' + response.statusText);
                    }
                });
            }
            return response.json();
        })
        .then(data => {
            // Display AI results
            displayAIResults(data, seq);
            if (aiButton) {
                aiButton.value = originalValue;
                aiButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('<?php echo addslashes(t('error') ?? 'Error'); ?>: ' + error.message);
            if (aiButton) {
                aiButton.value = originalValue;
                aiButton.disabled = false;
            }
        });
    
    return false; // Prevent form submission
}

function escapeHtml(text) {
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function displayAIResults(data, seq) {
    seq = seq || '0';
    // Create a container for AI results
    var resultsContainer = document.getElementById('aiResults' + seq);
    if (!resultsContainer) {
        resultsContainer = document.createElement('div');
        resultsContainer.id = 'aiResults' + seq;
        resultsContainer.style.marginTop = '20px';
        resultsContainer.style.padding = '20px';
        resultsContainer.style.border = '1px solid #ccc';
        resultsContainer.style.borderRadius = '5px';
        resultsContainer.style.backgroundColor = '#f9f9f9';
        
        // Insert after the form
        var form = document.getElementById('searchForm' + seq);
        if (form && form.parentNode) {
            form.parentNode.insertBefore(resultsContainer, form.nextSibling);
        } else {
            document.body.appendChild(resultsContainer);
        }
    }
    
    // Clear previous results
    resultsContainer.innerHTML = '<h2>AI <?php echo addslashes(t('search_results') ?? 'Search Results'); ?></h2>';
    
    // Display results based on API response format
    if (data.error) {
        resultsContainer.innerHTML += '<p style="color: red;">' + data.error + '</p>';
    }
    
    // Show thinking process if available
    if (data.thinking) {
        resultsContainer.innerHTML += '<div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border-left: 3px solid #007bff; border-radius: 3px;"><strong><?php echo addslashes(t('show_thinking_full') ?? 'Thinking Process'); ?>:</strong><pre style="white-space: pre-wrap; word-wrap: break-word; margin: 5px 0;">' + escapeHtml(data.thinking) + '</pre></div>';
    }
    
    if (data.data && data.data.length > 0) {
        var resultsHtml = '<ul>';
        data.data.forEach(function(result) {
            resultsHtml += '<li>';
            if (result.reference) {
                resultsHtml += '<strong>' + result.reference + '</strong>: ';
            }
            if (result.text) {
                resultsHtml += result.text;
            }
            resultsHtml += '</li>';
        });
        resultsHtml += '</ul>';
        resultsContainer.innerHTML += resultsHtml;
    } else if (data.results && data.results.length > 0) {
        var resultsHtml = '<ul>';
        data.results.forEach(function(result) {
            resultsHtml += '<li>';
            if (result.reference) {
                resultsHtml += '<strong>' + result.reference + '</strong>: ';
            }
            if (result.text) {
                resultsHtml += result.text;
            }
            resultsHtml += '</li>';
        });
        resultsHtml += '</ul>';
        resultsContainer.innerHTML += resultsHtml;
    } else {
        resultsContainer.innerHTML += '<p><?php echo addslashes(t('no_records')); ?></p>';
    }
    
    // Scroll to results
    resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
<style type="text/css">
.light {
    background-color: var(--bg-primary, #ffffff);
}
.dark {
    background-color: var(--bg-tertiary, #f1f5f9);
}
</style>
</head>
<body>
<?php include __DIR__ . '/banner.php'; ?>
<center><div align="center">
<?php
function show_form(string $seq = '0'): void {
    global $query, $books, $script, $options, $multi_verse, $portable, $cn, $tw, $en, $strongs,
           $cuvs, $cuvt, $cuvc, $kjv, $nasb, $esv, $ckjvs, $ckjvt, $pinyin, $ncvs, $lcvs, $ccsb, $clbs, $ukjv, $kjv1611, $bbe,
           $wiki_base, $long_url_base, $short_url_base, $book_chinese, $book_english, $book_cn, $book_short, $context;
?>
<center><div align="center">
<form method="GET" action="<?php echo htmlspecialchars($script); ?>" id="searchForm<?php echo $seq; ?>">
<?php if ($portable) { ?>
    <input type="text" size="40" maxlength="128" name="q" value="<?php echo htmlspecialchars($query ?? ''); ?>" id="searchQuery<?php echo $seq; ?>">
<?php } else { ?>
    <input type="text" size="80" maxlength="128" name="q" value="<?php echo htmlspecialchars($query ?? ''); ?>" id="searchQuery<?php echo $seq; ?>">
<?php } ?>
<input type="submit" value="<?php echo t('study_full'); ?>" id="searchButton<?php echo $seq; ?>" style="margin-right: 5px;">
<input type="submit" value="<?php echo t('ai_full'); ?>" id="aiButton<?php echo $seq; ?>" onclick="handleAISearch('<?php echo $seq; ?>'); return false;" formnovalidate>
<?php if ($portable) echo "<br/>"; ?>
<input type='checkbox' name='o' id='<?php echo "o$seq"; ?>' value='<?php echo "o$seq"; ?>' <?php if ($options) echo 'checked'; ?> onChange="javascript:toggleOptions(this,<?php echo $seq; ?>)"><?php echo t('options_full'); ?>
<input type='checkbox' name='p' value='1' <?php if ($portable) echo 'checked'; ?>><?php echo t('portable_full'); ?>
<input type='checkbox' name='show_thinking' id='showThinking<?php echo $seq; ?>' value='1' checked><?php echo t('show_thinking_full'); ?>
<div id="<?php echo "options$seq"; ?>" style="display: <?php echo $options ? 'inline' : 'none'; ?>">
<br/><?php echo t('books_full'); ?>
<select name="b" style="max-width: 250px; width: auto;">
    <option value="0" <?php if ($books == 0) echo "SELECTED"; ?>><?php echo t('whole_bible_full'); ?></option>
    <option value="100" <?php if ($books == 100) echo "SELECTED"; ?>>基督徒百科 CCWiki</option>
    <option value="1-39" <?php if ($books == "1-39") echo "SELECTED"; ?>><?php echo t('old_testament_full'); ?></option>
    <option value="40-66" <?php if ($books == "40-66") echo "SELECTED"; ?>><?php echo t('new_testament_full'); ?></option>
    <?php
    // Get book names in current language for displaying book ranges
    $book_names = function_exists('getBookNames') ? getBookNames() : null;
    
    // Law (Gen-Deut) - books 1-5
    $law_start = $book_names ? $book_names['short'][1] : ($book_cn[1] ?? 'Gen');
    $law_end = $book_names ? $book_names['short'][5] : ($book_cn[5] ?? 'Deut');
    $law_text = t('law') . " ($law_start-$law_end)";
    
    // History (Josh-Esth) - books 6-17
    $hist_start = $book_names ? $book_names['short'][6] : ($book_cn[6] ?? 'Josh');
    $hist_end = $book_names ? $book_names['short'][17] : ($book_cn[17] ?? 'Esth');
    $hist_text = t('history') . " ($hist_start-$hist_end)";
    
    // Poetry & Wisdom (Job-Song) - books 18-22
    $poetry_start = $book_names ? $book_names['short'][18] : ($book_cn[18] ?? 'Job');
    $poetry_end = $book_names ? $book_names['short'][22] : ($book_cn[22] ?? 'Song');
    $poetry_text = t('poetry_wisdom') . " ($poetry_start-$poetry_end)";
    
    // Major Prophets (Is-Dan) - books 23-27
    $major_start = $book_names ? $book_names['short'][23] : ($book_cn[23] ?? 'Is');
    $major_end = $book_names ? $book_names['short'][27] : ($book_cn[27] ?? 'Dan');
    $major_text = t('major_prophets') . " ($major_start-$major_end)";
    
    // Minor Prophets (Hos-Mal) - books 28-39
    $minor_start = $book_names ? $book_names['short'][28] : ($book_cn[28] ?? 'Hos');
    $minor_end = $book_names ? $book_names['short'][39] : ($book_cn[39] ?? 'Mal');
    $minor_text = t('minor_prophets') . " ($minor_start-$minor_end)";
    
    // Gospels and History (Matt-Acts) - books 40-44
    $gospels_start = $book_names ? $book_names['short'][40] : ($book_cn[40] ?? 'Matt');
    $gospels_end = $book_names ? $book_names['short'][44] : ($book_cn[44] ?? 'Acts');
    $gospels_text = t('gospels_history') . " ($gospels_start-$gospels_end)";
    
    // Paul's Epistles (Rom-Philem) - books 45-57
    $pauls_start = $book_names ? $book_names['short'][45] : ($book_cn[45] ?? 'Rom');
    $pauls_end = $book_names ? $book_names['short'][57] : ($book_cn[57] ?? 'Philem');
    $pauls_text = t('pauls_epistles') . " ($pauls_start-$pauls_end)";
    
    // General Epistles (Heb-Rev) - books 58-66
    $general_start = $book_names ? $book_names['short'][58] : ($book_cn[58] ?? 'Heb');
    $general_end = $book_names ? $book_names['short'][66] : ($book_cn[66] ?? 'Rev');
    $general_text = t('general_epistles') . " ($general_start-$general_end)";
    ?>
    <option value="1-5" <?php if ($books == "1-5") echo "SELECTED"; ?>><?php echo htmlspecialchars($law_text); ?></option>
    <option value="6-17" <?php if ($books == "6-17") echo "SELECTED"; ?>><?php echo htmlspecialchars($hist_text); ?></option>
    <option value="18-22" <?php if ($books == "18-22") echo "SELECTED"; ?>><?php echo htmlspecialchars($poetry_text); ?></option>
    <option value="23-27" <?php if ($books == "23-27") echo "SELECTED"; ?>><?php echo htmlspecialchars($major_text); ?></option>
    <option value="28-39" <?php if ($books == "28-39") echo "SELECTED"; ?>><?php echo htmlspecialchars($minor_text); ?></option>
    <option value="40-44" <?php if ($books == "40-44") echo "SELECTED"; ?>><?php echo htmlspecialchars($gospels_text); ?></option>
    <option value="45-57" <?php if ($books == "45-57") echo "SELECTED"; ?>><?php echo htmlspecialchars($pauls_text); ?></option>
    <option value="58-66" <?php if ($books == "58-66") echo "SELECTED"; ?>><?php echo htmlspecialchars($general_text); ?></option>
    <?php for ($i = 1; $i <= 66; $i++) { 
        // Get book names in current language
        if ($book_names) {
            $book_long = $book_names['long'][$i] ?? '';
            $book_short_display = $book_names['short'][$i] ?? '';
        } else {
            // Fallback
            $book_long = $book_chinese[$i] ?? '';
            $book_short_display = $book_cn[$i] ?? '';
        }
        $book_option_text = $book_long . " ($book_short_display)";
    ?>
        <option value="<?php echo $i; ?>" <?php if ($books == $i) echo "SELECTED"; ?>><?php echo htmlspecialchars($book_option_text); ?></option>
    <?php } ?>
</select>
<?php if ($portable) echo "<br/>"; ?>
<?php echo t('multi_full'); ?> <select name="m" style="max-width: 150px; width: auto; margin-right: 10px;">
    <option value="0" <?php if ($multi_verse == 0) echo "SELECTED"; ?>><?php echo t('single_verse_full'); ?></option>
    <option value="1" <?php if ($multi_verse == 1) echo "SELECTED"; ?>><?php echo t('multi_verse_full'); ?></option>
</select> 
<?php echo t('extend_full'); ?> <select name="e" style="max-width: 100px; width: auto; margin-left: 5px;">
    <?php
    $current_lang = function_exists('detectLanguage') ? detectLanguage() : 'en';
    $verse_text = ($current_lang == 'zh_tw') ? '節' : (($current_lang == 'zh_cn') ? '节' : '');
    for ($i = 0; $i <= 5; $i++) {
        $selected = ((!$context && $i == 0) || $context == $i) ? 'SELECTED' : '';
        if ($current_lang == 'en') {
            $display_text = $i . ' ' . ($i == 1 ? 'Verse' : 'Verses');
        } else {
            $display_text = $i . $verse_text;
        }
        echo "<option value=\"$i\" $selected>$display_text</option>\n    ";
    }
    ?>
</select>
<div style="display: inline-block; vertical-align: top; margin-right: 15px;">
<strong><?php echo t('language_full'); ?>:</strong><br/>
<input type='checkbox' name='cn' value='1' <?php if ($cn) echo 'checked'; ?>><?php echo t('simplified_full'); ?><br/>
<input type='checkbox' name='tw' value='1' <?php if ($tw) echo 'checked'; ?>><?php echo t('traditional_full'); ?><br/>
<input type='checkbox' name='en' value='1' <?php if ($en) echo 'checked'; ?>><?php echo t('english_full'); ?>
</div>
<div style="display: inline-block; vertical-align: top; margin-right: 15px;">
<strong><?php echo t('translation_full'); ?>:</strong><br/>
<input type='checkbox' name='strongs' value='strongs' <?php if ($strongs) echo 'checked'; ?>><?php echo t('strongs_code_full'); ?><br/>
<input type='checkbox' name='cuvs' value='cuvs' <?php if ($cuvs) echo 'checked'; ?>><?php echo t('trans_cuvs'); ?> (CUVS)*<br/>
<input type='checkbox' name='cuvt' value='cuvt' <?php if ($cuvt) echo 'checked'; ?>><?php echo t('trans_cuvt'); ?> (CUVT)*<br/>
<input type='checkbox' name='kjv' value='kjv' <?php if ($kjv) echo 'checked'; ?>><?php echo t('trans_kjv'); ?> (KJV)*<br/>
<input type='checkbox' name='nasb' value='nasb' <?php if ($nasb) echo 'checked'; ?>><?php echo t('trans_nasb'); ?> (NASB)*
</div>
<div style="display: inline-block; vertical-align: top; margin-right: 15px;">
<strong><?php echo t('popular_translations_full'); ?>:</strong><br/>
<input type='checkbox' name='esv' value='esv' <?php if ($esv) echo 'checked'; ?>><?php echo t('trans_esv'); ?> (ESV)<br/>
<input type='checkbox' name='ncvs' value='ncvs' <?php if ($ncvs) echo 'checked'; ?>><?php echo t('trans_ncvs'); ?> (NCVS)<br/>
<input type='checkbox' name='cuvc' value='cuvc' <?php if ($cuvc) echo 'checked'; ?>><?php echo t('trans_cuvc'); ?> (CUVC)<br/>
<input type='checkbox' name='pinyin' value='pinyin' <?php if ($pinyin) echo 'checked'; ?>><?php echo t('trans_pinyin'); ?> (pinyin)
</div>
<div style="display: inline-block; vertical-align: top;">
<strong><?php echo t('more_translations_full'); ?>:</strong><br/>
<input type='checkbox' name='lcvs' value='lcvs' <?php if ($lcvs) echo 'checked'; ?>><?php echo t('trans_lcvs'); ?> (LCVS)<br/>
<input type='checkbox' name='ccsb' value='ccsb' <?php if ($ccsb) echo 'checked'; ?>><?php echo t('trans_ccsb'); ?> (CCSB)<br/>
<input type='checkbox' name='clbs' value='clbs' <?php if ($clbs) echo 'checked'; ?>><?php echo t('trans_clbs'); ?> (CLBS)<br/>
<input type='checkbox' name='ckjvs' value='ckjvs' <?php if ($ckjvs) echo 'checked'; ?>><?php echo t('trans_ckjvs'); ?> (CKJVS)<br/>
<input type='checkbox' name='ckjvt' value='ckjvt' <?php if ($ckjvt) echo 'checked'; ?>><?php echo t('trans_ckjvt'); ?> (CKJVT)<br/>
<input type='checkbox' name='ukjv' value='ukjv' <?php if ($ukjv) echo 'checked'; ?>><?php echo t('trans_ukjv'); ?> (UKJV)<br/>
<input type='checkbox' name='kjv1611' value='kjv1611' <?php if ($kjv1611) echo 'checked'; ?>><?php echo t('trans_kjv1611'); ?> (KJV1611)<br/>
<input type='checkbox' name='bbe' value='bbe' <?php if ($bbe) echo 'checked'; ?>><?php echo t('trans_bbe'); ?> (BBE)
</div>
</div>
</form>
</div></center>
<?php
}

show_form();

if (!$portable) {
    echo "<p> </p>";
    echo $book_menu;
    echo "<p> </p>";
}

if ($wiki) {
    echo $wiki_book_menu;
}

if ($book) {
    if (!$portable) {
        echo "<p> </p>";
        echo $chapter_menu;
        echo "<p> </p>";
    }
    if ($wiki) {
        echo $wiki_chapter_menu;
        if (!$chapter) {
            echo "<p> </p><p>{{Template:MHC:" . htmlspecialchars($book_chinese[$book] ?? '') . "}}</p>";
        } else {
            echo htmlspecialchars($wiki_text);
        }
        echo "<p>{{Template:MHC:圣经}}</p><p> </p>";
    }
}

echo "<div align='center'><center>";

$bid1 = isset($bid) ? $bid - 1 : 0;
$cid1 = isset($cid) ? $cid - 1 : 0;

echo "</div></center>";

if ($query && $echo_string) {
    echo $echo_string; // Output HTML directly to allow <p>, <b>, <strong> tags
}
?>
<center><div align="center"><p>
【<strong><?php echo t('font_size_full'); ?></strong>
<a href="javascript:FontZoom(9)"><?php echo t('font_xs_full'); ?></a>
<a href="javascript:FontZoom(10)"><?php echo t('font_s_full'); ?></a>
<a href="javascript:FontZoom(12)"><?php echo t('font_m_full'); ?></a>
<a href="javascript:FontZoom(14)"><?php echo t('font_l_full'); ?></a>
<a href="javascript:FontZoom(16)"><?php echo t('font_xl_full'); ?></a>】
</p></div></center>
<?php
// Removed duplicate display of CUVS, CUVT, and KJV - they're now shown in the list like all other translations
if ($show_verse || $portable) {
    echo "<p> </p>\n";
    echo $text_cmp;
    echo "<p> </p>\n";
    // Removed duplicate display of CUVS, CUVT, and KJV - they're now shown in the list like all other translations
}

if ($wiki) {
    echo htmlspecialchars($wiki_text);
    if ($chapter) {
        echo "<p> </p><p>{{Template:MHC:" . htmlspecialchars($book_chinese[$book] ?? '') . "}}</p>";
    }
    echo "<p>{{Template:MHC:圣经}}</p><p> </p>";
}

echo "<p> </p>";
if ($book && !$portable) {
    echo $chapter_menu;
}
echo "<p> </p>";
if (!$portable) {
    echo $book_menu;
}

echo "<p> </p>";
if (!$portable) {
    show_form('1');
    ?>
    <p> </p>
    <center><div align="center"><p>
    【<strong>字体大小 FontSize</strong>
    <a href="javascript:FontZoom(9)">更小 XS</a>
    <a href="javascript:FontZoom(10)">小 S</a>
    <a href="javascript:FontZoom(12)">中 M</a>
    <a href="javascript:FontZoom(14)">大 L</a>
    <a href="javascript:FontZoom(16)">更大 XL</a>】
    </p></div></center>
    <?php include __DIR__ . '/footer.php'; ?>
<?php
} else {
    include __DIR__ . '/footer_portal.php';
}
?>
</body>
</html>
</html>