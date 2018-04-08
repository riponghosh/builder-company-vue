 function HtmlExportToPDF(ElementID, FileName) {
 
		var doc = new jsPDF('p', 'mm', [700, 1000]);
		                  var margins = {
		        top: 5,
		        bottom: 5,
		        left: 5
		        
		    };
		                  doc.setProperties({
		                     title: 'Title',
		                     subject: 'This is the subject',
		                     author: 'Author Name',
		                     keywords: 'generated, javascript, web 2.0, ajax',
		                     creator: 'Creator Name'
		                    });
		                 
		                  doc.fromHTML(
		                  document.getElementById(ElementID).innerHTML,margins.left, // x coord
		    margins.top);
                  
                  doc.save(FileName+'.pdf');
}

function initiateRichTextEditor()
{

	$("#ReportsEmaileditor").jqte();
}

/*

function MakeWidgetsDragable()
{
	$( "#Drag_LogActivity" ).draggable();
	$( "#Drag_HottelSettings" ).draggable();
	$( "#Drag_AlertTable" ).draggable();
	$( "#Drag_CircuitTable" ).draggable();
	$( "#Drag_ExcelTable" ).draggable();
	$( "#Drag_OccupancyColumnChart" ).draggable();
	$( "#Drag_OccupancyTable" ).draggable();
	$( "#Drag_SMDataBarChart" ).draggable();
	$( "#Drag_WeatherLineChart" ).draggable();
	$( "#Drag_WeatherTable" ).draggable();
	
}
*/
 function setMygrid2()
 {
           $( "#datepicker" ).datepicker();
}

 function CallPDFCreator(tableid)
 {
 	alert(tableid);
       var form = $(tableid), a4  =[ 595.28,  841.89];
		//$('body').scrollTop(0);
  		createPDF();
}


function createSidemenuscripts()
{
	//alert('inside')
	$('#slide-submenu').on('click',function() {			        
        $(this).closest('.list-group').fadeOut('slide',function(){
        	$('.mini-submenu').fadeIn();	
        });
        
      });

	$('.mini-submenu').on('click',function(){		
        $(this).next('.list-group').toggle('slide');
        $('.mini-submenu').hide();
	})

	/*$(document).click(function () {
		$(this).next('.list-group').toggle('slide');
        $('.mini-submenu').hide();
    });*/
	$('#slide-submenu').click();

}

function callNotificationScripts()
{

//$('#test').BootSideMenu({side:"left", autoClose:false});
// $('#test').BootSideMenu({side:"left",autoClose:true});
 //$('#test2').BootSideMenu({side:"right"});

 $('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    
    
 
    if ($(this).find('.btn-success').size()>0) {
    	$(this).find('.btn').toggleClass('btn-success');
    }
 
    
    $(this).find('.btn').toggleClass('btn-default');
       
});

	
	

	$("#notificationLink").click(function () {
        $("#notificationContainer").fadeToggle(300);
        //$("#notification_count").fadeOut("slow");
        $('#notificationLink > i.fa-bell').addClass('fa-bell-o');
        $('#notificationLink > i.fa-bell').removeClass('fa-bell');
        return false;
    });

    //Document Click hiding the popup 
    $(document).click(function () {
        $("#notificationContainer").hide();
    });

    //Popup on click
    $("#notificationContainer").click(function () {
        //return false;
    });
}
var thisObj1 = this;

