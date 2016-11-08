<html>
<head>




<script>

var current_ID = 'vel';
function changeGraph(newID) {

    document.getElementById(current_ID).style.display='none';
    document.getElementById(newID).style.display = '';
    current_ID = newID;
    //alert(current_ID);
  }
</script>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart);


  function drawChart() {

    var vel = new google.visualization.DataTable();
    vel.addColumn('number', 'Distance');
    vel.addColumn('number', 'Velocidad');
    vel.addColumn('number', 'Avg Speed');

    vel.addRows([
      <?php foreach($velocidades as $v): ?>
          [<?= $v[0]; ?>, <?= $v[1] ?>, <?= $velocidadMedia ?>],
        <?php endforeach ?>
    ]);


    var dis = new google.visualization.DataTable();
    dis.addColumn('number', 'Time');
    dis.addColumn('number', 'Distancia');

    dis.addRows([
      <?php foreach($distancias as $v): ?>
          [<?= $v[0] ?>, <?= $v[1]; ?>],
        <?php endforeach ?>
    ]);


    var ele = new google.visualization.DataTable();
    ele.addColumn('number', 'Time');
    ele.addColumn('number', 'Elevacion');

    ele.addRows([
      <?php foreach($elevaciones as $v): ?>
          [<?= $v[0] ?>, <?= $v[1]; ?>],
        <?php endforeach ?>
    ]);
    /*
    var options = {
      chart: {
        title: current_ID,
      },
      width: 950,
      height: 500,
      linewidth : 1
    };
    */
    var options = {
      title: '<?= $fechaActividad ?>',
      width: 1300,
      height: 500,
      linewidth : 1, 
      hAxis: {
        gridlines : {color: '#ff9900', opacity : 0.4, count : <?= $cantGrid; ?>},
        opacity : 0.5
        },
      vAxis : {
        gridlines : { color: '#ff9900', opacity : 0.4, count : 4 }
      },
      series: {
        0: {color : '#ff9900', areaOpacity : 0.5},
        1: {color: 'red', areaOpacity : 0.0, lineWidth : 1.75, lineDashStyle: [8,6]}
      }
    };

    var velChart = new google.visualization.AreaChart(document.getElementById('vel'));
    var eleChart = new google.visualization.AreaChart(document.getElementById('ele'));
    var disChart = new google.visualization.AreaChart(document.getElementById('dis'));

    velChart.draw(vel, options);
    eleChart.draw(ele, options);
    disChart.draw(dis, options);
  }
</script>
</head>

<body>
  <button onclick="window.location.href='/lalo/index.php'">Subir Nuevo Archivo</button>

  <br></br>
  <button type="button" onclick=changeGraph('vel')>VELOCIDADES</button>
  <button type="button" onclick=changeGraph('ele')>ELEVACIONES</button>
  <button type="button" onclick=changeGraph('dis')>DISTANCIAS</button>
  
  <div id="vel" style="float:left;  "></div>
  <div id="ele" style="float:left; display:none"></div>
  <div id="dis" style="float:left; display:none"></div>

  

  
</body>

</html>