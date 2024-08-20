import { UsuarioService } from 'src/app/services/User/usuario.service';
import { ActivatedRoute, Route, Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { LoginService } from 'src/app/services/Loggin/login.service';
import { NotificationsService } from 'angular2-notifications';

@Component({
  selector: 'app-reserva-cancha',
  templateUrl: './reserva-cancha.component.html',
  styleUrls: ['./reserva-cancha.component.css']
})
export class ReservaCanchaComponent implements OnInit{

  canchaId!: number;
  usuarioId!: number;
  isUser: boolean = false;

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private usuarioService: UsuarioService,
    private loginService: LoginService,
    private notifications: NotificationsService
  ) {}

  /**
   * Formulario para realizar la reserva de una cancha.
   */
  formReservaCancha = this.fb.group({
    fecha_reserva: ['', [Validators.required]],
    hora_reserva: ['', [Validators.required]],
    hora_fin: ['', [Validators.required]],
    arbitro_opcion: ['', [Validators.required]],
    metodo_pago: ['', [Validators.required]]
  });

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


  /**
   * Método de inicialización del componente.
   * Verifica el rol del usuario y obtiene el ID de la cancha de los parámetros de la ruta.
   */

  ngOnInit() {
    const userId = this.loginService.getUserId();
    if (userId === null) {
      // Manejar el caso en el que el userId no está disponible
      console.error('No se pudo obtener el ID del usuario');
      this.router.navigate(['/Inicio']);
      return;
    }


    this.usuarioId = userId;
    this.isUser = this.loginService.getUserRole() === 'Usuario';

    if (!this.isUser) {
      // Redirigir o mostrar mensaje si el rol no es "Usuario"
      alert('Solo los usuarios pueden realizar reservas.');
      this.router.navigate(['/Inicio']);
      return;
    }

    this.route.params.subscribe(params => {
      this.canchaId = +params['id'];
    });

     // Inicializar arbitro_opcion con string 'true' o 'false'
     this.formReservaCancha.get('arbitro_opcion')?.setValue('false');

     // Convertir los valores de arbitro_opcion entre string y booleano
     this.formReservaCancha.get('arbitro_opcion')?.valueChanges.subscribe(value => {
       if (typeof value === 'boolean') {
         this.formReservaCancha.get('arbitro_opcion')?.setValue(value ? 'true' : 'false', { emitEvent: false });
       }
     });
  }

   /**
   * Procesa el formulario de reserva de cancha.
   * Envía los datos al servicio de usuario para crear una reserva.
   */

  procesar() {
    if (this.formReservaCancha.valid) {
      const formData = this.formReservaCancha.value;
      this.usuarioService.reservarCancha(this.usuarioId, this.canchaId, formData).subscribe(
        res => {
          this.onSuccess('Reserva creada');
          setTimeout(()=>{this.router.navigate(['/Canchas'])}, 3000);
          console.log('Reserva creada:', res);

        },
        error => {
          this.onError('Error al crear la reserva');
          console.error('Error al crear la reserva:', error);
        }
      );
    } else {
      this.onError('Formulario no valido');
      console.error('Formulario no válido');
    }
  }
}
