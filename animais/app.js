var db_contatos_inicial = {
    "data": [
        {
            "id": 1,
<<<<<<< HEAD
            "nome": "--",
            "cidade": "--",
            "categoria": "--",
            "email": "--",
            "telefone": "--",
            "info": "--"
        },
=======
            "nome": "Alicia Moraes Ferreira",
            "cidade": "Vespasiano",
            "especie": "Gato",
            "categoria": "Abandono",
            "email": "alicinha111@hotmail.com",
            "telefone": "98666-5567",
            "info": "Cachorro muito magro"
        },
        {
            "id": 2,
            "nome": "Regina Pereira",
            "cidade": "Lagoa Santa",
            "especie": "Gato",
            "categoria": "Agressão",
            "email": "reginap@gmail.com",
            "telefone": "98887-7876",
            "info": "--"
        },
        {
            "id": 3,
            "nome": "Yuri Fernandes Oliveira",
            "cidade": "Belo Horizonte",
            "especie": "Cachorro",
            "categoria": "Abandono",
            "email": "GamerYuri@gmail.com",
            "telefone": "98854-6556",
            "info": "Sinais de raiva."
        },
        {
            "id": 4,
            "nome": "Carol Kim",
            "cidade": "Pedro Leopoldo",
            "especie": "Cachorro",
            "categoria": "Agressão",
            "email": "kimcarol@gmail.com",
            "telefone": "94848-4683",
            "info": "Animal sangrando."
        },
>>>>>>> versao 2
        
    ]
}


// Caso os dados já estejam no Local Storage, caso contrário, carrega os dados iniciais
<<<<<<< HEAD
var db = JSON.parse(localStorage.getItem('db_contato'));
=======
var db = JSON.parse(localStorage.getItem('db_denuncia'));
>>>>>>> versao 2
if (!db) {
    db = db_contatos_inicial
};

// Exibe mensagem em um elemento de ID msg
function displayMessage(msg) {
    $('#msg').html('<div class="alert alert-warning">' + msg + '</div>');
}

function insertContato(contato) {
    // Calcula novo Id a partir do último código existente no array (PODE GERAR ERRO SE A BASE ESTIVER VAZIA)
    let novoId = db.data[db.data.length - 1].id + 1;
    let novoContato = {
        "id": novoId,
        "nome": contato.nome,
        "email" : contato.email,
        "telefone": contato.telefone,
        "cidade" : contato.cidade,
<<<<<<< HEAD
=======
        "especie": contato.especie,
>>>>>>> versao 2
        "categoria": contato.categoria,
        "info": contato.info
    };

    // Insere o novo objeto no array
    db.data.push(novoContato);
    displayMessage("Contato inserido com sucesso");

    // Atualiza os dados no Local Storage
<<<<<<< HEAD
    localStorage.setItem('db_contato', JSON.stringify(db));
=======
    localStorage.setItem('db_denuncia', JSON.stringify(db));
>>>>>>> versao 2
}

function updateContato(id, contato) {
    // Localiza o indice do objeto a ser alterado no array a partir do seu ID
    let index = db.data.map(obj => obj.id).indexOf(id);

    // Altera os dados do objeto no array
    db.data[index].nome = contato.nome,
    db.data[index].email = contato.email,
<<<<<<< HEAD
    db.data[index].telefone = contato.telefone,
    db.data[index].cidade = contato.cidade,
    db.data[index].categoria = contato.categoria,
    db.data[index].info = contato.info

    displayMessage("Contato alterado com sucesso");

    // Atualiza os dados no Local Storage
    localStorage.setItem('db_contato', JSON.stringify(db));
=======
    db.data[index].cidade = contato.cidade,
    db.data[index].telefone = contato.telefone,  
    db.data[index].especie = contato.especie, 
    db.data[index].categoria = contato.categoria,
    db.data[index].info = contato.info

    displayMessage("Denúncia alterado com sucesso");

    // Atualiza os dados no Local Storage
    localStorage.setItem('db_denuncia', JSON.stringify(db));
>>>>>>> versao 2
}

function deleteContato(id) {    
    // Filtra o array removendo o elemento com o id passado
    db.data = db.data.filter(function (element) { return element.id != id });

    displayMessage("Contato removido com sucesso");

    // Atualiza os dados no Local Storage
<<<<<<< HEAD
    localStorage.setItem('db_contato', JSON.stringify(db));
}
=======
    localStorage.setItem('db_denuncia', JSON.stringify(db));
}
>>>>>>> versao 2
