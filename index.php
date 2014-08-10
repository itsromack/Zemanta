<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Zemanta</title>
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>

<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Zemanta</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="#">Home</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container"><br /><br /><br /><br /></div>

<div class="zemanta">
    <table border="1">
    <tr>
        <td>Api Key</td>
        <td id='api_key'>
            <button id='get_zemanta_api_key'>Get Zemanta API Key</button>
        </td>
    </tr>
    <tr>
        <td>Text</td>
        <td>
            <input type='text' size='30' id='zemanta_keyword' />
        </td>
    </tr>
    <tr>
        <td colspan="2" id='zemanta_suggestions'>
            <button id='get_zemanta_suggestions'>Get Zemanta Suggestions</button>
            <div id="zemanta_articles"></div>
        </td>
    </tr>
    </table>
</div>

<div id="footer">
    <div class="container">
        <p class="text-muted credit">Romack Natividad 2014</p>
    </div>
</div>

<script src="assets/js/jquery.1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script>
$(document).ready(function($){
    $('#get_zemanta_api_key').click(function(){
        $.ajax({
            data: {
                keyword: 'zemanta.auth.create_user'
            },
            dataType: 'jsonp',
            url: 'http://api.zemanta.com/services/rest/0.0/',
            method: 'POST',
            success: function(response){
                console.log(response);
            },
            error: function(e){
                console.log(e);
            }
        });
    });
    $('#get_zemanta_suggestions').click(function(){
        console.log('Fetching Articles');
        $.ajax({
            data: {
                keyword: $('#zemanta_keyword').val(),
                format: 'json'
            },
            url: 'http://pelek.dev/zemanta_fetch_suggestions.php',
            method: 'POST',
            success: function(response){

                console.log(response);
                articles = '<table>';
                $.each(response.articles, function(key, val){
                    $.each(val, function(k, v){
                        articles = articles + '<tr>';
                        articles = articles + '<td>' + k + '</td>';
                        articles = articles + '<td>' + v + '</td>';
                        articles = articles + '</tr>';
                    });
                });
                articles = articles + '</table>';
                console.log(articles);
                $('#zemanta_articles').html(articles);
            },
            error: function(e){
                console.log(e);
            }
        });
    });
});
</script>



</body>

</html>

