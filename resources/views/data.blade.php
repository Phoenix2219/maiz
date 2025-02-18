<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Motor y Sensor</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 p-6">

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 border-4 border-yellow-600">
        <h1 class="text-2xl font-bold text-center mb-4">Control de Motor y Datos de Sensor</h1>
        <h3 id="status" class="text-lg text-center text-red-500 font-semibold">Estado: Desconectado</h3>
        
        <div class="flex justify-center gap-4 my-4">
            <button onclick="sendData('1')" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Encender motor</button>
            <button onclick="sendData('0')" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Apagar motor</button>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-center font-semibold">Temperatura: <span id="temperature">0</span>°C</h3>
                <canvas id="temperatureChart"></canvas>
            </div>
            <div>
                <h3 class="text-center font-semibold">Humedad: <span id="humidity">0</span>%</h3>
                <canvas id="humidityChart"></canvas>
            </div>
        </div>

        <div class="flex justify-center mt-6">
            <button onclick="window.history.back()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Volver</button>
        </div>
    </div>

    <script>
        const ws = new WebSocket('ws://localhost:8080');
        let tempChart, humChart;
        let tempData = [];
        let humData = [];
        let labels = [];
        
        ws.onopen = function() {
            document.getElementById("status").innerText = "Estado: Conectado";
            document.getElementById("status").classList.remove("text-red-500");
            document.getElementById("status").classList.add("text-green-500");
        };

        ws.onmessage = function(event) {
            console.log("Datos recibidos:", event.data);
            const data = event.data.split("  ");
            const humidity = parseFloat(data[0].split(": ")[1].replace("%", ""));
            const temperature = parseFloat(data[1].split(": ")[1].replace("°C", ""));

            document.getElementById("humidity").innerText = humidity;
            document.getElementById("temperature").innerText = temperature;

            labels.push(new Date().toLocaleTimeString());
            tempData.push(temperature);
            humData.push(humidity);

            if (labels.length > 20) {
                labels.shift();
                tempData.shift();
                humData.shift();
            }

            tempChart.update();
            humChart.update();
        };

        function sendData(value) {
            ws.send(value);
            console.log("Enviado:", value);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const ctxTemp = document.getElementById('temperatureChart').getContext('2d');
            const ctxHum = document.getElementById('humidityChart').getContext('2d');
            
            tempChart = new Chart(ctxTemp, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Temperatura (°C)',
                        data: tempData,
                        borderColor: 'red',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            humChart = new Chart(ctxHum, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Humedad (%)',
                        data: humData,
                        borderColor: 'blue',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
</body>
</html>
