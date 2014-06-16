/**
 * Created by Nicolas Canfrere on 23/04/2014.
 */
 /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/
var spinnerOpts = {
    lines: 9, // The number of lines to draw
    length: 4, // The length of each line
    width: 2, // The line thickness
    radius: 4, // The radius of the inner circle
    corners: 1, // Corner roundness (0..1)
    rotate: 0, // The rotation offset
    direction: 1, // 1: clockwise, -1: counterclockwise
    color: '#A9A085', // #rgb or #rrggbb or array of colors
    speed: 1.1, // Rounds per second
    trail: 100, // Afterglow percentage
    shadow: false, // Whether to render a shadow
    hwaccel: false, // Whether to use hardware acceleration
    className: 'spinner', // The CSS class to assign to the spinner
    zIndex: 2e9, // The z-index (defaults to 2000000000)
    top: '50%', // Top position relative to parent
    left: '50%' // Left position relative to parent
};

$(function(){
    var spinners =      $(".excel-spinner");
    spinners.spin(spinnerOpts);

    var excelSpinner1 =  $("#excelSpinner1");
    var loader1 = $("#loader1");
    loader1.hide();
    var download_excel_global = $("#download-excel-global");
    download_excel_global.hide();
    var form_excel_global = $("#form_excel_global");
    var submit_excel_global = $("#submit_excel_global");

    form_excel_global.on("submit", function(evt){
        evt.preventDefault();
        submit_excel_global.hide();
        loader1.show();
        $.post(form_excel_global.attr("action"), form_excel_global.serialize())
            .done(function(resp){
                if(!resp.error){
                    /*console.log(resp);*/
                    loader1.hide();
                    var a = download_excel_global.find("a.btn");
                    var href = a.attr("href");
                    href = href + resp.link;
                    a.attr("href", href) ;
                    download_excel_global.show();
                } else {

                }
            })
            .fail(function(resp){

            });
        return false;
    });

    var excelSpinner2 =  $("#excelSpinner2");
    var loader2 = $("#loader2");
    loader2.hide();
    var download_excel_brutes = $("#download-excel-brutes");
    download_excel_brutes.hide();
    var form_excel_brutes = $("#form_excel_brutes");
    var submit_excel_brutes = $("#submit_excel_brutes");

    form_excel_brutes.on("submit",function(evt){
        evt.preventDefault();
        submit_excel_brutes.hide();
        loader2.show();
        $.post(form_excel_brutes.attr("action"), form_excel_brutes.serialize())
            .done(function(resp){
                if(!resp.error){

                    loader2.hide();
                    var a = download_excel_brutes.find("a.btn");
                    var href = a.attr("href");
                    href = href + resp.link;
                    a.attr("href", href) ;
                    download_excel_brutes.show();
                } else {

                }
            })
            .fail(function(resp){

            });
        return false;
    });


    var excelSuccess =  $("#excelSuccess");
    excelSuccess.hide();
    var excelError =    $("#excelError");
    excelError.hide();

});
