$(document).ready(function(){
    //initialize materialize components
    $('.modal').modal();
    $('select').formSelect();
    $('.collapsible').collapsible();
    $('.datepicker').datepicker();
    $('.sidenav').sidenav();

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
                    //alert(data); //used to check if sent JSON is correct
                    var articleList = $.parseJSON(data);
                    var text = "";
                    for (var i=0; i<articleList.length; i++)
                    {
                       
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

                        //might slow things down since this loads all urls, fix later, but for now, disable
                        text += "<div class='collapsible-body '><iframe class='article-frame' height='600' src='"+articleList[i][7]+"''></iframe></div>";
                        //text += "<div class='collapsible-body '><iframe class='article-frame' height='600' ></iframe></div>";

                        //src=" + articleList[i][7] + "
                        text += "<div class='collapsible-body'>";

                        if(articleList[i][8].length == 0){ //no reviews to be shown
                            text += "<div class='row'><p>No reviews yet</p>";
                        }

                        else{
                        //display reviews
                            for(var k=0; k < articleList[i][8].length; k++) //loop through 4D array!!!
                            {
                                text += "<div class='row'>"
                                //score
                                text += "Rating: " + articleList[i][8][k][0]+" stars<br/>";
                                //comments
                                text += "<p><i>" + articleList[i][8][k][1] +"</i></p>";
                                //check if satire or not
                                if(articleList[i][8][k][2] == false)
                                    text += "Not satire <br/>";
                                else
                                    text += "Satire <br/>";
                                //check if opinion or not
                                if(articleList[i][8][k][2] == false)
                                    text += "Not opinion <br/>"
                                else
                                    text += "Opinion <br/>";

                                //end of row
                                text +="</div>";
                            }
                        }                        
                        


                        text += "</div>";
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


    //resize frame when article listing is clicked
    $(document).on("click",".article-listing",function(){
        var collapsiblewidth = $(".article-listing").width()-50; //50 pixels is just approximate, might not be right for bigger screens
        $(".article-frame").width(collapsiblewidth); 
    });

    //resize frame on window resize
    $(window).resize(function(){
       var collapsiblewidth = $(".article-listing").width()-50;
        $(".article-frame").width(collapsiblewidth); 
    });
});