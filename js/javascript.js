/*******************************
 * Cấu hình cho Màu sắc
 *******************************/
const formatColors = {
    greenFormats: ["17", "18", "22"],
    blueFormats: ["139", "140", "141", "249", "250", "251", "599", "600"],
    defaultColor: "#9e0cf2"
};

/*******************************
 * Các Hàm Tiện ích
 *******************************/

/**
 * Lấy màu nền dựa trên itag định dạng.
 * @param {string} downloadUrlItag - Tham số itag từ URL tải xuống.
 * @returns {string} - Màu nền tương ứng.
 */
function getBackgroundColor(downloadUrlItag) {
    if (formatColors.greenFormats.includes(downloadUrlItag)) {
        return "green";
    } else if (formatColors.blueFormats.includes(downloadUrlItag)) {
        return "#3800ff";
    } else {
        return formatColors.defaultColor;
    }
}

/**
 * Hàm debounce để giới hạn tần suất thực thi của một hàm.
 * @param {Function} func - Hàm cần debounce.
 * @param {number} wait - Thời gian chờ (tính bằng mili giây).
 * @returns {Function} - Hàm đã được debounce.
 */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

/**
 * Trích xuất ID video YouTube từ URL.
 * @param {string} url - URL YouTube.
 * @returns {string|null} - ID video hoặc null nếu không tìm thấy.
 */
// Hàm lấy ID video YouTube từ URL, bao gồm URL Shorts
function getYouTubeVideoIds(url) {
    // Xác thực đầu vào
    if (!url || typeof url !== 'string') {
        console.error('URL không hợp lệ được cung cấp cho getYouTubeVideoId:', url);
        return null;
    }

    try {
        // Tạo đối tượng URL để phân tích URL
        const urlObj = new URL(url);

        // Kiểm tra xem hostname có thuộc về YouTube hoặc liên kết ngắn của YouTube không
        const validHosts = ['www.youtube.com', 'youtube.com', 'youtu.be'];
        if (!validHosts.includes(urlObj.hostname)) {
            console.warn('URL không thuộc về YouTube:', url);
            return null;
        }

        // Đối với youtu.be (liên kết ngắn), ID video nằm trong pathname
        if (urlObj.hostname === 'youtu.be') {
            const videoId = urlObj.pathname.slice(1); // Xóa dấu '/' đầu tiên
            return videoId.length === 11 ? videoId : null;
        }

        // Đối với URL youtube.com, tìm 'v' hoặc 'shorts' trong query hoặc pathname
        if (urlObj.hostname.includes('youtube.com')) {
            if (urlObj.pathname.startsWith('/shorts/')) {
                // ID video Shorts nằm trong pathname sau "/shorts/"
                return urlObj.pathname.split('/')[2];
            }

            // URL video thông thường có 'v' là tham số query
            const videoId = urlObj.searchParams.get('v');
            return videoId && videoId.length === 11 ? videoId : null;
        }

        console.warn('Định dạng URL YouTube không được nhận diện:', url);
        return null;
    } catch (error) {
        console.error('Lỗi khi phân tích URL trong getYouTubeVideoId:', error);
        return null;
    }
}

/**
 * Làm sạch nội dung HTML bằng DOMPurify.
 * @param {string} content - Nội dung HTML cần làm sạch.
 * @returns {string} - Nội dung HTML đã được làm sạch.
 */
function sanitizeContent(content) {
    return DOMPurify.sanitize(content);
}

/**
 * Cập nhật nội dung HTML bên trong của một phần tử được chỉ định với nội dung đã được làm sạch.
 * @param {string} elementId - ID của phần tử HTML.
 * @param {string} content - Nội dung cần chèn.
 */
function updateElement(elementId, content) {
    const element = document.getElementById(elementId);
    if (element) {
        element.innerHTML = content;
    } else {
        console.warn(`Không tìm thấy phần tử với ID "${elementId}".`);
    }
}

