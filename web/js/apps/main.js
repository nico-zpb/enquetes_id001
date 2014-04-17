

$(function(){
    function getNumDaysInMonth(m,y){
        return new Date(y,( m+1), 0).getDate();
    }

    var annee = $("#q5_annee"), mois = $("#q5_mois"), jour=$("#q5_jour");


    annee.on("change", function(evt){
        var a = parseInt($(this).val());
        var m = parseInt(mois.val()-1);

        var nj = getNumDaysInMonth(m,a);
        jour.empty();

        for(var i=0; i<nj; i++){
            jour.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });

    mois.on("change", function(evt){
        var m = parseInt($(this).val()) - 1;
        var a = parseInt(annee.val());

        var nj = getNumDaysInMonth(m, a);
        jour.empty();

        for(var i=0; i<nj; i++){
            jour.append($("<option value='" + (i+1) + "'>" + (i+1) + "</option>"));
        }
    });



});
