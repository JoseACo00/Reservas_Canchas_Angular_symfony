import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';
import { ArbitroService } from 'src/app/services/Arbitro/arbitro.service';
import { LoginService } from 'src/app/services/Loggin/login.service';

@Component({
  selector: 'app-editar-disponibilidad',
  templateUrl: './editar-disponibilidad.component.html',
  styleUrls: ['./editar-disponibilidad.component.css']
})
export class EditarDisponibilidadComponent {
  arbitroId!: number;
  arbitroName: string = '';
  arbitroSurname: string = '';
  formEditArbitro: FormGroup;

  constructor(
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private arbitroService: ArbitroService,
    private router: Router,
    private loginService: LoginService,
    private notifications: NotificationsService
  ) {
    this.formEditArbitro = this.fb.group({
      experiences: ['', [Validators.required]],
      disponibilidad: ['', [Validators.required]]
    });
  }

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
   * Carga los datos del árbitro al iniciar el componente.
   */
  ngOnInit(): void {
    this.arbitroId = this.loginService.getUserId()!;
    this.cargarDatosArbitro();
  }

  /**
   * Carga los datos del árbitro desde el servicio.
   */
  cargarDatosArbitro(): void {
    this.arbitroService.obtenerArbitro(this.arbitroId).subscribe(
      data => {
        this.arbitroName = data.name;
        this.arbitroSurname = data.surname1;
        this.formEditArbitro.patchValue({
          name: data.name,
          surname1: data.surname1,
          experiences: data.experiences,
          disponibilidad: data.disponibilidad
        });
      },
      error => {
        console.error('Error al cargar los datos del árbitro:', error);
        this.onError('Error al cargar las canchas');
      }
    );
  }


   /**
   * Procesa el formulario de edición del árbitro.
   * Si el formulario es válido, envía los datos actualizados al servicio.
   */
  procesar(): void {
    if (this.formEditArbitro.valid) {
      const formData = this.formEditArbitro.value;
      this.arbitroService.editarArbitro(this.arbitroId, formData).subscribe(
        res => {
          console.log('Datos actualizados:', res);
          this.onSuccess('Datos actulizados');
            setTimeout(()=>{this.router.navigate(['/Arbitro/partidos'])});
        },
        error => {
          this.onError('Error al actualizar los datos del árbitro:');
        }
      );
    } else {
      this.onError('Formulario no valido');
      console.error('Formulario no válido');
    }
  }
}
