jQuery(document).ready(function(){
    var pageName = jQuery('#pageName').val();
    /*** category filter start ***/
    jQuery('#categoryOption').on('change' , function(){
        var ajaxData = {dataId : this.value};
        var data = callAjax(ajaxData , '/ajaxCall/'+pageName, 0);
        if(data)
            jQuery('.ajaxData').html(data);
        else
            jQuery('.message').html('<div class="alert alert-danger text-center">Some Error Occured!</div>');
        return false;
    });
    /*** category filter end ***/
    /*** sorting start ***/
    jQuery('.ajaxData').on('click' , '.sort-col' , function(){
        var th=jQuery(this);         
        var orderBy = th.attr('class');
        orderBy = orderBy.substr(orderBy.indexOf(" "));
        var colName = th.attr('data-col');
        var ajaxData = { sortcolumn : colName , orderby : orderBy };
        var data = callAjax(ajaxData , '/ajaxCall/'+pageName ,0);
        if(data != ''){
            var $response=jQuery(data);
            jQuery($response).find('.sort-col').each(function (){
                var th1=jQuery(this);
                if(th1.attr('data-col')==colName)
                {
                    if(jQuery.trim(orderBy) == 'desc'){
                        th1.removeClass('desc').addClass('asc');
                        th1.children().removeClass('fa-sort-desc').addClass('fa-sort-asc');
                    }
                    else{
                        th1.removeClass('asc').addClass('desc');
                        th1.children().removeClass('fa-sort-asc').addClass('fa-sort-desc');
                    }
                }
            });             
            jQuery('.ajaxData').html($response);        
        }
    });
    /*** sorting end ***/
    /*** detail view start **/
    jQuery('.ajaxData').on('click' , '.detail-anchor' , function(){
        var data = callAjax('' , this.href, 0);
        jQuery('.custPopup').show().append(data);
        return false;
    });
    /*** detail view end**/
});

    function closePopUp(val){
        jQuery(val).parent().hide();
        return false;
    }
