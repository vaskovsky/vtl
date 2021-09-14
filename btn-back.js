/*! Copyright © 2021 Alexey Vaskovsky. Released under the MIT license */
document.addEventListener("DOMContentLoaded", event =>
{
	const btnBackList = document.querySelectorAll("#btn-back, .btn-back");
	for(let btnBack of btnBackList)
	{
		btnBack.addEventListener("click", event =>
		{
			event.preventDefault();
			history.back();
		});
	}
});
