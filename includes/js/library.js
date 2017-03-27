
	function confirmM(heading, question, id) {
	$('.modal').modal('hide');
		cancelButtonTxt = "Cancel";
		okButtonTxt = "Yes";
		var html = "<div class='modal fade' id='"+id+"'>";
			html += "<div class='modal-dialog'>";
				html += "<div class='modal-content'>";
					html += "<div class='modal-header'>";
						html += "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>";
						html += "<h4 class='modal-title'>"+heading+"</h4>";
					html += "</div>";
					html += "<div class='modal-body'>";
						html += "<p>"+question+"</p>";
					html += "</div>";
					html += "<div class='modal-footer'>";
						html += "<a href='javascript:;' class='btn btn-primary' data-dismiss='modal'>Close</a>";
						html += "<a href='#!' id='okButton' class='btn btn-primary'>"+okButtonTxt+"</a>";
					html += "</div>";
				html += "</div>";
			html += "</div>";
		html += "</div>";
		$(html).modal('show');     
	  };
	
	function modalView(id, heading, dialog_msg){
		$('.modal').modal('hide');
		var html = "<div class='modal fade' id='"+id+"'>";
			html += "<div class='modal-dialog'>";
				html += "<div class='modal-content'>";
					html += "<div class='modal-header'>";
						html += "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>";
						html += "<h4 class='modal-title'>"+heading+"</h4>";
					html += "</div>";
					html += "<div class='modal-body'>";
						html += "<p>"+dialog_msg+"</p>";
					html += "</div>";
					html += "<div class='modal-footer'>";
						html += "<a href='javascript:;'' class='btn-sm btn-primary' data-dismiss='modal'>Close</a>";
					html += "</div>";
				html += "</div>";
			html += "</div>";
		html += "</div>";
		
		$(html).modal('show', {show: true, backdrop: 'static', keyboard: false});
	}