// Export PDF //
function pdfExport()
{
	confirm ("Are you sure you want to export in pdf?");
}

// Export Excel //
function excelExportRole()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'RoleList',
									escape:'false'});
	}
}

function excelExportCustomer()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'CustomerList',
									escape:'false'});
	}
}

function excelExportSG()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'DepartmentList',
									escape:'false'});
	}
}

function excelExportDP()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'DesignatedPositionList',
									escape:'false'});
	}
}

function excelExportStaff()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'StaffList',
									escape:'false'});
	}
}

function excelExportSupplier()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'SupplierList',
									escape:'false'});
	}
}

function excelExportModule()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'ModuleList',
									escape:'false'});
	}
}

function excelExportSL()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'StorageLocationList',
									escape:'false'});
	}
}

function excelExportSC()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'ServiceCategoryList',
									escape:'false'});
	}
}

function excelExportService()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'ServiceList',
									escape:'false'});
	}
}

function excelExportPC()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'AutoPartsCategoryList',
									escape:'false'});
	}
}

function excelExportParts()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'AutoPartsList',
									escape:'false'});
	}
}

function excelExportPI()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'AutoPartsInventoryList',
									escape:'false'});
	}
}

function excelExportPRC()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'ProductCategoryList',
									escape:'false'});
	}
}

function excelExportProduct()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'ProductList',
									escape:'false'});
	}
}

function excelExportPRI()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'ProductInventoryList',
									escape:'false'});
	}
}

function excelExportRace()
{
	var yes = confirm ("Are you sure you want to export in excel?");
       
	if(yes) {
		$('#tableID').tableExport({ type:'excel',
									excelFontSize: 11,
									tableName: 'RaceList',
									escape:'false'});
	}
}