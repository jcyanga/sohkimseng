var domain ="http://"+document.domain;

$('#changePassword').hide();

// Role Create //
$('._showCreateRoleModal').click(function(){

	$('#modal-launcher-create-role').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');

});

$('#submitRoleFormCreate').click(function(){
	var name = $('#name').val();

	if( !onlyLetter(name) ) {
		alert('Invalid name format.');
		name.focus();
	}

	$.post("?r=role/create",{
		name : name,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#name').val('');	
		    $('#modal-launcher-create').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'Role[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'Role[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewRole').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-role').modal('hide');
    	e.preventDefault();
    }
});

// Role Update //
if( $('._showUpdateRoleModal').length ){

$('._showUpdateRoleModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-role').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=role/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#roleFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#roleFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
			}

		});
	});
});

}

$('#submitRoleFormUpdate').click(function(){
	var id = $('#id').val();
	var name = $('#updateName').val();

	if( !onlyLetter(name) ) {
		alert('Invalid name format.');
		name.focus();
	}

	$.post("?r=role/update",{
		id : id,
		name : name,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#id').val('');
		    $('#updateName').val('');	
		    $('#modal-launcher-update-role').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#roleFormUpdate').find('input[name="' + 'Role[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#roleFormUpdate').find('input[name="'+ 'Role[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateRole').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-role').modal('hide');
    	e.preventDefault();
    }
});

// Role Delete //
$('.roleDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=role/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Role View //
if( $('._showViewRoleModal').length ){

$('._showViewRoleModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-role').modal({       
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=role/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>ROLE NAME</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewRole').html(html);
			}

		});
	});
});

}

$('.closeViewRole').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-role').modal('hide');
    	e.preventDefault();
    }
});

// Role Forms Clear //
$('#clearRoleForms').click(function(){

	$('#roleFormCreate').find('input:text[id=name]').val('');
	$('#roleFormUpdate').find('input:text[id=updateName]').val('');

});

// Role View Close //
$('#closeRoleForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-role').modal('hide');
    	e.preventDefault();
    }
});

// Customer Create //
$('#forCompany').hide();
$('#forIndividual').hide();

$('#customerType').change(function(){

	if($(this).val() == 0){
		$('#forCompany').hide('fast');
		$('#forIndividual').hide('fast');

	}else if($(this).val() == 1){
		$('#forIndividual').hide('fast');
		$('#forCompany').show('fast');

	}else{
		$('#forCompany').hide('fast');
		$('#forIndividual').show('fast');

	}

});

$('._showCreateCustomerModal').click(function(){

	$('#modal-launcher-create-customer').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,

        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#companyName').val('');	
    $('#companyAddress').val('');
    $('#companyShippingAddress').val('');
    $('#companyUenNo').val('');
    $('#companyContactPerson').val('');
    $('#companyEmail').val('');
    $('#companyPhoneNumber').val('');
    $('#companyOfficeNumber').val('');
    $('#companyFaxNumber').val('');

	$('#fullname').val('');	
    $('#customerAddress').val('');
    $('#customerShippingAddress').val('');
    $('#customerRace').val('');
    $('#customerNric').val('');
    $('#customerEmail').val('');
    $('#customerPhoneNumber').val('');	
    $('#customerOficeNumber').val('');
    $('#customerFaxNumber').val('');
});

$('#submitCustomerFormCreate').click(function(){
	var type = $('#customerType').val();
	
	if(type == 0){
		alert('Invalid customer type selected.');
		type.focus();
		return false;
	}

	if(type == 1){

		var companyName = $('#companyName').val();
		var companyAddress = $('#companyAddress').val();
		var companyShippingAddress = $('#companyShippingAddress').val();
		var companyUenNo = $('#companyUenNo').val();
		var companyContactPerson = $('#companyContactPerson').val();
		var companyEmail = $('#companyEmail').val();
		var companyPhoneNumber = $('#companyPhoneNumber').val();
		var companyOfficeNumber = $('#companyOfficeNumber').val();
		var companyFaxNumber = $('#companyFaxNumber').val();

		if( !onlyLetterAndNumber(companyName) ) {
			alert('Invalid company name format.');
			companyName.focus();
		}

		if( !onlyLetterAndNumber(companyAddress) ) {
			alert('Invalid company address format.');
			companyAddress.focus();
		}

		if( !onlyLetterAndNumber(companyShippingAddress) ) {
			alert('Invalid company shipping address format.');
			companyShippingAddress.focus();
		}

		if( !onlyLetterAndNumber(companyUenNo) ) {
			alert('Invalid company uen number format.');
			companyUenNo.focus();
		}

		if( !onlyForEmail(companyEmail) ) {
			alert('Invalid company email format.');
			companyEmail.focus();
		}

		if( !onlyNumber(companyPhoneNumber) ) {
			alert('Invalid company phone number format.');
			companyPhoneNumber.focus();
		}

		if( !onlyNumber(companyOfficeNumber) ) {
			alert('Invalid company office number format.');
			companyOfficeNumber.focus();
		}

		$.post("?r=customer/create-company",{
			companyName : companyName,
			companyAddress : companyAddress,
			companyShippingAddress : companyShippingAddress,
			companyUenNo : companyUenNo,
			companyContactPerson : companyContactPerson,
			companyEmail : companyEmail,
			companyPhoneNumber : companyPhoneNumber,
			companyOfficeNumber : companyOfficeNumber,
			companyFaxNumber : companyFaxNumber

		}, 
		function(data) {
			var data = jQuery.parseJSON(data);
			if( data.status == 'Success') {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

			    $('#companyName').val('');	
			    $('#companyAddress').val('');
			    $('#companyShippingAddress').val('');
			    $('#companyUenNo').val('');
			    $('#companyContactPerson').val('');
			    $('#companyEmail').val('');
			    $('#companyPhoneNumber').val('');
			    $('#companyOfficeNumber').val('');
			    $('#companyFaxNumber').val('');
			    $('#modal-launcher-create-customer').toggle('fast');

				alert(data.message);
				window.location.reload();

			} else {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
		            $('input[name="' + 'Customer[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('textarea[name="' + 'Customer[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('input[name="'+ 'Customer[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}else{

		var fullname = $('#fullname').val();
		var customerAddress = $('#customerAddress').val();
		var customerShippingAddress = $('#customerShippingAddress').val();
		var customerRace = $('#customerRace').val();
		var customerNric = $('#customerNric').val();
		var customerEmail = $('#customerEmail').val();
		var customerPhoneNumber = $('#customerPhoneNumber').val();
		var customerOficeNumber = $('#customerOficeNumber').val();
		var customerFaxNumber = $('#customerFaxNumber').val();

		if( !onlyLetterAndNumber(fullname) ) {
			alert('Invalid customer name format.');
			fullname.focus();
		}

		if( !onlyLetterAndNumber(customerAddress) ) {
			alert('Invalid customer address format.');
			customerAddress.focus();
		}

		if( !onlyLetterAndNumber(customerShippingAddress) ) {
			alert('Invalid customer shipping address format.');
			customerShippingAddress.focus();
		}

		if( !onlyLetterAndNumber(customerNric) ) {
			alert('Invalid customer nric number format.');
			customerNric.focus();
		}

		if( !onlyForEmail(customerEmail) ) {
			alert('Invalid customer email format.');
			customerEmail.focus();
		}

		if( !onlyNumber(customerPhoneNumber) ) {
			alert('Invalid customer phone number format.');
			customerPhoneNumber.focus();
		}

		if( !onlyNumber(customerOficeNumber) ) {
			alert('Invalid customer office number format.');
			customerOficeNumber.focus();
		}

		$.post("?r=customer/create-customer",{
			fullname : fullname,
			customerAddress : customerAddress,
			customerShippingAddress : customerShippingAddress,
			customerRace : customerRace,
			customerNric : customerNric,
			customerEmail : customerEmail,
			customerPhoneNumber : customerPhoneNumber,
			customerOficeNumber : customerOficeNumber,
			customerFaxNumber : customerFaxNumber

		}, 
		function(data) {
			var data = jQuery.parseJSON(data);
			if( data.status == 'Success') {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

			    $('#fullname').val('');	
			    $('#customerAddress').val('');
			    $('#customerShippingAddress').val('');
			    $('#customerRace').val('');
			    $('#customerNric').val('');
			    $('#customerEmail').val('');
			    $('#customerPhoneNumber').val('');	
			    $('#customerOficeNumber').val('');
			    $('#customerFaxNumber').val('');
			    $('#modal-launcher-create-customer').toggle('fast');

				alert(data.message);
				window.location.reload();

			} else {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
		            $('input[name="' + 'Customer[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('textarea[name="' + 'Customer[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('input[name="'+ 'Customer[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}
	
});

$('.closeNewCustomer').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-customer').modal('hide');
    	e.preventDefault();
    }
});

// Customer Update //
$('#forUpdateCompany').hide();
$('#forUpdateIndividual').hide();

if( $('._showUpdateCustomerModal').length ){

$('._showUpdateCustomerModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-customer').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=customer/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				
				if(result.type == 1){

					$('#forUpdateCompany').show();
					$('#customerFormUpdate').find('input:hidden[name=id]').val(result.id);
					$('#customerFormUpdate').find('select[id=updateCustomerType]').val(1).change();
					$('#customerFormUpdate').find('input:text[id=updateCompanyName]').val(result.company_name.toUpperCase());
					$('#customerFormUpdate').find('textarea[id=updateCompanyAddress]').val(result.address.toUpperCase());
					$('#customerFormUpdate').find('textarea[id=updateCompanyShippingAddress]').val(result.shipping_address.toUpperCase());
					$('#customerFormUpdate').find('input:text[id=updateCompanyUenNo]').val(result.uen_no.toUpperCase());
					$('#customerFormUpdate').find('input:text[id=updateCompanyContactPerson]').val(result.fullname.toUpperCase());
					$('#customerFormUpdate').find('input:text[id=updateCompanyEmail]').val(result.email.toUpperCase());
					$('#customerFormUpdate').find('input:text[id=updateCompanyPhoneNumber]').val(result.phone_number);
					$('#customerFormUpdate').find('input:text[id=updateCompanyOfficeNumber]').val(result.mobile_number);
					$('#customerFormUpdate').find('input:text[id=updateCompanyFaxNumber]').val(result.fax_number);

				}else{

					$('#forUpdateIndividual').show();
					$('#customerFormUpdate').find('input:hidden[name=id]').val(result.id);
					$('#customerFormUpdate').find('select[id=updateCustomerType]').val(2).change();
					$('#customerFormUpdate').find('input:text[id=updateFullname]').val(result.fullname.toUpperCase());
					$('#customerFormUpdate').find('textarea[id=updateCustomerAddress]').val(result.address.toUpperCase());
					$('#customerFormUpdate').find('textarea[id=updateCustomerShippingAddress]').val(result.shipping_address.toUpperCase());
					$('#customerFormUpdate').find('select[id=updateCustomerRace]').val(result.race_id).change();
					$('#customerFormUpdate').find('input:text[id=updateCustomerNric]').val(result.nric.toUpperCase());
					$('#customerFormUpdate').find('input:text[id=updateCustomerEmail]').val(result.email.toUpperCase());
					$('#customerFormUpdate').find('input:text[id=updateCustomerPhoneNumber]').val(result.phone_number);
					$('#customerFormUpdate').find('input:text[id=updateCustomerOficeNumber]').val(result.mobile_number);
					$('#customerFormUpdate').find('input:text[id=updateCustomerFaxNumber]').val(result.fax_number);

				}
			
			}

		});
	});
});

}

$('#updateCustomerType').change(function(){

	if($(this).val() == 0){
		$('#forUpdateCompany').hide('fast');
		$('#forUpdateIndividual').hide('fast');

	}else if($(this).val() == 1){
		$('#forUpdateIndividual').hide('fast');
		$('#forUpdateCompany').show('fast');

	}else{
		$('#forUpdateCompany').hide('fast');
		$('#forUpdateIndividual').show('fast');

	}

});

$('#submitCustomerFormUpdate').click(function(){
	var type = $('#updateCustomerType').val();
	
	if(type == 0){
		alert('Invalid customer type selected.');
		type.focus();
		return false;
	}

	if(type == 1){

		var id = $('#id').val();
		var companyName = $('#updateCompanyName').val();
		var companyAddress = $('#updateCompanyAddress').val();
		var companyShippingAddress = $('#updateCompanyShippingAddress').val();
		var companyUenNo = $('#updateCompanyUenNo').val();
		var companyContactPerson = $('#updateCompanyContactPerson').val();
		var companyEmail = $('#updateCompanyEmail').val();
		var companyPhoneNumber = $('#updateCompanyPhoneNumber').val();
		var companyOfficeNumber = $('#updateCompanyOfficeNumber').val();
		var companyFaxNumber = $('#updateCompanyFaxNumber').val();

		if( !onlyLetterAndNumber(companyName) ) {
			alert('Invalid company name format.');
			companyName.focus();
		}

		if( !onlyLetterAndNumber(companyAddress) ) {
			alert('Invalid company address format.');
			companyAddress.focus();
		}

		if( !onlyLetterAndNumber(companyShippingAddress) ) {
			alert('Invalid company shipping address format.');
			companyShippingAddress.focus();
		}

		if( !onlyLetterAndNumber(companyUenNo) ) {
			alert('Invalid company uen number format.');
			companyUenNo.focus();
		}

		if( !onlyForEmail(companyEmail) ) {
			alert('Invalid company email format.');
			companyEmail.focus();
		}

		if( !onlyNumber(companyPhoneNumber) ) {
			alert('Invalid company phone number format.');
			companyPhoneNumber.focus();
		}

		if( !onlyNumber(companyOfficeNumber) ) {
			alert('Invalid company office number format.');
			companyOfficeNumber.focus();
		}

		$.post("?r=customer/update-company",{
			id : id,
			companyName : companyName,
			companyAddress : companyAddress,
			companyShippingAddress : companyShippingAddress,
			companyUenNo : companyUenNo,
			companyContactPerson : companyContactPerson,
			companyEmail : companyEmail,
			companyPhoneNumber : companyPhoneNumber,
			companyOfficeNumber : companyOfficeNumber,
			companyFaxNumber : companyFaxNumber

		}, 
		function(data) {
			var data = jQuery.parseJSON(data);
			if( data.status == 'Success') {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

			    $('#id').val('');
				$('#updateCompanyName').val('');
				$('#updateCompanyAddress').val('');
				$('#updateCompanyShippingAddress').val('');
				$('#updateCompanyUenNo').val('');
				$('#updateCompanyContactPerson').val('');
				$('#updateCompanyEmail').val('');
				$('#updateCompanyPhoneNumber').val('');
				$('#updateCompanyOfficeNumber').val('');
				$('#updateCompanyFaxNumber').val('');
			    $('#modal-launcher-update-customer').toggle('fast');

				alert(data.message);
				window.location.reload();

			} else {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
		            $('input[name="' + 'Customer[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('textarea[name="' + 'Customer[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('input[name="'+ 'Customer[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}else{

		var id = $('#id').val();
		var fullname = $('#updateFullname').val();
		var customerAddress = $('#updateCustomerAddress').val();
		var customerShippingAddress = $('#updateCustomerShippingAddress').val();
		var customerRace = $('#updateCustomerRace').val();
		var customerNric = $('#updateCustomerNric').val();
		var customerEmail = $('#updateCustomerEmail').val();
		var customerPhoneNumber = $('#updateCustomerPhoneNumber').val();
		var customerOficeNumber = $('#updateCustomerOficeNumber').val();
		var customerFaxNumber = $('#updateCustomerFaxNumber').val();

		if( !onlyLetterAndNumber(fullname) ) {
			alert('Invalid customer name format.');
			fullname.focus();
		}

		if( !onlyLetterAndNumber(customerAddress) ) {
			alert('Invalid customer address format.');
			customerAddress.focus();
		}

		if( !onlyLetterAndNumber(customerShippingAddress) ) {
			alert('Invalid customer shipping address format.');
			customerShippingAddress.focus();
		}

		if( !onlyLetterAndNumber(customerNric) ) {
			alert('Invalid customer nric number format.');
			customerNric.focus();
		}

		if( !onlyForEmail(customerEmail) ) {
			alert('Invalid customer email format.');
			customerEmail.focus();
		}

		if( !onlyNumber(customerPhoneNumber) ) {
			alert('Invalid customer phone number format.');
			customerPhoneNumber.focus();
		}

		if( !onlyNumber(customerOficeNumber) ) {
			alert('Invalid customer office number format.');
			customerOficeNumber.focus();
		}

		$.post("?r=customer/update-customer",{
			id : id,
			fullname : fullname,
			customerAddress : customerAddress,
			customerShippingAddress : customerShippingAddress,
			customerRace : customerRace,
			customerNric : customerNric,
			customerEmail : customerEmail,
			customerPhoneNumber : customerPhoneNumber,
			customerOficeNumber : customerOficeNumber,
			customerFaxNumber : customerFaxNumber

		}, 
		function(data) {
			var data = jQuery.parseJSON(data);
			if( data.status == 'Success') {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

			    $('#updateFullname').val();
				$('#updateCustomerAddress').val();
				$('#updateCustomerShippingAddress').val();
				$('#updateCustomerRace').val();
				$('#updateCustomerNric').val();
				$('#updateCustomerEmail').val();
				$('#updateCustomerPhoneNumber').val();
				$('#updateCustomerOficeNumber').val();
				$('#updateCustomerFaxNumber').val();
			    $('#modal-launcher-update-customer').toggle('fast');

				alert(data.message);
				window.location.reload();

			} else {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
		            $('input[name="' + 'Customer[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('textarea[name="' + 'Customer[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('input[name="'+ 'Customer[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}

});

$('.closeUpdateCustomer').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-customer').modal('hide');
    	e.preventDefault();
    }
});

// Customer Delete //
$('.customerDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=customer/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Customer View //
if( $('._showViewCustomerModal').length ){

$('._showViewCustomerModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-customer').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=customer/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {

				if(result.type == 1){
					
					var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>COMPANY NAME</b></td>' +
							'<td>'+result.company_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>UEN NO.</b></td>' +
							'<td>'+result.uen_no.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>ADDRESS</b></td>' +
							'<td>'+result.address.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SHIPPING ADDRESS</b></td>' +
							'<td>'+result.shipping_address.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>CONTACT PERSON</b></td>' +
							'<td>'+result.fullname.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>COMPANY EMAIL</b></td>' +
							'<td>'+result.email.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>COMPANY PHONE NUMBER</b></td>' +
							'<td>'+result.phone_number+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>COMPANY MOBILE NUMBER</b></td>' +
							'<td>'+result.mobile_number+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>COMPANY FAX NUMBER</b></td>' +
							'<td>'+result.fax_number+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
					+'</table>';

				}else{

					var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>CUSTOMER NAME</b></td>' +
							'<td>'+result.fullname.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>NRIC NO.</b></td>' +
							'<td>'+result.nric.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>ADDRESS</b></td>' +
							'<td>'+result.address.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SHIPPING ADDRESS</b></td>' +
							'<td>'+result.shipping_address.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PERSONAL EMAIL</b></td>' +
							'<td>'+result.email.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PERSONAL PHONE NUMBER</b></td>' +
							'<td>'+result.phone_number+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PERSONAL MOBILE NUMBER</b></td>' +
							'<td>'+result.mobile_number+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>FAX NUMBER</b></td>' +
							'<td>'+result.fax_number+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
					+'</table>';

				}
				
				$('#viewCustomer').html(html);
			}

		});
	});
});

}

$('.closeViewCustomer').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-customer').modal('hide');
    	e.preventDefault();
    }
});

// Customer Forms Clear //
$('#clearCustomerForms').click(function(){

	$('#customerFormCreate').find('input:text[id=fullname]').val('');
	$('#customerFormCreate').find('textarea[id=address]').val('');
	$('#customerFormCreate').find('input:text[id=race]').val('');
	$('#customerFormCreate').find('input:text[id=email]').val('');
	$('#customerFormCreate').find('input:text[id=phoneNumber]').val('');
	$('#customerFormCreate').find('input:text[id=mobileNumber]').val('');

	$('#customerFormUpdate').find('input:hidden[name=id]').val('');
	$('#customerFormUpdate').find('input:text[id=updateFullname]').val('');
	$('#customerFormUpdate').find('textarea[id=updateAddress]').val('');
	$('#customerFormUpdate').find('input:text[id=updateRace]').val('');
	$('#customerFormUpdate').find('input:text[id=updateEmail]').val('');
	$('#customerFormUpdate').find('input:text[id=updatePhoneNumber]').val('');
	$('#customerFormUpdate').find('input:text[id=updateMobileNumber]').val('');

});

// Customer View Close //
$('#closeCustomerForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-customer').modal('hide');
    	e.preventDefault();
    }
});

