$(document).ready(function() {
    // Ambil data dari PHP ke JavaScript
    const data = <?php echo json_encode($data); ?>;
    
    // Kelompokkan data berdasarkan PT
    const groupedData = data.reduce((acc, row) => {
        if (!acc[row.Kode_PT]) acc[row.Kode_PT] = [];
        acc[row.Kode_PT].push({ tanggal: row.tanggal, harga: row.Harga });
        return acc;
    }, {});

    // Inisialisasi canvas dan chart
    const ctx = document.getElementById('priceChart').getContext('2d');
    let chart = null;

    // Fungsi untuk memperbarui chart
    function updateChart(pt) {
        const ptData = groupedData[pt] || [];
        const datasets = [{
            label: pt,
            data: ptData.map(d => ({ x: d.tanggal, y: d.harga })),
            borderColor: getRandomColor(),
            fill: false
        }];

        if (chart) {
            chart.destroy();
        }

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: datasets
            },
            options: {
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'll',
                            displayFormats: {
                                day: 'DD-MM-YYYY'
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Tanggal'
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Harga'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

    // Fungsi untuk mendapatkan warna acak
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Event listener untuk tombol PT
    $('.pt-link').click(function() {
        const pt = $(this).data('pt');
        updateChart(pt);
    });

    // Tampilkan chart awal
    if ($('.pt-link').length > 0) {
        const initialPt = $('.pt-link').first().data('pt');
        updateChart(initialPt);
    }
});
