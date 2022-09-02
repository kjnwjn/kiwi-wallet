<div class="container-fluid ">
    <div class="row">
        <div class="col-lg-6 p-3">
            <canvas class= "" id="myChart"></canvas>
        </div>
        <div class="col-lg-6 p-3">
            <canvas class= "" id="myChart4"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 p-3">
          <canvas class= "" id="myChart2"></canvas>
        </div>
        <div class="col-lg-6 p-3">
          <canvas class= "" id="myChart3"></canvas>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

  const urlAllAccount = 'http://localhost/api/admin/list-account'
  const urlPendingAccount = 'http://localhost/api/admin/list-account/pending'
  const urlActivedAccount = 'http://localhost/api/admin/list-account/actived'
  const urlDisabledAccount = 'http://localhost/api/admin/list-account/disabled'
  const urlBlockedAccount = 'http://localhost/api/admin/list-account/blocked'
  // function getData(url){
  //   fetch(url)
  //         .then(response => response.json())
  //         .then(response => {console.log(response.data.length)})
  // };
  // totalAccount = getData(urlAllAccount);
  // pendingsAccount = getData(urlPendingAccount);
  // getData(urlAllAccount)
  // chart 1
  const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'The graph shows the number of accounts created in the first 6 months of 2022',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [0, 10, 5, 2, 20, 30, 45],
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {}
  };


// chart 4
const labels4 = [
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
  ];

  const data4 = {
    labels: labels4,
    datasets: [{
      label: 'The graph shows the number of accounts created in the last months of 2022',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [0, 10, 5, 2, 20, 30, 45],
    }]
  };

  const config4 = {
    type: 'line',
    data: data4,
    options: {}
  };

// chart 2
  const data1 = {
  labels: [
    'recharge',
    'transfer',
    'withdraw'
  ],
  datasets: [{
    label: 'The graph',
    data: [300, 50, 100],
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)'
    ],
    hoverOffset: 4
  }]
};
  const config1 = {
  type: 'doughnut',
  data: data1,
};



// chart 3
const data2 = {
  labels: [
    'pending',
    'actived',
    'disabled',
    'blocked',
   
  ],
  datasets: [{
    label: '123',
    data: [ 16, 7, 3, 14],
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(75, 192, 192)',
      'rgb(255, 205, 86)',
      'rgb(201, 203, 207)',
      
    ]
  }]
};
const config2 = {
  type: 'polarArea',
  data: data2,
  options: {}
};

</script>
<script>
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
  const myChart4 = new Chart(
    document.getElementById('myChart4'),
    config4
  );
  const myChart2 = new Chart(
    document.getElementById('myChart2'),
    config1
  );
  const myChart3 = new Chart(
    document.getElementById('myChart3'),
    config2
  );
</script>