// Staff Group Create //
$('._showCreateSGModal').click(function(){

	$('#modal-launcher-create-sg').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,

        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');	
    $('#description').val('');

});

$('#submitSGFormCreate').click(function(){
	var name = $('#name').val();
	var description = $('#description').val();

	if( !onlyLetter(name) ) {
		alert('Invalid department name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=staff-group/create",{
		name : name,
		description : description,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#name').val('');	
		    $('#description').val('');	
		    $('#modal-launcher-create-sg').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'StaffGroup[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'StaffGroup[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'StaffGroup[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewSg').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-sg').modal('hide');
    	e.preventDefault();
    }
});

// Staff Group Update //
if( $('._showUpdateSGModal').length ){

$('._showUpdateSGModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-sg').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=staff-group/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#sgFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#sgFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
				$('#sgFormUpdate').find('textarea[id=updateDescription]').val(result.description.toUpperCase());
			}

		});
	});
});

}

$('#submitSGFormUpdate').click(function(){
	var id = $('#id').val();
	var name = $('#updateName').val();
	var description = $('#updateDescription').val();
	
	if( !onlyLetter(name) ) {
		alert('Invalid department name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=staff-group/update",{
		id : id,
		name : name,
		description : description,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateName').val('');
		    $('#updateDescription').val('');
		    $('#modal-launcher-update-sg').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#sgFormUpdate').find('input[name="' + 'StaffGroup[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#sgFormUpdate').find('textarea[name="' + 'StaffGroup[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#sgFormUpdate').find('input[name="'+ 'StaffGroup[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateSg').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-sg').modal('hide');
    	e.preventDefault();
    }
});

// Staff Group Delete //
$('.sgDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=staff-group/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Staff Group View //
if( $('._showViewSGModal').length ){

$('._showViewSGModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-sg').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=staff-group/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DEPARTMENT NAME</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DESCRIPTION</b></td>' +
							'<td>'+result.description.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewSG').html(html);
			}

		});
	});
});

}

$('.closeViewSg').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-sg').modal('hide');
    	e.preventDefault();
    }
});

// Staff Group Forms Clear //
$('#clearSGForms').click(function(){

	$('#sgFormCreate').find('input:text[id=name]').val('');
	$('#sgFormCreate').find('textarea[id=description]').val('');

	$('#sgFormUpdate').find('input:hidden[name=id]').val('');
	$('#sgFormUpdate').find('input:text[id=updateName]').val('');
	$('#sgFormUpdate').find('textarea[id=updateDescription]').val('');
	
});

// Staff Group View Close //
$('#closeSGForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-sg').modal('hide');
    	e.preventDefault();
    }
});

// Designated Position Create //
$('._showCreateDPModal').click(function(){

	$('#modal-launcher-create-dp').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,

        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');	
    $('#description').val('');

});

$('#submitDPFormCreate').click(function(){
	var name = $('#name').val();
	var description = $('#description').val();

	if( !onlyLetter(name) ) {
		alert('Invalid designated position name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=designated-position/create",{
		name : name,
		description : description,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#name').val('');	
		    $('#description').val('');	
		    $('#modal-launcher-create-dp').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'DesignatedPosition[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'DesignatedPosition[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'DesignatedPosition[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewDp').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-dp').modal('hide');
    	e.preventDefault();
    }
});

// Designated Position Update //
if( $('._showUpdateDPModal').length ){

$('._showUpdateDPModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-dp').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=designated-position/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#dpFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#dpFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
				$('#dpFormUpdate').find('textarea[id=updateDescription]').val(result.description.toUpperCase());
			}

		});
	});
});

}

$('#submitDPFormUpdate').click(function(){
	var id = $('#id').val();
	var name = $('#updateName').val();
	var description = $('#updateDescription').val();
	
	if( !onlyLetter(name) ) {
		alert('Invalid designated position name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=designated-position/update",{
		id : id,
		name : name,
		description : description,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateName').val('');
		    $('#updateDescription').val('');
		    $('#modal-launcher-update-dp').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#dpFormUpdate').find('input[name="' + 'DesignatedPosition[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#dpFormUpdate').find('textarea[name="' + 'DesignatedPosition[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#dpFormUpdate').find('input[name="'+ 'DesignatedPosition[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateDp').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-dp').modal('hide');
    	e.preventDefault();
    }
});

// Designated Position Delete //
$('.dpDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=designated-position/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Designated Position View //
if( $('._showViewDPModal').length ){

$('._showViewDPModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-dp').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=designated-position/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DESIGNATED POSITION NAME</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DESCRIPTION</b></td>' +
							'<td>'+result.description.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewDP').html(html);
			}

		});
	});
});

}

$('.closeViewDp').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-dp').modal('hide');
    	e.preventDefault();
    }
});

// Designated Position Forms Clear //
$('#clearDPForms').click(function(){

	$('#dpFormCreate').find('input:text[id=name]').val('');
	$('#dpFormCreate').find('textarea[id=description]').val('');

	$('#dpFormUpdate').find('input:hidden[name=id]').val('');
	$('#dpFormUpdate').find('input:text[id=updateName]').val('');
	$('#dpFormUpdate').find('textarea[id=updateDescription]').val('');
	
});

// Designated Position View Close //
$('#closeDPForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-dp').modal('hide');
    	e.preventDefault();
    }
});

// Staff Create //
$('._showCreateStaffModal').click(function(){

	$('#modal-launcher-create-staff').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#staffGroup').val('');
	$('#designatedPosition').val('');	
	$('#fullname').val('');	
    $('#address').val('');
    $('#race').val('');
    $('#email').val('');
    $('#mobileNumber').val('');

});

$('#submitStaffFormCreate').click(function(){
	var staffGroup = $('#staffGroup').val();
	var designatedPosition = $('#designatedPosition').val();
	var fullname = $('#fullname').val();
	var address = $('#address').val();
	var race = $('#race').val();
	var email = $('#email').val();
	var mobileNumber = $('#mobileNumber').val();

	if( !onlyLetter(fullname) ) {
		alert('Invalid fullname format.');
		fullname.focus();
	}

	if( !onlyLetterAndNumber(address) ) {
		alert('Invalid address format.');
		address.focus();
	}

	if( !onlyForEmail(email) ) {
		alert('Invalid email format.');
		email.focus();
	}

	if( !onlyNumber(mobileNumber) ) {
		alert('Invalid mobile number format.');
		mobileNumber.focus();
	}

	$.post("?r=staff/create",{
		staffGroup : staffGroup,
		designatedPosition : designatedPosition,
		fullname : fullname,
		address : address,
		race : race,
		email : email,
		mobileNumber : mobileNumber,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#staffGroup').val('');
		    $('#designatedPosition').val('');
		    $('#fullname').val('');	
		    $('#address').val('');
		    $('#race').val('');
		    $('#email').val('');
		    $('#mobileNumber').val('');
		    $('#modal-launcher-create-staff').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'Staff[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'Staff[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'Staff[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewStaff').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-staff').modal('hide');
    	e.preventDefault();
    }
});

// Staff Update //
if( $('._showUpdateStaffModal').length ){

$('._showUpdateStaffModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-staff').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=staff/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#staffFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#staffFormUpdate').find('select[id=updateStaffGroup]').val(result.staff_group_id).change();
				$('#staffFormUpdate').find('select[id=updateDesignatedPosition]').val(result.designated_position_id).change();
				$('#staffFormUpdate').find('input:text[id=updateFullname]').val(result.fullname.toUpperCase());
				$('#staffFormUpdate').find('textarea[id=updateAddress]').val(result.address.toUpperCase());
				$('#staffFormUpdate').find('select[id=updateRace]').val(result.race).change();
				$('#staffFormUpdate').find('input:text[id=updateEmail]').val(result.email.toUpperCase());
				$('#staffFormUpdate').find('input:text[id=updateMobileNumber]').val(result.mobile_number);
			}

		});
	});
});

}

