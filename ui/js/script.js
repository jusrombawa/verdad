$(document).ready(function(){
	$.ajax({
		type: 'POST',
		url: 'setEmployees',
		dataType: 'json',
		data: 
		success: function(result){
			for(var i=0; i<result.length; i++){
				var emp = result[i];
				$('#personnel-container>.row').append(
					'<div class="col s4"><div class="card small"><div class="card-image"><img src="ui/img/temp.jpg"></div><div class="card-stacked"><div class="card-content">'+emp[0]+'<br>'+emp[1]+'<br>'+emp[2]+'</div></div></div></div>'
				);
			}
		}
	});
});