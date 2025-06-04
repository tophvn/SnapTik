<?php
$downloadContent = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = trim($_POST['url']);

    try {
        // Kiểm tra URL hợp lệ
        if (empty($url) || !preg_match('/facebook\.com/', $url)) {
            throw new Exception('Liên kết không hợp lệ. Vui lòng sử dụng URL video Facebook.');
        }

        // Header cho cURL
        $headers = [
            'sec-fetch-user: ?1',
            'sec-ch-ua-mobile: ?0',
            'sec-fetch-site: none',
            'sec-fetch-dest: document',
            'sec-fetch-mode: navigate',
            'cache-control: max-age=0',
            'authority: www.facebook.com',
            'upgrade-insecure-requests: 1',
            'accept-language: en-GB,en;q=0.9,tr-TR;q=0.8,tr;q=0.7,en-US;q=0.6',
            'sec-ch-ua: "Google Chrome";v="89", "Chromium";v="89", ";Not A Brand";v="99"',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36',
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
        ];

        // Gọi cURL để lấy HTML
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        $data = curl_exec($ch);
        if ($data === false) {
            throw new Exception('Không thể kết nối tới Facebook: ' . curl_error($ch));
        }
        curl_close($ch);

        // Trích xuất SD và HD link
        $sdLink = false;
        $hdLink = false;
        $title = 'Video Facebook';
        $videoId = '';
        $thumbnail = 'https://via.placeholder.com/200x300'; // Placeholder mặc định

        // Tìm video ID
        if (preg_match('#(\d+)/?$#', $url, $matches)) {
            $videoId = $matches[1];
        }

        // Tìm SD link
        $regexRateLimit = '/browser_native_sd_url":"([^"]+)"/';
        if (preg_match($regexRateLimit, $data, $match)) {
            $tmpStr = "{\"text\": \"{$match[1]}\"}";
            $sdLink = json_decode($tmpStr)->text . '&dl=1';
        }

        // Tìm HD link
        $regexRateLimit = '/browser_native_hd_url":"([^"]+)"/';
        if (preg_match($regexRateLimit, $data, $match)) {
            $tmpStr = "{\"text\": \"{$match[1]}\"}";
            $hdLink = json_decode($tmpStr)->text . '&dl=1';
        }

        // Tìm tiêu đề
        if (preg_match('/<title>(.*?)<\/title>/', $data, $matches)) {
            $tmpStr = "{\"text\": \"{$matches[1]}\"}";
            $title = json_decode($tmpStr)->text;
        } elseif (preg_match('/title id="pageTitle">(.+?)<\/title>/', $data, $matches)) {
            $tmpStr = "{\"text\": \"{$matches[1]}\"}";
            $title = json_decode($tmpStr)->text;
        }

        // Tìm thumbnail từ thẻ og:image
        if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/i', $data, $match)) {
            $thumbnail = htmlspecialchars($match[1]);
        }

        // Kiểm tra nếu không tìm thấy link video
        if (!$sdLink && !$hdLink) {
            throw new Exception('Không tìm thấy liên kết video. Đảm bảo video là công khai.');
        }

        // Tạo nội dung download với video thay vì thumbnail
        $downloadContent = '
            <div class="download-result">
                <div class="download-header">
                    <h2>Trình tải video Facebook</h2>
                    <p>Tải video Facebook chất lượng cao trực tuyến</p>
                </div>
                <div class="video-data">
                    <div class="tik-left">
                        <div class="thumbnail">
                            <div class="video-preview">
                                <video controls poster="' . $thumbnail . '" style="width: 100%; max-width: 200px; aspect-ratio: 3/4; border-radius: 3px;">
                                    <source src="' . ($sdLink ?: $hdLink) . '" type="video/mp4">
                                    Trình duyệt của bạn không hỗ trợ thẻ video.
                                </video>
                            </div>
                            <div class="content">
                                <h3>' . htmlspecialchars($title) . '</h3>
                            </div>
                        </div>
                    </div>
                    <div class="tik-right">
                        <div class="dl-action">
        ';

        if ($sdLink) {
            $downloadContent .= '
                <p><button class="tik-button-dl button dl-success" onclick="downloadFile(\'' . $sdLink . '\', \'facebook_video_' . $videoId . '_sd.mp4\')"><i class="icon icon-download"></i> Tải xuống chất lượng thấp</button></p>
            ';
        }
        if ($hdLink) {
            $downloadContent .= '
                <p><button class="tik-button-dl button dl-success" onclick="downloadFile(\'' . $hdLink . '\', \'facebook_video_' . $videoId . '_hd.mp4\')"><i class="icon icon-download"></i> Tải xuống chất lượng cao</button></p>
            ';
        }

        $downloadContent .= '
                        </div>
                    </div>
                </div>
                <a class="more-video" href="/">Tải xuống video khác</a>
                <div class="download-footer">
                    <p>💡 Đảm bảo video là công khai để tải thành công</p>
                </div>
            </div>
        ';
    } catch (Exception $e) {
        $errorMessage = '<div style="color: red;">Lỗi: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>SnapTik - Tải Video Facebook Chất Lượng Cao, Miễn Phí</title>
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5, shrink-to-fit=no" />
    <meta name="color-scheme" content="dark light">
    <meta itemprop="name" content="SnapTik - Tải Video Facebook Chất Lượng Cao, Miễn Phí">
    <meta name="description" content="Công cụ tải video Facebook miễn phí, chất lượng cao. Download video Facebook với SnapTik trên mọi thiết bị máy tính, điện thoại iOS, Android.">
    <meta name="author" content="Admin" />
    <meta itemprop="image" content="static/snapthumb.jpg">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="SnapTik - Tải Video Facebook Chất Lượng Cao, Miễn Phí">
    <meta name="twitter:description" content="Công cụ tải video Facebook miễn phí, chất lượng cao. Download video Facebook với SnapTik trên mọi thiết bị máy tính, điện thoại iOS, Android.">
    <meta name="twitter:image:src" content="static/snapthumb.jpg">
    <meta name="twitter:site" content="Snaptik.App">
    <meta property="og:title" content="SnapTik - Tải Video Facebook Chất Lượng Cao, Miễn Phí">
    <meta property="og:type" content="article">
    <meta property="og:image" content="static/snapthumb.jpg">
    <meta property="og:description" content="Công cụ tải video Facebook miễn phí, chất lượng cao. Download video Facebook với SnapTik trên mọi thiết bị máy tính, điện thoại iOS, Android.">
    <link rel="apple-touch-icon" sizes="192x192" href="static/icons-192.png">
    <link rel="shortcut icon" href="static/svg/favicon.png" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .download-result {
            margin: 30px auto;
            padding: 20px;
            max-width: 800px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }
        .download-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .download-header h2 {
            font-size: 1.5rem;
            color: #333;
            margin: 0;
        }
        .download-header p {
            font-size: 0.9rem;
            color: #666;
            margin: 5px 0 0;
        }
        .video-data {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }
        .tik-left {
            flex: 1;
            min-width: 200px;
        }
        .thumbnail {
            text-align: center;
            border: 0;
            border-radius: 5px;
            padding: 5px;
            background: #f9f9f9;
        }
        .thumbnail video {
            width: 100%;
            max-width: 200px;
            aspect-ratio: 3/4;
            border-radius: 3px;
        }
        .content h3 {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            margin: 10px 0 0;
            line-height: 1.3;
            text-align: center;
        }
        .tik-right {
            flex: 1;
            min-width: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .dl-action {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .tik-button-dl {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            background: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            border: none;
            width: 100%;
        }
        .tik-button-dl:hover {
            background: #0056b3;
        }
        .tik-button-dl i {
            margin-right: 8px;
        }
        .more-video {
            margin-top: 20px;
            padding: 10px;
            background: #444;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            width: 100%;
        }
        .more-video:hover {
            background: #333;
        }
        .download-footer {
            text-align: center;
            margin-top: 10px;
            font-size: 0.8rem;
            color: #666;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }
        .overlay.active {
            display: block;
        }
        .popup-body {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            max-width: 90%;
            width: 400px;
        }
        .popup-body video {
            width: 100%;
            border-radius: 5px;
        }
        .close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        .close-popup svg {
            fill: #333;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }
        .navbar-brand .logo a {
            font-size: 24px;
            font-weight: 700;
            color: #000;
            text-decoration: none;
        }
        .navbar-brand .logo a span {
            color: #007BFF;
        }
        .button-install {
            background: #007BFF;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 10px;
        }
        .button-install:hover {
            background: #0056b3;
        }
        .navbar-menu {
            display: flex;
            align-items: center;
        }
        .navbar-end {
            display: flex;
            gap: 15px;
        }
        .navbar-end .navbar-item {
            padding: 8px 15px;
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .navbar-end .navbar-item:hover {
            background: #f0f0f0;
            color: #007BFF;
        }
        .navbar-end .navbar-item.active {
            background: #007BFF;
            color: #fff;
        }
        .navbar-burger {
            display: none;
        }
        @media (max-width: 768px) {
            .download-result {
                padding: 15px;
            }
            .video-data {
                flex-direction: column;
                align-items: center;
            }
            .tik-left, .tik-right {
                width: 100%;
            }
            .thumbnail video {
                max-width: 150px;
            }
            .popup-body {
                width: 90%;
            }
            .navbar-burger {
                display: block;
            }
            .navbar-menu {
                display: none;
            }
            .navbar-menu.is-active {
                display: block;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                background: #fff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                padding: 10px 0;
            }
            .navbar-end {
                flex-direction: column;
                gap: 5px;
                padding: 10px;
            }
            .navbar-end .navbar-item {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body data-lang="vi">
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <div class="navbar-item logo">
                    <a href="index.php" class="fs24 fw700" title="">Snap<span>Tik</span></a>
                    <a href="https://play.google.com/store/apps/details?id=com.videodownloader.download.video.nolgo.nowatermark.downloader&referrer=web_install" class="flex-center button button-install" data-lang="vi"><i class="icon icon-mobile"></i><span class="nav_install_label">Cài Đặt App</span></a>
                </div>
                <div role="button" class="navbar-burger" aria-label="Menu" data-target="snaptik-menu"><span></span><span></span><span></span></div>
            </div>
            <div id="snaptik-menu" class="navbar-menu transition-all">
                <div class="navbar-start"></div>
                <div class="navbar-end">
                    <a href="index.php" class="navbar-item">TikTok</a>
                    <a href="facebook.php" class="navbar-item active">Facebook</a>
                    <a href="youtube.php" class="navbar-item">YouTube</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="hero" class="section hero">
        <div class="container w100">
            <h1 class="title">Tải Video Facebook</h1>
            <h2 class="title title-2">Download Video Facebook chất lượng cao - Miễn phí</h2>
            <form class="form" name="formurl" method="post">
                <div class="message">
                    <div class="message-body"></div>
                </div>
                <div class="is-relative" style="overflow: hidden;width: 100%;">
                    <input name="url" id="url" type="text" class="link-input" value="" placeholder="Dán liên kết Facebook vào đây" required="" aria-label="Name" autocomplete="off" autocapitalize="none">
                    <button class="button button-paste transition-all" type="button" onclick="pasteUrl()"><i class="icon icon-paste"></i><span>Dán</span></button>
                </div>
                <button type="submit" aria-label="Get" class="button button-go is-link transition-all"><i class="icon icon-down"></i>Download</button>
                <div class="get-loader flex-center transition-all" style="display: none;"><span class="snaptik-loader"></span></div>
            </form>
        </div>
    </section>
    <section id="main" class="section">
        <div class="container">
            <div class="alert-snaptik mb-3" role="alert">
                <b>Thông báo:</b> Đảm bảo liên kết video Facebook là công khai để có thể tải về.
            </div>
            <div id="download" class="download">
                <?php echo $downloadContent ?: $errorMessage; ?>
            </div>
            <div class="contents">
                <h3 class="title f14">Tải Video Facebook Chất Lượng Cao</h3>
                <p>SnapTik.Com là công cụ giúp download video Facebook với chất lượng cao, không cần cài đặt ứng dụng hay phần mềm. Công cụ hoạt động online, hoàn toàn miễn phí.</p>

                <h3 class="subtitle f14 mb-3">Các tính năng của SnapTik Download video Facebook</h3>
                <p class="mb-3"><b>Tải Video Facebook chất lượng cao:</b> SnapTik hỗ trợ tải video Facebook ở định dạng HD, giữ nguyên chất lượng như bản gốc.</p>
                <p class="mb-3"><b>Hỗ trợ mọi thiết bị:</b> Tải video trên máy tính, điện thoại iOS, Android mà không cần ứng dụng bổ sung.</p>
                <p class="mb-3"><b>Miễn phí hoàn toàn:</b> Không yêu cầu đăng nhập hay trả phí, sử dụng dễ dàng mọi lúc.</p>

                <h3 class="title f14">Cách tải video Facebook</h3>
                <p class="mb-3 mt-3"><span class="step-guide">Bước 1:</span> <kbd>Copy</kbd> đường dẫn của video Facebook muốn tải về</p>
                <p class="mb-3"><span class="step-guide">Bước 2:</span> <kbd>Mở SnapTik</kbd> bằng trình duyệt web</p>
                <p class="mb-3"><span class="step-guide">Bước 3:</span> <kbd>Dán</kbd> đường link video vào ô công cụ và nhấn nút <kbd>Tải về</kbd></p>
                <p class="mb-3"><span class="step-guide">Bước 4:</span> Chọn chất lượng (Low hoặc High) và nhấn nút download để tải video về máy</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <section class="section">
            <div class="container">
                <div class="columns footer-link">
                    <div class="column">
                        <h4 class="col-heading">Company</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" rel="nofollow">Liên hệ</a></li>
                        </ul>
                    </div>
                    <div class="column">
                        <h4 class="col-heading">Legal</h4>
                        <ul class="list-unstyled">
                            <li><a href="terms-of-service.html" rel="nofollow">Điều khoản dịch vụ</a></li>
                            <li><a href="privacy-policy.html" rel="nofollow">Chính sách bảo mật</a></li>
                        </ul>
                    </div>
                    <div class="column">
                        <h4 class="col-heading">Tools</h4>
                        <ul class="list-unstyled">
                            <li><a href="#">Download photo TikTok Notes</a></li>
                            <li><a href="#" rel="nofollow">Download video Douyin</a></li>
                            <li><a href="facebook.php" rel="nofollow">Download video Facebook</a></li>
                            <li><a href="youtube.php" rel="nofollow">Download video YouTube</a></li>
                            <li><a href="#" rel="nofollow">Download Tiktok Slide</a></li>
                            <li><a href="#" rel="nofollow">Download Tiktok Story</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="copyright"><span>© 2019 - 2023 SnapTik - <a href="/">Video Downloader</a> Version 18.4</span></div>
        </div>
    </footer>

    <div id="popup_play" class="overlay">
        <div class="popup-body">
            <a class="close close-popup"><svg width="32" height="32" class="svg-close" version="1.1" viewBox="0 0 32 32" aria-hidden="false"><path d="M25.33 8.55l-1.88-1.88-7.45 7.45-7.45-7.45-1.88 1.88 7.45 7.45-7.45 7.45 1.88 1.88 7.45-7.45 7.45 7.45 1.88-1.88-7.45-7.45z"></path></svg></a>
            <div class="popup-content">
                <video id="vid" controls=""></video>
            </div>
        </div>
    </div>

    <script>
        function pasteUrl() {
            navigator.clipboard.readText().then(text => {
                document.getElementById("url").value = text;
            }).catch(err => {
                console.error('Không thể dán: ', err);
            });
        }

        function showVideo(videoUrl) {
            const popup = document.getElementById("popup_play");
            const video = document.getElementById("vid");
            video.src = videoUrl;
            video.autoplay = true;
            video.play().catch(error => console.log("Tự động phát thất bại:", error));
            popup.classList.add("active");
        }

        function closePopup() {
            const popup = document.getElementById("popup_play");
            const video = document.getElementById("vid");
            video.pause();
            video.src = "";
            popup.classList.remove("active");
        }

        document.querySelector(".close-popup")?.addEventListener("click", closePopup);

        document.getElementById("popup_play")?.addEventListener("click", (event) => {
            if (event.target === document.getElementById("popup_play")) {
                closePopup();
            }
        });

        async function downloadFile(url, fileName) {
            try {
                const response = await fetch(url);
                const blob = await response.blob();
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = fileName;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(link.href);
            } catch (error) {
                console.error('Lỗi khi tải tệp:', error);
                alert('Không thể tải tệp. Vui lòng thử lại sau.');
            }
        }

        document.querySelector('.navbar-burger').addEventListener('click', function() {
            document.querySelector('#snaptik-menu').classList.toggle('is-active');
        });
    </script>
</body>
</html>

