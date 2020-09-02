var advicsSearch ={
    init:function(){
        
    },
    
    getModels:function(maker_id){
        $.ajax({
            url: 'index.php?route=module/advics_search/getInputFromView',
            type:'POST',
            data: {
                id: maker_id,
                type: 'model'
            },
            success: function(resp) {
                $('#searchForm #model').html(advicsSearch.getHtmlOption(resp, 'model'));
                $('#searchButton').attr('disabled');
            }
        });
    },   
    
    getChasis:function(model_id){
        $.ajax({
            url: 'index.php?route=module/advics_search/getInputFromView',
            type:'POST',
            data: {
                id: model_id,
                type: 'chassis'
            },
            success: function(resp) {
                $('#searchForm #chassis').html(advicsSearch.getHtmlOption(resp, 'chassis'));
                $('#searchButton').attr('disabled');
            }
        });
    },
    
    getHtmlOption:function(resp, type){
        var html = '';
        if(type == 'model'){
            html += '<option value = "0">Выберите модель</option>';
        }else if(type == 'chassis'){
            html += '<option value = "0">Выберите кузов</option>'; 
        }
        for(var i=0; i<resp.length; i++){
            html += '<option value = "'+resp[i]['id']+'">'+resp[i][type]+'</option>';
        }
        return html;
    },
    
    unblockSearchButton:function(){
        $('#searchButton').removeAttr('disabled');
    },
    
    searchPrice:function(){
        var maker = $('#searchForm #maker').val();
        var model = $('#searchForm #model').val();
        var chassis = $('#searchForm #chassis').val();
        $.ajax({
            url: 'index.php?route=module/advics_search/getPrice',
            type:'POST',
            data: {
                maker: maker,
                model: model,
                chassis:chassis
            },
            success: function(resp) {
                console.log(resp);
            }
        });
    }
    
}
$(document).ready(advicsSearch.init());
