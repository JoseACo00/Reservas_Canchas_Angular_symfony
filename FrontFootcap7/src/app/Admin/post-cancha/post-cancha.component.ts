import { AdminService } from './../../services/Admin/admin.service';
import { Component } from '@angular/core';
import { AbstractControl, FormBuilder, ValidationErrors, ValidatorFn, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-post-cancha',
  templateUrl: './post-cancha.component.html',
  styleUrls: ['./post-cancha.component.css']
})
export class PostCanchaComponent {


  constructor(private router: Router,  private fb: FormBuilder, private AdminService: AdminService){
  }

  formAddCancha = this.fb.group({
    'nombre': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(5), Validators.maxLength(120)]], // Permite letras, números y espacios
    'localidad': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(3), Validators.maxLength(30)]], // Permite letras, números y espacios
    'direccion': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ ,./]*$'), Validators.minLength(5), Validators.maxLength(255)]], // Permite letras, números y espacios
    'precio': ['', [Validators.required, Validators.min(20), Validators.max(120)]],
    'imagen': ['', [Validators.required, this.imageExtensionValidator()]], // Asegúrate de usar this. aquí
      'disponibilidad': ['', [Validators.required]]
    });
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


  crearCancha(){
    if (this.formAddCancha.valid) {
      console.log('Enviando datos al servidor:', this.formAddCancha.value);
      this.AdminService.addCancha(this.formAddCancha.value)
        .subscribe(
          (response) => {
            console.log('Cancha creada:', response);
            this.router.navigate(['/Canchas']);
            // Puedes agregar aquí lógica adicional después de enviar el formulario
          },
          (error) => {
            console.error('Error al crear la Cancha:', error);
            // Puedes manejar el error aquí, por ejemplo, mostrando un mensaje al usuario
          }
        );
    } else {
      console.error('Formulario no válido');
      // Puedes manejar el caso en que el formulario no sea válido aquí
    }
  }


}
