<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>推荐内容</title>
    <style>
        /* 添加一些简单的样式 */
        .recommendation {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div>
        <h2>推荐内容</h2>
        <div id="recommendations"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/api/recommendations')
                .then(response => response.json())
                .then(data => {
                    const recommendationsContainer = document.getElementById('recommendations');
                    data.forEach(item => {
                        const itemDiv = document.createElement('div');
                        itemDiv.classList.add('recommendation');

                        const itemName = document.createElement('h3');
                        itemName.textContent = item.name;

                        const itemDescription = document.createElement('p');
                        itemDescription.textContent = item.description;

                        itemDiv.appendChild(itemName);
                        itemDiv.appendChild(itemDescription);

                        recommendationsContainer.appendChild(itemDiv);
                    });
                })
                .catch(error => {
                    console.error('Error fetching recommendations:', error);
                });
        });
    </script>
</body>
</html>
