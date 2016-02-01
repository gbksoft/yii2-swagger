/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    $('#apihistory').load('apihistory.php');
    $('#apihistory').on('click','.log-item .log-hash',function(){
        var el = $(this);
        var hash = $(this).text();
        
        if( $('#'+hash).length ){
            $('#'+hash).remove();
            return;
        }
        
        $('<div>',{
            'id': hash,
        })
                .addClass('log-diff')
                .load('apihistory.php?c='+hash)
                .appendTo(el.parent());
    });
});


