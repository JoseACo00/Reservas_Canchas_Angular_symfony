import { NgModule, Component } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegistroUsuarioComponent } from './CrearCuentas/registro-usuario/registro-usuario.component';

const routes: Routes = [
  {path:'Login', component: LoginComponent},
  {path: 'registro-Usuario', component: RegistroUsuarioComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