$('#submitStaffFormUpdate').click(function(){
	var id = $('#id').val();
	var staffGroup = $('#updateStaffGroup').val();
	var designatedPosition = $('#updateDesignatedPosition').val();
	var fullname = $('#updateFullname').val();
	var address = $('#updateAddress').val();
	var race = $('#updateRace').val();
	var email = $('#updateEmail').val();
	var mobileNumber = $('#updateMobileNumber').val();

	if( !onlyLetter(fullname) ) {
		alert('Invalid fullname format.');
		fullname.focus();
	}

	if( !onlyLetterAndNumber(address) ) {
		alert('Invalid address format.');
		address.focus();
	}

	if( !onlyNumber(race) ) {
		alert('Invalid race format.');
		race.focus();
	}

	if( !onlyForEmail(email) ) {
		alert('Invalid email format.');
		email.focus();
	}

	if( !onlyNumber(mobileNumber) ) {
		alert('Invalid mobile number format.');
		mobileNumber.focus();
	}

	$.post("?r=staff/update",{
		id : id,
		staffGroup : staffGroup,
		designatedPosition : designatedPosition,
		fullname : fullname,
		address : address,
		race : race,
		email : email,
		mobileNumber : mobileNumber,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateStaffGroup').val('');
		    $('#updateDesignatedPosition').val('');
		    $('#updateFullname').val('');	
		    $('#updateAddress').val('');
		    $('#updateRace').val('');
		    $('#updateEmail').val('');
		    $('#updateMobileNumber').val('');
		    $('#modal-launcher-update-staff').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#staffFormUpdate').find('input[name="' + 'Staff[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#staffFormUpdate').find('textarea[name="' + 'Staff[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#staffFormUpdate').find('input[name="'+ 'Staff[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateStaff').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-staff').modal('hide');
    	e.preventDefault();
    }
});

// Staff Delete //
$('.staffDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=staff/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Staff View //
if( $('._showViewStaffModal').length ){

$('._showViewStaffModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-staff').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=staff/get-data-for-view", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DEPARTMENT</b></td>' +
							'<td>'+result.staff_group_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DESiGNATED POSITION</b></td>' +
							'<td>'+result.designated_position_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>FULLNAME</b></td>' +
							'<td>'+result.fullname.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>ADDRESS</b></td>' +
							'<td>'+result.address.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>RACE</b></td>' +
							'<td>'+result.race_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>EMAIL</b></td>' +
							'<td>'+result.email.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>MOBILE NUMBER</b></td>' +
							'<td>'+result.mobile_number+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewStaff').html(html);
			}

		});
	});
});

}

$('.closeViewStaff').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-staff').modal('hide');
    	e.preventDefault();
    }
});

// Staff Forms Clear //
$('#clearStaffForms').click(function(){

	$('#staffFormCreate').find('select[id=staffGroup]').val('');
	$('#staffFormCreate').find('select[id=designatedPosition]').val('');
	$('#staffFormCreate').find('input:text[id=fullname]').val('');
	$('#staffFormCreate').find('textarea[id=address]').val('');
	$('#staffFormCreate').find('input:text[id=race]').val('');
	$('#staffFormCreate').find('input:text[id=email]').val('');
	$('#staffFormCreate').find('input:text[id=mobileNumber]').val('');

	$('#staffFormUpdate').find('input:hidden[name=id]').val('');
	$('#staffFormUpdate').find('select[id=updateStaffGroup]').val('');
	$('#staffFormUpdate').find('select[id=updateDesignatedPosition]').val('');
	$('#staffFormUpdate').find('input:text[id=updateFullname]').val('');
	$('#staffFormUpdate').find('textarea[id=updateAddress]').val('');
	$('#staffFormUpdate').find('input:text[id=updateRace]').val('');
	$('#staffFormUpdate').find('input:text[id=updateEmail]').val('');
	$('#staffFormUpdate').find('input:text[id=updateMobileNumber]').val('');

});

// Staff View Close //
$('#closeStaffForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-staff').modal('hide');
    	e.preventDefault();
    }

});

// Supplier Create //
$('._showCreateSupplierModal').click(function(){

	$('#modal-launcher-create-supplier').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,

        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');	
    $('#address').val('');
    $('#contactNumber').val('');

});

$('#submitSupplierFormCreate').click(function(){
	var supplierCode = $('#supplierCode').val();
	var name = $('#name').val();
	var address = $('#address').val();
	var contactNumber = $('#contactNumber').val();

	if( !onlyLetter(name) ) {
		alert('Invalid supplier name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(address) ) {
		alert('Invalid address format.');
		address.focus();
	}

	if( !onlyNumber(contactNumber) ) {
		alert('Invalid contact number format.');
		contactNumber.focus();
	}

	$.post("?r=supplier/create",{
		supplierCode : supplierCode,
		name : name,
		address : address,
		contactNumber : contactNumber,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#supplierCode').val('');	
		    $('#name').val('');	
		    $('#address').val('');
		    $('#contactNumber').val('');
		    $('#modal-launcher-create-supplier').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'Supplier[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'Supplier[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'Supplier[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewSupplier').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-supplier').modal('hide');
    	e.preventDefault();
    }
});

// Supplier Update //
if( $('._showUpdateSupplierModal').length ){

$('._showUpdateSupplierModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-supplier').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=supplier/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#supplierFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#supplierFormUpdate').find('input:text[id=updateSupplierCode]').val(result.supplier_code.toUpperCase());
				$('#supplierFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
				$('#supplierFormUpdate').find('textarea[id=updateAddress]').val(result.address.toUpperCase());
				$('#supplierFormUpdate').find('input:text[id=updateContactNumber]').val(result.contact_number);
			}

		});
	});
});

}

$('#submitSupplierFormUpdate').click(function(){
	var id = $('#id').val();
	var supplierCode = $('#updateSupplierCode').val();
	var name = $('#updateName').val();
	var address = $('#updateAddress').val();
	var contactNumber = $('#updateContactNumber').val();

	if( !onlyLetter(name) ) {
		alert('Invalid supplier name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(address) ) {
		alert('Invalid address format.');
		address.focus();
	}

	if( !onlyNumber(contactNumber) ) {
		alert('Invalid contact number format.');
		contactNumber.focus();
	}

	$.post("?r=supplier/update",{
		id : id,
		supplierCode : supplierCode,
		name : name,
		address : address,
		contactNumber : contactNumber,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateSupplierCode').val('');	
		    $('#updateName').val('');
		    $('#updateAddress').val('');
		    $('#updateContactNumber').val('');
		    $('#modal-launcher-update-supplier').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#supplierFormUpdate').find('input[name="' + 'Supplier[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#supplierFormUpdate').find('textarea[name="' + 'Supplier[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#supplierFormUpdate').find('input[name="'+ 'Supplier[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateSupplier').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-supplier').modal('hide');
    	e.preventDefault();
    }
});

// Supplier Delete //
$('.supplierDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=supplier/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Supplier View //
if( $('._showViewSupplierModal').length ){

$('._showViewSupplierModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-supplier').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=supplier/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SUPPLIER CODE</b></td>' +
							'<td>'+result.supplier_code.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SUPPLIER NAME</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>ADDRESS</b></td>' +
							'<td>'+result.address.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>CONTACT NUMBER</b></td>' +
							'<td>'+result.contact_number+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewSupplier').html(html);
			}

		});
	});
});

}

$('.closeViewSupplier').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-supplier').modal('hide');
    	e.preventDefault();
    }
});

// Supplier Forms Clear //
$('#clearSupplierForms').click(function(){

	$('#supplierFormCreate').find('input:text[id=name]').val('');
	$('#supplierFormCreate').find('textarea[id=address]').val('');
	$('#supplierFormCreate').find('input:text[id=contactNumber]').val('');

	$('#supplierFormUpdate').find('input:hidden[name=id]').val('');
	$('#supplierFormUpdate').find('input:text[id=updateName]').val('');
	$('#supplierFormUpdate').find('textarea[id=updateAddress]').val('');
	$('#supplierFormUpdate').find('input:text[id=updateContactNumber]').val('');

});

// Supplier View Close //
$('#closeSupplierForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-supplier').modal('hide');
    	e.preventDefault();
    }
});

// Module Create //
$('._showCreateModuleModal').click(function(){

	$('#modal-launcher-create-module').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');	

});

$('#submitModuleFormCreate').click(function(){
	var name = $('#name').val();

	if( !onlyLetter(name) ) {
		alert('Invalid module name format.');
		name.focus();
	}

	$.post("?r=module/create",{
		name : name,
	
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#name').val('');	
		    $('#modal-launcher-create-module').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'Module[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'Module[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'Module[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewModule').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-module').modal('hide');
    	e.preventDefault();
    }
});

// Module Update //
if( $('._showUpdateModuleModal').length ){

$('._showUpdateModuleModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-module').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=module/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#moduleFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#moduleFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
			}

		});
	});
});

}

$('#submitModuleFormUpdate').click(function(){
	var id = $('#id').val();
	var name = $('#updateName').val();
	
	if( !onlyLetter(name) ) {
		alert('Invalid module name format.');
		name.focus();
	}

	$.post("?r=module/update",{
		id : id,
		name : name,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateName').val('');
		    $('#modal-launcher-update-module').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#moduleFormUpdate').find('input[name="' + 'Module[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#moduleFormUpdate').find('textarea[name="' + 'Module[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#moduleFormUpdate').find('input[name="'+ 'Module[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateModule').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-module').modal('hide');
    	e.preventDefault();
    }
});

// Module Delete //
$('.moduleDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=module/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Module View //
if( $('._showViewModuleModal').length ){

$('._showViewModuleModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-module').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=module/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SUPPLIER CODE</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewModule').html(html);
			}

		});
	});
});

}

$('.closeViewModule').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-module').modal('hide');
    	e.preventDefault();
    }
});

// Module Forms Clear //
$('#clearModuleForms').click(function(){

	$('#moduleFormCreate').find('input:text[id=name]').val('');

	$('#moduleFormUpdate').find('input:hidden[name=id]').val('');
	$('#moduleFormUpdate').find('input:text[id=updateName]').val('');
	
});

// Module View Close //
$('#closeModuleForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-module').modal('hide');
    	e.preventDefault();
    }
});

// Storage Location Create //
$('._showCreateSLModal').click(function(){

	$('#modal-launcher-create-sl').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#rack').val('');	
    $('#bay').val('');
    $('#level').val('');
    $('#position').val('');

});

$('#submitSLFormCreate').click(function(){
	var rack = $('#rack').val();
	var bay = $('#bay').val();
	var level = $('#level').val();
	var position = $('#position').val();

	if( !onlyLetterAndNumber(rack) ) {
		alert('Invalid rack format.');
		rack.focus();
	}

	if( !onlyLetterAndNumber(bay) ) {
		alert('Invalid bay format.');
		bay.focus();
	}

	if( !onlyLetterAndNumber(level) ) {
		alert('Invalid level format.');
		level.focus();
	}

	if( !onlyLetterAndNumber(position) ) {
		alert('Invalid position format.');
		position.focus();
	}

	$.post("?r=storage-location/create",{
		rack : rack,
		bay : bay,
		level : level,
		position : position,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#rack').val('');	
		    $('#bay').val('');	
		    $('#level').val('');
		    $('#position').val('');
		    $('#modal-launcher-create-sl').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'StorageLocations[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'StorageLocations[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'StorageLocations[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewSl').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-sl').modal('hide');
    	e.preventDefault();
    }
});

// Storage Location Update //
if( $('._showUpdateSLModal').length ){

$('._showUpdateSLModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-sl').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=storage-location/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#slFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#slFormUpdate').find('input:text[id=updateRack]').val(result.rack.toUpperCase());
				$('#slFormUpdate').find('input:text[id=updateBay]').val(result.bay.toUpperCase());
				$('#slFormUpdate').find('input:text[id=updateLevel]').val(result.level.toUpperCase());
				$('#slFormUpdate').find('input:text[id=updatePosition]').val(result.position.toUpperCase());
			}

		});
	});
});

}

$('#submitSLFormUpdate').click(function(){
	var id = $('#id').val();
	var rack = $('#updateRack').val();
	var bay = $('#updateBay').val();
	var level = $('#updateLevel').val();
	var position = $('#updatePosition').val();
	
	if( !onlyLetterAndNumber(rack) ) {
		alert('Invalid rack format.');
		rack.focus();
	}

	if( !onlyLetterAndNumber(bay) ) {
		alert('Invalid bay format.');
		bay.focus();
	}

	if( !onlyLetterAndNumber(level) ) {
		alert('Invalid level format.');
		level.focus();
	}

	if( !onlyLetterAndNumber(position) ) {
		alert('Invalid position format.');
		position.focus();
	}

	$.post("?r=storage-location/update",{
		id : id,
		rack : rack,
		bay : bay,
		level : level,
		position : position,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateRack').val('');
		    $('#updateBay').val('');
		    $('#updateLevel').val('');
		    $('#updatePosition').val('');
		    $('#modal-launcher-update-sl').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#slFormUpdate').find('input[name="' + 'StorageLocations[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#slFormUpdate').find('textarea[name="' + 'StorageLocations[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#slFormUpdate').find('input[name="'+ 'StorageLocations[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateSl').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-sl').modal('hide');
    	e.preventDefault();
    }
});

// Storage Location Delete //
$('.slDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=storage-location/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Storage Location View //
if( $('._showViewSLModal').length ){

$('._showViewSLModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-sl').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=storage-location/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>RACK</b></td>' +
							'<td>'+result.rack.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>BAY</b></td>' +
							'<td>'+result.bay.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>LEVEL</b></td>' +
							'<td>'+result.level.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>POSITION</b></td>' +
							'<td>'+result.position.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewSL').html(html);
			}

		});
	});
});

}

