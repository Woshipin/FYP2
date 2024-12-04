@extends('backend-user.newlayout')

@section('newuser-section')
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    {{-- Modal CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <style>
        /* Modal 通用样式 */
        .modal-dialog {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            border-radius: 12px;
            padding: 20px;
            /* Adjust padding as needed */
            max-height: 80vh;
            overflow-y: auto;
            max-width: 800px;
            /* 增加宽度 */
        }

        /* Modal Header */
        .modal-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #ddd;
        }

        /* Form 样式优化 */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        /* 自适应文件上传框 */
        .file-upload {
            border: 2px dashed #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 6px;
            cursor: pointer;
        }

        /* 提交按钮样式 */
        .submit-button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
        }

        .submit-button:hover {
            background-color: #1d4ed8;
        }

        /* 自定义滚动条 */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #666;
        }
    </style> --}}
    <style>
        /* Modal 通用样式 */
        .modal-lg {
            max-width: 900px;
            /* 增加Modal宽度 */
        }

        .modal-content {
            border-radius: 12px;
            padding: 20px;
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Form 样式优化 */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        /* 自适应文件上传框 */
        .file-upload {
            border: 2px dashed #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 6px;
            cursor: pointer;
        }

        /* 提交按钮样式 */
        .submit-button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
        }

        .submit-button:hover {
            background-color: #1d4ed8;
        }

        /* 自定义滚动条 */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #666;
        }
    </style>

    {{-- Form CSS --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            background-color: #fff;
            /* padding: 2rem; */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .community-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .community-item {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .community-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            cursor: pointer;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
        }

        .community-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #64748b;
        }

        .community-details h2 {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
            color: #1e293b;
        }

        .member-count {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        .chevron {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .community-item.expanded .chevron {
            transform: rotate(180deg);
        }

        .community-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .community-item.expanded .community-content {
            max-height: 1000px;
        }

        .content-inner {
            padding: 0 1.5rem 1.5rem;
        }

        .community-description {
            color: #475569;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .image-grid-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: none;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        .image-grid-nav.prev {
            left: -1rem;
        }

        .image-grid-nav.next {
            right: -1rem;
        }

        .grid-image {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 0.5rem;
            background-color: #f1f5f9;
        }

        .tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .tag {
            background-color: #f1f5f9;
            color: #475569;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .member-count svg {
            width: 16px;
            height: 16px;
        }

        /* New Styles for Modal */
        .button {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s ease-in-out;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
            pointer-events: all;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 600;
            color: #111;
        }

        .modal-description {
            color: #666;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .close-button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            padding: 4px;
            transition: color 0.2s;
        }

        .close-button:hover {
            color: #111;
        }

        /* Additional styles for forms, buttons, and image uploads */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input::placeholder,
        textarea::placeholder {
            color: #999;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .coordinates {
            display: flex;
            gap: 20px;
        }

        .coordinates .form-group {
            flex: 1;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .file-upload {
            border: 2px dashed #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
        }

        .file-upload input[type="file"] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload p {
            margin: 0;
            color: #777;
            pointer-events: none;
            /* 防止文本拦截点击事件 */
        }

        .file-upload:hover {
            border-color: #2563eb;
            background-color: rgba(37, 99, 235, 0.05);
        }

        .submit-button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            margin-top: 12px;
            transition: background-color 0.2s;
        }

        .submit-button:hover {
            background-color: #1d4ed8;
        }

        .resort-list {
            margin-top: 20px;
        }

        .resort-list ul {
            list-style: none;
            padding: 0;
        }

        .resort-list li {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .resort-list li:hover {
            background-color: #f0f0f0;
        }

        .resort-details {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .resort-details.active {
            display: block;
        }

        .resort-details p {
            margin-bottom: 10px;
        }

        .view-icon {
            cursor: pointer;
            font-size: 20px;
            color: #666;
            transition: color 0.2s;
        }

        .view-icon:hover {
            color: #111;
        }

        .active-indicator {
            font-size: 12px;
            color: #666;
            margin-left: 10px;
        }

        .add-button {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            color: #111;
            transition: all 0.2s;
        }

        .add-button:hover {
            background-color: #f0f0f0;
        }

        /* Add styles for image preview */
        .image-preview-container {
            border: 1px solid #000;
            border-radius: 6px;
            padding: 10px;
            min-height: 100px;
            margin-top: 10px;
        }

        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <div class="container">

        <h1>Community</h1><br>

        <!-- Button to trigger the modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#resortModal">
            Add New Resort
        </button>

        <br><br>

        {{-- Show Community --}}
        <div class="community-list">
            @foreach ($communities as $community)
                <div class="community-item">
                    <button class="community-header">
                        <div class="community-info">
                            <!-- Display first letter of community name as avatar -->
                            <div class="avatar">{{ strtoupper(substr($community->name, 0, 1)) }}</div>
                            <div class="community-details">
                                <h2>{{ $community->name }}</h2>
                                <div class="member-count">
                                    <!-- SVG icon for member count -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    @foreach (explode(',', $community->category) as $category)
                                        <span class="tag">{{ $category }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="community-content">
                        <div class="content-inner">
                            <!-- Community Description -->
                            <p class="community-description">{{ $community->description }}</p>
                            
                            <div class="image-grid">
                                <button class="image-grid-nav prev">&lt;</button>

                                <!-- Debugging: Display the paths -->
                                @foreach ($community->multipleImages as $image)
                                    <p>{{ $image->image_path }}</p>  <!-- Check if image paths are correct -->
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $community->name }}" class="grid-image">
                                @endforeach

                                <button class="image-grid-nav next">&gt;</button>
                            </div>


                            <div class="tags">
                                <!-- Loop through categories -->
                                @foreach (explode(',', $community->category) as $category)
                                    <span class="tag">{{ $category }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Bootstrap Add Community Modal -->
        <div class="modal fade" id="resortModal" tabindex="-1" role="dialog" aria-labelledby="resortModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"> <!-- 使用modal-lg类来增加宽度 -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resortModalLabel">Add New Resort</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="resortForm" action="{{ route('resort.community.save', ['id' => $id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" placeholder="Enter resort name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" name="category" required>
                                    <option value="transport">Transport</option>
                                    <option value="community">Community</option>
                                    <option value="social">Social</option>
                                    <option value="cultural">Cultural</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Images</label>
                                <div class="file-upload">
                                    <input type="file" id="image" name="image[]" accept="image/*" multiple
                                        required>
                                    <p>Click or drag images here to upload</p>
                                </div>
                                <div class="image-preview-container" id="imagePreview">
                                    <p>No image selected</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cultural">Cultural Information</label>
                                <textarea id="cultural" name="cultural" placeholder="Enter cultural information" rows="5" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="location">Address</label>
                                <textarea id="location" name="address" placeholder="Enter address" rows="5" required></textarea>
                            </div>

                            <div class="coordinates">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="number" id="latitude" name="latitude" placeholder="0"
                                        step="0.0000001" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="number" id="longitude" name="longitude" placeholder="0"
                                        step="0.0000001" required readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" placeholder="Enter description" rows="5" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary submit-button">Save Resort</button>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- JS Code --}}
    <script>
        // Handle expand/collapse functionality
        const communityHeaders = document.querySelectorAll('.community-header');

        communityHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const communityItem = header.closest('.community-item');
                communityItem.classList.toggle('expanded');
            });
        });

        // Handle image grid navigation
        document.querySelectorAll('.image-grid').forEach(grid => {
            const images = Array.from(grid.querySelectorAll('.grid-image'));
            const prevBtn = grid.querySelector('.prev');
            const nextBtn = grid.querySelector('.next');
            let currentPage = 0;
            const imagesPerPage = 3;
            const totalPages = Math.ceil(images.length / imagesPerPage);

            function showImages(page) {
                const start = page * imagesPerPage;
                const end = start + imagesPerPage;

                images.forEach((img, index) => {
                    if (index >= start && index < end) {
                        img.style.display = 'block';
                    } else {
                        img.style.display = 'none';
                    }
                });
            }

            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = (currentPage - 1 + totalPages) % totalPages;
                showImages(currentPage);
            });

            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = (currentPage + 1) % totalPages;
                showImages(currentPage);
            });

            // Show initial images
            showImages(0);
        });

        document.addEventListener('DOMContentLoaded', () => {
            // 初始化图片上传与预览功能
            initializeImageUpload();

            // 初始化表单提交处理
            // initializeFormSubmission();
        });

        /**
         * 初始化图片上传与预览功能
         */
        function initializeImageUpload() {
            const imageInput = document.getElementById('image');
            const previewContainer = document.getElementById('imagePreview');
            const maxFileSize = 5 * 1024 * 1024; // 5MB

            imageInput.addEventListener('change', function(event) {
                const files = event.target.files;
                previewContainer.innerHTML = ''; // 清空旧内容

                if (files.length === 0) {
                    previewContainer.innerHTML = '<p>No image selected</p>';
                    return;
                }

                Array.from(files).forEach((file, index) => {
                    // 检查是否为图片文件
                    if (!file.type.startsWith('image/')) {
                        alert(`File "${file.name}" is not a valid image.`);
                        return;
                    }

                    // 检查文件大小
                    if (file.size > maxFileSize) {
                        alert(`File "${file.name}" exceeds the 5MB size limit.`);
                        return;
                    }

                    const reader = new FileReader();

                    // 加载图片并显示预览
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        img.title = `Image ${index + 1}`;
                        img.style.maxWidth = '100px';
                        img.style.margin = '5px';
                        img.style.borderRadius = '8px';
                        img.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)';
                        img.style.cursor = 'pointer';

                        // 添加删除图片功能
                        img.addEventListener('click', () => {
                            if (confirm(`Remove "${file.name}" from upload?`)) {
                                img.remove();
                            }
                        });

                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                });
            });
        }

        /**
         * 初始化表单提交逻辑
         */
        // function initializeFormSubmission() {
        //     const form = document.getElementById("resortForm");

        //     form.addEventListener('submit', function(e) {
        //         e.preventDefault();

        //         // 检查表单是否有效
        //         if (!form.checkValidity()) {
        //             alert('Please fill in all required fields.');
        //             return;
        //         }

        //         // 获取表单数据
        //         const formData = new FormData(form);

        //         // 模拟数据保存逻辑
        //         console.log('Form Data:', Object.fromEntries(formData.entries()));
        //         alert('Resort saved successfully!');

        //         // 关闭模态框
        //         const modal = bootstrap.Modal.getInstance(document.getElementById('resortModal'));
        //         modal.hide();

        //         // 重置表单
        //         form.reset();

        //         // 清空图片预览
        //         document.getElementById('imagePreview').innerHTML = '<p>No image selected</p>';
        //     });
        // }
    </script>

    {{-- Get Coordinates --}}
    <script>
        document.getElementById('location').addEventListener('input', function() {
            const address = this.value.trim();

            // 如果地址为空，清空经纬度输入框
            if (address === '') {
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
                return;
            }

            // 调用 Nominatim API 获取地理编码数据
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`, {
                    headers: {
                        'User-Agent': 'YourAppName/1.0 (YourContactEmail)', // 替换为你的应用信息
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        // 获取第一个结果的经纬度信息
                        const location = data[0];
                        document.getElementById('latitude').value = location.lat;
                        document.getElementById('longitude').value = location.lon;
                    } else {
                        // 地址未找到时清空输入框
                        document.getElementById('latitude').value = '';
                        document.getElementById('longitude').value = '';
                        console.error('No results found for the given address.');
                    }
                })
                .catch(error => {
                    // 捕获网络错误并清空输入框
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                    console.error('Error fetching geocoding data:', error);
                });
        });
    </script>
    {{-- <script>
        // 防抖机制，用于减少 API 调用次数
        let debounceTimer;

        document.getElementById('location').addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                let address = this.value.trim();

                // 清理字符串：移除特殊字符和前导符号
                address = address.replace(/^-|[^a-zA-Z0-9\s,]/g, '');

                // 尝试简化地址，仅保留主要部分
                const simplifiedAddress = address.split(',').slice(0, 3).join(',');

                // 如果地址为空，清空经纬度输入框
                if (address === '') {
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                    return;
                }

                // 调用 Nominatim API
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(simplifiedAddress)}&countrycodes=my`, {
                        headers: {
                            'User-Agent': 'YourAppName/1.0 (ahpin7762@gmail.com)',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const sortedData = data.sort((a, b) => b.importance - a.importance);
                            const location = sortedData[0];

                            // 填入经纬度
                            document.getElementById('latitude').value = location.lat;
                            document.getElementById('longitude').value = location.lon;
                        } else {
                            // 未找到结果，清空经纬度输入框
                            document.getElementById('latitude').value = '';
                            document.getElementById('longitude').value = '';
                            console.error('No results found for the given address.');
                        }
                    })
                    .catch(error => {
                        document.getElementById('latitude').value = '';
                        document.getElementById('longitude').value = '';
                        console.error('Error fetching geocoding data:', error);
                    });
            }, 500); // 防抖延迟 500 毫秒
        });
    </script> --}}

    {{-- Toastr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)"
                }
            }).showToast();
        @elseif (Session::has('fail'))
            Toastify({
                text: "{{ Session::get('fail') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endif

        @if (Session::has('error'))
            Toastify({
                text: "{{ Session::get('error') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toastify({
                    text: "{{ $error }}",
                    duration: 10000,
                    style: {
                        background: "linear-gradient(to right, #b90000, #c99396)"
                    }
                }).showToast();
            @endforeach
        @endif
    </script>
@endsection
