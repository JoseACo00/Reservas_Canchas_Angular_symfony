import { Component } from '@angular/core';
import { AbstractControl, FormBuilder, ValidationErrors, ValidatorFn, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-edit-cancha',
  templateUrl: './edit-cancha.component.html',
  styleUrls: ['./edit-cancha.component.css']
})
export class EditCanchaComponent {

  constructor(private fb: FormBuilder, private Route: Router){

  }


  formEditCanchas = this.fb.group({
    'nombre': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(5), Validators.maxLength(120)]], // Permite letras, números y espacios
    'localidad': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(3), Validators.maxLength(30)]], // Permite letras, números y espacios
    'direccion': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(5), Validators.maxLength(255)]], // Permite letras, números y espacios
    'precio': ['', [Validators.required, Validators.min(25), Validators.max(120)]],
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

      procesar() {
        console.log(this.formEditCanchas.value);
      }


}
