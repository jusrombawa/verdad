$(document).ready(function(){
    //initialize materialize components
    $('.modal').modal();
    $('select').formSelect();
    $('.collapsible').collapsible();
    $('.sidenav').sidenav();
    $('.fixed-action-btn').floatingActionButton();
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();

    //hide initially hidden components
    $("#articles_sect").hide();
    $("#login-area").hide();
    $("#art-submit-modal-button").hide();

    //notify about login status
    var info = $("#info").text().trim();

    if(info != '')
        M.toast({html:"<span>" + info + "</span>"});
    //clear info after prompt
    info = "";
    $("#info").text("");

    //then clear info from session if it's there
    $.ajax({
        type:"GET",
        url: "/clearInfo",
        error: function(jqXHR, exception)
        {
            alert(jqXHR.responseText);
        }

    });

    //check if mobile user
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
        var isMobile = true;
    else
        var isMobile = false

    //check if logged in, automatically show article list
    if($("#loggedInUser").text().trim() != '')
    {
        if(isMobile == false)
        {
            $("#intro_sect").hide( function() {
                $("#read_button").hide();
                $("#title_header").hide();
                $("#subtitle_header").hide();
                $("#articles_sect").show();
                $("#art-submit-modal-button").show();
            });

            getArticles();
        }
        else
        {
            $("#intro_sect").hide( function() {
                $("#read_button").hide();
                $("#title_header").hide();
                $("#subtitle_header").hide();
                $("#articles_sect").show();
                $("#art-submit-modal-button").show();
               
                $("#article_frame").hide();
                //change column size for article collapsible section
                $("#art-collapsible-sect").removeClass("s5");
                $("#art-collapsible-sect").addClass("s12");
            });
            getArticles();
        }

        //check report count if reviewer
        if($("#reviewerStatus").text() == 1)
        {
            $.ajax({
                type: "GET",
                url: "/getReportCount",
                success: function(data){
                    if(data == 0)
                        $(".report-count").hide();
                    else
                        $(".report-count").text(data)
                },
                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }
            });
        }
    }


    //start reading articles
    $("#read_button").click(function(){
        //hide extra stuff
        if(isMobile == false)
        {
            $("#intro_sect").hide(1000, function() {
                $("#read_button").hide(1000);
                $("#title_header").hide(1000);
                $("#subtitle_header").hide(1000);
                $("#articles_sect").show(2000);
                $("#art-submit-modal-button").show(2000);
            });
    
            getArticles();
        }
        else
        {
            $("#intro_sect").hide(1000, function() {
                $("#read_button").hide(1000);
                $("#title_header").hide(1000);
                $("#subtitle_header").hide(1000);
                $("#articles_sect").show(2000);
                $("#art-submit-modal-button").show(2000);
                $("#article_frame").hide();
                //change column size for article collapsible section
                $("#art-collapsible-sect").removeClass("s5");
                $("#art-collapsible-sect").addClass("s12");
            });
    
            getArticles();
        }
    });

    var articleListLength;
    var pageSize = 7;
    var pages;

    function getArticles(){
        //request to get articles
        $.ajax({
                type: 'GET',
                url: '/getArticles',

                success: function(data) {
                    var articleList = $.parseJSON(data);
                    var text = "";
                    if(isMobile)
                        $("#article_list").removeClass("popout");

                    for (var i=0; i<articleList.length; i++)
                    {         
                        //row opening tag
                        text += "<li class='article-item'>";
                        text += "<div class='collapsible-header'>"


                        //title
                        text += articleList[i][0] + "<br/>";

                        //rating
                        //check for not enough ratings (null for now)
                        if(articleList[i][4] == null)
                            text += "No reviews yet <br/>"
                        else
                            text += "Average score: " + articleList[i][4] + "<br/>";
                        text += "</div>"

                        //src=" + articleList[i][7] + "
                        text += "<div class='collapsible-body'>";

                        //check if satire and/or opinion

                        if(isMobile){
                            text += "<a href='"+ articleList[i][7] +"' target='_blank' rel='noopener noreferrer'>Read article</a><br/><br/>";
                        }
                        else
                            text += "<a class='article-button waves-effect waves-light btn-small blue darken-3' href='"+ articleList[i][7] +"' target='article_frame'><i class='material-icons'>link</i> Read article</a><br/><br/>";

                        //date published
                        artdate = new Date(articleList[i][2]);
                        text += "Date published: " + artdate.toDateString() + "<br/>";
    
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

                        text += "<br/><br/>"
                        
                        //add button to allow review submission
                        if($("#reviewerStatus").text() == 1)
                            text += "<a id='review"+articleList[i][9]+"' class='btn waves-effect waves-light blue darken-3 submit-review'><i class='material-icons'>rate_review</i> Write a review</a>"
                    
                        //check if there are reviews

                        if(articleList[i][8].length > 0){
                        //display reviews
                            text += "<br/><br/><div class='row divider'></div>"
                            text += "<div class='row'> <h6>Reviews:</h6> </div>";
                            for(var k=0; k < articleList[i][8].length; k++) //loop through 4D array!!!
                            {
                                text += "<div class='row divider'></div>"
                                text += "<div class='row'>"
                                //score
                                text += "Rating: " + articleList[i][8][k][0]+" stars<br/>";
                                //link to reviewer's profile
                                text += "Review written by: <a id="+articleList[i][8][k][4]+" class='user-profile'>" + articleList[i][8][k][4] + "</a>";
                                //comments
                                text += "<p><i>" + articleList[i][8][k][1] +"</i></p>";
                                //check if satire or not
                                if(articleList[i][8][k][2] == true)
                                    text += "Satire <br/>";
                                //check if opinion or not
                                if(articleList[i][8][k][3] == true)
                                    text += "Opinion <br/>";
                                //add in report button
                                if($("#loggedInUser").text().trim() != articleList[i][8][k][4] && $("#reviewerStatus").text() == 1)
                                {
                                    text += '<a id="report' + articleList[i][8][k][5] + '"class="report-button waves-effect waves-blue blue darken-3 btn"><i class="material-icons">report</i> Report</a><br/><br/>'
                                }
                                //end of row
                                text += "<div class='row divider'></div>"
                                text +="</div>";
                            }
                        }                        

                        text += "</div>";
                        text += "</li>";
                    }

                    //add pagination
                    articleListLength = articleList.length

                    pages = Math.ceil(articleListLength/pageSize);

                    text += '<br/><div class="container">';

                    text += '<ul id="art-pagination" class="pagination">'
                    text += '<li id="prev-page" class="page-num waves-effect"><a href="#!"><i class="material-icons">chevron_left</i></a></li>'

                    for(var i=1; i<= pages; i++){
                        if(i==1)
                            text += '<li id="page-'+ i +'" class="page-num waves-effect active blue darken-3"><a href="#!">'+ i +'</a></li>';
                        else
                            text += '<li id="page-'+ i +'"class="page-num waves-effect"><a href="#!">'+ i +'</a></li>'
                    }
                    text += '<li id="next-page" class="page-num waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>'
                    text += '</ul>'
                    text += '</div>'
                            

                    //write to table
                    $("#article_list").html(text);

                    if($("#reviewerStatus").text() != 1)
                    {
                        
                    }
                    


                    showPage(1);   
                },

                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }

            });
    }


    //determine page number
    var pageNumber = 1; //default

    $(document).on("click",".page-num", function(){
        var selPage = $(this).text();

        //remove currently active
        $("#art-pagination li").removeClass("active blue darken-3");
        //add to active class to this instance
        

        if(selPage == 'chevron_left' && pageNumber > 1) {
            --pageNumber;
            $("#page-" + pageNumber).addClass("active blue darken-3");
        }
        else if (selPage == 'chevron_right' && pageNumber < pages){
            pageNumber++;
            $("#page-" + pageNumber).addClass("active blue darken-3");
        }
        else if (Number.isInteger(parseInt(selPage))){
            $(this).addClass("active blue darken-3");
            pageNumber = parseInt(selPage);
        }

        showPage(pageNumber);
    });

    showPage = function(page) {
        $(".article-item").hide();
        $(".article-item").each(function(n) {
            if (n >= pageSize * (page - 1) && n < pageSize * page)
                $(this).show();
        });        
    }


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
                    window.location.assign("/");
                },

                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }
            });
        }

        else if (username == '')
            alert("Username field cannot be empty.");

        else if (password == '')
            alert("Password field cannot be empty.");


        e.preventDefault(); // avoid to execute the actual submit of the form.

    });

    $("#loginPasswordDesktop").keypress(function(e){
        if (e.which == 13)
        {
            //login if enter is pressed
            var username = $("#loginUsernameDesktop").val().trim();
            var password = $("#loginPasswordDesktop").val().trim();
            
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
                        window.location.assign("/");
                    },

                    error: function(jqXHR, exception)
                    {
                        alert(jqXHR.responseText);
                    }
                });
            }

            else if (username == '')
                alert("Username field cannot be empty.");

            else if (password == '')
                alert("Password field cannot be empty.");


            e.preventDefault(); // avoid to execute the actual submit of the form.
        }
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
                    window.location.assign("/");
                },

                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }
            });
        }

        else if (username == '')
            alert("Username field cannot be empty.");

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
                window.location.assign("/");
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
        var templink = document.createElement("a");
        templink.href = $("#articleURL").val().trim();

        var hostURL = templink.protocol + "//" + templink.hostname + "/";

        if($("#articleURL").val().trim() == '')
            alert("Please input article URL.")
        else if($("#articleTitle").val().trim() == '')
            alert("Please input the article's title or click on Suggest Title.")
        else if($("#articleAuthor").val().trim() == '')
            alert("Please input the article's author.")
        else if($("#articlePublisher").val().trim() == '')
            alert("Please input the article's publisher.")
        else if($("#articlePubDate").val().trim() == '')
            alert("Please input the article's publish date.")
        else if($("#articlePubTime").val().trim() == '')
            alert("Please input the article's publish time.")
        else{
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
                    window.location.reload();
                },

                error: function(jqXHR, exception)
                {
                    alert("Error submiting article.");
                    alert(jqXHR.responseText);
                }
            });
        }


    });

    //suggest titles for article submission
    $(document).on("click","#suggest-title", function(){
        //found out about textance on https://stackoverflow.com/questions/7901760/how-can-i-get-the-title-of-a-webpage-given-the-url-an-external-url-using-jquer
        //more info at http://textance.herokuapp.com/index.html
        //and by more info I mean some description text and some other misc utils

        var articleURL = $("#articleURL").val().trim();
        var apiURL = "http://textance.herokuapp.com/title/" + articleURL; //append article url to textance url

        $.ajax({
          url: apiURL,
          complete: function(data) {
            var suggestedTitle = data.responseText;
            $("#articleTitle").val(suggestedTitle);
          }
        });

    });

    $("#suggest-publisher").click(function(){
        var templink = document.createElement("a");
        templink.href = $("#articleURL").val().trim();
        
        var hostURL = templink.protocol + "//" + templink.hostname + "/";

        //alert(hostURL)

        if($("#articleURL").val().trim() != '')
        {
            $.ajax({
                type:"GET",
                data: {
                    "hostURL": hostURL
                },
                url: "/suggestPublisher",
                success: function(data){
                    if(data == false)
                        alert("Publisher not found. Please manually input the article's publisher")
                    else
                        $("#articlePublisher").val(data);
                },
                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }
            });
        }

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
            var reviewSatire = 1;
        else
            var reviewSatire = 0;

        //check if opinion
        if($("#review-opinion").is(":checked"))
            var reviewOpinion = 1;
        else
            var reviewOpinion = 0;

        //simple input sanitation
        if(reviewRating == null)
            alert("Please input a rating.");
        else if (reviewComments == '')
            alert("Please include comments on your review.")
        else if (reviewRating == null & reviewComments == '')
            alert("Please provide a rating and comments.")
        else
        {
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
                   window.location.reload();
                },

                error: function(jqXHR, exception)
                {
                    alert("Error submiting review.");
                    alert(jqXHR.responseText);
                }
            });
        }

    });

    $("#register-submit").click(function(){
        var regUsername = $("#regUsername").val().trim();
        var regPassword = $("#regPassword").val().trim();
        var regVerifyPassword = $("#regVerifyPassword").val().trim();
        var regEmail = $("#regEmail").val().trim();
        var regFirstName = $("#regFirstName").val().trim();
        var regMiddleName = $("#regMiddleName").val().trim();
        var regLastName = $("#regLastName").val().trim();
        var regNameSuffix = $("#regNameSuffix").val().trim();

        if($("#regTerms").is(":checked"))
            var regTerms = true;
        else
            var regTerms = false;

        var testreg = regUsername + "\n" + regPassword + "\n" + regEmail + "\n" + regFirstName + "\n" + regMiddleName + "\n" + regLastName + "\n" + regNameSuffix + "\n" + regTerms + "\n";

        var emailPattern = new RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$"); //thanks to https://www.regextester.com/19 I don't have to figure this crap out
        var suffixPattern = new RegExp("(Sr.|Jr.|^M{0,3}(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$)"); //thanks to this https://stackoverflow.com/questions/267399/how-do-you-match-only-valid-roman-numerals-with-a-regular-expression I just added Jr. and Sr. to the mix
        var emailMatch = emailPattern.test(regEmail);
        var suffixMatch = suffixPattern.test(regNameSuffix);

        if(regUsername == '')
            alert("Please input your username.");
        else if(regPassword == '')
            alert("Please input your password.");
        else if(regVerifyPassword == '')
            alert("Please verify your password.");
        else if(regPassword != regVerifyPassword)
            alert("Please verify that your password matches.");
        else if(regEmail == '')
            alert("Please input your email address.");
        else if(!emailMatch)
            alert("Please input a valid email address.");
        else if(regFirstName == '')
            alert("Please input your first name.");
        /*else if(regMiddleName == '')
            alert("Please input your middle name.");*/
        else if(regLastName == '')
            alert("Please input your last name.");
        else if(!suffixMatch && regNameSuffix != '')
            alert("Please input a valid name suffix.");
        else if(regTerms == false)
            alert("Please make sure that you've read Verdad's terms and conditions.");
        else
        {
            $.ajax({
                type:"POST",
                url:"/registerUser",
                data: {
                    "regUsername": regUsername,
                    "regPassword": regPassword,
                    "regEmail": regEmail,
                    "regFirstName": regFirstName,
                    "regMiddleName": regMiddleName,
                    "regLastName": regLastName,
                    "regNameSuffix": regNameSuffix
                },

                success: function(data)
                {
                    if(data == 1 || data == true)
                    {
                        window.location.assign("/verifyPage");
                    }
                    else
                        alert(data);
                },

                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }
            });
        }
    });

    //toggle password visibility
    $("#passToggle").click(function(){
        if($("#regPassword").attr('type') === 'password')
        {
            $("#regPassword").attr("type","text");
            $("#passToggle").removeClass("grey-text");
            $("#passToggle").addClass("blue-text text-darken-3 blue lighten-5");
        }
        else
        {
            $("#regPassword").attr("type","password");
            $("#passToggle").removeClass("blue-text text-darken-3 blue lighten-5");
            $("#passToggle").addClass("grey-text");
        }
    });

    $("#verifyToggle").click(function(){
        if($("#regVerifyPassword").attr('type') === 'password')
        {
            $("#regVerifyPassword").attr("type","text");
            $("#verifyToggle").removeClass("grey-text");
            $("#verifyToggle").addClass("blue-text text-darken-3 blue lighten-5");
        }
        else
        {
            $("#regVerifyPassword").attr("type","password");
            $("#verifyToggle").removeClass("blue-text text-darken-3 blue lighten-5");
            $("#verifyToggle").addClass("grey-text");
        }
    });

    $("#verify-submit").click(function(){

        var verificationCode = $("#verificationCode").val().trim();

        //check length of string
        if(verificationCode.length != 6)
            alert("Please check your verification code and try submitting again.")
        else{

            $.ajax({
                type: "POST",
                data: {
                    "verificationCode":verificationCode
                },
                url: "/verifyUser",
                success: function(data)
                {
                    if(data == true)
                    {
                        window.location.assign("/");
                    }
                    else
                        alert(data);
                },
                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }

            });
        }

    });

    $("#faq").click(function(){

    });

    $(document).on("click", ".user-profile", function(){
//    $(".user-profile").click(function(){

        var username = $(this).attr("id");

        $.ajax({
            type: "GET",
            data: {
                "profileUsername": username
            },
            url: "/userProfile",
            success: function(){
                window.location.assign("/profilePage");
            },
            error: function(jqXHR, exception)
            {
                alert(jqXHR.responseText);
            }
        });
    });

    $("#change-pic-submit").click(function(){

        var form = $("#change-pic-form")[0];
        var data = new FormData(form);

        var fileVal=document.getElementById("profileUpload");
        alert(fileVal.value);

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "/uploadPhoto",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function(data){
                window.location.reload();
            },
            error: function(jqXHR, exception)
            {
                alert(jqXHR.responseText);
            }


        });
    });

    affiliationcounter = 0;

    $("#add-affiliation").click(function(){

        text = '<div class="row">';

            text += '<div class="col s6">';
                text += '<input id="position'+affiliationcounter+'" name="position'+affiliationcounter+'" class="revRegPosition" type="text"> ';
                text += '<label for="position'+affiliationcounter+'">Position</label>'
            text += '</div>';

            text += '<div class="col s6">';
                text += '<input id="organization'+affiliationcounter+'" name="organization'+affiliationcounter+'" class="revRegOrganization" type="text"> ';
                text += '<label for="organization'+affiliationcounter+'">Organization</label>'
            text += '</div>';
        text += '</div>';

        text += '<div class="row">';
            text += '<div class="col s12"><h6 class="blue-text text-darken-3">Scanned copy/photograph of organization ID</h6>';
            text += '<input type="file" name="orgIDupload'+affiliationcounter+'" id="orgIDupload" class="orgIDupload"></div>'
        text += '</div>';


        $("#affiliationInputs").append(text);
        affiliationcounter++;
    });

    $("#revRegSubmit").click(function(){
        /*var positions = $(".regRevPosition").map(function(){ return $(this).val().trim()}).get(); //get values from regRevPosition class then put into array
        var organizations = $(".regRevOrganization").map(function(){ return $(this).val().trim()}).get();*/

        //check affiliations
        countedPosition = 0;
        countedOrganization = 0;
        $(".revRegPosition").each(function(i){
            if($(this).val().trim() != '')
                countedPosition++;
        });
        //check organizations
        $(".revRegOrganization").each(function(i){
            if($(this).val().trim() != '')
                countedOrganization++;
        });

        if($("#revRegPhone").val().trim() == '')
            alert("Please input your phone number.")
        else if(affiliationcounter == 0)
            alert("Please click on Add Affiliation to add an affiliation.")
        else if(countedPosition < affiliationcounter)
            alert("Please fill out all position fields.")
        else if(countedOrganization < affiliationcounter)
            alert("Please fill out all organization fields.")
        else
        {
            var form = $("#revRegForm")[0];
            if(form.length > 0)
            {
                var data = new FormData(form);
                $.each(form.files, function(k,file){
                    data.append('form[]', file);
                });
                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "/registerReviewer",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(data){
                        if(data == true)
                            window.location.assign("/revSignupPending");
                        else
                            alert(data);
                    },
                    error: function(jqXHR, exception)
                    {
                        alert(jqXHR.responseText);
                    }


                });
            }
        }

    });

    $(document).on("click", ".report-button", function(){
        var reportID = $(this).attr("id")
        reportID = reportID.substr(6);
        reportUser = $("#loggedInUser").text().trim()

        //change value of hidden input fields
        $("#reportedReviewID").val(reportID);
        $("#reportSubmitterUsername").val(reportUser);

        
        var instance = M.Modal.getInstance($("#report-submit-modal"));
        instance.open();
    });

    $("#submit-report").click(function(){

        //get hidden values
        var reportedReviewID = $("#reportedReviewID").val()
        var reportSubmitterUsername = $("#reportSubmitterUsername").val()

        //get value of reasons as an array of booleans
        var reasons = [];

        $(".report-reason").each(function(i){
            if ($(this).is(":checked")) reasons[i] = true
            else reasons[i] = false
        });

        //get comments
        var reportComments = $("#report-comments").val().trim();

        //input validation
        //check every value of reasons if false
        var noReasons = reasons.every(function(reason){
            return reason == false;
        })
        
        if(noReasons) //all false, no reasons indicated
            alert("Please check at least one reason for the report.")
        else if(reportComments == '')
            alert("Please include comments regarding your report.")
        else
        {
            //alert(reportedReviewID + " " + reportSubmitterUsername + " " + reasons + " " + reportComments)

            $.ajax({
                type:"POST",
                data:{
                    "reportedReviewID": reportedReviewID,
                    "reportSubmitterUsername": reportSubmitterUsername,
                    "reasons": reasons,
                    "reportComments": reportComments
                },
                url: "/reportReview",
                success: function(data){
                    alert(data)
                },
                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }
            });
        }
    });


});