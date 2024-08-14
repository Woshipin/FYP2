@extends('frontend-auth.newlayout')

@section('frontend-section')
    <br><br><br><br><br>

    <div class="container">
        <h2>Verify Face</h2>
        <button id="retry-btn" style="display: none;">Retry</button>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div id="camera-container">
            <video id="video" width="640" height="480" autoplay muted></video>
            <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/face-api.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            async function startFaceRecognition() {
                const video = document.getElementById('video');
                const canvas = document.getElementById('canvas');
                const retryBtn = document.getElementById('retry-btn');

                // 加载人脸检测模型
                await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
                await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
                await faceapi.nets.faceRecognitionNet.loadFromUri('/models');

                // 请求摄像头权限
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(stream => {
                        video.srcObject = stream;
                        video.onloadedmetadata = () => {
                            video.play();
                            startFaceDetection();
                        };
                    })
                    .catch(err => console.error(err));

                function startFaceDetection() {
                    const displaySize = {
                        width: video.width,
                        height: video.height
                    };

                    // 循环检测人脸
                    setInterval(async () => {
                        const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                            .withFaceLandmarks()
                            .withFaceDescriptors();
                        const resizedDetections = faceapi.resizeResults(detections, displaySize);

                        if (resizedDetections.length > 0) {
                            // 检测到人脸时的处理逻辑
                            console.log('Detected face');
                            // 进行人脸比对
                            const userPhotoDescriptor = await fetch('/user-photo-descriptor.json')
                                .then(response => response.json());
                            resizedDetections.forEach(detection => {
                                const faceDescriptor = detection.descriptor;
                                const faceMatcher = new faceapi.FaceMatcher(userPhotoDescriptor);
                                const bestMatch = faceMatcher.findBestMatch(faceDescriptor);
                                console.log('Best match:', bestMatch);
                                if (bestMatch.label === 'unknown' || bestMatch._distance > 0.6) {
                                    // 如果人脸匹配度较低，或者未知用户，则显示重试按钮
                                    retryBtn.style.display = 'block';
                                } else {
                                    // 如果人脸匹配成功，则执行相关操作，比如跳转页面等
                                    window.location.href = '/dashboard';
                                }
                            });
                        }
                    }, 100);
                }
            }

            // 页面加载完成后开始人脸识别
            startFaceRecognition();

            // 重试按钮点击事件
            const retryBtn = document.getElementById('retry-btn');
            retryBtn.addEventListener('click', () => {
                location.reload();
            });
        });
    </script>

@endsection
