import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Route, Router } from '@angular/router';

@Component({
  selector: 'app-registro-admin',
  templateUrl: './registro-admin.component.html',
  styleUrls: ['./registro-admin.component.css']
})
export class RegistroAdminComponent {


  constructor(private router:Router, private fb: FormBuilder){

  }

  formAdmin = this.fb.group({
    'name': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(45)]], // Permite solo letras y espacios
    'surname1': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(30)]],
    'surname2': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(30)]],
    'email': ['', [Validators.required, Validators.email,  Validators.pattern('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$')]], // Verifica el formato de correo electrónico
    'password': ['', [Validators.required, Validators.minLength(6), Validators.maxLength(50)]],
    'birthdate': ['', [Validators.required, Validators.pattern('^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/([0-9]{4})$')]],
    'phone': ['', [Validators.required, Validators.minLength(9), Validators.maxLength(12), Validators.pattern('[0-9]*')]] // Permite solo números,
  });


  // Ejemplo de uso  
  procesar() {
    console.log(this.formAdmin.value);
  }

  
}
