<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>jQuery Filterable Demo</title>
<!-- <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
<!-- <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet"> -->

</head>

<body>
	<link href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.min.css" rel="stylesheet">
<link href="http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.4/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
<link href="tablefilters/lib/bootstrap-filterable.css" rel="stylesheet" type="text/css">
<div id="jquery-script-menu">
<h1 style="margin-top:150px;" align="center";>jQuery Filterable Demo</h1>
<table id="example-table" class="table table-striped table-hover table-condensed" style="margin-top:100px;">
<tr>
<th>Make</th>
<th>Model</th>
<th>Color</th>
<th>Year</th>
</tr>
<tbody>
<tr>
<td>Ford</td>
<td>Escort</td>
<td>Blue</td>
<td>2000</td>
</tr>
<tr>
<td>Ford</td>
<td>Ranger</td>
<td>Blue</td>
<td>1990</td>
</tr>
<tr>
<td>Toyota</td>
<td>Tacoma</td>
<td>Red</td>
<td>2012</td>
</tr>
<tr>
<td>Ford</td>
<td>Mustang</td>
<td>Silver</td>
<td>2012</td>
</tr>
<tr>
<td>Mercury</td>
<td>Sable</td>
<td>Silver</td>
<td>2002</td>
</tr>
<tr>
<td>Toyota</td>
<td>Corolla</td>
<td>Blue</td>
<td>2012</td>
</tr>
</tbody>
</table>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> 
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script> 
<script src="http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.4/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script src="tablefilters/src/jquery.filterable.js"></script> 
<script>
$('#example-table').filterable();
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
