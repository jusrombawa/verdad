$(document).ready(function(){
    //initialize materialize components
    $('.modal').modal();
    $('select').formSelect();
    $('.collapsible').collapsible();
    $('.datepicker').datepicker();

    //hide initially hidden components
    $("#articles_sect").hide();

    /*function setTabParams(name, value1, value2){
            value1 = encodeURIComponent(value1);
            value2 = encodeURIComponent(value2);
            var newUrl = name + "/" + value1 + "/" + value2;
            window.history.pushState(,"",newUrl)
    }*/

    //start reading articles
    $("#read_button").click(function(){
        //hide extra stuff
        $("#intro_sect").hide(1000, function() {
            $("#read_button").hide(1000);
            $("#title_header").hide(1000);
            $("#subtitle_header").hide(1000);
            $("#articles_sect").show(2000);
        });

        //request to get articles
        $.ajax({
                type: 'GET',
                url: '/getArticles',

                success: function(data) {
                    var articleList = $.parseJSON(data);
                    var text = "";
                    for (var i=0; i<articleList.length; i++)
                    {
                        //hidden form for id
                       /* text +=
                        '<form action="/article"><input class="hidden_id_form" id="' + articleList[i][8] '" type="hidden" name="id" value="' + articleList[i][8] + '"</form>';*/
                        //row opening tag
                        text += "<li>";
                        text += "<div class='collapsible-header article-listing'>"


                        //title
                        text += articleList[i][0];
                        text += "<br/>";
                        //author
                        text += articleList[i][1];
                        text += "<br/>";
                        //date published
                        text += articleList[i][2];
                        text += "<br/>";
                        //publisher
                        text += articleList[i][3];
                        text += "<br/>";

                        //rating
                        //check for not enough ratings (null for now)
                        if(articleList[i][4] == null)
                            text += "No ratings"
                        else
                            text += "" + articleList[i][4] + "";
                        text += "<br/>";
                        //check if satire and/or opinion
                        if(articleList[i][5] && articleList[i][6]) text += "Satire & Opinion";
                        else if(articleList[i][5] && !articleList[i][6]) text += "Satire";
                        else if(!articleList[i][5] && articleList[i][6]) text += "Opinion";
                        else text += "Not satire or opinion";
                        text += "</div>"

                        /*text += "<div class='collapsible-body'>Text goes here.";
                        text += "</div>";
*/
                        text += "<div class='collapsible-body '><iframe class='article-frame' height='600' ></iframe></div>";

                        //src=" + articleList[i][7] + "

                        text += "<div class='collapsible-body'>Body goes here but this is supposed to be review.</div>"
                        text += "</li>";
                    }

                    //write to table
                    $("#article_list").html(text);

                },

                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }

            });
    });

    //read specific article
    /*$(document).on("click",".hidden_id",function(){
        //alert("hello");
        var articleID = $(this).attr("name");

        //alert(articleID);

        $.ajax({
            type: 'GET',
            url: '/article',
            data: articleID,

            success: function(data) {
                articleBody = $.parseJSON(data);
                //alert(articleBody[1]);
            },

            error: function() {
                
            }


        });*/

/*
    //resize frame when article listing is clicked
    $(document).on("click",".article-listing",function(){
        var collapsiblewidth = $(".article-listing").width()-50; //50 pixels is just approximate, might not be right for bigger screens
        $(".article-frame").width(collapsiblewidth); 
    });

    //resize frame on window resize
    $(window).resize(function(){
       var collapsiblewidth = $(".article-listing").width()-50;
        $(".article-frame").width(collapsiblewidth); 
    });*/
});