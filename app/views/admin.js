$(document).ready(function(){
    //initialize materialize components
    $('.modal').modal();
    $('select').formSelect();
    $('.collapsible').collapsible();
    $('.sidenav').sidenav();
//  $('.fixed-action-btn').floatingActionButton();
    $('.materialboxed').materialbox();

    $("#login-area").hide();

    //notify about login status
    var info = $("#info").text().trim();

    if(info != '')
        M.toast({html:"<span>" + info + "</span>"});
    //clear info after prompt
    info = "";
    $("#info").text("");

    //check if logged in, automatically show article list
    if($("#loggedInAdmin").text().trim() != '')
    {
        getPendingReviewers();
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
                url:"/adminLogin",
                data: {
                    "username": username,
                    "password": password
                },

                success: function(data)
                {
                    window.location.assign("/admin");
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

    $("#loginButtonMobile").click(function(e){
        var username = $("#loginUsernameMobile").val().trim();
        var password = $("#loginPasswordMobile").val().trim();

        //alert("Logging in as " + username + " with password " + password); //THIS IS FOR TEST PURPOSE ONLY OH MY GOD I SWEAR IF YOU FORGET TO REMOVE THIS

        //check if non-empty login
        if(username != '' && password != '')
        {
            $.ajax({
                type:"POST",
                url:"/adminLogin",
                data: {
                    "username": username,
                    "password": password
                },

                success: function(data)
                {
                    window.location.assign("/admin");
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

    $(document).on("click", "#logoutDesktop", function(){
        $.ajax({
            type: 'POST',
            url: '/adminLogout',
            success: function(data) {
                window.location.assign("/admin");
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
            url: '/adminLogout',
            success: function(data) {
                window.location.assign("/admin");
            },

            error: function(jqXHR, exception)
            {
                alert("Error logging out.");
                alert(jqXHR.responseText);
            }

        });
    });

    function getPendingReviewers()
    {
        $.ajax({
            type:"GET",
            url:"/getPendingReviewers",
            success: function(data){
                alert(data);
            },
            error: function(jqXHR, exception)
            {
                alert(jqXHR.responseText);
            }

        });
    }


});