/* Muestras las estadísticas de la colección seleccionada */
function estadisticasColeccion(coleccion){
    $.ajax({
        url: './php/storedTweets.php',
        type: 'POST',
        data: {coleccion: coleccion},
        success:  function (response) {
            $('#numberOfTweets').html(response); 
        }   
    });

    $.ajax({
        url: './php/firstTweet.php',
        type: 'POST',
        data: {coleccion: coleccion},
        success:  function (response) {
            $('#firstTweet').html(response); 
        }   
    });

    $.ajax({
        url: './php/lastTweet.php',
        type: 'POST',
        data: {coleccion: coleccion},
        success:  function (response) {
            $('#lastTweet').html(response); 
        }   
    });

    $.ajax({
        url: './php/tweetMasRetwitteado.php',
        type: 'POST',
        data: {coleccion: coleccion},
        success:  function (response) {
            $('#numberOfReTweets').html(response); 
        }   
    });

    $.ajax({
        url: './php/usuariosMasMencionados.php',
        type: 'POST',
        data: {coleccion: coleccion},
        success:  function (response) {
            $('#mostMentionedUsers').html(response); 
        }   
    });

    $.ajax({
        url: './php/hashtagMasFrecuente.php',
        type: 'POST',
        data: {coleccion: coleccion},
        success:  function (response) {        
            $('#mostFrequentHashtag').html(response); 
        }   
    });

    $.ajax({
        url: './php/usuarioConMasTweets.php',
        type: 'POST',
        data: {coleccion: coleccion},
        success:  function (response) { 
            $('#userWithMoreTweets').html(response); 
        }   
    });

    $.ajax({
        url: './php/idiomasTweets.php',
        type: 'POST',
        data: {coleccion: coleccion},
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
        data: {coleccion: coleccion},
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
        data: {coleccion: coleccion},
        success:  function (response) { 
            //console.log(response);
            var data = JSON.parse(response);
            //console.log(data);        
            crea_bar_chart("barChartMinute", data.hora, data.tweets, 'No de tweets', 'Hora');        
        }   
    });
}

$(document).ready(function(){
    //lista de colecciones
    $.ajax({
        url: './php/getColecciones.php',
        type: "POST",  
        success: function(response) {    
            $('#selectColeccion').html(response);          
        },
        error: function(response){
            console.log(response);
        }
    });
});

/* Lista los elementos deseados */
function filtrosColeccion(coleccion){
    //lista de usuarios
    $.ajax({
        url: './php/getUsuarios.php',
        type: "POST", 
        data: {coleccion: coleccion}, 
        success: function(response) { 
            $('#inputUserName').html(response);          
        },
        error: function(response){
            console.log(response);
        }
    });

    //lista de idiomas
    $.ajax({
        url: './php/getIdiomas.php',
        type: "POST",  
        data: {coleccion: coleccion},
        success: function(response) {  
            $('#inputLanguage').html(response);          
        },
        error: function(response){
            console.log(response);
        }
    });

    //lista de paises
    $.ajax({
        url: './php/getLugares.php',
        type: "POST", 
        data: {coleccion: coleccion}, 
        success: function(response) {  
            $('#inputPlace').html(response);          
        },
        error: function(response){
            console.log(response);
        }
    });

    //lista de hashtags
    $.ajax({
        url: './php/getHashtags.php',
        type: "POST", 
        data: {coleccion: coleccion}, 
        success: function(response) {  
            $('#inputHashtag').html(response);          
        },
        error: function(response){
            console.log(response);
        }
    });
}

/* Devuelve True si se ha seleccionado un elemento de una lista */
function isSelect(elemento){
    if(elemento != 0){
        return true;
    }
    
    return false;
}

/* Crea una nueva colección basada en los filtros 
seleccionados (al menos 3) */
function creaColeccionFiltrada(coleccion){
    if(isSelect(coleccion)){  
        // alamacenamos el valor de los filtros 
        var userName = $("#inputUserName").val(); 
        console.log(userName);
        var idioma = $("#inputLanguage").val();
        var pais = $("#inputPlace").val();
        var hashtag = $("#inputHashtag").val();
        var isRetweet = $("#optionRetweed").is(':checked');
        var fechaInicio = $("#inputDateIni").val();
        console.log(fechaInicio);
        var fechaFin = $("#inputDateFin").val();        
        var palabras = $("#inputPalabras").val(); 
        console.log(palabras);   
        

        //comprobar que se han seleccionado al menos 3 filtros
        var numFiltros = 0;
        var filtrosActivos = new Array(7);
        var filtros = 0;
        
        if(isSelect(userName)){
            filtrosActivos[numFiltros] = true;
            filtros = filtros + 1;
        }
        else{
            filtrosActivos[numFiltros] = false;        
        }
        numFiltros = numFiltros + 1;        

        if(isSelect(idioma)){
            filtrosActivos[numFiltros] = true;
            filtros = filtros + 1;
        }
        else{
            filtrosActivos[numFiltros] = false;
        } 
        numFiltros = numFiltros + 1;       
        
        if(isSelect(pais)){
            filtrosActivos[numFiltros] = true;
            filtros = filtros + 1;
        }
        else{
            filtrosActivos[numFiltros] = false;
        } 
        numFiltros = numFiltros + 1;       

        if(isSelect(hashtag)){
            filtrosActivos[numFiltros] = true;
            filtros = filtros + 1;
        }
        else{
            filtrosActivos[numFiltros] = false;
        }  
        numFiltros = numFiltros + 1;      

        if(isRetweet){
            filtrosActivos[numFiltros] = true;
            filtros = filtros + 1;            
        }
        else{
            filtrosActivos[numFiltros] = false;
        } 
        numFiltros = numFiltros + 1;       

        if(fechaInicio != "" && fechaFin != "" ){
            filtrosActivos[numFiltros] = true;
            filtros = filtros + 1;
        }
        else{
            filtrosActivos[numFiltros] = false;            
        }  
        numFiltros = numFiltros + 1;             

        if(palabras != ""){
            filtrosActivos[numFiltros] = true;
            filtros = filtros + 1;
        }
        else{
            filtrosActivos[numFiltros] = false;
        }
        numFiltros = numFiltros + 1;

        console.log(filtrosActivos);
        

        //si al menos se han seleccionado 3 filtros creamos la colección
        if(filtros >= 3){
                $.ajax({
                url: './php/creaColeccionFiltrada.php',
                type: 'POST',
                data: {
                    coleccion:coleccion,
                    filtrosActivos:filtrosActivos,
                    userName:userName,
                    idioma:idioma,
                    pais:pais,
                    hashtag:hashtag,
                    isRetweet:isRetweet,
                    fechaInicio:fechaInicio,
                    fechaFin:fechaFin,                    
                    palabras:palabras  
                },
                success:  function (response) { 
                    $('#alert').html(response); 
                }   
            });
        }
        else{
            $('#alert').html('<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-warning"></i> Seleccione al menos 3 filtros</h4></div>');
            console.log("Seleccione al menos tres filtros");
        }
    }
    else{
        console.log("Seleccione una colección");
    }   
    
}

/******  GRÁFICAS *******/
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