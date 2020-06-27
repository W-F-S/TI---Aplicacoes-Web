var db_dica_inicial = {
    "data": [
        {
            "id": 1,
            "nome": "Alicia Moraes Ferreira",
            "conteudo": "Belo Horizonte",
            "ong": "Cão Viver - Associação particular administrada por voluntários",
            
            "titulo": "alicinha111@hotmail.com",
            "imagem": "98666-5567",
            "info": "--"
        }
        
       
        
    ]
}


// Caso os dados já estejam no Local Storage, caso contrário, carrega os dados iniciais
var db = JSON.parse(localStorage.getItem('db_dica'));
if (!db) {
    db = db_dica_inicial
};

// Exibe mensagem em um elemento de ID msg
function displayMessage(msg) {
    $('#msg').html('<div class="alert alert-warning">' + msg + '</div>');
}

function insertDica(dica) {
    // Calcula novo Id a partir do último código existente no array (PODE GERAR ERRO SE A BASE ESTIVER VAZIA)
    let novoId = db.data[db.data.length - 1].id + 1;
    let novoDica = {
        "id": novoId,
        "nome": dica.nome,
        "titulo" : dica.titulo,
        "conteudo": dica.imagem,
        "imagem" : dica.conteudo,
        
    };

    // Insere o novo objeto no array
    db.data.push(novoDica);
    displayMessage("dica inserido com sucesso");

    // Atualiza os dados no Local Storage
    localStorage.setItem('db_dica', JSON.stringify(db));
}

function updateDica(id, dica) {
    // Localiza o indice do objeto a ser alterado no array a partir do seu ID
    let index = db.data.map(obj => obj.id).indexOf(id);

    // Altera os dados do objeto no array
    db.data[index].nome = dica.nome,
    db.data[index].titulo = dica.titulo,
    db.data[index].conteudo = dica.conteudo,
    db.data[index].imagem = dica.imagem,  
    

    displayMessage("Denúncia alterado com sucesso");

    // Atualiza os dados no Local Storage
    localStorage.setItem('db_dica', JSON.stringify(db));
}

function deleteDica(id) {    
    // Filtra o array removendo o elemento com o id passado
    db.data = db.data.filter(function (element) { return element.id != id });

    displayMessage("dica removido com sucesso");

    // Atualiza os dados no Local Storage
    localStorage.setItem('db_dica', JSON.stringify(db));
}