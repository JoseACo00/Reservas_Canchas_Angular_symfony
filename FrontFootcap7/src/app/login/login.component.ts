import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, Validators } from '@angular/forms';
import { LoginService } from '../services/Loggin/login.service';
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


  //SE GUARDA EN LOCALSTORAGE o SESION STORAGE DEPENDE DEL CHECK BOX QUE TIENE UN  formControlName="remenberMe"
  //FALLO TE LO GUARDA EN LOS 2 PUEDE SER UTIL O NO EL TIEMPO LO DIRÁ
  public onLogin02() {
    if (this.formLogin.valid) {
      this.LoginService.Login(this.formLogin.value)
        .subscribe(
          (res: any) => {
            if(this.formLogin.get('remenberMe')?.value) {
              localStorage.setItem('TokenJWT', res.token);
            }
            if (res.token) {
              sessionStorage.setItem('TokenJWT', res.token);
              alert('Inicio de sesión exitoso');
              this.router.navigate(['/Inicio']); // Redirige a la página principal después del inicio de sesión
            } else {
              alert('Credenciales inválidas');
            }
          },
          (error: { message: string; }) => {
            alert('Error en la solicitud: ' + error.message);
          }
        );
    } else {
      alert('Por favor, completa todos los campos del formulario.');
    }
  }
}