$('.closeViewSl').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-sl').modal('hide');
    	e.preventDefault();
    }
});

// Storage Location Forms Clear //
$('#clearSLForms').click(function(){

	$('#slFormCreate').find('input:text[id=rack]').val('');
	$('#slFormCreate').find('input:text[id=bay]').val('');
	$('#slFormCreate').find('input:text[id=level]').val('');
	$('#slFormCreate').find('input:text[id=position]').val('');

	$('#slFormUpdate').find('input:hidden[name=id]').val('');
	$('#slFormUpdate').find('input:text[id=updateRack]').val('');
	$('#slFormUpdate').find('input:text[id=updateBay]').val('');
	$('#slFormUpdate').find('input:text[id=updateLevel]').val('');
	$('#slFormUpdate').find('input:text[id=updatePosition]').val('');
	
});

// Storage Location View Close //
$('#closeSLForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-sl').modal('hide');
    	e.preventDefault();
    }
});

// Service Category Create //
$('._showCreateSCModal').click(function(){

	$('#modal-launcher-create-sc').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');	
    $('#description').val('');

});

$('#submitSCFormCreate').click(function(){
	var name = $('#name').val();
	var description = $('#description').val();

	if( !onlyLetter(name) ) {
		alert('Invalid service category name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=service-category/create",{
		name : name,
		description : description,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#name').val('');	
		    $('#description').val('');	
		    $('#modal-launcher-create-sc').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'ServiceCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'ServiceCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'ServiceCategory[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewSc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-sc').modal('hide');
    	e.preventDefault();
    }
});

// Service Category Update //
if( $('._showUpdateSCModal').length ){

$('._showUpdateSCModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-sc').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=service-category/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#scFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#scFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
				$('#scFormUpdate').find('textarea[id=updateDescription]').val(result.description.toUpperCase());
			}

		});
	});
});

}

$('#submitSCFormUpdate').click(function(){
	var id = $('#id').val();
	var name = $('#updateName').val();
	var description = $('#updateDescription').val();
	
	if( !onlyLetter(name) ) {
		alert('Invalid service category name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=service-category/update",{
		id : id,
		name : name,
		description : description,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateName').val('');
		    $('#updateDescription').val('');
		    $('#modal-launcher-update-sc').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#scFormUpdate').find('input[name="' + 'ServiceCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#scFormUpdate').find('textarea[name="' + 'ServiceCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#scFormUpdate').find('input[name="'+ 'ServiceCategory[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateSc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-sc').modal('hide');
    	e.preventDefault();
    }
});

// Service Category Delete //
$('.scDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=service-category/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Service Category View //
if( $('._showViewSCModal').length ){

$('._showViewSCModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-sc').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=service-category/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SERVICE CATEGORY NAME</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DESCRIPTION</b></td>' +
							'<td>'+result.description.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewSC').html(html);
			}

		});
	});
});

}

$('.closeViewSc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-sc').modal('hide');
    	e.preventDefault();
    }
});

// Service Category Forms Clear //
$('#clearSCForms').click(function(){

	$('#scFormCreate').find('input:text[id=name]').val('');
	$('#scFormCreate').find('textarea[id=description]').val('');

	$('#scFormUpdate').find('input:hidden[name=id]').val('');
	$('#scFormUpdate').find('input:text[id=updateName]').val('');
	$('#scFormUpdate').find('textarea[id=updateDescription]').val('');
	
});

// Service Category View Close //
$('#closeSCForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-sc').modal('hide');
    	e.preventDefault();
    }
});

// Service Create //
$('._showCreateServiceModal').click(function(){

	$('#modal-launcher-create-service').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#serviceCategory').val('');	
    $('#serviceName').val('');
    $('#description').val('');
    $('#price').val('');

});

$('#submitServiceFormCreate').click(function(){
	var serviceCategory = $('#serviceCategory').val();
	var serviceName = $('#serviceName').val();
	var description = $('#description').val();
	var price = $('#price').val();

	if( !onlyLetter(serviceName) ) {
		alert('Invalid service name format.');
		serviceName.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	if( !onlyNumber(price) ) {
		alert('Invalid price format.');
		price.focus();
	}

	$.post("?r=service/create",{
		serviceCategory : serviceCategory,
		serviceName : serviceName,
		description : description,
		price : price,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#serviceCategory').val('');	
		    $('#serviceName').val('');	
		    $('#description').val('');
		    $('#price').val('');		
		    $('#modal-launcher-create-service').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'Service[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'Service[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'Service[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewService').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-service').modal('hide');
    	e.preventDefault();
    }
});

// Service Update //
if( $('._showUpdateServiceModal').length ){

$('._showUpdateServiceModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-service').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=service/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#serviceFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#serviceFormUpdate').find('select[id=updateServiceCategory]').val(result.service_category_id).change();
				$('#serviceFormUpdate').find('input:text[id=updateServiceName]').val(result.service_name.toUpperCase());
				$('#serviceFormUpdate').find('textarea[id=updateDescription]').val(result.description.toUpperCase());
				$('#serviceFormUpdate').find('input:text[id=updatePrice]').val(parseFloat(result.price).toFixed(2));
			}

		});
	});
});

}

$('#submitServiceFormUpdate').click(function(){
	var id = $('#id').val();
	var serviceCategory = $('#updateServiceCategory').val();
	var serviceName = $('#updateServiceName').val();
	var description = $('#updateDescription').val();
	var price = $('#updatePrice').val();
	
	if( !onlyLetter(serviceName) ) {
		alert('Invalid service name format.');
		serviceName.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	if( !onlyNumber(price) ) {
		alert('Invalid price format.');
		price.focus();
	}

	$.post("?r=service/update",{
		id : id,
		serviceCategory : serviceCategory,
		serviceName : serviceName,
		description : description,
		price : price,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateServiceCategory').val('');
		    $('#updateServiceName').val('');
		    $('#updateDescription').val('');
		    $('#updatePrice').val('');
		    $('#modal-launcher-update-service').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#serviceFormUpdate').find('input[name="' + 'Service[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#serviceFormUpdate').find('textarea[name="' + 'Service[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#serviceFormUpdate').find('input[name="'+ 'Service[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateService').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-service').modal('hide');
    	e.preventDefault();
    }
});

// Service Delete //
$('.serviceDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=service/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Service View //
if( $('._showViewServiceModal').length ){

$('._showViewServiceModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-service').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=service/get-data-for-view", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SERVICE CATEGORY</b></td>' +
							'<td>'+result.service_category_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SERVICE CATEGORY</b></td>' +
							'<td>'+result.service_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DESCRIPTION</b></td>' +
							'<td>'+result.description.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewService').html(html);
			}

		});
	});
});

}

$('.closeViewService').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-service').modal('hide');
    	e.preventDefault();
    }
});

// Service Forms Clear //
$('#clearServiceForms').click(function(){


	$('#serviceFormCreate').find('select[id=serviceCategory]').val('');
	$('#serviceFormCreate').find('input:text[id=serviceName]').val('');
	$('#serviceFormCreate').find('textarea[id=description]').val('');
	$('#serviceFormCreate').find('input:text[id=price]').val('');

	$('#serviceFormUpdate').find('select[id=updateServiceCategory]').val('');
	$('#serviceFormUpdate').find('input:text[id=updateServiceName]').val('');
	$('#serviceFormUpdate').find('textarea[id=updateDescription]').val('');
	$('#serviceFormUpdate').find('input:text[id=updatePrice]').val('');
	
});

// Service View Close //
$('#closeServiceForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-service').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Category Create //
$('._showCreatePCModal').click(function(){

	$('#modal-launcher-create-pc').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');	
    $('#description').val('');

});

$('#submitPCFormCreate').click(function(){
	var name = $('#name').val();
	var description = $('#description').val();

	if( !onlyLetter(name) ) {
		alert('Invalid auto-parts category name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=parts-category/create",{
		name : name,
		description : description,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#name').val('');	
		    $('#description').val('');	
		    $('#modal-launcher-create-pc').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'PartsCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'PartsCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'PartsCategory[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewPc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-pc').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Category Update //
if( $('._showUpdatePCModal').length ){

$('._showUpdatePCModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-pc').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=parts-category/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#pcFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#pcFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
				$('#pcFormUpdate').find('textarea[id=updateDescription]').val(result.description.toUpperCase());
			}

		});
	});
});

}

$('#submitPCFormUpdate').click(function(){
	var id = $('#id').val();
	var name = $('#updateName').val();
	var description = $('#updateDescription').val();
	
	if( !onlyLetter(name) ) {
		alert('Invalid auto-parts category name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=parts-category/update",{
		id : id,
		name : name,
		description : description,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateName').val('');
		    $('#updateDescription').val('');
		    $('#modal-launcher-update-pc').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#pcFormUpdate').find('input[name="' + 'PartsCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#pcFormUpdate').find('textarea[name="' + 'PartsCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#pcFormUpdate').find('input[name="'+ 'PartsCategory[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdatePc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-pc').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Category Delete //
$('.pcDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=parts-category/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Auto-Parts Category View //
if( $('._showViewPCModal').length ){

$('._showViewPCModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-pc').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=parts-category/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>AUTO-PARTS CATEGORY NAME</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DESCRIPTION</b></td>' +
							'<td>'+result.description.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewPC').html(html);
			}

		});
	});
});

}

$('.closeViewPc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-pc').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Category Forms Clear //
$('#clearPCForms').click(function(){

	$('#pcFormCreate').find('input:text[id=name]').val('');
	$('#pcFormCreate').find('textarea[id=description]').val('');

	$('#pcFormUpdate').find('input:hidden[name=id]').val('');
	$('#pcFormUpdate').find('input:text[id=updateName]').val('');
	$('#pcFormUpdate').find('textarea[id=updateDescription]').val('');
	
});

// Auto-Parts Category View Close //
$('#closePCForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-pc').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Create //
$('._showCreatePartsModal').click(function(){

	$('#modal-launcher-create-parts').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#storageLocation').val('');	
	$('#supplier').val('');	
    $('#partsCategory').val('');
    $('#partsName').val('');
    $('#quantity').val('');
    $('#uom').val('');
    $('#costPrice').val('');
    $('#reorderLevel').val('');
    $('#gstPrice').val('');
    $('#sellingPrice').val('');

});

$('#submitPartsFormCreate').click(function(){
	var storageLocation = $('#storageLocation').val();
	var supplier = $('#supplier').val();
	var partsCode = $('#partsCode').val();
	var partsCategory = $('#partsCategory').val();
	var partsName = $('#partsName').val();
	var quantity = $('#quantity').val();
	var uom = $('#uom').val();
	var costPrice = $('#costPrice').val();
	var reorderLevel = $('#reorderLevel').val();
	var gstPrice = $('#gstPrice').val();
	var sellingPrice = $('#sellingPrice').val();

	if( !onlyLetterAndNumber(partsName) ) {
		alert('Invalid auto-parts name format.');
		partsName.focus();
	}

	if( !onlyLetterAndNumber(uom) ) {
		alert('Invalid unit of measure format.');
		uom.focus();
	}

	if( !onlyNumber(quantity) ) {
		alert('Invalid quantity format.');
		quantity.focus();
	}

	if( !onlyNumber(reorderLevel) ) {
		alert('Invalid re-order level format.');
		reorderLevel.focus();
	}

	if( !onlyNumber(costPrice) ) {
		alert('Invalid cost price format.');
		costPrice.focus();
	}

	if( !onlyNumber(sellingPrice) ) {
		alert('Invalid selling price format.');
		sellingPrice.focus();
	}

	$.post("?r=parts/create",{
		storageLocation : storageLocation,
		supplier : supplier,
		partsCode : partsCode,
		partsCategory : partsCategory,
		partsName : partsName,
		quantity : quantity,
		uom : uom,
		costPrice : costPrice,
		reorderLevel : reorderLevel,	
		gstPrice : gstPrice,
		sellingPrice : sellingPrice,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#storageLocation').val('');
		    $('#supplier').val('');
			$('#partsCategory').val('');
			$('#partsName').val('');
			$('#quantity').val('');
			$('#uom').val('');
			$('#costPrice').val('');
			$('#reorderLevel').val('');
			$('#gstPrice').val('');
			$('#sellingPrice').val('');	
		    $('#modal-launcher-create-parts').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'Parts[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'Parts[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'Parts[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewParts').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-parts').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Update //
if( $('._showUpdatePartsModal').length ){

$('._showUpdatePartsModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-parts').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=parts/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#partsFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#partsFormUpdate').find('select[id=updateStorageLocation]').val(result.storage_location_id).change();
				$('#partsFormUpdate').find('select[id=updateSupplier]').val(result.supplier_id).change();
				$('#partsFormUpdate').find('select[id=updatePartsCategory]').val(result.parts_category_id).change();
				$('#partsFormUpdate').find('input:text[id=updatePartsCode]').val(result.parts_code.toUpperCase());
				$('#partsFormUpdate').find('input:text[id=updatePartsName]').val(result.parts_name.toUpperCase());
				$('#partsFormUpdate').find('input:text[id=updateQuantity]').val(parseInt(result.quantity));
				$('#partsFormUpdate').find('input:text[id=updateUom]').val(result.unit_of_measure.toUpperCase());
				$('#partsFormUpdate').find('input:text[id=updateCostPrice]').val(parseFloat(result.cost_price).toFixed(2));
				$('#partsFormUpdate').find('input:text[id=updateReorderLevel]').val(parseInt(result.reorder_level));
				$('#partsFormUpdate').find('input:text[id=updateGstPrice]').val(parseInt(result.gst_price));
				$('#partsFormUpdate').find('input:text[id=updateSellingPrice]').val(parseFloat(result.selling_price).toFixed(2));
			}

		});
	});
});

}

