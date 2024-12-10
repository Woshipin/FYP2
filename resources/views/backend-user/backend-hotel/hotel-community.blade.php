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

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Modal CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .hotel-list {
            margin-top: 20px;
        }

        .hotel-list ul {
            list-style: none;
            padding: 0;
        }

        .hotel-list li {
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

        .hotel-list li:hover {
            background-color: #f0f0f0;
        }

        .hotel-details {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .hotel-details.active {
            display: block;
        }

        .hotel-details p {
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

    {{-- Action CSS --}}
    <style>
        .community-content {
            position: relative;
        }

        .action-icons {
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }

        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
            width: 24px;
            height: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            /* 为悬浮文字定位 */
        }

        .icon-button svg {
            width: 20px;
            height: 20px;
            color: #666;
            transition: color 0.3s ease;
        }

        .icon-button:hover svg {
            color: #000;
        }

        /* 添加悬浮时的文字显示在图标上方 */
        .icon-button::after {
            content: attr(title);
            /* 通过 title 属性显示文字 */
            position: absolute;
            top: -25px;
            /* 文字显示在图标上方 */
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .icon-button:hover::after {
            opacity: 1;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="container">

        <h1>Community</h1><br>

        <!-- Button to trigger the modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hotelModal">
            Add New Hotel Community
        </button>

        <br><br>

        {{-- Show Community --}}
        <div class="community-list">
            @foreach ($communities as $community)
                <div class="community-item">
                    <button class="community-header">
                        <div class="community-info">
                            <!-- Display first letter of community name as avatar -->
                            {{-- <div class="avatar">{{ strtoupper(substr($community->name, 0, 1)) }}</div> --}}
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
                            <p class="community-address">{{ $community->cultural }}</p>
                            <p class="community-address">{{ $community->address }}</p>

                            <div class="image-grid">
                                <!-- Left navigation button -->
                                <button class="image-grid-nav prev">&lt;</button>

                                <!-- Community images -->
                                @foreach ($community->multipleImages as $image)
                                    <img src="{{ $image->full_image_path }}" alt="{{ $community->name }}"
                                        class="grid-image">
                                @endforeach

                                <!-- Right navigation button -->
                                <button class="image-grid-nav next">&gt;</button>
                            </div>

                            <br>

                            {{-- <div class="tags">
                                <!-- Loop through categories -->
                                @foreach (explode(',', $community->category) as $category)
                                    <span class="tag">{{ $category }}</span>
                                @endforeach
                            </div> --}}
                        </div>

                        <!-- Edit and Delete icons as buttons -->
                        <div class="action-icons">

                            <!-- Edit Button -->
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#hotelEditModal{{ $community->id }}">
                                <i class="fa fa-edit"></i>&nbsp;Edit
                            </a>

                            <!-- Delete button -->
                            <a onclick="return confirm('Are you sure to delete this data?')"
                                href="{{ route('hotel.community.delete', $community->id) }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>&nbsp;Delete
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bootstrap Add Community Modal -->
        <div class="modal fade" id="hotelModal" tabindex="-1" role="dialog" aria-labelledby="hotelModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"> <!-- 使用modal-lg类来增加宽度 -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hotelModalLabel">Add New Hotel Community</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="hotelForm" action="{{ route('hotel.community.save', ['id' => $id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" placeholder="Enter community name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="communitycategory" class="form-label">Community Category</label>
                                <select class="form-control" name="category">
                                    <option value="">---------Select Community Categories---------</option>
                                    @foreach ($communitycategorys as $communitycategory)
                                        <option value="{{ $communitycategory->name }}">{{ $communitycategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="imageAdd">Images</label>
                                <div class="file-upload">
                                    <input type="file" id="imageAdd" name="image[]" accept="image/*" multiple
                                        required>
                                    <p>Click or drag images here to upload</p>
                                </div>
                                <div class="image-preview-container" id="imagePreviewAdd">
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

                            <button type="submit" class="btn btn-primary submit-button">Save Community</button>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamically Generated Edit Community Modal -->
        @foreach ($communities as $community)
            <div class="modal fade" id="hotelEditModal{{ $community->id }}" tabindex="-1" role="dialog"
                aria-labelledby="hotelEditModalLabel{{ $community->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="hotelEditModalLabel{{ $community->id }}">
                                Edit Community
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="hotelEditForm{{ $community->id }}"
                                action="{{ route('hotel.community.update', $community->id) }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="id" value="{{ $community->id }}" />

                                <div class="form-group">
                                    <label for="name{{ $community->id }}">Name</label>
                                    <input type="text" id="name{{ $community->id }}" name="name"
                                        value="{{ $community->name }}" class="form-control"
                                        placeholder="Enter hotel name" required />
                                </div>

                                <div class="form-group">
                                    <label for="communitycategory" class="form-label">Community Category</label>
                                    <select class="form-control" name="category">
                                        <option value="">---------Select Community Categories---------</option>
                                        @foreach ($communitycategorys as $communitycategory)
                                            <option value="{{ $communitycategory->name }}"
                                                {{ $communitycategory->id ? 'selected' : '' }}>
                                                {{ $communitycategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="image{{ $community->id }}">Images</label>
                                    <div class="file-upload">
                                        <input type="file" id="image{{ $community->id }}" name="image[]"
                                            accept="image/*" multiple>
                                        <p>Click or drag images here to upload</p>
                                    </div>
                                    <div class="image-preview-container" id="imagePreview{{ $community->id }}">
                                        <p>No image selected</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cultural{{ $community->id }}">Cultural Information</label>
                                    <textarea id="cultural{{ $community->id }}" name="cultural" placeholder="Enter cultural information"
                                        rows="5">{{ $community->cultural ?? '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="location{{ $community->id }}">Address</label>
                                    <textarea id="location{{ $community->id }}" name="address" placeholder="Enter address" rows="5">{{ $community->address ?? '' }}</textarea>
                                </div>

                                <div class="coordinates">
                                    <div class="form-group">
                                        <label for="latitude{{ $community->id }}">Latitude</label>
                                        <input type="number" id="latitude{{ $community->id }}" name="latitude"
                                            placeholder="0" step="0.0000001" required readonly
                                            value="{{ $community->latitude ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="longitude{{ $community->id }}">Longitude</label>
                                        <input type="number" id="longitude{{ $community->id }}" name="longitude"
                                            placeholder="0" step="0.0000001" required readonly
                                            value="{{ $community->longitude ?? '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description{{ $community->id }}">Description</label>
                                    <textarea id="description{{ $community->id }}" name="description" placeholder="Enter description" rows="5">{{ $community->description ?? '' }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary submit-button">
                                    Update Community
                                </button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Select2 JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#communitycategory').select2({
                placeholder: "Select Community Categories",
                allowClear: true
            });
        });
    </script>

    {{-- JS Code --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // 初始化展开/折叠功能
            initializeCommunityToggle();

            // 初始化图片网格导航
            initializeImageGridNavigation();

            // 初始化图片上传与预览功能
            initializeImageUpload();

            // 加载数据库中的现有图片
            loadExistingImages();

            // 初始化动态模态框
            initializeModals();

            // 编辑时初始化已选择图片
            initializeEditImageSelection();
        });

        /**
         * 初始化展开/折叠功能
         */
        function initializeCommunityToggle() {
            const communityHeaders = document.querySelectorAll(".community-header");

            communityHeaders.forEach((header) => {
                header.addEventListener("click", () => {
                    const communityItem = header.closest(".community-item");
                    communityItem.classList.toggle("expanded");
                });
            });
        }

        /**
         * 初始化图片网格导航（分页显示）
         */
        function initializeImageGridNavigation() {
            document.querySelectorAll(".image-grid").forEach((grid) => {
                const images = Array.from(grid.querySelectorAll(".grid-image"));
                const prevBtn = grid.querySelector(".prev");
                const nextBtn = grid.querySelector(".next");
                let currentPage = 0;
                const imagesPerPage = 3;
                const totalPages = Math.ceil(images.length / imagesPerPage);

                function showImages(page) {
                    const start = page * imagesPerPage;
                    const end = start + imagesPerPage;

                    images.forEach((img, index) => {
                        img.style.display = index >= start && index < end ? "block" : "none";
                    });
                }

                if (prevBtn && nextBtn) {
                    prevBtn.addEventListener("click", (e) => {
                        e.preventDefault();
                        currentPage = (currentPage - 1 + totalPages) % totalPages;
                        showImages(currentPage);
                    });

                    nextBtn.addEventListener("click", (e) => {
                        e.preventDefault();
                        currentPage = (currentPage + 1) % totalPages;
                        showImages(currentPage);
                    });
                }

                // 显示初始图片
                showImages(0);
            });
        }

        /**
         * 初始化图片上传与预览功能
         */
        function initializeImageUpload() {
            document.querySelectorAll('input[type="file"]').forEach((imageInput) => {
                const previewContainerId = imageInput.dataset.previewTarget ||
                    `imagePreview${imageInput.id.replace('image', '')}`;
                const previewContainer = document.getElementById(previewContainerId);
                const maxFileSize = 5 * 1024 * 1024; // 5MB

                if (!previewContainer) {
                    console.warn(`Preview container with ID "${previewContainerId}" not found`);
                    return;
                }

                imageInput.addEventListener("change", function(event) {
                    const files = event.target.files;
                    previewContainer.innerHTML = ""; // 清空现有内容

                    if (files.length === 0) {
                        previewContainer.innerHTML = '<p class="text-muted">No image selected</p>';
                        return;
                    }

                    Array.from(files).forEach((file, index) => {
                        // 检查文件类型
                        if (!file.type.startsWith("image/")) {
                            alert(`File "${file.name}" is not a valid image.`);
                            return;
                        }

                        // 检查文件大小
                        if (file.size > maxFileSize) {
                            alert(`File "${file.name}" exceeds the 5MB size limit.`);
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imgDiv = createPreviewImageDiv(e.target.result, file.name);
                            previewContainer.appendChild(imgDiv);
                        };
                        reader.readAsDataURL(file);
                    });
                });
            });
        }

        /**
         * 初始化编辑时显示已选图片
         */
        function initializeEditImageSelection() {
            document.querySelectorAll('input[type="file"]').forEach((imageInput) => {
                const previewContainerId = imageInput.dataset.previewTarget ||
                    `imagePreview${imageInput.id.replace('image', '')}`;
                const previewContainer = document.getElementById(previewContainerId);
                const imageUrls = JSON.parse(imageInput.dataset.imageUrls || "[]");

                if (!previewContainer) {
                    console.warn(`Preview container with ID "${previewContainerId}" not found`);
                    return;
                }

                previewContainer.innerHTML = ""; // 清空现有内容

                if (imageUrls.length === 0) {
                    previewContainer.innerHTML = '<p class="text-muted">No image selected</p>';
                    return;
                }

                // 循环生成图片预览
                imageUrls.forEach((url) => {
                    const imgDiv = createPreviewImageDiv(url, url, true);
                    previewContainer.appendChild(imgDiv);
                });
            });
        }

        /**
         * 从服务器删除图片
         */
        function deleteImageFromServer(imageUrl, imgDiv) {
            // 显示确认提示
            if (confirm("Are you sure you want to delete this image?")) {
                $.ajax({
                    url: `/hotel-image/${imageUrl}`,
                    type: "DELETE",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        console.log(data.message);
                        imgDiv.remove();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    },
                });
            }
        }

        /**
         * 初始化动态模态框
         */
        function initializeModals() {
            const modals = document.querySelectorAll(".modal");
            modals.forEach((modal) => {
                new bootstrap.Modal(modal); // 确保模态框组件被初始化
            });
        }

        /**
         * 创建图片预览容器，包含删除功能
         */
        function createPreviewImageDiv(src, title, isExisting = false) {
            const imgDiv = document.createElement("div");
            imgDiv.style.position = "relative";
            imgDiv.style.margin = "5px";
            imgDiv.style.width = "120px"; // 增加宽度
            imgDiv.style.height = "100px"; // 减少高度
            imgDiv.style.display = "inline-block"; // 使图像水平排列

            const img = document.createElement("img");
            img.src = src;
            img.alt = title;
            img.title = title;
            img.style.width = "100%";
            img.style.height = "100%";
            img.style.objectFit = "cover";
            img.style.borderRadius = "8px";
            img.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.2)";
            img.style.cursor = "pointer";

            const deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.className = "btn btn-danger btn-sm delete-image";
            deleteButton.textContent = "X";
            deleteButton.style.position = "absolute";
            deleteButton.style.top = "5px";
            deleteButton.style.right = "5px";

            if (isExisting) {
                deleteButton.addEventListener("click", () => {
                    if (confirm(`Remove this image from server?`)) {
                        deleteImageFromServer(src, imgDiv);
                    }
                });
            } else {
                deleteButton.addEventListener("click", () => {
                    if (confirm(`Remove "${title}" from upload?`)) {
                        imgDiv.remove();
                    }
                });
            }

            imgDiv.appendChild(img);
            imgDiv.appendChild(deleteButton);

            return imgDiv;
        }
    </script>

    {{-- Get Coordinates --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 获取所有地址输入框
            const addressInputs = document.querySelectorAll('textarea[id^="location"]');

            addressInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    const address = this.value.trim();
                    const id = this.id.replace('location', '');

                    // 如果地址为空，清空经纬度输入框
                    if (address === '') {
                        document.getElementById('latitude' + id).value = '';
                        document.getElementById('longitude' + id).value = '';
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
                                document.getElementById('latitude' + id).value = location.lat;
                                document.getElementById('longitude' + id).value = location.lon;
                            } else {
                                // 地址未找到时清空输入框
                                document.getElementById('latitude' + id).value = '';
                                document.getElementById('longitude' + id).value = '';
                                console.error('No results found for the given address.');
                            }
                        })
                        .catch(error => {
                            // 捕获网络错误并清空输入框
                            document.getElementById('latitude' + id).value = '';
                            document.getElementById('longitude' + id).value = '';
                            console.error('Error fetching geocoding data:', error);
                        });
                });
            });
        });
    </script>

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
