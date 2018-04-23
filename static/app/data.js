app.factory("Data", ['$http', 'toaster',
    function ($http, toaster) { // This service connects to our REST API

        var serviceBase = 'api/v1/';
        
        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 10000, 'trustedHtml');
        }
		obj.Addtoast = function (inf,Msg) {
            toaster.pop(inf, "", Msg, 10000, 'trustedHtml');
        }
        obj.AddtoastTopRight = function (inf,Msg) {
            //toaster.options.positionClass = 'toast-top-right'
            toaster.pop(inf, "", "<img src='images/hourglass.gif' width='25px' height='30px'/>"+Msg, 0, 'trustedHtml');
            
        }
        obj.ClearStatictoast = function (id) {
            toaster.clear(undefined, id);
        }
        obj.get = function (q) {
			//alert(serviceBase + q);
            return $http.get(serviceBase + q).then(function (results) {
                //alert('good');
                if( typeof results === 'undefined' || results === null ){
                     results = {'Error':true};
                    //alert('1');
                    return results;
                }
                else
                {

				    results.data.Error = false;
                    //alert('2');
                    return results.data;
                }
            })
			.catch(function(response) {
                //alert('exception');
			  //console.error('Gists error', response.status, response.data);
			  //toaster.pop("error", "", response.data, 10000, 'trustedHtml');
			  
			  //toaster.pop("error", "", "An HTTP error occured", 10000, 'trustedHtml');
              var results = {'data':{'Error':true}};
			  return results;
			});
        };
        obj.post = function (q, object) {
			//alert(serviceBase + q);
            return $http.post(serviceBase + q, object).then(function (results) {

                if( typeof results === 'undefined' || results === null ){
                     results = {'Error':true};
                    //alert('error');
                    return results;
                }
                else
                {
				//alert(results);
                    //alert('success');
				    results.data.Error = false;
                    return results.data;
                }
            })
			.catch(function(response) {
			  //console.error('Gists error', response.status, response.data);
			  //alert('error');
			  //toaster.pop(response.status, "", response.data, 10000, 'trustedHtml');
			  
			  response.Error = true;
			  //if(q=='LoadLogActivityDetails')
				  //alert(response);
			  return response;
			});
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);