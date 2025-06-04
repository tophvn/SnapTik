function isValidUrl(url, platform) {
    const patterns = {
        tiktok: /^(https?:\/\/(vt\.tiktok\.com|www\.tiktok\.com)\/)/,
        douyin: /^(https?:\/\/v\.douyin\.com\/)/,
        facebook: /^(https?:\/\/(www\.facebook\.com|fb\.com)\/(videos|reel|watch|share)\/)/
    };
    return patterns[platform].test(url);
}

async function handleSubmit(event, platform) {
    event.preventDefault();
    const urlInput = document.getElementById('url').value.trim();
    const downloadDiv = document.getElementById('download');
    const messageBody = document.querySelector('.message-body');
    const loader = document.querySelector('.get-loader');

    if (!urlInput) {
        messageBody.textContent = 'Vui lòng nhập URL video!';
        messageBody.parentElement.style.display = 'block';
        return false;
    }

    if (!isValidUrl(urlInput, platform)) {
        messageBody.textContent = `URL ${platform} không hợp lệ! Vui lòng kiểm tra lại.`;
        messageBody.parentElement.style.display = 'block';
        return false;
    }

    const encodedUrl = encodeURIComponent(urlInput);
    const apiBaseUrl = 'proxy.php'; // Sử dụng proxy để tránh CORS
    const infoUrl = `${apiBaseUrl}?endpoint=info&url=${encodedUrl}`;

    try {
        loader.style.display = 'flex';
        downloadDiv.innerHTML = '';

        const response = await fetch(infoUrl, { method: 'GET' });
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            const errorMessage = errorData.error?.message || `Lỗi HTTP! Status: ${response.status}`;
            throw new Error(errorMessage);
        }

        const data = await response.json();
        if (!data.success || !data.videoUrl) {
            throw new Error(data.error?.message || 'Không thể tải metadata video. Vui lòng kiểm tra URL.');
        }

        downloadDiv.innerHTML = `
            <div class="video-preview">
                <video controls poster="${data.cover || ''}">
                    <source src="${data.videoUrl}" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ video.
                </video>
                <div class="video-info">
                    <h4>${data.title || 'Video'}</h4>
                    <p>Author: ${data.author || 'Unknown'}</p>
                    <p>Description: ${data.description || 'No description'}</p>
                    <a href="${data.videoUrl}" download="${platform}_${data.id || 'video'}.mp4" class="button button-go is-link">
                        <i class="icon icon-down"></i> Tải xuống
                    </a>
                </div>
            </div>
        `;
        messageBody.parentElement.style.display = 'none';
    } catch (error) {
        console.error('Fetch error:', error);
        let errorMessage = error.message || 'Không thể kết nối đến API. Vui lòng thử lại sau.';
        if (errorMessage.includes('Cloudflare')) {
            errorMessage = 'Lỗi server API (Cloudflare Worker). Vui lòng thử URL TikTok khác hoặc liên hệ izgit.com.';
        }
        messageBody.textContent = `Lỗi: ${errorMessage}`;
        messageBody.parentElement.style.display = 'block';
        downloadDiv.innerHTML = '';
    } finally {
        loader.style.display = 'none';
    }

    return false;
}

async function pasteUrl() {
    try {
        const url = await navigator.clipboard.readText();
        document.getElementById('url').value = url;
    } catch (error) {
        console.error('Failed to paste:', error);
    }
}

document.querySelectorAll('.btn-accordion').forEach(button => {
    button.addEventListener('click', () => {
        const content = button.nextElementSibling;
        content.style.display = content.style.display === 'block' ? 'none' : 'block';
        button.querySelector('.arrow').classList.toggle('active');
    });
});