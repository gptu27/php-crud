$(document).ready(function(){
	
	$('#edit').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget);
	  var id = button.data('id');
	  var fullname = button.data('fullname');
	  var phone = button.data('phone');
	  var email = button.data('email');
	  var place = button.data('place');
	  var modal = $(this);
	  modal.find('input[name="id"]').val(id);
	  modal.find('input[name="fullname"]').val(fullname);
	  modal.find('input[name="phone"]').val(phone);
	  modal.find('input[name="email"]').val(email);
	  modal.find('input[name="place"]').val(place);
	});

	$('#delete').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget);
	  var id = button.data('idfordelete');
	  var fullname = button.data('fullname');
	  var modal = $(this);
	  modal.find('input[name="idfordelete"]').val(id);
	  modal.find('#abonentName').text(fullname);
	});
    
});
