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

    var spinners =      $(".spinner");
    spinners.spin(spinnerOpts);
    var excelSpinner =  $("#excelSpinner");
    excelSpinner.hide();
    var excelForm =     $("#excelForm");
    var excelSubmit =   $("#excelSubmit");
    var excelSuccess =  $("#excelSuccess");
    excelSuccess.hide();
    var excelError =    $("#excelError");
    excelError.hide();

    var annee_start =   $("#annee_start");
    var annee_end =     $("#annee_end");
    var mois_start =    $("#mois_start");
    var mois_end =      $("#mois_end");
    var jour_start =    $("#jour_start");
    var jour_end =      $("#jour_end");

    annee_start.on("change", function(evt){
        var a = parseInt($(this).val());
        var m = parseInt(mois_start.val()-1);

        var nj = getNumDaysInMonth(m,a);
        jour_start.empty();

        for(var i=0; i<nj; i++){
            jour_start.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    mois_start.on("change", function(evt){
        var m = parseInt($(this).val()) - 1;
        var a = parseInt(annee_start.val());

        var nj = getNumDaysInMonth(m, a);
        jour_start.empty();

        for(var i=0; i<nj; i++){
            jour_start.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    mois_end.on("change", function(evt){
        var m = parseInt($(this).val()) - 1;
        var a = parseInt(annee_end.val());

        var nj = getNumDaysInMonth(m, a);
        jour_end.empty();

        for(var i=0; i<nj; i++){
            jour_end.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    annee_end.on("change", function(evt){
        var a = parseInt($(this).val());
        var m = parseInt(mois_end.val()-1);

        var nj = getNumDaysInMonth(m,a);
        jour_end.empty();

        for(var i=0; i<nj; i++){
            jour_end.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    excelForm.on("submit", function(evt){
        evt.preventDefault();
        excelSubmit.attr("disabled","disabled").hide();
        excelSpinner.show();
        var url = $(this).attr("action");
        var successText;
        var datas = $(this).serialize();
        console.log(url, datas);
        $.post(url, datas)
            .done(function(data, textStatus, xhr){
                excelSpinner.hide();
                if(data && data.error){

                } else {
                    successText = '<a href="'+ data.link +'" class="alert-link">Téléchargez votre fichier ici.</a>';
                    excelSuccess.html(successText).show();

                    excelSubmit.removeAttr("disabled").show();
                }
            })
            .fail(function(xhr, textStatus, errorThrown){
                excelSpinner.hide();
                console.log(xhr, textStatus, errorThrown);
                excelError.text("Error "+ xhr.status + " " + xhr.statusText + ". Une erreur serveur est survenue, merci de prévenir le webmaster de cet incident. Excusez nous pour ce désagrément.").show();
            });
        return false;
    });
});
