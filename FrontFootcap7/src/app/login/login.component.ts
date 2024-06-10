import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, Validators } from '@angular/forms';
import { LoginService } from '../services/Loggin/login.service';
import jwt_decode from 'jwt-decode';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {


  constructor(private router: Router, private fb: FormBuilder, private LoginService:LoginService){

  }

  formLogin =this.fb.group({
    'email': ['', [Validators.required, Validators.email,  Validators.pattern('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$')]], // Verifica el formato de correo electrónico
    'password': ['', [Validators.required, Validators.minLength(6), Validators.maxLength(30)]],
    'remenberMe' : [ false ]
  })

  procesar(){
    console.log(this.formLogin.value);
  }


  // public onLogin021() {
  //   if (this.formLogin.valid) {
  //     const rememberMe = this.formLogin.get('rememberMe')?.value;
  //     this.LoginService.login(this.formLogin.value)
  //       .subscribe(
  //         (res: any) => {
  //           if (res.token) {
  //             const storage = rememberMe ? localStorage : localStorage;
  //             storage.setItem('TokenJWT', res.token);
  //             const decodedToken: any = jwt_decode(res.token);

  //             setTimeout(() => {
  //               // Redirige al usuario basado en su rol
  //               if (decodedToken.rolName === 'Admin') {
  //                 this.router.navigate(['/Canchas']);
  //               } else if (decodedToken.rolName === 'Usuario') {
  //                 this.router.navigate(['/user-dashboard']);
  //               } else if (decodedToken.rolName === 'Arbitro') {
  //                 this.router.navigate(['/arbitro-dashboard']);
  //               } else {
  //                 this.router.navigate(['/Inicio']);
  //               }
  //             }, 2000);
  //           }
  //         },
  //         (error) => {
  //           console.error('Error en el inicio de sesión:', error);
  //           // Manejar errores de autenticación
  //         }
  //       );
  //   } else {
  //     // Manejar formulario inválido
  //   }
  // }

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
              //CAMBIAR POR UN INSTANT LOS ALERTS
              //this.translate.instant(

              //SIEMPRE que sn

              setTimeout(() => {
                  this.router.navigate(['/Canchas']);
              })

              // this.onSuccess('Inicio de sesión exitoso');
              // setTimeout(()=>{this.router.navigate(['/Inicio'])}, 2000); // Redirige a la página principal después del inicio de sesión
            } else {

          }


          }

        );
    } else {

    }
  }

}