var dashboardCtrl = app.controller('dashboardCtrl', function (Excel, $scope, $rootScope, $routeParams, $location, $http, Data, $filter, $document, $window, $timeout,$interval, $parse,trafficCop,$interpolate,ngDialog,$templateCache,Utils,Notification) {
    //initially set those objects to null to avoid undefined error
    
    $scope.intervals = []
    var WeatherchartObj = null;
    var OccupancyChartObj = null;
    var LogActivityChartObj = null;
	var SMDataBarChartObj_currentDate = null;
	var SMDataBarChartObj_lastWeek = null;
	var SMDataBarChartObj_lastYear = null;
    var ExcelGraphChartObj = null;
    
	var today = new Date();
	var newdate = new Date();
	var LogActivitynewdate = new Date();
    var dtFormatUK = "dd-MM-yyyy";
	//newdate.setDate(today.getDate()-6);
	newdate.setDate(today.getDate()-27);
	LogActivitynewdate.setDate(today.getDate()-6);
	
	$scope.RootStartDate = $filter('date')(newdate, dtFormatUK);
	$scope.RootEndDate = $filter('date')(today, dtFormatUK);
        
	$scope.WeatherFilterEndDate = $filter('date')(today, dtFormatUK);    
	$scope.WeatherFilterStartDate = $filter('date')(newdate, dtFormatUK);    
	
	$scope.OccupancyFilterEndDate = $filter('date')(today, dtFormatUK);    
	$scope.OccupancyFilterStartDate = $filter('date')(newdate, dtFormatUK);    
	
	$scope.ExcelFilterEndDate = $filter('date')(today, dtFormatUK);    
	$scope.ExcelFilterStartDate = $filter('date')(newdate, dtFormatUK);    
	
	$scope.LogActivityFilterEndDate = $filter('date')(today, dtFormatUK);    
	$scope.LogActivityFilterStartDate = $filter('date')(LogActivitynewdate, dtFormatUK); 

	$scope.AlertFilterEndDate = $filter('date')(today, dtFormatUK);    
	$scope.AlertFilterStartDate = $filter('date')(newdate, dtFormatUK); 
	
	$scope.SMDatBarChartFilterEndDate = $filter('date')(today, dtFormatUK);    
	$scope.SMDatBarChartFilterStartDate = $filter('date')(newdate, dtFormatUK); 

	$scope.SMDatBarChart_chkShowLastWeek = true;
	$scope.SMDatBarChart_chkShowLastYear = true;

	$scope.LogActivity_chkShowAll = true;

	$scope.ShowObservationTypeFlag5=0;
       
    $scope.HeaderMessagesTimerInterval = null;
    $scope.HeaderMessagesList = [];
    $scope.ReportsToDownloadSelectAllCheckbox = false;
    $scope.ReportsToEmailListSelectAllCheckbox = true;
    $scope.ReportWidgetFirstLoad = true;
    $scope.ReportDownloadActiveTab =1;
    
       /* $scope.WeatherFilterEndDate = $filter('date')(today, 'yyyy-MM-dd');    
	$scope.WeatherFilterStartDate = $filter('date')(newdate, 'yyyy-MM-dd');    
	
	$scope.OccupancyFilterEndDate = $filter('date')(today, 'yyyy-MM-dd');    
	$scope.OccupancyFilterStartDate = $filter('date')(newdate, 'yyyy-MM-dd');    
	
	$scope.ExcelFilterEndDate = $filter('date')(today, 'yyyy-MM-dd');    
	$scope.ExcelFilterStartDate = $filter('date')(newdate, 'yyyy-MM-dd');    
	
	$scope.AlertFilterEndDate = $filter('date')(today, 'yyyy-MM-dd');    
	$scope.AlertFilterStartDate = $filter('date')(newdate, 'yyyy-MM-dd'); */
    
	$scope.SetDateToAllWidgets = function()
	{
	
		$scope.WeatherFilterEndDate = $scope.RootEndDate;    
		$scope.WeatherFilterStartDate = $scope.RootStartDate;    
	
		$scope.OccupancyFilterEndDate = $scope.RootEndDate;    
		$scope.OccupancyFilterStartDate = $scope.RootStartDate;        
	
		$scope.ExcelFilterEndDate = $scope.RootEndDate;     
		$scope.ExcelFilterStartDate = $scope.RootStartDate;      
	
		$scope.AlertFilterEndDate = $scope.RootEndDate;    
		$scope.AlertFilterStartDate = $scope.RootStartDate;
		
		$scope.SMDatBarChartFilterEndDate = $scope.RootEndDate;    
		$scope.SMDatBarChartFilterStartDate = $scope.RootStartDate;
		
		$scope.ReloadAllWidgets();
	}
	$scope.snackbarTextMessage = "";
	$scope.MessagingIsOn = false;
	$scope.trafficCop = trafficCop;
	$scope.ShowTrafficIndication = true;
	$scope.excludedRequests = ['GetAllNewContactFormMessages'];
                // We can now watch the trafficCop service to see when there are pending
                // HTTP requests that we're waiting for.
                
				$scope.$watch(
                    function calculateModelValue() {
                    	//console.log(trafficCop);
                        return( trafficCop.pending.all);
                    },
                    function handleModelChange( count ) {
                        /*console.log(
                            "Pending HTTP count:", count,
                            "{",
                                trafficCop.pending.get, "GET ,",
                                trafficCop.pending.post, "POST",
                           "}"
                        );*/
                       // console.log($scope.trafficCop);
                        //console.log('here');
                       //count = pending.all;
                      // url = pending.url;
                      // console.log(pending);
                      //var myarray = $scope.trafficCop.pending.url.split('/');
                       //blval = $scope.isInArray(myarray[2], $scope.excludedRequests);
                       //console.log(blval);
                        //console.log('infor');
                        //console.log(resp);
                        //var str = config.url;
                        //var myarray = str.split('/');
						if($scope.ShowTrafficIndication)
						{
							if(count>0)
							{
								$scope.snackbarTextMessage = "Processing "+count+" requests";
								$scope.showsnackbar();
							}
							else 
							{
								$scope.snackbarTextMessage = "All done and we are back";
								$scope.hidesnackbar();
							}
						}
						else
							$scope.hidesnackbar();
                    }
                );
    $scope.isInArray = function (value, array) {
                      return array.indexOf(value) > -1;
                    }
	$scope.showsnackbar = function () {
		var x = document.getElementById("snackbar")
		x.className = "show";
		//setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
	}
	$scope.hidesnackbar = function () {
		var x = document.getElementById("snackbar")
		//x.className = "show";
		//setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
		x.className = x.className.replace("show", "");
	}
        
    $scope.LogActivityDefaultOption = 2;
    $scope.AllUserTitles = [];
	$scope.AllWidgetsList = null;
	$scope.ContactFormMessageList = null;
	$scope.ContactFormMessageNewCount = 0;
	$scope.ToGroupListForContactMessages = null;
	$scope.LoggedUserName = "";
		$scope.weatherchartResized=false;   
		$scope.occupancychartResized=false;   
	$scope.OccupancyFormType= "LIST";
	$scope.ObservationEditFormType = "";
	$scope.ObservationFormType= "LIST";
	$scope.ObservationDisplayType= "SM";
	$scope.HotelVisitFormType= "LIST";
	$scope.HotelContactsFormType= "LIST";
	$scope.ExcelFormType= "LIST";
	$scope.EditingOccupancy = {"pk":"0","date":"","covers":"0","rooms":"0","functions":"0","delegates":"0","spa":"0","sleepers":"0","hotel":"","hotelid":""};
	$scope.HotelSettings = {"ID":"0","OnSpeacialMeasure":true, "AnnualConsumption":"", "SMStartDate":"", "SMEndDate":"", "GM_UserID":0, "MM_UserID":0, "HKHead_UserID":0, "HotelID":0,"Notes":"","HotelVisits":null};
	$scope.EditingHotelVisit = {"ID":0,"VisitTypeID":null,"VisitDate":"","VisitedUserID":null,"Remark":"","HotelSettingsID":0,"Vdate":""};
	$scope.EditingHotelContacts = {"ID":0,"UserID":0,"HotelSettingsID":0};
	$scope.user = {"ID":"0","Username":"","Password":"","Email":"","Firstname":"","Lastname":"","CreatedDate":"","IsAdmin":"","Active":"","Mobile":"","ConfirmPassword":"","userhotels":null};
	
	$scope.ContactFormMessage = {"ID":"0","Subject":"","Message":""};
	$scope.ExportColumnsLogActivity = "CreatedDate,Description,Username,HotelName";
	$scope.ExportColumnsHotelSettingsVisits = "Name Type,VisitDate,VisitedUserName,Remark";
	$scope.ExportColumnsHotelSettingsContacts = "Title,Username";
	$scope.ExportColumnsOccupancytable = "date,covers,rooms,sleepers,functions,delegates,spa";
	$scope.ExportColumnsWeathertable = "date,temp,hdd,cdd";
 	$scope.ExportColumnsCircuittable = "Name,sum_min,sum_avg,sum_max,aut_min,aut_avg,aut_max,win_min,win_avg, win_max,spr_min, spr_avg,spr_max";

		
	$scope.ExportColumnsObservationsALL = "StatusName,DiscoveredDate,whereName,what,ShortDescription,ID RefID";
	$scope.ExportColumnsObservationsSM = "StatusName,DiscoveredDate,whereName,what,ShortDescription,ID RefID";
	$scope.ExportColumnsObservationsGM = "StatusName,DiscoveredDate,whereName,what,ShortDescription,ID RefID";
	$scope.ExportColumnsObservationsOBS = "StatusName,DiscoveredDate,whereName,what,ShortDescription,ID RefID";





	
	$scope.AddNewObservationParams = {"HotelID":0,"TypeID":"1","GroupID":"0"};
	$scope.ObservationPriorityNumbers = [
      {num: ""},{num: "1"},{num: "2"},{num: "3"},{num: "4"},{num: "5"},{num: "6"},{num: "7"},{num: "8"},{num: "9"},{num: "10"},
	  {num: "11"},{num: "12"},{num: "13"},{num: "14"},{num: "15"},{num: "16"},{num: "17"},{num: "18"},{num: "19"},{num: "20"}
    ];
	
	$scope.ObservationEditingItem= null;
	$scope.SelectedHotel = null;
	$scope.SelectedHotelFuntionalGroups=null;
	$scope.ExcelGraphsList = null;
	
	$scope.DashboardPostParams = [];
	$scope.OccupancyPostParams = [];
	
	$scope.ShowOtherSampleWidgets = false;
	
	
	
	
	$scope.LogActivityErrorMessage = "";
	$scope.HotelSettingsErrorMessage = "";
	$scope.ObservationsErrorMessage = "";
	
	$scope.isLogActivityLoading = true;
	$scope.isHotelSettingsLoading = true;
	$scope.isHotelSettingsVisitInfoLoading = true;
	$scope.isWeatherInfoLoading = true;
	$scope.isOccupancyInfoLoading = true;
	$scope.isExcelInfoLoading = true;
	$scope.isExcelChartInfoLoading = true;
	$scope.isAlertsInfoLoading = true;
	$scope.isCircuitsInfoLoading = true;
	$scope.isObservationInfoLoading = true;
        $scope.isExcelPrintInfoLoading = true;
	$scope.isSMDataBarChartInfoLoading = true;
	$scope.isReportFileDownloaderLoading = true;
	
	$scope.userWidgets = null;
	$scope.isUserAadmin = false;
	$scope.selectedID = [];
	$scope.CircuitsBreadCrumb = [];
	$scope.ExcelPrintItem = null;
	$scope.Channels = null;
	$scope.userAssignedHotels = null;
	$scope.WeatherList = null;
	$scope.OccupancyList = null;
	$scope.AlertList = null;
	$scope.AlertSetList = null;
	$scope.CircuitDetailsList = null;
	$scope.ClickedCuircuit = null;
	$scope.ObservationsDetailsList = null;
	$scope.ObservationsSMDetailsList = null;
        $scope.ObservationsAllDetailsList = null;
	$scope.ObservationsGMDetailsList = null;
	$scope.ObservationsOBSDetailsList = null;
	$scope.ObservationsTypesList = null;
	$scope.ObservationsCategoryList = null;
	$scope.ObservationsStatusList = null;
	$scope.ObservationsFundingList = null;
	$scope.ObservationImagesList = null;
	$scope.LogActivityList = null;
	$scope.ExcelChartDataList = null;
	$scope.ReportsToDownloadList = null;
	//file upload variables
	$scope.ObservationImageform = [];
	$scope.reportUploadForm = {"ReportType":'',"uFile":""};
	$scope.files = [];

	//----------
	
	
	
    $scope.logoutUser = function () {
		//alert('fromm reports ctrl');
        $rootScope.$emit('logoutEvent',{});
    };
	
	$scope.AssignColor = function (smdataColor) {
		
		if(smdataColor!=$scope.SelectedHotel.color)
		{
			//alert(smdataColor);
			$scope.SelectedHotel.color = smdataColor;
			
		  
			angular.forEach($scope.Channels, function(chn) 
			{
				angular.forEach(chn.Channels, function(cc) 
				{
					//alert(cc.color);
					if(cc.GroupId == $scope.SelectedHotel.GroupId)
						cc.color = smdataColor;
				});
							
			});
			
		}
    };
	
	$scope.ShowHotelColor = function (color)
	{
		//alert(color);
		if($scope.Menu_Hotel_Red)
			return color;
		else
			return 'white';
	};
	
	$scope.AssignColors = function (smdataColors) {
		
		
		  angular.forEach(smdataColors, function(smdataColor) 
			{
				angular.forEach($scope.Channels, function(chn) 
				{
					angular.forEach(chn.Channels, function(cc) 
					{
						//alert(cc.color);
						if(cc.GroupId == smdataColor.GroupId)
							cc.color = smdataColor.color;
					});
								
				});
			});
			
		
    };
	
	$scope.userAssignedHotels = function(item, index){
         if(index == 0){
             return item.value;
         }
        return '';
    }; 
	
		//weather paging
			$scope.Weatherpredicate = '';  
			$scope.WeatherPagingreverse = true;  
			$scope.WeatherPagingcurrentPage = 1;  
		   
			$scope.Weatherorder = function (predicate) {  
				$scope.WeatherPagingreverse = ($scope.Weatherpredicate === predicate) ? !$scope.WeatherPagingreverse : false;  
				$scope.Weatherpredicate = predicate;  
			};  
		   
		   
			$scope.WeatherPagingnumPerPage = 10;  
			$scope.Weatherpaginate = function (value) {  
			//alert('weather');
			 var begin, end, index;  
			 begin = ($scope.WeatherPagingcurrentPage - 1) * $scope.WeatherPagingnumPerPage;  
			 end = begin + $scope.WeatherPagingnumPerPage;  
			 index = $scope.WeatherList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//weather paging variables end
		
		//Occupancy paging
			$scope.Occupancypredicate = 'date';  
			$scope.OccupancyPagingreverse = true;  
			$scope.OccupancyPagingcurrentPage = 1;  
		   
			$scope.Occupancyorder = function (predicate) {  
				$scope.OccupancyPagingreverse = ($scope.Occupancypredicate === predicate) ? !$scope.OccupancyPagingreverse : false;  
				$scope.Occupancypredicate = predicate;  
			};  
		   
		   
			$scope.OccupancyPagingnumPerPage = 10;  
			$scope.Occupancypaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.OccupancyPagingcurrentPage - 1) * $scope.OccupancyPagingnumPerPage;  
			 end = begin + $scope.OccupancyPagingnumPerPage;  
			 index = $scope.OccupancyList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Occupancy paging variables end
		
		//LogActivity paging
			$scope.LogActivitypredicate = 'CreatedDate';  
			$scope.LogActivityPagingreverse = true;  
			$scope.LogActivityPagingcurrentPage = 1;  
		   
			$scope.LogActivityorder = function (predicate) {  
				$scope.LogActivityPagingreverse = ($scope.LogActivitypredicate === predicate) ? !$scope.LogActivityPagingreverse : false;  
				$scope.LogActivitypredicate = predicate;  
			};  

			 
		   
		   
			$scope.LogActivityPagingnumPerPage = 10;  
			$scope.LogActivitypaginate = function (value) {  
			//alert('log');
			 var begin, end, index;  
			 begin = ($scope.LogActivityPagingcurrentPage - 1) * $scope.LogActivityPagingnumPerPage;  
			 end = begin + $scope.LogActivityPagingnumPerPage;  
			 index = $scope.LogActivityList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//LogActivity paging variables end
		
		//Excel paging
			$scope.Excelpredicate = 'date';  
			$scope.ExcelPagingreverse = true;  
			$scope.ExcelPagingcurrentPage = 1;  
		   
			$scope.Excelorder = function (predicate) {  
				$scope.ExcelPagingreverse = ($scope.Excelpredicate === predicate) ? !$scope.ExcelPagingreverse : false;  
				$scope.Excelpredicate = predicate;  
			};  
		   
		   
			$scope.ExcelPagingnumPerPage = 7;  
			$scope.Excelpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ExcelPagingcurrentPage - 1) * $scope.ExcelPagingnumPerPage;  
			 end = begin + $scope.ExcelPagingnumPerPage;  
			 index = $scope.ExcelList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Excel paging variables end
		
		
		//Alert paging
			$scope.Alertpredicate = '';  
			$scope.AlertPagingreverse = true;  
			$scope.AlertPagingcurrentPage = 1;  
		   
			$scope.Alertorder = function (predicate) {  
				$scope.AlertPagingreverse = ($scope.Alertpredicate === predicate) ? !$scope.AlertPagingreverse : false;  
				$scope.Alertpredicate = predicate;  
			};  
		   
		   
			$scope.AlertPagingnumPerPage = 7;  
			$scope.Alertpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.AlertPagingcurrentPage - 1) * $scope.AlertPagingnumPerPage;  
			 end = begin + $scope.AlertPagingnumPerPage;  
			 index = $scope.AlertList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Alert paging variables end
		
		
		//AlertSet paging
			$scope.AlertSetpredicate = '';  
			$scope.AlertSetPagingreverse = true;  
			$scope.AlertSetPagingcurrentPage = 1;  
		   
			$scope.AlertSetorder = function (predicate) {  
				$scope.AlertSetPagingreverse = ($scope.AlertSetpredicate === predicate) ? !$scope.AlertSetPagingreverse : false;  
				$scope.AlertSetpredicate = predicate;  
			};  
		   
		   
			$scope.AlertSetPagingnumPerPage = 7;  
			$scope.AlertSetpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.AlertSetPagingcurrentPage - 1) * $scope.AlertSetPagingnumPerPage;  
			 end = begin + $scope.AlertSetPagingnumPerPage;  
			 index = $scope.AlertSetList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//AlertSet paging variables end
		
		
		//HoelVisit paging
			$scope.HotelVisitpredicate = 'VisitDate';  
			$scope.HotelVisitPagingreverse = true;  
			$scope.HotelVisitPagingcurrentPage = 1;  
		   
			$scope.HotelVisitorder = function (predicate) {  
				$scope.HotelVisitPagingreverse = ($scope.HotelVisitpredicate === predicate) ? !$scope.HotelVisitPagingreverse : false;  
				$scope.HotelVisitpredicate = predicate;  
			};  
		   
		   
			$scope.HotelVisitPagingnumPerPage = 5;  
			$scope.HotelVisitpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.HotelVisitPagingcurrentPage - 1) * $scope.HotelVisitPagingnumPerPage;  
			 end = begin + $scope.HotelVisitPagingnumPerPage;  
			 index = $scope.HotelSettings.HotelVisits.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Hotel Visit paging variables end
		

		//ReportstoDOwnload

			$scope.Reportstodownloadpredicate = 'FolderName';  
			$scope.ReportstodownloadPagingreverse = true;  
			$scope.ReportstodownloadPagingcurrentPage = 1;  
		   
			$scope.Reportstodownloadorder = function (predicate) {  
				$scope.ReportstodownloadPagingreverse = ($scope.Reportstodownloadpredicate === predicate) ? !$scope.ReportstodownloadPagingreverse : false;  
				$scope.Reportstodownloadpredicate = predicate;  
			};  
		   
		   
			$scope.ReportstodownloadPagingnumPerPage = 5;  
			$scope.Reportstodownloadpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ReportstodownloadPagingcurrentPage - 1) * $scope.ReportstodownloadPagingnumPerPage;  
			 end = begin + $scope.ReportstodownloadPagingnumPerPage;  
			 index = $scope.ReportsToDownloadList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		// End 

		//ReportsToEmailList

			$scope.ReportsToEmailListpredicate = 'Email';  
			$scope.ReportsToEmailListPagingreverse = true;  
			$scope.ReportsToEmailListPagingcurrentPage = 1;  
		   
			$scope.ReportsToEmailListorder = function (predicate) {  
				$scope.ReportsToEmailListPagingreverse = ($scope.ReportsToEmailListpredicate === predicate) ? !$scope.ReportsToEmailListPagingreverse : false;  
				$scope.ReportsToEmailListpredicate = predicate;  
			};  
		   
		   
			$scope.ReportsToEmailListPagingnumPerPage = 15;  
			$scope.ReportsToEmailListpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ReportsToEmailListPagingcurrentPage - 1) * $scope.ReportsToEmailListPagingnumPerPage;  
			 end = begin + $scope.ReportsToEmailListPagingnumPerPage;  
			 index = $scope.ReportSendToUsersList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		// End 


		//HoelVisit paging
			$scope.HotelContactspredicate = 'NameOfUser';  
			$scope.HotelContactsPagingreverse = false;  
			$scope.HotelContactsPagingcurrentPage = 5;  
		   
			$scope.HotelContactsorder = function (predicate) {  
				$scope.HotelContactsPagingreverse = ($scope.HotelContactspredicate === predicate) ? !$scope.HotelContactsPagingreverse : false;  
				$scope.HotelContactspredicate = predicate;  
			};  
		   
		   
			$scope.HotelContactsPagingnumPerPage = 3;  
			$scope.HotelContactspaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.HotelContactsPagingcurrentPage - 1) * $scope.HotelContactsPagingnumPerPage;  
			 end = begin + $scope.HotelContactsPagingnumPerPage;  
			 index = $scope.HotelSettings.HotelContacts.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Hotel Visit paging variables end
		
		//Observation paging
			$scope.Observationpredicate = '';  
			$scope.ObservationPagingreverse = true;  
			$scope.ObservationPagingcurrentPage = 1;  
		   
			$scope.Observationorder = function (predicate) {  
				$scope.ObservationPagingreverse = ($scope.Observationpredicate === predicate) ? !$scope.ObservationPagingreverse : false;  
				$scope.Observationpredicate = predicate;  
			};  
		   
		   
			$scope.ObservationPagingnumPerPage = 7;  
			$scope.Observationpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ObservationPagingcurrentPage - 1) * $scope.ObservationPagingnumPerPage;  
			 end = begin + $scope.ObservationPagingnumPerPage;  
			 index = $scope.ObservationsDetailsList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Observation paging variables end
		
		
		//Observation Images paging
			$scope.ObservationImagespredicate = '';  
			$scope.ObservationImagesPagingreverse = true;  
			$scope.ObservationImagesPagingcurrentPage = 1;  
		   
			$scope.ObservationImagesorder = function (predicate) {  
				$scope.ObservationImagesPagingreverse = ($scope.ObservationImagespredicate === predicate) ? !$scope.ObservationImagesPagingreverse : false;  
				$scope.ObservationImagespredicate = predicate;  
			};  
		   
		   
			$scope.ObservationImagesPagingnumPerPage = 1;  
			$scope.ObservationImagespaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ObservationImagesPagingcurrentPage - 1) * $scope.ObservationImagesPagingnumPerPage;  
			 end = begin + $scope.ObservationImagesPagingnumPerPage;  
			 index = $scope.ObservationImagesList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Observation  Images paging variables end
		
                //Observation All paging
			$scope.ObservationAllpredicate = 'whereName';  
			$scope.ObservationAllPagingreverse = true;  
			$scope.ObservationAllPagingcurrentPage = 1;  
		   
			$scope.ObservationAllorder = function (predicate) {  
                           // alert(predicate);
                                $scope.ObservationAllPagingnumPerPage = $scope.ObservationsAllDetailsList.length;
				$scope.ObservationAllPagingreverse = ($scope.ObservationAllpredicate === predicate) ? !$scope.ObservationAllPagingreverse : false;  
				$scope.ObservationAllpredicate = predicate;  
                                //$scope.ObservationAllPagingnumPerPage = 10;
                                
			};  
		   
		   
			$scope.ObservationAllPagingnumPerPage = 10;  
			$scope.ObservationAllpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ObservationAllPagingcurrentPage - 1) * $scope.ObservationAllPagingnumPerPage;  
			 end = begin + $scope.ObservationAllPagingnumPerPage;  
			 index = $scope.ObservationsAllDetailsList.indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Observation paging variables end
		
		//Observation SM paging
			$scope.ObservationSMpredicate = 'whereName';  
			$scope.ObservationSMPagingreverse = true;  
			$scope.ObservationSMPagingcurrentPage = 1;  
		   
			$scope.ObservationSMorder = function (predicate) {  
                           // alert(predicate);
				$scope.ObservationSMPagingreverse = ($scope.ObservationSMpredicate === predicate) ? !$scope.ObservationSMPagingreverse : false;  
				$scope.ObservationSMpredicate = predicate;  
			};  
		   
		   
			$scope.ObservationSMPagingnumPerPage = 10;  
			$scope.ObservationSMpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ObservationSMPagingcurrentPage - 1) * $scope.ObservationSMPagingnumPerPage;  
			 end = begin + $scope.ObservationSMPagingnumPerPage;  
			 index = $scope.GetFilteredOBSDetailsByType(3).indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Observation paging variables end
		
		//Observation GM paging
			$scope.ObservationGMpredicate = 'whereName';  
			$scope.ObservationGMPagingreverse = true;  
			$scope.ObservationGMPagingcurrentPage = 1;  
		   
			$scope.ObservationGMorder = function (predicate) {  
				$scope.ObservationGMPagingreverse = ($scope.ObservationGMpredicate === predicate) ? !$scope.ObservationGMPagingreverse : false;  
				$scope.ObservationGMpredicate = predicate;  
			};  
		   
		   
			$scope.ObservationGMPagingnumPerPage = 10;  
			$scope.ObservationGMpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ObservationGMPagingcurrentPage - 1) * $scope.ObservationGMPagingnumPerPage;  
			 end = begin + $scope.ObservationGMPagingnumPerPage;  
			 index = $scope.GetFilteredOBSDetailsByType(2).indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Observation paging variables end
		
		//Observation OBS paging
			$scope.ObservationOBSpredicate = 'whereName';  
			$scope.ObservationOBSPagingreverse = true;  
			$scope.ObservationOBSPagingcurrentPage = 1;  
		   
			$scope.ObservationOBSorder = function (predicate) {  
				$scope.ObservationOBSPagingreverse = ($scope.ObservationOBSpredicate === predicate) ? !$scope.ObservationOBSPagingreverse : false;  
				$scope.ObservationOBSpredicate = predicate;  
			};  
		   
		   
			$scope.ObservationOBSPagingnumPerPage = 10;  
			$scope.ObservationOBSpaginate = function (value) {  
			 var begin, end, index;  
			 begin = ($scope.ObservationOBSPagingcurrentPage - 1) * $scope.ObservationOBSPagingnumPerPage;  
			 end = begin + $scope.ObservationOBSPagingnumPerPage;  
			 index = $scope.GetFilteredOBSDetailsByType(1).indexOf(value);  
			 return (begin <= index && index < end);  
			};  
		//Observation paging variables end
	
	
	$scope.EditOccupancy = function (OccupancyEditItem) {
		$scope.OccupancyFormType= "EDIT";
		$scope.EditingOccupancy = OccupancyEditItem;
	};
	$scope.CancelEditOccupancy = function () {
		$scope.OccupancyFormType= "LIST";
		$scope.EditingOccupancy = {"pk":"0","date":"","covers":"0","rooms":"0","functions":"0","delegates":"0","spa":"0","sleepers":"0","hotel":$scope.SelectedHotel.Name,"hotelid":$scope.SelectedHotel.GroupId};
	};
	$scope.ShowAddOccupancyForm = function () {
		$scope.OccupancyFormType= "ADD";
		$scope.EditingOccupancy = {"pk":"0","date":"","covers":"0","rooms":"0","functions":"0","delegates":"0","spa":"0","sleepers":"0","hotel":$scope.SelectedHotel.Name,"hotelid":$scope.SelectedHotel.GroupId};
		//$scope.EditingOccupancy.Hotelid = $scope.userAssignedHotels[0].GroupId;
	};
	
	$scope.ShowExcelPrintPageForm = function () {
                
		//$scope.ExcelFormType= "PRINT";
		$scope.ExcelPostParams = {'ExcelStartDate': $scope.formatDateMysql($scope.ExcelFilterStartDate) , 'ExcelEndDate':$scope.formatDateMysql($scope.ExcelFilterEndDate),'SelectedHotel':$scope.SelectedHotel.GroupId,'Date':''};
		if($scope.ExcelPrintItem==null)
		{
			$scope.isExcelPrintInfoLoading = true;
			Data.post('LoadExcelPrintDetail',{
					dparams: $scope.ExcelPostParams
				}).then(function (results) {
					$scope.ExcelPrintItem = results.ExcelPrint;
                                        $scope.isExcelPrintInfoLoading = false;
				}); 
		}
	};
	
	$scope.SaveExcelPrintPageForm = function () {
		if($scope.ExcelPrintItem!=null)
		{
			Data.post('UpdateExcelPrintDetails',{
					ExcelPrintDetails: $scope.ExcelPrintItem
				}).then(function (results) {
					if (results.status == "success") {
						
						$scope.ExcelPrintItem.SmDataID = results.ID;
					}
					Data.toast(results);
				}); 
		}
	};
	$scope.ShowExcelGraphs = function () {
		//alert('came');
		var width= $("#excelGraphMainDiv").width();
                //alert(width);
                
		
		$scope.ExcelPostParams = {'ExcelStartDate': $scope.formatDateMysql($scope.ExcelFilterStartDate) , 'ExcelEndDate':$scope.formatDateMysql($scope.ExcelFilterEndDate),'SelectedHotel':$scope.SelectedHotel.GroupId,'width':width};
		if($scope.ExcelGraphsList==null)
		{
			//alert('inside');
                    $scope.isExcelChartInfoLoading = true;
			Data.post('LoadExcelChart',{
					dparams: $scope.ExcelPostParams
				}).then(function (results) {
					$scope.ExcelGraphsList = results.Excel.Linechart;
					$scope.ExcelChartDataList = results.Excel.ExcelChartData;
					eval(" ExcelGraphChartObj = new Highcharts.Chart("+results.Excel.Linechart+");");
                                        //alert(ExcelGraphChartObj);
                                        //ExcelGraphChartObj.reflow();
                                        //ExcelGraphChartObj.redraw();
					$scope.isExcelChartInfoLoading = false;
				}); 
		}
	};
	$scope.CancelExcelPrintPageForm = function () {
		$scope.ExcelFormType= "LIST";
	};
	$scope.DoSaveOccupancyChanges = function (OccupancyEditedItem) {

			//alert(OccupancyEditedItem.pk);
			//alert(OccupancyEditedItem.hotelid);
			//alert(OccupancyEditedItem.date);
                        OccupancyEditedItemCopy = OccupancyEditedItem;
                        OccupancyEditedItem.date = $scope.formatDateMysql(OccupancyEditedItem.date);
			Data.post('UpdateOccupancy', {
				Occupancy: OccupancyEditedItem
			}).then(function (results) {
				//Data.toast(results);
				if (results.status == "success") {
					Data.toast(results);
					$scope.OccupancyFormType= "LIST";
					$scope.ReloadOccupancyInformation();
				}
				if (results.status == "error") {
					Data.toast(results);
					
				}
			});
		
    };
	
	

	$scope.ReloadWeatherInformation = function () {
		//alert($scope.WeatherFilterStartDate);
		//alert($scope.WeatherFilterEndDate);
		$scope.DashboardPostParams = {'WeatherStartDate': $scope.formatDateMysql($scope.WeatherFilterStartDate) , 'WeatherEndDate':$scope.formatDateMysql($scope.WeatherFilterEndDate),'SelectedHotel':$scope.SelectedHotel.GroupId};
		//alert($scope.DashboardPostParams);
		$scope.LoadWeatherInformation();
	};
	
	$scope.ReloadAlertInformation = function () {
		$scope.LoadAlertInformation();
	};
	
	$scope.exportDataToCsv = function (ExportData, Filename, columns) 
	{
		var mystyle = {
	        headers: true
	    };
    
		if(columns==null)
			columns ="*";
		
		if(ExportData.length>0)
		{
				//alasql('SELECT '+columns+' INTO XLSX("'+Filename+'.xlsx",{headers:true}) FROM ?',[ExportData]);
		
			alasql('SELECT '+columns+' INTO XLSX("'+Filename+'.xlsx",?) FROM ?',[mystyle,ExportData]);
		}
		else
			Data.Addtoast("error","No records found to export");
    };
    
    
    $scope.exportDataToMMCsv = function (ExportData, Filename, columns) 
	{
		var mystyle = {
	        headers: true
	    };
    
		if(columns==null)
			columns ="*";
		
		if(ExportData.length>0)
		{
				//alasql('SELECT '+columns+' INTO XLSX("'+Filename+'.xlsx",{headers:true}) FROM ?',[ExportData]);
		
			alasql('SELECT '+columns+' INTO CSV("'+Filename+'.csv",?) FROM ?',[mystyle,ExportData]);
		}
		else
			Data.Addtoast("error","No records found to export");
    };
	
	$scope.HasPermission = function(keyname) {
		
		//alert($scope.userWidgets);
		//alert(keyname);
		angular.forEach($scope.userWidgets, function(widget) {
			if(widget.Name === keyname)
			{
				//alert('found');
				//console.log('found permission	');
				$parse(widget.Name).assign($scope, 1); 
				//console.log($scope.HotelSettings_Info_Save);
				//return true;
			}
		}
		)
		//return false;
	}
	
	$scope.CheckPermission = function () {
		
		
		angular.forEach($scope.userWidgets, function(widget) {
			
				$scope[widget.Name] = (widget.Active==1);
				
		}
		)
        
                if($scope.ExcelTable_kWh)
                $scope.activeExcelInfoTab = 1;
                else if($scope.ExcelTable_Cost)
				$scope.activeExcelInfoTab = 2;
		
	};
	
	$scope.ReloadOccupancyInformation = function () {
		
		$scope.LoadOccupancyInformation()
	};
	
	$scope.ReloadExcelInformation = function () {
		
                $scope.ExcelGraphsList = null;
		$scope.LoadExcelInformation()
	};
	
	$scope.getMenuCss = function (chn) {
		if(chn.Channels.length<=0)
			return "";
		else
			return "flyout-alt";
    };
	
	$scope.ClickChannel = function(channel)
	{
		
            if(channel.GroupId<=1)
                return;
            
                var firstElement = null;
					angular.forEach($scope.Channels, function(chn) {
							firstElement = chn;
							
				});
				//alert(firstElement)
				UncheckAll(firstElement);
	  
				if($scope.SelectedHotel!=channel.GroupId)
				{
					//$scope.SelectedHotel = channel.GroupId;
					$scope.SelectedHotel = channel;
					//$scope.SelectedHotelChannel = channel;
					
					channel.isChecked = true;
					//LoadDashboard();
					//alert($scope.SelectedHotel);
					$scope.UpdateCurrentlyBrowsingHotel();
					$scope.ReloadAllWidgets();
				}
            
	};
	
	$scope.ReloadAllWidgets = function()
	{
		$scope.clearIntervals();
		$scope.ExcelPrintItem=null;
					$scope.ExcelGraphsList=null;
					$scope.LoadWidgets();
					$scope.ExcelFormType= "LIST";
					$scope.OccupancyFormType= "LIST";
					$scope.EditingOccupancy = {"pk":"0","date":"","covers":"0","rooms":"0","functions":"0","delegates":"0","spa":"0","sleepers":"0","hotel":"","hotelid":""};
					$scope.HotelSettings = {"ID":"0","OnSpeacialMeasure":true, "AnnualConsumption":"", "SMStartDate":"", "SMEndDate":"", "GM_UserID":0, "MM_UserID":0, "HKHead_UserID":0, "HotelID":0,"HotelVisits":null};
					$scope.EditingHotelVisit = {"ID":0,"VisitTypeID":0,"VisitDate":"","VisitedUserID":0,"Remark":"","HotelSettingsID":0,"Vdate":""};


	
	}
	
	function parentCheckChange(item) 
	{
	    for (var i in item.Channels) {
	      item.Channels[i].isChecked = item.isChecked;
		  
			var grpid= item.Channels[i].GroupId;
			var kk = $scope.selectedID.indexOf(grpid);
			if(kk != -1) {
				if(!item.Channels[i].isChecked)
				$scope.selectedID.splice(kk, 1);
				//delete $scope.selectedID[kk];
			}
			else
			{
				if(item.Channels[i].isChecked)
				$scope.selectedID.push(grpid);
			}
		  
	      if (item.Channels[i].Channels) {
	        parentCheckChange(item.Channels[i]);
	      }
	    }
  	}
	
	function UncheckAll(item) 
	{
		
	    for (var i in item.Channels) {
	      item.Channels[i].isChecked = false;
		  //item.Channels[i].color = 'white';
			
	      if (item.Channels[i].Channels) {
	        UncheckAll(item.Channels[i]);
	      }
	    }
  	}

	
	function LoadDashboard()
	{
		//var checkfirst = 0;
		//Data.Addtoast("info","Loading Chart");
			Data.get('LoadDashboardConfigs').then(function (sessionresults) {
				//console.log(sessionresults);
				$scope.clearIntervals();
				//if(!(typeof sessionresults === 'undefined' || sessionresults === null  || sessionresults.Error)
				//	&& (!(typeof sessionresults.data === 'undefined' || sessionresults.data === null  || sessionresults.data.Error)))
				if(!Utils.isUndefinedOrNull(sessionresults) && !Utils.isUndefinedOrNull(sessionresults.data) && !Utils.isUndefinedOrNull(sessionresults.data) && !sessionresults.data.Error)
				{
					sessionresults = sessionresults.data;
					//alert(sessionresults.userWidgets);
					$scope.SelectedHotel = sessionresults.SelectedHotel;
					//Below is moved to new role system
					//$scope.userWidgets =  sessionresults.userWidgets;
					$scope.userWidgets =  sessionresults.userPermissions;
					
					$scope.Channels = sessionresults.channels.data;
					
					angular.forEach($scope.Channels, function(chn) {
								$scope.userAssignedHotels = chn.Channels;
					});
					
					
					
					$scope.isUserAadmin = sessionresults.isadmin;
					//$scope.LoggedUserName = sessionresults.LoggedUserName;
					//alert($scope.LoggedUserName);
					$scope.AllWidgetsList = sessionresults.AllWidgetsList;
					$scope.CheckPermission();
					
					$timeout( function(){   $scope.LoadWidgets();  }, 3000);

					
				}
				else
				{
					
					Data.Addtoast("error","There was an error. We are retrying");
					
					$timeout( function(){  LoadDashboard();  }, 3000);
				}
				
            });
			
		
			/*
			LoadSampleChart();
			
			
			
			
			LoadOccupancyInformation();
			
			LoadExcelInformation();
			
			//thisObj.setMyChart();   
			*/

			thisObj1.callNotificationScripts();   
			
			thisObj1.createSidemenuscripts();   
	}
	