/**
 * Lấy giá trị tham số truy vấn theo tên từ URL.
 * @param {string} name - Tên của tham số.
 * @param {string} url - URL để trích xuất tham số.
 * @returns {string} - Giá trị tham số hoặc chuỗi rỗng nếu không tìm thấy.
 */
function getParameterByName(name, url) {
    // Thoát các ký tự đặc biệt của regex
    name = name.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`[?&]${name}(=([^&#]*)|&|#|$)`);
    const results = regex.exec(url);
    
    if (!results) return '';
    if (!results[2]) return '';
    
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

/*******************************
 * Yêu cầu AJAX với Logic Thử Lại
 *******************************/

/**
 * Thực hiện yêu cầu AJAX GET với khả năng thử lại.
 * @param {string} inputUrl - URL đầu vào cho yêu cầu.
 * @param {number} retries - Số lần thử lại còn lại.
 */
function makeRequest(inputUrl, retries = 4) {
    const requestUrl = `https://vkrdownloader.xyz/server?api_key=vkrdownloader&vkr=${encodeURIComponent(inputUrl)}`;
    const retryDelay = 2000; // Độ trễ thử lại ban đầu (tính bằng mili giây)
    const maxRetries = retries;

    $.ajax({
        url: requestUrl,
        type: "GET",
        cache: true,
        async: true,
        crossDomain: true,
        dataType: 'json',
        timeout: 15000, // Thời gian chờ kéo dài cho các mạng chậm
        success: function (data) {
            handleSuccessResponse(data, inputUrl);
        },
        error: function (xhr, status, error) {
            if (retries > 0) {
                let delay = retryDelay * Math.pow(2, maxRetries - retries); // Độ trễ lũy tiến
                console.log(`Thử lại sau ${delay / 1000} giây... (còn ${retries} lần thử)`);
                setTimeout(() => makeRequest(inputUrl, retries - 1), delay);
            } else {
                const errorMessage = getErrorMessage(xhr, status, error);
                console.error(`Chi tiết lỗi: ${errorMessage}`);
                displayError("Không thể lấy liên kết tải xuống sau nhiều lần thử. Vui lòng kiểm tra URL hoặc thử lại sau.");
                document.getElementById("loading").style.display = "none";
            }
        },
        complete: function () {
            document.getElementById("downloadBtn").disabled = false; // Kích hoạt lại nút
        }
    });
}

function getErrorMessage(xhr, status, error) {
    const statusCode = xhr.status;
    let message = `Trạng thái: ${status}, Lỗi: ${error}`;

    if (xhr.responseText) {
        try {
            const response = JSON.parse(xhr.responseText);
            if (response && response.error) {
                message += `, Lỗi máy chủ: ${response.error}`;
            }
        } catch (e) {
            message += `, Không thể phân tích phản hồi máy chủ.`;
        }
    }

    switch (statusCode) {
        case 0: return "Lỗi mạng: Không thể kết nối với máy chủ.";
        case 400: return "Yêu cầu không hợp lệ: URL đầu vào có thể không đúng.";
        case 401: return "Không được ủy quyền: Vui lòng kiểm tra khóa API.";
        case 429: return "Quá nhiều yêu cầu: Bạn đang bị giới hạn tốc độ.";
        case 503: return "Dịch vụ không khả dụng: Máy chủ tạm thời quá tải.";
        default: return `${message}, HTTP ${statusCode}: ${xhr.statusText || error}`;
    }
}

function displayError(message) {
    // Giả sử có một phần tử placeholder cho thông báo lỗi
    const errorElement = document.getElementById("errorMessage");
    if (errorElement) {
        errorElement.innerText = message;
        errorElement.style.display = "block";
    }
}

/**
 * Tạo thông báo lỗi chi tiết dựa trên phản hồi XHR.
 * @param {Object} xhr - Đối tượng XMLHttpRequest.
 * @param {string} status - Chuỗi trạng thái.
 * @param {string} error - Thông báo lỗi.
 * @returns {string} - Thông báo lỗi được định dạng.
 */

