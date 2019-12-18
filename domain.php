<?php

/**
 *   type = arr 返回全部
 *   type = host 返回域名
 *   type = tld 返回顶级域名
 *   type = name 返回二级域名
 *   type = root 返回子域名
 */
function getRootDomain($url = '', $type = 'root', $domain_check = false)
{
    if (empty($url)) {
        return $url;
    }
    $url = trim($url);
    //如果不是以http开头的就拼接域名
    if (!preg_match('/^http/i', $url)) {
        $url = 'http://' . $url;
    }
    $arr = [];
    //截取限定字符
    if (preg_match_all('/(^https?:\/\/[\p{Han}a-zA-Z0-9\-\.\/]+)/iu', $url, $arr)) {
        $url = $arr['0']['0'];
        unset($arr);
    }
    $url_parse = parse_url(strtolower($url));
    if (empty($url_parse['host'])) {
        return '';
    }
    //host判断快速返回
    if ($domain_check === false and $type == 'host') {
        return $url_parse['host'];
    }

    //结束数组初始化
    //"https://浙www.cnblogs.com/zjfblog/p/8358860.html";
    $res = array(
        'scheme' => '',   //  https
        'host'   => '',   //  浙www.cnblogs.com        域名
        'path'   => '',   ///  zjfblog/p/8358860.html  uRI
        'name'   => '',   //   cnglogs   二级域名
        'domain' => '',   //   子域名 cnblogs.com
    );

    $urlarr        = explode('.', $url_parse['host']);
    $count         = count($urlarr);
    $res['scheme'] = $url_parse['scheme'];
    $res['host']   = $url_parse['host'];
    if (!empty($url_parse['path'])) {
        $res['path'] = $url_parse['psth'];
    }
    #列举域名中固定元素
    $state_domain = array('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me', 'jp', 'uk', 'ws', 'eu', 'pw', 'kr', 'io', 'us', 'cn', 'al', 'dz', 'af', 'ar', 'ae', 'aw', 'om', 'az', 'eg', 'et', 'ie', 'ee', 'ad', 'ao', 'ai', 'ag', 'at', 'au', 'mo', 'bb', 'pg', 'bs', 'pk', 'py', 'ps', 'bh', 'pa', 'br', 'by', 'bm', 'bg', 'mp', 'bj', 'be', 'is', 'pr', 'ba', 'pl', 'bo', 'bz', 'bw', 'bt', 'bf', 'bi', 'bv', 'kp', 'gq', 'dk', 'de', 'tl', 'tp', 'tg', 'dm', 'do', 'ru', 'ec', 'er', 'fr', 'fo', 'pf', 'gf', 'tf', 'va', 'ph', 'fj', 'fi', 'cv', 'fk', 'gm', 'cg', 'cd', 'co', 'cr', 'gg', 'gd', 'gl', 'ge', 'cu', 'gp', 'gu', 'gy', 'kz', 'ht', 'nl', 'an', 'hm', 'hn', 'ki', 'dj', 'kg', 'gn', 'gw', 'ca', 'gh', 'ga', 'kh', 'cz', 'zw', 'cm', 'qa', 'ky', 'km', 'ci', 'kw', 'hr', 'ke', 'ck', 'lv', 'ls', 'la', 'lb', 'lt', 'lr', 'ly', 'li', 're', 'lu', 'rw', 'ro', 'mg', 'im', 'mv', 'mt', 'mw', 'my', 'ml', 'mk', 'mh', 'mq', 'yt', 'mu', 'mr', 'um', 'as', 'vi', 'mn', 'ms', 'bd', 'pe', 'fm', 'mm', 'md', 'ma', 'mc', 'mz', 'mx', 'nr', 'np', 'ni', 'ne', 'ng', 'nu', 'no', 'nf', 'na', 'za', 'aq', 'gs', 'pn', 'pt', 'se', 'ch', 'sv', 'yu', 'sl', 'sn', 'cy', 'sc', 'sa', 'cx', 'st', 'sh', 'kn', 'lc', 'sm', 'pm', 'vc', 'lk', 'sk', 'si', 'sj', 'sz', 'sd', 'sr', 'sb', 'so', 'tj', 'tw', 'th', 'tz', 'to', 'tc', 'tt', 'tn', 'tv', 'tr', 'tm', 'tk', 'wf', 'vu', 'gt', 've', 'bn', 'ug', 'ua', 'uy', 'uz', 'es', 'eh', 'gr', 'hk', 'sg', 'nc', 'nz', 'hu', 'sy', 'jm', 'am', 'ac', 'ye', 'iq', 'ir', 'il', 'it', 'in', 'id', 'vg', 'jo', 'vn', 'zm', 'je', 'td', 'gi', 'cl', 'cf', 'yr', 'arpa', 'museum', 'asia', 'ax', 'bl', 'bq', 'cat', 'cw', 'gb', 'jobs', 'mf', 'rs', 'su', 'sx', 'tel', 'travel', 'shop', 'ltd', 'store', 'vip', '网店', '中国', '公司', '网络', 'co.il', 'co.nz', 'co.uk', 'me.uk', 'org.uk', 'com.sb', '在线', '中文网', '移动', 'wang', 'club', 'ren', 'top', 'website', 'cool', 'company', 'city', 'email', 'market', 'software', 'ninja', '我爱你', 'bike', 'today', 'life', 'space', 'pub', 'site', 'help', 'link', 'photo', 'video', 'click', 'pics', 'sexy', 'audio', 'gift', 'tech', '网址', 'online', 'win', 'download', 'party', 'bid', 'loan', 'date', 'trade', 'red', 'blue', 'pink', 'poker', 'green', 'farm', 'zone', 'guru', 'tips', 'land', 'care', 'camp', 'cab', 'cash', 'limo', 'toys', 'tax', 'town', 'fish', 'fund', 'fail', 'house', 'shoes', 'media', 'guide', 'tools', 'solar', 'watch', 'cheap', 'rocks', 'news', 'live', 'lawyer', 'host', 'wiki', 'ink', 'design', 'lol', 'hiphop', 'hosting', 'diet', 'flowers', 'car', 'cars', 'auto', 'mom', 'cq', 'he', 'nm', 'ln', 'jl', 'hl', 'js', 'zj', 'ah', 'jx', 'ha', 'hb', 'gx', 'hi', 'gz', 'yn', 'xz', 'qh', 'nx', 'xj', 'xyz', 'xin', 'science', 'press', 'band', 'engineer', 'social', 'studio', 'work', 'game', 'kim', 'games', 'group', '集团');
    if ($count <= 2) {
        #当域名直接根形式不存在host部分直接输出
        $last   = array_pop($urlarr);  // "com"
        $last_1 = array_pop($urlarr);  //  "cnblogs"
        if (in_array($last, $state_domain)) {
            $res['domain'] = $last_1 . '.' . $last;
            $res['name']   = $last_1;
            $res['tld']    = $last;  // com
        }
    } else if ($count > 2) {
        $last          = array_pop($urlarr);
        $last_1        = array_pop($urlarr);
        $last_2        = array_pop($urlarr);
        $res['domain'] = $last_1 . '.' . $last; //默认为n.com形式
        $res['name']   = $last_2;
        //排除非标准 ltd 域名
        if (!in_array($last, $state_domain)) {
            return false;
        }

        if (in_array($last, $state_domain)) {
            $res['domain'] = $last_1 . '.' . $last; //n.com形式
            $res['name']   = $last_1;
            $res['tld']    = $last;
        }
        //排除顶级根二级后缀
        if ($last_1 !== $last and in_array($last_1, $state_domain) and !in_array($last, array('com', 'net', 'org', 'edu', 'gov'))) {
            $res['domain'] = $last_2 . '.' . $last_1 . '.' . $last; //n.n.com形式
            $res['name']   = $last_2;
            $res['tld']    = $last_1 . '.' . $last;
        }
        //限定cn顶级根二级后缀为'com', 'net', 'org', 'edu', 'gov'
        if (in_array($last, array('cn')) and $last_1 !== $last and strlen($last_1) > 2 and !in_array($last_1, array('com', 'net', 'org', 'edu', 'gov'))) {
            $res['domain'] = $last_1 . '.' . $last; //n.n.cn形式
            $res['name']   = $last_1;
            $res['tld']    = $last;
        }
    }
    //检测和验证返回的是不是域名格式
    if (!empty($res['domain']) and preg_match('/^([\p{Han}a-zA-Z0-9])+([\p{Han}a-zA-Z0-9\-])*\.[a-zA-Z\.\p{Han}]+$/iu', $res['domain'])) {
        if ($type == 'arr') {
            return $res;
        } elseif ($type == 'host') {
            return $res['host'];
        } elseif ($type == 'tld') {
            return $res['tld'];
        } elseif ($type == 'subdomain') {
            return $res['name'];
        } else {
            return $res['domain'];
        }
    } else {
        return '';
    }
}
