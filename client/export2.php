<!DOCTYPE html> 
<html> 
  
<head> 
    <title> 
        How to convert an HTML element 
        or document into image ? 
    </title> 
      
    <script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"> 
    </script> 
      
    <script src= 
"https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"> 
    </script> 
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head> 
  
<body> 
    <center> 
    <h2 style="color:green"> 
        GeeksForGeeks 
    </h2> 
      
    <h2 style="color:purple"> 
        Convert div to image 
    </h2> 
      
    <div id="html-content-holder" style="background-color: #F0F0F1;  
                color: #00cc65; width: 500px;padding-left: 25px;  
                padding-top: 10px;"> 
          
        <strong> 
            GeeksForGeeks 
        </strong> 
          <div id="chart"></div>
        <hr/> 
          
        <h3 style="color: #3e4b51;"> 
            ABOUT US 
        </h3> 
      
        <p style="color: #3e4b51;">  
            <b>GeeksForGeeks</b> is a portal and a forum 
            for many tutorials focusing on Programming 
            ASP.Net, C#, jQuery, AngularJs, Gridview, MVC, 
            Ajax, Javascript, XML, MS SQL-Server, NodeJs, 
            Web Design, Software and much more 
        </p> 
      
        <p style="color: #3e4b51;"> 
            How many times were you frustrated while  
            looking out for a good collection of  
            programming/algorithm/interview questions?  
            What did you expect and what did you get? 
            This portal has been created to provide 
            well written, well thought and well 
            explained solutions for selected questions. 
        </p> 
    </div> 
  
    <input id="btn-Preview-Image" type="button"
                value="Preview" />  
          
    <a id="btn-Convert-Html2Image" href="#"> 
        Download 
    </a> 
  
    <br/> 
      
    <h3>Preview :</h3> 
      
    <div id="previewImage"></div> 
      
    <script> 
        $(document).ready(function() { 
          
            // Global variable 
            var element = $("#html-content-holder");  
          
            // Global variable 
            var getCanvas;  
  
            $("#btn-Preview-Image").on('click', function() { 
                html2canvas(element, { 
                    onrendered: function(canvas) { 
                        $("#previewImage").append(canvas); 
                        getCanvas = canvas; 
                    } 
                }); 
            }); 
  
            $("#btn-Convert-Html2Image").on('click', function() { 
                var imgageData =  
                    getCanvas.toDataURL("image/png"); 
              
                // Now browser starts downloading  
                // it instead of just showing it 
                var newData = imgageData.replace( 
                /^data:image\/png/, "data:application/octet-stream"); 
              
                $("#btn-Convert-Html2Image").attr( 
                "download", "GeeksForGeeks.png").attr( 
                "href", newData); 
            }); 
        }); 
    </script> 

        <script> 
        function createFile(){
                html2canvas($("#html-content-holder"), { 
                    onrendered: function(canvas) { 
                        var dataURL = canvas.toDataURL(); 
                        var name="nyaa";
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
    </center> 

        <div class="col-md-offset-4 col-md-4 col--md-offset-4 top"> 
        <div id="createImg" style="border:1px solid;"> 
            <h1>Geeks

        </div> 
    
    </div> 


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