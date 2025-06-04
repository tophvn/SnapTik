<?php
$downloadContent = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = trim($_POST['url']);

    try {
        // Validate URL
        if (empty($url) || !preg_match('/(youtube\.com|youtu\.be)/', $url)) {
            throw new Exception('URL không hợp lệ. Vui lòng sử dụng URL video YouTube hợp lệ.');
        }

        // Extract video ID
        $videoId = '';
        if (preg_match('/v=([^&]+)/', $url, $matches) || preg_match('/youtu\.be\/([^?]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        // Placeholder for thumbnail
        $thumbnail = $videoId ? "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg" : 'https://via.placeholder.com/200x300';

        // Build minimal download content (let javascript.js handle video and download buttons)
        $downloadContent = '
            <div class="download-result">
                <div class="download-header">
                    <h2>Tải Video YouTube</h2>
                    <p>Tải video YouTube chất lượng cao trực tuyến</p>
                </div>
                <div class="video-data">
                    <div class="tik-left">
                        <div class="thumbnail">
                            <div class="video-preview">
                                <img src="' . $thumbnail . '" alt="Hình thu nhỏ video" style="width: 100%; max-width: 200px; aspect-ratio: 3/4; border-radius: 3px;">
                            </div>
                        </div>
                    </div>
                    <div class="tik-right">
                        <div class="dl-action">
                            <div id="download"></div>
                        </div>
                    </div>
                </div>
                <a class="more-video" href="/">Tải video khác</a>
                <div class="download-footer">
                    <p>💡 Đảm bảo video ở chế độ công khai để tải thành công</p>
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
    <title>SnapTik - Tải Video YouTube Chất Lượng Cao, Miễn Phí</title>
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5, shrink-to-fit=no" />
    <meta name="color-scheme" content="dark light">
    <meta itemprop="name" content="SnapTik - Tải Video YouTube Chất Lượng Cao, Miễn Phí">
    <meta name="description" content="Công cụ miễn phí để tải video YouTube chất lượng cao. Sử dụng SnapTik để tải video YouTube trên mọi thiết bị: PC, iOS, Android.">
    <meta name="author" content="Admin" />
    <meta itemprop="image" content="static/snapthumb.jpg">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="SnapTik - Tải Video YouTube Chất Lượng Cao, Miễn Phí">
    <meta name="twitter:description" content="Công cụ miễn phí để tải video YouTube chất lượng cao. Sử dụng SnapTik để tải video YouTube trên mọi thiết bị: PC, iOS, Android.">
    <meta name="twitter:image:src" content="static/snapthumb.jpg">
    <meta name="twitter:site" content="Snaptik.App">
    <meta property="og:title" content="SnapTik - Tải Video YouTube Chất Lượng Cao, Miễn Phí">
    <meta property="og:type" content="article">
    <meta property="og:image" content="static/snapthumb.jpg">
    <meta property="og:description" content="Công cụ miễn phí để tải video YouTube chất lượng cao. Sử dụng SnapTik để tải video YouTube trên mọi thiết bị: PC, iOS, Android.">
    <link rel="apple-touch-icon" sizes="192x192" href="static/icons-192.png">
    <link rel="shortcut icon" href="static/svg/favicon.png" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.2.3/purify.min.js" integrity="sha512-Ll+TuDvrWDNNRnFFIM8dOiw7Go7dsHyxRp4RutiIFW/wm3DgDmCnRZow6AqbXnCbpWu93yM1O34q+4ggzGeXVA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            flex-direction: row; /* Sửa thành row để các nút nằm ngang */
            flex-wrap: wrap; /* Cho phép wrap nếu không đủ chỗ */
            gap: 10px;
            justify-content: center; /* Căn giữa các nút */
        }
        /* Thêm style cho nút tải xuống */
        .download-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background 0.3s;
        }
        .download-item:hover {
            background: #f0f0f0;
        }
        .format {
            font-weight: 500;
            color: #333;
            flex: 1;
        }
        .size {
            font-size: 0.9rem;
            color: #666;
            margin: 0 15px;
        }
        .download-btn {
            padding: 8px 15px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
            text-align: center;
            min-width: 100px;
        }
        .download-btn:hover {
            background: #218838;
        }
        /* Kết thúc style cho nút tải xuống */
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
        #form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }
        #inputUrl {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        #downloadBtn {
            padding: 10px 20px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
        #downloadBtn:hover {
            background: #0056b3;
        }
        #loading {
            display: none;
            text-align: center;
            margin: 20px 0;
        }
        #loading .centerV {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .wave {
            width: 5px;
            height: 40px;
            background: #007BFF;
            margin: 0 3px;
            animation: wave 1s linear infinite;
        }
        .wave:nth-child(2) { animation-delay: -0.9s; }
        .wave:nth-child(3) { animation-delay: -0.8s; }
        .wave:nth-child(4) { animation-delay: -0.7s; }
        .wave:nth-child(5) { animation-delay: -0.6s; }
        .wave:nth-child(6) { animation-delay: -0.5s; }
        .wave:nth-child(7) { animation-delay: -0.4s; }
        .wave:nth-child(8) { animation-delay: -0.3s; }
        .wave:nth-child(9) { animation-delay: -0.2s; }
        .wave:nth-child(10) { animation-delay: -0.1s; }
        @keyframes wave {
            0%, 40%, 100% { transform: scaleY(0.4); }
            20% { transform: scaleY(1); }
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
            #form {
                flex-direction: column;
            }
            #inputUrl {
                width: 100%;
            }
            .dl-action {
                flex-direction: column;
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
                </div>
                <div role="button" class="navbar-burger" aria-label="Menu" data-target="snaptik-menu"><span></span><span></span><span></span></div>
            </div>
            <div id="snaptik-menu" class="navbar-menu transition-all">
                <div class="navbar-start"></div>
                <div class="navbar-end">
                    <a href="index.php" class="navbar-item">TikTok</a>
                    <a href="facebook.php" class="navbar-item">Facebook</a>
                    <a href="youtube.php" class="navbar-item active">YouTube</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="hero" class="section hero">
        <div class="container w100">
        <h1 class="title" style="font-size: 36px; margin-bottom: 10px;">Tải Video YouTube</h1>
        <h2 class="title title-2" style="font-size: 24px; margin-bottom: 20px;">Tải video YouTube chất lượng cao - Miễn phí</h2>
        <div id="form" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <input id="inputUrl" type="url" placeholder="Nhập URL YouTube" required autocomplete="off" autocapitalize="none"
                style="flex: 1; min-width: 300px; font-size: 18px; background-color: white; color: gray; padding: 12px; border: 1px solid #ccc; border-radius: 4px;">
            <button id="downloadBtn" type="button"
                    style="font-size: 18px; background-color: #00BE63; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer;">
                Download
            </button>
        </div>

            <div id="loading">
                <div class="centerV">
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                </div>
            </div>
        </div>
    </section>
    <section id="main" class="section">
        <div class="container">
            <div class="alert-snaptik mb-3" role="alert">
                <b>Lưu ý:</b> Đảm bảo liên kết video YouTube ở chế độ công khai để tải thành công.
            </div>
            <div id="container">
                <div id="thumb" class="mb-3"></div>
                <div id="title"></div>
                <div id="description" class="mt-3"></div>
                <div id="uploader"></div>
                <div id="duration"></div>
                <div id="extractor"></div>
                <div id="downloadURL"></div>
                <div id="download"></div>
            </div>
            <div class="contents">
                <h3 class="title f14">Tải Video YouTube Chất Lượng Cao</h3>
                <p>SnapTik.Com là công cụ tải video YouTube chất lượng cao mà không cần cài đặt ứng dụng hay phần mềm. Công cụ hoạt động trực tuyến và hoàn toàn miễn phí.</p>
                <h3 class="subtitle f14 mb-3">Tính Năng của Công Cụ Tải Video YouTube SnapTik</h3>
                <p class="mb-3"><b>Tải Video YouTube Chất Lượng Cao:</b> SnapTik hỗ trợ tải video YouTube ở chất lượng HD, giữ nguyên chất lượng gốc.</p>
                <p class="mb-3"><b>Hỗ Trợ Mọi Thiết Bị:</b> Tải video trên PC, iOS và Android mà không cần ứng dụng bổ sung.</p>
                <p class="mb-3"><b>Hoàn Toàn Miễn Phí:</b> Không cần đăng nhập hay thanh toán, dễ sử dụng mọi lúc.</p>
                <h3 class="title f14">Cách Tải Video YouTube</h3>
                <p class="mb-3 mt-3"><span class="step-guide">Bước 1:</span> <kbd>Sao chép</kbd> URL của video YouTube bạn muốn tải.</p>
                <p class="mb-3"><span class="step-guide">Bước 2:</span> <kbd>Mở SnapTik</kbd> trong trình duyệt web của bạn.</p>
                <p class="mb-3"><span class="step-guide">Bước 3:</span> <kbd>Dán</kbd> URL video YouTube vào ô nhập liệu của công cụ và nhấn <kbd>Tải xuống</kbd>.</p>
                <p class="mb-3"><span class="step-guide">Bước 4:</span> Chọn chất lượng và định dạng mong muốn, sau đó nhấn nút tải xuống để lưu video.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <section class="section">
            <div class="container">
                <div class="columns footer-link">
                    <div class="column">
                        <h4 class="col-heading">Công Ty</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" rel="nofollow">Liên Hệ</a></li>
                        </ul>
                    </div>
                    <div class="column">
                        <h4 class="col-heading">Pháp Lý</h4>
                        <ul class="list-unstyled">
                            <li><a href="terms-of-service.html" rel="nofollow">Điều Khoản Dịch Vụ</a></li>
                            <li><a href="privacy-policy.html" rel="nofollow">Chính Sách Bảo Mật</a></li>
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
            <div class="copyright"><span>© 2019 - 2023 SnapTik - <a href="/">Công Cụ Tải Video</a> Phiên Bản 18.4</span></div>
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
                document.getElementById("inputUrl").value = text;
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

        document.querySelector('.navbar-burger').addEventListener('click', function() {
            document.querySelector('#snaptik-menu').classList.toggle('is-active');
        });
    </script>
    <script type="text/javascript" src="js/javascript.js"></script>
</body>
</html>