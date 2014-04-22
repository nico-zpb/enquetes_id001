/**
 * Created by Nicolas Canfrere on 22/04/14.
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


$(function(){

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
});