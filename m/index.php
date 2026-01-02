<?php

// Initialize variables to prevent undefined warnings
$echo_string = '';
$text_tw = '';
$text_cn = '';
$text_en = '';
$text_cmp = '';
$text_py = '';
$short_url_base = '';
$long_url_base = '';
$img_url = '';
$sitename = '';
$wiki_base = '';
$wiki_search_base = '';
$extend = 1;
$clbs = '';
$ccsb = '';
$ckjvs = '';
$ckjvt = '';
$cuvs = '';
$cuvt = '';
$cuvc = '';
$ncvs = '';
$pinyin = '';
$lcvs = '';
$kjv = '';
$nasb = '';
$esv = '';
$ukjv = '';
$kjv1611 = '';
$bbe = '';
$tr = '';
$wlc = '';
$name = '';
$chapter = 0;
$verse = 0;
$verse2 = 0;
$mode = '';
$book = 0;
$book2 = 0;

$book_short=array("", "Gen", "Exod", "Lev", "Num", "Deut", "Josh", "Judg", "Ruth", "1Sam", "2Sam", "1Kgs", "2Kgs", "1Chr", "2Chr", "Ezra", "Neh", "Esth", "Job", "Ps", "Prov", "Eccl", "Song", "Isa", "Jer", "Lam", "Ezek", "Dan", "Hos", "Joel", "Amos", "Obad", "Jonah", "Mic", "Nah", "Hab", "Zeph", "Hag", "Zech", "Mal", "Matt", "Mark", "Luke", "John", "Acts", "Rom", "1Cor", "2Cor", "Gal", "Eph", "Phil", "Col", "1Thess", "2Thess", "1Tim", "2Tim", "Titus", "Phlm", "Heb", "Jas", "1Pet", "2Pet", "1John", "2John", "3John", "Jude", "Rev");
//$book_index=array(""=>0, "Gen"=>1, "Exod"=>2, "Lev"=>3, "Num"=>4, "Deut"=>5, "Josh"=>6, "Judg"=>7, "Ruth"=>8, "1Sam"=>9, "2Sam"=>10, "1Kgs"=>11, "2Kgs"=>12, "1Chr"=>13, "2Chr"=>14, "Ezra"=>15, "Neh"=>16, "Esth"=>17, "Job"=>18, "Ps"=>19, "Prov"=>20, "Eccl"=>21, "Song"=>22, "Isa"=>23, "Jer"=>24, "Lam"=>25, "Ezek"=>26, "Dan"=>27, "Hos"=>28, "Joel"=>29, "Amos"=>30, "Obad"=>31, "Jonah"=>32, "Mic"=>33, "Nah"=>34, "Hab"=>35, "Zeph"=>36, "Hag"=>37, "Zech"=>38, "Mal"=>39, "Matt"=>40, "Mark"=>41, "Luke"=>42, "John"=>43, "Acts"=>44, "Rom"=>45, "1Cor"=>46, "2Cor"=>47, "Gal"=>48, "Eph"=>49, "Phil"=>50, "Col"=>51, "1Thess"=>52, "2Thess"=>53, "1Tim"=>54, "2Tim"=>55, "Titus"=>56, "Phlm"=>57, "Heb"=>58, "Jas"=>59, "1Pet"=>60, "2Pet"=>61, "1John"=>62, "2John"=>63, "3John"=>64, "Jude"=>65, "Rev"=>66);
$book_english=array( "", "Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalms", "Proverbs", "Ecclesiastes", "Song of Solomon", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habakkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi", "Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation");
$book_english2=array( "", "Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalm", "Proverbs", "Ecclesiastes", "Song of Songs", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habakkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi", "Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation");
$book_en=array("", "Gen", "Ex", "Lev", "Num", "Deut", "Josh", "Judg", "Ruth", "1 Sam", "2 Sam", "1 Kin", "2 Kin", "1 Chr", "2 Chr", "Ezra", "Neh", "Esth", "Job", "Ps", "Prov", "Eccl", "Song", "Is", "Jer", "Lam", "Ezek", "Dan", "Hos", "Joel", "Amos", "Obad", "Jon", "Mic", "Nah", "Hab", "Zeph", "Hag", "Zech", "Mal", "Matt", "Mark", "Luke", "John", "Acts", "Rom", "1 Cor", "2 Cor", "Gal", "Eph", "Phil", "Col", "1 Thess", "2 Thess", "1 Tim", "2 Tim", "Titus", "Philem", "Heb", "James", "1 Pet", "2 Pet", "1 John", "2 John", "3 John", "Jude", "Rev");
$book_en2=array("", "Ge", "Ex", "Le", "Nu", "De", "Jos", "Jud", "Ru", "1Sa", "2Sa", "1Ki", "2Ki", "1Ch", "2Ch", "Ezr", "Ne", "Es", "Job", "Psalm", "Pr", "Ec", "So", "Isa", "Jer", "La", "Eze", "Da", "Ho", "Joe", "Am", "Ob", "Jon", "Mic", "Na", "Hab", "Zep", "Hag", "Zec", "Mal", "Mt", "Mr", "Lu", "Joh", "Ac", "Ro", "1Co", "2Co", "Ga", "Eph", "Php", "Col", "1Th", "2Th", "1Ti", "2Ti", "Tit", "Phm", "Heb", "Jas", "1Pe", "2Pe", "1Jo", "2Jo", "3Jo", "Jude", "Re");
$book_en3=array("", "Gen", "Exo", "Lev", "Num", "Deu", "Jos", "Jdg", "Rut", "1Sa", "2Sa", "1Ki", "2Ki", "1Ch", "2Ch", "Ezr", "Neh", "Est", "Job", "Psa", "Pro", "Ecc", "Son", "Isa", "Jer", "Lam", "Eze", "Dan", "Hos", "Joe", "Amo", "Oba", "Jon", "Mic", "Nah", "Hab", "Zep", "Hag", "Zec", "Mal", "Mat", "Mar", "Luk", "Joh", "Act", "Rom", "1Co", "2Co", "Gal", "Eph", "Phi", "Col", "1Th", "2Th", "1Ti", "2Ti", "Tit", "Phm", "Heb", "Jam", "1Pe", "2Pe", "1Jo", "2Jo", "3Jo", "Jud", "Rev");
$book_chinese=array("", "创世记", "出埃及记", "利未记", "民数记", "申命记", "约书亚记", "士师记", "路得记", "撒母耳记上", "撒母耳记下", "列王纪上", "列王纪下", "历代志上", "历代志下", "以斯拉记", "尼希米记", "以斯帖记", "约伯记", "诗篇", "箴言", "传道书", "雅歌", "以赛亚书", "耶利米书", "耶利米哀歌", "以西结书", "但以理书", "何西阿书", "约珥书", "阿摩司书", "俄巴底亚书", "约拿书", "弥迦书", "那鸿书", "哈巴谷书", "西番雅书", "哈该书", "撒迦利亚书", "玛拉基书", "马太福音", "马可福音", "路加福音", "约翰福音", "使徒行传", "罗马书", "哥林多前书", "哥林多后书", "加拉太书", "以弗所书", "腓立比书", "歌罗西书", "帖撒罗尼迦前书", "帖撒罗尼迦后书", "提摩太前书", "提摩太后书", "提多书", "腓利门书", "希伯来书", "雅各书", "彼得前书", "彼得后书", "约翰一书", "约翰二书", "约翰三书", "犹大书", "启示录");
$book_cn=array("", "创", "出", "利", "民", "申", "书", "士", "得", "撒上", "撒下", "王上", "王下", "代上", "代下", "拉", "尼", "斯", "伯", "诗", "箴", "传", "歌", "赛", "耶", "哀", "结", "但", "何", "珥", "摩", "俄", "拿", "弥", "鸿", "哈", "番", "该", "亚", "玛", "太", "可", "路", "约", "徒", "罗", "林前", "林后", "加", "弗", "腓", "西", "帖前", "帖后", "提前", "提后", "多", "门", "来", "雅", "彼前", "彼后", "约一", "约二", "约三", "犹", "启");
$book_taiwan=array("", "創世記", "出埃及記", "利未記", "民數記", "申命記", "約書亞記", "士師記", "路得記", "撒母耳記上", "撒母耳記下", "列王紀上", "列王紀下", "歷代志上", "歷代志下", "以斯拉記", "尼希米記", "以斯帖記", "約伯記", "詩篇", "箴言", "傳道書", "雅歌", "以賽亞書", "耶利米書", "耶利米哀歌", "以西結書", "但以理書", "何西阿書", "約珥書", "阿摩司書", "俄巴底亞書", "約拿書", "彌迦書", "那鴻書", "哈巴谷書", "西番雅書", "哈該書", "撒迦利亞書", "瑪拉基書", "馬太福音", "馬可福音", "路加福音", "約翰福音", "使徒行傳", "羅馬書", "哥林多前書", "哥林多後書", "加拉太書", "以弗所書", "腓立比書", "歌羅西書", "帖撒羅尼迦", "帖撒羅尼迦", "提摩太前書", "提摩太後書", "提多書", "腓利門書", "希伯來書", "雅各書", "彼得前書", "彼得後書", "約翰一書", "約翰二書", "約翰三書", "猶大書", "啟示錄");
$book_tw=array("", "創", "出", "利", "民", "申", "書", "士", "得", "撒上", "撒下", "王上", "王下", "代上", "代下", "拉", "尼", "斯", "伯", "詩", "箴", "傳", "歌", "賽", "耶", "哀", "結", "但", "何", "珥", "摩", "俄", "拿", "彌", "鴻", "哈", "番", "該", "亞", "瑪", "太", "可", "路", "約", "徒", "羅", "林前", "林後", "加", "弗", "腓", "西", "帖前", "帖後", "提前", "提後", "多", "門", "來", "雅", "彼前", "彼後", "約一", "約二", "約三", "猶", "啟");
$book_short_index=array(""=>0, 
"Gen"=>1, "Exod"=>2, "Lev"=>3, "Num"=>4, "Deut"=>5, 
"Josh"=>6, "Judg"=>7, "Ruth"=>8, "1Sam"=>9, "2Sam"=>10, "1Kgs"=>11, "2Kgs"=>12, "1Chr"=>13, "2Chr"=>14, 
"Ezra"=>15, "Neh"=>16, "Esth"=>17, "Job"=>18, "Ps"=>19, "Prov"=>20, "Eccl"=>21, "Song"=>22, 
"Isa"=>23, "Jer"=>24, "Lam"=>25, "Ezek"=>26, "Dan"=>27, 
"Hos"=>28, "Joel"=>29, "Amos"=>30, "Obad"=>31, "Jonah"=>32, "Mic"=>33, "Nah"=>34, "Hab"=>35, "Zeph"=>36, "Hag"=>37, "Zech"=>38, "Mal"=>39, 
"Matt"=>40, "Mark"=>41, "Luke"=>42, "John"=>43, "Acts"=>44, 
"Rom"=>45, "1Cor"=>46, "2Cor"=>47, "Gal"=>48, "Eph"=>49, "Phil"=>50, "Col"=>51, "1Thess"=>52, "2Thess"=>53, "1Tim"=>54, "2Tim"=>55, "Titus"=>56, "Phlm"=>57, 
"Heb"=>58, "Jas"=>59, "1Pet"=>60, "2Pet"=>61, "1John"=>62, "2John"=>63, "3John"=>64, "Jude"=>65, "Rev"=>66);
$book_count=array(0, 
50, 40, 27, 36, 34, 
24, 21, 4, 31, 24, 22, 25, 29, 36, 
10, 13, 10, 42, 150, 31, 12, 8, 
66, 52, 5, 48, 12, 
14, 3, 9, 1, 4, 7, 3, 3, 3, 2, 14, 4, 
28, 16, 24, 21, 28, 
16, 16, 13, 6, 6, 4, 4, 5, 3, 6, 4, 3, 1, 
13, 5, 5, 3, 5, 1, 1, 1, 22);
$book_offset=array(0, 
0, 50, 90, 117, 153, 
187, 211, 232, 236, 267, 291, 313, 338, 367, 
403, 413, 426, 436, 478, 628, 659, 671, 
679, 745, 797, 802, 850, 
862, 876, 879, 888, 889, 893, 900, 903, 906, 909, 911, 925, 
929, 957, 973, 997, 1018, 
1046, 1062, 1078, 1091, 1097, 1103, 1107, 1111, 1116, 1119, 1125, 1129, 1132, 
1133, 1146, 1151, 1156, 1159, 1164, 1165, 1166, 1167);

$book_index=array(
"1Ch" => 13,
"1 Chr" => 13,
"1Chr" => 13,
"1Chronicles" => 13,
"1 Chronicles" => 13,
"1Co" => 46,
"1 Cor" => 46,
"1Cor" => 46,
"1Corinthians" => 46,
"1 Corinthians" => 46,
"1J" => 62,
"1Jn" => 62,
"1Jo" => 62,
"1 John" => 62,
"1John" => 62,
"1K" => 11,
"1Kgs" => 11,
"1Ki" => 11,
"1 Kin" => 11,
"1Kings" => 11,
"1 Kings" => 11,
"1P" => 60,
"1Pe" => 60,
"1 Pet" => 60,
"1Pet" => 60,
"1Peter" => 60,
"1 Peter" => 60,
"1S" => 9,
"1Sa" => 9,
"1 Sam" => 9,
"1Sam" => 9,
"1Samuel" => 9,
"1 Samuel" => 9,
"1Th" => 52,
"1 Th" => 52,
"1 Thess" => 52,
"1Thess" => 52,
"1Thessalonians" => 52,
"1 Thessalonians" => 52,
"1Ti" => 54,
"1 Tim" => 54,
"1Tim" => 54,
"1Timothy" => 54,
"1 Timothy" => 54,
"1Tm" => 54,
"2Ch" => 14,
"2 Chr" => 14,
"2Chr" => 14,
"2Chronicles" => 14,
"2 Chronicles" => 14,
"2Co" => 47,
"2 Cor" => 47,
"2Cor" => 47,
"2Corinthians" => 47,
"2 Corinthians" => 47,
"2J" => 63,
"2Jn" => 63,
"2Jo" => 63,
"2 John" => 63,
"2John" => 63,
"2K" => 12,
"2Kgs" => 12,
"2Ki" => 12,
"2 Kin" => 12,
"2Kings" => 12,
"2 Kings" => 12,
"2P" => 61,
"2Pe" => 61,
"2 Pet" => 61,
"2Pet" => 61,
"2Peter" => 61,
"2 Peter" => 61,
"2S" => 10,
"2Sa" => 10,
"2 Sam" => 10,
"2Sam" => 10,
"2Samuel" => 10,
"2 Samuel" => 10,
"2Th" => 53,
"2 Th" => 53,
"2 Thess" => 53,
"2Thess" => 53,
"2Thessalonians" => 53,
"2 Thessalonians" => 53,
"2Ti" => 55,
"2 Tim" => 55,
"2Tim" => 55,
"2Timothy" => 55,
"2 Timothy" => 55,
"2Tm" => 55,
"3J" => 64,
"3Jn" => 64,
"3Jo" => 64,
"3 John" => 64,
"3John" => 64,
"Ac" => 44,
"Act" => 44,
"Acts" => 44,
"Am" => 30,
"Amo" => 30,
"Amos" => 30,
"Cs" => 51,
"Col" => 51,
"Colossians" => 51,
"Da" => 27,
"Dan" => 27,
"Daniel" => 27,
"De" => 5,
"Deu" => 5,
"Deut" => 5,
"Deuteronomy" => 5,
"Dn" => 27,
"Dt" => 5,
"Ec" => 21,
"Ecc" => 21,
"Eccl" => 21,
"Ecclesiastes" => 21,
"Ep" => 49,
"Eph" => 49,
"Ephesians" => 49,
"Es" => 17,
"Est" => 17,
"Esth" => 17,
"Esther" => 17,
"Ex" => 2,
"Exo" => 2,
"Exod" => 2,
"Exodus" => 2,
"Eze" => 26,
"Ezek" => 26,
"Ezekiel" => 26,
"Ezr" => 15,
"Ezra" => 15,
"Ga" => 48,
"Gal" => 48,
"Galatians" => 48,
"Ge" => 1,
"Gen" => 1,
"Genesis" => 1,
"Gn" => 1,
"Hab" => 35,
"Habakkuk" => 35,
"Hag" => 37,
"Haggai" => 37,
"Hb" => 58,
"Heb" => 58,
"Hebrews" => 58,
"Hg" => 37,
"Ho" => 28,
"Hos" => 28,
"Hosea" => 28,
"Hs" => 28,
"Is" => 23,
"Isa" => 23,
"Isaiah" => 23,
"Jam" => 59,
"James" => 59,
"Jas" => 59,
"Jb" => 18,
"Jd" => 65,
"Jdg" => 7,
"Jer" => 24,
"Jeremiah" => 24,
"Jg" => 7,
"Jl" => 29,
"Jm" => 59,
"Jn" => 43,
"Jnh" => 32,
"Job" => 18,
"Joe" => 29,
"Joel" => 29,
"Joh" => 43,
"John" => 43,
"Jon" => 32,
"Jonah" => 32,
"Jos" => 6,
"Josh" => 6,
"Joshua" => 6,
"Jr" => 24,
"Jud" => 65,
"Jude" => 65,
"Judg" => 7,
"Judges" => 7,
"La" => 25,
"Lam" => 25,
"Lamentations" => 25,
"Le" => 3,
"Lev" => 3,
"Leviticus" => 3,
"Lk" => 42,
"Lm" => 25,
"Lu" => 42,
"Luk" => 42,
"Luke" => 42,
"Lv" => 3,
"Mal" => 39,
"Malachi" => 39,
"Mar" => 41,
"Mark" => 41,
"Mat" => 40,
"Matt" => 40,
"Matthew" => 40,
"Mi" => 33,
"Mic" => 33,
"Micah" => 33,
"Mk" => 41,
"Mr" => 41,
"Mt" => 40,
"Na" => 34,
"Nah" => 34,
"Nahum" => 34,
"Ne" => 16,
"Neh" => 16,
"Nehemiah" => 16,
"Nm" => 4,
"No" => 4,
"Nu" => 4,
"Num" => 4,
"Numbers" => 4,
"Ob" => 31,
"Oba" => 31,
"Obad" => 31,
"Obadiah" => 31,
"Phi" => 50,
"Phil" => 50,
"Philem" => 57,
"Philemon" => 57,
"Philippians" => 50,
"Phlm" => 57,
"Phm" => 57,
"Php" => 50,
"Pm" => 57,
"Pp" => 50,
"Pr" => 20,
"Pro" => 20,
"Prov" => 20,
"Proverbs" => 20,
"Ps" => 19,
"Psa" => 19,
"Psalm" => 19,
"Psalms" => 19,
"Re" => 66,
"Rev" => 66,
"Rev" => 66,
"Revelation" => 66,
"Ro" => 45,
"Rom" => 45,
"Romans" => 45,
"Rm" => 45,
"Rt" => 8,
"Ru" => 8,
"Rut" => 8,
"Ruth" => 8,
"Rv" => 66,
"Sg" => 22,
"So" => 22,
"Son" => 22,
"Song" => 22,
"Song of Solomon" => 22,
"Song of Songs" => 22,
"SS" => 22,
"Tit" => 56,
"Titus" => 56,
"Tt" => 56,
"Zc" => 38,
"Zec" => 38,
"Zech" => 38,
"Zechariah" => 38,
"Zep" => 36,
"Zeph" => 36,
"Zephaniah" => 36,
"Zp" => 36,
"书" => 6,
"亚" => 38,
"亞" => 38,
"代上" => 13,
"代下" => 14,
"以弗所书" => 49,
"以弗所書" => 49,
"以斯帖記" => 17,
"以斯帖记" => 17,
"以斯拉記" => 15,
"以斯拉记" => 15,
"以西結書" => 26,
"以西结书" => 26,
"以賽亞書" => 23,
"以赛亚书" => 23,
"传" => 21,
"传道书" => 21,
"伯" => 18,
"但" => 27,
"但以理书" => 27,
"但以理書" => 27,
"何" => 28,
"何西阿书" => 28,
"何西阿書" => 28,
"使徒行传" => 44,
"使徒行傳" => 44,
"來" => 58,
"俄" => 31,
"俄巴底亚书" => 31,
"俄巴底亞書" => 31,
"傳" => 21,
"傳道書" => 21,
"出" => 2,
"出埃及記" => 2,
"出埃及记" => 2,
"列王紀上" => 11,
"列王紀下" => 12,
"列王纪上" => 11,
"列王纪下" => 12,
"创" => 1,
"创世记" => 1,
"利" => 3,
"利未記" => 3,
"利未记" => 3,
"創" => 1,
"創世記" => 1,
"加" => 48,
"加拉太书" => 48,
"加拉太書" => 48,
"历代志上" => 13,
"历代志下" => 14,
"可" => 41,
"启" => 66,
"启示录" => 66,
"哀" => 25,
"哈" => 35,
"哈巴谷书" => 35,
"哈巴谷書" => 35,
"哈該書" => 37,
"哈该书" => 37,
"哥林多前书" => 46,
"哥林多前書" => 46,
"哥林多后书" => 47,
"哥林多後書" => 47,
"啟" => 66,
"啟示錄" => 66,
"士" => 7,
"士师记" => 7,
"士師記" => 7,
"多" => 56,
"太" => 40,
"尼" => 16,
"尼希米記" => 16,
"尼希米记" => 16,
"希伯來書" => 58,
"希伯来书" => 58,
"帖前" => 52,
"帖后" => 53,
"帖後" => 53,
"帖撒罗尼迦" => 52,
"帖撒罗尼迦" => 53,
"帖撒羅尼迦" => 52,
"帖撒羅尼迦" => 53,
"弗" => 49,
"弥" => 33,
"弥迦书" => 33,
"彌" => 33,
"彌迦書" => 33,
"彼前" => 60,
"彼后" => 61,
"彼後" => 61,
"彼得前书" => 60,
"彼得前書" => 60,
"彼得后书" => 61,
"彼得後書" => 61,
"徒" => 44,
"得" => 8,
"拉" => 15,
"拿" => 32,
"提前" => 54,
"提后" => 55,
"提多书" => 56,
"提多書" => 56,
"提後" => 55,
"提摩太前书" => 54,
"提摩太前書" => 54,
"提摩太后书" => 55,
"提摩太後書" => 55,
"摩" => 30,
"撒上" => 9,
"撒下" => 10,
"撒母耳記上" => 9,
"撒母耳記下" => 10,
"撒母耳记上" => 9,
"撒母耳记下" => 10,
"撒迦利亚书" => 38,
"撒迦利亞書" => 38,
"斯" => 17,
"書" => 6,
"来" => 58,
"林前" => 46,
"林后" => 47,
"林後" => 47,
"歌" => 22,
"歌罗西书" => 51,
"歌羅西書" => 51,
"歷代志上" => 13,
"歷代志下" => 14,
"民" => 4,
"民数记" => 4,
"民數記" => 4,
"犹" => 65,
"犹大书" => 65,
"猶" => 65,
"猶大書" => 65,
"王上" => 11,
"王下" => 12,
"玛" => 39,
"玛拉基书" => 39,
"珥" => 29,
"瑪" => 39,
"瑪拉基書" => 39,
"申" => 5,
"申命記" => 5,
"申命记" => 5,
"番" => 36,
"箴" => 20,
"箴言" => 20,
"約" => 43,
"約一" => 62,
"約壹" => 62,
"約三" => 64,
"約叁" => 64,
"約二" => 63,
"約貳" => 63,
"約伯記" => 18,
"約拿書" => 32,
"約書亞記" => 6,
"約珥書" => 29,
"約翰一書" => 62,
"約翰壹書" => 62,
"約翰三書" => 64,
"約翰叁書" => 64,
"約翰二書" => 63,
"約翰貳書" => 63,
"約翰福音" => 43,
"結" => 26,
"约" => 43,
"约一" => 62,
"约壹" => 62,
"约三" => 64,
"约叁" => 64,
"约书亚记" => 6,
"约二" => 63,
"约贰" => 63,
"约伯记" => 18,
"约拿书" => 32,
"约珥书" => 29,
"约翰一书" => 62,
"约翰壹书" => 62,
"约翰三书" => 64,
"约翰叁书" => 64,
"约翰二书" => 63,
"约翰贰书" => 63,
"约翰福音" => 43,
"结" => 26,
"罗" => 45,
"罗马书" => 45,
"羅" => 45,
"羅馬書" => 45,
"耶" => 24,
"耶利米书" => 24,
"耶利米哀歌" => 25,
"耶利米書" => 24,
"腓" => 50,
"腓利門書" => 57,
"腓利门书" => 57,
"腓立比书" => 50,
"腓立比書" => 50,
"西" => 51,
"西番雅书" => 36,
"西番雅書" => 36,
"詩" => 19,
"詩篇" => 19,
"該" => 37,
"诗" => 19,
"诗篇" => 19,
"该" => 37,
"賽" => 23,
"赛" => 23,
"路" => 42,
"路加福音" => 42,
"路得記" => 8,
"路得记" => 8,
"那鴻書" => 34,
"那鸿书" => 34,
"門" => 57,
"门" => 57,
"阿摩司书" => 30,
"阿摩司書" => 30,
"雅" => 59,
"雅各书" => 59,
"雅各書" => 59,
"雅歌" => 22,
"馬可福音" => 41,
"馬太福音" => 40,
"马可福音" => 41,
"马太福音" => 40,
"鴻" => 34,
"鸿" => 34
);
krsort($book_index); //reversely sort by keys
ini_set('display_errors', 'Off');
//error_reporting(E_ALL | STRICT);

//error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_REQUEST['a'])) 
{
	$_REQUEST['a'] = ""; 
}
if (!isset($_REQUEST['api'])) 
{
	$_REQUEST['api'] = $_REQUEST['a']; 
}

if (!isset($_REQUEST['i'])) 
{
	$_REQUEST['i'] = ""; 
}
if (!isset($_REQUEST['c'])) 
{
	$_REQUEST['c'] = ""; 
}
if (!isset($_REQUEST['v'])) 
{
	$_REQUEST['v'] = ""; 
}
if (!isset($_REQUEST['v2'])) 
{
	$_REQUEST['v2'] = ""; 
}
if (!isset($_REQUEST['b'])) 
{
	$_REQUEST['b'] = ""; 
}
if (!isset($_REQUEST['l'])) 
{
	$_REQUEST['l'] = ""; 
}
if (!isset($_REQUEST['m'])) 
{
	$_REQUEST['m'] = ""; 
}
if (!isset($_REQUEST['n'])) 
{
	$_REQUEST['n'] = ""; 
}
if (!isset($_REQUEST['p'])) 
{
	$_REQUEST['p'] = ""; 
}
if (!isset($_REQUEST['q'])) 
{
	$_REQUEST['q'] = ""; 
}
if (!isset($_REQUEST['s'])) 
{
	$_REQUEST['s'] = ""; 
}

if (!isset($_REQUEST['w'])) 
{
	$_REQUEST['w'] = ""; 
}
if (!isset($_REQUEST['mode'])) 
{
	$_REQUEST['mode'] = ""; 
}
if (!isset($_REQUEST['b'])) 
{
	$_REQUEST['b'] = ""; 
}
if (!isset($_REQUEST['o'])) 
{
	$_REQUEST['o'] = ""; 
}
$echo_string = ''; // Initialize echo_string
$mode = trim($_REQUEST['mode'] ?? '');
//if(!$mode)
//	$mode='READ';
$search = trim($_REQUEST['s'] ?? '');
$index = trim($_REQUEST['i'] ?? '');
$chapter = (int)($_REQUEST['c'] ?? 0);
$verse = (int)($_REQUEST['v'] ?? 0);
$verse2 = (int)($_REQUEST['v2'] ?? 0);
$books = $_REQUEST['b'] ?? '';
$options = $_REQUEST['o'] ?? '';
list($book,$book2) = array_pad(explode("-", $books, 2), 2, '');
$book = $book ? (int)$book : 0;
$book2 = $book2 ? (int)$book2 : 0;
//$range = $_REQUEST['r'];
$name = $_REQUEST['n'] ?? '';
$portable=$_REQUEST['p'] ?? '';
$portable=1;
$query=trim($_REQUEST['q'] ?? '');
if(!$query)
{
	require_once(__DIR__ . "/../votd.php");
	$query=$votd_string ?? '';
}
/*
if(preg_match('/index/i',$query))
{
	$query = ""; 
}
*/
//replace chinese space, semi-comma, comma into english version
$search=array('　','：','，','.','—','－','；');
$replace=array(' ',':',',',':','-','-',';');
$query=str_replace($search,$replace,$query);
preg_match("/@(.*)/", $query, $query_option_array);
//print_r($query_option_array);
$query_options = isset($query_option_array[1]) ? $query_option_array[1] : '';
//ltrim($query_options, "@");
$query_without_options=preg_replace("/@(.*)/","",$query);
if($query_options)
{
	//echo $query_options;
	$query_option = '';
	$query_option2 = '';
	if(strstr($query_options,"-"))
	{
		$query_options_parts = explode("-", $query_options, 2);
		$query_option = $query_options_parts[0] ?? '';
		$query_option2 = $query_options_parts[1] ?? '';
	}
	else
		$query_option=$query_options;
	//echo $query_option . " " . $query_option2;
	if((int)$query_option)
		$book=(int)$query_option;
	elseif(isset($book_index[$query_option]) && $book_index[$query_option])
		$book=$book_index[$query_option];
	//echo $book_index[$query_option];
	//echo "Book=$book";
	if((int)$query_option)
		$book2=(int)$query_option2;
	else if(isset($book_index[$query_option2]) && $book_index[$query_option2])
		$book2=$book_index[$query_option2];
	//echo "Book2=$book2";
}	
$queries=explode(" ",$query_without_options);
$multi_verse=$_REQUEST['m'];
if(!$multi_verse)
	$multi_verse=0;
$extend=isset($_REQUEST['e'])?(int)$_REQUEST['e']:1;
$search_table = 'bible_search';
$language = strtolower($_REQUEST['l']); //cn, tw, en

$wiki= $_REQUEST['w'];
//$wiki= 1;
$api = $_REQUEST['api'];
$script =  $_SERVER['PHP_SELF'];
$script = "index.php";

/*
$cuvs=$_REQUEST['cuvs'];
$cuvt=$_REQUEST['cuvt'];
$cuvc=$_REQUEST['cuvc'];
$ncvs=$_REQUEST['ncvs'];
$pinyin=$_REQUEST['pinyin'];
$lcvs=$_REQUEST['lcvs'];
$ccsb=$_REQUEST['ccsb'];
$clbs=$_REQUEST['clbs'];
$kjv=$_REQUEST['kjv'];
$nasb=$_REQUEST['nasb'];
$ukjv=$_REQUEST['ukjv'];
$kjv1611=$_REQUEST['kjv1611'];
$bbe=$_REQUEST['bbe'];
$tr=$_REQUEST['tr'];
$wlc=$_REQUEST['wlc'];
$ckjvs=$_REQUEST['ckjvs'];
$ckjvt=$_REQUEST['ckjvt'];
*/
$cuvs=isset($_REQUEST['cuvs'])?"cuvs":"";
$cuvt=isset($_REQUEST['cuvt'])?"cuvt":"";
$cuvc=isset($_REQUEST['cuvc'])?"cuvc":"";
$ncvs=isset($_REQUEST['ncvs'])?"ncvs":"";
$pinyin=isset($_REQUEST['pinyin'])?"pinyin":"";
$lcvs=isset($_REQUEST['lcvs'])?"lcvs":"";
$ccsb=isset($_REQUEST['ccsb'])?"ccsb":"";
$clbs=isset($_REQUEST['clbs'])?"clbs":"";
$kjv=isset($_REQUEST['kjv'])?"kjv":"";
$nasb=isset($_REQUEST['nasb'])?"nasb":"";
$esv=isset($_REQUEST['esv'])?"esv":"";
$ukjv=isset($_REQUEST['ukjv'])?"ukjv":"";
$kjv1611=isset($_REQUEST['kjv1611'])?"kjv1611":"";
$bbe=isset($_REQUEST['bbe'])?"bbe":"";
$tr=isset($_REQUEST['tr'])?"tr":"";
$wlc=isset($_REQUEST['wlc'])?"wlc":"";
$ckjvs=isset($_REQUEST['ckjvs'])?"ckjvs":"";
$ckjvt=isset($_REQUEST['ckjvt'])?"ckjvt":"";

if(!$language)  
	$language="cn";
$cn=isset($_REQUEST['cn'])?1:0;
$en=isset($_REQUEST['en'])?1:0;
$tw=isset($_REQUEST['tw'])?1:0;

if(!$cn && !$cn && !$tw)
{
	$cn=1;
	$tw=0;
	$en=1;
	$pinyin="pinyin";
}
	

if($en){
	$nasb="nasb";
	//$esv="esv";
}

$bible_books=array($cuvs,$cuvt,$kjv,$nasb,$esv,$ncvs,$cuvc,$lcvs,$pinyin,$ccsb,$ckjvs,$ckjvt,$clbs,$ukjv,$kjv1611,$bbe);

$strongs = $_REQUEST['strongs'] ?? '';

// Set default values before including common.php and config.php
if (!$img_url) {
    $img_url = 'https://bibleengine.ai';
}
if (!$short_url_base) {
    $short_url_base = 'https://bibleengine.ai';
}
if (!$long_url_base) {
    $long_url_base = 'https://bibleengine.ai';
}
if (!$sitename) {
    $sitename = 'BibleEngine.ai';
}

//echo "book=" . $book . " chapter=" . $chapter . " chapter2="  . $chapter2 . " verse=" . $verse . " verse2=" .$verse2;


require_once(__DIR__ . "/../common.php");
require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../dbconfig.php");
//print_r($book_index);

//$init=false;
if(!$mode && !$book && !$query && !$wiki)
{ 
	if(!$name){
		$name = "John";
		$chapter=3;
		$verse=16;
	}
	//echo "name=$name";
	
	//echo "book=$book";
	$mode = "READ";
}
if(!$query && $mode=="READ")
{
	$book = $book_index[$name] ?? 43;
	if($book<=0 || $book > 66)
		$book=43;	
}


if(!$wiki && (!$chapter || $chapter < 1))
	$chapter = 1;
if(isset($book_count[$book]) && $chapter>$book_count[$book])
	$chapter=$book_count[$book];
elseif(!isset($book_count[$book]))
	$chapter = 1;
if(!$verse) $verse=1;	


try {
    $dbport_int = isset($dbport) ? (int)$dbport : 3306;
    $db = new mysqli($dbhost, $dbuser, $dbpassword, $database, $dbport_int);
    if ($db->connect_error) {
        throw new Exception("Connection Error: " . $db->connect_error);
    }
    $db->set_charset('utf8');
} catch (Exception $e) {
    die($e->getMessage());
}
/*
$db = new SaeMysql();
$sql="SET NAMES utf8";
$db->runSql( $sql );
*/
/*
$sql="select * FROM bible_book ORDER BY id";
$result = mysqli_query($db, $sql ) or die(" $sql Could not execute query.".mysqli_error());
$i=0;
$book_short[0]=$book_en3[0]="";
$book_en[0]=$book_english[0]="";
$book_cn[0]=$book_chinese[0]="";
$book_tw[0]=$book_taiwan[0]="";
$book_count[0]=0;
while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) {
	$id = $row[id];
	$book_short[$id] = $row[short];
	$book_english[$id] = $row[english];
	$book_en[$id] = $row[en];
	$book_en3[$id] = $row[en3];
	$book_chinese[$id] = $row[chinese];
	$book_cn[$id] = $row[cn];
	$book_taiwan[$id] = $row[taiwan];
	$book_tw[$id] = $row[tw];
	$book_count[$id] = $row[count];
	if(!$book && $init && $name == $book_short[$id])
	{
		$book=$id;
		//echo "\n<br/>book=$book";
	}	
}
*/
/*
if(!$init && !$books)
{
	if(!$book2)
		$books=$book;
	else
		$books = "$book-$book2";
}
*/

//mysqli_close($db);
$do_query = true;
//to search bible
$querystr="";
$sql="";
$count=0;
if($query)
{ //search

	//echo $query . "<br/>\n";
	$pattern="/[0-9]/";

	
	//query string is verse indeces
	if(preg_match($pattern, $query_without_options))
	{
		//echo $query . "<br/>\n";
		$query=str_replace(" ","",$query);
		$segments=explode(";",strtolower($query));
		foreach($segments as $segment){
			//$segment=trim($segment);
			$book_number = 0;
			$sql_where ="";
			$found=false;
			foreach($book_index as $book_name => $ii)
			{
				//$pos=stripos($segment,$book_name);
				//$book_name=ltrim($book_name);
				$pattern="/^$book_name ?[0-9]+/i";
				if(preg_match($pattern,$segment))
				//if($pos !== false)
				{
					$found=true;
					//echo $book_name;
					$book=$ii;
					$sql_where = " (book = $ii) ";
					$references = str_replace(" ","",substr($segment, strlen($book_name)));
					//echo $references;
					$references_parts = explode("-", $references, 2);
					$reference1 = $references_parts[0] ?? '';
					$reference2 = $references_parts[1] ?? '';
					$r1_parts = explode(":", $reference1, 2);
					$r1 = $r1_parts[0] ?? '';
					$r2 = $r1_parts[1] ?? '';
					$r3_parts = explode(":", $reference2, 2);
					$r3 = $r3_parts[0] ?? '';
					$r4 = $r3_parts[1] ?? '';
					list($ir1,$ir2,$ir3,$ir4)=array((int)($r1),(int)($r2),(int)($r3),(int)($r4));
					//echo "r1=$r1, r2=$r2, r3=$r3, r4=$r4<br/>\n";
					//echo "ir1=$ir1, ir2=$ir2, ir3=$ir3, ir4=$ir4";
					if(!$reference2)
					{
						//$chapter=$r1;
						if($ir1){
						
							$sql_where .= " AND (chapter=$ir1) ";
							$chapter=$ir1;
						}else
							$echo_string="章节格式错误，可能章号不正确，正确格式参考： John 3";
						if($r2) //only one whole chapter
						{ 
						
								//$verse = $r1;
					
								$verses_temp = explode(",",$r2);
								if((int)$verses_temp[0])
								{
									$verse=$verse2=$verses_temp[0];

									//$sql_where .= " AND ((verse=" . (int)$verses_temp[0] .  " )";
									$sql_where .= " AND (verse BETWEEN " . ((int)$verses_temp[0] - $extend) . " AND " . ((int)$verses_temp[0] + $extend);
									$index_temp=count($verses_temp);
									for($iii=1;$iii<$index_temp;$iii++)
									{
										//$sql_where .= " OR (verse=" . (int)$verses_temp[$iii] . ") ";
										$sql_where .= " OR verse BETWEEN " . ((int)$verses_temp[$iii] - $extend) . " AND " . ((int)$verses_temp[$iii] + $extend);
										$verse=$verse2=$verses_temp[$iii];

									}
									$sql_where .= ") ";
								}
								else
									$echo_string="章节格式错误，可能节号不正确，正确格式参考： John 3:16或者 John 3:16,19";
							/*			
							//$verse = $r1;
							if($ir2)
								$sql_where .= " AND (verse=$ir2)";
							else
								$echo_string="章节格式错误，可能节号不正确，正确格式参考： John 3:16";
							//echo $sql_where;
							*/
						}
					}else{ //$reference2 is not null
						if(!$r2 && !$r4){  // John 1-3
							if($ir1 && $ir3){
								$sql_where .= " AND (chapter BETWEEN $ir1 AND $ir3)";
								$chapter=$ir1;
							}else 
								$echo_string="章节格式错误，可能章号不正确，正确格式参考： John 3-4";

						}elseif($r2 && !$r4){ //John 3:16-18
							/*	
							if(($ir1) && ($ir2) && ($ir3))
								$sql_where .= " AND (chapter = $ir1) AND ( verse  BETWEEN $ir2 AND $ir3)";							
							else
								$echo_string="章节格式错误，可能章号或者节号不正确，正确格式参考：John 3:16-18";
							*/
								//with references, only one chapter $ir1
								//John 3:16-18,20    or Johen 3:16-18,19-21
								
							list($chapter_temp,$verse_string_temp)=explode(":",$references);
							$verse_array_temp = explode(",",$verse_string_temp);
							if(count($verse_array_temp)>0)
							{
								$sql_where .= "AND (chapter = " . (int)$chapter_temp . ") AND ( (1 = 0) ";
								$chapter=$chapter_temp;
								foreach ($verse_array_temp as $verse_temp)
								{
									list($verse1_temp,$verse2_temp)=explode("-",$verse_temp);
									$verse=$verse1_temp;
									$verse2=$verse2_temp;
									if((int)$verse2_temp)
									{
										$sql_where .= " OR (verse BETWEEN " . (int)$verse1_temp . " AND  " . (int)$verse2_temp . ") ";
									}else{
										$sql_where .= " OR (verse = " . (int)$verse1_temp . ") ";
									}
								}
								$sql_where .= ") ";
							}else{
							
								$echo_string="章节格式错误，可能章号或者节号不正确，正确格式参考：John 3:16-18 或 John 3:16-18,19-21 或 John 3:16-18,20";
							//echo "HELLOHELLO " . 	$sql_where;
							}

						}elseif(!$r2){
							if(($ir3) && ($ir4))
							{//John 3-5:6
								$irr=0 + $ir3 - 1;
								$sql_where .= " AND ( (chapter BETWEEN $ir1 AND $irr) OR ( (chapter = $ir3) AND (verse BETWEEN 1 AND $ir4)))";
								$chapter=$ir1;
								$verse=1;
								$verse2=$ir4;
							}
							else
								$echo_string="章节格式错误，可能章号不正确，正确格式参考：John 3-5:6";

						}
					}
					//$break=true;
					break;//break foreach book_index
				}//if preg_match	
				//if($break)
				//	break;
			} //foreach book_index
			if(!$found)
				$echo_string="未找到书卷名称";			
			if($sql_where && !$echo_string)
			{
				$count=0;
				//$echo_string=""; //ignore minor errors
				$sql= "SELECT book, chapter, verse FROM bible_books WHERE $sql_where";
				$result = mysqli_query($db, $sql) or die(" $sql Could not execute query." . mysqli_error($db));
				//$result = $db->getData( $sql );

				//while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) {
				while($row = mysqli_fetch_assoc($result)) {
				//foreach($result as $row){
					$count++;
					$bid = $row['book'] ?? 0;
					$cid = $row['chapter'] ?? 0;
					$vid = $row['verse'] ?? 0;
					$querystr .=  $bid . ":" . $cid . ":" . $vid . ",";
					if($count>500)
					{
						$echo_string="索引经文章节超过500条，请缩小范围后重新索引";
						$querystr ="";
						break;
					}
				}
				$mode='INDEX';
			}
			
		}//foreach segment			

	
			

		$querystr = rtrim($querystr,",");
		$index=$querystr;
//					echo $querystr;
			
		$do_query=false;
		$mode='INDEX';
	}else{
	//search
        $mode='QUERY';
		
		$count = count($queries);

		if($count > 10){
			$echo_string ="至多10个关键词，请缩小关键词的数量以降低服务器的开销。";
			$do_query =false;
		}

		if($multi_verse)
			$search_table = 'bible_multi_search';
		else
			$search_table = 'bible_search';
		
		
		//echo "range=" . $range . "\n";
		//echo "book=" . $book;
		$sql_where = "";

		if($book2)
				$sql_where =  " book BETWEEN $book AND $book2 ";
		elseif($book)
			$sql_where = " book = $book";
		else
			$sql_where = " 1=1 ";			


		if($do_query)
		{	
			//print_r($queries);
			$sql="select book,chapter,verse from $search_table WHERE txt LIKE '%" . $queries[0] . "%'";
			for($i=1; $i < $count; ++$i)
			{
				$sql = $sql . " AND txt LIKE '%" . $queries[$i] . "%' ";
			}
			if($sql_where)
				$sql = $sql . " AND (" . $sql_where . " ) ";
				
			//echo $sql;

			$result = mysqli_query($db, $sql ) or die(" $sql Could not execute query.".mysqli_error($db));
			//$result = $db->getData( $sql );

			$i=0;
			if(!$result)
				die("-3 No query result");
				
			$querystr = "";
			$querystrtext = "";
			while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) {
			//foreach($result as $row){
				$bid = $row[book];
				$cid = $row[chapter];
				$vid = $row[verse];
				$querystr = $querystr . $bid . ":" . $cid . ":" . $vid . ",";
				if($language == "tw")
					$querystrtext= $querystrtext . $book_tw[$bid] . ":" . $cid . ":" . $vid . ",";
				elseif($language == "en")
					$querystrtext= $querystrtext . $book_en[$bid] . ":" . $cid . ":" . $vid . ",";
				else
					$querystrtext= $querystrtext . $book_cn[$bid] . ":" . $cid . ":" . $vid . ",";
				// $response->verses[$i]['book'] = $bid;
				// $response->verses[$i]['chapter'] = $cid;
				// $response->verses[$i]['verse'] = $vid;
				$response[$i]= array($bid,$cid,$vid);
				if($language == "tw")
					$responsetext[$i] = array($book_tw[$bid],$cid,$vid);
				elseif($language == "en")
					$responsetext[$i] = array($book_en[$bid],$cid,$vid);
				else
					$responsetext[$i] = array($book_cn[$bid],$cid,$vid);
				//echo $query;
				$i ++;
				$count=$i;
				if($i >= $max_record_count){
					$echo_string .= "<h2>结果超出<b> $max_record_count </b>条记录，请增加关键词或者设定查询范围来准确查询</h2>";
					
					break;
				}
				

			}
			$querystr = rtrim($querystr,",");
			//$search = $querystr;
			if($querystr){ //there are result
				$index = $querystr;
				$echo_string .="<p>共查到<b>$count</b>条记录：</p>";
			}else{
				$index = '';
				$echo_string .= "<h2>没有查到记录，请修改搜索条件重新搜索</h2>";
			}
			
		}
	}
}	


//$filename = $_SERVER['SCRIPT_NAME'];
if($mode=='QUERY' && $api)
{
	if($api == "json")
	{
		echo json_encode($response);
		exit();
	}elseif($api == "text")
	{
		echo $querystrtext;
		exit();
	}else{
		echo $querystr;
		exit();
	}
	
}


//echo $index;
//echo $querystr;

$count = 0;

$english_title = ($book_chinese[$book] ?? '') . " " . ($book_english[$book] ?? '');
$short_url_title = $short_url_base . "/" . $book_short[$book];
if($chapter)
{
	$english_title .= " " . $chapter;
	$short_url_title .=  "." . $chapter;
}
if($verse)
{
	$english_title = $english_title . ":$verse";
	$short_url_title .= "." . $verse;
	$show_verse = true;
}else
	$show_verse = false;
if($index)
		$show_verse = true;
if($verse2)
{
	$english_title .=  "-$verse2";
	$short_url_title .= "-$verse2";
}



if($query)
		$title =  $query;
else
		$title = $english_title;
		
$title .= " - " . $sitename;;
/*if($mode != 'QUERY')
	$title .= $short_url_title . ".htm";
*/	

?>



<?php

$book_menu ="<p>旧约 (OT) ";
$wiki_book_menu= "<p>== 旧约 ==</p><p>&nbsp;</p>\n";
$verse_number = 0;
for($i=1;$i<=66;++$i) {
	if($book == $i)
	{
			$book_menu = $book_menu . " <strong>";
	}
	if($short_url_base)
		$book_menu = $book_menu . "&nbsp;  <a href=\"$short_url_base/" . $book_short[$i] . ".htm\" title=\"" .  $book_chinese[$i] . " (" . $book_english[$i]  . ") \">" . $book_cn[$i] . " (" . $book_short[$i]. ") </a> ";
	else
		$book_menu = $book_menu . "&nbsp;  <a href=\"$script?q=" . $book_short[$i] . " 1\"  title=\"" .  $book_chinese[$i] . " (" . $book_english[$i]  . ") \">" . $book_cn[$i] . " (" . $book_short[$i]. ") </a> ";
	
	if($book == $i)
	{
			$book_menu = $book_menu . "</strong>";
	}
	
	if($chapter)
	{
		$wiki_book_menu = $wiki_book_menu . "<p>[[MHC:" . $book_chinese[$i] . " | " . $book_cn[$i] . "(" . $book_short[$i] . ")" . "]]</p>\n";
	}else{
		$wiki_book_menu = $wiki_book_menu . "<p>[[MHC:" . $book_chinese[$i] . " | " . $book_chinese[$i] . "(" . $book_english[$i] . ")" . "]]</p>\n";
	}
	if($i == 39)
	{
		$book_menu = $book_menu . " <br/>新约 (NT) ";
		$wiki_book_menu = $wiki_book_menu . "\n<p> == 新约 == </p><p>&nbsp;</p>\n";
	}
	$book_menu = $book_menu . "\n";
	$wiki_book_menu = $wiki_book_menu . "\n";
}
$book_menu = $book_menu . " </p>";
$wiki_book_menu = $wiki_book_menu . "\n";

$chapter_menu =  $book_chinese[$book] . "(" . $book_cn[$book] . ") " . $book_english[$book] . "(" . $book_short[$book]  . ") ";
$wiki_chapter_menu = "<p>==". $book_chinese[$book] . "目录==</p><p>&nbsp;</p>\n";
for($i = 1; $i <= $book_count[$book]; $i++)
{
	if($i == $chapter)
	{
		$chapter_menu = $chapter_menu . "<strong>";
	}
	if($short_url_base)
		$chapter_menu = $chapter_menu . "<a href=\"$short_url_base/" . $book_short[$book] . "." . $i . ".htm\" title=\"" .  $book_chinese[$book] . " " . $i . " &nbsp; " . $book_english[$book] . " " . $i ."\"> &nbsp;" . $i . " </a> ";
	else
		$chapter_menu = $chapter_menu . "<a href=\"$script?q=" . $book_short[$book] . " " . $i . "\"  title=\"" .  $book_chinese[$book] . " " . $i . " &nbsp; " . $book_english[$book] . " " . $i ."\"> &nbsp;" . $i . " </a> ";

	if($chapter)
	{
		$wiki_chapter_menu = $wiki_chapter_menu . "<p>[[MHC:" . $book_chinese[$book] . " " . $i . " | " . $book_cn[$book] . " " . $i . "]]</p>\n";
	}else{
		$wiki_chapter_menu = $wiki_chapter_menu . "<p>[[MHC:" . $book_chinese[$book] . " " . $i . " | " . $book_chinese[$book] . " " . $i . "]]</p>\n";
	}

	if($i == $chapter)
	{
		$chapter_menu = $chapter_menu . "</strong>";
	}
	
	$chapter_menu = $chapter_menu . "\n";
	$wiki_chapter_menu = $wiki_chapter_menu . "\n";
	if(!$chapter && (($i % 5) == 0))
		$wiki_chapter_menu = $wiki_chapter_menu . "<p>&nbsp;</p>\n";
	if($chapter && (($i % 20 ) == 0))
		$wiki_chapter_menu = $wiki_chapter_menu . "<p>&nbsp;</p>\n";
}
//$chapter_menu = "<p>" . $chapter_menu . " " . $book_chinese[$book] . "(" . $book_cn[$book] . ") " . $book_english[$book] . "(" . $book_en[$book] . "," . $book_short[$book] . ")" . "</p>";


if($index)
{
		$sql = "SELECT bible_books.* ";
		
		$book_count = 0;
		foreach ($bible_books as $bible_book) {
			if($bible_book)
			{
				$sql .= ", $bible_book.Scripture as text_$bible_book ";
				$book_count ++;
				if($book_count > $max_book_count){
						$echo_string .= "<h2>选择查询的圣经译本超出<b> $max_book_count </b>个，请缩减同时查询的译本个数以降低服务器开销</h2>";
						break;
				}
			}
		}
		
		$sql .= " FROM bible_books ";
		
		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= ", bible_book_$bible_book as $bible_book";
		}
			
		$sql .= " WHERE (1=1 "; 
		
		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= " AND (bible_books.book=$bible_book.book AND bible_books.chapter=$bible_book.chapter AND bible_books.verse=$bible_book.verse) ";
		}

		$sql .= " ) AND ( 1=0 "; 
		
		$verses=explode(",",$index);
		$verse_count = count($verses);
		for($i=0; $i< $verse_count; $i++)
		{
			list($verse_book,$verse_chapter,$verse_verse)=explode(":",$verses[$i]);
			//echo $verse_book . "," . $verse_chapter . "," . $verse_verse . "\n";
			$sql = $sql . " OR (bible_books.book=$verse_book AND bible_books.chapter=$verse_chapter AND bible_books.verse=$verse_verse)";
		}
		$sql .= " ) "; 
		
}else{ //not index but search
	if($mode=='QUERY' && !$echo_string || $mode=='READ')
	{
		$sql = "SELECT bible_books.* ";

		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= ", $bible_book.Scripture as text_$bible_book ";
		}
		
		$sql .= " FROM bible_books";
		
		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= ", bible_book_$bible_book as $bible_book ";
		}
			
		$sql .= " WHERE 1=1 "; 
		
		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= " AND (bible_books.book=$bible_book.book AND bible_books.chapter=$bible_book.chapter AND bible_books.verse=$bible_book.verse) ";
		}
	}
	if($chapter)
	{
		//$sql = "SELECT * FROM bible_books WHERE  book = $book AND chapter=$chapter";
		$sql .= " AND  bible_books.book = $book AND bible_books.chapter=$chapter";
		if($verse)
			if($verse2)
				$sql = $sql . " AND bible_books.verse >= $verse AND bible_books.verse <=$verse2";
			else
				$sql = $sql . " AND bible_books.verse >= $verse - 3 AND bible_books.verse <=$verse + 3";
		
	}
}
if(!$index)
		$sql = $sql . " ORDER BY bible_books.book,bible_books.chapter,bible_books.verse";
	//echo "book=$book<br/>\n";
	//echo $sql;
	//exit;
