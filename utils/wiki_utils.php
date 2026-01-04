<?php
/**
 * Wiki search and retrieval utilities
 */

/**
 * Search wiki for content
 * @param string $q Search query
 * @param int $p Page number (default: 1)
 * @return string Wiki content or error message
 */
function search_wiki(string $q, int $p = 1): string {
    global $echo_string, $wiki_base;
    
    if (!function_exists('t')) {
        require_once(__DIR__ . '/../lang.php');
    }
    if (!function_exists('show_hint')) {
        require_once(__DIR__ . '/../common.php');
    }
    if (!function_exists('show_banner')) {
        require_once(__DIR__ . '/../common.php');
    }
    
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

