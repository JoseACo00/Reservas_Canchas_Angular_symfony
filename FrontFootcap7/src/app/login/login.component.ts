import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, Validators } from '@angular/forms';
import { LoginService } from '../services/Loggin/login.service';
import jwt_decode from 'jwt-decode';
import { NotificationsService } from 'angular2-notifications';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {


  constructor(private router: Router, private fb: FormBuilder, private LoginService:LoginService,private notifications: NotificationsService){

  }

  formLogin =this.fb.group({
    'email': ['', [Validators.required, Validators.email,  Validators.pattern('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$')]], // Verifica el formato de correo electrónico
    'password': ['', [Validators.required, Validators.minLength(6), Validators.maxLength(30)]],
    'remenberMe' : [ false ]
  })

  procesar(){
    console.log(this.formLogin.value);
  }

  //ALERTAS
  onSuccess(message: string) {
    this.notifications.success('Correcto con padre', message, {
      position: ['top', 'middle'],
      animate: 'fromRight',
      showProgressBar: true,
      timeOut: 2000
    });
  }
  onError(message: string) {
    this.notifications.error('Error con padre', message, {
      position: ["top", "center"], // Configuración de posición
      animate: 'fromTop',
      showProgressBar: true,
      timeOut: 4000
    });
  }

 /**
   * Método para gestionar el inicio de sesión.
   * Verifica si el formulario es válido, luego envía los datos al servicio de inicio de sesión.
   * Si el inicio de sesión es exitoso, almacena el token JWT y redirige al usuario a la página principal.
   */
 public onLogin021() {
  if (this.formLogin.valid) {
    const rememberMe = this.formLogin.get('remenberMe')?.value;
    this.LoginService.login(this.formLogin.value)
      .subscribe(
        (res: any) => {
          if (res.token) {
            if (rememberMe) {
              localStorage.setItem('TokenJWT', res.token);
            } else {
              sessionStorage.setItem('TokenJWT', res.token);
            }
            this.onSuccess('Inicio de sesión exitoso');
            setTimeout(() => {
              this.router.navigate(['/Inicio']);
            }, 2000); // Redirige a la página principal después de 2 segundos
          } else {
            this.onError('Error: No se recibió un token. Por favor, inténtelo nuevamente.');
          }
        },
        (error: any) => {
          this.onError(`Error de inicio de sesión: ${error.message}`);
        }
      );
  } else {
    this.onError('Formulario no válido. Por favor, completa todos los campos requeridos correctamente.');
  }
}

}

