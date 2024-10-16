$(document).ready(function () {
	$('#editarResultadoForm').submit(function (event) {
		event.preventDefault();

		$.ajax({
			url: 'http://localhost/sofutbol/index.php/partidos/editar_resultado',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				$('.toast').remove(); // Eliminar toasts anteriores
				const toast = `
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" style="position: absolute; top: 20px; right: 20px;">
                        <div class="toast-header">
                            <strong class="me-auto">Notificación</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            ${response.success ? 'Resultado actualizado correctamente.' : 'Error al actualizar el resultado.'}
                        </div>
                    </div>
                `;

				$('body').append(toast);

				const toastElement = $('.toast:last');
				const bsToast = new bootstrap.Toast(toastElement);
				bsToast.show();

				$('#editModal').modal('hide');
				if (response.success) {
					location.reload();
				}
			},
			error: function (xhr, status, error) {
				$('.toast').remove(); // Eliminar toasts anteriores
				const toast = `
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" style="position: absolute; top: 20px; right: 20px;">
                        <div class="toast-header">
                            <strong class="me-auto">Error</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Error en la solicitud: ${error}
                        </div>
                    </div>
                `;
				$('body').append(toast);
				const toastElement = $('.toast:last');
				const bsToast = new bootstrap.Toast(toastElement);
				bsToast.show();
			}
		});
	});

	// Manejo del evento para llenar el modal de edición
	$('#editModal').on('show.bs.modal', function (event) {
		const button = $(event.relatedTarget);
		const partidoId = button.data('partido-id');
		const local = button.data('local');
		const visitante = button.data('visitante');
		const golesLocal = button.data('goles-local');
		const golesVisitante = button.data('goles-visitante');
		const estado = button.data('estado');

		$('#partidoId').val(partidoId);
		$('#equipoLocal').val(local);
		$('#equipoVisitante').val(visitante);
		$('#golesLocal').val(golesLocal);
		$('#golesVisitante').val(golesVisitante);
		$('#estado').val(estado);
	});
});
