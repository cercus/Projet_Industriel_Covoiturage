@extends('base')

@section('title')
Proposer un trajet
@endsection

@section('style')
<link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
<ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{route('inscription')}}">Inscription</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('connexion')}}">Connexion</a>
    </li>
</ul>
@endsection

@section('content')
<h1 class="center-title">Proposer un trajet</h1>
<div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
  Thank you for getting in touch! 
</div>
<div>
    <form id="mapForm">
        @csrf
        @if($errors->any())
        <div class="alert alert-warning">
            Le trajet n'a pas pu être ajouté &#9785; {{implode('', $errors->all('<div>:message</div>'))}}
        </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                    {{session()->get('success')}}&#9786;
            </div>
        @endif
        <div>
            <div class="col-right-input-trajet">
                <div class="border border-dark">
                    <h2 class="center-title">Départ</h2>
                    <div class="col-md-10 mx-auto space-bottom-title">
                        <div class="col-right-input">
                            <label for="numRueDep">Numero de rue</label>
                            <input type="text" placeholder="3" class="input-form @error('numRueDep') is-invalid @enderror" id="numRueDep" name="numRueDep" aria-describedby="numRueDepError">
                            <span class="text-danger" id="numDepError"></span>
                        </div>
                        <div class="col-left-input">
                            <label for="rueDep">Nom de la voie</label>
                            <input type="text" placeholder="Boulevard Baille" class="input-form @error('rueDep') is-invalid @enderror" id="rueDep" name="rueDep" aria-describedby="rueDepError" required>
                            <span class="text-danger" id="rueDepError"></span>
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpDep">Code postal</label>
                            <input type="number" placeholder="13010" class="input-form @error('cpDep') is-invalid @enderror" id="cpDep" name="cpDep" aria-describedby="cpDepError" required>
                            <span class="text-danger" id="cpDepError"></span>
                        </div>
                        <div class="col-left-input">
                            <label for="villeDep">Ville</label>
                            <input type="text" placeholder="Marseille" class="input-form @error('villeDep') is-invalid @enderror" id="villeDep" name="villeDep" aria-describedby="villeDepError" required>
                            <span class="text-danger" id="villeDepError"></span>
                        </div>
                    </div>
                </div>

                <div class="border border-dark" style="margin-top: 20px;">
                    <h2 class="center-title">Destination</h2>
                    <div class="col-md-10 mx-auto space-bottom-title">
                        <div class="col-right-input">
                            <label for="numRueArr">Numero de rue</label>
                            <input type="text" placeholder="3" class="input-form @error('numRueArr') is-invalid @enderror" id="numRueArr" name="numRueArr" aria-describedby="numRueArrError">
                            <span class="text-danger" id="numRueArrError"></span>
                        </div>
                        <div class="col-left-input">
                            <label for="rueArr">Nom de la voie</label>
                            <input type="text" placeholder="Boulevard Baille" class="input-form @error('rueArr') is-invalid @enderror" id="rueArr" name="rueArr" aria-describedby="rueArrError" required>
                            <span class="text-danger" id="rueArrError"></span>
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpArr">Code postal</label>
                            <input type="number" placeholder="13010" class="input-form @error('cpArr') is-invalid @enderror" id="cpArr" name="cpArr" aria-describedby="cpArrError" required>
                            <span class="text-danger" id="cpArrError"></span>
                        </div>
                        <div class="col-left-input">
                            <label for="villeArr">Ville</label>
                            <input type="text" placeholder="Marseille" class="input-form @error('villeArr') is-invalid @enderror" id="villeArr" name="villeArr" aria-describedby="villeArrError">
                            <span class="text-danger" id="villeArrError"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-left-input-trajet">
                <div>
                    <div id="map" style="width: 100%; height: 550px;"></div>
                    <!--
                    <img src="/images/map_example.png" width="100%"> -->
                    <div class="row justify-content-center align-items-center col-button-trajet" style="padding-top: 20px;">

                        <button type="submit" class="btn button-form" id="valider" disabled>Soumettre</button>
                        <a class="btn button-form" onclick="test()" id="valider">Voir l'itinéraire</a>
                    </div>

                </div>
            </div>


        </div>

        <div class="col-right-input-accueil">
            <div style="padding-bottom: 20px;">
                <div class="col-md-10 mx-auto space-bottom-title">
                    <div class="col-right-input">
                        <label for="date">Date de départ</label>
                        <input type="datetime-local" class="input-form @error('date') is-invalid @enderror" id="date" name="date" aria-describedby="dateError" required>
                        <span class="text-danger" id="dateError"></span>
                    </div>
                    <div class="col-left-input">
                        <label for="place">Nombre de place(s)</label>
                        <input type="number" placeholder="1" class="input-form @error('place') is-invalid @enderror" id="place" name="place" aria-describedby="placeError" required>
                        <span class="text-danger" id="placeError"></span>
                    </div>
                </div>
                <div class="col-md-10 mx auto space-bottom-title" style="margin: 0 auto; text-align: center;">
                        <label for="prix">Prix</label>
                        <input type="number" placeholder="1" class="input-form @error('prix') is-invalid @enderror" id="prix" name="prix" aria-describedby="prixError" required>
                        <span class="text-danger" id="prixError"></span>
                </div>
            </div>
        </div>
        
    </form>
