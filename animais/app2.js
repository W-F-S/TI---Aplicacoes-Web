var db_parceiro_inicial = {
    "data": [
        {
            "id": 1,
            "nome": "Alicia Moraes Ferreira",
            "cidade": "Belo Horizonte",
            "ong": "Cão Viver - Associação particular administrada por voluntários",
            
            "email": "alicinha111@hotmail.com",
            "telefone": "98666-5567",
            "info": "--"
        },
        {
            "id": 2,
            "nome": "Regina Pereira",
            "cidade": "Belo Horizonte",
            "ong": "ONG Asas e Amigos",
            "email": "reginap@gmail.com",
            "telefone": "98887-7876",
            "info": "--"
        },
        {
            "id": 3,
            "nome": "Regina Pereira",
            "cidade": "Belo Horizonte",
            "ong": "Castrapet",
            "email": "reginap@gmail.com",
            "telefone": "98887-7876",
            "info": "--"
        }
       
        
    ]
}


// Caso os dados já estejam no Local Storage, caso contrário, carrega os dados iniciais
var db = JSON.parse(localStorage.getItem('db_parceiro'));
if (!db) {
    db = db_parceiro_inicial
};

// Exibe mensagem em um elemento de ID msg
function displayMessage(msg) {
    $('#msg').html('<div class="alert alert-warning">' + msg + '</div>');
}

function insertParceiro(parceiro) {
    // Calcula novo Id a partir do último código existente no array (PODE GERAR ERRO SE A BASE ESTIVER VAZIA)
    let novoId = db.data[db.data.length - 1].id + 1;
    let novoParceiro = {
        "id": novoId,
        "nome": parceiro.nome,
        "email" : parceiro.email,
        "telefone": parceiro.telefone,
        "cidade" : parceiro.cidade,
        "ong": parceiro.ong,
        "info": parceiro.info
    };

    // Insere o novo objeto no array
    db.data.push(novoParceiro);
    displayMessage("parceiro inserido com sucesso");

    // Atualiza os dados no Local Storage
    localStorage.setItem('db_parceiro', JSON.stringify(db));
}

function updateParceiro(id, parceiro) {
    // Localiza o indice do objeto a ser alterado no array a partir do seu ID
    let index = db.data.map(obj => obj.id).indexOf(id);

    // Altera os dados do objeto no array
    db.data[index].nome = parceiro.nome,
    db.data[index].email = parceiro.email,
    db.data[index].cidade = parceiro.cidade,
    db.data[index].telefone = parceiro.telefone,  
    db.data[index].ong = parceiro.ong, 
    db.data[index].info = parceiro.info

    displayMessage("Denúncia alterado com sucesso");

    // Atualiza os dados no Local Storage
    localStorage.setItem('db_parceiro', JSON.stringify(db));
}

function deleteParceiro(id) {    
    // Filtra o array removendo o elemento com o id passado
    db.data = db.data.filter(function (element) { return element.id != id });

    displayMessage("parceiro removido com sucesso");

    // Atualiza os dados no Local Storage
    localStorage.setItem('db_parceiro', JSON.stringify(db));
}