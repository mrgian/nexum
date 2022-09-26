function editProfile() {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: $('#buttonEdit').attr('url'),
        type: 'POST',
        dataType: 'json',
        data: $("#formEdit").serialize(),
        statusCode: {
            200: function (response) {
                alert('Profilo modificato con successo!', 'success')
            },
            401: function (response) {
                alert('Non sei autorizzato ad eseguire questa operazione!', 'danger')
            }
        }
    });
}

const alertPlaceholder = document.getElementById('alertPlaceholder')

const alert = (message, type) => {
  const wrapper = document.createElement('div')
  wrapper.innerHTML = [
    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
    `   <div>${message}</div>`,
    '   <button type="button" class="btn-close" data-bs-dismiss="alert"></button>',
    '</div>'
  ].join('')

  alertPlaceholder.append(wrapper)
}

