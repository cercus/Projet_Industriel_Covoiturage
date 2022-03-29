$("#villeDep").change(function(event) {
    $("#numRueArr").val("170");
    $("#rueArr").val("Avenue de Luminy");
    $("#cpArr").val("13009");
    $("#villeArr").val("Marseille");
    document.getElementById("destination").innerHTML = "Université de Luminy";
    document.getElementById("depart").innerHTML = "Départ";
    //$("#destination").val("Université de Luminy");

});

$("#villeArr").change(function(event) {
    $("#numRueDep").val("170");
    $("#rueDep").val("Avenue de Luminy");
    $("#cpDep").val("13009");
    $("#villeDep").val("Marseille");
    document.getElementById("depart").innerHTML = "Université de Luminy";
    document.getElementById("destination").innerHTML = "Destination";
    //$("#depart").val("Université de Luminy");

});