/*******************************
 * Xử lý Sự kiện
 *******************************/

/**
 * Xử lý sự kiện nhấp vào nút "Tải xuống".
 */
document.getElementById("downloadBtn").addEventListener("click", debounce(function () {
    document.getElementById("loading").style.display = "initial";
    document.getElementById("downloadBtn").disabled = true; // Vô hiệu hóa nút

    const inputUrl = document.getElementById("inputUrl").value.trim();
    if (!inputUrl) {
        displayError("Vui lòng nhập URL YouTube hợp lệ.");
        document.getElementById("loading").style.display = "none";
        document.getElementById("downloadBtn").disabled = false;
        return;
    }

    makeRequest(inputUrl); // Thực hiện yêu cầu AJAX với logic thử lại
}, 300));  // Điều chỉnh độ trễ nếu cần

/**
 * Hiển thị thông báo lỗi trong trang thay vì sử dụng alert.
 * @param {string} message - Thông báo lỗi cần hiển thị.
 */
function displayError(message) {
    const errorContainer = document.getElementById("error");
    if (errorContainer) {
        errorContainer.innerHTML = sanitizeContent(message);
        errorContainer.style.display = "block";
    } else {
        // Sử dụng alert nếu không có container lỗi
        alert(message);
    }
}

/*******************************
 * Xử lý Phản hồi
 *******************************/

/**
 * Xử lý phản hồi AJAX thành công.
 * @param {Object} data - Dữ liệu phản hồi từ máy chủ.
 * @param {string} inputUrl - URL đầu vào ban đầu.
 */
function handleSuccessResponse(data, inputUrl) {
    document.getElementById("container").style.display = "block";
    document.getElementById("loading").style.display = "none";

    if (data.data) {
        const videoData = data.data;
        
        // Trích xuất dữ liệu cần thiết
        //const thumbnailUrl = videoData.thumbnail;
        const downloadUrls = videoData.downloads.map(download => download.url);
        const videoSource = videoData.source;
        const videoId = getYouTubeVideoIds(videoSource);
        const thumbnailUrl = videoId 
    ? `https://i.ytimg.com/vi/${videoId}/hqdefault.jpg`
    : videoData.thumbnail;
        // Tạo HTML cho video
        const videoHtml = `
    <video style='background: black url(${thumbnailUrl}) center center/cover no-repeat; width:100%; height:500px; border-radius:20px;' 
           poster='${thumbnailUrl}' controls playsinline>
        <source src='${videoData.downloads[5]?.url || ''}' type='video/mp4'>
        ${Array.isArray(downloadUrls) ? downloadUrls.map(url => `<source src='${url}' type='video/mp4'>`).join('') : ''}
        <source src='https://vkrdownloader.xyz/server/dl.php?vkr=${encodeURIComponent(inputUrl)}' type='video/mp4'>
    </video>`;
        const YTvideoHtml = `
            <video style='background: black url(${thumbnailUrl}) center center/cover no-repeat; width:100%; height:500px; border-radius:20px;' 
                   poster='${thumbnailUrl}' controls playsinline>
                 <source src='https://vkrdownloader.xyz/server/redirect.php?vkr=https://youtu.be/${videoId}' type='video/mp4'>
                 <source src='https://vkrdownloader.xyz/server/dl.php?vkr=${inputUrl}' type='video/mp4'>
                ${downloadUrls.map(url => `<source src='${url}' type='video/mp4'>`).join('')}
            </video>`;
        const titleHtml = videoData.title ? `<h3>${sanitizeContent(videoData.title)}</h3>` : "";
        const descriptionHtml = videoData.description ? `<h4><details><summary>Xem Mô tả</summary>${sanitizeContent(videoData.description)}</details></h4>` : "";
        const durationHtml = videoData.size ? `<h5>${sanitizeContent(videoData.size)}</h5>` : "";

        // Cập nhật các phần tử DOM
        if (videoId) {
            updateElement("thumb", YTvideoHtml);
        } else {
            updateElement("thumb", videoHtml);
        }
        updateElement("title", titleHtml);
        updateElement("description", descriptionHtml);
        updateElement("duration", durationHtml);

        // Tạo các nút tải xuống
        generateDownloadButtons(data, inputUrl);
    } else {
        displayError("Vấn đề: Không thể lấy liên kết tải xuống. Vui lòng kiểm tra URL và liên hệ với chúng tôi qua mạng xã hội @TheOfficialVKr.");
        document.getElementById("loading").style.display = "none";
    }
}

