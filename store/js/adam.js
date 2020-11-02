

$(document).ready(function() {
    //INPUT FIELDS IN CHECKOUT PAGE DELIVERY OPTIONS
    $('.deliveryoptions input').on('keyup', function() {
        let empty = false;

        $('.deliveryoptions input').each(function() {
            var inputString=$(this).val();
            empty = inputString.length == 0;
        });

        $('.zip input').each(function() {
            var zipcode = $(this).val();
            empty = /^\d+$/.test(zipcode)==0; //im using \d to make sure that enteredd character only are 0-9
            if(!empty){ //now that i know empty contains only 0-9, make sure its length also is 5
                let fiveDigits;
                fiveDigits=zipcode.length == 5; //set fivedigits to true if length==5.
                empty=!fiveDigits; //this sets empty to false only when fivedigits==true.
            }
        });

        if (empty)
            $('.actions input').attr('disabled', 'disabled');
        else
            $('.actions input').attr('disabled', false);
    });



    //INPUT FIELDS IN CHECKOUT PAGE PAYMENT METHOD
    $('.paymentmethod input').on('keyup', function() {
        var empty2=false;

        $('.paymentmethod input').each(function() {
            if ($(this).val().length == 0) {
                empty2 = true;
            }
        });

        if (empty2)
            $('.actions2 input').attr('disabled', 'disabled');
        else
            $('.actions2 input').attr('disabled', false);
    });
});


// bring api key: f69bcc57-8320-4a15-8489-9983079efa72

//HERE IS THE GOOGLE MAP FUNCTIONALITIES -------------------------------------------------
//I have access to the google objects because the google maps api script drop those things in their forrest
var map;

//POSTNORD ARRAY THAT WILL HOLD THE LOCATION AND PICKUP POINT NAME AND ADDRESS
var coordARR=new Array();


//BRING ARRAY THAT WILL HOLD THE LOCATION AND PICKUP POINT NAME AND ADDRESS
var locationList=new Array();


