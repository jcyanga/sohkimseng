var domain ="http://"+document.domain;

//============== Create Customer by Invoice ================//

$('._showCreateCustomerByInvoiceModal').click(function(){

	$('#modal-launcher-create-customerbyinvoice').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

});

$('#submitCustomerFormCreateByInvoice').click(function(){
	var fullname = $('#fullname').val();
	var address = $('#address').val();
	var race = $('#race').val();
	var email = $('#email').val();
	var phoneNumber = $('#phoneNumber').val();
	var mobileNumber = $('#mobileNumber').val();

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

	if( !onlyNumber(phoneNumber) ) {
		alert('Invalid phone number format.');
		phoneNumber.focus();
	}

	if( !onlyNumber(mobileNumber) ) {
		alert('Invalid mobile number format.');
		mobileNumber.focus();
	}

	$.post("?r=quotation/create-customer",{
		fullname : fullname,
		address : address,
		race : race,
		email : email,
		phoneNumber : phoneNumber,
		mobileNumber : mobileNumber,

	}, 
	function(data) {
		var data = jQuery.parseJSON(data);
		if( data.status == 'Success') {

			$('form input').removeClass('inputTxtError');
		    $('label.error').remove();

		    $('#fullname').val('');	
		    $('#address').val('');
		    $('#race').val('');
		    $('#email').val('');
		    $('#phoneNumber').val('');
		    $('#mobileNumber').val('');
		    $('#modal-launcher-create-customerbyinvoice').toggle('fast');

			alert(data.message);
			window.location = domain + '?r=invoice/create-invoice&id='+ data.id;

		} else {

			$('form input').removeClass('inputTxtError');
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

});

//============== Invoice Create ================//

$('._showCreateInvoiceModal').click(function(){

	$('#modal-launcher-create-invoice').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#invoiceFormCreate').find('select[id=customer]').val('0').change();
	$('#invoiceFormCreate').find('select[id=sales_person]').val('0').change();
	$('#invoiceFormCreate').find('textarea[id=remarks]').val('');
	$('#invoiceFormCreate').find('input:text[id=grandTotal]').val('');
	$('#invoiceFormCreate').find('input:hidden[id=gst_amount]').val('');
	$('#invoiceFormCreate').find('input:text[id=netTotal]').val('');
	$('#invoiceFormCreate').find('select[id=parts]').val('0').change();
	$('#invoiceFormCreate').find('input:text[id=partsQty]').val('');
	$('#invoiceFormCreate').find('input:text[id=partsPrice]').val('');
	$('#invoiceFormCreate').find('input:text[id=partsSubtotal]').val('');
	$('#invoiceFormCreate').find('select[id=services]').val('0').change();
	$('#invoiceFormCreate').find('input:text[id=servicesQty]').val('');
	$('#invoiceFormCreate').find('input:text[id=servicesPrice]').val('');
	$('#invoiceFormCreate').find('input:text[id=servicesSubtotal]').val('');

});

$('.closeInvoice').click(function(e){
    if( confirm('Are you want to close this Invoice Form?') ){	
    	$('#modal-launcher-create-invoice').modal('hide');
    	e.preventDefault();
    }
});

//=========== Auto-Parts ===========//

function getPartsPriceAndQtyInvoice()
{
	var partsId = $('#parts').val();

	$.get("?r=invoice/get-parts-price-and-qty",{
		parts_id : partsId,

	},function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		if( data.status == 'success') {
			var qty = result.quantity;
			var price = result.price;
			var total = parseFloat(qty) * parseFloat(price);

			$('#partsQty').val(qty);
			$('#partsPrice').val(price);
			$('#partsSubtotal').val(parseFloat(total).toFixed(2));

		}else{
			return false;
		}
	});
}

function updatePartsSubtotalInvoice()
{
	var partsQty = $('#partsQty').val();
	var partsPrice = $('#partsPrice').val();
	
	if( !onlyNumber(partsQty) ) {
		alert('Invalid auto-parts quantity format.');
		partsQty.focus();
	}

	if( !onlyNumber(partsPrice) ) {
		alert('Invalid auto-parts unit-price format.');
		partsPrice.focus();
	}

	var total = parseFloat(partsQty) * parseFloat(partsPrice);
	$('#partsSubtotal').val(parseFloat(total).toFixed(2));
}

$('.add_autoparts_invoice').click(function(){
	var partsId = $('#parts').val();
	var partsQty = $('#partsQty').val();
	var partsPrice = $('#partsPrice').val();
	var partsSubtotal = $('#partsSubtotal').val();

	if(partsQty == '' || partsPrice == ''){
		alert('Key in quantity and price first.');
		return false;
	
	}else{

		if( !onlyNumber(partsQty) ) {
			alert('Invalid auto-parts quantity format.');
			partsQty.focus();
		}

		if( !onlyNumber(partsPrice) ) {
			alert('Invalid auto-parts unit-price format.');
			partsPrice.focus();
		}

		var ctr = $('#ctr').val();
		ctr++;

		$.post("?r=invoice/insert-auto-parts-in-list",{
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
			$('#partsPrice').val('');
			$('#partsSubtotal').val('');

			setTimeout(function() {
                getInvoiceTotal();
            }, 500);

		});

	}

});

//=========== Services ===========//

function getServicesPriceAndQtyInvoice()
{
	var servicesId = $('#services').val();

	$.get("?r=invoice/get-services-price-and-qty",{
		services_id : servicesId,

	},function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		if( data.status == 'success') {
			var qty = 1;
			var serviceName = result.service_name;
			var price = result.price;
			var total = parseFloat(qty) * parseFloat(price);

			$('#editFormServiceDetails').val(serviceName);
			$('#servicesQty').val(qty);
			$('#servicesPrice').val(price);
			$('#servicesSubtotal').val(parseFloat(total).toFixed(2));

		}else{
			return false;
		}
	});
}

function updateServiceDetailsInvoice()
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

function saveServiceDetailsInvoice()
{
	var servicesId = $('#services').val();
	var servicesDetails = $('#editFormServiceDetails').val();

	if( servicesId == '' || servicesDetails == ''){
		alert('Key in service details first.');

	}else{
		
		$.post("?r=invoice/save-service-details",{
			service_id : servicesId,
			service_details : servicesDetails,

		},function(data){

			$('#saveServiceDetailsBtn').addClass('hidden');
			$('#editFormServiceDetails').addClass('hidden');
			$('#editServiceDetailsBtn').removeClass('hidden');

			$('#services option:selected').detach();
			$('#services').append("<option value="+ servicesId +">" + "- " + servicesDetails + "</option>")
			$('#services').val(servicesId).change();

		});

	}
}

function updateServicesSubtotalInvoice()
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

$('.add_services_invoice').click(function(){
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

		$.post("?r=invoice/insert-services-in-list",{
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

function editSelectedInvoiceItem(n)
{
	$('.selectedItemInLabel-'+n).addClass('hidden');
	$('.selectedItemInInputbox-'+n).removeClass('hidden');

	$('.save-button-'+n).removeClass('hidden');
	$('.edit-button-'+n).addClass('hidden');
}

function updateSelectedSubtotalInvoice(n)
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
            getInvoiceTotal();
        }, 500);
}

function saveSelectedInvoiceItem(n)
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

function removeSelectedInvoiceItem(n)
{
	$('.inserted-item-in-list-'+n).detach();

	setTimeout(function(){
            getInvoiceTotal();
        }, 500);
}

function getInvoiceTotal()
{
	var total = 0;

	$('.partsservicesSubtotal').each(function(){
		total += parseFloat($(this).val());
    })

    $('#grandTotal').val(total.toFixed(2));
    setTimeout(function(){
            getInvoiceNetTotal();
        }, 500);
}

function getInvoiceNetTotal()
{
	var grandTotal = $('#grandTotal').val();
	var gst = $('#gst').val();

	if( !onlyNumber(gst) ) {
		alert('Invalid gst format.');
		gst.focus();
	}

	var total = parseFloat(grandTotal) * parseFloat(gst);
	total /= 100;
	$('#gst_amount').val(parseFloat(total).toFixed(2));

	var netTotal = parseFloat(grandTotal) + parseFloat(total);
	$('#netTotal').val(parseFloat(netTotal).toFixed(2));

}

// ====================== Submit Invoice ====================== //

$('#submitInvoiceForm').click(function(){

	var invoiceno = $('#invoiceFormCreate').find('input:text[id=invoice_no]').val();
	var customerName = $('#invoiceFormCreate').find('select[id=customer]').val();
	var salesPerson = $('#invoiceFormCreate').find('select[id=sales_person]').val();
	var dateIssue = $('input:text.date_issue').val();
	var remarks = $('#invoiceFormCreate').find('textarea[id=remarks]').val();
	var grandTotal = $('#invoiceFormCreate').find('input:text[id=grandTotal]').val();
	var gst_amount = $('#invoiceFormCreate').find('input:hidden[id=gst_amount]').val();
	var netTotal = $('#invoiceFormCreate').find('input:text[id=netTotal]').val();

	var parts_services = $('input:hidden.partsservicesName').serializeArray();
	var parts_services_qty = $('input:text.partsservicesQty').serializeArray();
	var parts_services_price = $('input:text.partsservicesPrice').serializeArray();
	var parts_services_subtotal = $('input:text.partsservicesSubtotal').serializeArray();

	if(customerName == '0' || salesPerson == '0' ){
		alert('Invalid Customer Name or Sales Person Selected.');
		return false;

	}else{

		$.post("?r=invoice/create",{
			invoice_no : invoiceno,
			customer_name: customerName,
			sales_person : salesPerson,
			date_issue : dateIssue,
			remarks : remarks,
			grand_total : grandTotal,
			gst_amount : gst_amount,
			net_total : netTotal,
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
				window.location = domain + '?r=invoice/view&id=' + data.id;

			} else {

				$('form input').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';

		            $('select[name="' + 'Invoice[' + field + ']' + '"]').addClass('inputTxtError');
		            $('textarea[name="' + 'Invoice[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('input[name="' + 'Invoice[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('select[name="'+ 'Invoice[' + keys[0] + ']' +'"]').focus();
		      	$('textarea[name="'+ 'Invoice[' + keys[0] + ']' +'"]').focus();
		      	$('input[name="'+ 'Invoice[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}

});

//============== Invoice Update ================//

$('._showUpdateInvoiceModal').click(function(){

	$('#modal-launcher-update-invoice').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
        })

	$('form input, textarea').removeClass('inputTxtError');
	$('label.error').remove();

	$('#invoiceFormUpdate').find('select[id=update_parts]').val('0').change();
	$('#invoiceFormUpdate').find('input:text[id=update_partsQty]').val('');
	$('#invoiceFormUpdate').find('input:text[id=update_partsPrice]').val('');
	$('#invoiceFormUpdate').find('input:text[id=update_partsSubtotal]').val('');
	$('#invoiceFormUpdate').find('select[id=update_services]').val('0').change();
	$('#invoiceFormUpdate').find('input:text[id=update_servicesQty]').val('');
	$('#invoiceFormUpdate').find('input:text[id=update_servicesPrice]').val('');
	$('#invoiceFormUpdate').find('input:text[id=update_servicesSubtotal]').val('');

	var id = $(this).attr('id');

	$.get("?r=invoice/get-data",{
		id : id,

	},function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		$('#invoiceFormUpdate').find('input:hidden[name=invoice_id]').val(id);
		$('#invoiceFormUpdate').find('input:text[id=update_invoice_no]').val(result.invoice_no);
		$('#invoiceFormUpdate').find('select[id=update_customer]').val(result.customer_id).change();
		$('#invoiceFormUpdate').find('select[id=update_sales_person]').val(result.user_id).change();
		$('#invoiceFormUpdate').find('input:text.update_date_issue').val(result.date_issue);
		$('#invoiceFormUpdate').find('textarea[id=update_remarks]').val(result.remarks.toUpperCase());
		$('#invoiceFormUpdate').find('input:text[id=update_grandTotal]').val(parseFloat(result.grand_total).toFixed(2));
		$('#invoiceFormUpdate').find('input:hidden[id=update_gst_amount]').val(parseFloat(result.gst).toFixed(2));
		$('#invoiceFormUpdate').find('input:text[id=update_netTotal]').val(parseFloat(result.net).toFixed(2));

		var services = data.services;
		var serviceslen = services.length;

		$.each(services, function(key, svalue){

			var service_id = svalue['id'];
			var service_name = svalue['name'];
			var service_quantity = svalue['quantity'];
			var service_unit_price = svalue['unit_price'];
			var service_sub_total = svalue['sub_total'];

			var services_html = '<div class="row selectedItemListDesign update-item-in-list-'+ service_id +' ">'+
									'<div class="col-md-6"></div>'+
									'<div class="col-md-6">'+
										'<div style="text-align: right;">'+
											'<span class="edit-button update-button-'+ service_id +' ">'+
								                '<a href="javascript:updateSelectedInvoiceItem('+ service_id +')" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>'+
								            '</span>'+
								            '&nbsp;'+
								            '<span class="save-button hidden save-update-button-'+ service_id +' ">'+
								                '<a href="javascript:saveUpdateSelectedInvoiceItem('+ service_id +')" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>'+
								            '</span>'+
								            '&nbsp;'+
								            '<span class="remove-button remove-update-button-'+ service_id +' ">'+
								                '<a href="javascript:removeUpdateSelectedInvoiceItem('+ service_id +')" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>'+
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

											'<input type="hidden" id="parts-services-update-id-in-list-'+ service_id +'" value="0-'+ service_id +'" name="QuotationDetail[description][]" class="inputForm form-control update_partsservicesName" />'+		
										'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-qty-in-list-'+ service_id +'" value="'+ service_quantity +'" name="QuotationDetail[quantity][]" onchange="editSelectedSubtotal('+ service_id +')" class="inputForm inputboxTotalAlignment form-control update_partsservicesQty" />'+	
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-price-in-list-'+ service_id +'" value="'+ service_unit_price +'" name="QuotationDetail[unit_price][]" onchange="editSelectedSubtotal('+ service_id +')" class="inputForm inputboxTotalAlignment form-control update_partsservicesPrice" />'+	
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-subtotal-in-list-'+ service_id +'" value="'+ service_sub_total +'" name="QuotationDetail[sub_total][]" class="inputForm inputboxTotalAlignment form-control update_partsservicesSubtotal" readonly="readonly" />'+	
									'</div>'+
								'<br/><hr/>'+
							'</div>'
			
			$('.update-item-in-list-invoice').append(services_html);
		});

		var parts = data.parts;
		var partslen = parts.length;

		$.each(parts, function(key, pvalue){

			var parts_id = pvalue['id'];
			var parts_name = pvalue['name'];
			var parts_quantity = pvalue['quantity'];
			var parts_unit_price = pvalue['unit_price'];
			var parts_sub_total = pvalue['sub_total'];

			var parts_html = '<div class="row selectedItemListDesign update-item-in-list-'+ parts_id +' ">'+
									'<div class="col-md-6"></div>'+
									'<div class="col-md-6">'+
										'<div style="text-align: right;">'+
											'<span class="edit-button update-button-'+ parts_id +' ">'+
								                '<a href="javascript:updateSelectedInvoiceItem('+ parts_id +')" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>'+
								            '</span>'+
								            '&nbsp;'+
								            '<span class="save-button hidden save-update-button-'+ parts_id +' ">'+
								                '<a href="javascript:saveUpdateSelectedInvoiceItem('+ parts_id +')" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>'+
								            '</span>'+
								            '&nbsp;'+
								            '<span class="remove-button remove-update-button-'+ parts_id +' ">'+
								                '<a href="javascript:removeUpdateSelectedInvoiceItem('+ parts_id +')" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>'+
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

											'<input type="hidden" id="parts-services-update-id-in-list-'+ parts_id +'" value="1-'+ parts_id +'" name="QuotationDetail[description][]" class="inputForm form-control update_partsservicesName" />'+		
										'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-qty-in-list-'+ parts_id +'" value="'+ parts_quantity +'" name="QuotationDetail[quantity][]" onchange="editSelectedSubtotal('+ parts_id +')" class="inputForm inputboxTotalAlignment form-control update_partsservicesQty" />'+	
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-price-in-list-'+ parts_id +'" value="'+ parts_unit_price +'" name="QuotationDetail[unit_price][]" onchange="editSelectedSubtotal('+ parts_id +')" class="inputForm inputboxTotalAlignment form-control update_partsservicesPrice" />'+	
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" id="parts-services-update-subtotal-in-list-'+ parts_id +'" value="'+ parts_sub_total +'" name="QuotationDetail[sub_total][]" class="inputForm inputboxTotalAlignment form-control update_partsservicesSubtotal" readonly="readonly" />'+	
									'</div>'+
								'<br/><hr/>'+
							'</div>'
			
			$('.update-item-in-list-invoice').append(parts_html);
		});
	
	});

});

$('.closeUpdateInvoice').click(function(e){
    if( confirm('Are you want to close this Quotation Form?') ){	
    	$('#modal-launcher-update-invoice').modal('hide');
    	e.preventDefault();
    }
});

//=========== Update Auto-Parts ===========//

function getUpdatePartsPriceAndQtyInvoice()
{
	var partsId = $('#update_parts').val();

	$.get("?r=invoice/get-parts-price-and-qty",{
		parts_id : partsId,

	},function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		if( data.status == 'success') {
			var qty = result.quantity;
			var price = result.price;
			var total = parseFloat(qty) * parseFloat(price);

			$('#update_partsQty').val(qty);
			$('#update_partsPrice').val(price);
			$('#update_partsSubtotal').val(parseFloat(total).toFixed(2));

		}else{
			return false;
		}
	});
}

function editPartsSubtotalInvoice()
{
	var partsQty = $('#update_partsQty').val();
	var partsPrice = $('#update_partsPrice').val();
	
	if( !onlyNumber(partsQty) ) {
		alert('Invalid auto-parts quantity format.');
		partsQty.focus();
	}

	if( !onlyNumber(partsPrice) ) {
		alert('Invalid auto-parts unit-price format.');
		partsPrice.focus();
	}

	var total = parseFloat(partsQty) * parseFloat(partsPrice);
	$('#update_partsSubtotal').val(parseFloat(total).toFixed(2));
}

$('.autoparts_update_invoice').click(function(){
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

		if( !onlyNumber(partsPrice) ) {
			alert('Invalid auto-parts unit-price format.');
			partsPrice.focus();
		}

		var ctr = $('#n').val();
		ctr++;

		$.post("?r=invoice/update-auto-parts-in-list",{
		parts_id : partsId,
		parts_qty : partsQty,
		parts_price : partsPrice,
		parts_subtotal : partsSubtotal,
		ctr : ctr,

		},function(data){
			$('#update-item-in-list-invoice').append(data);

			$('#n').val(ctr);
			$('#update_parts').val(0).change();
			$('#update_partsQty').val('');
			$('#update_partsPrice').val('');
			$('#update_partsSubtotal').val('');

			setTimeout(function() {
                getUpdateQuoteGrandTotal();
            }, 500);

		});

	}

});

//=========== Update Services ===========//

function getUpdateServicesPriceAndQtyInvoice()
{
	var servicesId = $('#update_services').val();

	$.get("?r=invoice/get-services-price-and-qty",{
		services_id : servicesId,

	},function(data){
		var data = jQuery.parseJSON(data);
		var result = data.result;

		if( data.status == 'success') {
			var qty = 1;
			var serviceName = result.service_name;
			var price = result.price;
			var total = parseFloat(qty) * parseFloat(price);

			$('#updateFormServiceDetails').val(serviceName);
			$('#update_servicesQty').val(qty);
			$('#update_servicesPrice').val(price);
			$('#update_servicesSubtotal').val(parseFloat(total).toFixed(2));

		}else{
			return false;
		}
	});
}

function editServiceDetailsInvoice()
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

function saveUpdateServiceDetailsInvoice()
{
	var servicesId = $('#update_services').val();
	var servicesDetails = $('#updateFormServiceDetails').val();

	if( servicesId == '' || servicesDetails == ''){
		alert('Key in service details first.');

	}else{
		
		$.post("?r=invoice/save-service-details",{
			service_id : servicesId,
			service_details : servicesDetails,

		},function(data){

			$('#saveUpdateServiceDetailsBtn').addClass('hidden');
			$('#updateFormServiceDetails').addClass('hidden');
			$('#updateServiceDetailsBtn').removeClass('hidden');

			$('#update_services option:selected').detach();
			$('#update_services').append("<option value="+ servicesId +">" + "- " + servicesDetails + "</option>")
			$('#update_services').val(servicesId).change();

		});

	}
}

function editServicesSubtotalInvoice()
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

$('.services_update_invoice').click(function(){
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

		$.post("?r=invoice/update-services-in-list",{
		services_id : servicesId,
		services_qty : servicesQty,
		services_price : servicesPrice,
		services_subtotal : servicesSubtotal,
		ctr : ctr,

		},function(data){
			$('#update-item-in-list-invoice').append(data);

			$('#n').val(ctr);
			$('#update_services').val(0).change();
			$('#update_servicesQty').val('');
			$('#update_servicesPrice').val('');
			$('#update_servicesSubtotal').val('');

			setTimeout(function() {
                getUpdateQuoteGrandTotal();
            }, 500);

		});

	}

});

//=========== Update Selected Insert Parts & Services ===========//

function updateSelectedInvoiceItem(n)
{
	$('.selectedUpdateItemInLabel-'+n).addClass('hidden');
	$('.selectedUpdateItemInInputbox-'+n).removeClass('hidden');

	$('.save-update-button-'+n).removeClass('hidden');
	$('.update-button-'+n).addClass('hidden');
}

function editSelectedSubtotalInvoice(n)
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
            getUpdateQuoteGrandTotal();
        }, 500);
}

