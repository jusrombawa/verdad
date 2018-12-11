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
                        text += "<tr>";
                        //title
                        text += "<td><a class='hidden_id' name='" + articleList[i][8] + "'>" + articleList[i][0] + "</a></td>";
                        //author
                        text += "<td class='author'>" + articleList[i][1] + "</td>";
                        //date published
                        text += "<td>" + articleList[i][2] + "</td>";
                        //publisher
                        text += "<td>" + articleList[i][3] + "</td>";
                        //rating
                        //check for not enough ratings (null for now)
                        if(articleList[i][4] == null)
                            text += "<td>No ratings</td>"
                        else
                            text += "<td>" + articleList[i][4] + "</td>";
                        //check if satire and/or opinion
                        if(articleList[i][5] && articleList[i][6]) text += "<td>Satire & Opinion</td>";
                        else if(articleList[i][5] && !articleList[i][6]) text += "<td>Satire</td>";
                        else if(!articleList[i][5] && articleList[i][6]) text += "<td>Opinion</td>";
                        else text += "<td>No</td>";

                        //url
                        text += "<td><a href='" + articleList[i][7] + "'>Link</a></td>";

                        //row closing tag
                        text += "</tr>";
                    }

                    //write to table
                    $("#article_table").html(text);

                },

                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }

            });
    });

    //read specific article
    $(document).on("click",".hidden_id",function(){
        //alert("hello");
        var articleID = $(this).attr("name");

        $.ajax({
            type: 'GET',
            url: '/article',
            data: articleID,

            success: function() {
                alert("great success!");
            },

            error: function() {
                
            }


        });
    });
});