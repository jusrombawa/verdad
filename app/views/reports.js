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
							text += 'Report #' + (i+1)
						text += '</div>'

						text += '<div class="collapsible-body">'
							
							text += '<h5 class="blue-text text-darken-2">Article details</h5> <br/>'
							text += '<a target="_blank" "rel="noopener noreferrer" href="' + reportList[i][1] + '">' + reportList[i][0] + '</a><br/>'
							text += 'Average rating: ' + reportList[i][2] + '<br/>'
							//check if satire or opinion
							if(reportList[i][3])
								text += 'Satirical article<br/>'
							if(reportList[i][4])
								text += 'Opinion article<br/>'

							text += '<br/><div class="row divider"></div>'

							text += '<h5 class="blue-text text-darken-2">Review details</h5> <br/>'
							text += 'Review rating: ' + reportList[i][5] + '<br/>'
							text += 'Review written by: ' + reportList[i][6] + '<br/>'
							text += 'Review comments: <i>'  + reportList[i][7] + '</i><br/>'
							//check if satire or opinion
							if(reportList[i][8])
								text += 'Satirical article<br/>'
							if(reportList[i][9])
								text += 'Opinion article<br/>'

							text += '<br/><div class="row divider"></div>'

							text += '<h5 class="blue-text text-darken-2">Report details</h5><br/>'
							text += 'Report submitted by: ' + reportList[i][10]
							text += 'Reasons for reporting: <br/>'
							//check reasons
							text += '<ul>'
								if(reportList[i][11][0])
									text += '<li><span>Erroneous/inaccurate review</span></li>'
								if(reportList[i][11][1])
									text += '<li><span>Review lacks information/sources</span></li>'
								if(reportList[i][11][2])
									text += '<li><span>Possible conflict of interest</span></li>'
								if(reportList[i][11][3])
									text += '<li><span>Unprofessional language</span></li>'
								if(reportList[i][11][4])
									text += '<li><span>Mistaken as satire/opinion</span></li>'
								if(reportList[i][11][5])
									text += '<li><span>Article is actually satire/opinion</span></li>'
								if(reportList[i][11][6])
									text += '<li><span>Hateful remarks in review (racism, sexism, violent threat)</span></li>'
								if(reportList[i][11][7])
									text += '<li><span>Others</span></li>'
							text += '</ul><br/>'
							text += 'Report comments: <i>' + reportList[i][12] + '</i>'
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
});