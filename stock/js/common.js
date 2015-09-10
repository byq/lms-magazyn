function modalwindow(module, width, height, reload) {
//	var src = 'https://admin2.mojasiec.com/?m=' + module + '&popup=1';
	var src = '?m=' + module + '&popup=1';
	$.modal('<iframe src="' + src + '" style="border:0; width: ' + width + 'px; height: ' + height + 'px;">', {
		opacity: 60,
		containerCss:{
			padding: 3
		},
		onClose: function (dialog) {
			$.modal.close();
			if (reload) {
				location.reload(true);
			}
		}
	});
}

function modalclose() {
	parent.$.modal.close();
}

function pad(id) {
	$('#pid').val(id);
}

function pinv(id, net, gross) {
	pad(id);
	if (gross > 0) {
		$('input[name="valuebrutto"]').val(gross);
	} else {
		$('input[name="valuenetto"]').val(net);
	}
}

$(document).ready(function() {
	var i = 0;
	var count = 0;

	$('#pcount').change(function() {
		count = $('#pcount').val();
		$('#pserial').text(' ');
		for (i = 1; i <= count; i++) {
			$("#pserial").append('<INPUT type="text" name="receivenote[product][serial][]" SIZE="40"><br />');
		}
	});

	$('#packaging_check').change(function() {
		if ($(this).is(':checked')) {
			$('#packaging_count').attr('disabled', false);
			$('#packaging_unit').attr('disabled', false);
		} else {
			$('#packaging_count').val('');
			$('#packaging_count').attr('disabled', true);
			$('#packaging_unit').attr('disabled', true);
		}
	});

});