$scope.GenerateRandomString = function ()
{
	 var s = [];
            var hexDigits = "0123456789abcdef";
            for (var i = 0; i < 36; i++) {
                s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
            }
            s[14] = "4";  // bits 12-15 of the time_hi_and_version field to 0010
            s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);  // bits 6-7 of the clock_seq_hi_and_reserved to 01
            s[8] = s[13] = s[18] = s[23] = "-";
            return s.join("");
}
$scope.$on('$destroy', function() {
	//alert('came');
	angular.forEach($scope.AllWidgetsList, function(tmp) {
    	$templateCache.remove(tmp.TemplatePath);
	});
      $scope.clearIntervals();
 });

$scope.clearIntervals = function ()
{
	angular.forEach($scope.intervals, function(interval) {
    $interval.cancel(interval);
	});
}

	$scope.LoadWidgets = function () 
	{

				$scope.DoWriteLog('Logged in','Login');

				

				if($scope.Widget_WeatherTable || $scope.Widget_WeatherLineChart) 
				{
					$scope.LoadWeatherInformation();
				}	 	
				
				if($scope.Widget_OccupancyTable || $scope.Widget_OccupancyColumnChart)
					$scope.LoadOccupancyInformation();
				
				
				//$scope.ShowOccupancyEdit = true;
				//$scope.ShowOccupancyAdd = true;
				if($scope.Widget_ExcelTable)
					$scope.LoadExcelInformation();
				
				if($scope.Widget_AlertsTable)
					$scope.LoadAlertInformation();
				//alert($scope.ShowHotelSettingsTable);
				if($scope.Widget_HotelSettings)
					$scope.LoadHotelSettings();
				
				if($scope.Widget_CircuitDetails)
				$scope.LoadCircuitInformation(null);
			
				if($scope.Widget_ObservationTable)
					$scope.LoadOBSDetails();
				//$scope.LoadObservationsInformation();
				//$scope.PrepareOBSAddFeature();
				//alert($scope.ShowLogActivityTable);
				if($scope.Widget_LogActivity)
					$scope.LoadLogActivity();
				
				if($scope.Widget_SMdataBarChart)
				$scope.LoadSMDataBarChart();

				if($scope.Widget_ReportFileDownloader)
				$scope.GetReportsToDownload();
			    //if($scope.ShowSMDataBarChart)
				//if($scope.Widget_LogActivity)
				//$scope.intervals.push($interval( function(){   $scope.LoadLogActivity(); }, 60000));

				if($scope.MessagingIsOn)
	     		$scope.intervals.push($interval( function(){ $scope.GetAllNewContactFormMessages(); }, 6000));

	     		if(!$scope.isUserAadmin && $scope.MessagingIsOn)
			    $scope.GetToGroupForContactMessages(); 

				if($scope.Notification_HeaderMessages)
				$scope.GetHeaderMessages();


//				$timeout( function(){  $scope.SetDragableWidgets();   }, 5000);
				
	}
		
	$scope.LoadDataForNotifications = function () 
	{
		$timeout( function(){  $scope.GetAllNewContactFormMessages();   }, 5000);
						
	}

	function LoadSampleChart()
	{
		Data.Addtoast("info","Loading Chart");
			Data.get('sampleHightChartData').then(function (results) {
				//alert(results.Data);
				
						eval("var chart = new Highcharts.Chart("+results.Data+");");
						Data.Addtoast("info","Chart Loaded");
            });
		
	}
	
	//function LoadWeatherInformation()
	$scope.LoadWeatherInformation = function () 
	{
		$scope.isWeatherInfoLoading =true;
		$scope.DashboardPostParams = {'WeatherStartDate': $scope.formatDateMysql($scope.WeatherFilterStartDate) , 'WeatherEndDate':$scope.formatDateMysql($scope.WeatherFilterEndDate),'SelectedHotel':$scope.SelectedHotel.GroupId};
					
		
		 //Data.Addtoast("info","Loading Hotel List");
			Data.post('LoadWeather',{
				dparams: $scope.DashboardPostParams
			}).then(function (results) {
				//alert(results.weather.Linechart);
				
				if(results.weather.status=="success")
				{
						$scope.WeatherList = results.weather.data;
						$scope.WeathertotalItems = $scope.WeatherList.length; 
						Data.Addtoast("info","Weather details Loaded");
						//$scope.Channels = results.channels.data;
						//Data.Addtoast("info","Hotel Loaded");
						eval("WeatherchartObj = new Highcharts.Chart("+results.weather.Linechart+"); ");
						WeatherchartObj.reflow();
						if($scope.WeatherLineChart_FullWidth)
						$timeout( function(){  $scope.weatherchartResized=true; $scope.ResizeFullWidthCharts('divWeatherLineChart','WeatherChart');  }, 5000);
						
						Data.Addtoast("info","Weather Chart Loaded");
						
				}
				else
				{
					$scope.WeatherList = [];
						$scope.WeathertotalItems = 0; 
						//Data.toast(results);
						Data.toast(results.weather);
				}
				
				$scope.isWeatherInfoLoading =false;
            }); 
	}
	
	
	//function LoadOccupancyInformation()
	$scope.LoadOccupancyInformation = function () 
	{
            
		$scope.isOccupancyInfoLoading = true;
		$scope.OccupancyPostParams = {'OccupancyStartDate': $scope.formatDateMysql($scope.OccupancyFilterStartDate) , 'OccupancyEndDate':$scope.formatDateMysql($scope.OccupancyFilterEndDate),'SelectedHotel':$scope.SelectedHotel.GroupId};
		 Data.Addtoast("info","Loading Occupancy List");
			Data.post('LoadOccupancy',{
				dparams: $scope.OccupancyPostParams
			}).then(function (results) {
				//alert(results.Occupancy.OccupancyChart);
						$scope.OccupancyList = results.Occupancy.data;
						$scope.OccupancytotalItems = $scope.OccupancyList.length; 
						Data.Addtoast("info","Occupancy details Loaded");
						eval(" OccupancyChartObj = new Highcharts.Chart("+results.Occupancy.OccupancyChart+");");
                       OccupancyChartObj.reflow();
					   if($scope.OccupancyColumnChart_FullWidth)
						$timeout( function(){  $scope.occupancychartResized=true; $scope.ResizeFullWidthCharts('divOccupancyColumnChart','OccupancyChart');  }, 5000);
						//$scope.CheckPermission();
						//if($scope.OccupancyList.length<=0)
							//$scope.ShowOccupancyColumnChart = false;
						$scope.isOccupancyInfoLoading = false;
            }); 
	}
	
	$scope.LoadSMDataBarChart = function () 
	{
            
		$scope.isSMDataBarChartInfoLoading = true;
		$scope.SMDataBarChartParams = {'SelectedHotel':$scope.SelectedHotel.GroupId,'StartDate': $scope.formatDateMysql($scope.SMDatBarChartFilterStartDate) , 'EndDate':$scope.formatDateMysql($scope.SMDatBarChartFilterEndDate),'LastWeek':$scope.SMDatBarChart_chkShowLastWeek,'LastYear':$scope.SMDatBarChart_chkShowLastYear};
		 Data.Addtoast("info","Loading SMData bar chart");
			Data.post('LoadSMDataBarChart',{
				dparams: $scope.SMDataBarChartParams
			}).then(function (results) {

						
						Data.Addtoast("info","SMData bar chart Loaded");
						eval(" SMDataBarChartObj_currentDate = new Highcharts.Chart("+results.SMData.BarChart+");");
                       SMDataBarChartObj_currentDate.reflow();
					   //eval(" SMDataBarChartObj_lastWeek = new Highcharts.Chart("+results.SMData.BarChart_lastWeek+");");
                       //SMDataBarChartObj_lastWeek.reflow();
					   //eval(" SMDataBarChartObj_lastYear = new Highcharts.Chart("+results.SMData.BarChart_lastYear+");");
                       //SMDataBarChartObj_lastYear.reflow();
					   //if($scope.OccupancyColumnChart_FullWidth)
						//$timeout( function(){  $scope.occupancychartResized=true; $scope.ResizeFullWidthCharts('divOccupancyColumnChart','OccupancyChart');  }, 5000);
						//$scope.CheckPermission();
						//if($scope.OccupancyList.length<=0)
							//$scope.ShowOccupancyColumnChart = false;
						$scope.isSMDataBarChartInfoLoading = false;
            }); 
	}
	
	//function LoadExcelInformation()
        $scope.GetONWasteStyle = function(item)
        {
            onwasteval = $scope.GetONWasteValue(item);
            //alert(onwasteval);
            if(onwasteval<=0)
                return "green";
            else if(onwasteval>0 && onwasteval<=100)
                return "#FFBF00";
            else if(onwasteval>100)
                return "red";
        }
        $scope.GetONWasteValue = function(item)
        {
            if(item.smcontrol==null)
                return "";
            if(item.smcontrol.length==0)
                return "";
		
			var ongwastevalue= (item.nightlow-item.smcontrol[0].NightLow)*0.08992454*8*365;
			if(ongwastevalue<0 && !$scope.AnnualisedONWasteGreenValue_View)
				ongwastevalue = 0;
			
            return  ongwastevalue;
        }

        $scope.GetONWasteValueForExcelPrint = function(item)
        {
            
        	//if(item<0)
        	//	alert(item);

			if(item<0)
				item = 0;
			
            return  item;
        }
        
        
	$scope.LoadExcelInformation = function () 
	{
		$scope.isExcelInfoLoading = true;
		$scope.ExcelPostParams = {'ExcelStartDate': $scope.formatDateMysql($scope.ExcelFilterStartDate) , 'ExcelEndDate':$scope.formatDateMysql($scope.ExcelFilterEndDate),'SelectedHotel':$scope.SelectedHotel.GroupId};
		 Data.Addtoast("info","Loading Excel List");
			Data.post('LoadExcel',{
				dparams: $scope.ExcelPostParams
			}).then(function (results) {
				
						$scope.ExcelList = results.Excel.data;
						//$scope.AssignColor(results.Excel.color);
						//$scope.AssignColors(results.Excel.colors);
						$scope.ExceltotalItems = $scope.ExcelList.length; 
						Data.Addtoast("info","Excel details Loaded");
						//eval("var OccupancyChart = new Highcharts.Chart("+results.Excel.ExcelChart+");");
						//$scope.CheckPermission();
						//if($scope.OccupancyList.length<=0)
							//$scope.ShowOccupancyColumnChart = false;
						
						$scope.isExcelInfoLoading = false;
						$scope.activeExcelInfoTab = ($scope.ExcelTable_kWh?1:($scope.ExcelTable_Cost?2:0));
						//alert($scope.activeExcelInfoTab);
            }); 
	}
	
	$scope.LoadAlertInformation = function () 
	{
		$scope.isAlertsInfoLoading = true;
		$scope.AlertPostParams = {'AlertStartDate': $scope.formatDateMysql($scope.AlertFilterStartDate) , 'AlertEndDate':$scope.formatDateMysql($scope.AlertFilterEndDate),'SelectedHotel':$scope.SelectedHotel.GroupId};
					
							$scope.AlertList = null;
							$scope.AlertSetList = null;
							$scope.AlerttotalItems = 0;
							$scope.AlertSettotalItems = 0;
		 Data.Addtoast("info","Loading Alerts List");
			Data.post('LoadAlert',{
				dparams: $scope.AlertPostParams
			}).then(function (results) {
				//alert(results);
						if(results!=null && results.Alert!=null)
						{
							$scope.AlertList = results.Alert.data;
							$scope.AlertSetList = results.Alert.alertset;
							$scope.AlerttotalItems = $scope.AlertList.length;
							$scope.AlertSettotalItems = $scope.AlertSetList.length;
						}			
						$scope.isAlertsInfoLoading = false;

            }); 
	}
	
	$scope.LoadHotelSettings = function () 
	{
		$scope.HotelSettingsErrorMessage = "";
		$scope.isHotelSettingsLoading = true;
		$scope.HotelSettings.HotelID = $scope.SelectedHotel.GroupId;
		$scope.HotelSettingsPostParams = {'SelectedHotel':$scope.SelectedHotel.GroupId};
		
		 Data.Addtoast("info","Loading Hotel Settings List");
			Data.post('LoadHotelSettings',{
				dparams: $scope.HotelSettingsPostParams
			}).then(function (results) {
				//alert(results);
			if(!results.Error && results!=null && results.Hotel!=null)
			{
							$scope.HotelOtherUsers = null;
							//alert(results.Hotel.data);
							if(results.Hotel.data!=null)
							{
								$scope.HotelSettings = results.Hotel.data;
								$scope.HotelVisittotalItems = $scope.HotelSettings.HotelVisits.length; 
								$scope.HotelContactstotalItems = $scope.HotelSettings.HotelContacts.length; 
							}
							else
							{
								$scope.HotelSettings = {"ID":"0","OnSpeacialMeasure":true, "AnnualConsumption":"", "SMStartDate":"", "SMEndDate":"", "GM_UserID":0, "MM_UserID":0, "HKHead_UserID":0, "HotelID":0,"HotelVisits":null};
								//$scope.HotelSettings.HotelID = $scope.SelectedHotel.GroupId;
								$scope.HotelVisittotalItems = 0; 
							}
							
							//alert($scope.HotelSettings.GM_UserID);
							//alert($scope.HotelSettings.MM_UserID);
							//alert($scope.HotelSettings.HKHead_UserID);
							
								$scope.HotelSettings.HotelID = $scope.SelectedHotel.GroupId;
								$scope.HotelOtherUsers = results.Hotel.HotelUsers;
								$scope.HotelVisitTypes = results.Hotel.VisitTypes;
								$scope.AllUserTitles   = results.Hotel.titles;
							//$scope.AlertSetList = results.Alert.alertset;
							//$scope.AlerttotalItems = $scope.AlertList.length;
							//$scope.AlertSettotalItems = $scope.AlertSetList.length;
							$scope.isHotelSettingsLoading = false;
						$scope.isHotelSettingsVisitInfoLoading = false;			
			}		
			else
				{
					$scope.HotelSettingsErrorMessage = "oops! Something went wrong.We will retry in few seconds";
					$timeout( function(){  $scope.LoadHotelSettings(); }, 25000);
				}
					

            }); 
	}
	
	
	$scope.DoSaveHotelSettingsChanges = function (HotelSettingsItem) {

                        HotelSettingsItem.SMStartDate = $scope.formatDateMysql(HotelSettingsItem.SMStartDate);
                        HotelSettingsItem.SMEndDate = $scope.formatDateMysql(HotelSettingsItem.SMEndDate);
			//alert($scope.HotelSettings.ID);
			Data.post('UpdateHotelSettingsChanges', {
				HotelItem: $scope.HotelSettings
			}).then(function (results) {
				//Data.toast(results);
				if (results.status == "success") {
					Data.toast(results);
					HotelSettingsItem.ID = results.ID;
					if($scope.ExcelPrintItem!=null && $scope.ExcelPrintItem.HotelSettings!=null)
					{
						$scope.ExcelPrintItem.HotelSettings.DayMax = HotelSettingsItem.DayMax;
						$scope.ExcelPrintItem.HotelSettings.NightLow = HotelSettingsItem.NightLow;
					}
				}
				if (results.status == "error") {
					Data.toast(results);
					
				}
			});
		
    };
	
	$scope.DoSaveHotelVisitChanges = function (HotelVisitEditedItem) {
                HotelVisitEditedItem.Vdate = $scope.formatDateMysql(HotelVisitEditedItem.Vdate);
                
		$scope.isHotelSettingsVisitInfoLoading = true;		
		HotelVisitEditedItem.HotelSettingsID = $scope.HotelSettings.ID;
			Data.post('UpdateHotelVisit', {
				HotelVisit: HotelVisitEditedItem
			}).then(function (results) {
				//Data.toast(results);
				if (results.status == "success") {
					Data.toast(results);
					//HotelVisits
					//$scope.HotelSettings.
					//$scope.LoadHotelSettings();
					$scope.HotelSettings.HotelVisits = results.HotelVisits;
					$scope.HotelVisitFormType= "LIST";
					$scope.EditingHotelVisit = {"ID":0,"VisitTypeID":null,"VisitDate":"","VisitedUserID":null,"Remark":"","HotelSettingsID":$scope.HotelSettings.ID,"Vdate":""};
				}
				if (results.status == "error") {
					Data.toast(results);
					
				}
				$scope.isHotelSettingsVisitInfoLoading = false;		
			});
		
    };
	
	$scope.DoSaveHotelContactsChanges = function (HotelContactsEditedItem) {

		HotelContactsEditedItem.HotelSettingsID = $scope.HotelSettings.ID;
		
		//alert($scope.HotelSettings.HotelID);
		HotelContactsEditedItem.SelectedHotelID = $scope.HotelSettings.HotelID;
			Data.post('UpdateHotelContacts', {
				HotelContact: HotelContactsEditedItem
			}).then(function (results) {
				//Data.toast(results);
				if (results.status == "success") {
					Data.toast(results);
					//HotelVisits
					//$scope.HotelSettings.
					//$scope.LoadHotelSettings();
					$scope.HotelSettings.HotelContacts = results.HotelContacts;
					$scope.HotelContactstotalItems = $scope.HotelSettings.HotelContacts.length;
					$scope.HotelContactsFormType= "LIST";
					$scope.EditingHotelContacts = {"ID":0,"UserID":0,"HotelSettingsID":0};
				}
				if (results.status == "error") {
					Data.toast(results);
					
				}
			});
		
    };
	
	$scope.DoDeleteHotelContacts = function (delitem) {

		if(confirm('Do you really want to delete this contact ?'))
		{
			delitem.HotelSettingsID = $scope.HotelSettings.ID;
			Data.post('DeleteHotelContact', {
				HotelContact: delitem
			}).then(function (results) {
				//Data.toast(results);
				if (results.status == "success") {
					Data.toast(results);
					//HotelVisits
					//$scope.HotelSettings.
					//$scope.LoadHotelSettings();
					$scope.HotelSettings.HotelContacts = results.HotelContacts;
					$scope.HotelContactstotalItems = $scope.HotelSettings.HotelContacts.length;
					$scope.HotelContactsFormType= "LIST";
				}
				if (results.status == "error") {
					Data.toast(results);
					
				}
			});
		}
    };
	
	$scope.EditHotelVisit = function (HotelVisitEditItem) {
            
		$scope.HotelVisitFormType= "EDIT";
		$scope.EditingHotelVisit = HotelVisitEditItem;
	};
	
	$scope.EditHotelContacts = function (HotelContactEditItem) {
		$scope.HotelContactsFormType= "EDIT";
		$scope.EditingHotelContacts = HotelContactEditItem;
	};
	
	$scope.AddNewHotelVisit = function () {
		$scope.HotelVisitFormType= "ADD";
		$scope.EditingHotelVisit = {"ID":0,"VisitTypeID":null,"VisitDate":"","VisitedUserID":null,"Remark":"","HotelSettingsID":$scope.HotelSettings.ID,"Vdate":""};
	};
	
	$scope.AddNewHotelContacts = function () {
		$scope.HotelContactsFormType= "ADD";
		$scope.EditingHotelContacts = {"ID":0,"UserID":0,"HotelSettingsID":0};
	
	};
	
	$scope.GetHotelUserDetails = function (item) {
		
		
		if($scope.SelectedHotelUser==null)
		{
			var fitem = $filter('filter')($scope.HotelOtherUsers, { ID: item }); 
			$scope.SelectedHotelUser = fitem[0];
			
		}
		else
		{
			if($scope.SelectedHotelUser.ID==item)
			$scope.SelectedHotelUser = null;
			else
			{
				var fitem = $filter('filter')($scope.HotelOtherUsers, { ID: item }); 
				$scope.SelectedHotelUser = fitem[0];
			}
		}
		
	};
	
	$scope.LoadCircuitInformation = function (citem) 
	{
		$scope.isCircuitsInfoLoading = true;
		//alert(citem);
		if(citem==null)
		{
			$scope.CircuitsBreadCrumb = [];
			$scope.CircuitPostParams = {'SelectedHotel':$scope.SelectedHotel.GroupId};
		}
		else
		{
			if($scope.CircuitsBreadCrumb.length==0)
			$scope.CircuitsBreadCrumb.push({GroupId:$scope.SelectedHotel.GroupId,Name:$scope.SelectedHotel.Name})	;
			
			var dd = $scope.CircuitsBreadCrumb.indexOf(citem);
			if(dd != -1) {
				$scope.CircuitsBreadCrumb = $scope.CircuitsBreadCrumb.filter(function(item, idx) {
					return idx <= dd;
				});
				//$scope.CircuitsBreadCrumb.splice(dd, 1);
			}
			else
			{
				$scope.CircuitsBreadCrumb.push(citem);
			}
			$scope.CircuitPostParams = {'SelectedHotel':citem.GroupId};
			//alert($scope.CircuitsBreadCrumb[0])
		}
		
		
		 Data.Addtoast("info","Loading Circuit Details List");
			Data.post('LoadCircuitDetails',{
				dparams: $scope.CircuitPostParams
			}).then(function (results) {

							$scope.CircuitDetailsList = results.CircuitDetails.data;
							$scope.isCircuitsInfoLoading = false;		

            }); 
	}
	
	$scope.SaveCircuitInformation = function (citem) 
	{
		 
			Data.post('SaveCircuitDetails',{
				dparams: citem
			}).then(function (results) {

							citem.ID = results.ID;
							citem.FormType='LIST';
							Data.Addtoast("info","Saved Circuit Details Changes");
            }); 
	}
	$scope.DeleteCircuitInformation = function (citem) 
	{
		 if(confirm('Do you really want to delete the circuit details ?'))
		 {
			Data.post('DeleteCircuitDetails',{
				dparams: citem
			}).then(function (results) {

							citem.ID = 0;
							citem.sum_min = "";
							citem.sum_avg = ""; 
							citem.sum_max = ""; 
							citem.aut_min = ""; 
							citem.aut_avg = ""; 
							citem.aut_max = ""; 
							citem.win_min = "";
							citem.win_avg = ""; 
							citem.win_max = ""; 
							citem.spr_min = ""; 
							citem.spr_avg = "";
							citem.spr_max  = "";
							citem.FormType='LIST';
							Data.toast(results);
            }); 
			
		 }
	}
	
	

	
	
	
	$scope.ShowObservationEditForm = function (selitem) 
	{
		$scope.ObservationFormType = 'EDIT';
		//alert(selitem.Code);
		$scope.ObservationEditFormType = selitem.Code;
		$scope.ObservationEditingItem = selitem;
		$scope.ObservationImagesList = selitem.ImageSet;
		$scope.ObservationImagestotalItems = selitem.ImageSet.length;
		//alert($scope.ObservationImagestotalItems);
	}
	
	$scope.DoSaveObservationChanges = function (SavingItem) 
	{

		//$scope.AddNewObservationParams.HotelID = $scope.SelectedHotel.GroupId;
		
		//$scope.ObservationsPostParams = {'SelectedHotel':$scope.SelectedHotel.GroupId};
		 Data.Addtoast("info","Saving Observation changes");
			Data.post('SaveObservationChanges',{
				dparams: SavingItem
			}).then(function (results) {

							SavingItem.Info.ID = results.ID;
							Data.toast(results);
            }); 
	}
	
	
	$scope.ObservationImagesubmit = function(obdEditItem) {
		//alert('came');
	      	$scope.ObservationImageform.image = $scope.files[0];

	      	$http({
			  method  : 'POST',
			  url     : 'api/v1/ObservationImageupload',
			  processData: false,
			  transformRequest: function (data) {
			      var formData = new FormData();
			      formData.append("image", $scope.ObservationImageform.image);  
				  formData.append("ObservationID", obdEditItem.ID);  
				  //formData.append("dparams", obdEditItem);  
			      return formData;  
			  },  
			  data : $scope.ObservationImageform,
			  headers: {
			         'Content-Type': undefined
			  }
		   }).success(function(results){
		        //alert(data);
				Data.toast(results);
				$scope.ReloadObservationImages(obdEditItem);
		   });

	};

	function wysiwygeditor($scope) {
		$scope.orightml = '<h2>Try me!</h2><p>textAngular is a super cool WYSIWYG Text Editor directive for AngularJS</p><p><b>Features:</b></p><ol><li>Automatic Seamless Two-Way-Binding</li><li>Super Easy <b>Theming</b> Options</li><li style="color: green;">Simple Editor Instance Creation</li><li>Safely Parses Html for Custom Toolbar Icons</li><li class="text-danger">Doesn&apos;t Use an iFrame</li><li>Works with Firefox, Chrome, and IE8+</li></ol><p><b>Code at GitHub:</b> <a href="https://github.com/fraywing/textAngular">Here</a> </p>';
		$scope.htmlcontent = $scope.orightml;
		$scope.disabled = false;
	};

