$(document).ready(function(){
    //initialize materialize components
    $('.modal').modal();
    $('select').formSelect();
    $('.collapsible').collapsible();
    $('.datepicker').datepicker();
    $('.sidenav').sidenav();

    //hide initially hidden components
    $("#articles_sect").hide();
    $("#login-area").hide();

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
                       
                        //row opening tag
                        text += "<li>";
                        text += "<div class='collapsible-header article-listing'>"


                        //title
                        text += articleList[i][0];
                        text += "<br/>";
                        //date published
                        text += articleList[i][2];
                        text += "<br/>";

                        //rating
                        //check for not enough ratings (null for now)
                        if(articleList[i][4] == null)
                            text += "No ratings"
                        else
                            text += "Average score: " + articleList[i][4] + "";
                        text += "<br/><br/>";


                        text += "<a class='waves-effect waves-light btn blue article-button' href='"+ articleList[i][7] +"' target='article_frame'>Read article</a>";
                        text += "</div>"

                        //src=" + articleList[i][7] + "
                        text += "<div class='collapsible-body'>";

                        //check if satire and/or opinion
                        text += "<div class='row'>";
    
                            //author
                            text += "Written by: " + articleList[i][1];
                            text += "<br/>";
                            
                            //publisher
                            text += "Published by: " + articleList[i][3];
                            text += "<br/>";

                            if(articleList[i][5] && articleList[i][6]) text += "Satire & Opinion";
                            else if(articleList[i][5] && !articleList[i][6]) text += "Satire";
                            else if(!articleList[i][5] && articleList[i][6]) text += "Opinion";
                            else text += "Not satire or opinion";
                        
                        text += "</div>";
                        //check if there are reviews
                        text += "<div class='row divider'></div>"
                        text += "<div class='row'> <h6>Reviews:</h6> </div>";

                        if(articleList[i][8].length == 0){ //no reviews to be shown
                            text += "<div class='row'><p>No reviews yet</p>";
                        }

                        else{
                        //display reviews
                            for(var k=0; k < articleList[i][8].length; k++) //loop through 4D array!!!
                            {
                                text += "<div class='row divider'></div>"
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

                    //resize article_frame
                    var frameheight = $("#articles_sect").height();
                    $("#article_frame").height(frameheight);       
                },

                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }

            });
    });

    //pop up login for desktop
    $("#login-popup").click(function(){
        $("#login-area").slideToggle("slow");

    });

    //login form submit for desktop

    //$(document).on("click","#loginButtonDesktop").click(function(e){
    $("#loginButtonDesktop").click(function(e){
        var username = $("#loginUsernameDesktop").val().trim();
        var password = $("#loginPasswordDesktop").val().trim();

        //alert("Logging in as " + username + " with password " + password); //THIS IS FOR TEST PURPOSE ONLY OH MY GOD I SWEAR IF YOU FORGET TO REMOVE THIS

        //check if non-empty login
        if(username != '' && password != '')
        {
            $.ajax({
                type:"POST",
                url:"/login",
                data: {
                    "username": username,
                    "password": password
                },

                success: function(data)
                {
                    window.location.reload();
                },

                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }
            });
        }

        else if (username == '')
            alert("E-mail field cannot be empty.");

        else if (password == '')
            alert("Password field cannot be empty.");


        e.preventDefault(); // avoid to execute the actual submit of the form.

    });

    //resize article frame on window resize
    $(window).resize(function(){

        var frameheight = $("#articles_sect").height();
        $("#article_frame").height(frameheight);       
        
    });

    //push href from article buttons to frame
    $(document).on("click",".article-button",function(e){

        e.preventDefault();
        $("#article_frame").attr("src", $(this).attr("href"));
        
    });

    $(document).on("click", "#logoutDesktop", function(){

        $.ajax({
            type: 'POST',
            url: '/logout',
            success: function(data) {
                window.location.reload();
            },

            error: function(jqXHR, exception)
            {
                alert("Error logging out.");
                alert(jqXHR.responseText);
            }

        });
    });

});