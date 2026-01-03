<?php
declare(strict_types=1);

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
$wiki_search_base = 'https://godwithus.cn/w'; // Wiki search redirect base
$short_url_base = 'https://bibleengine.ai';
$long_url_base = 'https://bibleengine.ai';
$img_url = 'https://bibleengine.ai'; // Image/asset base URL
$sitename = 'BibleEngine.ai';
$engine_name_en = 'Goshen Bible Engine'; // English engine name
$engine_name_cn = '歌珊地圣经引擎'; // Chinese engine name
$engine_name_full = $engine_name_cn . '——给力的圣经研读和圣经搜索引擎 <br/> <b>' . $engine_name_en . '</b> -- Powerful Bible Study and Bible Search Engine';
$copyright_text = '2004-2026 VI AI Foundation (歌珊地科技 Goshen Tech)'; // Copyright text

function show_hint(): string {
    return "提示：请输入圣经章节，如 'John 3:16' 或 '约 3:16'。";
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
                    $txt = "没有查到搜索的词条，请更换关键词再搜索。" . show_hint() . show_banner();
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
$extend = isset($_REQUEST['e']) ? (int)$_REQUEST['e'] : 0;
$search_table = 'bible_search';
$language = strtolower($_REQUEST['l'] ?? 'cn') ?: 'cn';
$wiki = $_REQUEST['w'] ?? '';
$api = $_REQUEST['api'] ?? '';
$script = 'index.php';
$strongs = $_REQUEST['strongs'] ?? '';

if (!$query) {
    require_once __DIR__ . '/votd.php';
    $query = $votd_string ?? '';
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

$cuvs = isset($_REQUEST['cuvs']) ? "cuvs" : "";
$cuvt = isset($_REQUEST['cuvt']) ? "cuvt" : "";
$cuvc = isset($_REQUEST['cuvc']) ? "cuvc" : "";
$ncvs = isset($_REQUEST['ncvs']) ? "ncvs" : "";
$pinyin = isset($_REQUEST['pinyin']) ? "pinyin" : "";
$lcvs = isset($_REQUEST['lcvs']) ? "lcvs" : "";
$ccsb = isset($_REQUEST['ccsb']) ? "ccsb" : "";
$clbs = isset($_REQUEST['clbs']) ? "clbs" : "";
$kjv = isset($_REQUEST['kjv']) ? "kjv" : "";
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
require_once __DIR__ . '/dbconfig.php';

try {
    if (!file_exists(__DIR__ . '/dbconfig.php')) {
        throw new Exception("Error: " . __DIR__ . "/dbconfig.php not found");
    }
    require_once __DIR__ . '/dbconfig.php';

    if (!isset($dbhost, $dbuser, $dbpassword, $database)) {
        throw new Exception("Error: Database configuration variables not set in dbconfig.php");
    }

    $dbport_int = isset($dbport) ? (int)$dbport : 3306;
    $db = new mysqli($dbhost, $dbuser, $dbpassword, $database, $dbport_int);
    if ($db->connect_error) {
        throw new Exception("Connection Error: " . $db->connect_error);
    }
    $db->set_charset('utf8');
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
                            $echo_string = "章节格式错误，可能章号不正确，正确格式参考： John 3";
                        }
                        if ($r2) {
                            $verses_temp = explode(",", $r2);
                            if ((int)$verses_temp[0]) {
                                $verse = $verse2 = (int)$verses_temp[0];
                                $sql_where .= " AND (verse BETWEEN " . ((int)$verses_temp[0] - $extend) . " AND " . ((int)$verses_temp[0] + $extend);
                                for ($iii = 1; $iii < count($verses_temp); $iii++) {
                                    $sql_where .= " OR verse BETWEEN " . ((int)$verses_temp[$iii] - $extend) . " AND " . ((int)$verses_temp[$iii] + $extend);
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
                                $echo_string = "章节格式错误，可能章号或者节号不正确，正确格式参考：John 3:16-18 或 John 3:16-18,19-21 或 John 3:16-18,20";
                            }
                        } elseif (!$r2 && $ir3 && $ir4) {
                            $irr = $ir3 - 1;
                            $sql_where .= " AND ( (chapter BETWEEN $ir1 AND $irr) OR ( (chapter = $ir3) AND (verse BETWEEN 1 AND $ir4)))";
                            $chapter = $ir1;
                            $verse = 1;
                            $verse2 = $ir4;
                        } else {
                            $echo_string = "章节格式错误，可能章号不正确，正确格式参考：John 3-5:6";
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
                            $sql_where .= " AND (verse BETWEEN " . ((int)$verses_temp[0] - $extend) . " AND " . ((int)$verses_temp[0] + $extend);
                            for ($iii = 1; $iii < count($verses_temp); $iii++) {
                                $sql_where .= " OR verse BETWEEN " . ((int)$verses_temp[$iii] - $extend) . " AND " . ((int)$verses_temp[$iii] + $extend);
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
                            $echo_string = "章节格式错误，可能章号或者节号不正确，正确格式参考：John 3:16-18 或 John 3:16-18,19-21 或 John 3:16-18,20";
                        }
                    } elseif (!$r2 && $ir3 && $ir4) {
                        $irr = $ir3 - 1;
                        $sql_where .= " AND ( (chapter BETWEEN $ir1 AND $irr) OR ( (chapter = $ir3) AND (verse BETWEEN 1 AND $ir4)))";
                        $chapter = $ir1;
                        $verse = 1;
                        $verse2 = $ir4;
                    } else {
                        $echo_string = "章节格式错误，可能章号不正确，正确格式参考：John 3-5:6";
                    }
                }
            }
            if ($sql_where && !$echo_string) {
                $sql .= ($sql ? " UNION " : "") . "SELECT * FROM $search_table WHERE $sql_where";
            }
        }
    }
}if ($sql && !$echo_string) {
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

    if ($do_query && isset($queries[0])) {
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
                    $echo_string .= "<h2>结果超出<b>$max_record_count</b>条记录，请增加关键词或者设定查询范围来准确查询</h2>";
                    break;
                }
            }
            $querystr = rtrim($querystr, ',');
            if ($querystr) {
                $index = $querystr;
                $echo_string .= "<p>共查到<b>$count</b>条记录：</p>";
            } else {
                $index = '';
                $echo_string .= "<h2>没有查到记录，请修改搜索条件重新搜索</h2>";
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

$english_title = isset($book_chinese[$book], $book_english[$book]) ? $book_chinese[$book] . " " . $book_english[$book] : '';
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

$title = $query ?: $english_title;
$title .= " - $sitename";

$book_menu = "<p>旧约 (OT) ";
$wiki_book_menu = "<p>== 旧约 ==</p><p> </p>\n";
for ($i = 1; $i <= 66; ++$i) {
    if ($book == $i) {
        $book_menu .= " <strong>";
    }
    if ($short_url_base) {
        $book_menu .= "   <a href=\"$short_url_base/{$book_short[$i]}.htm\" title=\"{$book_chinese[$i]} ({$book_english[$i]})\">{$book_cn[$i]} ({$book_short[$i]})</a> ";
    } else {
        $book_menu .= "   <a href=\"$script?q={$book_short[$i]} 1\" title=\"{$book_chinese[$i]} ({$book_english[$i]})\">{$book_cn[$i]} ({$book_short[$i]})</a> ";
    }
    if ($book == $i) {
        $book_menu .= "</strong>";
    }
    if ($chapter) {
        $wiki_book_menu .= "<p>[[MHC:{$book_chinese[$i]} | {$book_cn[$i]}({$book_short[$i]})]]</p>\n";
    } else {
        $wiki_book_menu .= "<p>[[MHC:{$book_chinese[$i]} | {$book_chinese[$i]}({$book_english[$i]})]]</p>\n";
    }
    if ($i == 39) {
        $book_menu .= " <br/>新约 (NT) ";
        $wiki_book_menu .= "\n<p> == 新约 == </p><p> </p>\n";
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

$chapter_menu = isset($book_chinese[$book], $book_cn[$book], $book_english[$book], $book_short[$book]) ? "{$book_chinese[$book]}({$book_cn[$book]}) {$book_english[$book]}({$book_short[$book]}) " : '';
$wiki_chapter_menu = "<p>=={$book_chinese_val}目录==</p><p> </p>\n";
for ($i = 1; $i <= $book_count_val; $i++) {
    if ($i == $chapter) {
        $chapter_menu .= "<strong>";
    }
    if ($short_url_base) {
        $chapter_menu .= "<a href=\"$short_url_base/{$book_short_val}.$i.htm\" title=\"{$book_chinese_val} $i   {$book_english_val} $i\"> &nbsp;$i </a> ";
    } else {
        $chapter_menu .= "<a href=\"$script?q={$book_short_val} $i\" title=\"{$book_chinese_val} $i   {$book_english_val} $i\"> &nbsp;$i </a> ";
    }
    if ($chapter) {
        $wiki_chapter_menu .= "<p>[[MHC:{$book_chinese_val} $i | {$book_cn_val} $i]]</p>\n";
    } else {
        $wiki_chapter_menu .= "<p>[[MHC:{$book_chinese_val} $i | {$book_chinese_val} $i]]</p>\n";
    }
    if ($i == $chapter) {
        $chapter_menu .= "</strong>";
    }
    $chapter_menu .= "\n";
    $wiki_chapter_menu .= "\n";
    if (!$chapter && ($i % 5) == 0) {
        $chapter_menu .= "<br/>\n";
        $wiki_chapter_menu .= "<br/>\n";
    }
}

// Initialize SQL variable
$sql = '';

if ($index) {
    if (empty($bible_books)) {
        $echo_string = "请至少选择一个圣经译本";
        $sql = '';
    } else {
        $sql = "SELECT bible_books.* ";
        $book_count = 0;
        foreach ($bible_books as $bible_book) {
            if ($bible_book) {
                $sql .= ", $bible_book.Scripture AS text_$bible_book ";
                $book_count++;
                if ($book_count > $max_book_count) {
                    $echo_string .= "<h2>选择查询的圣经译本超出<b>$max_book_count</b>个，请缩减同时查询的译本个数以降低服务器开销</h2>";
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
            $echo_string = "索引格式错误，请检查输入的索引格式";
            $sql = '';
        } else {
            $sql .= ") ";
        }
    }
} else {
    if (($mode === 'QUERY' && !$echo_string) || $mode === 'READ') {
        if (empty($bible_books)) {
            $echo_string = "请至少选择一个圣经译本";
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

if (!$index && !empty($sql)) {
    $sql .= " ORDER BY bible_books.book, bible_books.chapter, bible_books.verse";
}

// Debug: Print SQL query (show even if there's an error)
if ((isset($_REQUEST['debug']) || isset($_GET['debug'])) && !empty($sql)) {
    echo "<!-- DEBUG SQL: " . htmlspecialchars($sql) . " -->\n";
    $echo_string .= "<pre style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc;'>DEBUG SQL:\n" . htmlspecialchars($sql) . "</pre>";
}

if (($index || !$echo_string) && !empty($sql)) {
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

        while ($row = $result->fetch_assoc()) {
            $bid = isset($row['book']) ? (int)$row['book'] : 0;
            $cid = isset($row['chapter']) ? (int)$row['chapter'] : 0;
            $vid = isset($row['verse']) ? (int)$row['verse'] : 0;
            $likes = isset($row['likes']) ? (int)$row['likes'] : 0;
            $txt_tw = $row['text_cuvt'] ?? '';
            $txt_cn = $row['text_cuvs'] ?? '';
            $txt_en = $row['text_kjv'] ?? '';

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

            $osis_cn = ($book_cn[$bid] ?? '') . " $cid";
            $osis = ($book_short[$bid] ?? '') . ".$cid";
            if ($vid) {
                $osis .= ".$vid";
                $osis_cn .= ":$vid";
            }

            if ($portable) {
                $text_tw .= " <sup>" . ($book_tw[$bid] ?? '') . " $cid:$vid</sup> " . htmlspecialchars($txt_tw) . "\n";
                $text_cn .= " <sup>" . ($book_cn[$bid] ?? '') . " $cid:$vid</sup> " . htmlspecialchars($txt_cn) . "\n";
                $text_en .= " <sup>" . ($book_short[$bid] ?? '') . " $cid:$vid</sup> " . htmlspecialchars($txt_en) . "\n";
            } elseif ($short_url_base) {
                $text_tw .= " <sup><a href=\"$short_url_base/$osis.htm\">" . ($book_tw[$bid] ?? '') . " $cid:$vid</a></sup> " . htmlspecialchars($txt_tw) . "\n";
                $text_cn .= " <sup><a href=\"$short_url_base/$osis.htm\">" . ($book_cn[$bid] ?? '') . " $cid:$vid</a></sup> " . htmlspecialchars($txt_cn) . "\n";
                $text_en .= " <sup><a href=\"$short_url_base/$osis.htm\">" . ($book_short[$bid] ?? '') . " $cid:$vid</a></sup> " . htmlspecialchars($txt_en) . "\n";
            } else {
                $text_tw .= " <sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\">" . ($book_tw[$bid] ?? '') . " $cid:$vid</a></sup> " . htmlspecialchars($txt_tw) . "\n";
                $text_cn .= " <sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\">" . ($book_cn[$bid] ?? '') . " $cid:$vid</a></sup> " . htmlspecialchars($txt_cn) . "\n";
                $text_en .= " <sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\">" . ($book_short[$bid] ?? '') . " $cid:$vid</a></sup> " . htmlspecialchars($txt_en) . "\n";
            }

            $background = ($verse_number % 2) ? " class=light" : " class=dark";
            $text_cmp .= "<table border=0 width=100%><tr><td $background>";

            if ($cn) {
                $text_cmp .= "<p>\n";
                $cv = ($book_cn[$bid] ?? '') . " $cid:$vid";
                if ($portable) {
                    $text_cmp .= "<sup>" . htmlspecialchars($cv) . "</sup> ";
                } elseif ($short_url_base) {
                    $text_cmp .= "<sup><a href=\"$short_url_base/$osis.htm\" title=\"" . htmlspecialchars($book_chinese[$bid] ?? '') . " $cid:$vid\">" . htmlspecialchars($cv) . "</a></sup> ";
                } else {
                    $text_cmp .= "<sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\" title=\"" . htmlspecialchars($book_chinese[$bid] ?? '') . " $cid:$vid\">" . htmlspecialchars($cv) . "</a></sup> ";
                }
                $text_cmp .= htmlspecialchars($txt_cn) . " (CUVS)</p>\n";
            }

            if ($tw) {
                $text_cmp .= "<p>\n";
                $cv = ($book_tw[$bid] ?? '') . " $cid:$vid";
                if ($portable) {
                    $text_cmp .= "<sup>" . htmlspecialchars($cv) . "</sup> ";
                } elseif ($short_url_base) {
                    $text_cmp .= "<sup><a href=\"$short_url_base/$osis.htm\" title=\"" . htmlspecialchars($book_taiwan[$bid] ?? '') . " $cid:$vid\">" . htmlspecialchars($cv) . "</a></sup> ";
                } else {
                    $text_cmp .= "<sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\" title=\"" . htmlspecialchars($book_taiwan[$bid] ?? '') . " $cid:$vid\">" . htmlspecialchars($cv) . "</a></sup> ";
                }
                $text_cmp .= htmlspecialchars($txt_tw) . " (CUVT)</p>\n";
            }

            if ($en) {
                $text_cmp .= "<p>\n";
                $cv = ($book_en[$bid] ?? '') . " $cid:$vid";
                if ($portable) {
                    $text_cmp .= "<sup>" . htmlspecialchars($cv) . "</sup> ";
                } elseif ($short_url_base) {
                    $text_cmp .= "<sup><a href=\"$short_url_base/$osis.htm\" title=\"" . htmlspecialchars($book_english[$bid] ?? '') . " $cid:$vid\">" . htmlspecialchars($cv) . "</a></sup> ";
                } else {
                    $text_cmp .= "<sup><a href=\"$script?q=" . ($book_short[$bid] ?? '') . " $cid:$vid\" title=\"" . htmlspecialchars($book_english[$bid] ?? '') . " $cid:$vid\">" . htmlspecialchars($cv) . "</a></sup> ";
                }
                $text_cmp .= htmlspecialchars($txt_en) . " (KJV)</p>\n";
            }

            $text_cmp .= "<ul>\n";
            foreach ($bible_books as $bible_book) {
                if ($bible_book) {
                    $text_string = $row["text_$bible_book"] ?? '';
                    if ($strongs && in_array($bible_book, ['cuvs', 'cuvt', 'kjv', 'nasb'])) {
                        // Process formatting tags first
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
                        // Process Strong's codes - tags appear AFTER the word they reference
                        // Pattern: word<WHxxxx> becomes word (<a href="...">Hxxxx</a>)
                        // Hebrew: <WHxxxx> where xxxx is 1-8674 (Old Testament)
                        // Greek: <WGxxxx> where xxxx is 1-5624 (New Testament)
                        
                        // Process <WG...> format (Greek, long form) - add Strong's code in parentheses as link
                        // Matches word<WG1> through word<WG5624> (Greek Strong's numbers)
                        // Replaces with: word (<a href="...">Gxxxx</a>)
                        $text_string = preg_replace('/([^\s<>]+)<WG(\d{1,4})>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}</a>)', $text_string);
                        
                        // Process <WH...> format (Hebrew, long form) - add Strong's code in parentheses as link
                        // Matches word<WH1> through word<WH8674> (Hebrew Strong's numbers)
                        // Replaces with: word (<a href="...">Hxxxx</a>)
                        $text_string = preg_replace('/([^\s<>]+)<WH(\d{1,4})>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}</a>)', $text_string);
                        
                        // Process <G...> format (Greek, short form) - add Strong's code in parentheses as link
                        // Matches word<G1> through word<G5624> (Greek Strong's numbers)
                        // Replaces with: word (<a href="...">Gxxxx</a>)
                        $text_string = preg_replace('/(?<!>)([^\s<>]+)<G(\d{1,4})>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}</a>)', $text_string);
                        
                        // Process <H...> format (Hebrew, short form) - add Strong's code in parentheses as link
                        // Matches word<H1> through word<H8674> (Hebrew Strong's numbers)
                        // Replaces with: word (<a href="...">Hxxxx</a>)
                        $text_string = preg_replace('/(?<!>)([^\s<>]+)<H(\d{1,4})>/i', '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}</a>)', $text_string);
                        // Process italic tags
                        $text_string = str_replace(['<FI>', '<Fi>'], ['<i>', '</i>'], $text_string);
                        // Fix font color attributes (replace backticks with quotes)
                        $text_string = str_replace('color=`', 'color="', $text_string);
                        $text_string = str_replace('`>', '">', $text_string);
                        $text_string = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $text_string);
                        // Don't escape HTML since we've processed it
                        $text_cmp .= "<li><p>" . $text_string . " (" . strtoupper($bible_book) . ")</p></li>\n";
                    } else {
                        // Escape HTML for non-Strong's text
                        $text_cmp .= "<li><p>" . htmlspecialchars($text_string) . " (" . strtoupper($bible_book) . ")</p></li>\n";
                    }
                }
            }
            $text_cmp .= "</ul>\n";

            if (!$portable) {
                $quick_link_text = "直达 Quick Link: ";
                $text_cmp .= "<p>本节研经资料 Bible Study ";
                $text_cmp .= "<select name=\"$osis\" onchange=\"javascript:handleSelect(this)\">\n<option value=\"\">请选择 Please Select</option>\n";
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
                $text_cmp .= " <small><a href=\"bible.php?cmd=like&b=$bid&c=$cid&v=$vid\"><img src='like.png' width=14 height=14 border=0 alt='Like'/>喜爱本节 Like the Verse</a>";
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
    } catch (Exception $e) {
        $echo_string = "Database query error: " . htmlspecialchars($e->getMessage());
    }
}

$text_tw = "<p>" . $text_tw . " (繁體和合本 CUVT)</p>";
$text_cn = "<p>" . $text_cn . " (和合本 CUV)</p>";
$text_en = "<p>" . $text_en . " (King James Version KJV)</p>";

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
</script>
<style type="text/css">
.light {
    background-color: #ffffff;
}
.dark {
    background-color: #eeeeee;
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
           $wiki_base, $long_url_base, $short_url_base, $book_chinese, $book_english, $book_cn, $book_short, $extend;
?>
<center><div align="center">
<form method="GET" action="<?php echo htmlspecialchars($script); ?>">
<?php if ($portable) { ?>
    <input type="text" size="40" maxlength="128" name="q" value="<?php echo htmlspecialchars($query ?? ''); ?>">
<?php } else { ?>
    <input type="text" size="80" maxlength="128" name="q" value="<?php echo htmlspecialchars($query ?? ''); ?>">
<?php } ?>
<input type="submit" value="研读 STUDY">
<?php if ($portable) echo "<br/>"; ?>
<input type='checkbox' name='o' id='<?php echo "o$seq"; ?>' value='<?php echo "o$seq"; ?>' <?php if ($options) echo 'checked'; ?> onChange="javascript:toggleOptions(this,<?php echo $seq; ?>)">选项 Options
<input type='checkbox' name='p' value='1' <?php if ($portable) echo 'checked'; ?>>便携 Portable
<a href="help.php"> 帮助 Help</a>
<small><a href="copyright.php">版权 Copyright</a></small>
<div id="<?php echo "options$seq"; ?>" style="display: <?php echo $options ? 'inline' : 'none'; ?>">
<br/>书卷 Books
<select name="b">
    <option value="0" <?php if ($books == 0) echo "SELECTED"; ?>>整本圣经 Whole Bible</option>
    <option value="100" <?php if ($books == 100) echo "SELECTED"; ?>>基督徒百科 CCWiki</option>
    <option value="1-39" <?php if ($books == "1-39") echo "SELECTED"; ?>>旧约全书 Old Testament</option>
    <option value="40-66" <?php if ($books == "40-66") echo "SELECTED"; ?>>新约全书 New Testament</option>
    <option value="1-5" <?php if ($books == "1-5") echo "SELECTED"; ?>>摩西五经 Law (Gen - Deut)</option>
    <option value="6-17" <?php if ($books == "6-17") echo "SELECTED"; ?>>历史书 History (Josh - Esth)</option>
    <option value="18-22" <?php if ($books == "18-22") echo "SELECTED"; ?>>诗歌智慧书 Poetry & Wisdom (Job - Song)</option>
    <option value="23-27" <?php if ($books == "23-27") echo "SELECTED"; ?>>大先知书 Major Prophets (Is - Dan)</option>
    <option value="28-39" <?php if ($books == "28-39") echo "SELECTED"; ?>>小先知书 Minor Prophets (Hos - Mal)</option>
    <option value="40-44" <?php if ($books == "40-44") echo "SELECTED"; ?>>福音历史书 Gospels (Matt - Acts)</option>
    <option value="45-57" <?php if ($books == "45-57") echo "SELECTED"; ?>>保罗书信 Paul's Epistles (Rom - Philem)</option>
    <option value="58-66" <?php if ($books == "58-66") echo "SELECTED"; ?>>一般使徒书信 General Epistles (Heb - Rev)</option>
    <?php for ($i = 1; $i <= 66; $i++) { ?>
        <option value="<?php echo $i; ?>" <?php if ($books == $i) echo "SELECTED"; ?>><?php echo htmlspecialchars(($book_chinese[$i] ?? '') . " " . ($book_english[$i] ?? '')); ?></option>
    <?php } ?>
</select>
<?php if ($portable) echo "<br/>"; ?>
多 Multi<select name="m">
    <option value="0" <?php if ($multi_verse == 0) echo "SELECTED"; ?>>单节 Single Verse</option>
    <option value="1" <?php if ($multi_verse == 1) echo "SELECTED"; ?>>多节 Multi Verse</option>
</select>节 VV
扩展 Ext<select name="e">
    <option value="0" <?php if (!$extend || $extend == 0) echo "SELECTED"; ?>>0</option>
    <option value="1" <?php if ($extend == 1) echo "SELECTED"; ?>>1</option>
    <option value="2" <?php if ($extend == 2) echo "SELECTED"; ?>>2</option>
    <option value="3" <?php if ($extend == 3) echo "SELECTED"; ?>>3</option>
    <option value="4" <?php if ($extend == 4) echo "SELECTED"; ?>>4</option>
    <option value="5" <?php if ($extend == 5) echo "SELECTED"; ?>>5</option>
</select>节 VV
<input type='checkbox' name='cn' value='1' <?php if ($cn) echo 'checked'; ?>>简CN
<input type='checkbox' name='tw' value='1' <?php if ($tw) echo 'checked'; ?>>繁TW
<input type='checkbox' name='en' value='1' <?php if ($en) echo 'checked'; ?>>英EN
<br/>
<input type='checkbox' name='strongs' value='strongs' <?php if ($strongs) echo 'checked'; ?>>带原文编号 W/ Strong's Code*
<input type='checkbox' name='cuvs' value='cuvs' <?php if ($cuvs) echo 'checked'; ?>>简体和合本CUVS*
<input type='checkbox' name='cuvt' value='cuvt' <?php if ($cuvt) echo 'checked'; ?>>繁体和合本CUVT*
<?php if ($portable) echo "<br/>"; ?>
<input type='checkbox' name='kjv' value='kjv' <?php if ($kjv) echo 'checked'; ?>>英王钦定本KJV*
<input type='checkbox' name='nasb' value='nasb' <?php if ($nasb) echo 'checked'; ?>>新美国标准圣经NASB*
<input type='checkbox' name='esv' value='esv' <?php if ($esv) echo 'checked'; ?>>英文标准版本ESV
<br/>
<input type='checkbox' name='cuvc' value='cuvc' <?php if ($cuvc) echo 'checked'; ?>>文理和合CUVC
<input type='checkbox' name='ncvs' value='ncvs' <?php if ($ncvs) echo 'checked'; ?>>新译本NCVS
<input type='checkbox' name='lcvs' value='lcvs' <?php if ($lcvs) echo 'checked'; ?>>吕振中LCVS
<input type='checkbox' name='ccsb' value='ccsb' <?php if ($ccsb) echo 'checked'; ?>>思高本CCSB
<?php if ($portable) echo "<br/>"; ?>
<input type='checkbox' name='clbs' value='clbs' <?php if ($clbs) echo 'checked'; ?>>当代圣经CLBS
<input type='checkbox' name='ckjvs' value='ckjvs' <?php if ($ckjvs) echo 'checked'; ?>>简体钦定本CKJVS
<input type='checkbox' name='ckjvt' value='ckjvt' <?php if ($ckjvt) echo 'checked'; ?>>繁体钦定本CKJVT
<br/>
<input type='checkbox' name='pinyin' value='pinyin' <?php if ($pinyin) echo 'checked'; ?>>拼音pinyin
<input type='checkbox' name='ukjv' value='ukjv' <?php if ($ukjv) echo 'checked'; ?>>更新钦定UKJV
<input type='checkbox' name='kjv1611' value='kjv1611' <?php if ($kjv1611) echo 'checked'; ?>>1611钦定 KJV1611
<input type='checkbox' name='bbe' value='bbe' <?php if ($bbe) echo 'checked'; ?>>简易英文BBE
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
    echo htmlspecialchars($echo_string);
}
?>
<center><div align="center"><p>
【<strong>字体大小 FontSize</strong>
<a href="javascript:FontZoom(9)">更小 XS</a>
<a href="javascript:FontZoom(10)">小 S</a>
<a href="javascript:FontZoom(12)">中 M</a>
<a href="javascript:FontZoom(14)">大 L</a>
<a href="javascript:FontZoom(16)">更大 XL</a>】
</p></div></center>
<?php
if (!$show_verse && !$portable) {
    if ($cn) {
        echo "<p> </p>";
        echo $text_cn;
    }
    if ($tw) {
        echo "<p> </p>\n";
        echo $text_tw;
    }
    if ($en) {
        echo "<p> </p>\n";
        echo $text_en;
    }
} else {
    echo "<p> </p>\n";
    echo $text_cmp;
    echo "<p> </p>\n";
    echo "<p> </p>\n";
    if ($cn) {
        echo $text_cn;
    }
    echo "<p> </p>\n";
    if ($tw) {
        echo $text_tw;
    }
    echo "<p> </p>\n";
    if ($en) {
        echo $text_en;
    }
    echo "<p> </p>\n";
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