</div>
<script>
    /*
    var poly = "}ukgGyq~_@d@x@JDARAp@DlA?zBEn@BZHLv@x@Zb@Zr@hAnD`@pADl@Dr@DVRb@PTt@lA\TNDVDRDvAP`@?H?@e@@UHc@fAmCNc@IE[Sq@k@e@]~@uChAoDb@uAj@oBJ_@bCmHX}@Nc@Ry@?m@SUe@m@w@sA_BiD{AoDcD_HeCkFm@qAeAsBm@iA}CiFcCcDaAiAiEaFgGiHMQM]yAoBuAmB{BsDu@uAGM_@u@iAeCs@mBSgATUTMfAYdAKlAIbBErAAxB@bCL^EvCHrEFjA@~DF~GBz@Ap@I|Bm@hB}@|EiCjAm@`AYrCm@pBSdFk@~Ei@hBSjGk@nCSd@ElCOdEO~E?lB?tCFbGVnBNfDVtEX|DXrFZnHd@pAFrFLXDvA?xA?tBErGOvFQpEYFBT@pACv@EbAK\Gz@Sv@MzAS~Aq@ZU^c@L_@Pm@f@Y|@YpDqAbEy@h@KbACrBCx@DVB|ABrDD|A@tBThAPz@XXJzBr@rAr@~FlEfFxDzF~DrCpBbCjB|BpAfC`AjFzAnEpAz@RlFlBlAb@jBt@PDZLlAt@xAz@dAl@fBhA~GrEl@d@jA~@vBjBj@b@?D?BBHBFLBLIBQ?Cf@g@f@a@zAoAtCaDtAsAxDkDRWLIFCBCj@s@j@eAZc@z@s@xAo@`ACr@KTCt@W`@Un@g@dCaCbAeAl@i@j@QZCVBVFBFBDHDN?JS@Er@OPEt@CtBMzCUt@MVInDcC`EcDdAs@tB}@`Bq@h@]X]j@mAb@{@zBcFp@}ATWTE@BJBHAHIDM?MCMGIIESc@w@qB}AcE[_AWiAc@gCUyBg@qLAaACeA?k@@YDKBO?MEQB_@JcE@aAFc@VeAP_@V[`@[d@QVGJ?vAQpBYtAk@hDk@nBUhBM`Eo@xB]^C\Bp@NTNXXR\N^R~@n@xFVfAb@r@XVXNz@n@BLRNHCHKDSRW`@MnAUtCY~Ec@xAIhBHhDZ|@DrAKz@IX?z@Mn@_@TRfAI";
    document.cookie = "distance_total=15311";
    document.cookie = "temps_trajet=1241";
    document.cookie = "polyline="+poly;
    document.cookie = "debutLat=43.3188657";
    document.cookie = "debutLon=5.4046122";
    document.cookie = "endLat=43.231462";
    document.cookie = "endLon=5.4361815";
    */


    
    var geocoder;
    var map;
    var directionsService;
    var directionsRenderer;


    var distanceTotale;// = 15201;
    var tempsTrajet;// = 1254;
    var polyline;// = "tetstetgyjfs";

    var debutLat;// = 43.36;
    var debutLon;// = 2.54;
    var finLat;// = 43.78;
    var finLon;// = 2.65;
    var numRueDep = 0;

    
    $('#mapForm').on('submit',function(e){
    e.preventDefault();
    console.log("Csrf = " + "{{ csrf_token() }}");
    // Récupération des variables du formulaire
    numRueDep = $('#numRueDep').val();
    console.log("Numero de rue : " + numRueDep);
    let rueDep = $('#rueDep').val();
    let cpDep = $('#cpDep').val();
    let villeDep = $('#villeDep').val();

    let numRueArr = $('#numRueArr').val();
    let rueArr = $('#rueArr').val();
    let cpArr = $('#cpArr').val();
    let villeArr = $('#villeArr').val();

    let date = $('#date').val();
    let place = $('#place').val();
    let prix = $('#prix').val();
    
    var newData = {
        "_token": "{{ csrf_token() }}",
        numRueDep:numRueDep,
        rueDep:rueDep,
        cpDep:cpDep,
        villeDep:villeDep,
        numRueArr:numRueArr,
        rueArr:rueArr,
        cpArr:cpArr,
        villeArr:villeArr,
        dateDepart: date,
        place: place,
        prix: prix,
        debutLat:debutLat,
        debutLon: debutLon,
        finLat:finLat,
        finLon:finLon,
        distance:distanceTotale,
        tempsTrajet:tempsTrajet,
        polyline:polyline
    };

    var dataJson = JSON.stringify(newData);

    $.ajax({
      url: "/conducteur/submit_proposer_trajet", // Url de post
      type:"POST", // Type
      data:dataJson, // Toutes les données qu'on envoie au serveur
      dataType: "json",
      contentType: "application/json",
      success:function(response){ // En cas de succès
        $('#successMsg').show();
        console.log(response);
        window.location = "{{ route('trajets_en_cours')}}";
      },
      error: function(response) { // En cas d'echec
        $('#numRueDepError').text(response.responseJSON.errors.numRueDep);
        $('#rueDepError').text(response.responseJSON.errors.rueDep);
        $('#cpDepError').text(response.responseJSON.errors.cpDep);
        $('#villeDepError').text(response.responseJSON.errors.villeDep);

        $('#numRueArrError').text(response.responseJSON.errors.numRueArr);
        $('#rueArrError').text(response.responseJSON.errors.rueArr);
        $('#cpArrError').text(response.responseJSON.errors.cpArr);
        $('#villeArrError').text(response.responseJSON.errors.villeArr);

        $('#dateError').text(response.responseJSON.errors.date);
        $('#placeError').text(response.responseJSON.errors.place);
        $('#prixError').text(response.responseJSON.errors.prix);
      },
      });
    });
    
    
    function initMap() {
        //geocoder = new google.maps.Geocoder();
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer()
        // The location of Uluru
        const luminy = { lat: 43.2319, lng: 5.4399 };
        // The map, centered at Uluru
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 9,
            center: luminy,
        });
        directionsRenderer.setMap(map);
        // The marker, positioned at Uluru
        
        //const marker = new google.maps.Marker({
        //    position: uluru,
        //    map: map,
        //});
        
    }
    function test(){
        
        var depart = $("#numRueDep").val()+" " +$("#rueDep").val()+" " + $("#cpDep").val() + " " + $("#villeDep");
        var arrivee = $("#numRueArr").val()+" " +$("#rueArr").val()+" " + $("#cpArr").val() + " " + $("#villArr");
        
        directionsService.route({
            origin: {
                query: depart,
            },
            destination: {
                query: arrivee,
            },
            travelMode: google.maps.TravelMode.DRIVING,
            drivingOptions: {
                departureTime: new Date(Date.now()),
                trafficModel: 'optimistic' 
            },

        }).then((response) => {
            directionsRenderer.setDirections(response);
            var parseJson = JSON.parse(JSON.stringify(response));
            console.log(JSON.parse(JSON.stringify(response)));
            distanceTotale = parseJson["routes"][0]["legs"][0]["distance"]["value"];
            tempsTrajet = parseJson["routes"][0]["legs"][0]["duration"]["value"];
            debutLat = parseJson["routes"][0]["legs"][0]["start_location"]["lat"];
            debutLon = parseJson["routes"][0]["legs"][0]["start_location"]["lng"];
            finLat = parseJson["routes"][0]["legs"][0]["end_location"]["lat"];
            finLon = parseJson["routes"][0]["legs"][0]["end_location"]["lng"];
            console.log(distanceTotale +" / " + tempsTrajet + "/ (" + debutLat + ", " + debutLon +") / (" + finLat+", " + finLon + " )");
            //console.log(parseJSON);
            document.getElementById("valider").disabled = false;
            

            //var distanceTotale = response["routes"][0]["legs"][0]["distance"]["value"];
            //var tempsTrajet = response["routes"][0]["legs"][0]["duration_in_traffic"]["value"];
            //var polyline = response["routes"][0]["overview_polyline"];
            //var debutLat = response["routes"][0]["legs"][0]["start_location"]["lat"];
            //var debutLon = response["routes"][0]["legs"][0]["start_location"]["lon"];

            //var finLat = response["routes"][0]["legs"][0]["end_location"]["lat"];
            //var finLon = response["routes"][0]["legs"][0]["end_location"]["lon"];



            //var json = JSON.stringify(response);
            
            
        }).catch((e) => window.alert("Directions request failed du to " + status));
        

        
        // geocoder.geocode( {'address': depart}, function(results, status) {
        //     if(status == 'OK') {
        //         var markerDep = new google.maps.Marker({
        //             map: map,
        //             position: results[0].geometry.location
        //         });
        //     } else {
        //         alert("Impossible de set le point de départ" + status);
        //     }
        // });

        // geocoder.geocode( {'address': arrivee}, function(results, status) {
        //     if(status == 'OK') {
        //         map.setCenter(results[0].geometry.location);
        //         var markerArr = new google.maps.Marker({
        //             map: map,
        //             position: results[0].geometry.location
        //         });
        //     } else {
        //         alert("Impossible de set le point d'arrivé" + status);
        //     }
        // });
        
        

    }
    
    


</script>
<script src="/js/proposerTrajet.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI6VY9vV6I-kMSDuPGImo-WM0s7Iu1S5c&callback=initMap&libraries=places,geometry&solution_channel=GMP_QB_locatorplus_v4_cABCDE" async defer></script>

@endsection