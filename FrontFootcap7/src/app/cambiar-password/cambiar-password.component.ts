import { EmailRequestService } from './../services/requestEmail/email-request.service';
import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';
import { ChangepasswordService } from '../services/ChangePassword/changepassword.service';

@Component({
  selector: 'app-cambiar-password',
  templateUrl: './cambiar-password.component.html',
  styleUrls: ['./cambiar-password.component.css']
})
export class CambiarPasswordComponent {

  constructor(private fb: FormBuilder, private EmailRequestService:EmailRequestService, private router: Router, private notifications: NotificationsService ){

  }

    /**
   * Formulario para solicitar el restablecimiento de contraseña.
   */

  formResetPassword = this.fb.group({
    'email': ['', [Validators.required, Validators.email,  Validators.pattern('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$')]], // Verifica el formato de correo electrónico
  });

  progresar(){
      console.log(this.formResetPassword.value);
  }

//MENSAJES DE ERROR y Y DE CORRECTO  //ALERTAS

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
   * Formulario para solicitar el restablecimiento de contraseña.
   */

//--------------------------------------------

  //ENVIAR LOS EMAILL 01
   RequestEmail() {

    this.EmailRequestService.request_Email(this.formResetPassword.value)
    .subscribe(
      (response) => {
        this.onSuccess('El email de recuperación fue enviado')
        console.log('El email de recuperación fue enviado al email:', response);
        // Puedes agregar aquí lógica adicional después de enviar el formulario
      },
      (err : any) => {
        this.onError('Error al enviar el email');
        console.error('Error al enviar el email:', err);
        // Puedes manejar el error aquí, por ejemplo, mostrando un mensaje al usuario
      }
    );

  }

  // MANERA CORRECTA 02
  RequestEmail1() {
    this.EmailRequestService.request_Email(this.formResetPassword.value)
      .subscribe(
        (response) => {
          this.onSuccess('El email de recuperación fue enviado correctamente');
          // Puedes agregar aquí lógica adicional después de enviar el formulario
        },
        (error: any) => {
          // this.onError('Error al enviar el email');
         this.onError(error.error.error);

        }
      );
  }


}
