$(document).ready(function(){
    //initialize materialize components
    $('.modal').modal();
    $('select').formSelect();
    $('.collapsible').collapsible();
    $('.datepicker').datepicker();
    $('.sidenav').sidenav();
    $('.fixed-action-btn').floatingActionButton();
    $('.timepicker').timepicker();

    //hide initially hidden components
    $("#articles_sect").hide();
    $("#login-area").hide();
    $("#art-submit-modal-button").hide();

    //notify about login status
    var info = $("#info").text().trim();

    if(info != '')
        M.toast({html:"<span>" + info + "</span>"});

    //start reading articles
    $("#read_button").click(function(){
        //hide extra stuff
        $("#intro_sect").hide(1000, function() {
            $("#read_button").hide(1000);
            $("#title_header").hide(1000);
            $("#subtitle_header").hide(1000);
            $("#articles_sect").show(2000);
            $("#art-submit-modal-button").show(2000);
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
                        
                        //add button to allow review submission
                        text += "<check if='{{ @SESSION.reviewerStatus == true}}'>";
                        text += "<a id='review"+articleList[i][9]+"' class='btn waves-effect waves-light blue submit-review'>Write a review <i class='material-icons'>rate_review</i></a>"
                        text += "</check>";

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

    $("#loginButtonMobile").click(function(e){
        var username = $("#loginUsernameMobile").val().trim();
        var password = $("#loginPasswordMobile").val().trim();

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


    $(document).on("click", "#logoutMobile", function(){

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

    $(document).on("click", "#art-submit-button", function(){

        //alert("submitting article");

        //get website host

        var templink = document.createElement("a");
        templink.href = $("#articleURL").val().trim();

        var hostURL = templink.protocol + templink.hostname;

        //alert(hostURL);

        $.ajax({
            type: 'POST',
            url: 'submit-article',
            data: {
                "articleURL": $("#articleURL").val().trim(),
                "articleTitle": $("#articleTitle").val().trim(),
                "articleAuthor": $("#articleAuthor").val().trim(),
                "articlePublisher": $("#articlePublisher").val().trim(),
                "articlePubDate": $("#articlePubDate").val().trim(),
                "articlePubTime": $("#articlePubTime").val().trim(),
                "hostURL": hostURL
            },
            success: function(data)
            {
                //alert("Hello there.")
                //I should probably find a way to reload just the article list
                window.location.reload();
            },

            error: function(jqXHR, exception)
            {
                alert("Error submiting article.");
                alert(jqXHR.responseText);
            }
        });

    });

    //suggest titles for article submission
    $(document).on("click","#suggest-title", function(){
        
        //found out about textance on https://stackoverflow.com/questions/7901760/how-can-i-get-the-title-of-a-webpage-given-the-url-an-external-url-using-jquer
        //more info at http://textance.herokuapp.com/index.html
        //and by more info I mean some description text and some other misc utils

       /* alert("suggesting title");*/

        var articleURL = $("#articleURL").val().trim();
        var apiURL = "http://textance.herokuapp.com/title/" + articleURL; //append article url to textance url

        $.ajax({
          url: apiURL,
          complete: function(data) {
            //alert(data.responseText);
            var suggestedTitle = data.responseText;
            $("#articleTitle").val(suggestedTitle);
          }
        });

    });

    $(document).on("click", ".submit-review", function(){

        var artinput = $(this).attr('id');
        var artID = artinput.substr(6);

        $("#article-review-id").text(artID);

        var instance = M.Modal.getInstance($("#review-submit-modal"));
        instance.open();
    });

    $(document).on("click", "#review-submit-button", function(){

        var reviewRating = $("#review-rating").val();
        var reviewArtID = parseInt($("#article-review-id").text());
        var reviewUser = $("#loggedInUser").text();
        var reviewComments = $("#review-comments").val();
        
        //check if satire
        if($("#review-satire").is(":checked"))
            var reviewSatire = true;
        else
            var reviewSatire = false;

        //check if opinion
        if($("#review-opinion").is(":checked"))
            var reviewOpinion = true;
        else
            var reviewOpinion = false;

        //simple input sanitation
        if(reviewRating == null)
            alert("Please input a rating.");
        else if (reviewComments == '')
            alert("Please include comments on your review.")
        else if (reviewRating == null & reviewComments == '')
            alert("Please provide a rating and comments.")
        else
        {
            //alert(reviewComments);
            $.ajax({
                type:"POST",
                url: "/submitReview",
                data:{
                    'articleID': reviewArtID,
                    'reviewerUsername': reviewUser,
                    'score': reviewRating,
                    'comments': reviewComments,
                    'satire': reviewSatire,
                    'opinion': reviewOpinion
                },

                success: function(data)
                {
                   //window.location.reload();
                   alert("this should be ID for: " + reviewUser)
                   alert($.parseJSON(data));
                },

                error: function(jqXHR, exception)
                {
                    alert("Error submiting review.");
                    alert(jqXHR.responseText);
                }
                });
        }

    });

});