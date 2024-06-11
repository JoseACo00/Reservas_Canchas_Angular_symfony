import { UsuarioService } from 'src/app/services/User/usuario.service';
import { ActivatedRoute, Route, Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { LoginService } from 'src/app/services/Loggin/login.service';

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
    private loginService: LoginService
  ) {}

  formReservaCancha = this.fb.group({
    fecha_reserva: ['', [Validators.required]],
    hora_reserva: ['', [Validators.required]],
    hora_fin: ['', [Validators.required]],
    arbitro_opcion: ['', [Validators.required]],
    metodo_pago: ['', [Validators.required]]
  });

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
  }

  procesar() {
    if (this.formReservaCancha.valid) {
      const formData = this.formReservaCancha.value;
      this.usuarioService.reservarCancha(this.usuarioId, this.canchaId, formData).subscribe(
        res => {
          console.log('Reserva creada:', res);
          this.router.navigate(['/Canchas']);
        },
        error => {
          console.error('Error al crear la reserva:', error);
        }
      );
    } else {
      console.error('Formulario no válido');
    }
  }
}
