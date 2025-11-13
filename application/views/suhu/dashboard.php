<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Suhu Realtime</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: #0d1117;
      color: #fff;
      text-align: center;
      padding: 40px;
    }
    .chart-container {
      width: 90%;
      max-width: 800px;
      margin: auto;
      background: #161b22;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(255,255,255,0.1);
    }
  </style>
</head>
<body>
  <h2>📈 Dashboard Suhu Realtime</h2>
  <div class="chart-container">
    <canvas id="suhuChart"></canvas>
  </div>

  <script>
    const ctx = document.getElementById('suhuChart').getContext('2d');
    let suhuChart;

    // Data awal dari PHP
    const initialData = <?php echo json_encode($suhu['data']); ?>;
    const labels = initialData.map(item => item.updated_Date.split(' ')[1].substring(0,5));
    const values = initialData.map(item => item.suhu);

    // Inisialisasi chart
    suhuChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Suhu (°C)',
          data: values,
          borderColor: '#36a2eb',
          backgroundColor: 'rgba(54,162,235,0.2)',
          borderWidth: 2,
          fill: true,
          tension: 0.3,
          pointRadius: 5,
          pointHoverRadius: 7
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false,
            title: {
              display: true,
              text: 'Suhu (°C)',
              color: '#fff'
            },
            ticks: { color: '#fff' }
          },
          x: {
            title: {
              display: true,
              text: 'Waktu Update',
              color: '#fff'
            },
            ticks: { color: '#fff' }
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.parsed.y + '°C';
              }
            }
          },
          legend: {
            labels: { color: '#fff' }
          }
        }
      }
    });

    // 🔁 Realtime update setiap 5 detik
    setInterval(fetchRealtimeData, 5000);

    function fetchRealtimeData() {
      fetch("<?php echo base_url('suhu/get_realtime'); ?>")
        .then(response => response.json())
        .then(result => {
            const newData = result.data;
            const newLabels = newData.map(item => item.updated_Date);
            const newValues = newData.map(item => item.suhu);

            suhuChart.data.labels = newLabels;
            suhuChart.data.datasets[0].data = newValues;
            suhuChart.update();

            // Log suhu terakhir
            const last = newData[newData.length - 1];
            console.info(`[UPDATE] Suhu terakhir: ${last.suhu}°C pada ${last.updated_Date}`);
        })
        .catch(error => console.error('Error:', error));
    }
  </script>
</body>
</html>
