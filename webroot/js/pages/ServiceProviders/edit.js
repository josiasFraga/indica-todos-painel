const loadPhotos = () => {
    if (window.app_api_url && window.service_provider_id) {
        const url = `${window.app_api_url}/service-provider-photos/index.json?service_provider_id=${window.service_provider_id}`;
        
        $.get(url, (data) => {
            if ( data.status != 'ok' ) {
                alert(data.message);
            } else if ( data.data.length > 0 ) {
                $('div#photo-gallery').html('');
                $.each(data.data,(index, _foto)=>{
                    $('div#photo-gallery').append(
                        '<div class="image-container">' +
                            '<div class="image-container_inner">' +
                                '<img src="' + _foto.photo + '" />' +
                            '</div>' +
                            '<button class="delete-photo-btn" data-photo-id="' + _foto.id + '">' +
                                '<i class="fa fa-times" aria-hidden="true"></i>' + // Ícone de exclusão
                            '</button>' +
                        '</div>'
                    );
                });

            } else {
                $('div#photo-gallery').html('<br />Nenhuma imagem cadastrada!<br /><br /><br />');
            }
        }).fail((jqXHR, textStatus, errorThrown) => {
            console.error('Erro ao buscar dados: ' + textStatus, errorThrown);
        });
    } else {
        console.error('app_api_url ou service_provider_id não definidos.');
    }
}

$(document).ready(() => {
    loadPhotos();

    $('button#enviar-foto').click(()=>{
        $('input#field_file').trigger('click');
    });

    $('input#field_file').change(function() {
        if (this.files && this.files[0]) {
            var formData = new FormData();
            formData.append('photo', this.files[0]);
            dados_enviar = {
                painel_token: '4efccd63af4fb77132310585edfaef2d',
                service_provider_id: window.service_provider_id
            };
            formData.append('dados', JSON.stringify(dados_enviar));
    
            $.ajax({
                url: window.app_api_url + '/service-provider-photos/upload.json',
                type: 'POST',
                data: formData,
                processData: false, // Impede que o jQuery transforme os dados em string
                contentType: false, // Impede que o jQuery defina o tipo de conteúdo, permitindo que o navegador defina como multipart/form-data
                success: function(data) {
                    if(data.status === 'ok') {
                        alert('Foto enviada com sucesso!');
                        loadPhotos();
                    } else {
                        alert('Erro ao enviar a foto: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Lógica de erro
                }
            });
        }
    });
});

$(document).on('click', '.delete-photo-btn', function(evt) {
    evt.preventDefault();
    var photoId = $(this).data('photo-id');
    var deleteUrl = window.app_api_url + '/service-provider-photos/delete/' + photoId + '.json';

    var formData = new FormData();
    var dados_enviar = {
        painel_token: '4efccd63af4fb77132310585edfaef2d',
        service_provider_id: window.service_provider_id
    };
    formData.append('dados', JSON.stringify(dados_enviar));

    if (confirm('Tem certeza que deseja excluir esta foto?')) {
        $.ajax({
            url: deleteUrl,
            type: 'POST',
            data: formData,
            processData: false, // Impede que o jQuery transforme os dados em string
            contentType: false, // Impede que o jQuery defina o tipo de conteúdo, permitindo que o navegador defina como multipart/form-data
            success: function(response) {
                // Tratar a resposta
                if (response.status === 'ok') {
                    alert('Foto excluída com sucesso.');
                    
                    loadPhotos();
                } else {
                    alert('Erro ao excluir a foto: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Erro ao excluir a foto.');
            }
        });
    }
});