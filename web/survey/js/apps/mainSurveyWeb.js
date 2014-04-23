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
    var cwSpinner =  $("#cwSpinner");
    cwSpinner.hide();
    var cwmSuccess =  $("#cwmSuccess");
    cwmSuccess.hide();
    var cwmError =    $("#cwmError");
    cwmError.hide();
    var cwSuccess =  $("#cwSuccess");
    cwSuccess.hide();
    var cwError =    $("#cwError");
    cwError.hide();
    var jour_start_cw =     $("#jour_start_cw");
    var mois_start_cw =     $("#mois_start_cw");
    var annee_start_cw =    $("#annee_start_cw");
    var jour_end_cw =       $("#jour_end_cw");
    var mois_end_cw =       $("#mois_end_cw");
    var annee_end_cw =      $("#annee_end_cw");
    var cwForm =            $("#cwForm");
    var cwSubmit =          $("#cwSubmit");

    annee_start_cw.on("change", function(evt){
        cwError.html("").hide();
        var a = parseInt($(this).val());
        var m = parseInt(mois_start_cw.val()-1);

        var nj = getNumDaysInMonth(m,a);
        jour_start_cw.empty();

        for(var i=0; i<nj; i++){
            jour_start_cw.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    mois_start_cw.on("change", function(evt){
        cwError.html("").hide();
        var m = parseInt($(this).val()) - 1;
        var a = parseInt(annee_start_cw.val());

        var nj = getNumDaysInMonth(m, a);
        jour_start_cw.empty();

        for(var i=0; i<nj; i++){
            jour_start_cw.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    annee_end_cw.on("change", function(evt){
        cwError.html("").hide();
        var a = parseInt($(this).val());
        var m = parseInt(mois_end_cw.val()-1);

        var nj = getNumDaysInMonth(m,a);
        jour_end_cw.empty();

        for(var i=0; i<nj; i++){
            jour_end_cw.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    mois_end_cw.on("change", function(evt){
        cwError.html("").hide();
        var m = parseInt($(this).val()) - 1;
        var a = parseInt(annee_end_cw.val());

        var nj = getNumDaysInMonth(m, a);
        jour_end_cw.empty();

        for(var i=0; i<nj; i++){
            jour_end_cw.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    cwSubmit.on("click", function(evt){
        evt.preventDefault();
        //verif sur les dates
        cwSpinner.show();
        cwSubmit.attr("disabled", "disabled");
        var today = new Date();
        var todayTs = today.getTime();

        var dateStart = new Date(parseInt(annee_start_cw.val()), parseInt(mois_start_cw.val())-1, parseInt(jour_start_cw.val()), 0,0,0);
        var dateEnd = new Date(parseInt(annee_end_cw.val()), parseInt(mois_end_cw.val())-1, parseInt(jour_end_cw.val()), 0,0,0);
        var dateEndTs = dateEnd.getTime();
        var dateStartTs = dateStart.getTime();
        var errorMsg = "<strong>Erreur</strong> ";

        if(dateStartTs > dateEndTs){
            // erreur date de debut supérieure à date fin
            errorMsg += "La date de début de période ne peut être supérieure à la date de fin de période.";
            cwError.html(errorMsg).show();
            cwSpinner.hide();
            cwSubmit.removeAttr("disabled");
            return false;
        }

        if(dateStartTs > todayTs){
            // erreur date de debut supérieure à date aujourd'hui
            errorMsg += "La date de début de période ne peut être supérieure à la date du jour.";
            cwError.html(errorMsg).show();
            cwSpinner.hide();
            cwSubmit.removeAttr("disabled");
            return false;
        }

        if(dateEndTs > todayTs){
            // erreur date de fin supérieure à date aujourd'hui
            errorMsg += "La date de fin de période ne peut être supérieure à la date du jour.";
            cwError.html(errorMsg).show();
            cwSpinner.hide();
            cwSubmit.removeAttr("disabled");
            return false;
        }

        cwSpinner.hide();
        cwError.html("").hide();
        cwForm.submit();
        return false;
    });

});


