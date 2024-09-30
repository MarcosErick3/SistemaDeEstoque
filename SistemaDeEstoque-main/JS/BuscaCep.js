const input_cep = document.getElementById('cep');
const input_bairro = document.getElementById('bairro');
const input_cidade = document.getElementById('cidade');
const input_logradouro = document.getElementById('rua'); // Atualizando para 'rua'
const input_uf = document.getElementById('estado'); // Atualizando para 'estado'
const input_numero = document.getElementById('numero'); // Atualizando para 'numero'

input_cep.addEventListener('blur', () => {
    let cep = input_cep.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    if (cep.length !== 8) {
        window.alert('Digite um CEP válido');
        return; // Saia da função se o CEP não for válido
    }

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao buscar o CEP');
            }
            return response.json();
        })
        .then(json => {
            if (json.erro) {
                window.alert('CEP não encontrado');
                return; // Saia da função se o CEP não for encontrado
            }
            // Preenchendo os campos com os dados do endereço
            input_logradouro.value = json.logradouro;
            input_bairro.value = json.bairro;
            input_cidade.value = json.localidade;
            input_uf.value = json.uf;

            // Habilitar os campos após preencher
            input_logradouro.disabled = false;
            input_bairro.disabled = false;
            input_cidade.disabled = false;
            input_uf.disabled = false;

            // Focar no campo número
            input_numero.focus();
        })
        .catch(error => {
            console.error(error);
            window.alert('Ocorreu um erro ao buscar os dados do CEP.');
        });
});