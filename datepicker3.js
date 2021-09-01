/*! Copyright © 2015-2021 Alexey Vaskovsky. Released under the MIT license */
$(function()
{
	if(undefined === $.fn.datepicker)
	{
		console.error("Bootstrap Datepicker not found.");
		return;
	}
	if(undefined === $.fn.datepicker.defaults)
	{
		console.error("Invalid version of Bootstrap Datepicker.");
		return;
	}
	$.fn.datepicker.defaults.language = "en";
	$.fn.datepicker.defaults.format = "yyyy-mm-dd";
	$.fn.datepicker.defaults.clearBtn = true;
	$.fn.datepicker.defaults.autoclose = true;
	$.fn.datepicker.defaults.todayHighlight = true;
	if(/^ru\b/.test(navigator.language) && !/\/en\//.test(location.pathname))
	{
		if(undefined === $.fn.datepicker.dates.ru)
			console.error("Russian locale for Bootstrap Datepicker not found.");
		else
		{
			$.fn.datepicker.defaults.language = "ru";
			$.fn.datepicker.dates.ru.format ="yyyy-mm-dd";
		}
	}	
	$(".date").datepicker();
});
