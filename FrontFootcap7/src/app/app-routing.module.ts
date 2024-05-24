import { NgModule, Component } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegistroUsuarioComponent } from './CrearCuentas/registro-usuario/registro-usuario.component';
import { RegistroAdminComponent } from './CrearCuentas/registro-admin/registro-admin.component';
import { RegistroArbitroComponent } from './CrearCuentas/registro-arbitro/registro-arbitro.component';

const routes: Routes = [
  {path:'Login', component: LoginComponent},
  {path: 'registro-Usuario', component: RegistroUsuarioComponent},
  {path: 'registro-Admin', component: RegistroAdminComponent},
  {path: 'registro-Arbitro', component: RegistroArbitroComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
