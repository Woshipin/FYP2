<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Map View</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .button {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .modal {
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

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 1200px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .stars {
            color: #ffc107;
            margin-left: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-body {
            display: flex;
            gap: 20px;
            height: calc(100vh - 200px);
            min-height: 500px;
        }

        .map-container {
            flex: 1;
            position: relative;
            height: 100%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .map-controls {
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
        }

        .map-button {
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

        .info-container {
            flex: 0 0 380px;
            overflow-y: auto;
            height: 100%;
            padding-right: 10px;
        }

        .info-container::-webkit-scrollbar {
            width: 8px;
        }

        .info-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .info-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .info-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .address {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            margin-bottom: 10px;
        }

        .icon {
            font-size: 18px;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .rating-score {
            background-color: #1a73e8;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }

        .rating-text {
            font-weight: 500;
        }

        .review-count {
            color: #666;
        }

        .select-rooms {
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

        .tabs {
            display: flex;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .tab {
            background-color: transparent;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .tab.active {
            border-bottom: 2px solid #1a73e8;
            color: #1a73e8;
        }

        .tab-content h3 {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .station-info {
            margin-bottom: 20px;
        }

        .station-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .station-card p {
            margin: 0 0 5px 0;
            font-size: 14px;
        }

        .station-card p:first-child {
            font-weight: 500;
        }

        .view-icon {
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

        .view-icon:hover {
            background-color: #e0e0e0;
        }

        .view-icon:hover .tooltip {
            opacity: 1;
            visibility: visible;
        }

        .tooltip {
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

        .tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            right: 10px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        .view-icon svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: #666;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        @media (max-width: 768px) {
            .modal-body {
                flex-direction: column;
            }

            .info-container {
                flex: 1;
            }

            .map-container {
                height: 300px;
            }
        }
    </style>
</head>

<body>
    <button id="openModal" class="button">View Location</button>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Hilton Singapore Orchard <span class="stars">★★★★★</span></h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.3891261244535!2d103.67928727472494!3d1.5336266984520148!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da73c109632e0b%3A0x74cda51bf210c304!2z5Y2X5pa55aSn5a2m5a2m6Zmi!5e0!3m2!1szh-CN!2smy!4v1732895265421!5m2!1szh-CN!2smy"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    <div class="map-controls">
                        <button class="map-button">+</button>
                        <button class="map-button">-</button>
                    </div>
                </div>
                <div class="info-container">
                    <p class="address"><span class="icon">📍</span> 333 Orchard Road, Singapore 238867</p>
                    <div class="rating">
                        <span class="rating-score">4.6/5</span>
                        <span class="rating-text">Great</span>
                        <span class="review-count">• 1,318 reviews</span>
                    </div>
                    <button class="select-rooms">Select Rooms</button>
                    <div class="tabs">
                        <button class="tab active">Transport</button>
                        <button class="tab">Landmarks</button>
                        <button class="tab">Dining</button>
                        <button class="tab">Shopping</button>
                    </div>
                    <div class="tab-content">
                        <h3><span class="icon">🚇</span> Metro station</h3>
                        <div class="station-info">
                            <div class="station-card">
                                <p><strong>Somerset</strong></p>
                                <p>About 7 mins from hotel by foot (440m)</p>
                                <div class="view-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <span class="tooltip">View more</span>
                                </div>
                            </div>
                            <div class="station-card">
                                <p><strong>Orchard</strong></p>
                                <p>About 11 mins from hotel by foot (730m)</p>
                                <div class="view-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <span class="tooltip">View more</span>
                                </div>
                            </div>
                        </div>
                        <h3><span class="icon">🚉</span> Train station</h3>
                        <div class="station-info">
                            <div class="station-card">
                                <p><strong>Woodlands Train Checkpoint</strong></p>
                                <p>About 27 mins from hotel by car (20.0km)</p>
                                <div class="view-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <span class="tooltip">View more</span>
                                </div>
                            </div>
                        </div>
                        <h3><span class="icon">✈️</span> Airport</h3>
                        <div class="station-info">
                            <div class="station-card">
                                <p><strong>Singapore Changi Airport</strong></p>
                                <p>About 24 mins from hotel by car (21.7km)</p>
                                <div class="view-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <span class="tooltip">View more</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("modal");
        const btn = document.getElementById("openModal");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                // Here you would typically also update the content of the tab
                console.log(`Switched to ${tab.textContent} tab`);
            });
        });
    </script>
</body>

</html>
