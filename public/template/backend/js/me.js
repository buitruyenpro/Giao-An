var formAdmin	= '#adminForm';

// SUBMIT FORM ADMIN
function submitFormAdmin(url){
	if(url != ""){
		$(formAdmin).attr('action',url);
	}
	$(formAdmin).submit();
}

// SORT LIST
function sortList(orderBy, order){
	$(formAdmin + ' input[name=order]').val(order);
	$(formAdmin + ' input[name=order_by]').val(orderBy);
	submitFormAdmin();
}

// CHANGE STATUS
function changeStatus(id, status){
	var linkSubmit = $(formAdmin).attr('action').replace(/filter/gi, "status");
	$(formAdmin + ' input[name=status_id]').val(id);
	$(formAdmin + ' input[name=status_value]').val(status);
	submitFormAdmin(linkSubmit);
}

//CHANGE MULTI STATUS
function changeMultiStatus(type){
	$(formAdmin + ' input[name=status_value]').val(type);
	var linkSubmit = $(formAdmin).attr('action').replace(/filter/gi, "multi-status");

	submitFormAdmin(linkSubmit);
}
	
// SHOW TOTAL ITEM CHECK
function showTotalItemCheck(total){
	$('a[data-type=show-total] span').remove();
	if(total > 0){
		$('a[data-type=show-total]').prepend('<span class="badge bg-aqua">'+total+'</span>');
	}
}

// DELETE ITEM
function deleteItem(){
	var linkSubmit = $(formAdmin).attr('action').replace(/filter/gi, "delete");
	submitFormAdmin(linkSubmit);
}

// CHANGE ORDERING
function changeOrdering(){
	var linkSubmit = $(formAdmin).attr('action').replace(/filter/gi, "ordering");
	submitFormAdmin(linkSubmit);
}

$(document).ready(function(){
	
	$(".alert").fadeOut(10000);
	var totalItemChecked = 0;
	// SELECTBOX filter_status - CHANGE
	$(formAdmin + ' select[name=filter_status]').change(function(){
    	submitFormAdmin();
    });

	// INPUT filter_keyword_value - KEYPRESS
	$(formAdmin + ' input[name=filter_keyword_value]').keypress(function(event){
		if(event.which == 13){
			event.preventDefault();
			submitFormAdmin();
		}
    });
    
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    //When unchecking the checkbox
    $("#check-all").on('ifUnchecked', function(event) {
    	$("input[type='checkbox']").iCheck("uncheck");
    	showTotalItemCheck(0);
    });
    
    //When checking the checkbox
    $("#check-all").on('ifChecked', function(event) {
        $("input[type='checkbox']").iCheck("check");
        var items = $(formAdmin + ' table tbody input[type=checkbox]:checked').length;
        showTotalItemCheck(items);
    });
    
    //When checking the checkbox
    $("table tbody input[type=checkbox]").on('ifChecked', function(event) {
    	totalItemChecked+=1;
    	 showTotalItemCheck(totalItemChecked);
    });
    
    $("table tbody input[type=checkbox]").on('ifUnchecked', function(event) {
    	totalItemChecked-=1;
    	showTotalItemCheck(totalItemChecked);
    });

});