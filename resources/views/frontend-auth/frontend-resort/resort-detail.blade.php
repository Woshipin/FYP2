@extends('frontend-auth.newlayout')

@section('frontend-section')

    {{-- Show Detail Card UI CSS --}}
    <style>
        :root {
            --primary-color: #1a73e8;
            --secondary-color: #5f6368;
            --border-color: #dadce0;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --rating-color: #ffd700;
            --success-color: #34a853;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #202124;
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        /* Header Section */
        .resort-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .resort-title {
            font-size: 1.75rem;
            color: #202124;
            margin-bottom: 0.5rem;
        }

        .resort-location {
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .price-tag {
            text-align: right;
        }

        .price {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        /* Image Gallery */
        /* 图片容器 */
        .image-column {
            display: flex;
            flex-direction: column;
        }

        /* 图片展示框架 */
        .image-gallery {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px var(--shadow-color);
            flex-grow: 1;
        }

        /* 主图片样式 */
        .main-image {
            display: block;
            width: 100%;
            height: auto;
            object-fit: cover;
            /* 确保图片内容全部显示 */
            vertical-align: top;
        }

        /* 缩略图网格布局 */
        .thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            /* 5列布局 */
            gap: 0.5rem;
            margin: 0;
            /* 去除额外间距 */
            padding: 0;
            /* 去除内边距 */
        }

        /* 缩略图样式 */
        .thumbnail {
            position: relative;
            width: 100%;
            /* 填满父容器 */
            aspect-ratio: 1 / 1;
            /* 保持缩略图为正方形 */
            overflow: hidden;
            /* 隐藏多余部分 */
            border-radius: 8px;
            cursor: pointer;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* 填满容器，内容全部显示 */
        }

        /* 鼠标悬停效果 */
        .thumbnail:hover {
            opacity: 0.8;
        }

        /* View More 按钮 */
        .view-more {
            position: absolute;
            top: 0.5rem;
            /* 调整为图片顶部显示 */
            right: 0.5rem;
            background-color: rgba(0, 0, 0, 0.7);
            /* 背景半透明黑色 */
            color: white;
            padding: 0.3rem 0.5rem;
            font-size: 0.9rem;
            border-radius: 4px;
            cursor: pointer;
            z-index: 1;
            /* 确保按钮在图片之上 */
            display: none;
            /* 默认隐藏 */
        }

        /* 当到达第5张图片时显示 View More */
        .thumbnail:nth-child(10) .view-more {
            display: block;
        }


        /* Information Card */
        .info-column {
            display: flex;
            flex-direction: column;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px var(--shadow-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-bottom: 1rem;
        }

        .star {
            color: var(--rating-color);
        }

        .rating-count {
            color: var(--secondary-color);
            font-size: 0.875rem;
        }

        /* Highlights Section */
        .highlights {
            margin: 1.5rem 0;
            padding: 1.5rem 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .highlights table {
            width: 100%;
            border-collapse: collapse;
        }

        .highlights table td {
            padding: 0.75rem 0;
            font-size: 1.1rem;
            color: var(--secondary-color);
        }

        .highlights table td:first-child {
            width: 30px;
            text-align: center;
        }

        .highlight-icon {
            width: 24px;
            height: 24px;
            color: var(--primary-color);
        }

        /* Amenities Section */
        .amenities {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--secondary-color);
        }

        /* Action Buttons */
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1557b0;
        }

        .btn-outline {
            border: 1px solid var(--border-color);
            background-color: white;
            color: var(--secondary-color);
        }

        .btn-outline:hover {
            background-color: #f8f9fa;
        }

        /* Rating Modal */
        .rating-modal {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        .rating-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* 星星容器 */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            /* 倒序排列以配合 CSS 选择器逻辑 */
            gap: 0.5rem;
            justify-content: center;
        }

        /* 隐藏单选按钮 */
        .star-rating input[type="radio"] {
            display: none;
        }

        /* 星星默认样式 */
        .star-rating label {
            cursor: pointer;
            font-size: 2rem;
            /* 星星大小 */
            color: #ddd;
            /* 默认填充灰色 */
            /* text-shadow: 0 0 1px #000; */
            /* 添加黑色阴影边框效果 */
            /* -webkit-text-stroke: 1px black; */
            /* 添加黑色边框 */
            transition: color 0.2s ease-in-out, -webkit-text-stroke 0.2s ease-in-out;
        }

        /* 鼠标悬停时高亮当前及左侧的星星 */
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: var(--rating-color, gold);
            /* 设置星星高亮颜色，默认金色 */
        }

        /* 单选按钮选中时高亮当前及左侧的星星 */
        .star-rating input[type="radio"]:checked+label,
        .star-rating input[type="radio"]:checked+label~label {
            color: var(--rating-color, gold);
        }


        /* Map Section */
        .map-section {
            margin-top: 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        .map-frame {
            width: 100%;
            height: 450px;
            border: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .resort-header {
                flex-direction: column;
            }

            .price-tag {
                text-align: left;
                margin-top: 1rem;
            }

            .amenities {
                grid-template-columns: 1fr;
            }
        }

        /* 360 Image Modal */
        .photosphere-container {
            width: 100%;
            height: 400px;
        }

        .columns {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .column {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .column:not(:last-child) {
            margin-right: 20px;
        }

        @media (max-width: 768px) {
            .columns {
                flex-direction: column;
            }

            .column:not(:last-child) {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }

        /* Modal for additional images */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            border-radius: 12px;
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            padding: 0.5rem;
        }

        .modal-thumbnail {
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .modal-thumbnail:hover {
            opacity: 0.8;
        }

        span {
            font-size: large;
            color: black;
        }

        #detail {
            font-size: large;
            color: black;
        }

        #btn {
            font-size: 13px;
            color: white;
        }

        i {
            font-size: large;
        }

        #btncontact {
            font-size: 13px;
            color: black;
        }

        /* 360 Image Modal 样式 */
        #pannellumModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        #closeBtn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            /* 半透明白色 */
            color: #333;
            /* 深色文本 */

            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            /* 添加box-shadow过渡 */
            z-index: 2;
            /* 确保按钮在图片上面 */
        }

        #closeBtn:hover {
            background-color: rgba(255, 255, 255, 1);
            /* 鼠标悬停时变为完全不透明 */
            color: #ff4500;
            /* 鼠标悬停时文字颜色变为橙色 */
            transform: translateY(-5px);
            /* 向上浮动5px */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* 添加阴影效果，避免显示黑色边框 */
        }


        /* 图片显示区域 */
        #panorama {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
            background-color: black;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Three Column CSS --}}
    <style>
        /* :root {
                                            --primary-color: #333;
                                            --secondary-color: #666;
                                            --shadow-color: rgba(0, 0, 0, 0.1);
                                        }

                                        body {
                                            font-family: sans-serif;
                                            margin: 0;
                                            padding: 0;
                                            line-height: 1.6;
                                            color: var(--primary-color);
                                        }

                                        .container {
                                            max-width: 1200px;
                                            margin: 0 auto;
                                            padding: 1rem;
                                        } */

        /* Styles for the three-column section */
        .columns {
            display: flex;
            justify-content: space-between;
            margin: 2rem 0;
            gap: 1.5rem;
        }

        .column {
            flex: 1;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        .column h3 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .column-content {
            color: var(--secondary-color);
        }

        @media (max-width: 768px) {
            .columns {
                flex-direction: column;
            }
        }
    </style>

    {{-- Community CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- 引入 Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .community-button {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .community-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .community-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 1200px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .community-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .community-modal-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .community-stars {
            color: #ffc107;
            margin-left: 10px;
        }

        .community-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .community-close:hover,
        .community-close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .community-modal-body {
            display: flex;
            gap: 20px;
            height: calc(100vh - 200px);
            min-height: 500px;
        }

        .community-map-container {
            flex: 1;
            position: relative;
            height: 100%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .community-map-controls {
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
        }

        .community-map-button {
            background-color: white;
            border: 1px solid #ccc;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            border-radius: 4px;
        }

        .community-info-container {
            flex: 0 0 380px;
            overflow-y: auto;
            height: 100%;
            padding-right: 10px;
        }

        .community-info-container::-webkit-scrollbar {
            width: 8px;
        }

        .community-info-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .community-info-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .community-info-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .community-address {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            margin-bottom: 10px;
        }

        .community-icon {
            font-size: 18px;
        }

        .community-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .community-rating-score {
            background-color: #1a73e8;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }

        .community-rating-text {
            font-weight: 500;
        }

        .community-review-count {
            color: #666;
        }

        .community-select-rooms {
            width: 100%;
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .community-tabs {
            display: flex;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .community-tab {
            background-color: transparent;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .community-tab.active {
            border-bottom: 2px solid #1a73e8;
            color: #1a73e8;
        }

        .community-tab-content h3 {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .community-station-info {
            margin-bottom: 20px;
        }

        .community-station-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .community-station-card p {
            margin: 0 0 5px 0;
            font-size: 14px;
        }

        .community-station-card p:first-child {
            font-weight: 500;
        }

        .community-view-icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 24px;
            height: 24px;
            background-color: #f5f5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .community-view-icon:hover {
            background-color: #e0e0e0;
        }

        .community-view-icon:hover .community-tooltip {
            opacity: 1;
            visibility: visible;
        }

        .community-tooltip {
            position: absolute;
            bottom: 100%;
            right: 0;
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            margin-bottom: 5px;
        }

        .community-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            right: 10px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        .community-view-icon svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: #666;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        @media (max-width: 768px) {
            .community-modal-body {
                flex-direction: column;
            }

            .community-info-container {
                flex: 1;
            }

            .community-map-container {
                height: 300px;
            }
        }

        /* Add styles for tab content */
        .community-tab-content {
            display: none;
        }

        .community-tab-content.active {
            display: block;
        }
    </style>

    {{-- Img 360 View --}}
    <!-- 引入 Photo Sphere Viewer 库 -->
    <script src="https://cdn.jsdelivr.net/npm/photo-sphere-viewer/dist/photo-sphere-viewer.min.js"></script>

    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    {{-- toastify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <br>

    {{-- Show Resort Detail Card --}}
    <div class="container">
        <!-- Resort Header -->
        <div class="resort-header">
            <div>
                <h1 class="resort-title" id="detail">{{ $resort->name }}</h1>
                <div class="resort-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span id="detail">{{ $resort->location }}</span>
                </div>
            </div>
            <div class="price-tag">
                <div class="price" id="detail">RM{{ $resort->price }}/day</div>
                <div>We Price Match</div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Column - Images -->
            <div class="image-column">
                <div class="image-gallery">
                    @if ($resort->images->isNotEmpty())
                        <!-- 主图片显示 -->
                        <div class="main-image-container">
                            <img src="{{ asset('images/' . $resort->images->first()->image) }}" alt="Resort view"
                                class="main-image">
                        </div>
                        <!-- 缩略图网格 -->
                        <div class="thumbnail-grid">
                            @foreach ($resort->images->slice(1, 10) as $image)
                                <div class="thumbnail">
                                    <img src="{{ asset('images/' . $image->image) }}" alt="Resort view"
                                        onclick="show360Image('{{ asset('images/' . $image->image) }}')">
                                    <!-- 如果是第10张图片，显示 View More -->
                                    @if ($loop->index == 9 && $resort->images->count() > 10)
                                        <div class="view-more" id="viewMore">View More</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- 如果没有图片，显示提示 -->
                        <div class="main-image">No Image Available</div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Information -->
            <div class="info-column">
                <div class="info-card">
                    <!-- Rating -->
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star star"></i>
                        @endfor
                        <span class="rating-count">({{ $averageRating ?? '0' }})</span>
                    </div>

                    <!-- Highlights -->
                    <div class="highlights">
                        <table>
                            <tr>
                                <td><i class="fas fa-map-marker-alt highlight-icon"></i></td>
                                <td id="detail">Ideal Location</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-utensils highlight-icon"></i></td>
                                <td id="detail">Small Resort</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-phone highlight-icon"></i></td>
                                <td id="detail">75212121</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-envelope highlight-icon"></i></td>
                                <td id="detail">Abc@Gmail.Com</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Amenities -->
                    <div class="amenities">
                        <div class="amenity-item">
                            <i class="fas fa-swimming-pool"></i>
                            <span id="detail">Swimming Pool</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-dumbbell"></i>
                            <span id="detail">Fitness Center</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-wifi"></i>
                            <span id="detail">Free WiFi</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-parking"></i>
                            <span id="detail">Parking Available</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ url('bookingresort/' . $resort->id) }}" class="btn btn-primary" id="btn">
                            <i class="fas fa-calendar-check"></i>
                            Book Now
                        </a>
                        <a href="{{ route('resorts.contact', ['id' => $resort->id]) }}" class="btn btn-outline"
                            id="btncontact">
                            <i class="fas fa-envelope"></i>
                            Contact
                        </a>
                    </div>
                </div>

                <!-- Rating Form -->
                <div class="rating-modal">
                    <h3>Rate this Resort</h3>
                    <form action="{{ route('resortratings') }}" method="POST" class="rating-form">
                        @csrf
                        <input type="hidden" name="rateable_id" value="{{ $resort->id }}">
                        <input type="hidden" name="rateable_name" value="{{ $resort->name }}">
                        <input type="hidden" name="rateable_type" value="{{ $resort->type }}">

                        <div class="star-rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <!-- 倒序排列以支持CSS逻辑 -->
                                <input type="radio" name="rating" id="star{{ $i }}"
                                    value="{{ $i }}">
                                <label for="star{{ $i }}" class="fas fa-star"></label>
                            @endfor
                        </div>

                        <button type="submit" class="btn btn-primary" id="btn">Submit Rating</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Three Column Section -->
        <div class="columns">
            <!-- Comments Column -->
            <div class="column">
                <h3><i class="fas fa-comments"></i> Comments</h3>
                <div class="column-content">
                    <!-- Add your comments content here -->
                    <p>Guest reviews and comments will appear here</p>
                </div>
            </div>

            <!-- Facility Column -->
            <div class="column">
                <h3><i class="fas fa-building"></i> Facility</h3>
                <div class="column-content">
                    <!-- Add your facility content here -->
                    <p>Resort facilities and amenities details</p>
                </div>
            </div>

            <!-- Community Column -->
            <div class="column" id="community-column">
                <h3><i class="fas fa-users"></i> Community</h3>
                <div class="column-content">
                    <!-- Add your community content here -->
                    <p>Community information and activities</p>
                </div>
            </div>

        </div>

        <!-- Map Section -->
        <div class="map-section">
            <iframe src="{{ $resort->map }}" class="map-frame" allowfullscreen></iframe>
        </div>

        <!-- 360 Image Modal -->
        <div id="pannellumModal" style="display: none;">
            <!-- Close 按钮放置在右上角 -->
            <button onclick="close360View()" id="closeBtn">Close</button>
            <div id="panorama" class="photosphere-container"></div>
        </div>

        <!-- Modal for additional images -->
        <div id="imageModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="modal-thumbnail-grid">
                    @foreach ($resort->images->slice(10) as $image)
                        <div class="modal-thumbnail">
                            <img src="{{ asset('images/' . $image->image) }}" alt="Resort view">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Modal for Community --}}
        <div id="community-modal" class="community-modal">
            <div class="community-modal-content">
                <div class="community-modal-header">
                    <h2>{{ $resort->name }}<span class="community-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star star"></i>
                            @endfor
                        </span></h2>
                    <span class="community-close">&times;</span>
                </div>
                <div class="community-modal-body">

                    {{-- <div class="community-map-container">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox=103.62410736083984%2C1.5447807095870226%2C103.6279067993164%2C1.547779402397805&layer=mapnik"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        <div class="community-map-controls">
                            <button class="community-map-button">+</button>
                            <button class="community-map-button">-</button>
                        </div>
                    </div> --}}

                    <div class="community-map-container" id="map" style="width: 100%; height: 500px; border: 0;">
                        <!-- 地图显示区域 -->
                    </div>

                    <!-- 控制按钮 -->
                    <div class="community-map-controls">
                        <button class="community-map-button">+</button>
                        <button class="community-map-button">-</button>
                    </div>

                    <div class="community-info-container">
                        <p class="community-address" id="detail"><span class="community-icon">📍</span>{{ $resort->location }}</p>
                        <div class="community-rating">
                            <span class="community-rating-score">{{ $averageRating ?? '0' }}</span>
                            {{-- <span class="community-rating-text">{{ $resort->location }}</span> --}}
                            <span class="community-review-count" id="detail">• 1,318 reviews</span>
                        </div>
                        {{-- <button class="community-select-rooms">Select Rooms</button> --}}
                        <div class="community-tabs">
                            <button class="community-tab active" data-tab="community-transport">Transport</button>
                            <button class="community-tab" data-tab="community-landmarks">Landmarks</button>
                            <button class="community-tab" data-tab="community-dining">Dining</button>
                            <button class="community-tab" data-tab="community-shopping">Shopping</button>
                        </div>

                        <!-- Transport tab content -->
                        <div class="community-tab-content active" id="community-transport">
                            <h3><span class="community-icon">🚇</span> Metro station</h3>
                            <div class="community-station-info">
                                <div class="community-station-card">
                                    <p><strong>Somerset</strong></p>
                                    <p>About 7 mins from hotel by foot (440m)</p>
                                    <div class="community-view-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span class="community-tooltip">View more</span>
                                    </div>
                                </div>
                                <!-- Other transport content remains the same -->
                            </div>
                        </div>

                        <!-- Landmarks tab content -->
                        <div class="community-tab-content" id="community-landmarks">
                            <h3><span class="community-icon">🏛️</span> Notable Landmarks</h3>
                            <div class="community-station-info">
                                <div class="community-station-card">
                                    <p><strong>Orchard Road Shopping District</strong></p>
                                    <p>1 min walk from hotel (100m)</p>
                                    <div class="community-view-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span class="community-tooltip">View more</span>
                                    </div>
                                </div>
                                <div class="community-station-card">
                                    <p><strong>ION Orchard</strong></p>
                                    <p>5 mins walk from hotel (400m)</p>
                                    <div class="community-view-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span class="community-tooltip">View more</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dining and Shopping tab content would go here -->
                        <div class="community-tab-content" id="community-dining">
                            <h3><span class="community-icon">🚇</span> Metro station</h3>
                            <div class="community-station-info">
                                <div class="community-station-card">
                                    <p><strong>Somerset</strong></p>
                                    <p>About 7 mins from hotel by foot (490m)</p>
                                    <div class="community-view-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span class="community-tooltip">View more</span>
                                    </div>
                                </div>
                                <!-- Other transport content remains the same -->
                            </div>
                        </div>

                        <div class="community-tab-content" id="community-shopping">
                            <h3><span class="community-icon">🚇</span> Metro station</h3>
                            <div class="community-station-info">
                                <div class="community-station-card">
                                    <p><strong>Somerset</strong></p>
                                    <p>About 7 mins from hotel by foot (450m)</p>
                                    <div class="community-view-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span class="community-tooltip">View more</span>
                                    </div>
                                </div>
                                <!-- Other transport content remains the same -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <br><br>

    <!-- 引入 Photo Sphere Viewer 库 -->
    <script src="https://cdn.jsdelivr.net/npm/photo-sphere-viewer/dist/photo-sphere-viewer.min.js"></script>

    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    {{-- 360 and Modal Function --}}
    <script>
        // 显示360度视图
        function show360Image(imageUrl) {
            const modal = document.getElementById('pannellumModal');
            const panoramaContainer = document.getElementById('panorama');

            // 显示模态框
            modal.style.display = 'block';

            // 清空之前的内容，防止重复初始化
            panoramaContainer.innerHTML = '';

            // 初始化Pannellum
            pannellum.viewer('panorama', {
                type: 'equirectangular',
                panorama: imageUrl,
                autoLoad: true,
                autoRotate: -2, // 自动旋转速度，可选
                showFullscreenCtrl: true // 显示全屏按钮
            });
        }

        // 关闭360度视图
        function close360View() {
            document.getElementById('pannellumModal').style.display = 'none';
        }

        // 显示更多图片模态框
        document.getElementById('viewMore').addEventListener('click', function() {
            document.getElementById('imageModal').style.display = 'block';
        });

        // 关闭模态框
        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('imageModal').style.display = 'none';
        });

        // 点击模态框外部关闭模态框
        window.addEventListener('click', function(event) {
            var modal = document.getElementById('imageModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    </script>

    {{-- Community JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- 引入 Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    {{-- Community Modal JS --}}
    <script>
        const communityModal = document.getElementById("community-modal");
        const communityColumn = document.getElementById("community-column"); // 选择 community-column 元素
        const communitySpan = document.getElementsByClassName("community-close")[0];

        communityColumn.onclick = function() {
            communityModal.style.display = "block"; // 点击列时显示modal
        }

        communitySpan.onclick = function() {
            communityModal.style.display = "none"; // 关闭modal
        }

        window.onclick = function(event) {
            if (event.target == communityModal) {
                communityModal.style.display = "none"; // 点击 modal 外部区域时关闭modal
            }
        }

        // Updated tab functionality
        const communityTabs = document.querySelectorAll('.community-tab');
        const communityTabContents = document.querySelectorAll('.community-tab-content');

        communityTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                communityTabs.forEach(t => t.classList.remove('active'));
                communityTabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab
                tab.classList.add('active');

                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
    {{-- Community Modal Map JS --}}
    <script>
        // 获取 PHP 传递的经纬度
        var latitude = {{ $resort->latitude }};
        var longitude = {{ $resort->longitude }};

        // 初始化地图并设置中心和缩放级别
        var map = L.map('map').setView([latitude, longitude], 14);

        // 使用 OpenStreetMap 作为地图图层
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // 在指定位置添加标记
        var marker = L.marker([latitude, longitude]).addTo(map);

        // 设置标记的弹出信息
        marker.bindPopup("<b>{{ $resort->name }}</b><br>Location: {{ $resort->latitude }}, {{ $resort->longitude }}")
            .openPopup();
    </script>

    {{-- Toastr New JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- New Toastr --}}
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
