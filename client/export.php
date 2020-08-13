<!DOCTYPE html> 
<html> 
  
<head> 
    <title></title> 
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"> </script> 
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script> 

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style> 
        .top { 
            margin-top: 20px; 
        } 
          
        h1 { 
            color: green; 
        } 
          
        input { 
            background-color: transparent; 
            border: 0px solid; 
            width: 300; 
        } 
          
        body { 
            text-align: center; 
        } 
    </style> 
</head> 
  
<body> 
  
    <div class="col-md-offset-4 col-md-4 col--md-offset-4 top"> 
        <div id="createImg" style="border:1px solid;"> 
            <h1>Geeks
<div id="chart">
    
    
</div>
        </div> 
    
    </div> 
    <script> 
        function createFile(){
                html2canvas($("#createImg"), { 
                    onrendered: function(canvas) { 
                        var dataURL = canvas.toDataURL(); 
                        var name="zlatan";
                        $.ajax({ 
                            type: "POST", 
                            url: "script.php", 
                            data: { 
                                imgBase64: dataURL,
                                name 
                            } 
                        }).done(function(o) { 
                       
                        }); 
                    } 
                }); 
            }
             window.onload = createFile;
    </script> 



    <script type="text/javascript">
   var options = {
            chart: {
                height: 350,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    colors: {
                        ranges: [
                            {
                                from: 0,
                                to: 110,
                                color: '#008140'
                            }, {
                                from: -100,
                                to: 0,
                                color: '#ff0000'
                            }
                        ]
                    },
                    columnWidth: '80%',
                }
            },
            dataLabels: {
                enabled: false,
            },
            series: [{
                name: 'Cash Flow',
                data: [1.45, 5.42, 5.9, -0.42, -12.6, -18.1, -18.2, -14.16, -11.1
                ]
            }],

            yaxis: {
                title: {
                    text: 'Growth',
                },
                labels: {
                    formatter: function (y) {
                        return y.toFixed(0) + "%";
                    }
                }

            },
            xaxis: {
                // TODO: uncomment below and fix the error
                //type: 'datetime',
                categories: [
                  
                    '2013-01-01', '2013-02-01', '2013-03-01', '2013-04-01', '2013-05-01', '2013-06-01',
                    '2013-07-01', '2013-08-01', '2013-09-01'
                ],
                labels: {
                    rotate: -90
                }
            },
            tooltip: {

            }
        }

        var chart = new ApexCharts(
            document.querySelector("#chart"),
            options
        );

        chart.render();
    </script>

</body> 
  
</html> 