$('#submitPartsFormUpdate').click(function(){
	var id = $('#id').val();
	var storageLocation = $('#updateStorageLocation').val();
	var supplier = $('#updateSupplier').val();
	var partsCode = $('#updatePartsCode').val();
	var partsCategory = $('#updatePartsCategory').val();
	var partsName = $('#updatePartsName').val();
	var quantity = $('#updateQuantity').val();
	var uom = $('#updateUom').val();
	var costPrice = $('#updateCostPrice').val();
	var reorderLevel = $('#updateReorderLevel').val();
	var gstPrice = $('#updateGstPrice').val();
	var sellingPrice = $('#updateSellingPrice').val();

	if( !onlyLetterAndNumber(partsName) ) {
		alert('Invalid auto-parts name format.');
		partsName.focus();
	}

	if( !onlyLetterAndNumber(uom) ) {
		alert('Invalid unit of measure format.');
		uom.focus();
	}

	if( !onlyNumber(quantity) ) {
		alert('Invalid quantity format.');
		quantity.focus();
	}

	if( !onlyNumber(reorderLevel) ) {
		alert('Invalid re-order level format.');
		reorderLevel.focus();
	}

	if( !onlyNumber(costPrice) ) {
		alert('Invalid cost price format.');
		costPrice.focus();
	}

	if( !onlyNumber(sellingPrice) ) {
		alert('Invalid selling price format.');
		sellingPrice.focus();
	}

	$.post("?r=parts/update",{
		id : id,
		storageLocation : storageLocation,
		supplier : supplier,
		partsCode : partsCode,
		partsCategory : partsCategory,
		partsName : partsName,
		quantity : quantity,
		uom : uom,
		costPrice : costPrice,
		reorderLevel : reorderLevel,	
		gstPrice : gstPrice,
		sellingPrice : sellingPrice,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateStorageLocation').val();
			$('#updateSupplier').val();
			$('#updatePartsCategory').val();
			$('#updatePartsName').val();
			$('#updateQuantity').val();
			$('#updateUom').val();
			$('#updateCostPrice').val();
			$('#updateReorderLevel').val();
			$('#updateGstPrice').val();
			$('#updateSellingPrice').val();
		    $('#modal-launcher-update-parts').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#partsFormUpdate').find('input[name="' + 'Parts[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#partsFormUpdate').find('textarea[name="' + 'Parts[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#partsFormUpdate').find('input[name="'+ 'Parts[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateParts').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-parts').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Delete //
$('.partsDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=parts/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Auto-Parts View //
if( $('._showViewPartsModal').length ){

$('._showViewPartsModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-parts').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=parts/get-data-for-view", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STORAGE LOCATION</b></td>' +
							'<td>'+result.storage_location_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SUPPLIER</b></td>' +
							'<td>'+result.supplier_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>AUTO-PARTS CODE</b></td>' +
							'<td>'+result.parts_code.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>AUTO-PARTS CATEGORY</b></td>' +
							'<td>'+result.parts_category_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>AUTO-PARTS NAME</b></td>' +
							'<td>'+result.parts_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>UNIT OF MEASURE</b></td>' +
							'<td>'+result.unit_of_measure.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>QUANTITY</b></td>' +
							'<td>'+parseInt(result.quantity)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>RE-ORDER LEVEL</b></td>' +
							'<td>'+parseInt(result.reorder_level)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>COST PRICE</b></td>' +
							'<td>'+parseFloat(result.reorder_level).toFixed(2)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>GST PRICE</b></td>' +
							'<td>'+parseInt(result.gst_price)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SELLING PRICE</b></td>' +
							'<td>'+parseFloat(result.selling_price).toFixed(2)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewParts').html(html);
			}

		});
	});
});

}

$('.closeViewParts').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-parts').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Forms Clear //
$('#clearPartsForms').click(function(){


	$('#partsFormCreate').find('select[id=partsCategory]').val('');
	$('#partsFormCreate').find('input:text[id=partsCode]').val('');
	$('#partsFormCreate').find('input:text[id=partsName]').val('');
	$('#partsFormCreate').find('textarea[id=description]').val('');
	$('#partsFormCreate').find('input:text[id=uom]').val('');

	$('#partsFormUpdate').find('select[id=updatePartCategory]').val('');
	$('#partsFormUpdate').find('input:text[id=updatePartsCode]').val('');
	$('#partsFormUpdate').find('input:text[id=updatePartsName]').val('');
	$('#partsFormUpdate').find('textarea[id=updateDescription]').val('');
	$('#partsFormUpdate').find('input:text[id=updateUom]').val('');
	
});

// Auto-Parts View Close //
$('#closePartsForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-parts').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Update Selected Qty
$('._showUpdateQtySelectedPartsModal').click(function(){

	if($('.autopartsSelected:checked').length == 0){
		alert('Select Auto-parts first.');
		return false;
	}

	$('#modal-launcher-updateqty-selected-parts').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('.autopartsSelected:checked').each(function(index, value){
		
		$.get('?r=parts/get-selected-partsinfo',{
			partsId: $(this).val(),

		},function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b><span class="fa fa-cogs"></span> AUTO-PARTS NAME</b></td>' +
							'<td style="text-align:center;" ><b><span class="fa fa-tags"></span> OLD QUANTITY</b></td>' +
							'<td style="text-align:center;" ><b><span class="fa fa-database"></span> NEW QUANTITY</b></td>' 
						+'</tr>'+
						'<tr>'+
							'<td style="width:50%;" >'+
								'<span class="fa fa-gg-circle"> '+result.parts_name.toUpperCase()+
								'<input type="hidden" name="partsId[]" id="partsId-'+ result.id  +'" class="selectedPartsId inputForm form-control partsId-'+ result.id  +'" value="'+parseInt(result.id)+'" />'+
							'</td>'+
							'<td>'+
								'<input type="text" id="editOldQty-'+ result.id  +'" class="inputForm form-control editOldQty-'+ result.id  +'" placeholder="0" style="text-align:center;" onchange="updateSelectedPartsQty('+ result.id +')" />'+
								'<input type="hidden" name="oldQty[]" id="oldQty-'+ result.id  +'" class="selectedPartsOldQty inputForm form-control oldQty-'+ result.id  +'" value="'+parseInt(result.quantity)+'" />'+
							'</td>'+
							'<td>'+
								'<input type="text" name="newQty[]" id="newQty-'+ result.id  +'" class="selectedPartsNewQty inputForm form-control newQty-'+ result.id  +'" value="'+parseInt(result.quantity)+'" readonly="readonly" style="text-align:center;" />'+
							'</td>'
						+'</tr>'+
					'</table>';

				$('#viewSelectedParts').append(html);
			}

		});

	});
});

function updateSelectedPartsQty(n){
	var editOldQty = $('#editOldQty-'+n).val();
	var oldQty = $('#oldQty-'+n).val();
	var newQty = $('#newQty-'+n).val();

	if( !onlyNumber(editOldQty) ){
		alert('Invalid old quantity value.');
		$('#editOldQty-'+n).val('');
		$('#newQty-'+n).val(parseInt(oldQty));
		return false;
	}
	
	if(editOldQty == null || editOldQty == ''){
		$('#newQty-'+n).val(parseInt(oldQty));
		return true;

	}else{
		$('#newQty-'+n).val(parseInt(editOldQty) + parseInt(oldQty));
		return true;

	}

}

$('#submitPartsQtyFormUpdate').click(function(){
	var partsId = $('input:hidden.selectedPartsId').serializeArray();
	var oldQty = $('input:hidden.selectedPartsOldQty').serializeArray();
	var newQty = $('input:text.selectedPartsNewQty').serializeArray();

	$.post('?r=parts/save-updated-parts-qty',{
		partsId : partsId,
		oldQty : oldQty,
		newQty : newQty,

	},function(data){
		var data = jQuery.parseJSON(data);
			
		if( data.status == 'Success' ) {
			alert(data.message);
			window.location.reload();	
		}

	});

});

$('.closeUpdateQtySelectedParts').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-updateqty-selected-parts').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts Update Qty
if( $('._showUpdatePartsQtyModal').length ){

$('._showUpdatePartsQtyModal').each(function(){
	$(this).click(function(){
		
		$('#modal-launcher-update-partsqty').modal({
            backdrop: 'static',
            keyboard: true,
        })

        var partsId = $(this).attr('id');

        $.get("?r=parts/get-data-for-view",{
        	id : partsId,

        },function(data){
        	var data = jQuery.parseJSON(data);		
        	var result = data.result;

        	var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SUPPLIER NAME</b></td>' +
							'<td>'+result.supplier_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>CATEGORY NAME</b></td>' +
							'<td>'+result.parts_category_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PARTS CODE</b></td>' +
							'<td>'+result.parts_code.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PARTS NAME</b></td>' +
							'<td>'+result.parts_name.toUpperCase()+'</td>'
						+'</tr>'+
							'<td><b>QUANTITY</b></td>' +
							'<td>'+'<button type="button" class="btn btn-info btn-xs" onclick="addQty('+partsId+')" style="margin-top: -10px;" ><i class="fa fa-plus-circle"></i></button> '+' <label style="font-size:22px; font-weight: 600;" id="partsQty" >'+result.quantity+'</label> '+' '+	' <button type="button" class="btn btn-info btn-xs" onclick="deductQty('+partsId+')"  style="margin-top: -10px;" ><i class="fa fa-minus-circle"></i></button>'+'</td>'
						+'</tr>'
				+'</table>';

				$('#p-modal-form').find('input:hidden[id=partsId]').val(partsId);
				$('#p-modal-form').find('input:hidden[id=partsOldQty]').val(parseInt(result.quantity));
				$('#p-modal-form').find('input:hidden[id=partsNewQty]').val(parseInt(result.quantity));
				$('#parts_information').html(html);

        });

	});

});

}

function addQty()
{
	var partsOldQty = $('#partsOldQty').val();
	var partsNewQty = $('#partsNewQty').val();
	var totalQty = parseInt(partsNewQty) + parseInt(1);
	
	$('#partsNewQty').val(parseInt(totalQty));
	$('#partsQty').html(parseInt(totalQty));
	return true;
}

function deductQty(id)
{
	var partsOldQty = $('#partsOldQty').val();
	var partsNewQty = $('#partsNewQty').val();
	var totalQty = parseInt(partsNewQty) - parseInt(1);
	
	$('#partsNewQty').val(parseInt(totalQty));
	$('#partsQty').html(parseInt(totalQty));
	return true;
}

$('#modal-submit-partsqty').click(function(){
	var partsId = $('#partsId').val();
	var partsOldQty = $('#partsOldQty').val();
	var partsNewQty = $('#partsNewQty').val();

	$.post('?r=parts/update-stock-quantity',{
		partsId : partsId,
		partsOldQty : partsOldQty,
		partsNewQty : partsNewQty

	},function(data){
		var data = jQuery.parseJSON(data);

		$('#partsId').val('');
		$('#partsOldQty').val('');
		$('#partsNewQty').val('');

		alert(data.message);
		window.location.reload();	

	});

});

$('.closeUpdatePartsQty').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-partsqty').modal('hide');
    	e.preventDefault();
    }
});

// Auto-Parts in Inventory Create //
// $('._showCreatePIModal').click(function(){

// 	$('#modal-launcher-create-pi').modal({
//             show: true,
//             backdrop: 'static',
//             keyboard: false,
//         })

// 	$('form input, textarea').removeClass('inputTxtError');
// 	$('label.error').remove();

// 	$('#parts').val('');	
//     $('#supplier').val('');
// 	$('#quantity').val('');	
//     $('#price').val('');
//     $('.selectedItems').remove();

// });

// $('.add_item').click(function(){
// 	var parts = $('#parts').val();
// 	var supplier = $('#supplier').val();
// 	var quantity = $('#quantity').val();
// 	var price = $('#price').val();

// 	if( quantity == "" || price == "" ) {
// 		alert('Key in quantity and price first.');
// 		return false;
	
// 	}else{

// 		var ctr = $('#ctr').val();

// 		ctr++;

// 		$.post("?r=parts-inventory/insert-item-in-list",{
// 			parts : parts,
// 			supplier : supplier,
// 			quantity : quantity,
// 			price : price,
// 			ctr : ctr,

// 		}, function(data){
// 			$('.insert-in-list').append(data);

// 		});

// 		$('#ctr').val(ctr);
// 		$('#parts').val('');
// 		$('#supplier').val('');
// 		$('#quantity').val('');
// 		$('#price').val('');
		
// 	}

// });

// function editItem(ctr)
// {
// 	$('.edit-button'+ctr).addClass('hidden');
// 	$('.save-button'+ctr).removeClass('hidden');

// 	$('#quantity-in-list-'+ctr).removeAttr('readonly');
// 	$('#price-in-list-'+ctr).removeAttr('readonly');
// }

// function saveItem(ctr)
// {
// 	$('.edit-button'+ctr).removeClass('hidden');
// 	$('.save-button'+ctr).addClass('hidden');

// 	$('#quantity-in-list-'+ctr).attr('readonly',true);
// 	$('#price-in-list-'+ctr).attr('readonly',true);
// }

// function removeItem(ctr)
// {
// 	$('.item-in-list-'+ctr).remove();
// }

// $('#submitPIFormCreate').click(function(){

// 	var suppliers = $('input:hidden.suppliers').serializeArray();
// 	var parts = $('input:hidden.parts').serializeArray();
// 	var quantities = $('input:text.quantities').serializeArray();
// 	var prices = $('input:text.prices').serializeArray();

// 	if( suppliers.length == 0 || parts.length == 0 || quantities.length == 0 || prices.length == 0 ) {
// 		alert('Add item in the list first.');
// 		return false;

// 	}else{
// 			$.post("?r=parts-inventory/create",{
// 			supplier : suppliers,
// 			parts : parts,
// 			quantity : quantities,
// 			price : prices

// 		}, 
// 		function(data) {
// 			var data = jQuery.parseJSON(data);
// 			if( data.status == 'Success') {

// 				$('form input').removeClass('inputTxtError');
// 			    $('label.error').remove();

// 			    $('#modal-launcher-create-pi').toggle('fast');

// 				alert(data.message);
// 				window.location.reload();

