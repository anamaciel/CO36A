var express = require('express')
	, mysql = require('mysql');
	
var client = mysql.createClient({
	user: 'fanatico_admin',
	password: 'ex4ALZ[~^sP2',
	host: '96.47.227.121'
});

client.query('USE fanatico_fanatico');

var onRequest = function (request, response) {
    // Informando o tipo do cabeçalho da página
    response.writeHead(200, {'Content-Type': 'text/html'});
  
    // Mensagem exibida no console há cada requisição
    console.log('Usuário conectado no Server!!!');

    // Encerrando o response
  response.end();
};

// Requisitando os módulos
var http = require('http').createServer(onRequest),
    io = require('socket.io').listen(http);
	
var request = require('request');

// Informando a porta para ser monitorada pelo Server
http.listen(8088, 'localhost');

/**
 * Evento "connection" que ocorre quando um usuário conecta no socket.io
 * @param {SocketObject} socket Objeto do socket conectado
 */

io.sockets.on('connection', function(socket){
    /**
     * Evento "userconected" que ocorre quando a página é carregada.
     */
    socket.on('userconected', function(data){
        // Enviando a mensagem só para o socket atual
        //socket.emit('showmessage', 'Usuário conectado no socket!!!');
        setInterval(function(){
		var id = data.split('|');
		var id2 = id[0].split('-');
		var text;
		var i2 = 0;
                
                //var msg = ('id: ' + id + 'id2: ' + id2);
        if(data != ''){
                for(i=0;i<id2.length;i++){
                    i2++;
                    if(i==0){
                        text = " AND ( ";
                    }
                    if(id2[i] != ''){
                        text += ' l.id_leilao = '+id2[i];
                        if(id2.length>i2){
                            text += " or ";
                        }
                    }
			
			
                    if(id2.length<=i2){
                        text += " )";
                    }
                }
		
                var msg = 'SELECT IF(a.tempo <= "00:00:00", "Encerrado", a.tempo) as tempo, (SELECT p.nome FROM pessoa p WHERE p.id_pessoa = l.id_pessoa LIMIT 1) as nome, (SELECT lg.login FROM login lg WHERE lg.id_pessoa = l.id_pessoa LIMIT 1) as login, l.id_leilao, l.id_pessoa, l.id_produtos, l.dt_inicio, l.dt_fim, l.preco_venda, l.status  FROM leilao l, atualiza_tempo a WHERE a.id_leilao = l.id_leilao'+text;
                var qtd;
                if(id[1] > 0){
                    client.query(
                        'SELECT qtd_lance FROM cliente WHERE id_pessoa = '+id[1]+' LIMIT 1',
                        function(err, results, fields){
                            if( err ){
                                throw err;	
                            }
                            qtd = results[0].qtd_lance;
                        }
                        );
                }
		
                var lances = '';
                var totalLance = '';
                var totalLancesLeilao = '';
                if(id[2] > 0){
                    client.query(
                        'SELECT ll.preco_lance, p.nome,lo.login FROM leilao_lance ll, pessoa p, login lo WHERE ll.id_leilao = '+id[2]+' AND p.id_pessoa = ll.id_pessoa AND p.id_pessoa = lo.id_pessoa ORDER BY ll.id_leilao_lance DESC LIMIT 10',
                        function(err, results, fields){
                            if( err ){
                                throw err;	
                            }
                            if(results.length > 0){
                                lances = results;
                                totalLancesLeilao = results[0].length;
                            } else {
                                lances = "";
                                totalLancesLeilao = 0;
                            }
                        }
                        );		
                    if(id[1] > 0){
                        client.query(
                            'SELECT qtd FROM leilao_pessoa WHERE id_pessoa = '+id[1]+' AND id_leilao = '+id[2]+'',
                            function(err, results, fields){
                                if( err ){
                                    throw err;	
                                }                          
                                if(results.length > 0){
                                    totalLance = results[0].qtd;
                                } else {
                                    totalLance = 0;
                                }
                            }                        
                            );
                    }
                }
            
		
		client.query(
				'SELECT IF(a.tempo <= "00:00:00", "Encerrado", a.tempo) as tempo, (SELECT p.nome FROM pessoa p WHERE p.id_pessoa = l.id_pessoa LIMIT 1) as nome, (SELECT lg.login FROM login lg WHERE lg.id_pessoa = l.id_pessoa LIMIT 1) as login, l.id_leilao, l.id_pessoa, l.id_produtos, l.dt_inicio, l.dt_fim, l.preco_venda, l.status  FROM leilao l, atualiza_tempo a WHERE a.id_leilao = l.id_leilao'+text,
				function(err, results, fields){
					if( err ){
						throw err;
					}
					
					data1 = new Date();
					hora = data1.getHours();
					if(hora < 10){
						hora = '0'+hora;
					}
					minuto = data1.getMinutes();
					if(minuto < 10){
						minuto = '0'+minuto;
					}
					seg = data1.getSeconds();
					if(seg < 10){
						seg = '0'+seg;
					}
                                        //socket.json.broadcast.send({text:'teste'});
					//socket.emit('showmessage', '{"total":'+results.length+', "lance":'+JSON.stringify(results)+', "qtd":'+qtd+' '+lances+' '+totalLance+' , "hora":"'+hora+':'+minuto+':'+seg+'"}');
					socket.emit('showmessage',{total:results.length, results:results, qtd: qtd, totalLance: totalLance, lances: lances, totalLancesLeilao: totalLancesLeilao, hora: hora+':'+minuto+':'+seg});
					
				}
			);
                            }else{
                data1 = new Date();
                hora = data1.getHours();
                if(hora < 10){
                    hora = '0'+hora;
                }
                minuto = data1.getMinutes();
                if(minuto < 10){
                    minuto = '0'+minuto;
                }
                seg = data1.getSeconds();
                if(seg < 10){
                    seg = '0'+seg;
                }
                socket.emit('showmessage',{total:0, results:'', qtd: 0, totalLance: 0, lances: 0, totalLancesLeilao: 0,hora: hora+':'+minuto+':'+seg});
            }
                    var msg = 'SELECT qtd FROM leilao_pessoa WHERE id_pessoa = '+id[1]+' AND id_leilao = '+id[2]+'';
                            //socket.emit('showmessage',{teste: msg});
            
        // Servidor responde o mesmo resultado via broadcast.
        //socket.broadcast.emit('showmessage', 'Outro usuário foi conectado!!!');
        //socket.emit('showmessage',{qtd: msg});
        }, 1000 );
    });
    

   /**
    * Evento "disconnect" emitido quando o usuário recarregar ou sair da página
    */
   socket.on('disconnect', function(){
      // Resposta do servidor via broadcast.
      socket.broadcast.emit('showmessage', 'Um usuário saiu ou recarregou à página!!!');
   });
   
});
