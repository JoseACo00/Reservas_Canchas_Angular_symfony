import { AdminService } from './../../services/Admin/admin.service';
import { Component } from '@angular/core';
import { AbstractControl, FormBuilder, Validators } from '@angular/forms';
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
    'nombre': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9 ]*$'), Validators.minLength(5), Validators.maxLength(120)]], // Permite letras, números y espacios
    'localidad': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9 ]*$'), Validators.minLength(3), Validators.maxLength(30)]], // Permite letras, números y espacios
    'direccion': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9 ]*$'), Validators.minLength(5), Validators.maxLength(255)]], // Permite letras, números y espacios
    'precio': ['', [Validators.required, Validators.min(20), Validators.max(120)]],
    'imagen': ['', [Validators.required, this.imageValidator]],
    'disponibilidad': ['', [Validators.required]]

  });

  imageValidator(control: AbstractControl): { [key: string]: any } | null {
    const file = control.value;
    if (file) {
      const maxSize = 3000 * 1024; // 3000 KB
      const allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'heic', 'heif'];

      const size = file.size;
      const type = file.type;

      if (size > maxSize) {
        return { 'imageSize': { value: control.value } };
      }

      // Obtener la extensión del archivo
      const extension = file.name.split('.').pop()?.toLowerCase();

      if (!extension || !allowedExtensions.includes(extension)) {
        return { 'imageType': { value: control.value } };
      }
    }
    return null;
  }


  crearCancha(){
    if (this.formAddCancha.valid) {
      console.log('Enviando datos al servidor:', this.formAddCancha.value);
      this.AdminService.addCancha(this.formAddCancha.value)
        .subscribe(
          (response) => {
            console.log('Cancha creada:', response);
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