// 			} else {

// 				alert('You have an error, please check all the fields.');
// 				return false;

// 			} 

// 		});

// 	}

// });

// Auto-Parts in Inventory Update //
// if( $('._showUpdatePIModal').length ){

// $('._showUpdatePIModal').each(function(){
// 	$(this).click(function(){
	
// 	$('#modal-launcher-update-pi').modal({
//         show: true,
//         backdrop: 'static',
//         keyboard: false,

//     })

// 	$('form input, textarea').removeClass('inputTxtError');
// 	$('label.error').remove();

// 		$.get("?r=parts-inventory/get-data", {
// 			id : $(this).attr('id'),
	
// 		},
// 		function(data){
// 			var data = jQuery.parseJSON(data);
// 			var result = data.result;
// 			if( data.status == 'Success' ) {
// 				$('#piFormUpdate').find('input:hidden[name=id]').val(result.id);
// 				$('#piFormUpdate').find('select[id=updateSupplier]').val(result.supplier_id).change();
// 				$('#piFormUpdate').find('select[id=updateParts]').val(result.parts_id).change();
// 				$('#piFormUpdate').find('input:text[id=updateQuantity]').val(result.quantity);
// 				$('#piFormUpdate').find('input:text[id=updatePrice]').val(parseFloat(result.price).toFixed(2));
// 			}

// 		});
// 	});
// });

// }

// $('#submitPIFormUpdate').click(function(){
// 	var id = $('#id').val();
// 	var supplier = $('#updateSupplier').val();
// 	var parts = $('#updateParts').val();
// 	var quantity = $('#updateQuantity').val();
// 	var price = $('#updatePrice').val();
	
// 	if( !onlyNumber(quantity) ) {
// 		alert('Invalid quantity format.');
// 		quantity.focus();
// 	}

// 	if( !onlyNumber(price) ) {
// 		alert('Invalid price format.');
// 		price.focus();
// 	}

// 	$.post("?r=parts-inventory/update",{
// 		id : id,
// 		supplier : supplier,
// 		parts : parts,
// 		quantity : quantity,
// 		price : price,
		
// 	}, 
// 	function(data) {
// 		var data = jQuery.parseJSON(data);
// 		if( data.status == 'Success') {

// 			$('form input').removeClass('inputTxtError');
// 		    $('label.error').remove();
		    
// 		    $('#id').val('');
// 		    $('#updateSupplier').val('');
// 		    $('#updateParts').val('');
// 		    $('#updateQuantity').val('');
// 		    $('#updatePrice').val('');
// 		    $('#modal-launcher-update-pi').toggle('fast');

// 			alert(data.message);
// 			window.location.reload();

// 		} else {

// 			$('form input').removeClass('inputTxtError');
// 		    $('label.error').remove();

// 			$.each(data.message, function(field, message) {
// 	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
// 	            $('#piFormUpdate').find('input[name="' + 'PartsInventory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
// 	            $('#piFormUpdate').find('select[name="' + 'PartsInventory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
// 	        });
	      
// 	      	var keys = Object.keys(data.message);
// 	      	$('#piFormUpdate').find('input[name="'+ 'PartsInventory[' + keys[0] + ']' +'"]').focus();	
// 	      	return false;

// 		} 

// 	});

// });

// Auto-Parts in Inventory Delete //
// $('.piDeleteColumn').each(function(){

// $(this).click(function() {    
// 	var yes = confirm ("Are you sure you want to delete this record?");
       
// 	if(yes) {
// 		$.post("?r=parts-inventory/delete-column",{
// 			id : $(this).attr('id'),

// 		},
// 		function(data){
// 			var data = jQuery.parseJSON(data);
			
// 			if( data.status == 'Success' ) {
// 				alert(data.message);
// 				window.location.reload();	

// 			}

// 		});
// 	}

// });

// });

// Auto-Parts in Inventory Forms Clear //
// $('#clearPIForms').click(function(){

// 	$('#piFormCreate').find('select[id=supplier]').val('');
// 	$('#piFormCreate').find('select[id=parts]').val('');
// 	$('#piFormCreate').find('input:text[id=quantity]').val('');
// 	$('#piFormCreate').find('input:text[id=price]').val('');
// 	$('#piFormCreate').find('input:hidden[id=ctr]').val('0');
// 	$('.selectedItems').remove();
	
// });

// Product Category Create //
$('._showCreatePRCModal').click(function(){

	$('#modal-launcher-create-prc').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');	
    $('#description').val('');

});

$('#submitPRCFormCreate').click(function(){
	var name = $('#name').val();
	var description = $('#description').val();

	if( !onlyLetter(name) ) {
		alert('Invalid product category name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=product-category/create",{
		name : name,
		description : description,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#name').val('');	
		    $('#description').val('');	
		    $('#modal-launcher-create-prc').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'ProductCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'ProductCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'ProductCategory[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewPrc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-prc').modal('hide');
    	e.preventDefault();
    }
});

// Product Category Update //
if( $('._showUpdatePRCModal').length ){

$('._showUpdatePRCModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-prc').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=product-category/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#prcFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#prcFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
				$('#prcFormUpdate').find('textarea[id=updateDescription]').val(result.description.toUpperCase());
			}

		});
	});
});

}

$('#submitPRCFormUpdate').click(function(){
	var id = $('#id').val();
	var name = $('#updateName').val();
	var description = $('#updateDescription').val();
	
	if( !onlyLetter(name) ) {
		alert('Invalid product category name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=product-category/update",{
		id : id,
		name : name,
		description : description,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateName').val('');
		    $('#updateDescription').val('');
		    $('#modal-launcher-update-prc').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#prcFormUpdate').find('input[name="' + 'ProductCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#prcFormUpdate').find('textarea[name="' + 'ProductCategory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#prcFormUpdate').find('input[name="'+ 'ProductCategory[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdatePrc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-prc').modal('hide');
    	e.preventDefault();
    }
});

// Product Category Delete //
$('.prcDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=product-category/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Product Category View //
if( $('._showViewPRCModal').length ){

$('._showViewPRCModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-prc').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=product-category/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PRODUCT CATEGORY NAME</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>DESCRIPTION</b></td>' +
							'<td>'+result.description.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewPRC').html(html);
			}

		});
	});
});

}

$('.closeViewPrc').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-prc').modal('hide');
    	e.preventDefault();
    }
});

// Product Category Forms Clear //
$('#clearPRCForms').click(function(){

	$('#prcFormCreate').find('input:text[id=name]').val('');
	$('#prcFormCreate').find('textarea[id=description]').val('');

	$('#prcFormUpdate').find('input:hidden[name=id]').val('');
	$('#prcFormUpdate').find('input:text[id=updateName]').val('');
	$('#prcFormUpdate').find('textarea[id=updateDescription]').val('');
	
});

// Product Category View Close //
$('#closePRCForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-prc').modal('hide');
    	e.preventDefault();
    }
});

// Product Create //
$('._showCreateProductModal').click(function(){

	$('#modal-launcher-create-product').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#storageLocation').val('');	
	$('#supplier').val('');	
    $('#productCategory').val('');
    $('#productName').val('');
    $('#quantity').val('');
    $('#uom').val('');
    $('#costPrice').val('');
    $('#reorderLevel').val('');
    $('#gstPrice').val('');
    $('#sellingPrice').val('');

});

$('#submitProductFormCreate').click(function(){
	var storageLocation = $('#storageLocation').val();
	var supplier = $('#supplier').val();
	var productCode = $('#productCode').val();
	var productCategory = $('#productCategory').val();
	var productName = $('#productName').val();
	var quantity = $('#quantity').val();
	var uom = $('#uom').val();
	var costPrice = $('#costPrice').val();
	var reorderLevel = $('#reorderLevel').val();
	var gstPrice = $('#gstPrice').val();
	var sellingPrice = $('#sellingPrice').val();

	if( !onlyLetterAndNumber(productName) ) {
		alert('Invalid product name format.');
		productName.focus();
	}

	if( !onlyLetterAndNumber(uom) ) {
		alert('Invalid unit of measure format.');
		uom.focus();
	}

	if( !onlyNumber(quantity) ) {
		alert('Invalid quantity format.');
		quantity.focus();
	}

	if( !onlyNumber(reorderLevel) ) {
		alert('Invalid re-order level format.');
		reorderLevel.focus();
	}

	if( !onlyNumber(costPrice) ) {
		alert('Invalid cost price format.');
		costPrice.focus();
	}

	if( !onlyNumber(sellingPrice) ) {
		alert('Invalid selling price format.');
		sellingPrice.focus();
	}

	$.post("?r=product/create",{
		storageLocation : storageLocation,
		supplier : supplier,
		productCode : productCode,
		productCategory : productCategory,
		productName : productName,
		quantity : quantity,
		uom : uom,
		costPrice : costPrice,
		reorderLevel : reorderLevel,	
		gstPrice : gstPrice,
		sellingPrice : sellingPrice,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#storageLocation').val('');
		    $('#supplier').val('');
			$('#productCategory').val('');
			$('#productName').val('');
			$('#quantity').val('');
			$('#uom').val('');
			$('#costPrice').val('');
			$('#reorderLevel').val('');
			$('#gstPrice').val('');
			$('#sellingPrice').val('');	
		    $('#modal-launcher-create-product').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'Product[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'Product[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'Product[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeNewProduct').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-product').modal('hide');
    	e.preventDefault();
    }
});

// Product Update //
if( $('._showUpdateProductModal').length ){

$('._showUpdateProductModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-product').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=product/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#productFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#productFormUpdate').find('select[id=updateStorageLocation]').val(result.storage_location_id).change();
				$('#productFormUpdate').find('select[id=updateSupplier]').val(result.supplier_id).change();
				$('#productFormUpdate').find('select[id=updateProductCategory]').val(result.product_category_id).change();
				$('#productFormUpdate').find('input:text[id=updateProductCode]').val(result.product_code.toUpperCase());
				$('#productFormUpdate').find('input:text[id=updateProductName]').val(result.product_name.toUpperCase());
				$('#productFormUpdate').find('input:text[id=updateQuantity]').val(parseInt(result.quantity));
				$('#productFormUpdate').find('input:text[id=updateUom]').val(result.unit_of_measure.toUpperCase());
				$('#productFormUpdate').find('input:text[id=updateCostPrice]').val(parseFloat(result.cost_price).toFixed(2));
				$('#productFormUpdate').find('input:text[id=updateReorderLevel]').val(parseInt(result.reorder_level));
				$('#productFormUpdate').find('input:text[id=updateGstPrice]').val(parseInt(result.gst_price));
				$('#productFormUpdate').find('input:text[id=updateSellingPrice]').val(parseFloat(result.selling_price).toFixed(2));
			}

		});
	});
});

}

$('#submitProductFormUpdate').click(function(){
	var id = $('#id').val();
	var storageLocation = $('#updateStorageLocation').val();
	var supplier = $('#updateSupplier').val();
	var productCode = $('#updateProductCode').val();
	var productCategory = $('#updateProductCategory').val();
	var productName = $('#updateProductName').val();
	var quantity = $('#updateQuantity').val();
	var uom = $('#updateUom').val();
	var costPrice = $('#updateCostPrice').val();
	var reorderLevel = $('#updateReorderLevel').val();
	var gstPrice = $('#updateGstPrice').val();
	var sellingPrice = $('#updateSellingPrice').val();

	if( !onlyLetterAndNumber(productName) ) {
		alert('Invalid product name format.');
		productName.focus();
	}

	if( !onlyLetterAndNumber(uom) ) {
		alert('Invalid unit of measure format.');
		uom.focus();
	}

	if( !onlyNumber(quantity) ) {
		alert('Invalid quantity format.');
		quantity.focus();
	}

	if( !onlyNumber(reorderLevel) ) {
		alert('Invalid re-order level format.');
		reorderLevel.focus();
	}

	if( !onlyNumber(costPrice) ) {
		alert('Invalid cost price format.');
		costPrice.focus();
	}

	if( !onlyNumber(sellingPrice) ) {
		alert('Invalid selling price format.');
		sellingPrice.focus();
	}

	$.post("?r=product/update",{
		id : id,
		storageLocation : storageLocation,
		supplier : supplier,
		productCode : productCode,
		productCategory : productCategory,
		productName : productName,
		quantity : quantity,
		uom : uom,
		costPrice : costPrice,
		reorderLevel : reorderLevel,	
		gstPrice : gstPrice,
		sellingPrice : sellingPrice,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateStorageLocation').val();
			$('#updateSupplier').val();
			$('#updateProductCategory').val();
			$('#updateProductName').val();
			$('#updateQuantity').val();
			$('#updateUom').val();
			$('#updateCostPrice').val();
			$('#updateReorderLevel').val();
			$('#updateGstPrice').val();
			$('#updateSellingPrice').val();
		    $('#modal-launcher-update-product').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#productFormUpdate').find('input[name="' + 'Product[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#productFormUpdate').find('textarea[name="' + 'Product[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#productFormUpdate').find('input[name="'+ 'Product[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateProduct').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-product').modal('hide');
    	e.preventDefault();
    }
});

// Product Delete //
$('.productDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=product/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Product View //
if( $('._showViewProductModal').length ){

$('._showViewProductModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-product').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=product/get-data-for-view", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SUPPLIER NAME</b></td>' +
							'<td>'+result.supplier_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PRODUCT CODE</b></td>' +
							'<td>'+result.product_code.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PRODUCT CATEGORY</b></td>' +
							'<td>'+result.product_category_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PRODUCT NAME</b></td>' +
							'<td>'+result.product_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>UNIT OF MEASURE</b></td>' +
							'<td>'+result.unit_of_measure.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>QUANTITY</b></td>' +
							'<td>'+parseInt(result.quantity)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>RE-ORDER LEVEL</b></td>' +
							'<td>'+parseInt(result.reorder_level)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>COST PRICE</b></td>' +
							'<td>'+parseFloat(result.cost_price).toFixed(2)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>GST PRICE</b></td>' +
							'<td>'+parseInt(result.gst_price)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SELLING PRICE</b></td>' +
							'<td>'+parseFloat(result.selling_price).toFixed(2)+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewProduct').html(html);
			}

		});
	});
});

}

