import { AdminService } from './../../services/Admin/admin.service';
import { Component } from '@angular/core';
import { AbstractControl, FormBuilder, ValidationErrors, ValidatorFn, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';

@Component({
  selector: 'app-post-cancha',
  templateUrl: './post-cancha.component.html',
  styleUrls: ['./post-cancha.component.css']
})
export class PostCanchaComponent {


  constructor(private router: Router,  private fb: FormBuilder, private AdminService: AdminService,   private notifications: NotificationsService){
  }

   /**
   * Formulario reactivo para agregar una nueva cancha.
   */
  formAddCancha = this.fb.group({
    'nombre': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(5), Validators.maxLength(120)]], // Permite letras, números y espacios
    'localidad': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(3), Validators.maxLength(30)]], // Permite letras, números y espacios
    'direccion': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ ,./]*$'), Validators.minLength(5), Validators.maxLength(255)]], // Permite letras, números y espacios
    'precio': ['', [Validators.required, Validators.min(20), Validators.max(120)]],
    'imagen': ['', [Validators.required, this.imageExtensionValidator()]], // Asegúrate de usar this. aquí
      'disponibilidad': ['', [Validators.required]]
    });

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
   * Método para crear una nueva cancha.
   * Valida el formulario y envía los datos al servidor.
   */

  crearCancha(){
    if (this.formAddCancha.valid) {
      console.log('Enviando datos al servidor:', this.formAddCancha.value);
      this.AdminService.addCancha(this.formAddCancha.value)
        .subscribe(
          (response) => {
            this.onSuccess('La cancha fue creada')
            console.log('Cancha creada:', response);
            setTimeout(()=>{this.router.navigate(['/Canchas'])}, 3000);

            // Puedes agregar aquí lógica adicional después de enviar el formulario
          },
          (error) => {
            this.onError('Error al crear la cancha')
            console.error('Error al crear la Cancha:', error);
            // Puedes manejar el error aquí, por ejemplo, mostrando un mensaje al usuario
          }
        );
    } else {
      this.onError('Formulario no es válido')
      console.error('Formulario no válido');
      // Puedes manejar el caso en que el formulario no sea válido aquí
    }
  }


}
