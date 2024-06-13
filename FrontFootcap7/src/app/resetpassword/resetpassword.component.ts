import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';
import { ChangepasswordService } from '../services/ChangePassword/changepassword.service';
@Component({
  selector: 'app-resetpassword',
  templateUrl: './resetpassword.component.html',
  styleUrls: ['./resetpassword.component.css']
})
export class ResetpasswordComponent {


  constructor(private fb: FormBuilder, private router: Router, private notifications: NotificationsService, private ChangePasswordService:ChangepasswordService, private activatedRoute: ActivatedRoute){

  }

  FormChangePassword= this.fb.group({
    'password': ['', [Validators.required, Validators.minLength(6), Validators.maxLength(50)]],
    'confirmPassword': ['', [Validators.required, Validators.minLength(6), Validators.maxLength(50)]],
  },

);


  //MENSJASES
  onError(message: string) {
    this.notifications.error('Error con Caballer@', message, {
      position: ["top", "center"], // Configuración de posición
      animate: 'fromTop',
      showProgressBar: true,
      timeOut: 4000
    });
  }

  onSucces(message: string) {
    this.notifications.success('Bien Caballer@', message, {
      position: ["top", "center"], // Configuración de posición
      animate: 'fromTop',
      showProgressBar: true,
      timeOut: 4000
    });
  }



  public validPassword() {
    const password = this.FormChangePassword.get('password')?.value;
    const confirmPassword = this.FormChangePassword.get('confirmPassword')?.value;

    // Verificar si las contraseñas son iguales
    if (password === confirmPassword) {
      this.onSucces('Contraeña actuliazada'); // Las contraseñas coinciden, no hay error
    } else {
      this.onError('Las contraseñas no coinciden'); // Las contraseñas no coinciden, mostrar mensaje de error
    }
  }

  // Método para enviar la solicitud de cambio de contraseña al backend Symfony
  public changePassword() {
    const password = this.FormChangePassword.get('password')?.value;
    const confirmPassword = this.FormChangePassword.get('confirmPassword')?.value;

    // Verificar si las contraseñas son iguales
    if (password === confirmPassword) {
      // Llamar al servicio para cambiar la contraseña
      const token = this.activatedRoute.snapshot.queryParams['token'];


      const newPasswordData = { password: password };

      this.ChangePasswordService.changePassword(token, newPasswordData).subscribe(
        (response) => {
          // Contraseña cambiada con éxito
          this.onSucces('Contraseña cambiada correctamente');
          // Redirigir a alguna página de éxito o a la página de inicio de sesión
          this.router.navigate(['/login']);
        },
        (error) => {
          // Ocurrió un error al cambiar la contraseña
          this.onError('Error al cambiar la contraseña. Por favor, inténtalo de nuevo más tarde.');
        }
      );
    } else {
      // Las contraseñas no coinciden
      this.onError('Las contraseñas no coinciden');
    }
  }


  public changePassword01() {
    // Validar las contraseñas
    this.validPassword();

    // Verificar si hubo errores de validación previos
    if (this.FormChangePassword.invalid) {
      return;
    }

    // Se obtienee  el token de la URL  utilizando el   ActivatedRoute
    const token = this.activatedRoute.snapshot.queryParams['token'];

    // Obtener la nueva contraseña del formulario
    const password = this.FormChangePassword.get('password')?.value;

    // Llamar al servicio para cambiar la contraseña
    const newPasswordData = { password: password };

    this.ChangePasswordService.changePassword(token, newPasswordData).subscribe(
      (response) => {
        // Contraseña cambiada con éxito
        this.onSucces('Contraseña cambiada correctamente');
        // Redirigir a alguna página de éxito o a la página de inicio de sesión
        this.router.navigate(['/loggin']);
      },
      (error:any) => {
        this.onError(error.error.error);
        // Ocurrió un error al cambiar la contraseña
        this.onError('Error al cambiar la contraseña. Por favor, inténtalo de nuevo más tarde.');
      }
    );
  }

}