jQuery(':submit').click(function () {

    //THIS IS THE BUTTON THAT CALLS THE DELIVERY COMPANY API'S AND PRINTS THE CHOSEN INFO ABOUT THE RECEIVED PICKUP-POINT DATA
    if(this.id == 'get_map') {

        var zipCode = $("#zip").val();


        //BRING GET DATA FROM THEIR DATABASE IN JSON FORMAT (THESE GUYS DATABASE WAS ALOT MORE DEVELOPER FRIENDLY TO USE THAN POSTNORD's) AND PUT THE RETRIEVED ATTRIBUTES IN CONTAINER TO BE USED LATER IN MAPS
        var deliverypoint2 = document.getElementById('deliverypointBring');

        //xhr2 retrieves the json data that the bring api supplies with this url
        var xhr2 = jQuery.get('https://api.bring.com/pickuppoint/api/pickuppoint/SE/postalCode/'+zipCode+'.json');
        xhr2.done(function (data){
            //console.log(data);
            var BreakException;
            var maxFive=0;

            try {
                data.pickupPoint.forEach(function (p) {
                    var locationHolder=new Array(); //for each lap create an empty array that in coming rows will push the pickup-point name, latitude, longtude and address
                    deliverypoint2.innerHTML += '<div class="border form-check radio"><label><input type="radio" class="form-check-input" name="optradio" data-toggle="collapse" data-target=".multi-collapse"><p class="font-weight-bold">'
                        +p.name +'</p>' + p.address + '<br>' + p.postalCode +' '+ p.city +'</label></div><br>';
                    locationHolder.push(p.name, p.latitude, p.longitude, p.address);
                    //console.log(locationHolder);

                    locationList.push(locationHolder); //Adds the latitude and longitude as a 2 element array in the locationList
                    //console.log(locationList);

                    maxFive = maxFive + 1;
                    if (maxFive === 5) throw BreakException; //A way to exit the foreach. Im aware that this could be done in other more elegant ways but i like the way the foreach transforms the data.pickupPoint into a single attribute since alot of attribute data are added in the loop. (which makes that adding process cleaner).
                });
            } catch (e){
                if (e !== BreakException) throw e;
            }
        });


            //POSTNORD GET DATA FROM THEIR DATABASE IN JSON FORMAT AND PUT THE RETRIEVED ATTRIBUTES IN CONTAINER TO BE USED LATER IN MAPS
            var deliverypoint = document.getElementById('deliverypointPostNord');
            var xhr = jQuery.get('https://cors-anywhere.herokuapp.com/https://api2.postnord.com/rest/businesslocation/v1/servicepoint/findByPostalCode.json?apikey=d3b6975d59adfcb276915c5d1ad08eea&countryCode=SE&postalCode=' + zipCode);

            xhr.done(function (data) {
                //console.log(data);                                                                                                                                            //#find_locations
                deliverypoint.innerHTML = '<div class="border form-check radio"><label><input type="radio" class="form-check-input" name="optradio" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="find_locations payment_method">' +
                    '<p class="font-weight-bold">'+
                    'POSTNORD/'+data.servicePointInformationResponse.servicePoints[0].name+'</p>'
                    + data.servicePointInformationResponse.servicePoints[0].deliveryAddress.streetName + ' ' + data.servicePointInformationResponse.servicePoints[0].deliveryAddress.streetNumber
                    + '<br>' + data.servicePointInformationResponse.servicePoints[0].deliveryAddress.postalCode
                    +' '+ data.servicePointInformationResponse.servicePoints[0].deliveryAddress.city+'</label></div>';
                //HERE I USE THE CITY, STREET NAME AND STREET NUMBER TO GET THE COORDINATES OF THAT LOCATION, I USE THIS LATER TO PUT OUT A MARKER IN THE GOOGLE MAP
                var getCoord = jQuery.get('https://cors-anywhere.herokuapp.com/https://api2.postnord.com/rest/businesslocation/v1/servicepoint/findNearestByAddress.json?apikey=d3b6975d59adfcb276915c5d1ad08eea&countryCode=SE&city=' + data.servicePointInformationResponse.servicePoints[0].deliveryAddress.city + '&streetName=' + data.servicePointInformationResponse.servicePoints[0].deliveryAddress.streetName + '&streetNumber=' + data.servicePointInformationResponse.servicePoints[0].deliveryAddress.streetNumber);

                getCoord.done(function (data) {
                    var placeHolder = new Array();

                    placeHolder.push("POSTNORD/" + data.servicePointInformationResponse.servicePoints[0].name, data.servicePointInformationResponse.servicePoints[0].coordinate.northing, data.servicePointInformationResponse.servicePoints[0].coordinate.easting, data.servicePointInformationResponse.servicePoints[0].deliveryAddress.streetName + ' ' + data.servicePointInformationResponse.servicePoints[0].deliveryAddress.streetNumber);

                    coordARR.push(placeHolder);
                    //console.log(coordARR);
                    createMap(); //Last of all, calls the map function
                })
            });
    }
});

function createMap () {
    var options = { //object with attributes of a set coordinate starting point & zoom
        center: {
            lat: coordARR[0][1], //map gets centered to the closest bring pickup-point coordinates
            lng: coordARR[0][2]
        },
        zoom: 13
    };

    //to get map to render i had to call the Map constructor inside the google map class and pass in the correct div container from the index.php.
    map = new google.maps.Map(document.getElementById('map'), options);


    var infowindow = new google.maps.InfoWindow();


    //POSTNORD
    //This chunk of code first puts out a mark for the recieved coordinates from coordARR and later adds shop:name and address (to that mark) which will pop up on click
    var mapMark, j;
    for (j = 0; j < coordARR.length; j++) {
        mapMark = new google.maps.Marker({
            position: new google.maps.LatLng(coordARR[j][1], coordARR[j][2]),
            map: map
        });

        google.maps.event.addListener(mapMark, 'click', (function (mapMark, j) {
            return function () {
                infowindow.setContent(coordARR[j][0]+'<br>'+coordARR[j][3]);
                infowindow.open(map, mapMark);
            }
        })(mapMark, j));
    }


    //BRING
    //This loop first puts out a mark for the recieved coordinates from locationList and later adds shop:name and address (to that same mark) which will pop up on click
    var mapPinPoint, i;
    for (i = 0; i < locationList.length; i++) {
        mapPinPoint = new google.maps.Marker({
            position: new google.maps.LatLng(locationList[i][1], locationList[i][2]),
            map: map
        });

        google.maps.event.addListener(mapPinPoint, 'click', (function (mapPinPoint, i) {
            return function () {
                infowindow.setContent(locationList[i][0]+'<br>'+locationList[i][3]);
                infowindow.open(map, mapPinPoint);
            }
        })(mapPinPoint, i));
    }
}


// END OF GOOGLE MAPS FUNCTIONALITIES ----------------------------------------------------