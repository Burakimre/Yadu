function check(tag) {
	fetch_customer_data(tag);
}

function fetch_customer_data(query) {
	$.ajax({
		url: "{{ route('events_controller.action')}}",
		method: 'POST',
		data: {
			query: query,
			_token: '{{ csrf_token() }}'
		},
		dataType: 'json',
		success: function (data) {
			console.log(data);
			if (data == "") {
				$('#box2').html("<h5><i>Kies eerst het type event</i></h5>");
			} else {
				$('#box2').html("");
				data.forEach(function (element) {
					//TODO: add if statement if element tag equals tag in given event add "checked"
					$('#box2').html($("#box2").html() + "<input type='radio' id='" +
						element['id'] + 
						"' class='picture " + element['tag_id'] +
						"' name='picture' value='" + 
						element['id'] + 
						"'> <label for='" +
						element['id'] + 
						"' class='picture " + element['tag_id'] +
						"' title='Uitje met gezinnen'> <img class='default' src='data:image/jpeg;base64," +
						element['picture'] + "'/> </label>");
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			console.log('jqXHR:');
			console.log(jqXHR);
			console.log('textStatus:');
			console.log(textStatus);
			console.log('errorThrown:');
			console.log(errorThrown);
		}

	})
}