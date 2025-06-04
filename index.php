<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>SnapTik - Tải Video TikTok Không Logo, Full HD, Miễn Phí</title>
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5, shrink-to-fit=no" />
    <meta name="color-scheme" content="dark light">
    <meta itemprop="name" content="SnapTik - Tải Video TikTok Không Logo, Full HD, Miễn Phí">
    <meta name="description" content="Công cụ tải video TikTok miễn phí, không có logo, chất lượng HD. Download video TikTok với SnapTik trên mọi thiết bị máy tính, điện thoại iOS, Android. ">
    <meta name="author" content="Admin" />
    <meta itemprop="image" content="static/snapthumb.jpg">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="SnapTik - Tải Video TikTok Không Logo, Full HD, Miễn Phí">
    <meta name="twitter:description" content="Công cụ tải video TikTok miễn phí, không có logo, chất lượng HD. Download video TikTok với SnapTik trên mọi thiết bị máy tính, điện thoại iOS, Android. ">
    <meta name="twitter:image:src" content="static/snapthumb.jpg">
    <meta name="twitter:site" content="Snaptik.App">
    <meta property="og:title" content="SnapTik - Tải Video TikTok Không Logo, Full HD, Miễn Phí">
    <meta property="og:type" content="article">
    <meta property="og:image" content="static/snapthumb.jpg">
    <meta property="og:description" content="Công cụ tải video TikTok miễn phí, không có logo, chất lượng HD. Download video TikTok với SnapTik trên mọi thiết bị máy tính, điện thoại iOS, Android. ">
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
        .thumbnail img {
            width: 100%;
            max-width: 200px;
            aspect-ratio: 3/4;
            object-fit: cover;
            border-radius: 3px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .thumbnail img:hover {
            transform: scale(1.05);
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
            .thumbnail img {
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
                </div>
                <div role="button" class="navbar-burger" aria-label="Menu" data-target="snaptik-menu"><span></span><span></span><span></span></div>
            </div>
            <div id="snaptik-menu" class="navbar-menu transition-all">
                <div class="navbar-start"></div>
                <div class="navbar-end">
                    <a href="index.php" class="navbar-item active">TikTok</a>
                    <a href="facebook.php" class="navbar-item">Facebook</a>
                    <a href="youtube.php" class="navbar-item">YouTube</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="hero" class="section hero">
        <div class="container w100">
            <h1 class="title">Tải Video TikTok</h1>
            <h2 class="title title-2">Download Video TikTok không logo, ID - Chất lượng HD - Miễn phí</h2>
            <form class="form" name="formurl" method="get" onsubmit="return startDownload(event)">
                <div class="message">
                    <div class="message-body"></div>
                </div>
                <div class="is-relative" style="overflow: hidden;width: 100%;">
                    <input name="url" id="url" type="text" class="link-input" value="" placeholder="Dán liên kết TikTok vào đây" required="" aria-label="Name" autocomplete="off" autocapitalize="none">
                    <button class="button button-paste transition-all" type="button" onclick="pasteUrl()"><i class="icon icon-paste"></i><span>Dán</span></button>
                </div>
                <button type="submit" aria-label="Get" class="button button-go is-link transition-all"><i class="icon icon-down"></i>Download</button>
                <div class="get-loader flex-center transition-all"><span class="snaptik-loader"></span></div>
            </form>
        </div>
    </section>
    <section id="main" class="section">
        <div class="container">
            <div class="alert-snaptik mb-3" role="alert">
            <b>Lưu ý:</b> Đảm bảo liên kết video Tiktok ở chế độ công khai để tải thành công.
            </div>
            <div id="download" class="download"></div>
            <div class="contents">
                <h3 class="title f14">Tải Video TikTok Không Dính Logo Và ID</h3>
                <p>SnapTik.Com là công cụ giúp download video TikTok mà không lo bị dính logo và id của người dùng TikTok trong video tải về máy. Điều đặc biệt, bạn không cần phải cài đặt bất kỳ ứng dụng, phần mềm hay tiện ích mở rộng gì để sử dụng SnapTik.
                    Công cụ hoạt động online, hoàn toàn miễn phí. </p>

                <h3 class="subtitle f14 mb-3">Các tính năng của SnapTik Download video Tiktok</h3>
                <p class="mb-3"><b>Tải Video Tiktok không logo:</b> SnapTik là website chuyên hỗ trợ <a href="#">tải video TikTok</a> không logo, watermark, ID; dễ dàng có được video nguyên bản để lưu trữ, tái sử dụng.</p>
                <p class="mb-3"><b>Lưu video Tiktok về máy với chất lượng HD:</b> Các video lưu từ Tiktok về máy trên SnapTik.App luôn ở chất lượng cao Full HD, HD, nét như bản gốc. </p>
                <p class="mb-3"><b>Hỗ trợ lưu video Tik tok ở các định dạng .mp4:</b> Định dạng khi tải video về máy là mp4. Bạn có thể lưu chúng ở định dạng video và sau đó chuyển đổi thành định dạng audio .mp3, dễ dàng lưu trữ các âm thanh, đoạn nhạc trên TikTok về
                    máy</p>
                <p class="mb-3"><b>Hoạt động trên mọi thiết bị:</b> Trong khi Tiktok chỉ hỗ trợ người dùng tải video trên ứng dụng di động, với SnapTik bạn có thể lưu các clip TikTok trên bất kỳ thiết bị nào, bao gồm điện thoại iphone (iOS), Samsung, Xiaomi (Android),
                    trên máy tính (PC).</p>
                <p class="mb-3"><b>Tiktok video downloader miễn phí:</b> Công cụ SnapTik.App hoàn toàn miễn phí, không yêu cầu đăng nhập và không cần trả phí. </p>

                <h3 class="title f14">Cách tải video tik tok không dính logo</h3>
                <p class="mb-3 mt-3"><span class="step-guide">Bước 1:</span> <kbd>Copy</kbd> đường dẫn của video TikTok muốn tải về (Bấm biểu tượng share, chọn copy liên kết)</p>
                <p class="mb-3"><span class="step-guide">Bước 2:</span> <kbd>Mở SnapTik</kbd> bằng bất cứ trình duyệt web nào chrome/firefox/Safari trên các thiết bị thông minh </p>
                <p class="mb-3"><span class="step-guide">Bước 3:</span> <kbd>Dán</kbd> đường link video vào ô công cụ và nhấn nút <kbd>Tải về</kbd></p>
                <p class="mb-3"><span class="step-guide">Bước 4:</span> Tiếp tục ấn nút <kbd>download</kbd> dưới hoặc bên cạnh video hiện trên màn hình để tải về máy</p>

                <div class="accordion" id="faq" itemscope="" itemtype="https://schema.org/FAQPage">
                    <div class="accordion-item" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                        <button class="button is-info btn-accordion">
                            <h3 class="accordion-title" itemprop="name">Có an toàn để tải video TikTok trên SnapTik.Com không?</h3>
                            <span class="icon arrow"></span>
                        </button>
                        <div class="accordion-content" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <div class="accordion-text" itemprop="text">
                                Có, tải video TikTok ở đây rất an toàn. Người dùng không cần cung cấp bất kỳ thông tin gì ngoài đường link của video TikTok. SnapTik.Com được xây dựng trên nền tảng web nên sẽ không có virus hay phần mềm độc hại. Đọc thêm về chính sách riêng tư để biết
                                thêm về các thông tin chúng tôi thu thập và sử dụng.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                        <button class="button is-info btn-accordion">
                            <h3 class="accordion-title" itemprop="name">SnapTik có lưu trữ video của người dùng khi tải không?</h3>
                            <span class="icon arrow"></span>
                        </button>
                        <div class="accordion-content" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <div class="accordion-text" itemprop="text">
                                Không, các video sau khi tải về, các đường link mà người dùng cung cấp sẽ bị xoá khỏi hệ thống ngay lập tức.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                        <button class="button is-info btn-accordion">
                            <h3 class="accordion-title" itemprop="name">Các video Tik Tok tải về qua SnapTik được lưu ở đâu?</h3>
                            <span class="icon arrow"></span>
                        </button>
                        <div class="accordion-content" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <div class="accordion-text" itemprop="text">
                                Các video sẽ được lưu ở thư mục tải về mặc định. Nó có thể thư mục download (tải về) trên máy tính, và ở tệp download trên điện thoại.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                        <button class="button is-info btn-accordion">
                            <h3 class="accordion-title" itemprop="name">Vì sao video tải về từ TikTok không trong bộ sưu tập điện thoại?</h3>
                            <span class="icon arrow"></span>
                        </button>
                        <div class="accordion-content" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <div class="accordion-text" itemprop="text">
                                Như đã nói, khi tải video tiktok về máy, chúng sẽ được lưu trong thư mục tải về, không phải nằm trong bộ sưu tập video và ảnh điện thoại. Bạn cần thêm thao tác lưu các video TikTok vào bộ sưu tập trên điện thoại.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                        <button class="button is-info btn-accordion">
                            <h3 class="accordion-title" itemprop="name">SnapTik có hạn chế số lần tải không?</h3>
                            <span class="icon arrow"></span>
                        </button>
                        <div class="accordion-content" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <div class="accordion-text" itemprop="text">
                                Không. Bạn có thể tải bao nhiêu video TikTok tuỳ ý. SnapTik không hạn chế số lần tải về trong ngày.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                        <button class="button is-info btn-accordion">
                            <h3 class="accordion-title" itemprop="name">Tôi có thể tải nhiều video Tiktok cùng lúc không?</h3>
                            <span class="icon arrow"></span>
                        </button>
                        <div class="accordion-content" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <div class="accordion-text" itemprop="text">
                                Không. SnapTik chưa hỗ trợ tải nhiều video cùng lúc.
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mb-3"><b>Lưu ý:</b> vn.snaptik.com hay snaptik.com không phải là một công cụ của Tiktok, chúng tôi không có mối quan hệ nào với Tiktok hay ByteDance Ltd. Chúng tôi chỉ hỗ trợ người dùng Tiktok tải xuống video trên Tiktok không có logo với mục
                    đích chính đáng. Chúng tôi không chịu trách nhiệm với việc người dùng sử dụng nội dung tải về như thế nào. Nếu bạn gặp sự cố với các trang như Tikmate hoặc SSSTiktok, hãy thử SnapTik, chúng tôi liên tục cải tiến công cụ để giúp người
                    dùng tải xuống video tiktok dễ dàng. Không sử dụng các video TikTok cho mục đích thương mại, kiếm tiền khi không được sự cho phép.</p>
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
            <div class="copyright"><span>© 2019 - 2023 SnapTik - <a href="/">TikTok Video Download</a> Version 18.4</span></div>
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
        async function startDownload(event) {
            event.preventDefault();
            const url = document.getElementById("url").value;
            const result = document.getElementById("download");
            const loader = document.querySelector(".get-loader");
            
            loader.style.display = "flex";
            result.innerHTML = "<p>Đang xử lý...</p>";
            
            try {
                const res = await fetch(`https://tikwm.com/api/?url=${encodeURIComponent(url)}`);
                const data = await res.json();
                if (data && data.data) {
                    const videoUrl = data.data.play || "";
                    const thumbnail = data.data.cover || "";
                    const title = data.data.title || "Video TikTok";
                    const musicUrl = data.data.music || "";
                    const hdVideoUrl = data.data.wmplay || data.data.play;

                    result.innerHTML = `
                        <div class="download-result">
                            <div class="download-header">
                                <h2>Trình tải video TikTok</h2>
                                <p>Tải video TikTok không có logo, hình mờ trực tuyến</p>
                            </div>
                            <div class="video-data">
                                <div class="tik-left">
                                    <div class="thumbnail">
                                        <div class="image-tik open-popup">
                                            <img src="${thumbnail}" alt="Thumbnail" onclick="showVideo('${videoUrl}')">
                                        </div>
                                        <div class="content">
                                            <h3>${title}</h3>
                                        </div//vn.snaptik.com/iv>
                                    </div>
                                </div>
                                <div class="tik-right">
                                    <div class="dl-action">
                                        <p><button class="tik-button-dl button dl-success" onclick="downloadFile('${videoUrl}', 'tiktok_video_1.mp4')"><i class="icon icon-download"></i> Tải xuống MP4 </button></p>
                                        <p><button class="tik-button-dl button dl-success" onclick="downloadFile('${videoUrl}', 'tiktok_video_2.mp4')"><i class="icon icon-download"></i> Tải xuống MP4 [No Logo]</button></p>
                                        <p><button class="tik-button-dl button dl-success" onclick="downloadFile('${hdVideoUrl}', 'tiktok_video_hd.mp4')"><i class="icon icon-download"></i> Tải xuống MP4 [Logo]</button></p>
                                        ${musicUrl ? `<p><button class="tik-button-dl button dl-success" onclick="downloadFile('${musicUrl}', 'tiktok_audio.mp3')"><i class="icon icon-download"></i> Tải xuống MP3</button></p>` : ""}
                                    </div>
                                </div>
                            </div>
                            <a class="more-video" href="/">Tải xuống video khác</a>
                            <div class="download-footer">
                                <p>💡 Cách tải video TikTok với TikVid</p>
                            </div>
                        </div>
                    `;
                } else {
                    throw new Error("Liên kết không hợp lệ hoặc không hỗ trợ.");
                }
            } catch (e) {
                result.innerHTML = `<div style="color: red;">Lỗi: ${e.message}</div>`;
            } finally {
                loader.style.display = "none";
            }
            return false;
        }

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