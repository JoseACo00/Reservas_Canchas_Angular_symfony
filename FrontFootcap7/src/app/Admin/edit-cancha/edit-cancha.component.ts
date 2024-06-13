import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormBuilder, ValidationErrors, ValidatorFn, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';
import { AdminService } from 'src/app/services/Admin/admin.service';

@Component({
  selector: 'app-edit-cancha',
  templateUrl: './edit-cancha.component.html',
  styleUrls: ['./edit-cancha.component.css']
})
export class EditCanchaComponent implements OnInit {

  canchaId!: number;
  canchaNombre: string = '';

  /**
   * Formulario reactivo para editar una cancha.
   */
  formEditCanchas = this.fb.group({
    'nombre': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(5), Validators.maxLength(120)]],
    'localidad': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(3), Validators.maxLength(30)]],
    'direccion': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ ,./]*$'), Validators.minLength(5), Validators.maxLength(255)]], // Permite letras, números y espacios
    'precio': ['', [Validators.required, Validators.min(25), Validators.max(120)]],
    'imagen': ['', [Validators.required, this.imageExtensionValidator()]],
    'disponibilidad': ['', [Validators.required]]
  });

  constructor(
    private route: ActivatedRoute,
    private fb: FormBuilder,
    private adminService: AdminService,
    private router: Router,
    private notifications: NotificationsService
  ) {}

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
   * Validador personalizado para verificar la extensión de la URL de la imagen.
   * @returns ValidatorFn Función de validación.
   */
  // Función validadora de URL de imagen
  imageExtensionValidator(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const url = control.value;
      if (!url) {
        return null;  // retorna null si no hay valor, es decir, no hay error
      }
      const pattern = /\.(jpg|jpeg|png|gif)$/i;
      const isValid = pattern.test(url);
      return isValid ? null : { invalidExtension: true };  // retorna un error si no es válido
    };
  }


  /**
   * Método de inicialización del componente.
   * Obtiene los datos de la cancha a editar.
   */
  ngOnInit() {
    this.route.params.subscribe(params => {
      this.canchaId = +params['id']; // Convierte el parámetro a número
      if (this.canchaId) {
        this.adminService.obtenerCancha(this.canchaId).subscribe(
          (data) => {
            this.formEditCanchas.patchValue({
              nombre: data.nombre,
              localidad: data.localidad,
              direccion: data.direccion,
              precio: data.precio,
              imagen: data.imagen,
              disponibilidad: data.disponibilidad
            });
            this.canchaNombre = data.nombre;
          },
          (error) => {
            console.error('Error al cargar los datos de la cancha:', error);
          }
        );
      }
    });
  }

   /**
   * Método para procesar la edición de la cancha.
   * Valida el formulario y envía los datos actualizados al servidor.
   */
  procesar() {
    if (this.formEditCanchas.valid) {
      if (this.canchaId) {
        this.adminService.editarCancha(this.canchaId, this.formEditCanchas.value).subscribe(
          res => {
            this.onSuccess('Se actalizó la cancha correctamente');
            setTimeout(()=>{this.router.navigate(['/Canchas'])}, 3000);
          },
          error => {
            this.onError('Error al editar la cancha')
            console.error('Error al editar la cancha:', error);
          }
        );
      }
    }
  }
}
