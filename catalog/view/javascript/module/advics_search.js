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
                $('#searchButton').attr('disabled', true);
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
                $('#searchButton').attr('disabled', true);
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
    
    drowPrice:function(price){
        var html =''
        for(var i=0; i<price.length; i++){
            html += '<tr>';
            html += '<td>' + price[i]['maker'] + '</td>';
            html += '<td>' + price[i]['model'] + '</td>';
            html += '<td>' + price[i]['chassis'] + '</td>';
            html += '<td>' + price[i]['engine'] + '</td>';
            html += '<td>' + price[i]['year'] + '</td>';
            html += '<td>' + price[i]['front_pads'] + '</td>';
            html += '<td>' + price[i]['rear_pads'] + '</td>';
            html += '<td>' + price[i]['front_disk'] + '</td>';
            html += '<td>' + price[i]['rear_disk'] + '</td>';
            html += '<td></td>';
            html += '<td></td>';
            html += '</tr>';
        }
        return html ;
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
                $('.table #priceTable').html(advicsSearch.drowPrice(resp));
            }
        });
    }
    
}
$(document).ready(advicsSearch.init());
