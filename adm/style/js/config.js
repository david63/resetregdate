$( function() {
	$('#reset_reg_date').datetimepicker({
		dateFormat: 'dd-mm-yy',
		timeFormat: 'HH:mm',
		stepMinute: 1,
		maxDateTime: new Date(),
		isRTL: isRTL
	});

	$('#reset_lv_date').datetimepicker({
		dateFormat: 'dd-mm-yy',
		timeFormat: 'HH:mm',
		stepMinute: 1,
		maxDateTime: new Date(),
		isRTL: isRTL
	});

	$.datepicker.regional['phpbb'] = {
		closeText: closeText,
		prevText: prevText,
		nextText: nextText,
		currentText: currentTextDate,
		monthNames: JSON.parse(monthNames),
		dayNamesMin: JSON.parse(dayNamesMin)
	};

	$.datepicker.setDefaults($.datepicker.regional['phpbb']);

	$.timepicker.regional['phpbb'] = {
		timeText: timeText,
		hourText: hourText,
		minuteText: minuteText,
		currentText: currentTextTime,
		closeText: closeText,
		timezone: timezone
	};

	$.timepicker.setDefaults($.timepicker.regional['phpbb']);
});