$('.closeViewProduct').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-product').modal('hide');
    	e.preventDefault();
    }
});

// Product Forms Clear //
$('#clearProductForms').click(function(){

	$('#productFormCreate').find('input:text[id=productCode]').val('');
	$('#productFormCreate').find('select[id=productCategory]').val('');
	$('#productFormCreate').find('input:text[id=productName]').val('');
	$('#productFormCreate').find('textarea[id=description]').val('');
	$('#productFormCreate').find('input:text[id=uom]').val('');

	$('#productFormUpdate').find('input:text[id=updateProductCode]').val('');
	$('#productFormUpdate').find('select[id=updateProductCategory]').val('');
	$('#productFormUpdate').find('input:text[id=updateProductName]').val('');
	$('#productFormUpdate').find('textarea[id=updateDescription]').val('');
	$('#productFormUpdate').find('input:text[id=updateUom]').val('');
	
});

// Product View Close //
$('#closeProductForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-product').modal('hide');
    	e.preventDefault();
    }
});

// Product Update Selected Qty
$('._showUpdateQtySelectedProductModal').click(function(){

	if($('.productSelected:checked').length == 0){
		alert('Select Product first.');
		return false;
	}

	$('#modal-launcher-updateqty-selected-product').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('.productSelected:checked').each(function(index, value){
		
		$.get('?r=product/get-selected-productinfo',{
			productId: $(this).val(),

		},function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b><span class="fa fa-cubes"></span> PRODUCT NAME</b></td>' +
							'<td style="text-align:center;" ><b><span class="fa fa-tags"></span> OLD QUANTITY</b></td>' +
							'<td style="text-align:center;" ><b><span class="fa fa-database"></span> NEW QUANTITY</b></td>' 
						+'</tr>'+
						'<tr>'+
							'<td style="width:50%;" >'+
								'<span class="fa fa-gg"> '+result.product_name.toUpperCase()+
								'<input type="hidden" name="productId[]" id="productId-'+ result.id  +'" class="selectedProductId inputForm form-control productId-'+ result.id  +'" value="'+parseInt(result.id)+'" />'+
							'</td>'+
							'<td>'+
								'<input type="text" id="editOldProductQty-'+ result.id  +'" class="inputForm form-control editOldProductQty-'+ result.id  +'" placeholder="0" style="text-align:center;" onchange="updateSelectedProductQty('+ result.id +')" />'+
								'<input type="hidden" name="oldProductQty[]" id="oldProductQty-'+ result.id  +'" class="selectedProductOldQty inputForm form-control oldQty-'+ result.id  +'" value="'+parseInt(result.quantity)+'" />'+
							'</td>'+
							'<td>'+
								'<input type="text" name="newProductQty[]" id="newProductQty-'+ result.id  +'" class="selectedProductNewQty inputForm form-control newProductQty-'+ result.id  +'" value="'+parseInt(result.quantity)+'" readonly="readonly" style="text-align:center;" />'+
							'</td>'
						+'</tr>'+
					'</table>';

				$('#viewSelectedProduct').append(html);
			}

		});

	});
});

function updateSelectedProductQty(n){
	var editOldProductQty = $('#editOldProductQty-'+n).val();
	var oldProductQty = $('#oldProductQty-'+n).val();
	var newProductQty = $('#newProductQty-'+n).val();

	if( !onlyNumber(editOldProductQty) ){
		alert('Invalid old product quantity value.');
		$('#editOldProductQty-'+n).val('');
		$('#newProductQty-'+n).val(parseInt(oldProductQty));
		return false;
	}
	
	if(editOldProductQty == null || editOldProductQty == ''){
		$('#newProductQty-'+n).val(parseInt(oldProductQty));
		return true;

	}else{
		$('#newProductQty-'+n).val(parseInt(editOldProductQty) + parseInt(oldProductQty));
		return true;

	}

}

$('#submitProductQtyFormUpdate').click(function(){
	var productId = $('input:hidden.selectedProductId').serializeArray();
	var oldProductQty = $('input:hidden.selectedProductOldQty').serializeArray();
	var newProductQty = $('input:text.selectedProductNewQty').serializeArray();

	$.post('?r=product/save-updated-product-qty',{
		productId : productId,
		oldProductQty : oldProductQty,
		newProductQty : newProductQty,

	},function(data){
		var data = jQuery.parseJSON(data);
			
		if( data.status == 'Success' ) {
			alert(data.message);
			window.location.reload();	
		}

	});

});

$('.closeUpdateQtySelectedProduct').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-updateqty-selected-product').modal('hide');
    	e.preventDefault();
    }
});

// Product Update Qty
if( $('._showUpdateProductQtyModal').length ){

$('._showUpdateProductQtyModal').each(function(){
	$(this).click(function(){
		
		$('#modal-launcher-update-productqty').modal({
            backdrop: 'static',
            keyboard: true,
        })

        var productId = $(this).attr('id');

        $.get("?r=product/get-data-for-view",{
        	id : productId,

        },function(data){
        	var data = jQuery.parseJSON(data);		
        	var result = data.result;

        	var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>SUPPLIER NAME</b></td>' +
							'<td>'+result.supplier_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>CATEGORY NAME</b></td>' +
							'<td>'+result.product_category_name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PRODUCT CODE</b></td>' +
							'<td>'+result.product_code.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>PRODUCT NAME</b></td>' +
							'<td>'+result.product_name.toUpperCase()+'</td>'
						+'</tr>'+
							'<td><b>QUANTITY</b></td>' +
							'<td>'+'<button type="button" class="btn btn-info btn-xs" onclick="addProductQty('+productId+')" style="margin-top: -10px;" ><i class="fa fa-plus-circle"></i></button> '+' <label style="font-size:22px; font-weight: 600;" id="productQty" >'+result.quantity+'</label> '+' '+	' <button type="button" class="btn btn-info btn-xs" onclick="deductProductQty('+productId+')"  style="margin-top: -10px;" ><i class="fa fa-minus-circle"></i></button>'+'</td>'
						+'</tr>'
				+'</table>';

				$('#product-modal-form').find('input:hidden[id=productId]').val(productId);
				$('#product-modal-form').find('input:hidden[id=productOldQty]').val(parseInt(result.quantity));
				$('#product-modal-form').find('input:hidden[id=productNewQty]').val(parseInt(result.quantity));
				$('#product_information').html(html);

        });

	});

});

}

function addProductQty()
{
	var productOldQty = $('#productOldQty').val();
	var productNewQty = $('#productNewQty').val();
	var totalProductQty = parseInt(productNewQty) + parseInt(1);
	
	$('#productNewQty').val(parseInt(totalProductQty));
	$('#productQty').html(parseInt(totalProductQty));
	return true;
}

function deductProductQty(id)
{
	var productOldQty = $('#productOldQty').val();
	var productNewQty = $('#productNewQty').val();
	var totalProductQty = parseInt(productNewQty) - parseInt(1);
	
	$('#productNewQty').val(parseInt(totalProductQty));
	$('#productQty').html(parseInt(totalProductQty));
	return true;
}

$('#modal-submit-productqty').click(function(){
	var productId = $('#productId').val();
	var productOldQty = $('#productOldQty').val();
	var productNewQty = $('#productNewQty').val();

	$.post('?r=product/update-stock-quantity',{
		productId : productId,
		productOldQty : productOldQty,
		productNewQty : productNewQty

	},function(data){
		var data = jQuery.parseJSON(data);

		$('#productId').val('');
		$('#productOldQty').val('');
		$('#productNewQty').val('');

		alert(data.message);
		window.location.reload();	

	});

});

$('.closeUpdateProductQty').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-productqty').modal('hide');
    	e.preventDefault();
    }
});

// Product in Inventory Create //
// $('._showCreatePRIModal').click(function(){

// 	$('#modal-launcher-create-pri').modal({
//             show: true,
//             backdrop: 'static',
//             keyboard: false,
//         })

// 	$('form input, textarea').removeClass('inputTxtError');
// 	$('label.error').remove();

// 	$('#product').val('');	
//     $('#supplier').val('');
// 	$('#quantity').val('');	
//     $('#price').val('');
//     $('.selectedItems').remove();

// });

// $('._addItem').click(function(){
// 	var product = $('#product').val();
// 	var supplier = $('#supplier').val();
// 	var quantity = $('#quantity').val();
// 	var price = $('#price').val();

// 	if( quantity == "" || price == "" ) {
// 		alert('Key in quantity and price first.');
// 		return false;
	
// 	}else{

// 		var ctr = $('#ctr').val();

// 		ctr++;

// 		$.post("?r=product-inventory/insert-item-in-list",{
// 			product : product,
// 			supplier : supplier,
// 			quantity : quantity,
// 			price : price,
// 			ctr : ctr,

// 		}, function(data){
// 			$('.insert-in-list').append(data);

// 		});

// 		$('#ctr').val(ctr);
// 		$('#product').val('');
// 		$('#supplier').val('');
// 		$('#quantity').val('');
// 		$('#price').val('');
		
// 	}

// });

// function editSelectedItem(ctr)
// {
// 	$('._editButton'+ctr).addClass('hidden');
// 	$('._saveButton'+ctr).removeClass('hidden');

// 	$('#quantity-in-list-'+ctr).removeAttr('readonly');
// 	$('#price-in-list-'+ctr).removeAttr('readonly');
// }

// function saveSelectedItem(ctr)
// {
// 	$('._editButton'+ctr).removeClass('hidden');
// 	$('._saveButton'+ctr).addClass('hidden');

// 	$('#quantity-in-list-'+ctr).attr('readonly',true);
// 	$('#price-in-list-'+ctr).attr('readonly',true);
// }

// function removeSelectedItem(ctr)
// {
// 	$('.item-in-list-'+ctr).remove();
// }

// $('#submitPRIFormCreate').click(function(){

// 	var suppliers = $('input:hidden.suppliers').serializeArray();
// 	var products = $('input:hidden.products').serializeArray();
// 	var quantities = $('input:text.quantities').serializeArray();
// 	var prices = $('input:text.prices').serializeArray();

// 	if( suppliers.length == 0 || products.length == 0 || quantities.length == 0 || prices.length == 0 ) {
// 		alert('Add item in the list first.');
// 		return false;

// 	}else{
// 			$.post("?r=product-inventory/create",{
// 			supplier : suppliers,
// 			products : products,
// 			quantity : quantities,
// 			price : prices

// 		}, 
// 		function(data) {
// 			var data = jQuery.parseJSON(data);
// 			if( data.status == 'Success') {

// 				$('form input').removeClass('inputTxtError');
// 			    $('label.error').remove();

// 			    $('#modal-launcher-create-pri').toggle('fast');

// 				alert(data.message);
// 				window.location.reload();

// 			} else {

// 				alert('You have an error, please check all the fields.');
// 				return false;

// 			} 

// 		});

// 	}

// });

// Product in Inventory Update //
// if( $('._showUpdatePRIModal').length ){

// $('._showUpdatePRIModal').each(function(){
// 	$(this).click(function(){
	
// 	$('#modal-launcher-update-pri').modal({
//         show: true,
//         backdrop: 'static',
//         keyboard: false,

//     })

// 	$('form input, textarea').removeClass('inputTxtError');
// 	$('label.error').remove();

// 		$.get("?r=product-inventory/get-data", {
// 			id : $(this).attr('id'),
	
// 		},
// 		function(data){
// 			var data = jQuery.parseJSON(data);
// 			var result = data.result;
// 			if( data.status == 'Success' ) {
// 				$('#priFormUpdate').find('input:hidden[name=id]').val(result.id);
// 				$('#priFormUpdate').find('select[id=updateSupplier]').val(result.supplier_id).change();
// 				$('#priFormUpdate').find('select[id=updateProduct]').val(result.product_id).change();
// 				$('#priFormUpdate').find('input:text[id=updateQuantity]').val(result.quantity);
// 				$('#priFormUpdate').find('input:text[id=updatePrice]').val(parseFloat(result.price).toFixed(2));
// 			}

// 		});
// 	});
// });

// }

// $('#submitPRIFormUpdate').click(function(){
// 	var id = $('#id').val();
// 	var supplier = $('#updateSupplier').val();
// 	var product = $('#updateProduct').val();
// 	var quantity = $('#updateQuantity').val();
// 	var price = $('#updatePrice').val();
	
// 	if( !onlyNumber(quantity) ) {
// 		alert('Invalid quantity format.');
// 		quantity.focus();
// 	}

// 	if( !onlyNumber(price) ) {
// 		alert('Invalid price format.');
// 		price.focus();
// 	}

// 	$.post("?r=product-inventory/update",{
// 		id : id,
// 		supplier : supplier,
// 		product : product,
// 		quantity : quantity,
// 		price : price,
		
// 	}, 
// 	function(data) {
// 		var data = jQuery.parseJSON(data);
// 		if( data.status == 'Success') {

// 			$('form input').removeClass('inputTxtError');
// 		    $('label.error').remove();
		    
// 		    $('#id').val('');
// 		    $('#updateSupplier').val('');
// 		    $('#updateProduct').val('');
// 		    $('#updateQuantity').val('');
// 		    $('#updatePrice').val('');
// 		    $('#modal-launcher-update-pri').toggle('fast');

// 			alert(data.message);
// 			window.location.reload();

// 		} else {

// 			$('form input').removeClass('inputTxtError');
// 		    $('label.error').remove();

// 			$.each(data.message, function(field, message) {
// 	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
// 	            $('#priFormUpdate').find('input[name="' + 'ProductInventory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
// 	            $('#priFormUpdate').find('select[name="' + 'ProductInventory[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
// 	        });
	      
// 	      	var keys = Object.keys(data.message);
// 	      	$('#priFormUpdate').find('input[name="'+ 'ProductInventory[' + keys[0] + ']' +'"]').focus();	
// 	      	return false;

// 		} 

// 	});

// });

// Product in Inventory Delete //
// $('.priDeleteColumn').each(function(){

// $(this).click(function() {    
// 	var yes = confirm ("Are you sure you want to delete this record?");
       
