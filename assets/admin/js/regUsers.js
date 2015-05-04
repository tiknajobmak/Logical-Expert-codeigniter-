jQuery(document).ready(function(){
    
    /** multiple delete **/
    jQuery('#del_multiple').on('click',function(){
        deleteMultiple('registerUsers/multipleDelete/');
        return false;
    });
    /** multiple delete end **/
    
    /*** record per page start ***/
    jQuery('#pagination_records').on('change',function(){
        var perPage = jQuery(this).val();
        var ajaxData = { perPage : perPage };
        var data = callAjax(ajaxData,'registerUsers/ajaxCall/' , useBaseUrl = 1 );
        if(data != ''){
            jQuery('.ajaxData').html(data);
        }
        else
            jQuery('.message').html('<div class="alert alert-danger text-center">Some Error Occured!</div>');
    });
    /*** record per page end ***/
    
    /*** sorting start ***/
    jQuery('.ajaxData').on('click' , '.sort-col' , function(){
        var th=jQuery(this);         
        var orderBy = th.attr('class');
        orderBy = orderBy.substr(orderBy.indexOf(" "));
        var colName = th.attr('data-col');
        var ajaxData = { sortcolumn : colName , orderby : orderBy };
        var data = callAjax(ajaxData , 'registerUsers/ajaxCall/' , useBaseUrl = 1);
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
    
     /** change status start **/
    jQuery('.ajaxData').on('click' , '.status' , function(){
        var id = this.id;
        var status = jQuery(this).children().attr('class');
        var statusVal = (status == 'enabled') ? 'Disabled' : 'Enabled';
        var statusClass = statusVal.toLowerCase();
        var ajaxData = { columnId : id , status : status };
        var data = callAjax(ajaxData , 'registerUsers/changeStatus' , useBaseUrl = 1);
        if(data)
            jQuery(this).html("<span class="+statusClass+">"+statusVal+"</span>");
        else
            flashMsg('<div class="alert alert-danger text-center">Some Error Occured!</div>');
    });
    /** change status end **/
    
});
