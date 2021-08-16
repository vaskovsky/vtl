/*! Copyright © 2015-2021 Alexey Vaskovsky. Released under the MIT license */
document.addEventListener("DOMContentLoaded", event =>
{
	const btnPrintList = document.getElementsByClassName("btn-print");
	for(let btnPrint of btnPrintList)
	{
		btnPrint.addEventListener("click", event =>
		{
			event.preventDefault();
			window.print();
		});
	}
});
