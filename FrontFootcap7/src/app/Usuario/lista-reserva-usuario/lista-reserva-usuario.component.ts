import { Router } from '@angular/router';
import { Component } from '@angular/core';
import { LoginService } from 'src/app/services/Loggin/login.service';
import { UsuarioService } from 'src/app/services/User/usuario.service';
import * as bootstrap from 'bootstrap';
import { NotificationsService } from 'angular2-notifications';
@Component({
  selector: 'app-lista-reserva-usuario',
  templateUrl: './lista-reserva-usuario.component.html',
  styleUrls: ['./lista-reserva-usuario.component.css']
})
export class ListaReservaUsuarioComponent {

  reservas: any[] = [];
  usuarioId: number | null = null;
  reservaIdToCancel: number | null = null;
  canchaIdToCancel: number | null = null;

  constructor(private usuarioService: UsuarioService, private loginService: LoginService, private router: Router,     private notifications: NotificationsService) { }

  ngOnInit(): void {
    this.usuarioId = this.loginService.getUserId(); // Obtener el ID del usuario del JWT
    if (this.usuarioId) {
      this.cargarReservas(this.usuarioId);
    }
  }


  //MENSJAES DE ERROR
  onError(message: string) {
    this.notifications.error('Error', message, {
      position: ["top", "center"], // Configuración de posición
      animate: 'fromTop',
      showProgressBar: true,
      timeOut: 4000
    });
  }

   onSuccess(message: string) {
    this.notifications.success('SUCCESS', message, {
      position: ['top', 'middle'],
      animate: 'fromTop',
      showProgressBar: true,
      timeOut: 2000
    });
  }

  cargarReservas(usuarioId: number): void {
    this.usuarioService.obtenerReservasUsuario(usuarioId).subscribe(
      (data: any) => {
        this.reservas = data;
      },
      (error) => {
        console.error('Error al cargar las reservas:', error);
      }
    );
  }

  editarReserva(reservaId: number, canchaId: number): void {
    this.router.navigate(['/Usuario/reserva', reservaId, 'cancha', canchaId, 'editar']);
  }

  openCancelModal(reservaId: number, canchaId: number): void {
    this.reservaIdToCancel = reservaId;
    this.canchaIdToCancel = canchaId;
  }

  confirmCancel(): void {
    if (this.reservaIdToCancel !== null && this.canchaIdToCancel !== null && this.usuarioId !== null) {
      const data = {
        usuario_id: this.usuarioId,
        cancha_id: this.canchaIdToCancel
      };

      this.usuarioService.cancelarReserva(this.reservaIdToCancel, data).subscribe(
        res => {
          this.onSuccess('reserva cancelada')
          console.log('Reserva cancelada:', res);
          this.cargarReservas(this.usuarioId!); // Recargar la lista de reservas
          const cancelModal = document.getElementById('cancelModal');
          if (cancelModal) {
            const modalInstance = bootstrap.Modal.getInstance(cancelModal);
            if (modalInstance) {
              modalInstance.hide();
            }
          }
        },
        error => {
          this.onError('Reserva no se pudo cancelar')
          console.error('Error al cancelar la reserva:', error);
        }
      );
    }
  }
}

