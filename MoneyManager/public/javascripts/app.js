var userAuthenticated = {}; // variavel Global, usuario Autenticado

function logout() {
    $.ajax({
        url: '/v1.0/logout',
        type: 'GET',
        success: function (data) {
            location.replace('/login');
        }
    });
}

function getJsonUsuarioAutenticado() {
    return $.getJSON('/v1.0/usuarioautenticado', function (data) {
        userAuthenticated = data.usuarios[0];
    });
}

