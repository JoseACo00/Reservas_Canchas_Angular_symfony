import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';
import { UsuarioService } from 'src/app/services/User/usuario.service';

@Component({
  selector: 'app-registro-usuario',
  templateUrl: './registro-usuario.component.html',
  styleUrls: ['./registro-usuario.component.css']
})
export class RegistroUsuarioComponent {

  constructor(private router: Router, private fb: FormBuilder, private UsuarioService: UsuarioService,  private notifications: NotificationsService){

  }

    FormUser =this.fb.group({
        'name': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(45)]], // Permite solo letras y espacios
        'surname1': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(30)]],
        'surname2': ['', [Validators.required, Validators.pattern('^[a-zA-Z ]*$'), Validators.minLength(3), Validators.maxLength(30)]],
        'email': ['', [Validators.required, Validators.email,  Validators.pattern('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$')]], // Verifica el formato de correo electrónico
        'password': ['', [Validators.required, Validators.minLength(6), Validators.maxLength(50)]],
        'age': ['', [Validators.required, Validators.min(16), Validators.max(65)]], // Permite solo números
        'phone': ['', [Validators.required, Validators.minLength(9), Validators.maxLength(12), Validators.pattern('[0-9]*')]] // Permite solo números
      });

      procesar() {
        console.log(this.FormUser.value);
      }

      //ALERTAS
      onSuccess(message: string) {
        this.notifications.success('Correcto caballer@', message, {
          position: ['bottom', 'right'],
          animate: 'fade',
          showProgressBar: true,
          timeOut: 2000
        });
      }
      onError(message: string) {
        this.notifications.error('Hubo un problema', message, {
          position: ["top", "right"], // Configuración de posición
          animate: 'fade',
          showProgressBar: true,
          timeOut: 4000
        });
      }

      public CrearUsaurio() {
        this.UsuarioService.registrarUsuario(this.FormUser.value)
          .subscribe(
            (response) => {
              console.log('Formulario Enviado:', response);
              this.onSuccess('Usuario creado')
              setTimeout(()=>{this.router.navigate(['/Login'])}, 3000);
              // Puedes agregar aquí lógica adicional después de enviar el formulario

            },
            (err : any) => {
              this.onError('No se puede registrar')
              console.error('Error al crear el usuario:', err);
              // Puedes manejar el error aquí, por ejemplo, mostrando un mensaje al usuario
            }
          );
      }
}


