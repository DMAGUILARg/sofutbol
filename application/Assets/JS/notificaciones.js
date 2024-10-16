document.addEventListener('DOMContentLoaded', function () {
	const notificationBell = document.querySelector('.notification-bell');
	const notificationBadge = document.getElementById('notification-badge');
	const notificationList = document.querySelector('.notificacion-list');

	function fetchNotifications() {
		fetch('http://localhost/sofutbol/index.php/notificaciones/obtener_notificaciones')
			.then(response => {
				if (!response.ok) {
					throw new Error('La respuesta no es válida: ' + response.statusText);
				}
				return response.json();
			})
			.then(data => {
				notificationList.innerHTML = '';

				if (data.notificaciones && Array.isArray(data.notificaciones) && data.notificaciones.length > 0) {
					notificationBadge.textContent = data.notificaciones.length;
					data.notificaciones.forEach(function (notificacion) {
						const li = document.createElement('li');
						li.innerHTML = `<p>${notificacion.mensaje}</p><span>${new Date(notificacion.fecha_envio).toLocaleString()}</span>`;
						notificationList.appendChild(li);
					});
				} else {
					notificationBadge.textContent = 0;
					notificationList.innerHTML = '<p>No tienes notificaciones.</p>';
				}
			})
			.catch(error => {
				console.error('Error al obtener las notificaciones:', error);
			});
	}

	fetchNotifications();
	setInterval(fetchNotifications, 20000);
});
