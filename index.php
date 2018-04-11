<?php
require_once("api/v1/commonfunctions.php");
$t = "?t=".commonfunctions::getGUID();
//echo $t;
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="iso-8859-1">
    <!--<meta charset="utf-8"/>-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
      <meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
          <title>Awesome Power</title>
          <!-- Bootstrap -->
             <link href="css/bootstrap.min.css<?=$t?>" rel="stylesheet"/>
            <!--<link rel="stylesheet" href="css/bootstrap/3.3.0/bootstrap.min.css">-->
		         <link rel="stylesheet" href="css/angularjs-datetime-picker.css<?=$t?>" />
             <link href="css/custom.css<?=$t?>" rel="stylesheet"/>
			       <link href="css/menu.css<?=$t?>" rel="stylesheet"/>
			       <link href="css/pushmenu.css<?=$t?>" rel="stylesheet"/>
             <link href="css/toaster.css<?=$t?>" rel="stylesheet"/>
			       <link rel="stylesheet" href="css/ngtable.css<?=$t?>"/>
			       <link rel="stylesheet" href="css/snackbar.css<?=$t?>"/>
			       <link rel="stylesheet" type="stylesheet" href="css/topmenu.css<?=$t?>"/>
			       <link href="assets/plugins/dataTables/dataTables.bootstrap.css<?=$t?>" rel="stylesheet" />
			       <link rel="stylesheet" href="css/jquery-ui.css<?=$t?>" />
			       <link rel="stylesheet" href="css/loading/wave.css<?=$t?>" />
             <link rel="stylesheet" href="css/notification/notification.css<?=$t?>" />
				     <link rel="stylesheet" href="css/contactform.css<?=$t?>" />

            <link rel="stylesheet" href="css/ngDialog/ngDialog.css<?=$t?>" />
            <link rel="stylesheet" href="css/ngDialog/ngDialog-theme-default.css<?=$t?>" />
            <link rel="stylesheet" href="css/ngDialog/ngDialog-theme-plain.css<?=$t?>" />
        <!--<link href="css/sidemenu/BootSideMenu.css" rel="stylesheet">-->
        <!--<link href="css/sidemenu/sidemenu.css" rel="stylesheet">-->
        <!--<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">-->
            <link href="css/sidemenu/minisidemenu.css<?=$t?>" rel="stylesheet">
            
            <!--<link href="css/RichTextEditor/richtexteditor.css<?=$t?>" rel="stylesheet">-->
            
            <link href="css/RichTextEditor/jquery-te-1.4.0.css<?=$t?>" rel="stylesheet">
            <link rel="stylesheet" href="css/ui-notification/angular-csp.css<?=$t?>">
          <link rel="stylesheet" href="css/ui-notification/angular-ui-notification.min.css<?=$t?>">
              
			  
                <style>
                  a {	
                  color: orange;
                  }
                </style>
                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                <!--[if lt IE 9]><link href= "css/bootstrap-theme.css"rel= "stylesheet" >

<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
				<!-- Page-Level CSS -->
				<script src="http://code.highcharts.com/adapters/standalone-framework.js"></script>
				<script src="https://code.highcharts.com/highcharts.js"></script>
				<script src="https://code.highcharts.com/modules/exporting.js"></script>
				
				

              </head>

  <body id="thisisbody" ng-cloak="">
    
	<header-html title="Awesome Power"></header-html> 
    
      <div class="container" style="margin-top:20px;">
		
        <div data-ng-view="" id="app" class="slide-animation"></div>
		

      </div>
    </body>
  <toaster-container toaster-options="{'time-out': 3000}"></toaster-container>

  <div class="ui-notification">
    <h3 ng-show="title" ng-bind-html="title"></h3>
    <div class="message" ng-bind-html="message"></div>
</div>
  <!-- Libs -->
  <script src="assets/plugins/jquery-1.10.2.js<?=$t?>"></script>
   <script src="assets/plugins/bootstrap/bootstrap.min.js<?=$t?>"></script>
   <!--<script src="js/jquery/2.1.1/jquery-2.1.1.min.js"></script>
  <script src="js/bootstrap/3.3.0/bootstrap.min.js"></script>-->

  <script src="js/angular.min.js<?=$t?>"></script>

  <script src="js/angular-route.min.js<?=$t?>"></script>
  <script src="js/angular-animate.min.js<?=$t?>" ></script>
  <script src="js/angularjs-datetime-picker.js<?=$t?>"></script>
  <script src="js/toaster.js<?=$t?>"></script>
  <script src="js/ngtable.js<?=$t?>"></script>
  <script src="js/underscore.js<?=$t?>"></script>
<script src="js/ui-notification/angular-ui-notification.min.js<?=$t?>"></script>


  <script src="js/angular-resource.js<?=$t?>"></script>
  <script src="js/ui-bootstrap-tpls-0.11.0.js<?=$t?>"></script>
  <script src="js/ngDialog/ngDialog.js<?=$t?>"></script>
  <script type="text/javascript" src="js/pagination/dirPagination.js<?=$t?>"></script>
  
  <script src="app/app.js<?=$t?>"></script>

  <script src="app/data.js<?=$t?>"></script>
  <script src="app/directives.js<?=$t?>"></script>
  <script src="app/Header.js<?=$t?>"></script>
  <script src="app/authCtrl.js<?=$t?>"></script>
  <script src="app/dashboardCtrl.js<?=$t?>"></script>
  <script src="app/profileCtrl.js<?=$t?>"></script>
   <script src="app/helpCtrl.js<?=$t?>"></script>
   <!--<script src="app/insideCtrl.js"></script>-->


    <script src="app/usermgmtCtrl.js<?=$t?>"></script>
    <script src="app/messageCtrl.js<?=$t?>"></script>
	<script src="app/logoutCtrl.js<?=$t?>"></script>
		<!--<script src="js/csvExport/alasql.min.js<?=$t?>"></script>
		<script src="js/csvExport/xlsx.core.min.js<?=$t?>"></script>-->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/alasql/0.4.2/alasql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.9.2/xlsx.core.min.js"></script>
		<!--<script src="js/Export/html2canvas.js"></script>-->
	
	<!-- <script src="js/Export/tableExport.js"></script>
    <script src="js/Export/JqueryBase64.js"></script>
    <script src="js/Export/html2canvas.js"></script>
    <script src="js/Export/base64.js"></script>
    <script src="js/Export/Jspdf.js"></script>
    <script src="js/Export/sprintf.js"></script> -->

  <script src="assets/plugins/dataTables/jquery.dataTables.js<?=$t?>"></script>
    <script src="assets/plugins/dataTables/dataTables.bootstrap.js<?=$t?>"></script>


  <script src="js/jquery-ui.js<?=$t?>"></script>

  <script type="text/javascript" src="plugins/htmltopdf/html2canvas.min.js<?=$t?>"></script>
  <script type="text/javascript" src="plugins/htmltopdf/jspdf.min.js<?=$t?>"></script>
  
  <!--<script type="text/javascript" src="js/RichTextEditor/bootstrap-colorpicker-module.js<?=$t?>"></script>
  <script type="text/javascript" src="js/RichTextEditor/angular-wysiwyg.js<?=$t?>"></script>-->
    
<script src="js/RichTextEditor/jquery-te-1.4.0.min.js<?=$t?>"></script>
<script src="js/pageslider/angular-pageslide-directive.js<?=$t?>"></script>

   <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
   <script src="app.js"></script>
  <!--<script type="text/javascript" src="plugins/htmltopdf/htmltopdf.js"></script>-->
  
</html>

