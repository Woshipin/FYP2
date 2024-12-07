@extends('frontend-auth.newlayout')

@section('frontend-section')

    {{-- Button CSS --}}
    {{-- <style>
        /* Style the WhatsApp icon */
        .btn-success {
            background-color: #25D366;
            padding: 12px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .btn-success i {
            font-size: 20px;
            color: white;
        }

        .btn-success:hover {
            background-color: #128C7E;
        }

        .btn-info {
            background-color: #FF0000;
            padding: 12px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .btn-info i {
            font-size: 20px;
            color: white;
        }

        .btn-info:hover {
            background-color: #E60000;
        }
    </style> --}}

    {{-- Responsible UI CSS --}}
    {{-- <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .product-price {
            margin-bottom: 20px;
        }

        .product-price p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .product-price .last-price {
            font-weight: bold;
        }

        .product-price .new-price {
            font-style: italic;
        }

        hr {
            border: 1px solid #000;
            margin: 20px 0;
        }

        .product-detail {
            margin-bottom: 20px;
            color: #333;
        }

        .product-detail h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #004080;
        }

        .product-detail p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
            color: black;
        }

        .product-detail h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: black;
        }

        @media (max-width: 600px) {

            .product-price p,
            .product-detail p {
                font-size: 14px;
            }

            .product-detail h2 {
                font-size: 20px;
            }

            .product-detail h3 {
                font-size: 16px;
            }
        }
    </style> --}}

    {{-- Mutliple Image UI CSS --}}
    {{-- <style>
        .product-imgs {
            width: 100%;
            max-width: 100%;
            margin: auto;
            position: relative;
        }

        .img-display {
            width: 100%;
            max-width: 100%;
            height: 500px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .swiper {
            width: 100%;
            max-width: 100%;
            height: 500px;
        }

        .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .swiper-slide img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
            margin: auto;
        }

        .img-placeholder {
            width: 100%;
            max-width: 100%;
            height: 500px;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: #666;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .swiper-container {
            position: relative;
            width: 100%;
            max-width: 100%;
            height: 500px;
            overflow: hidden;
        }

        @media (max-width: 768px) {

            .product-imgs,
            .img-display,
            .swiper,
            .swiper-container,
            .img-placeholder {
                height: 300px;
            }
        }

        @media (max-width: 480px) {

            .product-imgs,
            .img-display,
            .swiper,
            .swiper-container,
            .img-placeholder {
                height: 200px;
            }
        }
    </style> --}}

    {{-- show detail card UI CSS --}}
    {{-- <style>
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
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        /* Image Gallery */
        .image-gallery {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            padding: 0.5rem;
        }

        .thumbnail {
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .thumbnail:hover {
            opacity: 0.8;
        }

        /* Information Card */
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px var(--shadow-color);
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
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 1.5rem 0;
            padding: 1.5rem 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .highlight-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
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

        .star-rating {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            font-size: 1.5rem;
            color: #ddd;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input[type="radio"]:checked ~ label {
            color: var(--rating-color);
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
    </style> --}}

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

    {{-- Rating CSS --}}
    {{-- <style>
        .rating-css {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .rating-css div {
            color: #ffe400;
            font-size: 30px;
            font-family: sans-serif;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            padding: 20px 0;
        }

        .rating-css input {
            display: none;
        }

        .rating-css input+label {
            font-size: 60px;
            text-shadow: 1px 1px 0 #8f8420;
            cursor: pointer;
        }

        .rating-css input:checked+label~label {
            color: #b4afaf;
        }

        .rating-css label:active {
            transform: scale(0.8);
            transition: 0.3s ease;
        }

        .star-icon {
            display: flex;
            gap: 5px;
        }

        .submit-button {
            display: flex;
            justify-content: center;
        }

        .submit-button button {
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .rating-css div {
                font-size: 20px;
            }

            .rating-css input+label {
                font-size: 40px;
            }

            .submit-button button {
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .rating-css div {
                font-size: 18px;
            }

            .rating-css input+label {
                font-size: 30px;
            }

            .star-icon {
                gap: 3px;
            }

            .submit-button button {
                margin-top: 15px;
            }
        }
    </style> --}}

    {{-- 360 show image --}}
    {{-- <style>
        /* 为了使全景图像填满容器 */
        .photosphere-container {
            width: 100%;
            height: 400px;
            /* 调整高度以适应你的需要 */
        }

        /* 左中右三列布局 */
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
    </style> --}}

    {{-- Img 360 View --}}
    <!-- 引入 Photo Sphere Viewer 库 -->
    <script src="https://cdn.jsdelivr.net/npm/photo-sphere-viewer/dist/photo-sphere-viewer.min.js"></script>

    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    {{-- Mutliple Image Silder CSS and JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    {{-- toastify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <br>

    {{-- <div class="container">
        <!-- Resort Header -->
        <div class="resort-header">
            <div>
                <h1 class="resort-title">{{ $resort->name }}</h1>
                <div class="resort-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $resort->location }}</span>
                </div>
            </div>
            <div class="price-tag">
                <div class="price">RM{{ $resort->price }}/day</div>
                <div>We Price Match</div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Column - Images -->
            <div>
                <div class="image-gallery">
                    @if ($resort->images->isNotEmpty())
                        <img src="{{ asset('images/' . $resort->images[0]->image) }}" alt="Main resort view" class="main-image">
                        <div class="thumbnail-grid">
                            @foreach ($resort->images as $image)
                                <img src="{{ asset('images/' . $image->image) }}" alt="Resort view" class="thumbnail">
                            @endforeach
                        </div>
                    @else
                        <div class="main-image">No Image Available</div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Information -->
            <div>
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
                        <div class="highlight-item">
                            <i class="fas fa-map-marker-alt highlight-icon"></i>
                            <span>Ideal Location</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-utensils highlight-icon"></i>
                            <span>{{ $resort->type }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-phone highlight-icon"></i>
                            <span>{{ $resort->phone }}</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-envelope highlight-icon"></i>
                            <span>{{ $resort->email }}</span>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="amenities">
                        <div class="amenity-item">
                            <i class="fas fa-swimming-pool"></i>
                            <span>Swimming Pool</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-dumbbell"></i>
                            <span>Fitness Center</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-wifi"></i>
                            <span>Free WiFi</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-parking"></i>
                            <span>Parking Available</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ url('bookingresort/' . $resort->id) }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i>
                            Book Now
                        </a>
                        <a href="{{ route('resorts.contact', ['id' => $resort->id]) }}" class="btn btn-outline">
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
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                                <label for="star{{ $i }}" class="fas fa-star"></label>
                            @endfor
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <iframe src="{{ $resort->map }}" class="map-frame" allowfullscreen></iframe>
        </div>

    </div> --}}
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
    </div>

    <br><br>

    <!-- 引入 Photo Sphere Viewer 库 -->
    <script src="https://cdn.jsdelivr.net/npm/photo-sphere-viewer/dist/photo-sphere-viewer.min.js"></script>

    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    <!-- 引入Swiper的CSS和JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

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
