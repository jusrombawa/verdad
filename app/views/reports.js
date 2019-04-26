$(document).ready(function(){	

	//get reports
	$.ajax({
		type:"GET",
		url: "/getReports",
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

	$(document).on("click", ".confirm-report", function(){
		confirmID = $(this).attr("id");
		confirmID = confirmID.substr(7);
		//alert(confirmID)

		$.ajax({
			type: 'POST',
			data: {
				"confirmID": confirmID
			},
			url: "/confirmReport",
			success: function(data){
				window.location.reload();
			},
			error: function(jqXHR, exception)
	        {
	            alert(jqXHR.responseText);
	        }
		});
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
			url: "/denyReport",
			success: function(){
				window.location.reload();
			},
			error: function(jqXHR, exception)
	        {
	            alert(jqXHR.responseText);
	        }
		});
	});
});