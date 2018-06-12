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
    url: './php/usuariosMasMencionados.php',
    type: 'POST',
    success:  function (response) {
        console.log(response);
        $('#mostMentionedUsers').html(response); 
    }   
});

$.ajax({
    url: './php/tweetMasRetwitteado.php',
    type: 'POST',
    success:  function (response) {
        console.log(response);
        $('#numberOfReTweets').html(response); 
    }   
});