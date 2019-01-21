$(function () { 
    function buscarDados(){
        $.ajax({
            url: "inicial.php",
            type: "POST", 
            success: function(response) {
                callBack(response);
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    function callBack(response){
        var movimentos = JSON.parse(response);

        preencher_grafico(movimentos[0], movimentos[1]);
    }


    function preencher_grafico(despesas, receitas){
        var myChart = Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Consumo Anual'
            },
            xAxis: {
                categories: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
            },
            yAxis: {
                title: {
                    text: 'Valor (R$)'
                }
            },
            series: [{
                name: 'Receita',
                data: [receitas[0], receitas[1], receitas[2], receitas[3], receitas[4], receitas[5], receitas[6], receitas[7], receitas[8], receitas[9], receitas[10], receitas[11]],
                color: '#53c60f'
            }, {
                name: 'Despesa',
                data: [despesas[0], despesas[1], despesas[2], despesas[3], despesas[4], despesas[5], despesas[6], despesas[7], despesas[8], despesas[9], despesas[10], despesas[11]],
                color: '#ba1a1a'
            }]
        });
        
    }


    buscarDados();

});