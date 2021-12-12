window.onload = function() {

    var tables = document.querySelectorAll('.comments-table');

    tables.forEach(element => {
        buildChart(element.dataset.id, element.dataset.good, element.dataset.bad, element.dataset.neutral);
    });

    function buildChart(id, good, bad, neutral) {

        var ctx = document.getElementById('myChartComments-' + id).getContext('2d');

        var dataComments = {
            labels: ['Добре', 'Погано', 'Нейтрально'],
            datasets: [{
                axis: 'y',
                label: 'Реакція аудиторії (коментаторів)',
                barPercentage: 0.9,
                categoryPercentage: 0.9,
                barThickness: 20,
                maxBarThickness: 20,
                minBarLength: 2,
                data: [good, bad, neutral],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgb(75, 192, 192)',
                    'rgb(255, 99, 132)',
                    'rgb(153, 102, 255)'
                ],
                borderWidth: 1
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: dataComments,
            options: {
                indexAxis: 'y',
            }
        });
    }
}