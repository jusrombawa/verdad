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
                //alert(data);

                list = $.parseJSON(data);
                text = "";

                text += '<div class="row"><div class="col s12"><h4 class="blue-text text-darken-3">Pending reviewer requests</h4></div></div>'

                if(list.length == 0)
                    text += '<div class="row"><div class="col s12"><p>There are no pending reviewers right now.</p></div></div>'
                else
                {

                    text += '<div class="row"><div class="col s12">'
                    text += '<ul class="collapsible">'
                        for(var i=0; i<list.length; i++)
                        {
                            text += '<li>'
                                text += '<div class="collapsible-header">'
                                    text += '<h6 class="blue-text text-darken-3">' + list[i][2] + ', ' +  list[i][3] + ' ' + list[i][5] + ' ' +  list[i][4] + '</h6>'
                                text += '</div>'

                                text += "<div class='collapsible-body'>"
                                    text += "Username: " + list[i][1] + '<br/>'
                                    reqdate = new Date(list[i][6]);
                                    text += "Request date: " + reqdate.toDateString() + '<br/>';
                                    text += "<h6>Profile picture: </h6>"
                                    text += '<img class="materialboxed" src="' + list[i][7] + '" height="300"/>'
                                    text += '<br/>Email address: <a href="mailto:'+ list[i][8] +'">' + list[i][8] + '</a><br/>'
                                    text += 'Phone number: '
                                    if(list[i][9] != '')
                                        text += '(' + list[i][9] + ') '
                                    text += list[i][10] + '<br/><br/>'
                                    text += "<div class='row divider'></div>"
                                    text += '<h6 class="blue-text text-darken-3">Affiliations:</h6>'
                                    text += '<ul class="collapsible">'
                                    for(var j=0; j<list[i][11].length; j++)
                                    {
                                        text += '<li>'
                                            text += '<div class="collapsible-header"> Occupation: ' + list[i][11][j][0] + '</div>';
                                            text += '<div class="collapsible-body">Organization: ' + list[i][11][j][2] + '<br/>'
                                            text += 'Organization ID: <br/><img class="materialboxed" src="' + list[i][11][j][3] + '" height="240" />'
                                            text += "<div class='row divider'></div>"
                                        text += '</li>'
                                    }
                                    text += '</ul>'
                                
                                    text += '<a id="approve' + list[i][0] + '" class="waves-effect waves-light btn blue darken-3 approve-reviewer"><i class="material-icons left">check</i>Approve</a><br/> <br/>'
                                    text += '<a id="inquire' + list[i][0] + '" class="waves-effect waves-light btn lime darken-2 inquire-reviewer"><i class="material-icons left">email</i>Send inquiry</a><br/> <br/>'
                                    text += '<a id="deny' + list[i][0] + '" class="waves-effect waves-light btn orange darken-3 deny-reviewer"><i class="material-icons left">clear</i>deny</a>'

                                text += '</div>'
                            text += '</li>'

                        }
                    text += '</ul></div></div>'
                }

                $("#admin_sect").html(text);
                $('.collapsible').collapsible();
                $('.materialboxed').materialbox();
            },
            error: function(jqXHR, exception)
            {
                alert(jqXHR.responseText);
            }

        });
    }

    $(document).on("click", ".approve-reviewer", function(){
        var approveID = $(this).attr('id');
        approveID = approveID.substr(7);

        //alert(approveID);
        
        $.ajax({
            type: "POST",
            data: {
                "approveID": approveID
            },
            url: "/approveRegistration",
            success: function(data){
                window.location.reload();
            },
            error: function(jqXHR, exception)
            {
                alert(jqXHR.responseText);
            }
        });
    });

    $(document).on("click", ".inquire-reviewer", function(){
        var inquireID = $(this).attr('id');
        inquireID = inquireID.substr(7);
        $("#inquire-pr-id").val(inquireID);

        var inquireInstance = M.Modal.getInstance($("#inquiry-modal"));
        inquireInstance.open();
        //alert(inquireID);
    });

    $(document).on("click", "#inquiry-send", function(){
        var inquireID = $("#inquire-pr-id").val();
        var inquireText = $("#inquire-text").val();

        //alert(inquireID + " " + inquireText)

        if(inquireText != '')
        {
            $.ajax({
                type:"POST",
                data: {
                    "inquireID": inquireID,
                    "inquireText": inquireText
                },
                url: "/sendInquiry",
                success: function(data){
                    if(data == true)
                        alert("Inquiry sent successfully");
                    else{
                        alert("Inquiry not sent: \n\n" + data);
                    }
                },
                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }

            });
        }
        else
            alert("Can't send empty inquiry");

    });

    $(document).on("click", ".deny-reviewer", function(){
        var denyID = $(this).attr("id");
        denyID = denyID.substr(4);

        $("#deny-pr-id").val(denyID);
        var inquireInstance = M.Modal.getInstance($("#deny-modal"));
        inquireInstance.open();
    });

    $(document).on("click", "#deny-rev-submit", function(){
        var denyID = $("#deny-pr-id").val();
        var denyText = $("#deny-text").val();

        if(denyText != '')
        {
            $.ajax({
                type:"POST",
                data: {
                    "denyID": denyID,
                    "denyText": denyText
                },
                url: "/denyRegistration",
                success: function(data){
                    window.location.reload()
                },
                error: function(jqXHR, exception)
                {
                    alert(jqXHR.responseText);
                }

            });
        }
        else
            alert("Reason cannot be empty");
    });


});