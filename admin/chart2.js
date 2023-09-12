var ctx2 = document.getElementById('doughnut').getContext('2d');
var myChart2 = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Present', 'Absent', 'Late'],
        datasets: [{
           label: 'Employees',
           data: [42,12,8,6],
           backgroundColor: [
                'rgba(41,155,99,1)',
                'rgba(210, 4, 45,1)',
                'rgba(255,206,86,1)',

           ],
            borderColor: [
                'rgba(41,155,99,1)',
                'rgba(210, 4, 45,1)',
                'rgba(255,206,86,1)',
            ],
            borderWidth: 1
        }] 
    },
    options: {
        responsive:  true
    }
   });










