import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';
import { LoginService } from 'src/app/services/Loggin/login.service';
import { UsuarioService } from 'src/app/services/User/usuario.service';

@Component({
  selector: 'app-edit-reserva',
  templateUrl: './edit-reserva.component.html',
  styleUrls: ['./edit-reserva.component.css']
})
export class EditReservaComponent implements OnInit{

  usuarioId!: number;
  reservaId!: number;
  canchaId!: number;

  formEditReserva = this.fb.group({
    'fecha_reserva': ['', [Validators.required]],
    'hora_reserva': ['', [Validators.required]],
    'hora_fin': ['', [Validators.required]],
    'arbitro_opcion': ['', [Validators.required]],
    'metodo_pago': ['', [Validators.required]]
  });

  constructor(
    private route: ActivatedRoute,
    private fb: FormBuilder,
    private usuarioService: UsuarioService,
    private loginService: LoginService,
    private router: Router,
    private notifications: NotificationsService
  ) { }


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

  ngOnInit(): void {
    const userId = this.loginService.getUserId();
    if (userId === null) {
      console.error('No se pudo obtener el ID del usuario');
      this.router.navigate(['/Inicio']);
      return;
    }

    this.usuarioId = userId;
    this.reservaId = +this.route.snapshot.paramMap.get('reserva_id')!;
    this.canchaId = +this.route.snapshot.paramMap.get('cancha_id')!;

    this.cargarReserva();
  }

  cargarReserva(): void {
    // Cargar los datos de la reserva para pre-rellenar el formulario
    this.usuarioService.obtenerReservasUsuario(this.usuarioId).subscribe(
      (reservas) => {
        const reserva = reservas.find((r: any) => r.id === this.reservaId);
        if (reserva) {
          this.formEditReserva.patchValue({
            fecha_reserva: reserva.fecha_reserva,
            hora_reserva: reserva.hora_reserva,
            hora_fin: reserva.hora_fin,
            arbitro_opcion: reserva.arbitro_opcion,
            metodo_pago: reserva.metodo_pago
          });
        }
      },
      (error) => {
        console.error('Error al cargar los datos de la reserva:', error);
      }
    );
  }

  procesar(): void {
    if (this.formEditReserva.valid) {
      const data = {
        fecha_reserva: this.formEditReserva.get('fecha_reserva')?.value,
        hora_reserva: this.formEditReserva.get('hora_reserva')?.value,
        hora_fin: this.formEditReserva.get('hora_fin')?.value,
        arbitro_opcion: this.formEditReserva.get('arbitro_opcion')?.value,
        metodo_pago: this.formEditReserva.get('metodo_pago')?.value
      };

      this.usuarioService.editarReserva(this.reservaId, this.canchaId, this.usuarioId, data).subscribe(
        res => {
          this.onSuccess('La reserva fue actualizadad')
          console.log('Reserva actualizada:', res);
          setTimeout(()=>{this.router.navigate(['/Usuario/reservas'])}, 3000);
        },
        error => {
          this.onError('Error al actulizar la reserva');
          console.error('Error al actualizar la reserva:', error);
        }
      );
    }
  }
}
