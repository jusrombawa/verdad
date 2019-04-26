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
    //then clear info from session if it's there
    $.ajax({
        type:"GET",
        url: "/clearInfo",
        error: function(jqXHR, exception)
        {
            alert(jqXHR.responseText);
        }

    });

    //check if logged in, automatically show article list
    if($("#loggedInAdmin").text().trim() != '')
    {
        getPendingReviewers();
        getReports();
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

    function getReports()
    {
        $.ajax({
            type:"GET",
            url: "/adminGetReports",
            success:function(data)
            {
                var reportList = $.parseJSON(data);

                if(reportList.length > 0)
                {
                    text = '';
                    for(var i = 0; i < reportList.length; i++)
                    {
                        text += '<li class="report-item">';
                            text += '<div class="collapsible-header">'
                                text += 'Report #' + reportList[i][13]
                            text += '</div>'

                            text += '<div class="collapsible-body">'
                                
                                text += '<h5 class="blue-text text-darken-2">Article details</h5> <br/>'
                                text += '<a target="_blank" "rel="noopener noreferrer" href="' + reportList[i][1] + '">' + reportList[i][0] + '</a><br/>'
                                text += 'Average rating: ' + reportList[i][2] + '/5<br/>'
                                //check if satire or opinion
                                if(reportList[i][3])
                                    text += 'Satirical article<br/>'
                                if(reportList[i][4])
                                    text += 'Opinion article<br/>'

                                text += '<br/><div class="row divider"></div>'

                                text += '<h5 class="blue-text text-darken-2">Review details</h5> <br/>'
                                text += 'Review rating: ' + reportList[i][5] + '/5<br/>'
                                text += 'Review written by: ' + reportList[i][6] + '<br/>'
                                text += 'Review comments: <i>'  + reportList[i][7] + '</i><br/>'
                                //check if satire or opinion
                                if(reportList[i][8])
                                    text += 'Satirical article<br/>'
                                if(reportList[i][9])
                                    text += 'Opinion article<br/>'

                                text += '<br/><div class="row divider"></div>'

                                text += '<h5 class="blue-text text-darken-2">Report details</h5><br/>'
                                text += 'Report submitted by: ' + reportList[i][10] + '<br/>'
                                text += 'Reasons for reporting: <br/>'
                                //check reasons
                                text += '<i><ol>'
                                    if(reportList[i][11][0] == "true")
                                        text += '<li><span>Erroneous/inaccurate review</span></li>'
                                    if(reportList[i][11][1]  == "true")
                                        text += '<li><span>Review lacks information/sources</span></li>'
                                    if(reportList[i][11][2] == "true")
                                        text += '<li><span>Possible conflict of interest</span></li>'
                                    if(reportList[i][11][3] == "true")
                                        text += '<li><span>Unprofessional language</span></li>'
                                    if(reportList[i][11][4] == "true")
                                        text += '<li><span>Mistaken as satire/opinion</span></li>'
                                    if(reportList[i][11][5] == "true")
                                        text += '<li><span>Article is actually satire/opinion</span></li>'
                                    if(reportList[i][11][6] == "true")
                                        text += '<li><span>Hateful remarks in review (racism, sexism, violent threat)</span></li>'
                                    if(reportList[i][11][7] == "true")
                                        text += '<li><span>Others</span></li>'
                                text += '</ol></i>'
                                text += 'Report comments: <i>' + reportList[i][12] + '</i><br/><br/>'

                                text += '<a id="confirm'+reportList[i][13]+'"class="confirm-report waves-effect waves-light btn blue darken-2"><i class="material-icons left">check</i>confirm report</a><br/><br/>'
                                text += '<a id="deny'+reportList[i][13]+'"class="deny-report waves-effect waves-light btn orange darken-3"><i class="material-icons left">clear</i>deny report</a>'

                            text += '</div>'
                        text += '</li>';
                    }

                
                    $("#report-list").html(text);
                }
                else
                    $("#report-sect").html("There are no pending reports as of the moment.");
                //alert(data);
            },
            error: function(jqXHR, exception)
            {
                alert(jqXHR.responseText);
            }
        });
    }

    function getPendingReviewers()
    {
        $.ajax({
            type:"GET",
            url:"/getPendingReviewers",
            success: function(data){
                //alert(data);

                list = $.parseJSON(data);
                text = "";

                text += '<div class="row"><div class="col s12"><h4 class="blue-text text-darken-2">Pending reviewer requests</h4></div></div>'

                if(list.length == 0)
                    text += '<div class="row"><div class="col s12"><p>There are no pending reviewers as of the moment.</p></div></div>'
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

                                    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
                                    {
                                        text += '<img class="materialboxed" src="' + list[i][7] + '" width="240"/>'
                                    }
                                    else
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
                                            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ){
                                                text += 'Organization ID: <br/><img class="materialboxed" src="' + list[i][11][j][3] + '" width="200" />'
                                            }
                                            else
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

    $(document).on("click", ".deny-report", function(){
        denyID = $(this).attr("id");
        denyID = denyID.substr(4);
        //alert(denyID)

        $.ajax({
            type: 'POST',
            data: {
                "denyID": denyID
            },
            url: "/adminDenyReport",
            success: function(data){
                window.location.reload();
            },
            error: function(jqXHR, exception)
            {
                alert(jqXHR.responseText);
            }
        });
    });

    $(document).on("click", ".confirm-report", function(){
        confirmID = $(this).attr("id");
        confirmID = confirmID.substr(7);

        $.ajax({
            type: 'POST',
            data: {
                "confirmID": confirmID
            },
            url: "/adminConfirmReport",
            success: function(data){
                window.location.reload();
            },
            error: function(jqXHR, exception)
            {
                alert(jqXHR.responseText);
            }
        });
    });

});