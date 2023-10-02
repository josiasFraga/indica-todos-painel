$(document).ready(function() {
    $('#states').change(function() {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + stateId + '/municipios',
                type: 'GET',
                success: function(data) {
                    var citySelect = $('#cities');
                    citySelect.empty();
                    citySelect.append('<option value="">Selecione uma cidade</option>');
                    data.forEach(function(city) {
                        citySelect.append('<option value="' + city.id + '">' + city.nome + '</option>');
                    });
                }
            });
        } else {
            $('#cities').empty();
            $('#cities').append('<option value="">Selecione uma cidade</option>');
        }
    });
});