// 	if(yes) {
// 		$.post("?r=product-inventory/delete-column",{
// 			id : $(this).attr('id'),

// 		},
// 		function(data){
// 			var data = jQuery.parseJSON(data);
			
// 			if( data.status == 'Success' ) {
// 				alert(data.message);
// 				window.location.reload();	

// 			}

// 		});
// 	}

// });

// });

// Product in Inventory Forms Clear //
// $('#clearPRIForms').click(function(){

// 	$('#priFormCreate').find('select[id=supplier]').val('');
// 	$('#priFormCreate').find('select[id=product]').val('');
// 	$('#priFormCreate').find('input:text[id=quantity]').val('');
// 	$('#priFormCreate').find('input:text[id=price]').val('');
// 	$('#priFormCreate').find('input:hidden[id=ctr]').val('0');
// 	$('.selectedItems').remove();
	
// });

// User Permission Create //
$('._showCreateUPModal').click(function(){

	$('#modal-launcher-create-up').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#controllerName').val('');
		    $('#chosenController').val('');	
		    $('#userRole').val('');	
		    $('#methods').prop('unchecked');

});

$('#userRole').change(function(){
    if( $('#controllerName').val() == "0" || $('#controllerName').val() == "CHOOSE CONTROLLER HERE" ) {
        alert('Choose Controller first');
    }else {
        var controllerName = $('#controllerName').val();
        var userRole = $('#userRole').val();

        $.get("?r=user-permission/get-methods",{
        	controllerName: controllerName,
        	userRole : userRole,

        },function(data){

        	var chosenController = controllerName.split('Controller');

			$('#upFormCreate').find('input:hidden[id = selectedControllerName]').val(controllerName);
			$('#upFormCreate').find('input:hidden[id = selectedControllerNameChosen]').val(chosenController[0]);
			$('#upFormCreate').find('input:hidden[id = selectedUserRole]').val(userRole);
			$('#selectedMethods').html(data);

        });
    }
});

$('#controllerName').change(function(){
    if( $('#controllerName').val() == "0" || $('#controllerName').val() == "CHOOSE CONTROLLER HERE" ) {
        alert('Choose Controller in List.');
    }else {
        var controllerName = $('#controllerName').val();
        var userRole = $('#userRole').val();

        $.get("?r=user-permission/get-methods",{
        	controllerName: controllerName,
        	userRole : userRole,

        },function(data){

        	var chosenController = controllerName.split('Controller');

			$('#upFormCreate').find('input:hidden[id = selectedControllerName]').val(controllerName);
			$('#upFormCreate').find('input:hidden[id = selectedControllerNameChosen]').val(chosenController[0]);
			$('#upFormCreate').find('input:hidden[id = selectedUserRole]').val(userRole);
			$('#selectedMethods').html(data);

        });
    }
});

$('#select-all').click(function(event) {   
    $('.chkboxMethods').each(function() {
        this.checked = true;
    
    });
});

$('#submitUPFormCreate').click(function(){
	var controllerName = $('#selectedControllerName').val();
	var chosenController = $('#selectedControllerNameChosen').val();
	var userRole = $('#selectedUserRole').val();
	var methods = $('input:checkbox.chkboxMethods').serializeArray();

	if( methods.length == 0 ) {
		alert('Select Controller actions first.');
	}

	$.post("?r=user-permission/create",{
		controllerName : controllerName,
		chosenController : chosenController,
		userRole : userRole,
		methods : methods,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#controllerName').val('');
		    $('#chosenController').val('');	
		    $('#userRole').val('');	
		    $('#methods').prop('unchecked');
	
			alert(data.message);
			window.location.reload();
		} 

	});

});

$('.closeCreateUp').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-up').modal('hide');
    	e.preventDefault();
    }
});

// User Permission Delete //
$('.upDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=user-permission/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// User Create //
$('._showCreateUserModal').click(function(){

	$('#modal-launcher-create-user').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#role').val('');	
    $('#fullname').val('');
    $('#email').val('');
    $('#username').val('');
    $('#password').val('');
    $('#cpassword').val('');

});

$('#submitUserFormCreate').click(function(){
	var role = $('#role').val();
	var fullname = $('#fullname').val();
	var email = $('#email').val();
	var username = $('#username').val();
	var password = $('#password').val();
	var cpassword = $('#cpassword').val();

	if( cpassword !== password ) {
		alert('Password mismatch.');
		cpassword.focus();
	}

	if( !onlyLetter(fullname) ) {
		alert('Invalid fullname format.');
		fullname.focus();
	}

	if( !onlyForEmail(email) ) {
		alert('Invalid email format.');
		email.focus();
	}

	if( !onlyLetterAndNumber(username) ) {
		alert('Invalid username format.');
		username.focus();
	}

	if( !onlyLetterAndNumber(password) ) {
		alert('Invalid password format.');
		password.focus();
	}

	$.post("?r=user/create",{
		role : role,
		fullname : fullname,
		email : email,
		username : username,
		password : password,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#role').val('');
		    $('#fullname').val('');	
		    $('#email').val('');	
		    $('#username').val('');
		    $('#password').val('');		
		    $('#cpassword').val('');	
		    $('#modal-launcher-create-user').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'User[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'User[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeCreateUser').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-create-user').modal('hide');
    	e.preventDefault();
    }
});

// User Update //
if( $('._showUpdateUserModal').length ){

$('._showUpdateUserModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-user').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=user/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#userFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#userFormUpdate').find('select[id=updateRole]').val(result.role_id).change();
				$('#userFormUpdate').find('input:text[id=updateFullname]').val(result.fullname.toUpperCase());
				$('#userFormUpdate').find('input:text[id=updateEmail]').val(result.email.toUpperCase());
				$('#userFormUpdate').find('input:text[id=updateUsername]').val(result.username.toUpperCase());
				$('#userFormUpdate').find('input:password[id=updatePassword]').val(result.password);
			}

		});
	});
});

}

$('.showChangePassword').click(function()
{
    var chkboxVal = $(this).val();

    if( $(this).prop('checked') == true ) {
		$('#changePassword').show('fast');

	}else{
		$('#changePassword').hide('fast');
		$('#userFormUpdate').find('input:password[id=updateCpassword]').val('');

	}

});

$('#submitUserFormUpdate').click(function(){
	var id = $('#id').val();
	var role = $('#updateRole').val();
	var fullname = $('#updateFullname').val();
	var email = $('#updateEmail').val();
	var username = $('#updateUsername').val();
	var password = $('#updatePassword').val();
	var cpassword = $('#updateCpassword').val();

	if( !onlyLetter(fullname) ) {
		alert('Invalid fullname format.');
		fullname.focus();
	}

	if( !onlyForEmail(email) ) {
		alert('Invalid email format.');
		email.focus();
	}

	if( !onlyLetterAndNumber(username) ) {
		alert('Invalid username format.');
		username.focus();
	}

	if( !onlyLetterAndNumber(password) ) {
		alert('Invalid password format.');
		password.focus();
	}

	$.post("?r=user/update",{
		id : id,
		role : role,
		fullname : fullname,
		email : email,
		username : username,
		password : password,
		
	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#id').val('');
		    $('#updateRole').val('');
		    $('#updateFullname').val('');
		    $('#updateEmail').val('');
		    $('#updateUsername').val('');
		    $('#updatePassword').val('');
		    $('#updateCpassword').val('');
		    $('#modal-launcher-update-user').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#userFormUpdate').find('input[name="' + 'User[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#userFormUpdate').find('input[name="'+ 'User[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

$('.closeUpdateUser').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-update-user').modal('hide');
    	e.preventDefault();
    }
});

// User Delete //
$('.userDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=user/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// User View //
if( $('._showViewUserModal').length ){

$('._showViewUserModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-user').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=user/get-data-for-view", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>USER ROLE</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>FULLNAME</b></td>' +
							'<td>'+result.fullname.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>EMAIL</b></td>' +
							'<td>'+result.email.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>USERNAME</b></td>' +
							'<td>'+result.username.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewUser').html(html);
			}

		});
	});
});

}

$('.closeViewUser').click(function(e){
    if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-user').modal('hide');
    	e.preventDefault();
    }
});

// User Forms Clear //
$('#clearUserForms').click(function(){

	$('#userFormCreate').find('select[id=role]').val('');
	$('#userFormCreate').find('input:text[id=fullname]').val('');
	$('#userFormCreate').find('input:text[id=email]').val('');
	$('#userFormCreate').find('input:text[id=username]').val('');
	$('#userFormCreate').find('input:password[id=password]').val('');
	$('#userFormCreate').find('input:password[id=cpassword]').val('');

	$('#userFormUpdate').find('input:text[id=id]').val('');
	$('#userFormUpdate').find('select[id=updateRole]').val('');
	$('#userFormUpdate').find('input:text[id=updateFullname]').val('');
	$('#userFormUpdate').find('input:text[id=updateEmail]').val('');
	$('#userFormUpdate').find('input:text[id=updateUsername]').val('');
	$('#userFormUpdate').find('input:password[id=updatePassword]').val('');
	$('#userFormUpdate').find('input:password[id=updateCpassword]').val('');
	
});

// User View Close //
$('#closeUserForms').click(function(){
	if( confirm('You want to close this form?') ){	
    	$('#modal-launcher-view-user').modal('hide');
    	e.preventDefault();
    }
});

//======== Utilities ==========//

// Race Create //
$('._showCreateRaceModal').click(function(){

	$('#modal-launcher-create-race').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#name').val('');
	$('#description').val('');

});

$('#submitRaceFormCreate').click(function(){
	var name = $('#name').val();
	var description = $('#description').val();

	if( !onlyLetter(name) ) {
		alert('Invalid name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=race/create",{
		name : name,
		description : description,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();
		    
		    $('#name').val('');	
		    $('#description').val('');	
		    $('#modal-launcher-create-race').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('input[name="' + 'Race[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('textarea[name="' + 'Race[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('input[name="'+ 'Race[' + keys[0] + ']' +'"]').focus();	
	      	$('textarea[name="'+ 'Race[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

// Race Update //
if( $('._showUpdateRaceModal').length ){

$('._showUpdateRaceModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-update-race').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

		$.get("?r=race/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			if( data.status == 'Success' ) {
				$('#raceFormUpdate').find('input:hidden[name=id]').val(result.id);
				$('#raceFormUpdate').find('input:text[id=updateName]').val(result.name.toUpperCase());
				$('#raceFormUpdate').find('textarea[id=updateDescription]').val(result.description.toUpperCase());
			}

		});
	});
});

}

$('#submitRaceFormUpdate').click(function(){
	var id = $('#id').val();
	var name = $('#updateName').val();
	var description = $('#updateDescription').val();

	if( !onlyLetter(name) ) {
		alert('Invalid name format.');
		name.focus();
	}

	if( !onlyLetterAndNumber(description) ) {
		alert('Invalid description format.');
		description.focus();
	}

	$.post("?r=race/update",{
		id : id,
		name : name,
		description : description,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#id').val('');
		    $('#updateName').val('');
		    $('#updateDescription').val('');	
		    $('#modal-launcher-update-race').toggle('fast');

			alert(data.message);
			window.location.reload();

		} else {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

			$.each(data.message, function(field, message) {
	    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';
	            $('#raceFormUpdate').find('input[name="' + 'Race[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	            $('#raceFormUpdate').find('textarea[name="' + 'Race[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
	        });
	      
	      	var keys = Object.keys(data.message);
	      	$('#raceFormUpdate').find('input[name="'+ 'Race[' + keys[0] + ']' +'"]').focus();
	      	$('#raceFormUpdate').find('textarea[name="'+ 'Race[' + keys[0] + ']' +'"]').focus();	
	      	return false;

		} 

	});

});

// Race Delete //
$('.raceDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=race/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location.reload();	

			}

		});
	}

});

});

// Race View //
if( $('._showViewRaceModal').length ){

$('._showViewRaceModal').each(function(){
	$(this).click(function(){
	
	$('#modal-launcher-view-race').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,

    })
		$.get("?r=race/get-data", {
			id : $(this).attr('id'),
	
		},
		function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;
			
			if( parseInt(result.status) === 1 ) {
				var status = 'ACTIVE';
			}else{
				var status = 'INACTIVE';	
			}

			if( data.status == 'Success' ) {
				var html = '<table class="table table-hover table-striped viewTableContent">'+
						'<tr>'+
							'<td><b>ID</b></td>' +
							'<td>'+result.id+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>RACE NAME</b></td>' +
							'<td>'+result.name.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>RACE DESCRIPTION</b></td>' +
							'<td>'+result.description.toUpperCase()+'</td>'
						+'</tr>'+
						'<tr>'+
							'<td><b>STATUS</b></td>' +
							'<td>'+status+'</td>'
						+'</tr>'
				+'</table>';

				$('#viewRace').html(html);
			}

		});
	});
});

}

// Race Forms Clear //
$('#clearRaceForms').click(function(){

	$('#raceFormCreate').find('input:text[id=name]').val('');
	$('#raceFormCreate').find('textarea[id=description]').val('');

	$('#raceFormUpdate').find('input:text[id=updateName]').val('');
	$('#raceFormUpdate').find('textarea[id=updateDescription]').val('');

});

// Race View Close //
$('#closeRaceForms').click(function(){

	$('#modal-launcher-view-race').toggle('fast');
	window.location.reload();

});


//======= Form Validations =======//

function onlyLetter(element)
{
	var alpha = /^[a-zA-Z\s\.\-]*$/;
	
	if(element.match(alpha)) {
		return true;
	}else{
		return false;
	}
}

function onlyLetterAndNumber(element)
{
	var alphanum = /^[a-zA-Z0-9\s\.\#\-\,]*$/;
	
	if(element.match(alphanum)) {
		return true;
	}else{
		return false;
	}
}

function onlyNumber(element)
{
	var num = /^[0-9\+\-\s]*$/;
	
	if(element.match(num)) {
		return true;
	}else{
		return false;
	}
}

function onlyForEmail(element)
{
	var email = /^[a-zA-Z0-9\s\@\_\.\-]*$/;
	
	if(element.match(email)) {
		return true;
	}else{
		return false;
	}
}