/**
 * Trích xuất ID video YouTube từ URL.
 * @param {string} url - URL YouTube.
 * @returns {string|null} - ID video hoặc null nếu không tìm thấy.
 */
function getYouTubeVideoIds(url) {
    const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
    const match = url.match(regex);
    return match ? match[1] : null;
}

/**
 * Hiển thị thông báo lỗi trong container.
 * @param {string} message - Thông báo lỗi cần hiển thị.
 */
function displayError(message) {
    const container = document.getElementById("container");
    container.innerHTML = `<div style="color: red;">${sanitizeContent(message)}</div>`;
}

/**
 * Làm sạch nội dung để ngăn chặn tấn công XSS.
 * @param {string} content - Nội dung cần làm sạch.
 * @returns {string} - Nội dung đã được làm sạch.
 */
function sanitizeContent(content) {
    return DOMPurify.sanitize(content);
}

/**
 * Tạo các nút tải xuống với màu sắc và nhãn động.
 * @param {Object} videoData - Dữ liệu video từ máy chủ.
 * @param {string} inputUrl - URL đầu vào ban đầu.
 */
function generateDownloadButtons(videoData, inputUrl) {
    const downloadContainer = document.getElementById("download");
    downloadContainer.innerHTML = "";
    downloadContainer.style.display = "grid";
    downloadContainer.style.gridTemplateColumns = "repeat(2, 1fr)";
    downloadContainer.style.gap = "30px";
    downloadContainer.style.justifyContent = "center";
    downloadContainer.style.maxWidth = "600px";
    downloadContainer.style.margin = "0 auto";

    if (videoData.data) {
        const videoSource = videoData.data.source;
        const videoId = getYouTubeVideoIds(videoSource);
        if (videoId) {
            const qualities = ["mp3", "360", "720", "1080"];
            const labels = ["Mp3", "Mp4 (360p)", "Mp4 (720p)", "Mp4 (1080p)"];
            qualities.forEach((quality, index) => {
                const iframeSrc = `https://vkrdownloader.xyz/server/dlbtn.php?q=${encodeURIComponent(quality)}&vkr=${encodeURIComponent(videoSource)}`;
                downloadContainer.innerHTML += `
                    <div style="text-align: center;">
                        <span style="display: block; font-size: 14px; margin-bottom: 5px;">${labels[index]}</span>
                        <iframe id="download-iframe-${index}" 
                                style="border: 0; outline: none; width: 200px; max-height: 45px; height: 45px !important; overflow: hidden;" 
                                sandbox="allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox allow-downloads allow-downloads-without-user-activation" 
                                scrolling="no"
                                src="${iframeSrc}">
                        </iframe>
                    </div>`;
            });
        }
    } else {
        displayError("Không tìm thấy liên kết tải xuống hoặc cấu trúc dữ liệu không đúng.");
        document.getElementById("loading").style.display = "none";
    }
    if (downloadContainer.innerHTML.trim() === "") {
        displayError("Máy chủ không hoạt động do quá nhiều yêu cầu. Vui lòng liên hệ chúng tôi qua mạng xã hội @TheOfficialVKr.");
        document.getElementById("container").style.display = "none";
    }
}