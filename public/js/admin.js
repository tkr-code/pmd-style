$(document).ready(function () {
    //SUPPRIMER UEN IMAGE DE PRODUIT DE L'APPLICATION
    $(document).on('click', '.btn-application-image-delete', function (e) {
        e.preventDefault()
        let href = $(this).attr('href')
        let token = $(this).data('token')
        let div = $(this).closest('div')
        Swal.fire({
            title: 'Etes vous sûr?',
            text: "Voulez vous supprimr cettre image ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Fermer',
            confirmButtonText: 'Oui, je confirme!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: href,
                    method: 'DELETE',
                    type: 'json',
                    data: {
                        _token: token
                    },
                    beforeSend: function () {
                        $('.js-loader-text').text("Suppression de l'image en cour ...")
                        $('.js-loader').css('display', 'flex')
                    },
                    success: function (data) {
                        $('.js-loader').css('display', 'none')
                        console.log(data);
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Supression réussie !',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            div.remove()
                        } else {
                            alert('Une erreur est servenue')
                        }
                    },
                    error: function () {
                        $('.js-loader').css('display', 'none')
                        alert('Une erreur est servenue')
                    }
                })
            }
        })
    })
    $(document).on('click', '#btn-logout', function (e) {
        e.preventDefault()
        Swal.fire({
            title: 'Etes vous sûr?',
            text: "Vous êtes sur le point de vous déconnecter !  ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Fermer',
            confirmButtonText: 'Oui, je confirme!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Déconnection réussie !',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location.href = "/logout"
                })
            }
        })
    })
})