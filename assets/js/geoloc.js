var language;

var messages = {};

messages['wait'] = {
    'english' : 'Please wait...', 
    'french' : 'Veuillez patienter...'
};
messages['no_geoloc'] = {
    'english' : 'Your browser does not support geolocation', 
    'french' : 'Votre navigateur n\'est pas compatible avec la géolocalisation'
};
messages['locate_ok'] = {
    'english' : 'Your location has been detected', 
    'french' : 'Votre position a été détectée'
};
messages['detect_addr'] = {
    'english' : 'Detected address:', 
    'french' : 'Adresse détectée:'
};
messages['corr_addr'] = {
    'english' : 'If this address is correct, click "Validate my position". Otherwise, click again on "Locate me".', 
    'french' : 'Si cette adresse est correcte, cliquez sur "Valider ma position". Sinon, cliquez de nouveau sur "Me localiser".'
};

$(function() {
});

function locate(lang){
    language = lang;

    $("#show_close").css("display", "none");
    $("#result").html(messages['wait'][language]);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(setPosition);
    } 
    else { 
        $("#result").html(messages['no_geoloc'][language]);
    }
}

function setPosition(position) {

    var address = '';

    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    document.cookie = "lat=" + latitude;
    document.cookie = "lon=" + longitude;

    $("#show_close").css("display", "block");
    $("#show_close").css("margin-left", "auto");
    $("#show_close").css("margin-right", "auto");

    $.getJSON("https://nominatim.openstreetmap.org/reverse?format=json&lat=" + latitude + "&lon=" + longitude, function(data){
        
        var displayName = JSON.stringify(data['display_name']);
        var nameArray = displayName.split(',');
        var reverseArray = nameArray.reverse();

        reverseArray.splice(2, 4);

        var finalNameArray = reverseArray.reverse();
        var nameStr = finalNameArray.join();

        document.cookie = "address=" + nameStr;

        $("#result").html(messages['detect_addr'][language] + " " + '<span class="font-weight-bold">' + nameStr.substr(1, nameStr.length-2) + "</span><p>" + messages['corr_addr'][language] + "</p>");
    });
    
    
}

 
 