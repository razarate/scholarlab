jQuery(document).ready(function() {

    setInterval(checkSensor, 3000);

});

function checkSensor() {

    //var token = jQuery("#token").attr("name");

    jQuery.ajax({
        data: { /*[token]: "1", */view:"proxy" , task: "devicedata", format: "json", device: "allData" },
        success: function(result, status, xhr)
            {
                const resultObject = JSON.parse(result.data);
                //console.log('Ajax response: ' + result.data);
                //console.log('0x76: ' + resultObject['0x76']['Temp']);
                if (document.getElementById("bme280Temp")) {
                    document.getElementById("bme280Temp").innerHTML = parseFloat(resultObject['0x76']['Temp']).toFixed(2);
                    document.getElementById("bme280Humidity").innerHTML = parseFloat(resultObject['0x76']['Humidity']).toFixed(2);
                    //document.getElementById("bme280Alt").innerHTML = parseFloat(resultObject['0x76']['Alt']).toFixed(2);
                    document.getElementById("bme280Pressure").innerHTML = parseFloat(resultObject['0x76']['Pressure']).toFixed(2);
                }
                if (document.getElementById("ds18b20_1")) {
                    document.getElementById("ds18b20_1").innerHTML = parseFloat(resultObject['28-01191ed83f34']['Temp']).toFixed(2);
                    document.getElementById("ds18b20_2").innerHTML = parseFloat(resultObject['28-01191ecb8132']['Temp']).toFixed(2);
                }
                if (document.getElementById("ds18b20_3")) {
                    document.getElementById("ds18b20_3").innerHTML = parseFloat(resultObject['28-020a91772089']['Temp']).toFixed(2);
                }

                /*
                if (resultObject.status == 'opened') {
                    submitForm();
                }*/
            },
        error: function() { console.log('ajax call failed'); },
    });
}

function submitForm() {
  document.waitingRoomForm.submit();
}