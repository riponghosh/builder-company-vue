  $( document ).ready(function() {
var  form = $('#thisisbody'),
//var  form = $(window),
  //cache_width = form.width(),
  //cache_width = $(window).width()-200,
  a4  =[ 595.28,  841.89];  // for a4 size paper width and height

$('#create_pdf').on('click',function(){
  //alert('hi');
  $('body').scrollTop(0);
  createPDF();
});
//create pdf
function createPDF(){
  getCanvas().then(function(canvas){
    var  img = canvas.toDataURL("image/png");

	var imgWidth = 460; 
      var pageHeight = 600;  
      var imgHeight = canvas.height * imgWidth / canvas.width;
      var heightLeft = imgHeight;
      var position = 0;


    doc = new jsPDF({unit:'px', format:'a4'}); 
     //doc = new jsPDF('p', 'mm');

    	doc.addImage(img, 'PNG', 0, position, imgWidth, imgHeight);
    	heightLeft -= pageHeight;

      while (heightLeft >= 0) {
        position = heightLeft - imgHeight;
        doc.addPage();
        doc.addImage(img, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;
      }

        //doc.addImage(img, 'JPEG', 20, 20);
        doc.save('rpportal.pdf');
        //form.width(cache_width);
  });
}

// create canvas object
function getCanvas(){
 // form.width((a4[0]*1.33333) -80).css('max-width','none');
  return html2canvas(form,{
      imageTimeout:2000,
      removeContainer:true
    }); 
}
});