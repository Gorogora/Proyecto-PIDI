
$.ajax({
        url: './php/storedTweets.php',
        type: 'POST',
        success:  function (response) {
            $('#numberOfTweets').html(response); 
        }   
});

$.ajax({
    url: './php/firstTweet.php',
    type: 'POST',
    success:  function (response) {
        $('#firstTweet').html(response); 
    }   
});

$.ajax({
    url: './php/lastTweet.php',
    type: 'POST',
    success:  function (response) {
        $('#lastTweet').html(response); 
    }   
});

$.ajax({
    url: './php/tweetMasRetwitteado.php',
    type: 'POST',
    success:  function (response) {
        $('#numberOfReTweets').html(response); 
    }   
});

$.ajax({
    url: './php/usuariosMasMencionados.php',
    type: 'POST',
    success:  function (response) {
        $('#mostMentionedUsers').html(response); 
    }   
});

$.ajax({
    url: './php/hashtagMasFrecuente.php',
    type: 'POST',
    success:  function (response) {        
        $('#mostFrequentHashtag').html(response); 
    }   
});

$.ajax({
    url: './php/usuarioConMasTweets.php',
    type: 'POST',
    success:  function (response) { 
        $('#userWithMoreTweets').html(response); 
    }   
});

$.ajax({
    url: './php/idiomasTweets.php',
    type: 'POST',
    success:  function (response) { 
        //console.log(response);
        var data = JSON.parse(response);
        //console.log(data.tweets);        
        crea_pie_idiomas("pieChartLanguage", data.tweets, data.language, 'pie');
        
    }   
});

$.ajax({
    url: './php/lugaresTweets.php',
    type: 'POST',
    success:  function (response) { 
        //console.log(response);
        var data = JSON.parse(response);
        //console.log(data.tweets);        
        crea_pie_idiomas("pieChartPlace", data.tweets, data.place, 'doughnut');
        
    }   
});

$.ajax({
    url: './php/minutoMasCaliente.php',
    type: 'POST',
    success:  function (response) { 
        //console.log(response);
        var data = JSON.parse(response);
        console.log(data);        
        crea_bar_chart("barChartMinute", data.hora, data.tweets, 'No de tweets', 'Hora');        
    }   
});

$(document).ready(function(){
    $.ajax({
    url: './php/getColecciones.php',
    type: "POST",  
    success: function(response) {     
        console.log(response);
        $('#selectColeccion').html(response);          
    }
    });
});

function creaColeccionFiltrada(coleccion){
    var fechaInicio = $("#inputDateIni").val();
    var fechaFin = $("#inputDateFin").val();
    var userName = $("#inputUserName").val();
    var palabras = $("#inputPalabras").val();
    var idioma = $("#inputLanguage").val();
    var pais = $("#inputPlace").val();
    var retweet = $("#optionRetweed").is(':checked');
    var hashtag = $("#inputHashtag").val();

    //COMPROBAR QUE AL MENOS SE HA SELECCIONADO UN FILTRO!!!

    $.ajax({
        url: './php/creaColeccionFiltrada.php',
        type: 'POST',
        data: {
            coleccion:coleccion,
            fechaInicio:fechaInicio,
            fechaFin:fechaFin,
            userName:userName,
            palabras:palabras,
            idioma:idioma,
            pais:pais,
            retweet:retweet,
            hashtag:hashtag
        },
        success:  function (response) { 
            
        }   
    });
    
}


var backgroundColor = [
    "#455C73",
    "#9B59B6",
    "#BDC3C7",
    "#26B99A",
    "#3498DB",
    "#ff99bb",
    "#ffa64d",
    "#ffff33",
];

/*
type: 'doughnut' o 'pie'
*/
function crea_pie_idiomas(elementId, dataset, labels, type){
    var size = dataset.length;
    if(size > backgroundColor.length){
        dataset = dataset.slice(0, backgroundColor.length + 1);
        labels = labels.slice(0, backgroundColor.length + 1);
    }
    else if(size < backgroundColor.length){
        backgroundColor = backgroundColor.slice(0, size + 1);
    }

    var ctx = document.getElementById(elementId);

    var data = {
        labels : labels,
        datasets : [
            {
                data : dataset,
                backgroundColor: backgroundColor,
            }
        ]
    };

    var pieChart = new Chart(ctx, {
        data: data,
        type: type/*,
        options: {
          legend: false
        }*/
      });
}

function crea_bar_chart(elementId, labelsX, data, label, unit){
    var ctx = document.getElementById(elementId);
    var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsX,
            datasets: [{
                label: label,
                backgroundColor: "#03586A",
                data: data
            }]
        },

        options: {
            scales: {
              xAxes: [{
                time: {
                  unit: unit
                },
                gridLines: {
                  display: false
                },
                ticks: {
                  maxTicksLimit: 6
                }
              }],
              yAxes: [{
                ticks: {
                  min: 0,
                  max: data[0]+10,
                  maxTicksLimit: 5
                },
                gridLines: {
                  display: true
                }
              }],
            },
            legend: {
              display: true
            }
        }
    });
}