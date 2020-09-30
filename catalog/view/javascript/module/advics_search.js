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
            html += '<tr'+((i%2 != 0 )?' class = "count" ': '') +'>';
            html += '<td  data-label="Марка">' + price[i]['maker'] + '</td>';
            html += '<td  data-label="Модель">' + price[i]['model'] + '</td>';
            html += '<td  data-label="Кузов">' + price[i]['chassis'] + '</td>';
            html += '<td  data-label="Объём">' + price[i]['engine'] + '</td>';
            html += '<td  data-label="Период выпуска">' + price[i]['year'] + '</td>';
            html += '<td  data-label="Передние колодки">' + price[i]['front_pads'] + '</td>';
            html += '<td  data-label="Задние колодки">' + price[i]['rear_pads'] + '</td>';
            html += '<td  data-label="Передний тормозной диск">' + price[i]['front_disk'] + '</td>';
            html += '<td  data-label="Задний тормозной диск">' + price[i]['rear_disk'] + '</td>';
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
				$('.table-wrap table').show();
				$('.table-wrap .table_content').hide();
            }
        });
    }
    
}
$(document).ready(advicsSearch.init());