function saveUpdateSelectedInvoiceItem(n)
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

function removeUpdateSelectedInvoiceItem(n)
{
	$('.update-item-in-list-'+n).detach();

	setTimeout(function(){
            getUpdateQuoteGrandTotal();
        }, 500);
}

function getUpdateQuoteGrandTotal()
{
	var total = 0;

	$('.update_partsservicesSubtotal').each(function(){
		total += parseFloat($(this).val());
    })

    $('#update_grandTotal').val(total.toFixed(2));
    setTimeout(function(){
            getUpdateNetTotal();
        }, 500);
}

function getUpdateNetTotal()
{
	var grandTotal = $('#update_grandTotal').val();
	var gst = $('#update_gst').val();

	if( !onlyNumber(gst) ) {
		alert('Invalid gst format.');
		gst.focus();
	}

	var total = parseFloat(grandTotal) * parseFloat(gst);
	total /= 100;
	$('#update_gst_amount').val(parseFloat(total).toFixed(2));

	var netTotal = parseFloat(grandTotal) + parseFloat(total);
	$('#update_netTotal').val(parseFloat(netTotal).toFixed(2));

}

// ====================== Save Update Invoice ====================== //

$('#saveUpdateInvoiceForm').click(function(){

	var invoiceId = $('#invoiceFormUpdate').find('input:hidden[id=invoice_id]').val();
	var invoiceNo = $('#invoiceFormUpdate').find('input:text[id=update_invoice_no]').val();
	var customerName = $('#invoiceFormUpdate').find('select[id=update_customer]').val();
	var salesPerson = $('#invoiceFormUpdate').find('select[id=update_sales_person]').val();
	var dateIssue = $('input:text.update_date_issue').val();
	var remarks = $('#invoiceFormUpdate').find('textarea[id=update_remarks]').val();
	var grandTotal = $('#invoiceFormUpdate').find('input:text[id=update_grandTotal]').val();
	var gst_amount = $('#invoiceFormUpdate').find('input:hidden[id=update_gst_amount]').val();
	var netTotal = $('#invoiceFormUpdate').find('input:text[id=update_netTotal]').val();

	var parts_services = $('input:hidden.update_partsservicesName').serializeArray();
	var parts_services_qty = $('input:text.update_partsservicesQty').serializeArray();
	var parts_services_price = $('input:text.update_partsservicesPrice').serializeArray();
	var parts_services_subtotal = $('input:text.update_partsservicesSubtotal').serializeArray();

	if(customerName === 0 || salesPerson === 0 ){
		alert('Invalid Customer Name or Sales Person Selected.');
		return false;

	}else{

		$.post("?r=invoice/update",{
			invoiceId : invoiceId,
			invoice_no : invoiceNo,
			customer_name : customerName,
			sales_person : salesPerson,
			date_issue : dateIssue,
			remarks : remarks,
			grand_total : grandTotal,
			gst_amount : gst_amount,
			net_total : netTotal,
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
				window.location = domain + '?r=invoice/view&id=' + data.id;

			} else {

				$('form input').removeClass('inputTxtError');
			    $('label.error').remove();

				$.each(data.message, function(field, message) {
		    		var errMsg = '<label class="error" for="'+ field + '">'+ message +'</label>';

		            $('select[name="' + 'Invoice[' + field + ']' + '"]').addClass('inputTxtError');
		            $('textarea[name="' + 'Invoice[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		            $('input[name="' + 'Invoice[' + field + ']' + '"]').addClass('inputTxtError').after(errMsg);
		        });
		      
		      	var keys = Object.keys(data.message);
		      	$('select[name="'+ 'Invoice[' + keys[0] + ']' +'"]').focus();
		      	$('textarea[name="'+ 'Invoice[' + keys[0] + ']' +'"]').focus();
		      	$('input[name="'+ 'Invoice[' + keys[0] + ']' +'"]').focus();	
		      	return false;

			} 

		});

	}

});

//============ Delete Invoice =============//

$('.invoiceDeleteColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to delete this record?");
       
	if(yes) {
		$.post("?r=invoice/delete-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location = domain + '?r=invoice/';	

			}

		});
	}

});

});

//============ Approve Quotation =============//

$('.quotationApproveColumn').each(function(){

$(this).click(function() {    
	var yes = confirm ("Are you sure you want to approve this invoice?");
       
	if(yes) {
		$.post("?r=invoice/approve-column",{
			id : $(this).attr('id'),

		},
		function(data){
			var data = jQuery.parseJSON(data);
			
			if( data.status == 'Success' ) {
				alert(data.message);
				window.location = domain + '?r=invoice/';	

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