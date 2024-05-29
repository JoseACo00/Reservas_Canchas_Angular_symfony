import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-registro-usuario',
  templateUrl: './registro-usuario.component.html',
  styleUrls: ['./registro-usuario.component.css']
})
export class RegistroUsuarioComponent {

  constructor(private router: Router, private fb: FormBuilder){

  }

    FormUser =this.fb.group({
        'name': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(30)]], // Permite solo letras y espacios
        'surname1': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(30)]],
        'surname2': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(30)]],
        'email': ['', [Validators.required, Validators.email,  Validators.pattern('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$')]], // Verifica el formato de correo electrónico
        'password': ['', [Validators.required, Validators.minLength(6), Validators.maxLength(30)]],
        'age': ['', [Validators.required, Validators.minLength(1), Validators.maxLength(2), Validators.pattern('[0-9]*')]], // Permite solo números
        'phone': ['', [Validators.required, Validators.minLength(6), Validators.maxLength(12), Validators.pattern('[0-9]*')]] // Permite solo números
      });

      procesar() {
        console.log(this.FormUser.value);

      }
}


