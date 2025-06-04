<?php
header('Content-Type: application/json');

function getRandomUserAgent() {
    $userAgents = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36',
        'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1'
    ];
    return $userAgents[array_rand($userAgents)];
}

function fetchVideo($url) {
    $videoId = preg_match('/^https:\/\/www\.facebook\.com\/reel\/([0-9]+)/', $url, $matches) ? $matches[1] : $url;
    $videoId = preg_replace('/[^0-9]/', '', $videoId);

    $headers = [
        'User-Agent: ' . getRandomUserAgent(),
        'Referer: https://www.facebook.com/',
        'DNT: 1'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $content = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['success' => false, 'message' => 'Lỗi kết nối: ' . $error];
    }

    if (!$content) {
        return ['success' => false, 'message' => 'Không thể tải nội dung trang.'];
    }

    $doc = new DOMDocument();
    @$doc->loadHTML($content); // Dùng @ để bỏ qua warning về HTML không hợp lệ
    $metas = $doc->getElementsByTagName('meta');

    $videoLink = null;
    foreach ($metas as $meta) {
        if ($meta->getAttribute('property') === 'og:video') {
            $videoLink = $meta->getAttribute('content');
            break;
        }
    }

    if (!$videoLink) {
        return ['success' => false, 'message' => 'Không tìm thấy liên kết video. Đảm bảo video là công khai.'];
    }

    return [
        'success' => true,
        'videoLink' => $videoLink,
        'videoId' => $videoId
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];
    $maxAttempts = 3;
    $currentAttempt = 1;
    $result = null;

    while ($currentAttempt <= $maxAttempts) {
        $result = fetchVideo($url);
        if ($result['success']) {
            break;
        }
        $currentAttempt++;
    }

    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
}
?>