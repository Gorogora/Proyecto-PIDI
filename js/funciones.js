// contar el número de tweets
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