$scope.ReportFileUploader = function(element) 
	{
		//alert('came 5');
		    $scope.currentReportFile = element.files[0];
		    var reader = new FileReader();

		    reader.onload = function(event) {
		      $scope.File_Source = event.target.result
		      $scope.$apply(function($scope) {
		        $scope.Reportfiles = element.files;
		        $scope.ReportDownloadActiveTab =1;	
		      });
		    }
                    reader.readAsDataURL(element.files[0]);
	}

	$scope.ReportFileUploadSubmit = function() {
		//alert('came');

	if(confirm('Do you really want to upload the selected File ?'))
		{
	      	$scope.reportUploadForm.uFile = $scope.Reportfiles[0];

			//alert($scope.reportUploadForm.ReportType);

	      	$http({
			  method  : 'POST',
			  url     : 'api/v1/ReportsFileUpload',
			  processData: false,
			  transformRequest: function (data) {
			      var formData = new FormData();
			      formData.append("uFile", $scope.reportUploadForm.uFile);  
				  formData.append("ReportType", $scope.reportUploadForm.ReportType);  
				  //formData.append("dparams", obdEditItem);  
			      return formData;  
			  },  
			  data : $scope.reportUploadForm,
			  headers: {
			         'Content-Type': undefined
			  }
		   }).success(function(results){
		        //alert(data);
				Data.toast(results);
				$scope.GetReportsToDownload();
				$scope.reportUploadForm.uFile="";
				//$scope.Reportfiles=null;
		   });
		}
	};
	
	
	$scope.ObservationImageuploadedFile = function(element) 
	{
		//alert('came 5');
		    $scope.currentFile = element.files[0];
		    var reader = new FileReader();

		    reader.onload = function(event) {
		      $scope.image_source = event.target.result
		      $scope.$apply(function($scope) {
		        $scope.files = element.files;
		      });
		    }
                    reader.readAsDataURL(element.files[0]);
	}


	
	
	
	$scope.ReloadObservationImages = function (editItem) 
	{

		
			Data.post('LoadObservationsImages',{
				dparams: editItem
			}).then(function (results) {

							editItem.ImageSet = results.ObservationsImages.ImageList;
							$scope.ObservationImagesList = editItem.ImageSet;
							$scope.ObservationImagestotalItems = editItem.ImageSet.length;
							//$scope.LoadObservationsInformation();

            }); 
	}
	
	$scope.DeleteObservationImage = function (observItem,delItem) 
	{

		 if(confirm('Do you really want to delete the image ?'))
		 {
			Data.post('DeleteObservationImage',{
				dparams: delItem
			}).then(function (results) {
							Data.toast(results);
							$scope.ReloadObservationImages(observItem);
            }); 
		 }
	}
	
	
	$scope.PrepareOBSAddFeature = function () 
	{
		$scope.ObservationsPostParams = {'SelectedHotel':$scope.SelectedHotel.GroupId};
		 Data.Addtoast("info","Preparing Observation Add form");
			Data.post('PrepareOBSAdd',{
				dparams: $scope.ObservationsPostParams
			}).then(function (results) {

							
							$scope.ObservationEditingItem = results.PrepareOBSAddDetails.Info;
							$scope.ObservationEditingItem.ID=0;
							$scope.ObservationEditingItem.PriorityNumber=1;
							$scope.ObservationEditingItem.HotelID = $scope.SelectedHotel.GroupId;
							//alert($scope.AddNewObservationParams.GroupID);
							
							$scope.ObservationEditingItem.where = $scope.SelectedHotelFuntionalGroups[0].GroupId;		
							$scope.ObservationEditingItem.ObservationTypeID = $scope.ObservationsTypesList[0].ID;
							$scope.ObservationEditingItem.CategoryID = $scope.ObservationsCategoryList[0].ID;
							$scope.ObservationEditingItem.StatusID = $scope.ObservationsStatusList[0].ID;
							$scope.ObservationEditingItem.FundingID = $scope.ObservationsFundingList[0].ID;
						
						$scope.ObservationFormType='ADD';
						
						$scope.ObservationImagesList = [];

            }); 
	}
	
	$scope.DoSaveOBSChanges = function (SavingItem) 
	{

		//$scope.AddNewObservationParams.HotelID = $scope.SelectedHotel.GroupId;
		
		//$scope.ObservationsPostParams = {'SelectedHotel':$scope.SelectedHotel.GroupId};
                SavingItem.DiscoveredDate = $scope.formatDateMysql(SavingItem.DiscoveredDate);
                SavingItem.DateHotelCompleted = $scope.formatDateMysql(SavingItem.DateHotelCompleted);
                SavingItem.DateRpActioned = $scope.formatDateMysql(SavingItem.DateRpActioned);
		 Data.Addtoast("info","Saving Observation changes");
			Data.post('SaveOBSChanges',{
				dparams: SavingItem
			}).then(function (results) {

				//alert(results.Error);
				if(!Utils.isUndefinedOrNull(results) && !Utils.isUndefinedOrNull(results.ID) && !results.Error)
				{
							SavingItem.ID = results.ID;
							Data.toast(results);
							$scope.ObservationFormType='LIST';
							$scope.LoadOBSDetails();

				}
				else
				{
					Data.Addtoast("error","There was an error. Please retry saving the observation changes");
				}
            }); 
	}
	
	
	$scope.DoCancelOBSAddEditForm = function () 
	{
		if(confirm('All your changes will be lost \r\nDo you really want to cancel this process ?'))
		 {
		 	$scope.ObservationFormType='LIST';
		 }
	}
	
	
	$scope.DoDeleteOBS = function (DeletingObsItem) 
	{
		if(confirm('Deleting an Observation will delete the \r\n1). Associated replies and \r\n2). Images if any\r\nDo you really want to delete this observation ?'))
		 {

		//$scope.AddNewObservationParams.HotelID = $scope.SelectedHotel.GroupId;
		
		//$scope.ObservationsPostParams = {'SelectedHotel':$scope.SelectedHotel.GroupId};
		 Data.Addtoast("info","Deleting Observation");
			Data.post('DeleteOBS',{
				dparams: DeletingObsItem
			}).then(function (results) {

							Data.toast(results);
							$scope.ObservationFormType='LIST';
							$scope.LoadOBSDetails();
            }); 
			
		 }
	}
	
	$scope.DoSaveOBSReplies = function (ParentItem,SavingItem) 
	{

		//$scope.AddNewObservationParams.HotelID = $scope.SelectedHotel.GroupId;
		SavingItem.HotelID = $scope.SelectedHotel.GroupId;
		//$scope.ObservationsPostParams = {'SelectedHotel':$scope.SelectedHotel.GroupId};
		 Data.Addtoast("info","Saving a Observation Reply changes");
			Data.post('SaveOBSReplyChanges',{
				dparams: SavingItem
			}).then(function (results) {

							//ParentItem.Replies = results.Replies;
							$scope.LoadOBSDetails();
            }); 
	}
	
	$scope.ShowAddOBSForm = function () 
	{

		$scope.PrepareOBSAddFeature();
	}
	$scope.ShowEditOBSForm = function (citem) 
	{
		$scope.SelectedHotelFuntionalGroupsCircuits = citem.CircuitList;
		$scope.ObservationEditingItem=citem;
		$scope.ObservationImagesList = citem.ImageSet;
		$scope.ObservationImagestotalItems = citem.ImageSet.length;
		$scope.ObservationFormType='EDIT';
	}
	
	$scope.greaterThanFilterOBS = function(prop, val){
    return function(item){
      return item[prop] > val;
    }
	}

	$scope.GetFilteredOBSDetailsByType = function (typeid) 
	{
		if(typeid==0)
			return $scope.ObservationsAllDetailsList;
		var myRedObjects = $filter('filter')($scope.ObservationsAllDetailsList, { ObservationTypeID: typeid });
		return myRedObjects;
	}
	
	$scope.LoadOBSDetails = function () 
	{
		$scope.ObservationsErrorMessage = "";
		$scope.isObservationInfoLoading = true;
		$scope.ObservationsPostParams = {'SelectedHotel':$scope.SelectedHotel.GroupId,'Export':0};
		$scope.ObservationsPostParams.flag5k = $scope.ShowObservationTypeFlag5;
		 Data.Addtoast("info","Loading Observations Details List");
		 //Data.AddtoastTopRight("info","Loading Observations Details List");

		 
		 // Data.AddStatictoast("info","Loading Observations Details List",'OBSLIST');
		 //alert(tos);
			Data.post('LoadOBSDetails',{
				dparams: $scope.ObservationsPostParams
			}).then(function (results) {

				if(!results.Error && results.OBSDetails!=null)
				{

							

							//$scope.ObservationsSMDetailsList = results.OBSDetails.SMdata;
                            $scope.ObservationsAllDetailsList = results.OBSDetails.AllOBSdata;
							//$scope.ObservationsGMDetailsList = results.OBSDetails.GMdata;
							//$scope.ObservationsOBSDetailsList = results.OBSDetails.OBSdata;

							angular.forEach($scope.ObservationsAllDetailsList, function (item) {
						    item.ValuePerAnnum = parseFloat(item.ValuePerAnnum);
						    item.PriorityNumber = parseFloat(item.PriorityNumber);
						    item.ID = parseFloat(item.ID);
						   	});
						   	angular.forEach($scope.GetFilteredOBSDetailsByType(3), function (item) {
						    item.ValuePerAnnum = parseFloat(item.ValuePerAnnum);
						    item.PriorityNumber = parseFloat(item.PriorityNumber);
						    item.ID = parseFloat(item.ID);
						   	});
						   	angular.forEach($scope.GetFilteredOBSDetailsByType(2), function (item) {
						    item.ValuePerAnnum = parseFloat(item.ValuePerAnnum);
						    item.PriorityNumber = parseFloat(item.PriorityNumber);
						    item.ID = parseFloat(item.ID);
						   	});
						   	angular.forEach($scope.GetFilteredOBSDetailsByType(1), function (item) {
						    item.ValuePerAnnum = parseFloat(item.ValuePerAnnum);
						    item.PriorityNumber = parseFloat(item.PriorityNumber);
						    item.ID = parseFloat(item.ID);
						   	});
							
							//alert($scope.GetFilteredOBSDetailsByType(0).length);
							//alert($scope.GetFilteredOBSDetailsByType(1).length);
							//alert($scope.GetFilteredOBSDetailsByType(2).length);
							//alert($scope.GetFilteredOBSDetailsByType(3).length);
							//if($scope.SelectedHotelFuntionalGroups==null)
							//{
								$scope.SelectedHotelFuntionalGroups = 	results.OBSDetails.FuntionalGroups;
														
							//}
							
							//if($scope.SelectedHotelFuntionalGroupsCircuits==null)
							//{
								$scope.SelectedHotelFuntionalGroupsCircuits = 	results.OBSDetails.FuntionalGroupsCircuits;
														
							//}
						
							if($scope.ObservationsTypesList==null)
							{
								$scope.ObservationsTypesList = 	results.OBSDetails.Types;	
								
							}
							
							if($scope.ObservationsCategoryList == null)
							{
								$scope.ObservationsCategoryList = 	results.OBSDetails.Categories;
								
							}							
							if($scope.ObservationsStatusList == null)
							{
								$scope.ObservationsStatusList = 	results.OBSDetails.Status;
								
							}							
							if($scope.ObservationsFundingList == null)
							{
								$scope.ObservationsFundingList = 	results.OBSDetails.Funding;
																
							}
							
							
							if($scope.ObservationsAllDetailsList!=null)
                            {
								$scope.ObservationAlltotalItems  = $scope.ObservationsAllDetailsList.length;
                                $scope.ObservationAllPagingnumPerPage = $scope.ObservationsAllDetailsList.length;
                             }
							else
								$scope.ObservationAlltotalItems =0;
                                                            
                             if($scope.GetFilteredOBSDetailsByType(3)!=null)
								$scope.ObservationSMtotalItems  = $scope.GetFilteredOBSDetailsByType(3).length;
							else
								$scope.ObservationSMtotalItems =0;
							
							if($scope.GetFilteredOBSDetailsByType(2)!=null)
								$scope.ObservationGMtotalItems  = $scope.GetFilteredOBSDetailsByType(2).length;
							else
								$scope.ObservationGMtotalItems =0;
							
							if($scope.GetFilteredOBSDetailsByType(1)!=null)
								$scope.ObservationOBStotalItems  = $scope.GetFilteredOBSDetailsByType(1).length;
							else
								$scope.ObservationOBStotalItems =0;
							

							$scope.ObservationEditingItem=null;
							$scope.ObservationImagesList = null;
							$scope.ObservationImagestotalItems = 0;
							
							$scope.isObservationInfoLoading = false;

							//Data.ClearStatictoast('OBSLIST');

				}
				else
				{
					//Data.ClearStatictoast('OBSLIST');
					$scope.ObservationsErrorMessage = "oops! Something went wrong.We will retry in few seconds";
					$timeout( function(){  $scope.LoadOBSDetails(); }, 25000);
				}
				
            }); 
	}
	
	$scope.SendToPrinter = function(printSectionId, printobj) 
	{
		
		$scope.DoWriteLog('Excel Print Page Printed','Excel Print');


					var innerContents = document.getElementById(printSectionId).innerHTML;
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.date"', "value='"+printobj.date+"'");
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.fbFN"', "value='"+printobj.fbFN+"'");
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.cbFN"', "value='"+printobj.cbFN+"'");
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.hfFN"', "value='"+printobj.hfFN+"'");
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.hkFN"', "value='"+printobj.hkFN+"'");
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.generalFN"', "value='"+printobj.generalFN+"'");
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.plantFN"', "value='"+printobj.plantFN+"'");
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.reportText" class="ng-pristine ng-valid">', ">"+printobj.reportText);
					 innerContents = innerContents.replace('ng-model="ExcelPrintItem.reportText" class="ng-valid ng-dirty">', ">"+printobj.reportText);
					 
					 
					 //alert(innerContents);
					//alert(innerContents);
					var popupWinindow = window.open('', '_blank', 'width=600,height=700,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
					var cssScripts = '<link href="css/bootstrap.min.css" rel="stylesheet"/><link rel="stylesheet" href="css/angularjs-datetime-picker.css" /><link href="css/custom.css" rel="stylesheet"/><link href="css/menu.css" rel="stylesheet"/><link href="css/pushmenu.css" rel="stylesheet"/><link href="css/toaster.css" rel="stylesheet"/><link rel="stylesheet" href="css/ngtable.css"/><link rel="stylesheet" type="stylesheet" href="css/topmenu.css"/><link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />';
						  
					popupWinindow.document.open();
					popupWinindow.document.write('<html><head>'+cssScripts+'</head><body onload="window.print()">' + innerContents + '</html>');
					popupWinindow.document.close();

        
      }
	  
	  $scope.DoWriteLog = function(description, widgetName) 
	  {
		  Data.post('WriteLog',{
				dparams: {'SelectedHotel':$scope.SelectedHotel.GroupId,'Description':description,'WidgetName':widgetName}
			}).then(function (results) {
				
				
		  }); 
	  }
	  
	  $scope.ExelPrintDateChanges = function(eitem)
	  {
		  /*Data.post('LoadExcelPrintDetailsOnDateChange',{
				dparams: {'SelectedHotel':$scope.SelectedHotel.GroupId,'date':eitem.date}
			}).then(function (results) {
				
				
				eitem.SmDataID = results.SmDataID;
			
				eitem.fbFN = results.fbFN;
				eitem.cbFN = results.cbFN;
				eitem.hfFN = results.hfFN;
				eitem.hkFN = results.hkFN;
				eitem.generalFN = results.generalFN;
				eitem.plantFN = results.plantFN;
				eitem.reportText = results.reportText;
				
				eitem.FBAlertCount = results.FBAlertCount;
				eitem.HFAlertCount = results.HFAlertCount;
				eitem.FunctionsAlertCount = results.FunctionsAlertCount;
				eitem.HouseKeepingAlertCount = results.HouseKeepingAlertCount;
				eitem.GeneralAlertCount = results.GeneralAlertCount;
				eitem.PlantAlertCount = results.PlantAlertCount;
				
		  }); */
		  $scope.isExcelPrintInfoLoading = true;
		  $scope.ExcelFormType= "PRINT";
		$scope.ExcelPostParams = {'ExcelStartDate': $scope.formatDateMysql($scope.ExcelFilterStartDate) , 'ExcelEndDate':$scope.formatDateMysql($scope.ExcelFilterEndDate),'SelectedHotel':$scope.SelectedHotel.GroupId,'Date':$scope.formatDateMysql(eitem.date)};
		//if($scope.ExcelPrintItem==null)
		//{
			Data.post('LoadExcelPrintDetail',{
					dparams: $scope.ExcelPostParams
				}).then(function (results) {
					$scope.ExcelPrintItem = results.ExcelPrint;
					$scope.isExcelPrintInfoLoading = false;
				}); 
		//}
	  }
	  
	  $scope.LoadLogActivity = function()
	  {
		  //alert('hai');
		  var defoption = $scope.SelectedHotel.GroupId;
		  if($scope.LogActivity_chkShowAll)
		  	defoption = 0;

		  if($scope.Widget_LogActivity)
		  {
			  $scope.isLogActivityLoading = true;
			  $scope.LogActivityErrorMessage = "";
			  Data.post('LoadLogActivityDetails',{
					dparams: {'StartDate': $scope.formatDateMysql($scope.LogActivityFilterStartDate) , 'EndDate':$scope.formatDateMysql($scope.LogActivityFilterEndDate),'SelectedHotel':defoption}
				}).then(function (results) {
					//alert(results.Error);
					//alert(results.LogActivityDetails);
					//alert(results.LogActivityDetails.Data);
					if(!results.Error && !Utils.isUndefinedOrNull(results.LogActivityDetails) && !Utils.isUndefinedOrNull(results.LogActivityDetails.Data))
					{
						//alert(results.Data);
						$scope.LogActivityList = results.LogActivityDetails.Data;
						$scope.LogActivitytotalItems = results.LogActivityDetails.Data.length;
						//$timeout( function(){ $scope.LoadLogActivity(); }, 3000);
						//alert(results.LogActivityDetails.LogChart);
						if(!Utils.isUndefinedOrNull(results.LogActivityDetails.LogChart))
						{
							$scope.LogActivityList.isChart = true;
							eval(" LogActivityChartObj = new Highcharts.Chart("+results.LogActivityDetails.LogChart+");");
						}
						else
						{
							$scope.LogActivityList.isChart = false;
							
						}
						$scope.isLogActivityLoading = false;
					}
					else
					{
						$scope.LogActivityErrorMessage = "oops! Something went wrong.We will retry in few seconds";
						$timeout( function(){  $scope.LoadLogActivity(); }, 5000);
						//$scope.intervals.push($interval( function(){   $scope.LoadLogActivity(); }, 60000));
					}
					
			  }); 
		}
	  }

	  $scope.updateuseractivestatus = function(useritem)
	  {
		  
			if(confirm("Do you really want to change the active status of this user ?"))
			{ 
				var active = useritem.Active;
				if(active==1)
					useritem.Active=0;
				else
					useritem.Active=1;
			  Data.post('updateuseractivestatus',{
					user: useritem
				}).then(function (results) {
					//alert(results.Error);
					if(!results.Error)
					{
						Data.toast(results);
					}
					else
					{
						//$scope.LogActivityErrorMessage = "oops! Something went wrong.We will retry in few seconds";
						//$timeout( function(){  $scope.LoadLogActivity(); }, 5000);
						//$scope.intervals.push($interval( function(){   $scope.LoadLogActivity(); }, 60000));
					}
					
			  }); 
			}
		
	  }

	  $scope.ResetUserPassword = function(useritem)
	  {
		  
			if(confirm("Do you really want to rest the password for this user ?"))
			{ 
				
			  Data.post('ResetUserPassword',{
					user: useritem
				}).then(function (results) {
					//alert(results.Error);
					if(!results.Error)
					{
						Data.toast(results);
					}
					else
					{
						//$scope.LogActivityErrorMessage = "oops! Something went wrong.We will retry in few seconds";
						//$timeout( function(){  $scope.LoadLogActivity(); }, 5000);
						//$scope.intervals.push($interval( function(){   $scope.LoadLogActivity(); }, 60000));
					}
					
			  }); 
			}
		
	  }
	  
	$scope.LoadCircuitsForSelectedFG = function(selectedFG)
	{
		  //alert('hai');
		  Data.post('LoadCircuitsForFG',{
				dparams: {'FunctionalGroupID':selectedFG}
			}).then(function (results) {
				
				//alert(results.CircuitDetails.Data);
				//$scope.LogActivityList = results.LogActivityDetails.Data;
				//$scope.LogActivitytotalItems = results.LogActivityDetails.Data.length;
				//$timeout( function(){ $scope.LoadLogActivity(); }, 3000);

								$scope.SelectedHotelFuntionalGroupsCircuits = 	results.CircuitDetails.Data;
														
				
		  }); 
	}
	  
	 
	
	$scope.doCancelHotelContactsAddUser = function () {
		$scope.user = {"ID":"0","Username":"","Password":"","Email":"","Firstname":"","Lastname":"","CreatedDate":"","IsAdmin":"","Active":"","Mobile":"","ConfirmPassword":"","userhotels":null};
		
	}
	
	$scope.doUpdateHotelUserContact = function (user) {
		//if(user.Active=='true')
			//alert(user.Active);
		user.Active = (user.Active?1:0);
		user.From='Dashboard';
			$scope.user.AssignedHotel = $scope.SelectedHotel.GroupId;
			Data.post('AddNewUser', {
				user: user
			}).then(function (results) {
				Data.toast(results);
				if (results.status == "success") {
					$scope.doCancelHotelContactsAddUser();
					$scope.HotelContactsFormType='LIST';
					//Data.toast(results);
					$scope.HotelOtherUsers = results.HotelUsers; 
				}
			});
		
    };
	
	   
	
	
	$scope.ViewHotelcontactMoreInfo = function (user)
	{
		//alert(user);
		
		$scope.ViewingUser = user;
		$scope.activeHotelTab = 4;
	}
	
	$scope.CloseViewHotelcontactMoreInfo = function ()
	{
		//alert(user);
		$scope.activeHotelTab = 3;
		$scope.ViewingUser = null;
		
	}
        
        $scope.ResizeIt = function (mainDiv, graphname)
        {
            //class="col-lg-6"
            var mele = document.getElementById(mainDiv);
            //var gele = document.getElementById(graphDiv);
            //alert(ele);
            
            if(mele.className == "col-lg-12")
            {
                mele.className = "col-lg-6";
            }
            else
            {
               mele.className = "col-lg-12";
                
           }

           if(graphname=="WeatherChart")
           WeatherchartObj.reflow();
           if(graphname=="OccupancyChart")
           OccupancyChartObj.reflow();
          
        }
		
		$scope.ResizeFullWidthCharts = function (mainDiv, graphname)
        {
            
           if(graphname=="WeatherChart" && WeatherchartObj!=null)
           WeatherchartObj.reflow();
           if(graphname=="OccupancyChart" && OccupancyChartObj!=null)
           OccupancyChartObj.reflow();
          
        }
		
		$scope.ResizeClass = function (val, chartname)
        {
			//alert(val);
		
			if(chartname=='weather' && val && !$scope.weatherchartResized)
			{
				//alert(val);
				$timeout( function(){  if(!$scope.weatherchartResized) { $scope.weatherchartResized=true; $scope.ResizeFullWidthCharts('divWeatherLineChart','WeatherChart'); } }, 5000);
				
			}
			if(chartname=='occupancy' && val && !$scope.occupancychartResized)
			{
				$timeout( function(){  if(!$scope.occupancychartResized) { $scope.occupancychartResized=true;  $scope.ResizeFullWidthCharts('divOccupancyColumnChart','OccupancyChart'); } }, 5000);
				
			}
			
			if(val)
				return "col-lg-12";
			else
				return "col-lg-6";
		}
        
    $scope.formatDateUK = function(dateVal){

    	//alert(dateVal);
    		//var dateOut = new Date(date);
    	if(dateVal!=null && dateVal!='')
    	{
          var dateOut = new Date(dateVal.replace(/-/g,"/"));
          dateOut = $filter('date')(dateOut, "dd-MM-yyyy");
            
          return dateOut;
         }

         return null;
    };
    
     $scope.formatDateTimeUK = function(date){
     		//alert(date);
          //var dateOut = new Date(date);
          var dateOut = new Date(date.replace(/-/g,"/"));
          dateOut = $filter('date')(dateOut, "dd-MM-yyyy HH:mm:ss");
           // alert(dateOut);
          return dateOut;
    };
	 $scope.formatDateDayUK = function(date){
          var dateOut = new Date(date);
          dateOut = $filter('date')(dateOut, "EEE dd MMM yyyy");
            
          return dateOut;
    };
    
    $scope.formatDateMysql = function(date){
          //var dateOut = new Date(date);
          //dateOut = $filter('date')(dateOut, "yyyy-MM-dd");
            //alert(dateOut);
		if(date==null)
			return date;
		var arr = date.split("-");
		if(arr[0].length<4)
			return date.split('-').reverse().join('-');
		else 
			return date;
          //alert(dateOut);
          //return dateOut;
    };
	
     $scope.ShowDatePicker = function(ctrl)
	{
		//alert('came'+ctrl);
		//thisObj1.setMygrid2();   
		//$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		//$( "#"+ctrl ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#"+ctrl ).datepicker({ dateFormat: 'dd-mm-yy' });
		$( "#"+ctrl ).focus(); 
		/*$timeout( function(){ $( "#"+ctrl ).datepicker({ dateFormat: 'yy-mm-dd' }); 
				$( "#"+ctrl ).focus(); 
				//$( "#"+ctrl ).click(); 
				//$( "#"+ctrl ).mousedown(); 
		
		}, 600);*/
		//Data.Addtoast("info","Loaded Users");
	}
	
	$scope.EmailHtml = function (divid,WidgetName) 
	{
		var curpaging = $scope.WeatherPagingnumPerPage;
		if(WidgetName=="WeatherTable")
		$scope.WeatherPagingnumPerPage = $scope.WeatherList.length;
	
		$timeout( function(){   $scope.ConstructEmailContent(divid,curpaging,WidgetName);  }, 2000);
 
	}
	
	$scope.ConstructEmailContent = function (divid,curpaging,WidgetName) 
	{
		var x = document.getElementById(divid).innerHTML;
		x= $interpolate(x)($scope);
		//alert(x);
		//$scope.WeatherPagingnumPerPage = curpaging;
		 Data.Addtoast("info","Sending Email ");
			Data.post('EmailHtml',{
				dparams: {'EmailContent':x}
			}).then(function (results) {

							if(WidgetName=="WeatherTable")
							$scope.WeatherPagingnumPerPage = curpaging;
						
							Data.Addtoast("success",results.data.message);
            }); 
	}
	
	
	$scope.ExportOBS = function (tableId, sheetname) 
	{

		var exportHref=Excel.tableToExcel(tableId,sheetname);
            $timeout(function(){location.href=exportHref;},100); // trigger download
	}


	$scope.SaveContactFormMessage = function(Message)
	{
		  //alert('hai');
		  Message.HotelID = $scope.SelectedHotel.GroupId;
		  Data.post('SaveContactFormMessage',{
				dparams: Message
			}).then(function (results) {
				
				
						Data.toast(results);								
				
		  }); 
	}
	$scope.GetToGroupForContactMessages = function()
	{
		  //alert('hai');
		  Data.post('GetToGroupForContactMessages',{
				dparams: {'HotelID':$scope.SelectedHotel.GroupId}
			}).then(function (results) {
				
				$scope.ToGroupListForContactMessages = results.data;
						//Data.toast(results);								
				
		  }); 
	}

	$scope.GetAllContactFormMessagesCount = function()
	{
		  //if($scope.ContactFormMessageList==null)
		  	//return 0;
		  //else 
		  	//return $scope.ContactFormMessageList.length;
		  	return $scope.ContactFormMessageNewCount; 
	}

	$scope.GetAllNewContactFormMessages = function()
	{
		  //alert('hai');
		  
		  $scope.ShowTrafficIndication = false;
		  Data.post('GetAllNewContactFormMessages',{
		  	dparams: {'HotelID':$scope.SelectedHotel.GroupId}
			}).then(function (results) {
				$scope.ContactFormMessageList = null;
				$scope.ContactFormMessageList = results.data;
				$scope.ContactFormMessageNewCount = results.NewCount;
						//Data.toast(results);								
				
						$timeout(function(){ $scope.ShowTrafficIndication = true; }, 600);
		  }); 
	}

	$scope.GetReportsToDownload = function()
	{
		  //alert('hai');
		  
		  //$scope.ShowTrafficIndication = false;
		  //Notification.success({message: 'Success notification 20s', delay: 20000});
		  $scope.ReportDownloadActiveTab=1;

		  $scope.isReportFileDownloaderLoading = true;
		  Data.post('GetReportsToDownload',{
		  	dparams: {'Hotel':$scope.SelectedHotel}
			}).then(function (results) {
				$scope.ReportsToDownloadList = null;
				$scope.ReportsToDownloadList = results.ReportFiles;
				var loopcount=0;
				angular.forEach($scope.ReportsToDownloadList, function(item) {
						$scope.ReportsToDownloadList[loopcount].Checked= false;
						loopcount++;
					});
				$scope.ReportSendToUsersList = results.ReportSendToUsersList;
				var loopcount=0;
				angular.forEach($scope.ReportSendToUsersList, function(item) {
						$scope.ReportSendToUsersList[loopcount].Checked= true;
						loopcount++;
					});

				$scope.ReportsToEmailListtotalItems = $scope.ReportSendToUsersList.length;
				$scope.ReportsDownloadTypeList = results.directories;
				$scope.reportUploadForm.ReportType = '';
				$scope.ReportsToDownloadtotalItems = $scope.ReportsToDownloadList.length			
				$scope.isReportFileDownloaderLoading = false;
				$scope.ReportReadyEmailtemplate = results.ReportReadyEmailtemplate;
				$scope.ReportReadyEmailtemplate.Subject = "Your Awesome Power Energy Reports are now available to download.";
				//alert($scope.ReportReadyEmailtemplate.HtmlContent);
				if($scope.ReportWidgetFirstLoad)
				{
					$("#ReportsEmaileditor").jqte();
					$scope.ReportWidgetFirstLoad = false;
				}
				$("#ReportsEmaileditor").jqteVal($scope.ReportReadyEmailtemplate.HtmlContent);
				//thisObj1.initiateRichTextEditor();  
						//$timeout(function(){ $scope.ShowTrafficIndication = true; }, 600);
		  }); 
	}


	$scope.ReportsSelectUnselectAll = function()
	{
		//if ($scope.ReportsToDownloadSelectAllCheckbox) {
        //    $scope.ReportsToDownloadSelectAllCheckbox = true;
        //} else {
        //    $scope.ReportsToDownloadSelectAllCheckbox = false;
        //}
        //alert($scope.ReportsToDownloadSelectAllCheckbox);
		angular.forEach($scope.ReportsToDownloadList, function(item) {
						item.Checked= $scope.ReportsToDownloadSelectAllCheckbox;

					});
	}

	$scope.ReportsToEmailListSelectUnselectAll = function()
	{
		angular.forEach($scope.ReportSendToUsersList, function(item) {
						item.Checked= $scope.ReportsToEmailListSelectAllCheckbox;

					});
	}

	$scope.GetHeaderMessages = function()
	{
		  //alert('hai');
		  
		  //$scope.ShowTrafficIndication = false;
		  //Notification.success({message: 'Success notification 20s', delay: 20000});
		  if( $scope.HeaderMessagesTimerInterval!=null)
		  	$interval.cancel($scope.HeaderMessagesTimerInterval);
		  
		  Data.post('GetHeaderMessages',{
		  	dparams: $scope.SelectedHotel
			}).then(function (results) {
				$scope.HeaderMessagesList = results.HeaderMessages;
				$scope.HeaderMessageFlashCounter=-1;
				$scope.HeaderMessagesTimerInterval = $interval( function(){  $scope.FlashHeaderMessage();   }, 6000);
		  }); 
	}

	/*
	Notification('Primary notification');
	Notification.error('Error notification');
	 Notification.success('Success notification');
	 Notification.info('Information notification');
	 Notification.warning('Warning notification');
	 Notification({message: 'Primary notification', title: 'Primary notification'});
	 Notification.error({message: 'Error notification 1s', delay: 1000});
	 Notification.success({message: 'Success notification 20s', delay: 20000});
	 Notification.error({message: '<b>Error</b> <s>notification</s>', title: '<i>Html</i> <u>message</u>'});
	 Notification.success({message: 'Success notification<br>Some other <b>content</b><br><a href="https://github.com/alexcrack/angular-ui-notification">This is a link</a><br><img src="https://angularjs.org/img/AngularJS-small.png">', title: 'Html content'});
	*/
	$scope.FlashHeaderMessage = function()
	{
		if($scope.HeaderMessageFlashCounter>=$scope.HeaderMessagesList.length)
			$scope.HeaderMessageFlashCounter=-1;

		$scope.HeaderMessageFlashCounter++;
		var loopcount =0;
		angular.forEach($scope.HeaderMessagesList, function(item) {
			if($scope.HeaderMessageFlashCounter==loopcount)
    		Notification.warning({message: item.Message, delay: 4000});

    		loopcount++;
		});
		
	}

	$scope.DownloadReport = function(item)
	{
		 
		  $window.open("api/v1/DownloadReport?FileName="+item.FileName+"&FolderName="+item.FolderName);
		  
	}

	$scope.UpdateCurrentlyBrowsingHotel = function()
	{
		  //alert('hai');
		  
		  $scope.ShowTrafficIndication = false;
		  Data.post('UpdateCurrentlyBrowsingHotel',{
		  	dparams: {'SelectedHotel':$scope.SelectedHotel.GroupId}
			}).then(function (results) {
				$scope.ContactFormMessageList = null;
				$scope.ContactFormMessageList = results.data;
				$scope.ContactFormMessageNewCount = results.NewCount;
						//Data.toast(results);								
				
						$timeout(function(){ $scope.ShowTrafficIndication = true; }, 600);
		  }); 
	}
	

	$scope.CheckIfListHasIDZero = function(arrlist)
	  {
	  	alert('came');
	  	/*var cntv=0;
	  angular.forEach(arrlist, function(value, key) {
	  		if(key=="ID" && value=="0")  
	  		cntv++;			
		});
	  alert((arrlist.count==cntv));
	  return (arrlist.count==cntv);*/
	}

	$scope.exportDataToPDF = function (tableid) 
	{
		thisObj1.CallPDFCreator(tableid);   
    };

	$scope.doDeleteReportFile = function (DelFile) {
		
		if(confirm('Do you really want to delete the File ?'))
		{
			//alert(Deluser.ID);
			Data.post('DeleteReportFile', {
				dparams: DelFile
			}).then(function (results) {
				
				if (results.status == "success") {
					Data.toast(results);
					$scope.GetReportsToDownload();
				}
				else
				{
					Data.toast(results);
				}
			});
		}
    };
    

  

	  $scope.ShowHelpPopup = function (templatePath) {

		    $rootScope.theme = 'ngdialog-theme-plain';

		    ngDialog.open({

		    //template: 'firstDialogId',
		    templateUrl : "partials/HelpContent/"+templatePath,
		    controller: 'helpCtrl',

		    className: 'ngdialog-theme-plain custom-width'

		    });

    };

    $scope.GetTotalAnnualSavings = function(ListObject)
    {
    	var tot =0;
    	angular.forEach(ListObject, function (item) {
						    item.ValuePerAnnum = parseFloat(item.ValuePerAnnum);
						    tot = tot+item.ValuePerAnnum;
						   	});

    	return tot;
    }

    $scope.greaterThan = function(prop, val){
    return function(item){
      return item[prop] > val;
    }
   }

/*    $scope.SetDragableWidgets = function()
    {
    	thisObj1.MakeWidgetsDragable();  
    }
*/

    $scope.SendReportsNotificationEmail = function()
    {
    	var content = $("#ReportsEmaileditor").val();
    	alert(content);
    }

    $scope.SaveReportReadyTemplate = function()
    {
    	var content = $("#ReportsEmaileditor").val();
    	if(content!="")
    	{
    		$scope.ReportReadyEmailtemplate.HotelID = $scope.SelectedHotel.GroupId;
    		$scope.ReportReadyEmailtemplate.HtmlContent = content;
    		Data.post('SaveReportReadyTemplate',{
		  	dparams: $scope.ReportReadyEmailtemplate
			}).then(function (results) {
				$scope.ReportReadyEmailtemplate.ID = results.ID;
				Data.toast(results);
		  }); 
    	}
    }

    $scope.SendReportReadyNotificationEmail = function()
    {
    	var content = $("#ReportsEmaileditor").val();
    	if(content!="")
    	{
    		
    		$scope.ReportReadyEmailtemplate.HtmlContent = content;

    		Data.post('SendReportReadyNotificationEmail',{
		  	dparams: {'Email':$scope.ReportReadyEmailtemplate,'ToUsers':$scope.ReportSendToUsersList}
			}).then(function (results) {
				Data.toast(results.data);
		  }); 
    	}
    }

    $scope.ReportsCheckIfChecked = function () 
    {
    	var myRedObjects = $filter('filter')($scope.ReportsToDownloadList, { Checked: true });
    	return myRedObjects.length>0;
    }

    $scope.doMailThisReportFileToMe = function (eFile) {
		
		if(confirm('Do you really want to Email the selected File(s) to your email ?'))
		{
			//alert(Deluser.ID);
			if(eFile!=null)
			var myRedObjects = $filter('filter')($scope.ReportsToDownloadList, { FolderName: eFile.FolderName,FileName:eFile.FileName });
			else
			{
				var myRedObjects = $filter('filter')($scope.ReportsToDownloadList, { Checked: true });
			}
			Data.post('MailThisReportFileToMe', {
				dparams: myRedObjects
			}).then(function (results) {
				
				if (results.data.status == "success") {
					Data.toast(results.data);
					//$scope.GetReportsToDownload();
				}
				else
				{
					Data.toast(results);
				}
			});
		}
    };
    
	LoadDashboard();
	
});

