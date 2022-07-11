$(document).ready(function()
{
	$(".form_submit_ays").on('submit',function(event)
	{
		if(confirm("Are you sure?"))
		{
			//delete
		}
		else
		{
			//prevent delete
			event.preventDefault();
		}	
	});
});