if($index || !$echo_string)
{	
	$result = mysqli_query($db, $sql ) or die(" $sql Could not execute query.".mysqli_error($db));
	//$result = $db->getData( $sql );

	//echo $result;
	//$line=0;
	// $text_cmp = "<div id=words>";
	// $text_tw = "<div id=words>";
	// $text_cn = "<div id=words>";
	// $text_en = "<div id=words>";
	if(!$index)
	{
		$text_tw = $txt_tw . "<b>" . $book_taiwan[$book] . " (" . $book_tw[$book] . ") " . $chapter . "</b>\n";
		$text_cn = $txt_cn . "<b>" . $book_chinese[$book] . " (" . $book_cn[$book] . ") " . $chapter . "</b>\n";
		$text_en = $txt_en . "<b>" . $book_english[$book] . " (" . $book_en[$book] . ") " . $chapter . "</b>\n";
		//$text_py = $txt_py . "<b>" . $book_english[$book] . " (" . $book_en[$book] . ") " . $chapter . "</b>\n";
	}
    $wiki_text = "<p>&nbsp;</p> ==" . $book_chinese[$book] . " " . $chapter . "目录==<p>&nbsp;</p>\n";
	$verse_number = 0;
	//$text_cmp .= "<table border=0>";
	while($row = mysqli_fetch_assoc($result)) {
	//foreach($result as $row){
		$bid=$row['book'];
		$cid=$row['chapter'];
		$vid = $row['verse'];
		$likes=$row['likes'];
		$txt_tw = $row['txt_tw'] ?? '';
		$txt_cn = $row['txt_cn'] ?? '';
		$txt_en = $row['txt_en'] ?? '';
		
		// Process HTML tags in verse text if Strong's is enabled
		if($strongs && $strongs !== '') {
			// Process formatting tags first (before Strong's codes)
			// Red letter (words of Christ) - <FR>...</Fr>
			$search_str = array('<FR>','<Fr>');
			$replace_str = array('<span style="color:red;">','</span>');
			$txt_tw = str_replace($search_str, $replace_str, $txt_tw);
			$txt_cn = str_replace($search_str, $replace_str, $txt_cn);
			$txt_en = str_replace($search_str, $replace_str, $txt_en);
			
			// Orange letter (words of angels/divine speech) - <FO>...</Fo>
			$search_str = array('<FO>','<Fo>');
			$replace_str = array('<span style="color:orange;">','</span>');
			$txt_tw = str_replace($search_str, $replace_str, $txt_tw);
			$txt_cn = str_replace($search_str, $replace_str, $txt_cn);
			$txt_en = str_replace($search_str, $replace_str, $txt_en);
			
			// Italics (supplied words) - <FI>...</Fi>
			$txt_tw = str_replace(array('<FI>', '<Fi>'), array('<i>', '</i>'), $txt_tw);
			$txt_cn = str_replace(array('<FI>', '<Fi>'), array('<i>', '</i>'), $txt_cn);
			$txt_en = str_replace(array('<FI>', '<Fi>'), array('<i>', '</i>'), $txt_en);
			
			// Process Strong's codes - tags appear AFTER the word they reference
			// Pattern: word<WHxxxx> becomes word (<a href="...">Hxxxx</a>)
			// Hebrew: <WHxxxx> where xxxx is 1-8674 (Old Testament)
			// Greek: <WGxxxx> where xxxx is 1-5624 (New Testament)
			
			// Process <WG...> format (Greek, long form) - add Strong's code in parentheses as link
			// Matches word<WG1> through word<WG5624> (Greek Strong's numbers)
			// Replaces with: word (<a href="...">Gxxxx</a>)
			$pattern = '/([^\s<>]+)<WG(\d{1,4})>/i';
			$replacement = '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}</a>)';
			$txt_tw = preg_replace($pattern, $replacement, $txt_tw);
			$txt_cn = preg_replace($pattern, $replacement, $txt_cn);
			$txt_en = preg_replace($pattern, $replacement, $txt_en);
			
			// Process <WH...> format (Hebrew, long form) - add Strong's code in parentheses as link
			// Matches word<WH1> through word<WH8674> (Hebrew Strong's numbers)
			// Replaces with: word (<a href="...">Hxxxx</a>)
			$pattern = '/([^\s<>]+)<WH(\d{1,4})>/i';
			$replacement = '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}</a>)';
			$txt_tw = preg_replace($pattern, $replacement, $txt_tw);
			$txt_cn = preg_replace($pattern, $replacement, $txt_cn);
			$txt_en = preg_replace($pattern, $replacement, $txt_en);
			
			// Process <G...> format (Greek, short form) - add Strong's code in parentheses as link
			// Matches word<G1> through word<G5624> (Greek Strong's numbers)
			// Replaces with: word (<a href="...">Gxxxx</a>)
			$pattern = '/(?<!>)([^\s<>]+)<G(\d{1,4})>/i';
			$replacement = '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}</a>)';
			$txt_tw = preg_replace($pattern, $replacement, $txt_tw);
			$txt_cn = preg_replace($pattern, $replacement, $txt_cn);
			$txt_en = preg_replace($pattern, $replacement, $txt_en);
			
			// Process <H...> format (Hebrew, short form) - add Strong's code in parentheses as link
			// Matches word<H1> through word<H8674> (Hebrew Strong's numbers)
			// Replaces with: word (<a href="...">Hxxxx</a>)
			$pattern = '/(?<!>)([^\s<>]+)<H(\d{1,4})>/i';
			$replacement = '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}</a>)';
			$txt_tw = preg_replace($pattern, $replacement, $txt_tw);
			$txt_cn = preg_replace($pattern, $replacement, $txt_cn);
			$txt_en = preg_replace($pattern, $replacement, $txt_en);
			
			// Italics are already processed above
			
			// Fix font color attributes (replace backticks with quotes, add quotes if missing)
			// First, replace backticks with quotes in font color attributes
			$txt_tw = str_replace('color=`', 'color="', $txt_tw);
			$txt_cn = str_replace('color=`', 'color="', $txt_cn);
			$txt_en = str_replace('color=`', 'color="', $txt_en);
			$txt_tw = str_replace('`>', '">', $txt_tw);
			$txt_cn = str_replace('`>', '">', $txt_cn);
			$txt_en = str_replace('`>', '">', $txt_en);
			// Then, add quotes to unquoted font color attributes
			$txt_tw = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $txt_tw);
			$txt_cn = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $txt_cn);
			$txt_en = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $txt_en);
		}
		
		foreach ($queries as $query_word){
			if(empty($query_word)) continue;
			/*
			$pattern = "/($query_word)/";
			$replacement = "<strong>${1}</strong>";
			$txt_tw= preg_replace($pattern, $replacement, $txt_tw);
			$txt_cn= preg_replace($pattern, $replacement, $txt_cn);
			$txt_en= preg_replace($pattern, $replacement, $txt_en);
			*/
			$txt_tw= str_replace($query_word, "<strong>" . $query_word . "</strong>", $txt_tw);
			$txt_cn= str_replace($query_word, "<strong>" . $query_word . "</strong>", $txt_cn);
			$txt_en= str_ireplace($query_word, "<strong>" . $query_word . "</strong>", $txt_en);
			
		}
		
		// Remove empty strong tags that might have been created (multiple patterns)
		$txt_tw = preg_replace('/<strong>\s*<\/strong>/i', '', $txt_tw);
		$txt_cn = preg_replace('/<strong>\s*<\/strong>/i', '', $txt_cn);
		$txt_en = preg_replace('/<strong>\s*<\/strong>/i', '', $txt_en);
		//$txt_py = $row['txt_py'];
		if($vid == $verse && ($mode=='READ' || $mode=='INDEX'))
		{
			// Only wrap in strong tags if text is not empty
			if(trim($txt_tw) !== '') {
				$txt_tw = "<strong>" . $txt_tw . "</strong>";
			}
			if(trim($txt_cn) !== '') {
				$txt_cn = "<strong>" . $txt_cn . "</strong>";
			}
			if(trim($txt_en) !== '') {
				$txt_en = "<strong>" . $txt_en . "</strong>";
			}
			//$txt_py = "<strong>" . $txt_py . "</strong>";
		}
