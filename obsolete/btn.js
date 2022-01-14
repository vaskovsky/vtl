/*! Copyright © 2015-2022 Alexey Vaskovsky. Released under the MIT license */
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
	const btnPrintList = document.querySelectorAll("#btn-print, .btn-print");
	for(let btnPrint of btnPrintList)
	{
		btnPrint.addEventListener("click", event =>
		{
			event.preventDefault();
			window.print();
		});
	}
	const btnReloadList = document.querySelectorAll("#btn-reload, .btn-reload");
	for(let btnReload of btnReloadList)
	{
		btnReload.addEventListener("click", event =>
		{
			event.preventDefault();
			location.reload();
		});
	}
});
