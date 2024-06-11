import { Router } from '@angular/router';
import { Component } from '@angular/core';
import { LoginService } from 'src/app/services/Loggin/login.service';
import { UsuarioService } from 'src/app/services/User/usuario.service';
import * as bootstrap from 'bootstrap';
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

  constructor(private usuarioService: UsuarioService, private loginService: LoginService, private router: Router) { }

  ngOnInit(): void {
    this.usuarioId = this.loginService.getUserId(); // Obtener el ID del usuario del JWT
    if (this.usuarioId) {
      this.cargarReservas(this.usuarioId);
    }
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
          console.error('Error al cancelar la reserva:', error);
        }
      );
    }
  }
}