//		$book_short = $row['short'];
		$osis_cn = $book_cn[$bid] . " " . $cid;
		$osis=$book_short[$bid] . "." . $cid;
		if($vid){
			$osis = $osis . "." . $vid;
			$osis_cn = $osis_cn . ":" .$vid;
		}
		/*
		
		need further work
		*/
		if($portable)
		{
			$text_tw = $text_tw . " <sup>" . $book_tw[$bid] . " " . $cid . ":" . $vid . "</sup> " .  $txt_tw . "\n"; 
			$text_cn = $text_cn . " <sup>" . $book_cn[$bid] . " " .$cid . ":" . $vid . "</sup> " .  $txt_cn . "\n";
			$text_en = $text_en . " <sup>" . $book_short[$bid] . " " . $cid . ":" . $vid . "</sup> " .  $txt_en . "\n";
			//$text_py = $text_py . " <sup>" . $book_short[$bid] . " " . $cid . ":" . $vid . "</sup> " .  $txt_py . "\n";
		
		}else if($short_url_base)
		{
			$text_tw = $text_tw . " <sup><a href=\"$short_url_base/" . $osis . ".htm\">" . $book_tw[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_tw . "\n"; 
			$text_cn = $text_cn . " <sup><a href=\"$short_url_base/" . $osis . ".htm\">" . $book_cn[$bid] . " " .$cid . ":" . $vid . "</a></sup> " .  $txt_cn . "\n";
			$text_en = $text_en . " <sup><a href=\"$short_url_base/" . $osis . ".htm\">" . $book_short[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_en . "\n";
			//$text_py = $text_py . " <sup><a href=\"Bible." . $osis . "\">" . $book_short[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_py . "\n";
		}else{
			$text_tw = $text_tw . " <sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\">" . $book_tw[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_tw . "\n"; 
			$text_cn = $text_cn . " <sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\">" . $book_cn[$bid] . " " .$cid . ":" . $vid . "</a></sup> " .  $txt_cn . "\n";
			$text_en = $text_en . " <sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\">" . $book_short[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_en . "\n";
			//$text_py = $text_py . " <sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\">" . $book_short[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_py . "\n";
		}
		if($verse_number %2)
			$background= " class=light";
		else
			$background= " class=dark";
		$text_cmp .= "<table border=0 width=100%><tr><td $background>";
		
		if($cn){
		
		$text_cmp = $text_cmp . "<p>\n";
		
		$cv= $book_cn[$bid] . " " . $cid . ":" . $vid;
		if($portable)
		{
			$text_cmp =  $text_cmp . "<sup>" . $cv .  "</sup> ";
		}
		else if($short_url_base)
		{
			$text_cmp = $text_cmp .  "<sup><a href=\"$short_url_base/" . $osis . ".htm\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_chinese[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}
		else{
		
			$text_cmp = $text_cmp .  "<sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_chinese[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}

		
		// Only output if text is not empty
		if(trim($txt_cn) !== '') {
			$text_cmp = $text_cmp .  $txt_cn . " (CUVS)";
		}
	
		$text_cmp = $text_cmp .  "</p>\n";
		}
		if($tw){
			
		$text_cmp = $text_cmp . "<p>\n";

		$cv= $book_tw[$bid] . " " . $cid . ":" . $vid;
		if($portable)
		{
			$text_cmp =  $text_cmp . "<sup>" . $cv .  "</sup> ";
		}
		else if($short_url_base)
		{
			$text_cmp = $text_cmp .  "<sup><a href=\"$short_url_base/" . $osis . ".htm\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_taiwan[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}
		else{
		
			$text_cmp = $text_cmp .  "<sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_taiwan[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}

		
		// Only output if text is not empty
		if(trim($txt_tw) !== '') {
			$text_cmp = $text_cmp .  $txt_tw . " (CUVT)";
		}
	
		$text_cmp = $text_cmp .  "</p>\n";
		}

/*
		//for pinyin
		$text_cmp = $text_cmp . "<p>\n";
		$text_cmp = $text_cmp .  "<sup><a href=\"Bible." . $osis . "\"";
		$text_cmp = $text_cmp .   " title=\"" .  $book_english[$bid] . " " . $cid . ":" . $vid .  "\">";
		$cv= $book_en[$bid] . " " . $cid . ":" . $vid;
		$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		$text_cmp = $text_cmp .  $txt_py;		
		$text_cmp = $text_cmp .  "</p>\n";
		
*/		
	
		if($en){
		$text_cmp = $text_cmp . "<p>\n";

		
		$cv= $book_en[$bid] . " " . $cid . ":" . $vid;
		if($portable)
		{
			$text_cmp =  $text_cmp . "<sup>" . $cv .  "</sup> ";
		}
		else if($short_url_base)
		{
			$text_cmp = $text_cmp .  "<sup><a href=\"$short_url_base/" . $osis . ".htm\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_english[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}
		else{
		
			$text_cmp = $text_cmp .  "<sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_english[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}

		// Only output if text is not empty
		if(trim($txt_en) !== '') {
			$text_cmp = $text_cmp .  $txt_en . " (KJV)";
		}
		$text_cmp = $text_cmp .  "</p>\n";
		
		}
		$text_cmp .= "<ul>\n";
		foreach ($bible_books as $bible_book) {
				if($bible_book)
				{
					$text_string= $row["text_$bible_book"] ?? '';
					if($strongs && ( $bible_book == "cuvs" || $bible_book=="cuvt" || $bible_book == "kjv" || $bible_book == "nasb")){
							// Process formatting tags first
							// Red letter (words of Christ) - <FR>...</Fr>
							$search_str = array('<FR>','<Fr>');
							$replace_str = array('<span style="color:red;">','</span>');
							$text_string  = str_replace($search_str, $replace_str, $text_string);
							
							// Orange letter (words of angels/divine speech) - <FO>...</Fo>
							$search_str = array('<FO>','<Fo>');
							$replace_str = array('<span style="color:orange;">','</span>');
							$text_string  = str_replace($search_str, $replace_str, $text_string);
							
							// Italics (supplied words) - <FI>...</Fi>
							$text_string = str_replace(array('<FI>', '<Fi>'), array('<i>', '</i>'), $text_string);
							
							// Process Strong's codes - tags appear AFTER the word they reference
							// Pattern: word<WHxxxx> becomes word (<a href="...">Hxxxx</a>)
							// Hebrew: <WHxxxx> where xxxx is 1-8674 (Old Testament)
							// Greek: <WGxxxx> where xxxx is 1-5624 (New Testament)
							
							// Process <WG...> format (Greek, long form) - add Strong's code in parentheses as link
							// Matches word<WG1> through word<WG5624> (Greek Strong's numbers)
							// Replaces with: word (<a href="...">Gxxxx</a>)
							$pattern = '/([^\s<>]+)<WG(\d{1,4})>/i';
							$replacement = '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}</a>)';
							$text_string= preg_replace($pattern, $replacement, $text_string);
							
							// Process <WH...> format (Hebrew, long form) - add Strong's code in parentheses as link
							// Matches word<WH1> through word<WH8674> (Hebrew Strong's numbers)
							// Replaces with: word (<a href="...">Hxxxx</a>)
							$pattern = '/([^\s<>]+)<WH(\d{1,4})>/i';
							$replacement = '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}</a>)';
							$text_string= preg_replace($pattern, $replacement, $text_string);
							
							// Process <G...> format (Greek, short form) - add Strong's code in parentheses as link
							// Matches word<G1> through word<G5624> (Greek Strong's numbers)
							// Replaces with: word (<a href="...">Gxxxx</a>)
							$pattern = '/(?<!>)([^\s<>]+)<G(\d{1,4})>/i';
							$replacement = '${1} (<a href="http://bible.fhl.net/new/s.php?N=0&k=${2}" target="_blank">G${2}</a>)';
							$text_string= preg_replace($pattern, $replacement, $text_string);
							
							// Process <H...> format (Hebrew, short form) - add Strong's code in parentheses as link
							// Matches word<H1> through word<H8674> (Hebrew Strong's numbers)
							// Replaces with: word (<a href="...">Hxxxx</a>)
							$pattern = '/(?<!>)([^\s<>]+)<H(\d{1,4})>/i';
							$replacement = '${1} (<a href="http://bible.fhl.net/new/s.php?N=1&k=${2}" target="_blank">H${2}</a>)';
							$text_string= preg_replace($pattern, $replacement, $text_string);
							
							// Italics are already processed above
							
							// Fix font color attributes (replace backticks with quotes, add quotes if missing)
							// First, replace backticks with quotes in font color attributes
							$text_string = str_replace('color=`', 'color="', $text_string);
							$text_string = str_replace('`>', '">', $text_string);
							// Then, add quotes to unquoted font color attributes
							$text_string = preg_replace('/<font color=([^>\s"`]+)>/i', '<font color="$1">', $text_string);
							
							// Remove empty strong tags (with optional whitespace)
							$text_string = preg_replace('/<strong>\s*<\/strong>/i', '', $text_string);
							
						}
					$text_cmp .= "\n<li><p>" . $text_string . "<b>(" . strtoupper($bible_book) . ")</b></p></li>\n";
				}
		}
		$text_cmp .= "</ul>\n";

/*
		$key = "3208dfea819fa015";
//			 $key= "IP";
			  //$passage = urlencode("john 3:16");
			  //$options = "include-passage-references=true&include-passage-horizontal-line=false&include-footnotes=true&include-heading-horizontal-lines=false&include-headings=false&include-subheadings=true&include-surrounding-chapters=false&include-word-ids=true";
		$options = "include-passage-references=false&include-passage-horizontal-line=false&include-footnotes=false&include-heading-horizontal-lines=false&include-headings=false&include-subheadings=false&include-surrounding-chapters=false&include-word-ids=true";			  
			  //$url = "http://www.esvapi.org/v2/rest/passageQuery?key=$key&passage=$passage&$options";
			 $url="http://www.esvapi.org/v2/rest/passageQuery?key=$key&$options&q=" . $book_en[$bid] . "+" . $cid . "+" . $vid; 
			  $ch = curl_init($url); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			  $response = curl_exec($ch);
			  curl_close($ch);
			 $text_cmp = $text_cmp . "<P>" . $response . "</p>\n";
*/
			
		
		/*
		$text_com = $text_cmp . " <p><small><a href=\"Bible." . $osis . "\"";
		$text_cmp = $text_cmp .   " title=\"" .  $book_english[$bid] . " " . $cid . ":" . $vid .  "\">";
		$text_cmp = $text_cmp .   $book_short[$bid] . " " . $cid . ":" . $vid .  "</a></small>";
		*/
	if(!$portable){
		$quick_link_text = "直达 Quick Link: ";
		$text_cmp = $text_cmp .  "<p>本节研经资料 Bible Study ";
		$text_cmp .= "<select name=\"$osis\" onchange=\"javascript:handleSelect(this)\">\n<option value=\"\">请选择 Please Select</option>\n";
		//$text_cmp = $text_cmp .  " <a href=\"http://www.blueletterbible.org/Bible.cfm?b=" . $book_en[$bid] . "&c=$cid&v=$vid\" target=_blank>BlueLetter</a> | \n";
		$option_url = "http://www.blueletterbible.org/Bible.cfm?b=" . $book_en[$bid] . "&c=$cid&v=$vid";
		$option_name = "Blue Letter Bible";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		
		//$text_cmp = $text_cmp .  " <a href=\"http://www.yawill.com/modonline.php?book=$bid&chapter=$cid&node=$vid\" target=_blank>多版本对照</a>\n | ";

		$option_url = "http://www.yawill.com/modonline.php?book=$bid&chapter=$cid&node=$vid";
		$option_name = "Yawill.com多版本对照";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		
		//$text_cmp = $text_cmp .  " <a href=\"http://bible.cc/" . $book_english[$bid] . "/$cid-$vid.htm" . "\" target=_blank>Parallel Bible</a>\n | ";
		//$option_url = "http://bible.cc/" . $book_english[$bid] . "/$cid-$vid.htm";
		//$option_name = "Bible.cc Parallel Bible";
		//$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";

		
		//$text_cmp = $text_cmp .  "<a href=\"http://bible.fhl.net/new/read.php?VERSION1=unv&strongflag=2&TABFLAG=1&chineses=" . $book_tw[$bid] . "&chap=$cid&sec=$vid&VERSION2=kjv\" target=_blank>信望爱原文和词典</a> | \n";
		$option_url = "http://bible.fhl.net/new/read.php?VERSION1=unv&strongflag=2&TABFLAG=1&chineses=" . $book_tw[$bid] . "&chap=$cid&sec=$vid&VERSION2=kjv";
		$option_name = "原文词典";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=$option_url target=_blank>$option_name</a>&nbsp; ";
		
//		$text_cmp = $text_cmp .  "<a href=\"http://jidutu-wiki.org/wiki/圣经:" . $osis_cn . "\" target=_blank>百科网研经</a>\n";
//		$text_cmp = $text_cmp .  "<a href=\"http://jidutu-wiki.org/wiki/Bible:" . $osis . "\" target=_blank>(OSIS)</a>\n";
//		$text_cmp = $text_cmp .  "<a href=\"http://ccwiki.org/wiki/圣经:" . $osis_cn . "\" target=_blank>CCWIKI研经</a>\n";
//		$text_cmp = $text_cmp .  "<a href=\"http://ccwiki.org/wiki/Bible:" . $osis . "\" target=_blank>(OSIS)</a>\n";

		//$text_cmp = $text_cmp .  "<a href=\"/wiki/Bible:" . $osis_cn . "\" target=_blank>圣经百科</a>\n";
		////$text_cmp = $text_cmp .  "<!-- <a href=\"/wiki/Bible:" . $osis . "\" target=_blank>(OSIS)</a> -->| \n";
		$option_url = "$wiki_base/圣经:" . $book_chinese[$bid] . " " . $cid . ":" . $vid; //$osis_cn;
		$option_name = "圣经百科";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=\"$option_url\" target=_blank>$option_name</a>&nbsp; ";
		
		//$text_cmp = $text_cmp .  "<a href=\"/wiki/MHC:" . $book_chinese[$bid] . " " . $cid . "\" target=_blank title=\"亨利马太圣经注释\">MHC</a> <!-- (<a href=\"/wiki/MHC:" . $osis_cn . "\" target=_blank>中</a>\n";
		//$text_cmp = $text_cmp .  "<a href=\"/wiki/MHC:" . $osis . "\" target=_blank>英</a>) -->|\n";
		$option_url = "$wiki_base/MHC:" . $book_chinese[$bid] . " " . $cid;
		$option_name = "圣经注释";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=\"$option_url\" target=_blank>$option_name</a>&nbsp; ";
		
		

		//$text_cmp = $text_cmp .  "<a href=\"/wiki/MHCC:" . $book_chinese[$bid] . " " . $cid  .  "\" target=_blank title=\"亨利马太简明圣经注释\">MHCC</a> <!--(<a href=\"/wiki/MHCC:" . $osis_cn . "\" target=_blank>中</a>\n";
		//$text_cmp = $text_cmp .  "<a href=\"/wiki/MHCC:" . $osis . "\" target=_blank>英</a>) -->|\n";
		$option_url = "$wiki_base/MHCC:" . $book_chinese[$bid] . " " . $cid;
		$option_name = "MHCC 亨利马太简明圣经注释";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";


		//$text_cmp = $text_cmp .  "<a href=\"https://www.51zanmei.net/bibleindex-$bid-$cid\" target=_blank>赞美圣经</a> |\n";
		$option_url = "https://www.51zanmei.net/bibleindex-$bid-$cid.html";
		$option_name = "51zanmei.net 赞美圣经";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		
		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.almega.com.hk/bible/bible.asp?langid=1&BibleID=NCB&Site=wbs&BCVNo=". sprintf("%d%03d%03d", $bid, $cid, $vid) . "\" target=_blank>新译本</a>\n";
		$option_url = "http://www.almega.com.hk/bible/bible.asp?langid=1&BibleID=NCB&Site=wbs&BCVNo=". sprintf("%d%03d%03d", $bid, $cid, $vid);
		$option_name = "Chinese New Version 简体新译本";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.almega.com.hk/bible/bible.asp?langid=0&BibleID=NCB&Site=wbs&BCVNo=". sprintf("%d%03d%03d", $bid, $cid, $vid) . "\" target=_blank>(正體)</a>\n | ";
		$option_url = "http://www.almega.com.hk/bible/bible.asp?langid=0&BibleID=NCB&Site=wbs&BCVNo=". sprintf("%d%03d%03d", $bid, $cid, $vid);
		$option_name = "Chinese New Version 繁體新譯本";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
			
		//$text_cmp = $text_cmp .  "<a href=\"http://www.dbsbible.org/ct50/Bible/LZZ/gb/" . strtolower($book_en3[$bid]) . "/" . $cid . ".htm\">吕振中译本(LZZ)</a> |\n";
		$option_url = "http://www.dbsbible.org/ct50/Bible/LZZ/gb/" . strtolower($book_en3[$bid]) . "/" . $cid . ".htm";
		$option_name = "吕振中译本(LZZ)";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
	
		//$text_cmp = $text_cmp .  "<a href=\"http://www.esvapi.org/v2/rest/passageQuery?key=IP&q=" . $book_en[$bid] . "+" . $cid . "+" . $vid . "\" target=_blank>ESVAPI</a> \n";
		//$text_cmp = $text_cmp .  "(<a href=\"http://www.esvapi.org/v2/rest/passageQuery?key=IP&q=" . $book_en[$bid] . "+" . $cid . "\" target=_blank>Chapter</a>) | \n";

		

		//$text_cmp = $text_cmp .  "<a href=\"http://www.esvbible.org/search/" . $book_en[$bid] . "+" . $cid . ":" . $vid . "\" target=_blank>ESVBible</a> \n";
		$option_url = "http://www.esvbible.org/search/" . $book_en[$bid] . "+" . $cid . ":" . $vid;
		$option_name = "ESV Bible";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
	
		
		//$text_cmp = $text_cmp .  "(<a href=\"http://www.esvbible.org/search/" . $book_en[$bid] . "+" . $cid . "\" target=_blank>Chapter</a>) | \n";
		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.biblegateway.com/passage/?version=ESV&search=" .  $book_en[$bid] . "+" . $cid . ":" . $vid . "\" target=_blank>BibleGateway</a> | \n";
		$option_url = "http://www.biblegateway.com/passage/?version=ESV&search=" .  $book_en[$bid] . "+" . $cid . ":" . $vid;
		$option_name = "Bible Gateway";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";

		//$text_cmp = $text_cmp .  "<a href=\"http://biblia.com/books/esv/" .  $book_en[$bid] . "" . $cid . "." . $vid . "\" target=_blank>Biblia</a> | \n";
		$option_url = "http://biblia.com/books/esv/" .  $book_en[$bid] . "" . $cid . "." . $vid;
		$option_name = "Biblia";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";

		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.bible.is/ENGESV/" .  $book_short[$bid] . "/" . $cid  . "\" target=_blank>圣经朗读</a> | \n";
		$option_url = "http://www.bible.is/CHNUN1/" .  $book_short[$bid] . "/" . $cid;
		$option_name = "圣经朗读";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=$option_url target=_blank>$option_name</a>&nbsp; ";
		//$text_cmp = $text_cmp .  "<a href=\"http://www.youversion.com/zh-CN/bible/" .  $book_short[$bid] . "." . $cid  . "." . $vid  . ".cunpss\" target=_blank>优训读经</a>\n";
		$option_url = "https://www.youversion.com/zh-CN/bible/" .  $book_short[$bid] . "." . $cid  . "." . $vid  . ".cunpss";
		$option_name = "优训读经";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=$option_url target=_blank>$option_name</a>&nbsp; ";
		//$text_cmp = $text_cmp .  "(<a href=\"http://www.youversion.com/zh-CN/bible/" .  $book_short[$bid] . "." . $cid  . "." . $vid  . ".cnvs\" target=_blank>新译本</a> | \n";
		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.youversion.com/zh-CN/bible/" .  $book_short[$bid] . "." . $cid  . "." . $vid . ".esv\" target=_blank>ESV</a>)\n";
				
		//$text_cmp = $text_cmp .  "<a href=\"http://api.preachingcentral.com/bible.php?passage=" . $book_short[$bid] . "" . $cid . ":" . $vid . "&version=chinese-ncv-simplifi\" target=_blank>新译本</a> | \n";

	
	if($verse==$vid)
		{
			  /*
			 $url="http://api.preachingcentral.com/bible.php?passage=" . $book_short[$bid] . "" . $cid . ":" . $vid . "&version=chinese-ncv-simplifi";
			  $ch = curl_init($url); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			  $response = curl_exec($ch);
			  curl_close($ch);
			 $text_cmp = $text_cmp . "<p>&nbsp;</p><P>" . $response . "(新译本 CNVS)</p>\n";
			 
			 $url="http://api.preachingcentral.com/bible.php?passage=" . $book_short[$bid] . "" . $cid . ":" . $vid . "&version=chinese-ncv-traditio";
			  $ch = curl_init($url); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			  $response = curl_exec($ch);
			  curl_close($ch);
			 $text_cmp = $text_cmp . "<P>" . $response . "(新譯本 CNV)</p><p>&nbsp;</p>\n";
			*/
			
			/*
			 $key = "3208dfea819fa015";
			 $key= "IP";
			  $passage = urlencode("john 3:16");
			  $options = "include-passage-references=true&include-passage-horizontal-line=false&include-footnotes=true&include-heading-horizontal-lines=false&include-headings=false&include-subheadings=true&include-surrounding-chapters=false&include-word-ids=true";
			  //$url = "http://www.esvapi.org/v2/rest/passageQuery?key=$key&passage=$passage&$options";
			  $url="http://www.esvapi.org/v2/rest/passageQuery?key=$key&$options&q=" . $book_en[$bid] . "+" . $cid . "+" . $vid; 
			  $ch = curl_init($url); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			  $response = curl_exec($ch);
			  curl_close($ch);
			 $text_cmp = $text_cmp . "<P>" . $response . "</p>\n";
			 */
		
			 
		}
		$text_cmp = $text_cmp . "</select>";
		$text_cmp .= $quick_link_text;
		$reported = $row['reported'];
		$likes = (int)$row['likes'];
		$text_cmp = $text_cmp .  " <small><a href=\"bible.php?cmd=like&b=$bid&c=$cid&v=$vid\"><img src='like.png' width=14 height=14 border=0 alt = Like/>喜爱本节 Like the Verse</a>"; 
		//$text_cmp .= "<wb:like type=\"text\"></wb:like>";
		if($likes>0)
			$text_cmp = $text_cmp . " ($likes)\n";
		$text_cmp .= "</small>";
			/*
		if($reported)
			$text_cmp = $text_cmp .  "<small><font color=red> " . $reported . "报错 Report </font></small>\n";
		else
			$text_cmp = $text_cmp .  " <small><a href=\"bible.php?cmd=report&b=$bid&c=$cid&v=$vid\" target=_blank title=\"报告这节经文电子版有错误\" onclick=\"return confirm('您确定这节经文电子版有错误且要提交错误报告？')\">报错</a></small>\n";
		$text_cmp = $text_cmp .  "<small>更新 Updated " . $row['updated'] . "</small>\n";
			
		//echo "</span>\n";
		$text_cmp = $text_cmp .  "]</p>\n";
		*/
	
		$text_cmp .= "</p>\n";
	}//portable
			$text_cmp .=  "</td></tr></table>";

	    $wiki_text = $wiki_text . "<p>[[MHC:" . $book_chinese[$bid] . " " . $cid . ":" . $vid . " | " . $book_chinese[$bid] . " " . $cid . ":" . $vid .  "]]</p>\n";
		$verse_number ++;
		if(!$chapter && !($verse_number % 5 ) )
		{
			$text_cmp = $text_cmp .  " <p>&nbsp; </p></div>\n ";
			$wiki_text = $wiki_text . "<p>&nbsp;</p>\n";
		}
		if($chapter && !($verse_number % 10 ) )
		{
			$text_cmp = $text_cmp .  " <p>&nbsp; </p></div>\n ";
			$wiki_text = $wiki_text . "<p>&nbsp;</p>\n";
		}
		
			
	}

	$text_tw = "<p>" . $text_tw . " (繁體和合本 CUVT) </p>";
	$text_cn = "<p>" . $text_cn . " (和合本 CUV) </p>";
	$text_en = "<p>" . $text_en . " (King James Version KJV) </p>";
//$text_py = "<p>" . $text_py . " (Pinyin) </p>";
}

$chapter_menu = "<p>" . $chapter_menu . "</p>";

?>

<?php
if($mode=='QUERY' && ($api == "plain" || $api == "html"))
{
	
		echo $api_response;
		exit();
	
	
}

?>
<?php require_once(__DIR__ . "/../header.php") ?>
<script type="text/javascript"> 
<!--
function FontZoom(size) 
{ var element = document.getElementsByTagName("p"); 
var components = new Array(); for(i = 0, j = 0; i < element.length; i++) 
{ attribute = element 
[i].getAttribute("id"); //if(attribute == "words") 
{ components[j] = element[i]; j++; } } for (i = 0; i < components.length; i++) components[i].style.fontSize = size+'pt'; 
setcookie('fontSize',size);
} 
if(isset($_COOKIE['fontSize']))
  FontZoom($_COOKIE['fontSize']);

function handleSelect(elm)
{
if(elm.value)
	window.location = elm.value;
//newwin=window.open(elm.value, "_blank");
}

function toggleOptions(elm,idx)
{

	var options;
	if(idx)
		options= document.getElementById("options1");
	else
		options= document.getElementById("options0");
	//alert(options);
	if(elm.checked)
	{
		//alert("checked");
		options.style.display = 'inline';
	}else{
		//alert(" not checked");
		options.style.display = 'none';
	}


}
//newwin=window.open(elm.value, "_blank");

-->
</script>
<!--link rel="stylesheet" type="text/css" href="http://www.gnpcb.org/esv/assets/style/text.css" /-->
    <STYLE TYPE="text/css">
.light {
	BACKGROUND-COLOR: #ffffff
}
.dark {
	BACKGROUND-COLOR: #eeeeee
}    </STYLE>

</head>
<body>
<?php require_once(__DIR__ . "/../banner.php") ?>
<center><div align=center>
<!--
  <p><?php echo $title?><a href="http://BibleEngine.com">BibleEngine.com</a>  <br/>
  <a href="<?php echo $long_url_base?>"><?php echo $long_url_base?></a> <a href="<?php echo $short_url_base?>"><?php echo $short_url_base?></a> 
-->  
<!-- (<a href="devel.php">Devel</a> | <a href="alpha.php">Alpha</a>  | <a href="beta.php">Beta</a>  | <a href="legacy.php">Legacy</a>) -->
</div></center>
<?php 
function show_form($seq='0')
{
	global $query, $books, $script, $options, $multi_verse,$portable;
	global $cn, $tw, $en, $strongs;
	global $cuvs, $cuvt, $cuvc, $kjv, $nasb, $esv, $ckjvs, $ckjvt, $pinyin, $ncvs, $lcvs, $ccsb, $ukjv, $kjv1611, $bbe;
	global $wiki_base,$long_url_base,$short_url_base;
?>
<center><div align=center>
<FORM method = "GET" action = "<?php echo $script?>"> 
<?php if($portable) {?>
<input type="text" size="40" maxlength="128" name="q" value="<?php echo $query ?>"> 
<?php }else{ ?>
<input type="text" size="80" maxlength="128" name="q" value="<?php echo $query ?>"> 
<?php } ?>
<input  type="submit" value="研经 STUDY"> 
<?php if($portable) echo "<br/>"?>
<input type='checkbox' name='o' id='<?php echo "o$seq";?>' value='<?php echo "o$seq";?>' <?php if($options) echo 'checked'?> onChange="javascript:toggleOptions(this,<?php echo $seq?>)">选项 Options
<input type='checkbox' name='p' value='1' <?php if($portable) echo 'checked' ?>>便携 Portable
<a href="../help.php"> 帮助 Help</a> 
<small><a href="../copyright.php">版权 Copyright</a></small>
<div id=<?php echo "options$seq"?> style="display:
<?php 
if ($options) echo "inline"; 
else echo "none";
?>
">
<br/>书卷 Books
<select name="b">
<option value=0 <?php if($books==0) echo "SELECTED";?>>整本圣经 Whole Bible</option>
<option value="1-39" <?php if($books=="1-39") echo "SELECTED";?>>旧约全书 Old Testament</option>
<option value="40-66" <?php if($books=="40-66") echo "SELECTED";?>>新约全书 New Testament</option>
<option value="1-5" <?php if($books=="1-5") echo "SELECTED";?>>摩西五经 Law (Gen - Deut)</option>
<option value="6-17" <?php if($books=="6-17") echo "SELECTED";?>>历史书 History (Josh - Esth)</option>
<option value="18-22" <?php if($books=="18-22") echo "SELECTED";?>>诗歌智慧书 Poetry & Wisdom (Job - Song)</option>
<option value="23-27" <?php if($books=="23-27") echo "SELECTED";?>>大先知书 Major Prophets (Is - Dan)</option>
<option value="28-39" <?php if($books=="28-39") echo "SELECTED";?>>小先知书 Minor Prophets (Hos - Mal)</option>
<option value="40-44" <?php if($books=="40-44") echo "SELECTED";?>>福音历史书 Gospels (Matt - Acts)</option>
<option value="45-57" <?php if($books=="45-57") echo "SELECTED";?>>保罗书信 Paul&#39;s Epistles (Rom - Philem)</option>
<option value="58-66" <?php if($books=="58-66") echo "SELECTED";?>>一般使徒书信 General Epistles (Heb - Rev)</option>
<option value=1 <?php if($books=="1") echo "SELECTED";?>>创世记 Genesis</option> 
<option value=2 <?php if($books=="2") echo "SELECTED";?>>出埃及记 Exodus</option> 
<option value=3 <?php if($books=="3") echo "SELECTED";?>>利未记 Leviticus</option> 
<option value=4 <?php if($books=="4") echo "SELECTED";?>>民数记 Numbers</option> 
<option value=5 <?php if($books=="5") echo "SELECTED";?>>申命记 Deuteronomy</option> 
<option value=6 <?php if($books=="6") echo "SELECTED";?>>约书亚记 Joshua</option> 
<option value=7 <?php if($books=="7") echo "SELECTED";?>>士师记 Judges</option> 
<option value=8 <?php if($books=="8") echo "SELECTED";?>>路得记 Ruth</option> 
<option value=9 <?php if($books=="9") echo "SELECTED";?>>撒母耳记上 1 Samuel</option> 
<option value=10 <?php if($books=="10") echo "SELECTED";?>>撒母耳记下 2 Samuel</option> 
<option value=11 <?php if($books=="11") echo "SELECTED";?>>列王记上 1 Kings</option> 
<option value=12 <?php if($books=="12") echo "SELECTED";?>>列王记下 2 Kings</option> 
<option value=13 <?php if($books=="13") echo "SELECTED";?>>历代志上 1 Chronicles</option> 
<option value=14 <?php if($books=="14") echo "SELECTED";?>>历代志下 2 Chronicles</option> 
<option value=15 <?php if($books=="15") echo "SELECTED";?>>以斯拉记 Ezra</option> 
<option value=16 <?php if($books=="16") echo "SELECTED";?>>尼希米记 Nehemiah</option> 
<option value=17 <?php if($books=="17") echo "SELECTED";?>>以斯帖记 Esther</option> 
<option value=18 <?php if($books=="18") echo "SELECTED";?>>约伯记 Job</option> 
<option value=19 <?php if($books=="19") echo "SELECTED";?>>诗篇 Psalms</option> 
<option value=20 <?php if($books=="20") echo "SELECTED";?>>箴言 Proverbs</option> 
<option value=21 <?php if($books=="21") echo "SELECTED";?>>传道书 Ecclesiastes</option> 
<option value=22 <?php if($books=="22") echo "SELECTED";?>>雅歌 Song of Solomon</option> 
<option value=23 <?php if($books=="23") echo "SELECTED";?>>以赛亚书 Isaiah</option> 
<option value=24 <?php if($books=="24") echo "SELECTED";?>>耶利米书 Jeremiah</option> 
<option value=25 <?php if($books=="25") echo "SELECTED";?>>耶利米哀歌 Lamentations</option> 
<option value=26 <?php if($books=="26") echo "SELECTED";?>>以西结书 Ezekiel</option> 
<option value=27 <?php if($books=="27") echo "SELECTED";?>>但以理书 Daniel</option> 
<option value=28 <?php if($books=="28") echo "SELECTED";?>>何西阿书 Hosea</option> 
<option value=29 <?php if($books=="29") echo "SELECTED";?>>约珥书 Joel</option> 
<option value=30 <?php if($books=="30") echo "SELECTED";?>>阿摩司书 Amos</option> 
<option value=31 <?php if($books=="31") echo "SELECTED";?>>俄巴底亚书 Obadiah</option> 
<option value=32 <?php if($books=="32") echo "SELECTED";?>>约拿书 Jonah</option> 
<option value=33 <?php if($books=="33") echo "SELECTED";?>>弥迦书 Micah</option> 
<option value=34 <?php if($books=="34") echo "SELECTED";?>>那鸿书 Nahum</option> 
<option value=35 <?php if($books=="35") echo "SELECTED";?>>哈巴谷书 Habakkuk</option> 
<option value=36 <?php if($books=="36") echo "SELECTED";?>>西番雅书 Zephaniah</option> 
<option value=37 <?php if($books=="37") echo "SELECTED";?>>哈该书 Haggai</option> 
<option value=38 <?php if($books=="38") echo "SELECTED";?>>撒迦利亚书 Zechariah</option> 
<option value=39 <?php if($books=="39") echo "SELECTED";?>>玛拉基书 Malachi</option> 
<option value=40 <?php if($books=="40") echo "SELECTED";?>>马太福音 Matthew</option> 
<option value=41 <?php if($books=="41") echo "SELECTED";?>>马可福音 Mark</option> 
<option value=42 <?php if($books=="42") echo "SELECTED";?>>路加福音 Luke</option> 
<option value=43 <?php if($books=="43") echo "SELECTED";?>>约翰福音 John</option> 
<option value=44 <?php if($books=="44") echo "SELECTED";?>>使徒行传 Acts</option> 
<option value=45 <?php if($books=="45") echo "SELECTED";?>>罗马书 Romans</option> 
<option value=46 <?php if($books=="46") echo "SELECTED";?>>哥林多前书 1 Corinthians</option> 
<option value=47 <?php if($books=="47") echo "SELECTED";?>>哥林多后书 2 Corinthians</option> 
<option value=48 <?php if($books=="48") echo "SELECTED";?>>加拉太书 Galatians</option> 
<option value=49 <?php if($books=="49") echo "SELECTED";?>>以弗所书 Ephesians</option> 
<option value=50 <?php if($books=="50") echo "SELECTED";?>>腓立比书 Philippians</option> 
<option value=51 <?php if($books=="51") echo "SELECTED";?>>歌罗西书 Colossians</option> 
<option value=52 <?php if($books=="52") echo "SELECTED";?>>帖撒罗尼迦前书 1 Thessalonians</option> 
<option value=53 <?php if($books=="53") echo "SELECTED";?>>帖撒罗尼迦后书 2 Thessalonians</option> 
<option value=54 <?php if($books=="54") echo "SELECTED";?>>提摩太前书 1 Timothy</option> 
<option value=55 <?php if($books=="55") echo "SELECTED";?>>提摩太后书 2 Timothy</option> 
<option value=56 <?php if($books=="56") echo "SELECTED";?>>提多书 Titus</option> 
<option value=57 <?php if($books=="57") echo "SELECTED";?>>腓利门书 Philemon</option> 
<option value=58 <?php if($books=="58") echo "SELECTED";?>>希伯来书 Hebrews</option> 
<option value=59 <?php if($books=="59") echo "SELECTED";?>>雅各书 James</option> 
<option value=60 <?php if($books=="60") echo "SELECTED";?>>彼得前书 1 Peter</option> 
<option value=61 <?php if($books=="61") echo "SELECTED";?>>彼得后书 2 Peter</option> 
<option value=62 <?php if($books=="62") echo "SELECTED";?>>约翰壹书 1 John</option> 
<option value=63 <?php if($books=="63") echo "SELECTED";?>>约翰贰书 2 John</option> 
<option value=64 <?php if($books=="64") echo "SELECTED";?>>约翰叁书 3 John</option> 
<option value=65 <?php if($books=="65") echo "SELECTED";?>>犹大书 Jude</option> 
<option value=66 <?php if($books=="66") echo "SELECTED";?>>启示录 Revelation</option> 
</select> 
<?php if($portable) echo "<br/>"?>
多 Multi<select name="m">
<option value=0 <?php if($multi_verse==0) echo "SELECTED";?>>1</option>
<option value=2 <?php if($multi_verse==3) echo "SELECTED";?>>3</option>
</select>节 VV
扩展 Ext<select name="e">
<option value=0 <?php if(($extend ?? 1)==0) echo "SELECTED";?>>0</option>
<option value=1 <?php if(!isset($extend) || ($extend ?? 1)==1) echo "SELECTED";?>>1</option>
<option value=2 <?php if(($extend ?? 1)==2) echo "SELECTED";?>>2</option>
<option value=3 <?php if(($extend ?? 1)==3) echo "SELECTED";?>>3</option>
<option value=4 <?php if(($extend ?? 1)==4) echo "SELECTED";?>>4</option>
<option value=5 <?php if(($extend ?? 1)==5) echo "SELECTED";?>>5</option>
</select>节 VV
<input type='checkbox' name='cn' value=1 <?php if($cn) echo 'checked'?>>简CN
<input type='checkbox' name='tw' value=1 <?php if($tw) echo 'checked'?>>繁TW
<input type='checkbox' name='en' value=1 <?php if($en) echo 'checked'?>>英EN
<br/><!--圣经译本 Bible Translations<br/>-->
<input type='checkbox' name='strongs' value='strongs' <?php if($strongs) echo 'checked'?>>带原文编号 W/ Strong's Code*
<input type='checkbox' name='cuvs' value='cuvs' <?php if($cuvs) echo 'checked'?>>简体和合本CUVS*
<input type='checkbox' name='cuvt' value='cuvt' <?php if($cuvt) echo 'checked'?>>繁体和合本CUVT*
<?php if($portable) echo "<br/>"?>
<input type='checkbox' name='kjv' value='kjv' <?php if($kjv) echo 'checked'?>>英王钦定本KJV*
<input type='checkbox' name='nasb' value='nasb' <?php if($nasb) echo 'checked'?>>新美国标准圣经NASB*
<input type='checkbox' name='esv' value='esv' <?php if($esv) echo 'checked'?>>英文标准译本ESV
<br/>
<input type='checkbox' name='cuvc' value='cuvc' <?php if($cuvc) echo 'checked'?>>文理和合CUVC
<input type='checkbox' name='ncvs' value='ncvs' <?php if($ncvs) echo 'checked'?>>新译本NCVS
<input type='checkbox' name='lcvs' value='lcvs' <?php if($cuvs) echo 'checked'?>>吕振中LCVS
<input type='checkbox' name='ccsb' value='ccsb' <?php if($ccsb) echo 'checked'?>>思高本CCSB
<?php if($portable) echo "<br/>"?>
<input type='checkbox' name='clbs' value='clbs' <?php if(isset($clbs) && $clbs) echo 'checked'?>>当代圣经CLBS 
<input type='checkbox' name='ckjvs' value='ckjvs' <?php if($ckjvs) echo 'checked'?>>简体钦定本CKJVS
<input type='checkbox' name='ckjvt' value='ckjvt' <?php if($ckjvt) echo 'checked'?>>繁体钦定本CKJVT
<br/>
<input type='checkbox' name='pinyin' value='pinyin' <?php if($pinyin) echo 'checked'?>>拼音pinyin
<input type='checkbox' name='ukjv' value='ukjv' <?php if($ukjv) echo 'checked'?>>更新钦定UKJV
<input type='checkbox' name='kjv1611' value='kjv1611' <?php if($kjv1611) echo 'checked'?>>1611钦定 KJV1611
<input type='checkbox' name='bbe' value='bbe' <?php if($bbe) echo 'checked'?>>简易英文BBE
<!-- 
<input type='hidden' name='n' value="<?php echo htmlspecialchars($name ?? '') ?>">
<input type='hidden' name='c' value="<?php echo (int)($chapter ?? 0) ?>">
<input type='hidden' name='v' value="<?php echo (int)($verse ?? 0) ?>">
<input type='hidden' name='v2' value="<?php echo (int)($verse2 ?? 0) ?>">
<input type='hidden' name='mode' value="<?php echo htmlspecialchars($mode ?? '') ?>"> -->
</div>
</FORM> 
</div></center>
<?php
} //end of function show_form
?>
<?php
show_form();

if(!$portable)
{
	echo "<p>&nbsp; </p>";
	echo $book_menu;
	echo "<p>&nbsp; </p>";

}
if($wiki)
	echo $wiki_book_menu;
if($book)
{
	if(!$portable)
	{
		echo "<p>&nbsp; </p>";
		echo $chapter_menu;
		echo "<p>&nbsp; </p>";
	}
	if($wiki){
		echo $wiki_chapter_menu;
		if(!$chapter) 
			echo "<p>&nbsp;</p><p>{{Template:MHC:" . $book_chinese[$book] .  "}}</p>";
		echo "<p>{{Template:MHC:圣经}}</p><p>&nbsp;</p>";
	}
}
echo "<div align=center><center>";
?>
<?php

$bid1 = $bid -1;
$cid1 = $cid -1;
	
echo "</div></center>";

if($query && $echo_string)
	echo $echo_string;
?>
<center><div align=center><p>
【<strong>字体大小 FontSize</strong>
<a href="javascript:FontZoom(9)">更小 XS</a>
<a href="javascript:FontZoom(10)">小 S</a>
<a href="javascript:FontZoom(12)">中 M</a>
<a href="javascript:FontZoom(14)">大 L</a>
<a href="javascript:FontZoom(16)">更大 XL</a>】
</p></div></center>
<?php
if(!$show_verse && !$portable)
{
	if($cn){
	echo "<p>&nbsp; </p>";
	echo $text_cn;
	}
	
	if($tw){
	echo "<p>&nbsp;</p>\n";
	echo $text_tw;
	}

	//echo "<p>&nbsp;</p>\n";
	//echo $text_py;
	if($en){
	echo "<p>&nbsp;</p>\n";
	echo $text_en;
	}
/*
	 $url="http://api.preachingcentral.com/bible.php?passage=" . $book_short[$bid] . "" . $cid . "&version=chinese-ncv-simplifi";
	 //echo $url;
  $ch = curl_init($url); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  $response = curl_exec($ch);
   curl_close($ch);
   
	
 echo  "<p>&nbsp;</p><P>" . $response . "(新译本 CNVS)</p>\n";
*/
	
	/*
	 $key = "3208dfea819fa015";
	 //$key="IP";
	  //$passage = urlencode("john 3:16");
	  $options = "include-passage-references=true&include-passage-horizontal-line=false&include-footnotes=true&include-heading-horizontal-lines=false&include-headings=false&include-subheadings=true&include-surrounding-chapters=false&include-word-ids=true";
	  //$url = "http://www.esvapi.org/v2/rest/passageQuery?key=$key&passage=$passage&$options";
	  $url="http://www.esvapi.org/v2/rest/passageQuery?key=$key&$options&passage=" . $book_en[$bid] . "+" . $cid ; 
	  //echo $url;
	  $ch = curl_init($url); 
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	  $response = curl_exec($ch);
	  curl_close($ch);
	  echo "<P>" . $response . "</p>\n";
*/
		//http://www.esvapi.org/v2/rest/passageQuery?key=IP&passage=Gen+1&include-headings=false

		/*
		$key="ljEh2v62cHDn7krd6qKRyTimFp6E6jmhIqFBbB33";
		$url="https://$key:bibles.org/versions/NASB.xml";
	  $ch = curl_init($url); 
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	  $response = curl_exec($ch);
	  curl_close($ch);
	echo  "<p>&nbsp;</p><P>" . $response . "(NASB)</p>\n";

	  //http://www.dbsbible.org/ct50/Bible/LZZ/gb/mat/1.htm

	 $url="http://www.dbsbible.org/ct50/Bible/LZZ/gb/" . strtolower($book_en3[$bid]) . "/" . $cid . ".htm";
	 echo $url;
  $ch = curl_init($url); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  $response = curl_exec($ch);
   curl_close($ch);
   
echo  "<p>&nbsp;</p><P>" . $response . "(呂振中譯本 LZZ)</p>\n";
*/
	echo "<p>&nbsp;</p>\n";
}
else
{
	echo "<p>&nbsp;</p>\n";
	echo $text_cmp;
	echo "<p>&nbsp;</p>\n";
	echo "<p>&nbsp;</p>\n";
	
	
	echo "<p>&nbsp; </p>";
	if($cn)
		echo $text_cn;
	
	echo "<p>&nbsp;</p>\n";
	if($tw)
		echo $text_tw;
	

//	echo "<p>&nbsp;</p>\n";
//	echo $text_py;
	
	echo "<p>&nbsp;</p>\n";
	if($en)
		echo $text_en;

	echo "<p>&nbsp;</p>\n";


}
if($wiki){
	echo $wiki_text;
	if($chapter) 
		echo "<p>&nbsp;</p><p>{{Template:MHC:" . $book_chinese[$book] .  "}}</p>";
	echo "<p>{{Template:MHC:圣经}}</p><p>&nbsp;</p>";
}	
echo "<p>&nbsp; </p>";
if($book && !$portable)
	echo $chapter_menu;
echo "<p>&nbsp; </p>";
if(!$portable)
	echo $book_menu;

echo "<p>&nbsp; </p>";
if(!$portable)
{
	show_form(1);
?>
<p>&nbsp;</p>
<center><div align=center><p>
【<strong>字体大小 FontSize</strong>
<a href="javascript:FontZoom(9)">更小 XS</a>
<a href="javascript:FontZoom(10)">小 S</a>
<a href="javascript:FontZoom(12)">中 M</a>
<a href="javascript:FontZoom(14)">大 L</a>
<a href="javascript:FontZoom(16)">更大 XL</a>】
</p></div></center>
<?php require_once(__DIR__ . "/../footer.php") ?>
<?php
}
else
{
include(__DIR__ . "/../footer_portal.php");
}
?>
</body>
</html>
