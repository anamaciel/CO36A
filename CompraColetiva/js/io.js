var express = require('express')
	, mysql = require('mysql');
	
var client = mysql.createClient({
	user: 'root',
	password: '',
	host: 'localhost'
});

client.query('USE compracoletiva');

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
        socket.emit('showmessage', 'Usuário conectado no socket!!!');
        setInterval(function(){
		
                    var msg = 'SELECT * FROM oferta';
                            socket.emit('showmessage',{teste: msg});
            
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