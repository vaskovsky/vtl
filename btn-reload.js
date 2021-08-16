/*! Copyright © 2015-2021 Alexey Vaskovsky. Released under the MIT license */
document.addEventListener("DOMContentLoaded", event =>
{
	const btnReloadList = document.getElementsByClassName("btn-reload");
	for(let btnReload of btnReloadList)
	{
		btnReload.addEventListener("click", event =>
		{
			event.preventDefault();
			location.reload();
		});
	}
});
