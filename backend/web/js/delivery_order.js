var domain ="http://"+document.domain;

//============== Create Customer by Delivery ================//

$('._showCreateCustomerByDeliveryOrderModal').click(function(){

	$('#modal-launcher-create-customerbydeliverorder').modal({
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

$('#submitCustomerFormCreateByDeliveryOrder').click(function(){
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

		$.post("?r=delivery-order/create-company",{
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
				window.location = domain + '?r=delivery-order/create-delivery-order&id='+ data.id;

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

		$.post("?r=delivery-order/create-customer",{
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
				window.location = domain + '?r=delivery-order/create-delivery-order&id='+ data.id;

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

//============== Delivery Order Create ================//

$('._showCreateDeliveryOrderModal').click(function(){

	$('#modal-launcher-create-deliveryorder').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#deliveryorderFormCreate').find('select[id=deliveryorderCustomerName]').val('0').change();
	$('#deliveryorderFormCreate').find('select[id=sales_person]').val('0').change();
	$('#deliveryorderFormCreate').find('textarea[id=remarks]').val('');
	$('#deliveryorderFormCreate').find('input:text[id=grandTotal]').val('');
	$('#deliveryorderFormCreate').find('input:hidden[id=gst_amount]').val('');
	$('#deliveryorderFormCreate').find('input:text[id=gst]').val('');
	$('#deliveryorderFormCreate').find('input:text[id=netTotal]').val('');
	$('#deliveryorderFormCreate').find('select[id=parts]').val('0').change();
	$('#deliveryorderFormCreate').find('input:text[id=partsQty]').val('');
	$('#deliveryorderFormCreate').find('input:text[id=partsPrice]').val('');
	$('#deliveryorderFormCreate').find('input:text[id=partsSubtotal]').val('');
	$('#deliveryorderFormCreate').find('select[id=services]').val('0').change();
	$('#deliveryorderFormCreate').find('input:text[id=servicesQty]').val('');
	$('#deliveryorderFormCreate').find('input:text[id=servicesPrice]').val('');
	$('#deliveryorderFormCreate').find('input:text[id=servicesSubtotal]').val('');

});

$('.closeDeliveryOrder').click(function(e){
    if( confirm('Are you want to close this Delivery Order Form?') ){	
    	$('#modal-launcher-create-deliveryorder').modal('hide');
    	e.preventDefault();
    }
});

//========== Get Customer Information ==========//

$('#deliveryorderCustomerName').change(function(){
	var customerId = $(this).val();

	$.get('?r=delivery-order/get-customer-information',{
		customerId : customerId,

	}, function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		if( result.type == 1 ){ 

            var html = '<table class="table table-hover table-striped viewTableContent">'+
                        '<tr>'+
                            '<td><b>COMPANY NAME</b></td>' +
                            '<td>'+result.company_name.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>UEN NUMBER</b></td>' +
                            '<td>'+result.uen_no.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>CONTACT PERSON</b></td>' +
                            '<td>'+result.fullname.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>ADDRESS</b></td>' +
                            '<td>'+result.address.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>SHIPPING ADDRESS</b></td>' +
                            '<td>'+result.shipping_address.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>EMAIL</b></td>' +
                            '<td>'+result.email.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>PHONE NUMBER</b></td>' +
                            '<td>'+result.phone_number+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>OFFICE NUMBER</b></td>' +
                            '<td>'+result.mobile_number+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>FAX NUMBER</b></td>' +
                            '<td>'+result.fax_number+'</td>'+
                        '</tr>'+
                    '</table>';
                        
        }else{

            var html = '<table class="table table-hover table-striped viewTableContent">'+
                        '<tr>'+
                            '<td><b>CUSTOMER FULLNAME</b></td>' +
                            '<td>'+result.fullname.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>NRIC NUMBER</b></td>' +
                            '<td>'+result.nric.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>ADDRESS</b></td>' +
                            '<td>'+result.address.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>SHIPPING ADDRESS</b></td>' +
                            '<td>'+result.shipping_address.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>EMAIL</b></td>' +
                            '<td>'+result.email.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>PHONE NUMBER</b></td>' +
                            '<td>'+result.phone_number+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>OFFICE NUMBER</b></td>' +
                            '<td>'+result.mobile_number+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>FAX NUMBER</b></td>' +
                            '<td>'+result.fax_number+'</td>'+
                        '</tr>'+
                    '</table>';

        }

        $('#delivery-order-customer-information').html(html);

	}); 

}); 

//=========== Auto-Parts ===========//

function getPartsPriceAndQtyDeliveryOrder()
{
	var partsId = $('#parts').val();

	if(partsId == 0){

		$('#partsQty').val('');
		$('#currentQtyValue').val('');
		$('#currentQty').html(parseInt(0));
		$('#partsPrice').val('');
		$('#partsSubtotal').val('');
		return false;

	}else{

		$.get("?r=delivery-order/get-parts-price-and-qty",{
			parts_id : partsId,

		},function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;

			if( data.status == 'success') {
				var qty = result.quantity;
				var price = result.selling_price;
				
				$('#currentQty').html(parseInt(qty));
				$('#currentQtyValue').val(parseInt(qty));
				$('#partsPrice').val(parseInt(price));
				
			}else{
				return false;
			}
		});

	}
}

function updatePartsSubtotalDeliveryOrder()
{
	var partsQty = $('#partsQty').val();
	var currentPartsQty = $('#currentQtyValue').val();
	var partsPrice = $('#partsPrice').val();
	
	$('#currentQty').html(parseInt(currentPartsQty) - parseInt(partsQty));

	if( !onlyNumber(partsQty) ) {
		alert('Invalid auto-parts quantity format.');
		partsQty.focus();
	}

	var total = parseFloat(partsQty) * parseFloat(partsPrice);
	$('#partsSubtotal').val(parseFloat(total).toFixed(2));
}

$('.add_autoparts_deliveryorder').click(function(){
	var partsId = $('#parts').val();
	var partsQty = $('#partsQty').val();
	var partsPrice = $('#partsPrice').val();
	var partsSubtotal = $('#partsSubtotal').val();

	if(partsQty == '' || partsPrice == '' || partsQty == null || partsPrice == null){
		alert('Key in quantity and price first.');
		return false;
	
	}else{

		if( !onlyNumber(partsQty) ) {
			alert('Invalid auto-parts quantity format.');
			partsQty.focus();
		}

		var ctr = $('#ctr').val();
		ctr++;

		$.post("?r=delivery-order/insert-auto-parts-in-list",{
		parts_id : partsId,
		parts_qty : partsQty,
		parts_price : partsPrice,
		parts_subtotal : partsSubtotal,
		ctr : ctr,

		},function(data){
			$('#insert-item-in-list').append(data);

			$('#ctr').val(ctr);
			$('#parts').val(0).change();
			$('#partsQty').val('');
			$('#currentQtyValue').val('');
			$('#currentQty').html(parseInt(0));
			$('#partsPrice').val('');
			$('#partsSubtotal').val('');

			setTimeout(function() {
                getDeliveryOrderTotal();
            }, 500);

		});

	}

});

//=========== Services ===========//

function getServicesPriceAndQtyDeliveryOrder()
{
	var servicesId = $('#services').val();

	$.get("?r=delivery-order/get-services-price-and-qty",{
		services_id : servicesId,

	},function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		if( data.status == 'success') {
			var qty = 1;
			var serviceCategory = '[ '+result.name+' ]';
			var serviceName = result.service_name;
			var price = result.price;
			var total = parseFloat(qty) * parseFloat(price);

			$('#serviceCategory').val(serviceCategory.toUpperCase());
			$('#editFormServiceDetails').val(serviceName);
			$('#servicesQty').val(parseInt(qty));
			$('#servicesPrice').val(parseInt(price));
			$('#servicesSubtotal').val(parseFloat(total).toFixed(2));

		}else{
			return false;
		}
	});
}

function updateServiceDetailsDeliveryOrder()
{
	var servicesId = $('#services').val();

	if( servicesId == '0'){
		alert('Key in services first.');

	}else{
		
		$('#saveServiceDetailsBtn').removeClass('hidden');
		$('#editFormServiceDetails').removeClass('hidden');
		$('#editServiceDetailsBtn').addClass('hidden');

	}
}

function saveServiceDetailsDeliveryOrder()
{
	var servicesId = $('#services').val();
	var serviceCategory = $('#serviceCategory').val();
	var servicesDetails = $('#editFormServiceDetails').val();

	if( servicesId == '' || servicesDetails == ''){
		alert('Key in service details first.');

	}else{
		
		$.post("?r=delivery-order/save-service-details",{
			service_id : servicesId,
			service_details : servicesDetails,

		},function(data){

			$('#saveServiceDetailsBtn').addClass('hidden');
			$('#editFormServiceDetails').addClass('hidden');
			$('#editServiceDetailsBtn').removeClass('hidden');

			$('#services option:selected').detach();
			$('#services').append("<option value="+ servicesId +">" + serviceCategory +  ' ' + servicesDetails + "</option>")
			$('#services').val(servicesId).change();

		});

	}
}

function updateServicesSubtotalDeliveryOrder()
{
	var servicesQty = $('#servicesQty').val();
	var servicesPrice = $('#servicesPrice').val();

	if( !onlyNumber(servicesQty) ) {
		alert('Invalid service quantity format.');
		servicesQty.focus();
	}

	if( !onlyNumber(servicesPrice) ) {
		alert('Invalid service unit-price format.');
		servicesPrice.focus();
	}

	var total = parseFloat(servicesQty) * parseFloat(servicesPrice);
	$('#servicesSubtotal').val(parseFloat(total).toFixed(2));
}

$('.add_services_deliveryorder').click(function(){
	var servicesId = $('#services').val();
	var servicesQty = $('#servicesQty').val();
	var servicesPrice = $('#servicesPrice').val();
	var servicesSubtotal = $('#servicesSubtotal').val();

	if(servicesQty == '' || servicesPrice == ''){
		alert('Key in quantity and price first.');
		return false;
	
	}else{

		if( !onlyNumber(servicesQty) ) {
			alert('Invalid service quantity format.');
			servicesQty.focus();
		}

		if( !onlyNumber(servicesPrice) ) {
			alert('Invalid service unit-price format.');
			servicesPrice.focus();
		}

		var ctr = $('#ctr').val();
		ctr++;

		$.post("?r=delivery-order/insert-services-in-list",{
		services_id : servicesId,
		services_qty : servicesQty,
		services_price : servicesPrice,
		services_subtotal : servicesSubtotal,
		ctr : ctr,

		},function(data){
			$('#insert-item-in-list').append(data);

			$('#ctr').val(ctr);
			$('#services').val(0).change();
			$('#servicesQty').val('');
			$('#servicesPrice').val('');
			$('#servicesSubtotal').val('');

			setTimeout(function() {
                getInvoiceTotal();
            }, 500);

		});

	}

});

//=========== Selected Insert Parts & Services ===========//

function editSelectedDeliveryOrderItem(n)
{
	$('.selectedItemInLabel-'+n).addClass('hidden');
	$('.selectedItemInInputbox-'+n).removeClass('hidden');

	$('.save-button-'+n).removeClass('hidden');
	$('.edit-button-'+n).addClass('hidden');
}

function updateSelectedSubtotalDeliveryOrder(n)
{
	var qty = $('#parts-services-qty-in-list-'+n).val();
	var price = $('#parts-services-price-in-list-'+n).val();
	
	if( !onlyNumber(qty) ) {
		alert('Invalid item quantity format.');
		qty.focus();
	}

	if( !onlyNumber(price) ) {
		alert('Invalid item unit-price format.');
		price.focus();
	}

	var total = parseFloat(qty) * parseFloat(price);

	$('#parts-services-subtotal-in-list-'+n).val(parseFloat(total).toFixed(2));

	setTimeout(function(){
            getDeliveryOrderTotal();
        }, 500);
}

function saveSelectedDeliveryOrderItem(n)
{
	var inputboxQty = $('#parts-services-qty-in-list-'+n).val();
	var inputboxPrice = $('#parts-services-price-in-list-'+n).val();
	var inputboxSubtotal = $('#parts-services-subtotal-in-list-'+n).val();
	
	if( !onlyNumber(inputboxQty) ) {
		alert('Invalid item quantity format.');
		inputboxQty.focus();
	}

	if( !onlyNumber(inputboxPrice) ) {
		alert('Invalid item unit-price format.');
		inputboxPrice.focus();
	}

	$('#inlabel-quantity-'+n).html(inputboxQty);
	$('#inlabel-unitprice-'+n).html(inputboxPrice);
	$('#inlabel-subtotal-'+n).html(inputboxSubtotal);

	$('.selectedItemInInputbox-'+n).addClass('hidden');
	$('.selectedItemInLabel-'+n).removeClass('hidden');

	$('.edit-button-'+n).removeClass('hidden');
	$('.save-button-'+n).addClass('hidden');
}

function removeSelectedDeliveryOrderItem(n)
{
	$('.inserted-item-in-list-'+n).detach();

	setTimeout(function(){
            getDeliveryOrderTotal();
        }, 500);
}

function getDeliveryOrderTotal()
{
	var total = 0;

	$('.partsservicesSubtotal').each(function(){
		total += parseFloat($(this).val());
    })

    $('#grandTotal').val(total.toFixed(2));
    setTimeout(function(){
            getDeliveryOrderNetTotal();
        }, 500);
}

function getDeliveryOrderNetTotal()
{
	var grandTotal = $('#grandTotal').val();
	var gst = $('#gst').val();
	var discountPrice = $('input:text[id=discountAmount]').val();

	if(gst == '' || gst == null){
		gst = 0;
	}else{
		gst = gst;
	}

	var totalwithGst = parseFloat(grandTotal) * parseFloat(gst);
	totalwithGst /= 100;
	$('#gst_amount').val(parseFloat(totalwithGst).toFixed(2));

	var netTotal = parseFloat(grandTotal) + parseFloat(totalwithGst);

	if(discountPrice == ''){
       var discount = 0; 
    }else{
        var discount = discountPrice;
    }

    var net_with_disc = parseFloat(netTotal) - parseFloat(discount);
	$('#netTotal').val(parseFloat(net_with_disc).toFixed(2));

}

// ==================== Delivery Order Discount ==================== //

$('#btnDiscount').click(function(){

    $('#discountRemarks').removeAttr('readonly');
    $('#discountAmount').removeAttr('readonly');
    $('#btnDiscount').addClass('hidden');
    $('.submitDiscount').removeClass('hidden');
    $('.clearDiscount').removeClass('hidden');

});

$('#submitDiscount').click(function(){
    var discountDescription = $('textarea[id=discountRemarks]').val();
    var discountPrice = $('input:text[id=discountAmount]').val();
    var salesPerson = $('#sales_person').val();
    var grand_total =  $('#grandTotal').val();

    if( discountDescription == '' || discountPrice == '' ) {
        alert('Please key the discount fields first.');
        return false;
    
    }else if(salesPerson == 0){
        alert('Please key sales person first.');
        $('#discountAmount').val('');   
        $('#discountRemarks').val('');
        return false;

    }else if(grand_total == '0.00'){
        alert('Please key auto-parts or services first.');
        $('#discountAmount').val('');   
        $('#discountRemarks').val('');
        return false;

    }else{

        if( !onlyNumber(discountPrice) ) {
            alert('Invalid discount amount format.');
            discountPrice.focus();
        }

        if( !onlyLetterAndNumber(discountDescription) ) {
            alert('Invalid discount remarks format.');
            discountDescription.focus();
        }

        var total = 0;

		$('.partsservicesSubtotal').each(function(){
			total += parseFloat($(this).val());
	    })

	    $('#grandTotal').val(total.toFixed(2));

        var grandTotal = $('#grandTotal').val();
		var gst = $('#gst').val();
		var totalWithGst = total * $('#gst').val();

		if(gst == '' || gst == null){
			gst = 0;
		}else{
			gst = gst;
		}

		var totalwithGst = parseFloat(grandTotal) * parseFloat(gst);
		totalwithGst /= 100;
		$('#gst_amount').val(parseFloat(totalwithGst).toFixed(2));

		var netTotal = parseFloat(grandTotal) + parseFloat(totalwithGst);

		if(discountPrice == ''){
	       var discount = 0; 
	    }else{
	        var discount = discountPrice;
	    }

	    var net_with_disc = parseFloat(netTotal) - parseFloat(discount);
		$('#netTotal').val(parseFloat(net_with_disc).toFixed(2));

        $('#discountRemarks').attr('readonly', true);
        $('#discountAmount').attr('readonly', true);
        $('#btnDiscount').removeClass('hidden');
        $('.submitDiscount').addClass('hidden');
        $('.clearDiscount').addClass('hidden');
    }

});

$('#clearDiscount').click(function(){

    $('#discountRemarks').val('');
    $('#discountAmount').val('');    
    $('#discountRemarks').attr('readonly', true);
    $('#discountAmount').attr('readonly', true);
    $('#btnDiscount').removeClass('hidden');
    $('.submitDiscount').addClass('hidden');
    $('.clearDiscount').addClass('hidden');
        
});

// ====================== Submit Delivery Order ====================== //

$('#submitDeliveryOrderForm').click(function(){

	var deliveryorderCode = $('#deliveryorderFormCreate').find('input:text[id=delivery_order_code]').val();
	var salesPerson = $('#deliveryorderFormCreate').find('select[id=sales_person]').val();
	var paymentType = $('#deliveryorderFormCreate').find('select[id=paymentType]').val();
	var remarks = $('#deliveryorderFormCreate').find('textarea[id=remarks]').val();
	var dateIssue = $('input:text.date_issue').val();
	var customerName = $('#deliveryorderFormCreate').find('select[id=deliveryorderCustomerName]').val();
	var grandTotal = $('#deliveryorderFormCreate').find('input:text[id=grandTotal]').val();
	var gst_amount = $('#deliveryorderFormCreate').find('input:hidden[id=gst_amount]').val();
	var gst_value = $('#deliveryorderFormCreate').find('input:text[id=gst]').val();
	var netTotal = $('#deliveryorderFormCreate').find('input:text[id=netTotal]').val();
	var discountAmount = $('#deliveryorderFormCreate').find('input:text[id=discountAmount]').val();
	var discountRemarks = $('#deliveryorderFormCreate').find('textarea[id=discountRemarks]').val();

	var parts_services = $('input:hidden.partsservicesName').serializeArray();
	var parts_services_qty = $('input:text.partsservicesQty').serializeArray();
	var parts_services_price = $('input:text.partsservicesPrice').serializeArray();
	var parts_services_subtotal = $('input:text.partsservicesSubtotal').serializeArray();

	if(customerName == '0' || salesPerson == '0' ){
		alert('Invalid Customer Name or Sales Person Selected.');
		return false;

	}else{

		if(discountAmount == null || discountAmount == ''){
			var discount_amount = 0;
		
		}else{
			var discount_amount = discountAmount;

		}

		if(discountRemarks == null || discountRemarks == ''){
			var discount_remarks = 'No discount remarks';
		
		}else{
			var discount_remarks = discountRemarks;

		}

		$.post("?r=delivery-order/create",{
			deliveryorderCode : deliveryorderCode,
			salesPerson: salesPerson,
			paymentType : paymentType,
			remarks : remarks,
			dateIssue : dateIssue,
			customerName : customerName,
			grandTotal : grandTotal,
			gst_amount : gst_amount,
			gst_value : gst_value,
			netTotal : netTotal,
			discountAmount : discount_amount,
			discountRemarks : discount_remarks,
			parts_services : parts_services,
			parts_services_qty : parts_services_qty,
			parts_services_price : parts_services_price,
			parts_services_subtotal : parts_services_subtotal,

		},function(data){

			var data = jQuery.parseJSON(data);
			if( data.status == 'Success') {

				$('form input').removeClass('inputTxtError');
			    $('label.error').remove();

			    $('.insert-item-in-list').remove();

				alert(data.message);
				window.location = domain + '?r=delivery-order/view&id=' + data.id;

			} else {

				$('form input').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';

		            $('select[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError');
		            $('textarea[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('input[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('select[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();
		      	$('textarea[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();
		      	$('input[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}

});

// ====================== Submit Delivery Order For Customer Created ====================== //

$('#submitDeliveryOrderFormFromCustomer').click(function(){

	var deliveryorderCode = $('#deliveryorderFormCreate').find('input:text[id=delivery_order_code]').val();
	var salesPerson = $('#deliveryorderFormCreate').find('select[id=sales_person]').val();
	var paymentType = $('#deliveryorderFormCreate').find('select[id=paymentType]').val();
	var remarks = $('#deliveryorderFormCreate').find('textarea[id=remarks]').val();
	var dateIssue = $('input:text.date_issue').val();
	var customerName = $('#deliveryorderFormCreate').find('input:hidden[id=customer]').val();
	var grandTotal = $('#deliveryorderFormCreate').find('input:text[id=grandTotal]').val();
	var gst_amount = $('#deliveryorderFormCreate').find('input:hidden[id=gst_amount]').val();
	var gst_value = $('#deliveryorderFormCreate').find('input:text[id=gst]').val();
	var netTotal = $('#deliveryorderFormCreate').find('input:text[id=netTotal]').val();
	var discountAmount = $('#deliveryorderFormCreate').find('input:text[id=discountAmount]').val();
	var discountRemarks = $('#deliveryorderFormCreate').find('textarea[id=discountRemarks]').val();

	var parts_services = $('input:hidden.partsservicesName').serializeArray();
	var parts_services_qty = $('input:text.partsservicesQty').serializeArray();
	var parts_services_price = $('input:text.partsservicesPrice').serializeArray();
	var parts_services_subtotal = $('input:text.partsservicesSubtotal').serializeArray();

	if(customerName == '0' || salesPerson == '0' ){
		alert('Invalid Customer Name or Sales Person Selected.');
		return false;

	}else{

		if(discountAmount == null || discountAmount == ''){
			var discount_amount = 0;
		
		}else{
			var discount_amount = discountAmount;

		}

		if(discountRemarks == null || discountRemarks == ''){
			var discount_remarks = 'No discount remarks';
		
		}else{
			var discount_remarks = discountRemarks;

		}

		$.post("?r=delivery-order/create",{
			deliveryorderCode : deliveryorderCode,
			salesPerson: salesPerson,
			paymentType : paymentType,
			remarks : remarks,
			dateIssue : dateIssue,
			customerName : customerName,
			grandTotal : grandTotal,
			gst_amount : gst_amount,
			gst_value : gst_value,
			netTotal : netTotal,
			discountAmount : discount_amount,
			discountRemarks : discount_remarks,
			parts_services : parts_services,
			parts_services_qty : parts_services_qty,
			parts_services_price : parts_services_price,
			parts_services_subtotal : parts_services_subtotal,

		},function(data){

			var data = jQuery.parseJSON(data);
			if( data.status == 'Success') {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

			    $('.insert-item-in-list').remove();

				alert(data.message);
				window.location = domain + '?r=delivery-order/view&id=' + data.id;

			} else {

				$('form input').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';

		            $('select[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError');
		            $('textarea[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('input[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('select[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();
		      	$('textarea[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();
		      	$('input[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}

});

//============== Delivery Order Update ================//

$('._showUpdateDeliveryOrderModal').click(function(){

	$('#modal-launcher-update-delivery-order').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	var id = $(this).attr('id');

	$.get("?r=delivery-order/get-data",{
		id : id,

	},function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		$('#deliveryorderFormUpdate').find('input:hidden[id=delivery_order_id]').val(id);
		$('#deliveryorderFormUpdate').find('input:text[id=update_delivery_order_code]').val(result.delivery_order_code);
		$('#deliveryorderFormUpdate').find('select[id=update_sales_person]').val(result.user_id).change();
		$('#deliveryorderFormUpdate').find('select[id=update_paymentType]').val(result.payment_type_id).change();
		$('#deliveryorderFormUpdate').find('textarea[id=update_remarks]').val(result.remarks.toUpperCase());
		$('#deliveryorderFormUpdate').find('input:text.update_date_issue').val(result.date_issue);
		$('#deliveryorderFormUpdate').find('select[id=update_customer]').val(result.customer_id).change();

		$('#deliveryorderFormUpdate').find('input:text[id=update_grandTotal]').val(parseFloat(result.grand_total).toFixed(2));
		$('#deliveryorderFormUpdate').find('input:text[id=update_gst]').val(parseInt(result.gst_value));
		$('#deliveryorderFormUpdate').find('input:hidden[id=update_gst_amount]').val(parseFloat(result.gst).toFixed(2));
		$('#deliveryorderFormUpdate').find('input:text[id=update_netTotal]').val(parseFloat(result.net).toFixed(2));

		if(result.discount_amount == 0 || result.discount_amount == null || result.discount_amount == ''){
			var discountAmount = '';

		}else{
			var discountAmount = parseInt(result.discount_amount);

		}

		if(result.discount_remarks == 0 || result.discount_remarks == null || result.discount_remarks == 'NO DISCOUNT REMARKS'){
			var discountRemarks = '';

		}else{
			var discountRemarks = result.discount_remarks.toUpperCase();

		}

		$('#deliveryorderFormUpdate').find('input:text[id=update_discountAmount]').val(discountAmount);
		$('#deliveryorderFormUpdate').find('textarea[id=update_discountRemarks]').val(discountRemarks);

		if( result.type == 1 ){
            
            var html =  '<table class="table table-hover table-striped viewTableContent">'+
                            '<tr>'+
                                '<td><b>COMPANY NAME</b></td>' +
                                '<td>'+result.company_name.toUpperCase()+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>UEN NUMBER</b></td>' +
                                '<td>'+result.uen_no.toUpperCase()+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>CONTACT PERSON</b></td>' +
                                '<td>'+result.fullname.toUpperCase()+'</td>'
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
                                '<td><b>EMAIL</b></td>' +
                                '<td>'+result.email.toUpperCase()+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>PHONE NUMBER</b></td>' +
                                '<td>'+result.phone_number+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>OFFICE NUMBER</b></td>' +
                                '<td>'+result.mobile_number+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>FAX NUMBER</b></td>' +
                                '<td>'+result.fax_number+'</td>'
                            +'</tr>'+
                        '</table>';

        }else{

            var html = '<table class="table table-hover table-striped viewTableContent">'+
                            '<tr>'+
                                '<td><b>CONTACT PERSON</b></td>' +
                                '<td>'+result.fullname.toUpperCase()+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>NRIC NUMBER</b></td>' +
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
                                '<td><b>EMAIL</b></td>' +
                                '<td>'+result.email.toUpperCase()+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>PHONE NUMBER</b></td>' +
                                '<td>'+result.phone_number+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>OFFICE NUMBER</b></td>' +
                                '<td>'+result.mobile_number+'</td>'
                            +'</tr>'+
                            '<tr>'+
                                '<td><b>FAX NUMBER</b></td>' +
                                '<td>'+result.fax_number+'</td>'
                            +'</tr>'+
                        '</table>';
        }

        $('#update-delivery-order-customer-information').html(html);

		var parts = data.parts;
		var partslen = parts.length;

		$.each(parts, function(key, pvalue){

			var parts_id = pvalue['id'];
			var parts_name = pvalue['name'];
			var description = pvalue['description'];
			var parts_quantity = pvalue['quantity'];
			var parts_unit_price = pvalue['unit_price'];
			var parts_sub_total = pvalue['sub_total'];

			var parts_html = '<div class="row selectedItemListDesign update-item-in-list-'+ parts_id +' ">'+
									'<div class="col-md-6"></div>'+
									'<div class="col-md-6">'+
										'<div style="text-align: right;">'+
											'<span class="edit-button update-button-'+ parts_id +' ">'+
								                '<a href="javascript:updateSelectedDeliveryOrderItem('+ parts_id +')" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>'+
								            '</span>'+
								            '&nbsp;'+
								            '<span class="save-button hidden save-update-button-'+ parts_id +' ">'+
								                '<a href="javascript:saveUpdateSelectedDeliveryOrderItem('+ parts_id +')" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>'+
								            '</span>'+
								            '&nbsp;'+
								            '<span class="remove-button remove-update-button-'+ parts_id +' ">'+
								                '<a href="javascript:removeUpdateSelectedDeliveryOrderItem('+ parts_id +')" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>'+
								            '</span>'+	
										'</div>'+
									'</div>'+
								'</div>'+
								'<div class="row selectedItemListDesign update-item-in-list-'+ parts_id +' selectedUpdateItemInLabel-'+ parts_id +' ">'+
									'<div class="col-md-3 selectedPartsAndServicesFontSize" >'+
										'<span class="selectedPartsAndServices" >'+ parts_name.toUpperCase() +'</span>'+
									'</div>'+
									'<div class="col-md-3 selectedPartsAndServicesFontSize" >'+
										'<span class="selectedPartsAndServices" id="inlabel-update-quantity-'+ parts_id + '">' + parts_quantity +'</span>'+
									'</div>'+
									'<div class="col-md-3 selectedPartsAndServicesFontSize" >'+
										'<span class="selectedPartsAndServices" id="inlabel-update-unitprice-'+ parts_id +'">' + parts_unit_price +'</span>'+
									'</div>'+
									'<div class="col-md-3 selectedPartsAndServicesFontSize" >'+
										'<span class="selectedPartsAndServices" id="inlabel-update-subtotal-'+ parts_id +'">' + parts_sub_total +'</span>'+
									'</div>'+
								'<br/><hr/>'+
								'</div>'+
								'<div class="row hidden selectedItemListDesign update-item-in-list-'+ parts_id +' selectedUpdateItemInInputbox-'+ parts_id +' ">'+
									'<div class="col-md-3">'+
											'<input type="text" id="parts-services-update-name-in-list-'+ parts_id +'" value="'+ parts_name.toUpperCase() +'" class="inputForm inputboxTotalAlignment form-control" readonly="readonly" />'+

											'<input type="hidden" id="parts-services-update-id-in-list-'+ parts_id +'" value="1-'+ description +'" name="DeliveryOrderDetail[description][]" class="inputForm form-control update_partsservicesName" />'+		
										'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-qty-in-list-'+ parts_id +'" value="'+ parts_quantity +'" name="DeliveryOrderDetail[quantity][]" onchange="editSelectedSubtotal('+ parts_id +')" class="inputForm inputboxTotalAlignment form-control update_partsservicesQty" />'+	
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-price-in-list-'+ parts_id +'" value="'+ parts_unit_price +'" name="DeliveryOrderDetail[unit_price][]" onchange="editSelectedSubtotal('+ parts_id +')" class="inputForm inputboxTotalAlignment form-control update_partsservicesPrice" />'+	
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-subtotal-in-list-'+ parts_id +'" value="'+ parts_sub_total +'" name="DeliveryOrderDetail[sub_total][]" class="inputForm inputboxTotalAlignment form-control update_partsservicesSubtotal" readonly="readonly" />'+	
									'</div>'+
								'<br/><hr/>'+
							'</div>'
			
			$('.update-item-in-list-delivery-order').append(parts_html);
		});

		var services = data.services;
		var serviceslen = services.length;

		$.each(services, function(key, svalue){

			var service_id = svalue['id'];
			var service_name = svalue['name'];
			var description = svalue['description'];
			var service_quantity = svalue['quantity'];
			var service_unit_price = svalue['unit_price'];
			var service_sub_total = svalue['sub_total'];

			var services_html = '<div class="row selectedItemListDesign update-item-in-list-'+ service_id +' ">'+
									'<div class="col-md-6"></div>'+
									'<div class="col-md-6">'+
										'<div style="text-align: right;">'+
											'<span class="edit-button update-button-'+ service_id +' ">'+
								                '<a href="javascript:updateSelectedDeliveryOrderItem('+ service_id +')" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>'+
								            '</span>'+
								            '&nbsp;'+
								            '<span class="save-button hidden save-update-button-'+ service_id +' ">'+
								                '<a href="javascript:saveUpdateSelectedDeliveryOrderItem('+ service_id +')" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>'+
								            '</span>'+
								            '&nbsp;'+
								            '<span class="remove-button remove-update-button-'+ service_id +' ">'+
								                '<a href="javascript:removeUpdateSelectedDeliveryOrderItem('+ service_id +')" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>'+
								            '</span>'+	
										'</div>'+
									'</div>'+
								'</div>'+
								'<div class="row selectedItemListDesign update-item-in-list-'+ service_id +' selectedUpdateItemInLabel-'+ service_id +' ">'+
									'<div class="col-md-3 selectedPartsAndServicesFontSize" >'+
										'<span class="selectedPartsAndServices" >'+ service_name.toUpperCase() +'</span>'+
									'</div>'+
									'<div class="col-md-3 selectedPartsAndServicesFontSize" >'+
										'<span class="selectedPartsAndServices" id="inlabel-update-quantity-'+ service_id + '">' + service_quantity +'</span>'+
									'</div>'+
									'<div class="col-md-3 selectedPartsAndServicesFontSize" >'+
										'<span class="selectedPartsAndServices" id="inlabel-update-unitprice-'+ service_id +'">' + service_unit_price +'</span>'+
									'</div>'+
									'<div class="col-md-3 selectedPartsAndServicesFontSize" >'+
										'<span class="selectedPartsAndServices" id="inlabel-update-subtotal-'+ service_id +'">' + service_sub_total +'</span>'+
									'</div>'+
								'<br/><hr/>'+
								'</div>'+
								'<div class="row hidden selectedItemListDesign update-item-in-list-'+ service_id +' selectedUpdateItemInInputbox-'+ service_id +' ">'+
									'<div class="col-md-3">'+
											'<input type="text" id="parts-services-update-name-in-list-'+ service_id +'" value="'+ service_name.toUpperCase() +'" class="inputForm inputboxTotalAlignment form-control" readonly="readonly" />'+

											'<input type="hidden" id="parts-services-update-id-in-list-'+ service_id +'" value="0-'+ description +'" name="DeliveryOrderDetail[description][]" class="inputForm form-control update_partsservicesName" />'+		
										'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-qty-in-list-'+ service_id +'" value="'+ service_quantity +'" name="DeliveryOrderDetail[quantity][]" onchange="editSelectedSubtotal('+ service_id +')" class="inputForm inputboxTotalAlignment form-control update_partsservicesQty" />'+	
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-price-in-list-'+ service_id +'" value="'+ service_unit_price +'" name="DeliveryOrderDetail[unit_price][]" onchange="editSelectedSubtotal('+ service_id +')" class="inputForm inputboxTotalAlignment form-control update_partsservicesPrice" />'+	
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-subtotal-in-list-'+ service_id +'" value="'+ service_sub_total +'" name="DeliveryOrderDetail[sub_total][]" class="inputForm inputboxTotalAlignment form-control update_partsservicesSubtotal" readonly="readonly" />'+	
									'</div>'+
								'<br/><hr/>'+
							'</div>'
			
			$('.update-item-in-list-delivery-order').append(services_html);
		});
	
	});

});

$('.closeUpdateDeliveryOrder').click(function(e){
    if( confirm('Are you want to close this Quotation Form?') ){	
    	$('#modal-launcher-update-delivery-order').modal('hide');
    	e.preventDefault();
    }
});

//========== Get Update Customer Information ==========//

$('#update_customer').change(function(){
	var customerId = $(this).val();

	$.get('?r=delivery-order/get-customer-information',{
		customerId : customerId,

	}, function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		if( result.type == 1 ){ 

            var html = '<table class="table table-hover table-striped viewTableContent">'+
                        '<tr>'+
                            '<td><b>COMPANY NAME</b></td>' +
                            '<td>'+result.company_name.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>UEN NUMBER</b></td>' +
                            '<td>'+result.uen_no.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>CONTACT PERSON</b></td>' +
                            '<td>'+result.fullname.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>ADDRESS</b></td>' +
                            '<td>'+result.address.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>SHIPPING ADDRESS</b></td>' +
                            '<td>'+result.shipping_address.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>EMAIL</b></td>' +
                            '<td>'+result.email.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>PHONE NUMBER</b></td>' +
                            '<td>'+result.phone_number+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>OFFICE NUMBER</b></td>' +
                            '<td>'+result.mobile_number+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>FAX NUMBER</b></td>' +
                            '<td>'+result.fax_number+'</td>'+
                        '</tr>'+
                    '</table>';
                        
        }else{

            var html = '<table class="table table-hover table-striped viewTableContent">'+
                        '<tr>'+
                            '<td><b>CUSTOMER FULLNAME</b></td>' +
                            '<td>'+result.fullname.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>NRIC NUMBER</b></td>' +
                            '<td>'+result.nric.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>ADDRESS</b></td>' +
                            '<td>'+result.address.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>SHIPPING ADDRESS</b></td>' +
                            '<td>'+result.shipping_address.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>EMAIL</b></td>' +
                            '<td>'+result.email.toUpperCase()+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>PHONE NUMBER</b></td>' +
                            '<td>'+result.phone_number+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>OFFICE NUMBER</b></td>' +
                            '<td>'+result.mobile_number+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b>FAX NUMBER</b></td>' +
                            '<td>'+result.fax_number+'</td>'+
                        '</tr>'+
                    '</table>';

        }

        $('#update-delivery-order-customer-information').html(html);

	}); 

}); 

//=========== Update Auto-Parts ===========//

function getUpdatePartsPriceAndQtyDeliveryOrder()
{
	var partsId = $('#update_parts').val();

	if(partsId == 0){

		$('#update_partsQty').val('');
		$('#currentUpdateQtyValue').val('');
		$('#currentUpdateQty').html(parseInt(0));
		$('#update_partsPrice').val('');
		$('#update_partsSubtotal').val('');
		return false;

	}else{

		$.get("?r=delivery-order/get-parts-price-and-qty",{
			parts_id : partsId,

		},function(data){
			var data = jQuery.parseJSON(data);
			var result = data.result;

			if( data.status == 'success') {
				var qty = result.quantity;
				var price = result.selling_price;
				
				$('#currentUpdateQty').html(parseInt(qty));
				$('#currentUpdateQtyValue').val(parseInt(qty));
				$('#update_partsPrice').val(parseInt(price));
				
			}else{
				return false;
			}
		});

	}
}

function editPartsSubtotalDeliveryOrder()
{
	var partsQty = $('#update_partsQty').val();
	var currentPartsQty = $('#currentUpdateQtyValue').val();
	var partsPrice = $('#update_partsPrice').val();
	
	$('#currentUpdateQty').html(parseInt(currentPartsQty) - parseInt(partsQty));

	if( !onlyNumber(partsQty) ) {
		alert('Invalid auto-parts quantity format.');
		partsQty.focus();
	}

	var total = parseFloat(partsQty) * parseFloat(partsPrice);
	$('#update_partsSubtotal').val(parseFloat(total).toFixed(2));
}

$('.autoparts_update_delivery_order').click(function(){
	var partsId = $('#update_parts').val();
	var partsQty = $('#update_partsQty').val();
	var partsPrice = $('#update_partsPrice').val();
	var partsSubtotal = $('#update_partsSubtotal').val();

	if(partsQty == '' || partsPrice == ''){
		alert('Key in quantity and price first.');
		return false;
	
	}else{

		if( !onlyNumber(partsQty) ) {
			alert('Invalid auto-parts quantity format.');
			partsQty.focus();
		}

		var ctr = $('#n').val();
		ctr++;

		$.post("?r=delivery-order/update-auto-parts-in-list",{
		parts_id : partsId,
		parts_qty : partsQty,
		parts_price : partsPrice,
		parts_subtotal : partsSubtotal,
		ctr : ctr,

		},function(data){
			$('#update-item-in-list-delivery-order').append(data);

			$('#n').val(ctr);
			$('#update_parts').val(0).change();
			$('#update_partsQty').val('');
			$('#currentUpdateQtyValue').val('');
			$('#currentUpdateQty').html(parseInt(0));
			$('#update_partsPrice').val('');
			$('#update_partsSubtotal').val('');

			setTimeout(function() {
                getUpdateDeliveryOrderGrandTotal();
            }, 500);

		});

	}

});

//=========== Update Services ===========//

function getUpdateServicesPriceAndQtyDeliveryOrder()
{
	var servicesId = $('#update_services').val();

	$.get("?r=delivery-order/get-services-price-and-qty",{
		services_id : servicesId,

	},function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		if( data.status == 'success') {
			var qty = 1;
			var serviceCategory = '[ '+result.name+' ]';
			var serviceName = result.service_name;
			var price = result.price;
			var total = parseFloat(qty) * parseFloat(price);

			$('#serviceCategoryUpdate').val(serviceCategory.toUpperCase());
			$('#updateFormServiceDetails').val(serviceName);
			$('#update_servicesQty').val(parseInt(qty));
			$('#update_servicesPrice').val(parseInt(price));
			$('#update_servicesSubtotal').val(parseFloat(total).toFixed(2));

		}else{
			return false;
		}
	});
}

function editServiceDetailsDeliveryOrder()
{
	var servicesId = $('#update_services').val();

	if( servicesId == '0'){
		alert('Key in services first.');

	}else{
		
		$('#saveUpdateServiceDetailsBtn').removeClass('hidden');
		$('#updateFormServiceDetails').removeClass('hidden');
		$('#updateServiceDetailsBtn').addClass('hidden');

	}
}

function saveUpdateServiceDetailsDeliveryOrder()
{
	var servicesId = $('#update_services').val();
	var serviceCategory = $('#serviceCategoryUpdate').val();
	var servicesDetails = $('#updateFormServiceDetails').val();

	if( servicesId == '' || servicesDetails == ''){
		alert('Key in service details first.');

	}else{
		
		$.post("?r=delivery-order/save-service-details",{
			service_id : servicesId,
			service_details : servicesDetails,

		},function(data){

			$('#saveUpdateServiceDetailsBtn').addClass('hidden');
			$('#updateFormServiceDetails').addClass('hidden');
			$('#updateServiceDetailsBtn').removeClass('hidden');

			$('#update_services option:selected').detach();
			$('#update_services').append("<option value="+ servicesId +">" + serviceCategory +  ' ' + servicesDetails + "</option>")
			$('#update_services').val(servicesId).change();

		});

	}
}

function editServicesSubtotalDeliveryOrder()
{
	var servicesQty = $('#update_servicesQty').val();
	var servicesPrice = $('#update_servicesPrice').val();

	if( !onlyNumber(servicesQty) ) {
		alert('Invalid service quantity format.');
		servicesQty.focus();
	}

	if( !onlyNumber(servicesPrice) ) {
		alert('Invalid service unit-price format.');
		servicesPrice.focus();
	}

	var total = parseFloat(servicesQty) * parseFloat(servicesPrice);
	$('#update_servicesSubtotal').val(parseFloat(total).toFixed(2));
}

$('.services_update_delivery_order').click(function()
{
	var servicesId = $('#update_services').val();
	var servicesQty = $('#update_servicesQty').val();
	var servicesPrice = $('#update_servicesPrice').val();
	var servicesSubtotal = $('#update_servicesSubtotal').val();

	if(servicesQty == '' || servicesPrice == ''){
		alert('Key in quantity and price first.');
		return false;
	
	}else{

		if( !onlyNumber(servicesQty) ) {
			alert('Invalid service quantity format.');
			servicesQty.focus();
		}

		if( !onlyNumber(servicesPrice) ) {
			alert('Invalid service unit-price format.');
			servicesPrice.focus();
		}

		var ctr = $('#n').val();
		ctr++;

		$.post("?r=delivery-order/update-services-in-list",{
		services_id : servicesId,
		services_qty : servicesQty,
		services_price : servicesPrice,
		services_subtotal : servicesSubtotal,
		ctr : ctr,

		},function(data){
			$('#update-item-in-list-delivery-order').append(data);

			$('#n').val(ctr);
			$('#update_services').val(0).change();
			$('#update_servicesQty').val('');
			$('#update_servicesPrice').val('');
			$('#update_servicesSubtotal').val('');

			setTimeout(function() {
                getUpdateDeliveryOrderGrandTotal();
            }, 500);

		});

	}

});

//=========== Update Selected Insert Parts & Services ===========//

function updateSelectedDeliveryOrderItem(n)
{
	$('.selectedUpdateItemInLabel-'+n).addClass('hidden');
	$('.selectedUpdateItemInInputbox-'+n).removeClass('hidden');

	$('.save-update-button-'+n).removeClass('hidden');
	$('.update-button-'+n).addClass('hidden');
}

function editSelectedSubtotalDeliveryOrder(n)
{
	var qty = $('#parts-services-update-qty-in-list-'+n).val();
	var price = $('#parts-services-update-price-in-list-'+n).val();
	
	if( !onlyNumber(qty) ) {
		alert('Invalid item quantity format.');
		qty.focus();
	}

	if( !onlyNumber(price) ) {
		alert('Invalid item unit-price format.');
		price.focus();
	}

	var total = parseFloat(qty) * parseFloat(price);

	$('#parts-services-update-subtotal-in-list-'+n).val(parseFloat(total).toFixed(2));

	setTimeout(function(){
            getUpdateDeliveryOrderGrandTotal();
        }, 500);
}

function saveUpdateSelectedDeliveryOrderItem(n)
{
	var inputboxQty = $('#parts-services-update-qty-in-list-'+n).val();
	var inputboxPrice = $('#parts-services-update-price-in-list-'+n).val();
	var inputboxSubtotal = $('#parts-services-update-subtotal-in-list-'+n).val();
	
	if( !onlyNumber(inputboxQty) ) {
		alert('Invalid item quantity format.');
		inputboxQty.focus();
	}

	if( !onlyNumber(inputboxPrice) ) {
		alert('Invalid item unit-price format.');
		inputboxPrice.focus();
	}

	$('#inlabel-update-quantity-'+n).html(inputboxQty);
	$('#inlabel-update-unitprice-'+n).html(inputboxPrice);
	$('#inlabel-update-subtotal-'+n).html(inputboxSubtotal);

	$('.selectedUpdateItemInInputbox-'+n).addClass('hidden');
	$('.selectedUpdateItemInLabel-'+n).removeClass('hidden');

	$('.update-button-'+n).removeClass('hidden');
	$('.save-update-button-'+n).addClass('hidden');
}

function removeUpdateSelectedDeliveryOrderItem(n)
{
	$('.update-item-in-list-'+n).detach();

	setTimeout(function(){
            getUpdateInvoiceGrandTotal();
        }, 500);
}

function getUpdateDeliveryOrderGrandTotal()
{
	var total = 0;

	$('.update_partsservicesSubtotal').each(function(){
		total += parseFloat($(this).val());
    })

    $('#update_grandTotal').val(total.toFixed(2));
    setTimeout(function(){
            getUpdateDeliveryOrderNetTotal();
        }, 500);
}

function getUpdateDeliveryOrderNetTotal()
{
	var grandTotal = $('#update_grandTotal').val();
	var gst = $('#update_gst').val();
	var discountPrice = $('input:text[id=update_discountAmount]').val();

	if(gst == '' || gst == null){
		gst = 0;
	}else{
		gst = gst;
	}

	var totalwithGst = parseFloat(grandTotal) * parseFloat(gst);
	totalwithGst /= 100;
	$('#update_gst_amount').val(parseFloat(totalwithGst).toFixed(2));

	var netTotal = parseFloat(grandTotal) + parseFloat(totalwithGst);

	if(discountPrice == ''){
       var discount = 0; 
    }else{
        var discount = discountPrice;
    }

    var net_with_disc = parseFloat(netTotal) - parseFloat(discount);
	$('#update_netTotal').val(parseFloat(net_with_disc).toFixed(2));

}

// ==================== Invoice Update Discount ==================== //

$('#btnUpdateDiscount').click(function(){

    $('#update_discountRemarks').removeAttr('readonly');
    $('#update_discountAmount').removeAttr('readonly');
    $('#btnUpdateDiscount').addClass('hidden');
    $('.submitUpdateDiscount').removeClass('hidden');
    $('.clearUpdateDiscount').removeClass('hidden');

});

$('#submitUpdateDiscount').click(function(){
    var discountDescription = $('textarea[id=update_discountRemarks]').val();
    var discountPrice = $('input:text[id=update_discountAmount]').val();
    var salesPerson = $('#update_sales_person').val();
    var grand_total =  $('#update_grandTotal').val();

    if( discountDescription == '' || discountPrice == '' ) {
        alert('Please key the discount fields first.');
        return false;
    
    }else if(salesPerson == 0){
        alert('Please key sales person first.');
        $('#discountAmount').val('');   
        $('#discountRemarks').val('');
        return false;

    }else if(grand_total == '0.00'){
        alert('Please key auto-parts or services first.');
        $('#discountAmount').val('');   
        $('#discountRemarks').val('');
        return false;

    }else{

        if( !onlyNumber(discountPrice) ) {
            alert('Invalid discount amount format.');
            discountPrice.focus();
        }

        if( !onlyLetterAndNumber(discountDescription) ) {
            alert('Invalid discount remarks format.');
            discountDescription.focus();
        }

        var total = 0;

		$('.update_partsservicesSubtotal').each(function(){
			total += parseFloat($(this).val());
	    })

	    $('#update_grandTotal').val(total.toFixed(2));

        var grandTotal = $('#update_grandTotal').val();
		var gst = $('#update_gst').val();
		var totalWithGst = total * $('#update_gst').val();

		if(gst == '' || gst == null){
			gst = 0;
		}else{
			gst = gst;
		}

		var totalwithGst = parseFloat(grandTotal) * parseFloat(gst);
		totalwithGst /= 100;
		$('#update_gst_amount').val(parseFloat(totalwithGst).toFixed(2));

		var netTotal = parseFloat(grandTotal) + parseFloat(totalwithGst);

		if(discountPrice == ''){
	       var discount = 0; 
	    }else{
	        var discount = discountPrice;
	    }

	    var net_with_disc = parseFloat(netTotal) - parseFloat(discount);
		$('#update_netTotal').val(parseFloat(net_with_disc).toFixed(2));

        $('#update_discountRemarks').attr('readonly', true);
        $('#update_discountAmount').attr('readonly', true);
        $('#btnUpdateDiscount').removeClass('hidden');
        $('.submitUpdateDiscount').addClass('hidden');
        $('.clearUpdateDiscount').addClass('hidden');
    }

});

$('#clearUpdateDiscount').click(function(){

    $('#update_discountRemarks').val('');
    $('#update_discountAmount').val('');    
    $('#update_discountRemarks').attr('readonly', true);
    $('#update_discountAmount').attr('readonly', true);
    $('#btnUpdateDiscount').removeClass('hidden');
    $('.submitUpdateDiscount').addClass('hidden');
    $('.clearUpdateDiscount').addClass('hidden');
        
});

// ====================== Save Update Invoice ====================== //

$('#saveUpdateDeliveryOrderForm').click(function(){

	var deliveryorderId = $('#deliveryorderFormUpdate').find('input:hidden[id=delivery_order_id]').val();
	var deliveryorderCode = $('#deliveryorderFormUpdate').find('input:text[id=update_delivery_order_code]').val();
	var salesPerson = $('#deliveryorderFormUpdate').find('select[id=update_sales_person]').val();
	var paymentType = $('#deliveryorderFormUpdate').find('select[id=update_paymentType]').val();
	var remarks = $('#deliveryorderFormUpdate').find('textarea[id=update_remarks]').val();
	var dateIssue = $('input:text.update_date_issue').val();
	var customerName = $('#deliveryorderFormUpdate').find('select[id=update_customer]').val();
	var grandTotal = $('#deliveryorderFormUpdate').find('input:text[id=update_grandTotal]').val();
	var gst_amount = $('#deliveryorderFormUpdate').find('input:hidden[id=update_gst_amount]').val();
	var gst_value = $('#deliveryorderFormUpdate').find('input:text[id=update_gst]').val();
	var netTotal = $('#deliveryorderFormUpdate').find('input:text[id=update_netTotal]').val();
	var discountAmount = $('#deliveryorderFormUpdate').find('input:text[id=update_discountAmount]').val();
	var discountRemarks = $('#deliveryorderFormUpdate').find('textarea[id=update_discountRemarks]').val();

	var parts_services = $('input:hidden.update_partsservicesName').serializeArray();
	var parts_services_qty = $('input:text.update_partsservicesQty').serializeArray();
	var parts_services_price = $('input:text.update_partsservicesPrice').serializeArray();
	var parts_services_subtotal = $('input:text.update_partsservicesSubtotal').serializeArray();

	var selected_parts_services = $('input:hidden.update_selected_partsservicesName').serializeArray();
	var selected_parts_services_qty = $('input:text.update_selected_partsservicesQty').serializeArray();
	var selected_parts_services_price = $('input:text.update_selected_partsservicesPrice').serializeArray();
	var selected_parts_services_subtotal = $('input:text.update_selected_partsservicesSubtotal').serializeArray();

	if(customerName == '0' || salesPerson == '0' ){
		alert('Invalid Customer Name or Sales Person Selected.');
		return false;

	}else{

		if(discountAmount == null || discountAmount == ''){
			var discount_amount = 0;
		
		}else{
			var discount_amount = discountAmount;

		}

		if(discountRemarks == null || discountRemarks == ''){
			var discount_remarks = 'No discount remarks';
		
		}else{
			var discount_remarks = discountRemarks;

		}

		$.post("?r=delivery-order/update",{
			deliveryorderId : deliveryorderId,
			deliveryorderCode : deliveryorderCode,
			salesPerson: salesPerson,
			paymentType : paymentType,
			remarks : remarks,
			dateIssue : dateIssue,
			customerName : customerName,
			grandTotal : grandTotal,
			gst_amount : gst_amount,
			gst_value : gst_value,
			netTotal : netTotal,
			discountAmount : discount_amount,
			discountRemarks : discount_remarks,
			parts_services : parts_services,
			parts_services_qty : parts_services_qty,
			parts_services_price : parts_services_price,
			parts_services_subtotal : parts_services_subtotal,
			selected_parts_services : selected_parts_services,
			selected_parts_services_qty : selected_parts_services_qty,
			selected_parts_services_price : selected_parts_services_price,
			selected_parts_services_subtotal : selected_parts_services_subtotal,

		},function(data){

			var data = jQuery.parseJSON(data);
			if( data.status == 'Success') {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

			    $('.insert-item-in-list').remove();

				alert(data.message);
				window.location = domain + '?r=delivery-order/view&id=' + data.id;

			} else {

				$('form input, textarea').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';

		            $('select[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError');
		            $('textarea[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('input[name="' + 'DeliveryOrder[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('select[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();
		      	$('textarea[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();
		      	$('input[name="'+ 'DeliveryOrder[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}

});

//============ Delete Delivery Order =============//

$('.deliveryorderDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=delivery-order/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location = domain + '?r=delivery-order/';	

			}

		});
	}

});

});

//============ Approve Delivery Order =============//

$('.deliveryorderApproveColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to approve this delivery order?");
       
	if(yes) {
		$.post("?r=delivery-order/approve-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location = domain + '?r=delivery-order/';	

			}

		});
	}

});

});

//============ Cancel Delivery Order =============//

$('.deliveryorderCancelColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to cancel this delivery order?");
       
	if(yes) {
		$.post("?r=delivery-order/cancel-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location = domain + '?r=delivery-order/';	

			}

		});
	}

});

});

//============ Close Delivery Order =============//

$('.deliveryorderCloseColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to close this delivery order?");
       
	if(yes) {
		$.post("?r=delivery-order/close-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location = domain + '?r=delivery-order/';	

			}

		});
	}

});

});

// ============= Validation ============== //

function onlyLetterAndNumber(element)
{
	var alphanum = /^[a-zA-Z0-9\s]*$/;
	
	if(element.match(alphanum)) {
		return true;
	}else{
		return false;
	}
}

function onlyNumber(element)
{
	var num = /^[0-9]*$/;
	
	if(element.match(num)) {
		return true;
	}else{
		return false;
	}
}